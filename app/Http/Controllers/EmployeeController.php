<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\SalaryHistory;

class EmployeeController extends Controller
{
    public function allEmployee(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 5);

        $employeesQuery = Employee::where('deleted', '!=', config('deleted'))->latest();

        if($query){
            $employeesQuery->where('name', 'like', '%'.$query.'%');
        }

        $employees = $employeesQuery->paginate($perPage);
        return view('employee.allEmployee', compact('employees', 'query', 'perPage'));
    }

    public function viewEmployee($id = null){
        $employee = Employee::find($id);

        return view('employee.viewEmployee', compact('employee'));
    }
    
    
    

    public function addEmployee(Request $request) {
        if($request->isMethod('post')){
            $validatedData = $request->validate([
                'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
                'salary' => 'required|min:1',
                'joined_at' =>'required',
                'contact' =>'required',
            ]);

            $product = new Employee();
            $product->fill($validatedData);

            if($request->image){
                $image = $request->file('image');
                $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $image_name);
                $image_url = 'uploads/'.$image_name;
                $product->image = $image_url;
            }
            if($request->nid){
                $product->nid = $request->nid;
            }
            if($request->address){
                $product->address = $request->address;
            }
            if($product->save()){
                notify()->success('Employee info saved successfully', 'Added') ;
                return redirect()->route('allEmployee');
            }else{
                notify()->error('Employee info cannot be saved', 'Failed') ;
            }

        }else{
            return view('employee.addEmployee');
        }
        
    }

    public function editEmployee($id= null, Request $request){
        $employee = Employee::find($id);

        if($request->isMethod('post')){
            $validatedData = $request->validate([
                'name' => 'required',
                'salary' => 'required|min:1',
                'joined_at' =>'required|min:1',
                'contact' =>'required',
            ]);

            $employee->fill($validatedData);

            if($request->image){
                $image = $request->file('image');
                $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $image_name);
                $image_url = 'uploads/'.$image_name;
                $employee->image = $image_url;
            }
            if($request->nid){
                $employee->nid = $request->nid;
            }
            if($request->address){
                $employee->address = $request->address;
            }
            if($employee->save()){
                notify()->success('Emplyee info updated successfully', 'Updated') ;
                return redirect()->route('allEmployee');
            }else{
                notify()->error('Emplyee info cannot be updated', 'Failed') ;
            }

        }else{
            return view('employee.editEmployee', compact('employee'));
        }
    }

    public function deleteEmployee($id = null){
        $employee = Employee::find($id);
        $employee->deleted = config('deleted');
        if($employee->save()){
            notify()->warning('Emplyee info deleted successfully', 'Deleted') ;
            return redirect()->back();
        }
    }

    public function paySalary(  Request $request){
        $employees = Employee::where('deleted', '!=', config('deleted'))->latest()->get();
    
        if($request->isMethod('post')){
            $request->validate([
                'amount' => 'required|numeric|min:1',
                'year' => 'required',
                'month' =>'required',
                'employee_id' =>'required',
            ]);
    
            $salary = Salary::where('employee_id', $request->employee_id)
                                ->where('month', $request->month)
                                ->where('year', $request->year)
                                ->first();
    
            if($salary){
                if($salary->status == config('salary.partially_paid')){
                    $salary->paid_amount += $request->amount;
                }else{
                    notify()->warning('Entered Months salay is fully paid', 'Can not proceed to pay');
                    return redirect()->back();
                }
                

            }else{
                $salary = new Salary();
                $salary->fill($request->all());
                $salary->paid_amount = $request->amount;
            }
            if($salary->paid_amount == Employee::find($salary->employee_id)->value('salary')){
                $salary->status = 1;
            }else{
                $salary->status = 2;
            }
            $salary->save();

            $salary_history = new SalaryHistory();
            $salary_history->salary_id = $salary->id;
            $salary_history->amount = $request->amount;
            $salary_history->save();

            notify()->success('Salary paid successfully', 'Paid') ;
    
            return redirect()->back();
        }else{
            return view('employee.paySalary', compact('employees'));
        }
    }
    
}
