@extends('layouts.template')
@section('content')
@if ($errors->any())
    @foreach ($errors->all() as $error)
        @php
            notify()->error($error, 'Failed');
        @endphp
    @endforeach
@endif

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pay Salary</h4>
                <p class="card-description">Enter necessary information in the form below to pay a salary.</p>
                <form class="forms-sample" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="employee_id" class="col-sm-3 col-form-label">Select Employee</label>
                        <div class="col-sm-9">
                            <select class="form-control custom-select" id="employee_id" name="employee_id">
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->id }} - {{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="amount" class="col-sm-3 col-form-label">Amount</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="amount" placeholder="Enter Amount" name="amount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="month" class="col-sm-3 col-form-label">Month</label>
                        <div class="col-sm-9">
                            <select class="form-control custom-select" id="month" name="month">
                                <option value="">Select Month</option>
                                @foreach (range(1, 12) as $monthNum)
                                    <option value="{{ $monthNum }}">{{ date('F', mktime(0, 0, 0, $monthNum, 1)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="year" class="col-sm-3 col-form-label">Year</label>
                        <div class="col-sm-9">
                            <select class="form-control custom-select" id="year" name="year">
                                <option value="">Select Year</option>
                                @php
                                    $currentYear = date('Y');
                                    $range = range($currentYear-2, $currentYear + 5);
                                @endphp
                                @foreach ($range as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <a href="{{ route('allProduct') }}" class="btn btn-rounded btn-danger btn-lg">Cancel</a>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-rounded btn-success btn-lg"><i class="mdi mdi-plus"></i> Pay Salary</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
