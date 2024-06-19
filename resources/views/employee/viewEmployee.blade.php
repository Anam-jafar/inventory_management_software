@extends('layouts.template')
@section('content')
<div class="row d-flex justify-content-center">
    <!-- Right Card -->
    <div class="col-md-10 grid-margin stretch-card">
        <div class="card h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <h4 class="card-title">Employee Details</h4>
                <dl class="row">
                    <dt class="col-sm-4 text-dark">Name:</dt>
                    <dd class="col-sm-8 text-dark">{{ $employee->name }}</dd>
                    
                    <dt class="col-sm-4 text-dark">Salary:</dt>
                    <dd class="col-sm-8 text-dark">{{ $employee->salary }}</dd>
                    
                    <dt class="col-sm-4 text-dark">Joined At:</dt>
                    <dd class="col-sm-8 text-dark">{{ $employee->joined_at }}</dd>
                    
                    <dt class="col-sm-4 text-dark">Employment Duration:</dt>
                    <dd class="col-sm-8 text-dark">{{ \Carbon\Carbon::parse($employee->joined_at)->diffInDays(\Carbon\Carbon::now()) }} days</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Salary History -->
<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Salary History</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Paid Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->salaries as $salary)
                                <tr>
                                    <td>{{ $salary->id }}</td>
                                    <td>{{ $salary->month }}</td>
                                    <td>{{ $salary->year }}</td>
                                    <td>{{ $salary->paid_amount }}</td>
                                    <td>{{ $salary->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
