@extends('layouts.template')
@section('content')
<div class="row d-flex justify-content-center">
    <!-- Left Card -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                @if ($employee->image)
                    <img src="{{ asset($employee->image) }}" alt="Employee Image" class="smaller-image" width="50%">
                @else
                    <p>No image available</p>
                @endif
            </div>
        </div>
    </div>
    <!-- Right Card -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <h4 class="card-title">Employee Details</h4>
                <dl class="row">
                    <dt class="col-sm-4">Name:</dt>
                    <dd class="col-sm-8">{{ $employee->name }}</dd>
                    
                    <dt class="col-sm-4">Salary:</dt>
                    <dd class="col-sm-8">{{ $employee->salary }}</dd>
                    
                    <dt class="col-sm-4">Joined At:</dt>
                    <dd class="col-sm-8">{{ $employee->joined_at }}</dd>
                    
                    <dt class="col-sm-4">Employment Duration:</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($employee->joined_at)->diffInDays(\Carbon\Carbon::now()) }} days</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
