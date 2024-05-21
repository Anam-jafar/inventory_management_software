<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function viewOrder($id = null){
        $order = Order::with(['customer', 'item'])->find($id);

        return view('order.viewOrder', compact('order'));
    }
    public function addOrder(Request $request){
        $products = Product::where('deleted', '!=', config('deleted'))->latest()->get();
        $customers = Customer::where('deleted', '!=', config('deleted'))->latest()->get();
    
        if($request->isMethod('post')){

            // Check if a new customer is being added
            $customer_id = $request->customer_id;
            if ($request->new_customer_name) {
                $customer = new Customer();
                $customer->name = $request->new_customer_name;
                $customer->contact = $request->new_customer_contact;
                $customer->save();
                $customer_id = $customer->id;
            }
    
            // Calculate total amount
            $total_amount = 0;
            $products = $request->products;
            $quantities = $request->quantities;
    
            foreach ($products as $index => $product_id) {
                $product = Product::find($product_id);
                $total_amount += $product->price * $quantities[$index];
            }
    
            // Calculate discount
            $discount = 0;
            if ($request->discount_type) {
                if ($request->discount_type == 'percentage') {
                    $discount = ($request->discount_value / 100) * $total_amount;
                } elseif ($request->discount_type == 'amount') {
                    $discount = $request->discount_value;
                }
            }
            $total_amount_after_discount = $total_amount - $discount;
    
            // Save the order
            $order = new Order();
            $order->customer_id = $customer_id;
            $order->discount = $discount;
            $order->total_amount = $total_amount_after_discount;
            $order->save();
    
            // Save the product items
            foreach ($products as $index => $product_id) {
                $productItem = new OrderItem();
                $productItem->order_id = $order->id;
                $productItem->product_id = $product_id;
                $productItem->quantity = $quantities[$index];
                $productItem->save();
            }
    
            notify()->success('Product added successfully', 'Added') ;
            return redirect()->route('viewOrder', $order->id);
        } else {
            return view('order.addOrder', compact(['products', 'customers']));
        }
    }
    
}
