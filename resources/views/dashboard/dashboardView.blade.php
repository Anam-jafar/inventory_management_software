@extends('layouts.template')
@section('content')
<div class="d-xl-flex justify-content-between align-items-start">
    <h2 class="text-dark font-weight-bold mb-2">Overview dashboard </h2>
    <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
        <div class="btn-group bg-white p-3" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-link text-gray py-0 border-right" onclick="loadDashboardData('1_month')">1 Month</button>
            <button type="button" class="btn btn-link text-gray py-0 border-right" onclick="loadDashboardData('3_months')">3 Month</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="d-sm-flex justify-content-between align-items-center transaparent-tab-border">
            <ul class="nav nav-tabs tab-transparent" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="business-tab" data-bs-toggle="tab" href="#business-1" role="tab" aria-selected="false">Business Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="users-tab" data-bs-toggle="tab" href="#users-1" role="tab" aria-selected="true">Sales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="performance-tab" data-bs-toggle="tab" href="#performance-1" role="tab" aria-selected="false">Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="conversion-tab" data-bs-toggle="tab" href="#conversion-1" role="tab" aria-selected="false">Conversion</a>
                </li>
            </ul>
            <div class="d-md-block d-none">
                <a href="#" class="text-light p-1"><i class="mdi mdi-view-dashboard"></i></a>
                <a href="#" class="text-light p-1"><i class="mdi mdi-dots-vertical"></i></a>
            </div>
        </div>
        <div class="tab-content tab-transparent-content">
            <div class="tab-pane fade show active" id="business-1" role="tabpanel" aria-labelledby="business-tab">
            <div class="row">
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="dashboard-progress dashboard-progress-1 d-flex align-items-center justify-content-center item-parent">
                                    <i class="mdi mdi-lightbulb icon-md text-dark"></i>
                                </div>
                                <h5 class="mb-2 text-dark font-weight-bold">Orders</h5>
                                <h2 class="mb-4 text-dark font-weight-bold num-display" id="orders">--</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent">
                                    <i class="mdi mdi-cash-multiple icon-md text-dark"></i>
                                </div>
                                <h5 class="mb-2 text-dark font-weight-bold">Payment Received</h5>
                                <h2 class="mb-4 text-dark font-weight-bold num-display" id="paid">--</h2>
                                <p class="mt-4 mb-0">Total due on orders</p>
                                <h2 class="mb-4 text-dark font-weight-bold" id="due">--</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="dashboard-progress dashboard-progress-3 d-flex align-items-center justify-content-center item-parent">
                                    <i class="mdi mdi-plus-circle icon-md text-dark"></i>
                                </div>
                                <h5 class="mb-2 text-dark font-weight-bold">Extra Income</h5>
                                <h2 class="mb-4 text-dark font-weight-bold num-display" id="extraIncome">--</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="dashboard-progress dashboard-progress-4 d-flex align-items-center justify-content-center item-parent">
                                    <i class="mdi mdi-minus-circle icon-md text-dark"></i>
                                </div>
                                <h5 class="mb-2 text-dark font-weight-bold">Expense</h5>
                                <h2 class="mb-4 text-dark font-weight-bold num-display text-danger" id="totalExpense">--</h2>
                                <p class="mt-4 mb-0">Employee Salaries are included here.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Card for Products -->
                    <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Products Sale</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Products</th>
                                            <th>Unit Sold</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Card for Expenses -->
                    <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Expenses</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Expense Type</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expenseTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="users-1" role="tabpanel" aria-labelledby="users-tab">
            <div class="row d-flex justify-content-around">
                    <!-- elements -->
                    <div class="col-xl-5 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <canvas id="productPieChart" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <canvas id="ExpensePieChart" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- elements -->
                </div>
            </div>
            <div class="tab-pane fade" id="performance-1" role="tabpanel" aria-labelledby="performance-tab">
            <div class="row">
    <!-- existing content here -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Customers</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Order Count</th>
                            <th>Total Due</th>
                        </tr>
                    </thead>
                    <tbody id="customerTableBody">
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->order_count }}</td>
                            <td>{{ $customer->total_due }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
            </div>
            <div class="tab-pane fade" id="conversion-1" role="tabpanel" aria-labelledby="conversion-tab">
                <h3 class="text-center">Conversion</h3>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    // Embed the data into the HTML
    window.dashboardData = {
      products: <?php echo json_encode($products); ?>,
      expenses: <?php echo json_encode($expenses); ?>
    };
    // Function to load dashboard data based on the selected period
    function loadDashboardData(period) {
        $.ajax({
            url: '/view-data',
            type: 'GET',
            data: { period: period },
            success: function(data) {
                // Update the values on the page
                $('#orders').text(data.orders + ' Tk.');
                $('#paid').text(data.paid + ' Tk.');
                $('#due').text(data.due + ' Tk.');
                $('#extraIncome').text(data.extraIncome + ' Tk.');
                $('#totalExpense').text(data.totalExpense + ' Tk.');

                // Update the product table
                var productTableBody = '';
                data.products.forEach(function(product) {
                    productTableBody += '<tr><td>' + product.product_name + '</td><td>' + product.total_quantity + '</td></tr>';
                });
                $('#productTableBody').html(productTableBody);

                // Update the expense table
                var expenseTableBody = '';
                data.expenses.forEach(function(expense) {
                    expenseTableBody += '<tr><td>' + expense.type + '</td><td>' + expense.total_amount + '</td></tr>';
                });
                $('#expenseTableBody').html(expenseTableBody);
                window.dashboardData = {
                  products: <?php echo json_encode($products); ?>,
                  expenses: <?php echo json_encode($expenses); ?>
                };
            }
        });
    }

    // Load the default data for 1 month on page load
    $(document).ready(function() {
        loadDashboardData('1_month');
    });
</script>
@endsection
