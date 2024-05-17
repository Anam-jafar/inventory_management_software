@extends('layouts.template')
@section('content')
<div class="row d-flex justify-content-center">
    <!-- Left Card -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                    <p>Customer Details</p>
            </div>
        </div>
    </div>
    <!-- Right Card -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <h4 class="card-title">Customer Details</h4>
                <dl class="row">
                    <dt class="col-sm-4">Name:</dt>
                    <dd class="col-sm-8">{{ $customer->name }}</dd>
                    
                    <dt class="col-sm-4">Contact:</dt>
                    <dd class="col-sm-8">{{ $customer->contact }}</dd>
                    
                    <dt class="col-sm-4">Total Invoiced Amount:</dt>
                    <dd class="col-sm-8">{{ $customer->total_invoiced_amount }}</dd>

                    <dt class="col-sm-4">Total Due:</dt>
                    <dd class="col-sm-8">{{ $customer->due }}</dd>
                    
                    <!-- <dt class="col-sm-4">Employment Duration:</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($customer->joined_at)->diffInDays(\Carbon\Carbon::now()) }} days</dd> -->
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
