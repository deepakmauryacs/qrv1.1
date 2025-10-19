<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Models\Menu;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Don't forget to import Carbon if it's not already imported

class MenuController extends Controller {

    public function index() {
        return view('admin.menus.index');
    }

    public function getMenusData(Request $request) {
        $menus = Menu::with('menuCategory')->get();

        return datatables()->of($menus)
                        ->addIndexColumn()
                        ->addColumn('category', function ($row) {
                            return $row->menuCategory ? $row->menuCategory->name : 'No category';
                        })
                        ->addColumn('action', function ($row) {
                            $editUrl = route('admin.menus.edit', $row->id);
                            $deleteUrl = route('admin.menus.destroy', $row->id);
                            return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\''.$deleteUrl.'\')"><i class="bi bi-trash"></i> Delete</button>';
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    public function create() {
        $categories = MenuCategory::all();
        return view('admin.menus.create', compact('categories'));
    }

    public function store(Request $request) {
        // Custom validation logic
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

        // Create a new Menu item and assign sanitized data
        $menu = new Menu();
        $menu->menu_category_id = $category_id;
        $menu->name = $name;
        $menu->language = $language;
        $menu->description = $description;
        $menu->price_half = $price_half;
        $menu->price_full = $price_full;
        $menu->order = $order;
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

    public function edit($id) {
       
        $menu = Menu::findOrFail($id);
        $categories = MenuCategory::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
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
        $menu = Menu::findOrFail($id);

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
            $menu = Menu::findOrFail($id);

            // Delete the menu item
            $menu->delete();

            // Return a success response
            return response()->json([
                'status' => 1,
                'message' => 'Menu item deleted successfully!'
            ]);
     
    }


}
