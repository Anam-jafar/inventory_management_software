<!-- resources/views/expense/addExpense.blade.php -->
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
                <h4 class="card-title">{{ isset($expense) ? 'Edit' : 'Add' }} Expense</h4>
                <p class="card-description"> Enter necessary information in the form below to {{ isset($expense) ? 'edit the' : 'add a new' }} expense. </p>
                <form class="forms-sample" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="type" class="col-sm-3 col-form-label">Expense Type</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="type" name="type">
                                @foreach($expenseTypes as $type => $value)
                                    <option value="{{ $value }}" {{ isset($expense) && $expense->type == $value ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="amount" class="col-sm-3 col-form-label">Amount</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount', isset($expense) ? $expense->amount : '') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description">{{ old('description', isset($expense) ? $expense->description : '') }}</textarea>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <a href="{{ route('allExpense') }}" class="btn btn-rounded btn-danger btn-lg">Cancel</a>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-rounded btn-success btn-lg">
                                <i class="mdi mdi-{{ isset($expense) ? 'content-save' : 'plus' }}"></i> {{ isset($expense) ? 'Save' : 'Add' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
