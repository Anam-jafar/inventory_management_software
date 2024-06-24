@extends('layouts.template')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <div class="row d-flex justify-content-between align-items-center">
            <h4 class="card-title">Product list</h4>
            <h4 class="card-title">Total Value : <span class="badge badge-success">{{ $totalValue }} Tk.</span></h4>
        </div>

            <div class="row mb-3">
                <!-- Items per page dropdown -->
                <div class="col-md-2">
                    <form action="{{ route('allProduct') }}" method="GET" class="form-inline">
                        <label for="perPage" class="me-2">Items per page:</label>
                        <div class="row align-items-center">
                            <div class="col-md-auto pe-0">
                                <select name="perPage" id="perPage" class="form-select">
                                    <option value="5" {{ request()->input('perPage') == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request()->input('perPage') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="15" {{ request()->input('perPage') == 15 ? 'selected' : '' }}>15</option>
                                </select>
                            </div>
                            <div class="col-md-auto ps-0">
                                <button type="submit" class="btn btn-outline-light">Apply</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-10 justify-content-end d-flex">
                    <div class="row align-items-center">
                        <div class="col-md-auto pe-0">
                        <form action="{{ route('allProduct') }}" method="GET" class="form-inline">
                        
                            <input type="text" name="query" value="{{ request()->input('query') }}" class="form-control me-2" placeholder="Search Product">
                        </div>
                        <div class="col-md-auto ps-0">
                            <button type="submit" class="btn btn-outline-light btn-lg">Search</button>
                        
                        </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Category Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Total Value</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td><b>{{$product->quantity*$product->price}} Tk.</b></td>
                        <td>
                            <label class="badge badge-{{ $product->status ? 'success' : 'danger' }}">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </label>
                        </td>
                        <td>
                            <div class="dropdown dropdown-arrow-none">
                                <button class="btn p-0 text-dark dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIconButton1">
                                    <a class="dropdown-item" href="{{ route('editProduct', $product->id) }}"><i class="mdi mdi-border-color"></i> Update</a>
                                    <a class="dropdown-item" href="{{ route('deleteProduct', $product->id) }}"><i class="mdi mdi-delete"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <!-- Pagination Links -->
            {{ $products->appends(['query' => request()->input('query'), 'perPage' => request()->input('perPage')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
