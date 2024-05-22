@extends('layouts.template')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Order List</h4>
            <div class="row mb-3 d-flex justify-content-between">
    <!-- Items per page dropdown -->
    <div class="col-md-2">
        <form action="{{ route('allOrder') }}" method="GET" class="form-inline">
            <div class="d-flex align-items-center">
                <label for="perPage" class="me-2">show</label>
                <select name="perPage" id="perPage" class="form-select pagination-select" onchange="this.form.submit()">
                    <option value="5" {{ request()->input('perPage') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request()->input('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request()->input('perPage') == 15 ? 'selected' : '' }}>15</option>
                </select>
                <label for="perPage" class="me-2"> items</label>
            </div>
        </form>
    </div>

    <!-- Search orders by customer name -->
    <div class="col-md-4">
        <form action="{{ route('allOrder') }}" method="GET" class="d-flex">
            <input type="text" name="query" value="{{ request()->input('query') }}" class="form-control me-2" placeholder="Search orders by customer name">
            <button type="submit" class="btn btn-outline-light">Search</button>
        </form>
    </div>

    <!-- Payment Status Filter -->
    <div class="col-md-2">
        <form action="{{ route('allOrder') }}" method="GET" class="form-inline">
            <div class="d-flex align-items-center">
                <label for="payment_status" class="me-2">Payment</label>
                <select name="payment_status" id="payment_status" class="form-select status-select" onchange="this.form.submit()">
                    <option value="all" {{ request()->input('payment_status') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="{{ config('payment_status.not_paid') }}" {{ request()->input('payment_status') == config('payment_status.not_paid') ? 'selected' : '' }}>Not Paid</option>
                    <option value="{{ config('payment_status.partially_paid') }}" {{ request()->input('payment_status') == config('payment_status.partially_paid') ? 'selected' : '' }}>Partially Paid</option>
                    <option value="{{ config('payment_status.paid') }}" {{ request()->input('payment_status') == config('payment_status.paid') ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
        </form>
    </div>
</div>



            <!-- Orders Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Payable Amount</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ number_format($order->due, 2) }}</td>
                        <td>{{ config('payment_status.' . $order->payment_status) }}</td>
                        <td>
                            <div class="dropdown dropdown-arrow-none">
                                <button class="btn p-0 text-dark dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIconButton1">
                                    <a class="dropdown-item" href="{{ route('viewOrder', $order->id) }}"><i class="mdi mdi-eye-circle"></i> View</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <!-- Pagination Links -->
            {{ $orders->appends([
                'query' => request()->input('query'), 
                'perPage' => request()->input('perPage'), 
                'payment_status' => request()->input('payment_status', 'all')
            ])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div> 
@endsection
