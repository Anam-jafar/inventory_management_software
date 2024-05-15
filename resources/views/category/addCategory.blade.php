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
        <h4 class="card-title">Add category</h4>
        <p class="card-description"> Enter necessary information in the form below to add a new category. </p>
        <form class="forms-sample" method="POST">
            @csrf
            <div class="form-group row">
                <label for="category" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="category" placeholder="Enter category name" name="name" >
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-9">
                    <select class="form-control" id="status" name="status">
                        <option value="{{config('status.active')}}">Active</option>
                        <option value="{{config('status.inactive')}}">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="col-auto">
                    <a href="{{route('allCategory')}}" class="btn btn-rounded btn-danger btn-lg">Cancel</a>
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