<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function allOrder(Request $request) {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 5);
        $paymentStatus = $request->input('payment_status', 'all');
    
        $orders = Order::with('customer')
            ->when($query, function($queryBuilder) use ($query) {
                $queryBuilder->whereHas('customer', function($customerQuery) use ($query) {
                    $customerQuery->where('name', 'like', "%$query%");
                });
            })
            ->when($paymentStatus !== 'all', function($queryBuilder) use ($paymentStatus) {
                $queryBuilder->where('payment_status', $paymentStatus);
            })
            ->latest()
            ->paginate($perPage);
    
        return view('order.allOrder', compact('orders'));
    }
    
    
    
    public function viewOrder($id = null){
        $order = Order::with(['customer', 'item', 'payment'])->find($id);

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
            $order->due = $total_amount_after_discount;
            $order->save();

            $customer = Customer::find($customer_id);

            $customer->total_invoiced_amount += $total_amount_after_discount;
            $customer->due += $total_amount_after_discount;
            
            $customer->save();
            
            
    
            // Save the product items
            foreach ($products as $index => $product_id) {
                $productItem = new OrderItem();
                $productItem->order_id = $order->id;
                $productItem->product_id = $product_id;
                $productItem->quantity = $quantities[$index];
                $productItem->save();

                // Update product quantity
                $product = Product::find($product_id);
                $product->quantity -= $quantities[$index];
                $product->save();
            }
    
            notify()->success('Product added successfully', 'Added') ;
            return redirect()->route('viewOrder', $order->id);
        } else {
            return view('order.addOrder', compact(['products', 'customers']));
        }
    }

    public function payOrder(Request $request, $orderId) {
        $order = Order::find($orderId);
    
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $order->due,
        ]);
    
        $amount = $request->input('amount');
    
        // Save the payment (assuming you have a Payment model)
        Payment::create([
            'order_id' => $order->id,
            'amount' => $amount,
            'customer_id' => $order->customer_id,
        ]);
    
        // Update the customer's due amount
        $customer = $order->customer;
        $customer->due -= $amount;
        $customer->save();

        $order->due -= $amount;
        if($order->due == 0){
            $order->payment_status = config('payment_status.paid');
        }else{
            $order->payment_status = config('payment_status.partially_paid');
        }
        $order->total_paid += $amount;
        $order->save();
    
        return redirect()->route('viewOrder', $order->id);
    }
    
    
}
