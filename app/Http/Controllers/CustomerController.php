<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function allCustomer(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 5);

        $employeesQuery = Customer::where('deleted', '!=', config('deleted'))->latest();

        if($query){
            $employeesQuery->where('name', 'like', '%'.$query.'%');
        }

        $employees = $employeesQuery->paginate($perPage);
        return view('customer.allCustomer', compact('employees', 'query', 'perPage'));
    }

    public function viewCustomer($id = null){
        $employee = Customer::find($id);

        return view('customer.viewCustomer', compact('employee'));
    }
    
    
    

    public function addCustomer(Request $request) {
        if($request->isMethod('post')){
            $request->validate([
                'name' => [
                    'required',
                    'regex:/^[A-Za-z\s]+$/'
                ],
                'contact' => [
                    'required',
                    'regex:/^(\+?[0-9]{13}|[0-9]{11})$/'
                ],
                'due' => [
                    'min:0'
                ],
                'total_invoiced_amount' => [
                    'min:0'
                ],
            ], [
                'name.required' => 'The name field is required.',
                'name.regex' => 'The name must only contain letters and spaces.',
                
                'contact.required' => 'The contact field is required.',
                'contact.regex' => 'The contact must either start with a plus and contain 13 digits, or contain exactly 11 digits.',

                'due.min' => 'The due amount cannot be negative.',
                
                'total_invoiced_amount.min' => 'The total invoiced amount cannot be negative.'
            ]);
            

            $customer = new Customer();
            $customer->fill($request->all());
            if($customer->due == null){
                $customer->due = 0;
            }
            if($customer->total_invoiced_amount == null){
                $customer->total_invoiced_amount = 0;
            }

            if($customer->save()){
                notify()->success('Customer info saved successfully', 'Added') ;
                return redirect()->route('allEmployee');
            }else{
                notify()->error('Customer info cannot be saved', 'Failed') ;
            }

        }else{
            return view('customer.addCustomer');
        }
        
    }

    public function editCustomer($id= null, Request $request){
        $customer = Customer::find($id);

        if($request->isMethod('post')){
            $request->validate([
                'name' => [
                    'required',
                    'regex:/^[A-Za-z\s]+$/'
                ],
                'contact' => [
                    'required',
                    'regex:/^(\+?[0-9]{13}|[0-9]{11})$/'
                ],
                'due' => [
                    'min:0'
                ],
                'total_invoiced_amount' => [
                    'min:0'
                ],
            ], [
                'name.required' => 'The name field is required.',
                'name.regex' => 'The name must only contain letters and spaces.',
                
                'contact.required' => 'The contact field is required.',
                'contact.regex' => 'The contact must either start with a plus and contain 13 digits, or contain exactly 11 digits.',

                'due.min' => 'The due amount cannot be negative.',
                
                'total_invoiced_amount.min' => 'The total invoiced amount cannot be negative.'
            ]);
            

            $customer->fill($request->all());
            if($customer->due == null){
                $customer->due = 0;
            }
            if($customer->total_invoiced_amount == null){
                $customer->total_invoiced_amount = 0;
            }

            if($customer->save()){
                notify()->success('Customer info updated successfully', 'Updated') ;
                return redirect()->route('allEmployee');
            }else{
                notify()->error('Customer info cannot be updated', 'Failed') ;
            }

        }else{
            return view('customer.editCustomer', compact('customer'));
        }
    }

    public function deleteEmployee($id = null){
        $customer = Customer::find($id);
        $customer->deleted = config('deleted');
        if($customer->save()){
            notify()->warning('Customer info deleted successfully', 'Deleted') ;
            return redirect()->back();
        }
    }
}
