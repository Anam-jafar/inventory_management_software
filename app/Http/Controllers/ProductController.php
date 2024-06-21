<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ExtraIncome;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
        $totalValue = Product::sum(DB::raw('price * quantity')); 


        $products = $productsQuery->paginate($perPage);
        return view('product.allProduct', compact('products', 'query', 'perPage', 'totalValue'));
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

    public function restockProduct(Request $request){
        $products = Product::where('deleted', '!=', config('deleted'))->latest()->get();
        
        if($request->isMethod('post')){
            $request->validate([
                'quantity' =>'required|numeric|min:1',
            ]);

            $product = Product::find($request->id);
            $product->quantity += $request->quantity;
            $product->save();

            notify()->success('Product restocked successfully', 'Success') ;
            return redirect()->back();

        }else{
            return view('product.restockProduct', compact('products'));
        }
    }

    public function addExtraIncome(Request $request){
        $incomeTypes = config('extra_income_type');
        if($request->isMethod('post')){
            $request->validate([
                'amount' => 'required|numeric|min:1'
            ]);

            $income = new ExtraIncome();
            $income->type = $request->type;
            $income->amount = $request->amount;
            if(isset($request->description)){
                $income->description = $request->description;
            }

            if($income->save()){
                notify()->success('Extra Income info saved', 'Success') ;
                return redirect()->route('allExtraIncome');
            }
        }else{
            return view('product.addExtraIncome', compact('incomeTypes'));
        }
    }

    public function editExtraIncome(Request $request, $id = null){
        $incomeTypes = config('extra_income_type');
        $income = ExtraIncome::find($id);
        if($request->isMethod('post')){
            $request->validate([
                'amount' => 'required|numeric|min:1'
            ]);

            $income->type = $request->type;
            $income->amount = $request->amount;
            if(isset($request->description)){
                $income->description = $request->description;
            }

            if($income->save()){
                notify()->success('Extra Income info saved', 'Success') ;
                return redirect()->route('allExtraIncome');
            }
        }else{
            return view('product.addExtraIncome', compact(['incomeTypes', 'income']));
        }
    }

    public function allExtraIncome(Request $request) {
        $perPage = $request->input('perPage', 10);
        $type = $request->input('type', 'all');
        
        $incomes = ExtraIncome::when($type !== 'all', function ($query) use ($type) {
            $query->where('type', $type);
        })->latest()->paginate($perPage);
    
        $incomeTypes = config('extra_income_type');
    
        return view('product.allExtraIncome', compact('incomes', 'incomeTypes', 'type'));
    }

    public function deleteExtraIncome($id = null){
        ExtraIncome::find($id)->delete();
        notify()->warning('Extra income info deleted.', 'Deleted') ;
        return redirect()->back();
    }

}
