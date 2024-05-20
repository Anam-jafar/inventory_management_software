<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;


class SupplierController extends Controller
{
    public function allSupplier(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 5);

        $customersQuery = Supplier::where('deleted', '!=', config('deleted'))->latest();

        if($query){
            $customersQuery->where('name', 'like', '%'.$query.'%');
        }

        $customers = $customersQuery->paginate($perPage);
        return view('supplier.allSupplier', compact('customers', 'query', 'perPage'));
    }

    public function addSupplier(Request $request) {
        if($request->isMethod('post')){
            $validatedData = app(SupplierRequest::class)->validated();
            

            $supplier = new Supplier();
            $supplier->fill($validatedData);
            if($supplier->to_be_paid == null){
                $supplier->to_be_paid = 0;
            }
            if($supplier->total_given == null){
                $supplier->total_given = 0;
            }

            if($supplier->save()){
                notify()->success('Supplier info saved successfully', 'Added') ;
                return redirect()->route('allCustomer');
            }else{
                notify()->error('Supplier info cannot be saved', 'Failed') ;
            }

        }else{
            return view('supplier.addSupplier');
        }
        
    }

    public function editSupplier(Request $request, $id = null) {
        $supplier = Supplier::find($id);

        if($request->isMethod('post')){
            $validatedData = app(SupplierRequest::class)->validated();
            
            $supplier->fill($validatedData);

            if($supplier->save()){
                notify()->success('Supplier info updated successfully', 'Updated') ;
                return redirect()->route('allSupplier');
            }else{
                notify()->error('Supplier info cannot be updated', 'Failed') ;
            }

        }else{
            return view('supplier.editSupplier', compact('supplier'));
        }
        
    }

    public function viewSupplier($id = null){
        $customer = Supplier::find($id);

        return view('supplier.viewSupplier', compact('customer'));
    }

    public function deleteSupplier($id = null){
        $customer = Supplier::find($id);
        $customer->deleted = config('deleted');
        if($customer->save()){
            notify()->warning('Supplier info deleted successfully', 'Deleted') ;
            return redirect()->back();
        }
    }

}
