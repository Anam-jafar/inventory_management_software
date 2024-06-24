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
        <h4 class="card-title">Add Product</h4>
        <p class="card-description"> Enter necessary information in the form below to add a new product. </p>
        <form class="forms-sample" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="name" placeholder="Enter product name" name="name">
                </div>
            </div>
            <div class="form-group row">
                <label for="category" class="col-sm-3 col-form-label">Category</label>
                <div class="col-sm-9">
                    <select class="form-control custom-select" id="category" name="category_id">
                        <option value="">Choose category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="col-sm-3 col-form-label">Price</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="price" placeholder="Price" name="price" step="0.01">
                </div>

                <label for="quantity" class="col-sm-3 col-form-label">Quantity</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="quantity" placeholder="Quantity" name="quantity">
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="description" placeholder="Description" name="description"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="restock_limit" class="col-sm-3 col-form-label">Restock Limit</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="restock_limit" placeholder="Restock Limit" name="restock_limit">
                </div>
                <label for="status" class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-3">
                    <select class="form-control custom-select" id="status" name="status">
                        <option value="{{config('status.active')}}">Active</option>
                        <option value="{{config('status.inactive')}}">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-3 col-form-label">Image</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="image" name="image">
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-auto">
                    <a href="{{route('allProduct')}}" class="btn btn-rounded btn-danger btn-lg">Cancel</a>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-rounded btn-success btn-lg"><i class="mdi mdi-plus"></i> Add</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    </div>
 
</div>

@endsection