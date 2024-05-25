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
        <h4 class="card-title">Restock Product</h4>
        <p class="card-description"> Enter necessary information in the form below to restock a product. </p>
        <form class="forms-sample" method="POST">
            @csrf
            <div class="form-group row">
                <label for="product" class="col-sm-3 col-form-label">Select Product</label>
                <div class="col-sm-9">
                    <select class="form-control custom-select" id="product" name="id">
                        <option value="">Choose product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="quantity" class="col-sm-3 col-form-label">Quantity to Restock</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="quantity" placeholder="Enter quantity" name="quantity">
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-auto">
                    <a href="{{ route('allProduct') }}" class="btn btn-rounded btn-danger btn-lg">Cancel</a>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-rounded btn-success btn-lg"><i class="mdi mdi-plus"></i> Restock</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>

@endsection
