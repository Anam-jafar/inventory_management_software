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
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('d F Y H:i') }}</p>
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
                            <tr>
                                <th colspan="4" class="text-right">Total Amount After Discount</th>
                                <th>{{ number_format($order->total_amount, 2) }}</th>
                            </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>

                <h5 class="mt-4">Payment History</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->payment as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('d F Y') }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right">Total Paid</th>
                                <th>{{ number_format($order->total_paid, 2) }}</th>
                            </tr>
                            <tr>
                                <th class="text-right">Due</th>
                                <th>{{ number_format($order->due, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @if($order->payment_status != config('payment_status.paid'))
                <div class="row justify-content-end mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                        Pay
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('payOrder', $order->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="{{ $order->due }}" value="{{ $order->due }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="payButton">Pay - {{ $order->due }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('amount').addEventListener('input', function() {
        var amount = this.value;
        var payButton = document.getElementById('payButton');
        if (amount) {
            payButton.textContent = 'Pay - ' + amount;
        } else {
            payButton.textContent = 'Pay - {{ $order->due }}';
        }
    });
</script>

@endsection
