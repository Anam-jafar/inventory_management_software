@extends('layouts.template')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Extra Income List</h4>
            <div class="row mb-3 d-flex justify-content-between">
                <!-- Items per page dropdown -->
                <div class="col-md-2">
                    <form action="{{ route('allExtraIncome') }}" method="GET" class="form-inline">
                        <div class="d-flex align-items-center">
                            <label for="perPage" class="me-2">Show</label>
                            <select name="perPage" id="perPage" class="form-select pagination-select" onchange="this.form.submit()">
                                <option value="5" {{ request()->input('perPage') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request()->input('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ request()->input('perPage') == 15 ? 'selected' : '' }}>15</option>
                            </select>
                            <label for="perPage" class="ms-2">items</label>
                        </div>
                    </form>
                </div>

                <!-- Extra Income Type Filter -->
                <div class="col-md-2">
                    <form action="{{ route('allExtraIncome') }}" method="GET" class="form-inline">
                        <div class="d-flex align-items-center">
                            <label for="type" class="me-2">Type</label>
                            <select name="type" id="type" class="form-select status-select" onchange="this.form.submit()">
                                <option value="all" {{ request()->input('type') == 'all' ? 'selected' : '' }}>All</option>
                                @foreach($incomeTypes as $incomeType => $value)
                                    <option value="{{ $value }}" {{ request()->input('type') == $value ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $incomeType)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Extra Incomes Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incomes as $income)
                    <tr>
                        <td>{{ ucfirst(str_replace('_', ' ', ucfirst(array_search($income->type, config('extra_income_type'))))) }}</td>
                        <td>{{ $income->amount }}</td>
                        <td>{{ $income->description }}</td>
                        <td>
                            <div class="dropdown dropdown-arrow-none">
                                <button class="btn p-0 text-dark dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIconButton1">
                                    <a class="dropdown-item" href="{{ route('editExtraIncome', $income->id) }}"><i class="mdi mdi-border-color"></i> Update</a>
                                    <a class="dropdown-item" href="{{ route('deleteExtraIncome', $income->id) }}"><i class="mdi mdi-delete"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Links -->
            {{ $incomes->appends(['perPage' => request()->input('perPage'), 'type' => request()->input('type', 'all')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
