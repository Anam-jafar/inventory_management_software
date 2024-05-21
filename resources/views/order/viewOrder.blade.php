@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">View Order</h4>
                <p class="card-description"> Details of the order. </p>

                <div class="row">
                    <div class="col-sm-6">
                        <h5>Order Information</h5>
                        <p><strong>Order ID:</strong> {{ $order->id }}</p>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
                    </div>
                    <div class="col-sm-6">
                        <h5>Customer Information</h5>
                        <p><strong>Name:</strong> {{ $order->customer->name }}</p>
                        <p><strong>Contact:</strong> {{ $order->customer->contact }}</p>
                    </div>
                </div>

                <h5 class="mt-4">Order Items</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->item as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->product->price, 2) }}</td>
                                <td>{{ number_format($item->quantity * $item->product->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total Amount</th>
                                <th>{{ number_format($order->total_amount + $order->discount, 2) }}</th>
                            </tr>
                            @if($order->discount > 0)
                            <tr>
                                <th colspan="4" class="text-right">Discount</th>
                                <th>-{{ number_format($order->discount, 2) }}</th>
                            </tr>
                            @endif
                            <tr>
                                <th colspan="4" class="text-right">Total Amount After Discount</th>
                                <th>{{ number_format($order->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row justify-content-end mt-4">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
