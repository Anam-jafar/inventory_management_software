<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function allProduct(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 5);

        $productsQuery = Product::with('category')->where('deleted', '!=', config('deleted'))->latest();

        if($query){
            $productsQuery->where('name', 'like', '%'.$query.'%');
        }

        $products = $productsQuery->paginate($perPage);
        return view('product.allProduct', compact('products', 'query', 'perPage'));
    }
    
    
    

    public function addProduct(Request $request) {
        $categories = Category::where('deleted', '!=', config('deleted'))
        ->latest()->get();

        if($request->isMethod('post')){
            $validatedData = $request->validate([
                'name' => ['required'],
                'status' => 'required',
                'price' => 'required|min:1',
                'quantity' =>'required|min:1',
                'restock_limit' =>'required|min:1',
                'description' =>'max:191',
                'category_id' =>'required'
            ]);

            $product = new Product();
            $product->fill($validatedData);
            $product->slug = strtolower(str_replace(" ","-", $validatedData['name']));

            if($request->image){
                $image = $request->file('image');
                $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $image_name);
                $image_url = 'uploads/'.$image_name;
                $product->image = $image_url;
            }
            if($product->save()){
                notify()->success('Product added successfully', 'Added') ;
                return redirect()->route('allProduct');
            }else{
                notify()->error('Product cannot be saved', 'Failed') ;
            }

        }else{
            return view('product.addProduct', compact('categories'));
        }
        
    }

    public function editProduct($id= null, Request $request){
        $product = Product::find($id);
        $categories = Category::where('deleted', '!=', config('deleted'))
        ->latest()->get();

        if($request->isMethod('post')){
            $validatedData = $request->validate([
                'name' => ['required'],
                'status' => 'required',
                'price' => 'required|min:1',
                'quantity' =>'required|min:1',
                'restock_limit' =>'required|min:1',
                'description' =>'max:191',
                'category_id' =>'required'
            ]);

            $product->fill($validatedData);
            $product->slug = strtolower(str_replace(" ","-", $validatedData['name']));

            if($request->image){
                $image = $request->file('image');
                $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $image_name);
                $image_url = 'uploads/'.$image_name;
                $product->image = $image_url;
            }
            if($product->save()){
                notify()->success('Product updated successfully', 'Updated') ;
                return redirect()->route('allProduct');
            }else{
                notify()->error('Product cannot be updated', 'Failed') ;
            }

        }else{
            return view('product.editProduct', compact('categories', 'product'));
        }
    }

    public function deleteProduct($id = null){
        $product = Product::find($id);
        $product->deleted = config('deleted');
        if($product->save()){
            notify()->warning('Product deleted successfully', 'Deleted') ;
            return redirect()->back();
        }
    }

}
