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
        <h4 class="card-title">Add Supplier</h4>
        <p class="card-description"> Enter necessary information in the form below to update supplier. </p>
        <form class="forms-sample" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="name" value="{{ $supplier->name }}" name="name">
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-sm-3 col-form-label">Contact</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="address" value="{{$supplier->contact}}" name="contact">
                </div>
            </div>

            <div class="form-group row">
                <label for="contact" class="col-sm-3 col-form-label">Amount to be paid</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="contact" value="{{$supplier->to_be_paid}}" name="to_be_paid">
                </div>
                <label for="nid" class="col-sm-3 col-form-label">Due</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="nid" value="{{$supplier->total_given}}" name="total_given">
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-sm-3 col-form-label">Location</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="address" value="{{$supplier->location}}" name="location">
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="col-auto">
                    <a href="{{route('allProduct')}}" class="btn btn-rounded btn-danger btn-lg">Cancel</a>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-rounded btn-success btn-lg"><i class="mdi mdi-border-color"></i> update</button>
                </div>
            </div>
        </form>

        </div>
    </div>
    </div>
 
</div>

@endsection