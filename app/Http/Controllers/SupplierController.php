<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;


class SupplierController extends Controller
{
    public function addSupplier(Request $request) {
        if($request->isMethod('post')){
            $validatedData = app(SupplierRequest::class)->validated();
            

            $customer = new Supplier();
            $customer->fill($validatedData);
            if($customer->to_be_paid == null){
                $customer->to_be_paid = 0;
            }
            if($customer->total_given == null){
                $customer->total_given = 0;
            }

            if($customer->save()){
                notify()->success('Supplier info saved successfully', 'Added') ;
                return redirect()->route('allCustomer');
            }else{
                notify()->error('Supplier info cannot be saved', 'Failed') ;
            }

        }else{
            return view('supplier.addSupplier');
        }
        
    }

}
