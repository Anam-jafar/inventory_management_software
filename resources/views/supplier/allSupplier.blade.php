@extends('layouts.template')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Customer list</h4>
            <div class="row mb-3">
                <!-- Items per page dropdown -->
                <div class="col-md-2">
                    <form action="{{ route('allSupplier') }}" method="GET" class="form-inline">
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
                        <form action="{{ route('allSupplier') }}" method="GET" class="form-inline">
                        
                            <input type="text" name="query" value="{{ request()->input('query') }}" class="form-control me-2" placeholder="Search customer">
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
                        <th>Contact</th>
                        <th>Due</th>
                        <th>Total Given</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->contact }}</td>
                        <td>{{ $customer->to_be_paid }}</td>
                        <td>{{ $customer->total_given }}</td>

                        <td>
                            <div class="dropdown dropdown-arrow-none">
                                <button class="btn p-0 text-dark dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIconButton1">
                                    <a class="dropdown-item" href="{{ route('viewSupplier', $customer->id) }}"><i class="mdi  mdi-eye-circle"></i> View</a>
                                    <a class="dropdown-item" href="{{ route('editSupplier', $customer->id) }}"><i class="mdi mdi-border-color"></i> Update</a>
                                    <a class="dropdown-item" href="{{ route('deleteSupplier', $customer->id) }}"><i class="mdi mdi-delete"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <!-- Pagination Links -->
            {{ $customers->appends(['query' => request()->input('query'), 'perPage' => request()->input('perPage')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
