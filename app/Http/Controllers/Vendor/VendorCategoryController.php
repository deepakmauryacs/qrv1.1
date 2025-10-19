<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\VendorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorCategoryController extends Controller
{
    /**
     * Display the vendor categories index page.
     */
    public function index()
    {
        return view('vendor.categories.index');
    }

    /**
     * Show the form for creating a new vendor category.
     */
    public function create()
    {
        return view('vendor.categories.create');
    }

    /**
     * Provide data for the categories DataTable.
     */
    public function data(Request $request)
    {
        $vendorId = auth()->id();

        $categories = VendorCategory::where('vendor_id', $vendorId)
            ->orderBy('display_order')
            ->orderBy('name');

        return datatables()->of($categories)
            ->addIndexColumn()
            ->editColumn('is_active', fn (VendorCategory $category) => $category->is_active ? 'Active' : 'Inactive')
            ->addColumn('action', function (VendorCategory $category) {
                $editUrl = route('vendor.categories.edit', $category->id);
                $editButton = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">'
                    . '<i class="bi bi-pencil-square"></i> Edit</a>';

                $deleteUrl = route('vendor.categories.destroy', $category->id);
                $deleteButton = '<button type="button" class="btn btn-sm btn-danger btn-delete"'
                    . ' data-url="' . $deleteUrl . '"><i class="bi bi-trash"></i> Delete</button>';

                return $editButton . ' ' . $deleteButton;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Provide suggestions for category names from the shared menu categories table.
     */
    public function suggestions(Request $request)
    {
        $query = trim((string) $request->get('q', ''));

        if ($query === '') {
            return response()->json([
                'status' => 1,
                'data' => [],
            ]);
        }

        $suggestions = MenuCategory::query()
            ->select('name')
            ->where('name', 'like', '%' . str_replace(['%', '_'], ['\\%', '\\_'], $query) . '%')
            ->orderBy('name')
            ->limit(10)
            ->pluck('name')
            ->unique()
            ->values();

        return response()->json([
            'status' => 1,
            'data' => $suggestions,
        ]);
    }

    /**
     * Show the form for editing the specified vendor category.
     */
    public function edit(VendorCategory $category)
    {
        $this->guardCategory($category);

        return view('vendor.categories.edit', compact('category'));
    }

    /**
     * Store a newly created vendor category.
     */
    public function store(Request $request)
    {
        $vendorId = auth()->id();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:vendor_categories,name,NULL,id,vendor_id,' . $vendorId,
            'description' => 'nullable|string|max:1000',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->all(),
            ], 422);
        }

        $name = strip_tags(filter_var(trim($request->input('name')), FILTER_SANITIZE_STRING));
        $description = $request->filled('description')
            ? strip_tags(filter_var(trim($request->input('description')), FILTER_SANITIZE_STRING))
            : null;

        $displayOrder = filter_var(
            $request->input('display_order'),
            FILTER_VALIDATE_INT,
            ['options' => ['default' => 0, 'min_range' => 0]]
        );

        $isActive = $request->boolean('is_active');

        $category = VendorCategory::create([
            'vendor_id' => $vendorId,
            'name' => $name,
            'description' => $description,
            'display_order' => $displayOrder,
            'is_active' => $isActive,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Category created successfully.',
            'data' => $category,
        ]);
    }

    /**
     * Update the specified vendor category.
     */
    public function update(Request $request, VendorCategory $category)
    {
        $this->guardCategory($category);

        $vendorId = auth()->id();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:vendor_categories,name,' . $category->id . ',id,vendor_id,' . $vendorId,
            'description' => 'nullable|string|max:1000',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->all(),
            ], 422);
        }

        $name = strip_tags(filter_var(trim($request->input('name')), FILTER_SANITIZE_STRING));
        $description = $request->filled('description')
            ? strip_tags(filter_var(trim($request->input('description')), FILTER_SANITIZE_STRING))
            : null;

        $displayOrder = filter_var(
            $request->input('display_order'),
            FILTER_VALIDATE_INT,
            ['options' => ['default' => $category->display_order, 'min_range' => 0]]
        );

        $isActive = $request->boolean('is_active');

        $category->update([
            'name' => $name,
            'description' => $description,
            'display_order' => $displayOrder,
            'is_active' => $isActive,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Category updated successfully.',
        ]);
    }

    /**
     * Remove the specified vendor category from storage.
     */
    public function destroy(VendorCategory $category)
    {
        $this->guardCategory($category);

        $category->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Category deleted successfully.',
        ]);
    }

    /**
     * Ensure the category belongs to the authenticated vendor.
     */
    private function guardCategory(VendorCategory $category): void
    {
        if ($category->vendor_id !== auth()->id()) {
            abort(403, 'You are not allowed to perform this action.');
        }
    }
}
