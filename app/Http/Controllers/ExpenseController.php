<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function allExpense(Request $request) {
        $perPage = $request->input('perPage', 10);
        $type = $request->input('type', 'all');
        
        $expenses = Expense::when($type !== 'all', function ($query) use ($type) {
            $query->where('type', $type);
        })->latest()->paginate($perPage);
    
        $expenseTypes = config('expense_type');
    
        return view('expense.allExpense', compact('expenses', 'expenseTypes', 'type'));
    }

    public function addExpense(Request $request){
        $expenseTypes = config('expense_type');
        if($request->isMethod('post')){
            app(ExpenseRequest::class)->validated();

            $expense = new Expense();
            $expense->type = $request->type;
            $expense->amount = $request->amount;
            if(isset($request->description)){
                $expense->description = $request->description;
            }

            if($expense->save()){
                notify()->success('Expense stored', 'Success') ;
                return redirect()->route('allExpense');
            }
        }else{
            return view('expense.addExpense', compact('expenseTypes'));
        }
    }

    public function editExpense(Request $request, $id = null){
        $expenseTypes = config('expense_type');
        $expense = Expense::find($id);
        if($request->isMethod('post')){
            app(ExpenseRequest::class)->validated();
            $expense->type = $request->type;
            $expense->amount = $request->amount;
            if(isset($request->description)){
                $expense->description = $request->description;
            }

            if($expense->save()){
                notify()->success('Expense info saved', 'Success') ;
                return redirect()->route('allExpense');
            }
        }else{
            return view('expense.addExpense', compact('expenseTypes', 'expense'));
        }
    }

    public function viewExpense($id = null){
        $expense = Expense::find($id);

        return view('expense.viewExpense', compact('expense'));
    }

    public function deleteExpense($id = null){
        Expense::find($id)->delete();
        notify()->warning('Expense info deleted.', 'Deleted') ;
        return redirect()->back();
    }
}
