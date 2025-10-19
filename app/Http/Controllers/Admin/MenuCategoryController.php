<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;  // Your model for the Menu Categories
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MenuCategoryController extends Controller
{
    // Fetch categories for the datatable
    public function index()
    {
        $categories = MenuCategory::all();
        return view('admin.menu_category.index', compact('categories'));
    }
    

    public function getMenuCategoryData(Request $request)
    {
        $categories = MenuCategory::query();

        return datatables()->of($categories)
            ->addIndexColumn()
            ->addColumn('action', function($category) {
                $editUrl = route('admin.menu_categories.edit', $category->id);
                $deleteUrl = route('admin.menu_categories.destroy', $category->id);
                return '<a href="'.$editUrl.'" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(\''.$deleteUrl.'\')"><i class="bi bi-trash"></i> Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function create()
    {
        return view('admin.menu_category.create');
    }

    // Store a new category
    public function store(Request $request)
    {
        // Custom validation logic
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255|unique:menu_categories,name',
            'description' => 'nullable|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return JSON with validation errors
            return response()->json(['status' => 0, 'message' => $validator->errors()->all()]);
        }

        try {
            // Sanitize the input data
            $category_name = filter_var(trim($request->input('category_name')), FILTER_SANITIZE_STRING); // Removes extra spaces and sanitizes for special characters
            $description = filter_var(trim($request->input('description')), FILTER_SANITIZE_STRING); // Removes extra spaces and sanitizes for special characters

            // If you want to remove HTML tags, you can use:
            $category_name = strip_tags($category_name);
            $description = strip_tags($description);

            // Create a new category and assign sanitized data
            $category = new MenuCategory();
            $category->name = $category_name;
            $category->description = $description;
            $category->save();

            return response()->json(['status' => 1, 'message' => 'Category added successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Failed to add category']);
        }
    }
    
    public function edit($id)
    {
        // Fetch the category by ID
        $category = MenuCategory::findOrFail($id);

        // Return a view with the category data
        return view('admin.menu_category.edit', compact('category'));
    }


    // Update category
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255|unique:menu_categories,name,' . $id, // Unique validation for updating
            'description' => 'nullable|string',
        ]);

        try {
            $category = MenuCategory::findOrFail($id);

            // Sanitize input data
            $category_name = filter_var(trim($request->input('category_name')), FILTER_SANITIZE_STRING);
            $description = filter_var(trim($request->input('description')), FILTER_SANITIZE_STRING);

            // Update category fields
            $category->name = $category_name;
            $category->description = $description;
            $category->save();

            return response()->json(['status' => 1, 'message' => 'Category updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Failed to update category']);
        }
    }


    // Delete category
    public function destroy($id)
    {
        $category = MenuCategory::findOrFail($id);
        $category->delete(); // Soft delete the category
        
        return response()->json([
            'status' => 1,
            'message' => 'Category deleted successfully.',
        ]);
    }

}
