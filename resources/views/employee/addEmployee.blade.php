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
        <h4 class="card-title">Add Employee</h4>
        <p class="card-description"> Enter necessary information in the form below to add a new employee. </p>
        <form class="forms-sample" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                </div>
            </div>
            <div class="form-group row">
                <label for="salary" class="col-sm-3 col-form-label">Salary</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="salary" placeholder="Salary" name="salary">
                </div>
                <label for="joined_date" class="col-sm-3 col-form-label">Joined Date</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="joined_date" name="joined_at">
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="address" placeholder="Enter address" name="address">
                </div>
            </div>
            <div class="form-group row">
                <label for="contact" class="col-sm-3 col-form-label">Contact</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="contact" placeholder="Enter contact" name="contact">
                </div>
                <label for="nid" class="col-sm-3 col-form-label">NID</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="nid" placeholder="Enter NID" name="nid">
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