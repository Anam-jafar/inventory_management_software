<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExtraIncome;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboardViewData(Request $request) {
        $period = $request->get('period', '1_month');
        $currentDate = Carbon::now();
    
        switch ($period) {
            case '3_months':
                $startDate = $currentDate->subMonths(3);
                break;
            case '1_month':
            default:
                $startDate = $currentDate->subMonth();
                break;
        }
    
        // Fetch and process product data
        $productsQuery = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name as product_name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.id');
    
        // Fetch and process expense data
        $expensesQuery = DB::table('expenses')
            ->select('type', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('type');
    
        if ($startDate) {
            $productsQuery->where('order_items.updated_at', '>=', $startDate);
            $expensesQuery->where('expenses.updated_at', '>=', $startDate);
        }
    
        $products = $productsQuery->get();
        $expenses = $expensesQuery->get();
    
        $orders = Order::where('updated_at', '>=', $startDate)->sum('total_amount');
        $paid = Order::where('updated_at', '>=', $startDate)->sum('total_paid');
        $due = Order::where('updated_at', '>=', $startDate)->sum('due');
        $salaries = Salary::where('updated_at', '>=', $startDate)->sum('paid_amount');
        $expenseAmount = Expense::where('updated_at', '>=', $startDate)->sum('amount');
        $expenseAmount += $salaries;
        $extraIncome = ExtraIncome::where('updated_at', '>=', $startDate)->sum('amount');
    
        // Mapping expense types to their names
        $expenseTypes = config('expense_type');
        $mappedExpenses = $expenses->map(function($expense) use ($expenseTypes) {
            $typeName = array_search($expense->type, $expenseTypes);
            return [
                'type' => $typeName,
                'total_amount' => $expense->total_amount
            ];
        });

        $monthlySales = DB::table('orders')
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total_amount'),
            DB::raw('SUM(total_paid) as total_paid')
        )
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();
    
        return response()->json([
            'products' => $products,
            'expenses' => $mappedExpenses,
            'totalExpense' => $expenseAmount,
            'extraIncome' => $extraIncome,
            'orders' => $orders,
            'paid' => $paid,
            'due' => $due,
            'monthlySales' => $monthlySales
        ]);
    }

    public function dashboardView() {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    
        $products = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name as product_name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->whereBetween('order_items.updated_at', [$startDate, $endDate])
            ->groupBy('products.id')
            ->get();
    
        $expenses = DB::table('expenses')
            ->select('type', DB::raw('SUM(amount) as total_amount'))
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy('type')
            ->get();
    
        $orders = Order::whereBetween('updated_at', [$startDate, $endDate])->sum('total_amount');
        $paid = Order::whereBetween('updated_at', [$startDate, $endDate])->sum('total_paid');
        $due = Order::whereBetween('updated_at', [$startDate, $endDate])->sum('due');
        $salaries = Salary::whereBetween('updated_at', [$startDate, $endDate])->sum('paid_amount');
        $expenseAmount = Expense::whereBetween('updated_at', [$startDate, $endDate])->sum('amount');
        $expenseAmount += $salaries;
        $extraIncome = ExtraIncome::whereBetween('updated_at', [$startDate, $endDate])->sum('amount');
    
        // Mapping expense types to their names
        $expenseTypes = config('expense_type');
        $mappedExpenses = $expenses->map(function($expense) use ($expenseTypes) {
            $typeName = array_search($expense->type, $expenseTypes);
            return [
                'type' => $typeName,
                'total_amount' => $expense->total_amount
            ];
        });

        $customers = DB::table('orders')
        ->join('customers', 'orders.customer_id', '=', 'customers.id')
        ->select('customers.name as customer_name', DB::raw('COUNT(orders.id) as order_count'), DB::raw('SUM(orders.due) as total_due'))
        ->whereBetween('orders.updated_at', [$startDate, $endDate])
        ->groupBy('customers.id')
        ->orderByDesc('order_count')
        ->get();

        $products_ = Product::latest()->get();

        $monthlySales = DB::table('orders')
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total_amount'),
            DB::raw('SUM(total_paid) as total_paid')
        )
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        
    
        return view('dashboard.dashboardView', [
            'products' => $products,
            'expenses' => $mappedExpenses,
            'totalExpense' => $expenseAmount,
            'extraIncome' => $extraIncome,
            'orders' => $orders,
            'paid' => $paid,
            'due' => $due,
            'customers' => $customers,
            'products_' => $products_,
            'monthlySales' => $monthlySales
        ]);
    }

    public function generateMonthlyReport(Request $request) {
        $month = $request->get('month');
        $year = $request->get('year');
        $startDate = Carbon::createFromDate($year, $month)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month)->endOfMonth();
    
        // Fetch and process product data
        $productsQuery = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name as product_name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.id')
            ->whereBetween('order_items.updated_at', [$startDate, $endDate]);
    
        // Fetch and process expense data
        $expensesQuery = DB::table('expenses')
            ->select('type', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('type')
            ->whereBetween('expenses.updated_at', [$startDate, $endDate]);
    
        $products = $productsQuery->get();
        $expenses = $expensesQuery->get();
    
        $orders = Order::whereBetween('updated_at', [$startDate, $endDate])->sum('total_amount');
        $paid = Order::whereBetween('updated_at', [$startDate, $endDate])->sum('total_paid');
        $due = Order::whereBetween('updated_at', [$startDate, $endDate])->sum('due');
        $salaries = Salary::whereBetween('updated_at', [$startDate, $endDate])->sum('paid_amount');
        $expenseAmount = Expense::whereBetween('updated_at', [$startDate, $endDate])->sum('amount');
        $expenseAmount += $salaries;
        $extraIncome = ExtraIncome::whereBetween('updated_at', [$startDate, $endDate])->sum('amount');
        $extraIncomes = ExtraIncome::whereBetween('updated_at', [$startDate, $endDate])->get();
    
        // Mapping expense types to their names
        $expenseTypes = config('expense_type');
        $mappedExpenses = $expenses->map(function($expense) use ($expenseTypes) {
            $typeName = array_search($expense->type, $expenseTypes);
            return [
                'type' => $typeName,
                'total_amount' => $expense->total_amount
            ];
        });
    
        return response()->json([
            'products' => $products,
            'expenses' => $mappedExpenses,
            'totalExpense' => $expenseAmount,
            'extraIncome' => $extraIncome,
            'orders' => $orders,
            'paid' => $paid,
            'due' => $due,
            'extraIncomes' => $extraIncomes,
            'salaries' => $salaries
        ]);
    }

    public function generateProductReport(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::with('orderitem')->find($productId);

        if ($product) {
            $availableQuantity = $product->quantity;
            $orderItems = OrderItem::where('product_id', $productId)
                            ->with(['order.customer'])
                            ->get();

            $orderItemsData = $orderItems->map(function($item) {
                return [
                    'date' => $item->updated_at,
                    'quantity' => $item->quantity,
                    'customer_name' => $item->order->customer->name ?? 'N/A'
                ];
            });

            return response()->json([
                'product_name' => $product->name,
                'available_quantity' => $availableQuantity,
                'orderItems' => $orderItemsData
            ]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
    
    
}
