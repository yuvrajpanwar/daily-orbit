<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;


class CategoryController extends Controller
{
    public function addCategory()
    {
        return view('admin.categories.add-Category');
    }

    public function fetchAllCategories(Request $request)
    {
        $searchArr = $request->get('search');
        $searchValue = $searchArr['value'];
        $query = Category::select('categories.*')
            //for searching 
            ->where(function ($innerQuery) use ($searchValue) {
                $innerQuery->where('categories.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('categories.created_at', 'like', '%' . $searchValue . '%');
            });
        $query->where('is_deleted',0)->orderBy('categories.id', 'DESC');
        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return ucFirst($row->name);
            })
            ->addColumn('Date', function ($row) {
               return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->make(true);
    }

    
    public function storeCategory(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
        ]);

        // Create a new Category
        $Category = Category::create($validatedData);

        // Return a JSON response or redirect as needed

        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit-category', compact('category'));
    }


    public function updateCategory(Request $request, Category $Category)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:20',
            'is_visible' =>'in:0,1',
            'is_deleted' => 'in:0,1'
        ]);

        // Update the Category
        $Category->update($validatedData);

        // Redirect back with a success message
        return redirect(route('admin.categories'))->with('success', 'Category updated successfully');
    }

    public function deleteCategory(Category $category)
    {
        // Check if the Category exists
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }

        // Delete the Category
        $category->is_deleted = 1;
        $category->save();

        // Return a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully',
        ]);
    }

    public function updateCategoryVisibility(Request $request, Category $category)
    {

        $category->is_active = $request->input('is_active', 0);
        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category visibility updated successfully',
        ]);
    }
}
