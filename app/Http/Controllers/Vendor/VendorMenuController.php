<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Models\Menu;
use App\Models\VendorMenu;
use App\Models\VendorCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Don't forget to import Carbon if it's not already imported
use Illuminate\Validation\Rule;

class VendorMenuController extends Controller {

    public function index() {
        return view('vendor.menus.index');
    }

    public function getMenusData(Request $request) {
        $vendorId = auth()->id(); // Get the logged-in vendor's ID

        $menus = VendorMenu::with(['menuCategory', 'vendorCategory'])
            ->where('vendor_id', $vendorId) // Filter by authenticated vendor
            ->get();

        return datatables()->of($menus)
            ->addIndexColumn()
            ->addColumn('category', function ($row) {
                if ($row->vendorCategory) {
                    return $row->vendorCategory->name;
                }

                return $row->menuCategory ? $row->menuCategory->name : 'No category';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('vendor.menus.edit', $row->id);
                $deleteUrl = route('vendor.menus.destroy', $row->id);
                return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\''.$deleteUrl.'\')"><i class="bi bi-trash"></i> Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function updateStatus(Request $request) {
        $menu = VendorMenu::where('vendor_id', auth()->id())->find($request->menu_id);

        if (!$menu) {
            return response()->json(['message' => 'Menu item not found'], 404);
        }

        $menu->status = $request->status;
        $menu->save();

        return response()->json(['message' => 'Menu status updated successfully']);
    }


    public function create() {
        $vendorId = auth()->id();

        $categories = VendorCategory::query()
            ->where('vendor_id', $vendorId)
            ->where('is_active', true)
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();

        $hasCategories = $categories->isNotEmpty();

        return view('vendor.menus.create', compact('categories', 'hasCategories'));
    }

    public function store(Request $request) {
        // Custom validation logic
        $vendorId = auth()->id();

        $validator = Validator::make($request->all(), [
                    'category_id' => [
                        'required',
                        Rule::exists('vendor_categories', 'id')->where(function ($query) use ($vendorId) {
                            return $query->where('vendor_id', $vendorId)
                                ->where('is_active', true);
                        }),
                    ],
                    'name' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
                    'price_half' => 'nullable|string|max:255',
                    'price_full' => 'nullable|string|max:255',
                    'menu_type' => 'nullable|string|in:veg,non-veg',
                    'status' => 'required|in:1,2',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }


        $category_id = filter_var($request->input('category_id'), FILTER_SANITIZE_NUMBER_INT);
        $language = filter_var(trim($request->input('language')), FILTER_SANITIZE_STRING);
        $name = filter_var(trim($request->input('name')), FILTER_SANITIZE_STRING);
        $description = filter_var(trim($request->input('description')), FILTER_SANITIZE_STRING);
        $price_half = filter_var(trim($request->input('price_half')), FILTER_SANITIZE_STRING);
        $price_full = filter_var(trim($request->input('price_full')), FILTER_SANITIZE_STRING);
        $menu_type = filter_var(trim($request->input('menu_type')), FILTER_SANITIZE_STRING);
        $status = filter_var($request->input('status'), FILTER_SANITIZE_STRING);

        // Remove HTML tags
        $name = strip_tags($name);
        $description = strip_tags($description);
        $price_half = strip_tags($price_half);
        $price_full = strip_tags($price_full);
        $menu_type = strip_tags($menu_type);

        // Create a new Menu item and assign sanitized data
        $menu = new VendorMenu();
        $menu->vendor_id = auth()->id();
        $menu->menu_category_id = $category_id;
        $menu->name = $name;
        $menu->language = $language;
        $menu->description = $description;
        $menu->price_half = $price_half;
        $menu->price_full = $price_full;
        $menu->order = 0;
        $menu->menu_type = $menu_type;
        $menu->status = $status;

        // Handle image upload if exists
        // Handle image upload
        $imagePath = $request->image; // Keep existing image path

        if ($request->hasFile('image')) {
            // Get the current year
            $currentYear = Carbon::now()->year;

            // Create the target directory for the current year
            $directory = public_path('uploads/menu_images/' . $currentYear);

            // Ensure the directory exists
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true); // Create the directory if it doesn't exist
            }

            // Move the uploaded file to the desired directory
            $imagePath = $request->file('image')->move($directory, $request->file('image')->getClientOriginalName());

            // Store the relative path to the database
            $imagePath = 'uploads/menu_images/' . $currentYear . '/' . $request->file('image')->getClientOriginalName();
            $menu->image = $imagePath;
        }

        $menu->save();

        return response()->json(['status' => 1, 'message' => 'Menu item added successfully!']);
    }

    public function clone() {
        $categories = MenuCategory::all();
        return view('vendor.menus.clone', compact('categories'));
    }

    public function getMenusByCategory(Request $request)
    {
        $query = Menu::where('menu_category_id', $request->category_id);

        // Apply Type filter (Veg/Non-Veg) if selected
        if ($request->has('type') && !empty($request->type)) {
            $query->where('menu_type', $request->type);
        }

        // Apply Language filter if selected
        if ($request->has('language') && !empty($request->language)) {
            $query->where('language', $request->language);
        }

        $menus = $query->get();

        $vendorId = auth()->id(); // Get the logged-in vendor's ID
        $vendor_menus = VendorMenu::select('name')
            ->where('vendor_id', $vendorId) // Filter by authenticated vendor
            ->where('menu_category_id', $request->category_id) // Filter by authenticated vendor
            ->pluck('name')->toArray();

        return view('vendor.menus.menu_list', compact('menus', 'vendor_menus'))->render();
    }


    public function addMenuToVendor(Request $request)
    {
        $menu = Menu::find($request->menu_id);

        if (!$menu) {
            return response()->json(['success' => false, 'message' => 'Menu item not found.']);
        }

        // Check if the menu already exists for this vendor
        $existingMenu = VendorMenu::where('vendor_id', auth()->id())
            ->where('name', $menu->name)
            ->first();

        if ($existingMenu) {
            return response()->json(['success' => false, 'message' => 'Menu already added!']);
        }

        $vendorMenu = new VendorMenu();
        $vendorMenu->vendor_id = auth()->id();
        $vendorMenu->language = $menu->language;
        $vendorMenu->menu_category_id = $menu->menu_category_id;
        $vendorMenu->name = $menu->name;
        $vendorMenu->description = $menu->description;
        $vendorMenu->image = $menu->image;
        $vendorMenu->price_half = $menu->price_half;
        $vendorMenu->price_full = $menu->price_full;
        $vendorMenu->status = $menu->status;
        $vendorMenu->menu_type = $menu->menu_type;
        $vendorMenu->save();

        return response()->json(['success' => true, 'message' => 'Menu item added successfully!']);
    }


    public function edit($id) {
       
        $menu = VendorMenu::findOrFail($id);
        $categories = MenuCategory::all();
        return view('vendor.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                    'category_id' => 'required|exists:menu_categories,id',
                    'name' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
                    'price_half' => 'nullable|string|max:255',
                    'price_full' => 'nullable|string|max:255',
                    'order' => 'nullable|integer',
                    'menu_type' => 'nullable|string|in:veg,non-veg',
                    'status' => 'required|in:1,2',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }


        // Find the existing menu item by ID
        $menu = VendorMenu::findOrFail($id);

        // Sanitize input data
        $category_id = filter_var($request->input('category_id'), FILTER_SANITIZE_NUMBER_INT);
        $language = filter_var(trim($request->input('language')), FILTER_SANITIZE_STRING);
        $name = filter_var(trim($request->input('name')), FILTER_SANITIZE_STRING);
        $description = filter_var(trim($request->input('description')), FILTER_SANITIZE_STRING);
        $price_half = filter_var(trim($request->input('price_half')), FILTER_SANITIZE_STRING);
        $price_full = filter_var(trim($request->input('price_full')), FILTER_SANITIZE_STRING);
        $order = filter_var($request->input('order'), FILTER_SANITIZE_NUMBER_INT);
        $menu_type = filter_var(trim($request->input('menu_type')), FILTER_SANITIZE_STRING);
        $status = filter_var($request->input('status'), FILTER_SANITIZE_STRING);

        // Remove HTML tags
        $name = strip_tags($name);
        $description = strip_tags($description);
        $price_half = strip_tags($price_half);
        $price_full = strip_tags($price_full);
        $menu_type = strip_tags($menu_type);

        // Update the existing Menu item with sanitized data
        $menu->menu_category_id = $category_id;
        $menu->name = $name;
        $menu->language = $language;
        $menu->description = $description;
        $menu->price_half = $price_half;
        $menu->price_full = $price_full;
        $menu->order = $order;
        $menu->menu_type = $menu_type;
        $menu->status = $status;

        // Handle image upload
        $imagePath = $request->image; // Keep existing image path

        if ($request->hasFile('image')) {
            // Get the current year
            $currentYear = Carbon::now()->year;

            // Create the target directory for the current year
            $directory = public_path('uploads/menu_images/' . $currentYear);

            // Ensure the directory exists
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true); // Create the directory if it doesn't exist
            }

            // Move the uploaded file to the desired directory
            $imagePath = $request->file('image')->move($directory, $request->file('image')->getClientOriginalName());

            // Store the relative path to the database
            $imagePath = 'uploads/menu_images/' . $currentYear . '/' . $request->file('image')->getClientOriginalName();
            $menu->image = $imagePath;
        }


        $menu->save(); // Save the updated menu item

        return response()->json(['status' => 1, 'message' => 'Menu item updated successfully!']);
    }

    public function destroy($id)
    {
       
            // Find the menu item by its ID
            $menu = VendorMenu::findOrFail($id);

            // Delete the menu item
            $menu->delete();

            // Return a success response
            return response()->json([
                'status' => 1,
                'message' => 'Menu item deleted successfully!'
            ]);
     
    }


}
