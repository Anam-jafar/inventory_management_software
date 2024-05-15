@extends('layouts.template')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Category list</h4>
            <div class="row mb-3">
                <div class="col-md-2">
                    <form action="{{ route('allCategory') }}" method="GET" class="form-inline">
                    <label for="perPage" class="me-2">Items per page:</label>
                        <div class="row align-items-center">
                            <div class="col-md-auto pe-0">
                                <select name="perPage" id="perPage" class="form-select">
                                    <option value="5" {{ request()->perPage == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request()->perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="15" {{ request()->perPage == 15 ? 'selected' : '' }}>15</option>
                                </select>
                            </div>
                            <div class="col-md-auto ps-0">
                                <button type="submit" class="btn btn-outline-light">Apply</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-10 text-end">
                    <span>Total: {{ $categories->total() }} categories</span>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            <label class="badge badge-{{ $category->status ? 'success' : 'danger' }}">
                                {{ $category->status ? 'Active' : 'Inactive' }}
                            </label>
                        </td>
                        <td>
                            <div class="dropdown dropdown-arrow-none">
                                <button class="btn p-0 text-dark dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIconButton1">
                                    <a class="dropdown-item" href="{{route('editCategory',$category->id)}}"><i class="mdi mdi-border-color"></i> Update</a>
                                    <a class="dropdown-item" href="{{route('deleteCategory',$category->id)}}"><i class="mdi mdi-delete"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $categories->links('vendor.pagination.bootstrap-4') }} <!-- Pagination Links with Bootstrap styling -->
        </div>
    </div>
</div>
@endsection
