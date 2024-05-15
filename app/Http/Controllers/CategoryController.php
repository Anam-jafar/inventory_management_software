<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function allCategory(Request $request)
    {
        $query = $request->input('query');
    
        // Initialize $perPage with a default value of 5 if not present in the request
        $perPage = $request->input('perPage', 5);
    
        // Initialize the query builder without any search filter
        $categoriesQuery = Category::where('deleted', '!=', config('deleted'))
                                    ->latest();
    
        // Apply search filter if query is present
        if ($query) {
            $categoriesQuery->where('name', 'like', '%' . $query . '%');
        }
    
        // Retrieve categories with pagination
        $categories = $categoriesQuery->paginate($perPage);
    
        return view('category.allCategory', compact('categories', 'query', 'perPage'));
    }
    
    
    

    public function addCategory(Request $request) {
        if($request->isMethod('post')){
            $validatedData = $request->validate([
                'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
                'status' => 'required'
            ]);

            $category = new Category();
            $category->fill($validatedData);
            $category->save();

            if($category->save()){
                notify()->success('Category added successfully', 'Added') ;
                return redirect()->route('allCategory');
            }

        }else{
            return view('category.addCategory');
        }
    }

    public function editCategory($id= null, Request $request){
        $category = Category::find($id);

        if($request->isMethod('post')){
            $validatedData = $request->validate([
                'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
                'status' => 'required'
            ]);
            
            $category->fill($validatedData);
            $category->save();

            if($category->save()){
                notify()->success('Category updated successfully', 'Updated') ;
                return redirect()->route('allCategory');
            }

        }else{
            return view('category.editCategory', compact('category'));
        }
    }

public function deleteCategory($id = null){
    $category = Category::find($id);
    $category->deleted = config('deleted');
    if($category->save()){
        notify()->warning('Category deleted successfully', 'Deleted') ;
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

}

}
