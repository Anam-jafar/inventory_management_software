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
                    <a class="nav-link" id="conversion-tab" data-bs-toggle="tab" href="#conversion-1" role="tab" aria-selected="false">Monthly Report</a>
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
    <div class="card">
        <div class="card-body">
            <form id="reportForm" class="row">
                <div class="form-group col-md-4">
                    <select id="monthSelect" class="form-control custom-select">
                        <option value="" disabled selected>Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <select id="yearSelect" class="form-control custom-select">
                        <option value="" disabled selected>Year</option>
                        <!-- Year options here -->
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <button type="button" class="btn btn-rounded btn-success btn-lg" id="generateReportBtn" style="background-color: green !important;">Generate Monthly Report</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-4" id="reportResults">
        <!-- Report results will be displayed here -->
    </div>
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
    document.addEventListener('DOMContentLoaded', function() {
    // Populate the year select options
    const yearSelect = document.getElementById('yearSelect');
    const currentYear = new Date().getFullYear();
    for (let i = currentYear; i >= currentYear - 5; i--) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        yearSelect.appendChild(option);
    }

    document.getElementById('generateReportBtn').addEventListener('click', function() {
        const month = document.getElementById('monthSelect').value;
        const year = document.getElementById('yearSelect').value;
        
        fetch(`/generateMonthlyReport?month=${month}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                displayReport(data);
            })
            .catch(error => console.error('Error:', error));
    });

    function displayReport(data) {
        const reportResults = document.getElementById('reportResults');
        reportResults.innerHTML = '';

        // Ensure data is an array
        const products = Array.isArray(data.products) ? data.products : [];
        const expenses = Array.isArray(data.expenses) ? data.expenses : [];
        const extraIncome = Array.isArray(data.extraIncomes) ? data.extraIncomes : [];

        // Create and append product sales table
        const productSalesCard = createTableCard('Products Sale', 'productTableBody', [
            { title: 'Products', field: 'product_name' },
            { title: 'Unit Sold', field: 'total_quantity' }
        ], products);
        
        // Add salaries to expenses array
        expenses.push({ type: 'Salary', total_amount: data.salaries });

        // Create and append expenses table
        const expensesCard = createTableCard('Expenses', 'expenseTableBody', [
            { title: 'Expense Type', field: 'type' },
            { title: 'Amount', field: 'total_amount' }
        ], expenses);

        // Create and append extra income table
        const extraIncomeCard = createTableCard('Extra Incomes', 'extraIncomeTableBody', [
            { title: 'Income Type', field: 'type' },
            { title: 'Amount', field: 'amount' }
        ], extraIncome);

        // Calculate totals and profitability
        console.log(data.paid);
        const totalRevenue = data.paid + extraIncome.reduce((sum, income) => sum + income.amount, "");
        const paid = data.paid;
        const extra = extraIncome.reduce((sum, income) => sum + income.amount,"");
        const totalExpense = data.totalExpense;
        const isProfitable = totalRevenue > totalExpense;
        const salaries = data.salaries;
        const invoiced = data.orders;

        // Create and append summary card
        const summaryCard = createSummaryCard('Summary', totalRevenue, totalExpense, isProfitable, paid, extra, salaries, invoiced);

        // Append cards to the results container
        reportResults.appendChild(productSalesCard);
        reportResults.appendChild(expensesCard);
        reportResults.appendChild(extraIncomeCard);
        reportResults.appendChild(summaryCard);
    }

    function createTableCard(title, tbodyId, columns, data) {
        const card = document.createElement('div');
        card.classList.add('col-lg-6', 'grid-margin', 'stretch-card');

        const cardInner = document.createElement('div');
        cardInner.classList.add('card');

        const cardBody = document.createElement('div');
        cardBody.classList.add('card-body');

        const cardTitle = document.createElement('h4');
        cardTitle.classList.add('card-title');
        cardTitle.textContent = title;

        const table = document.createElement('table');
        table.classList.add('table');

        const thead = document.createElement('thead');
        const trHead = document.createElement('tr');

        columns.forEach(column => {
            const th = document.createElement('th');
            th.textContent = column.title;
            trHead.appendChild(th);
        });

        thead.appendChild(trHead);

        const tbody = document.createElement('tbody');
        tbody.id = tbodyId;

        data.forEach(item => {
            const tr = document.createElement('tr');
            columns.forEach(column => {
                const td = document.createElement('td');
                td.textContent = item[column.field];
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        });

        table.appendChild(thead);
        table.appendChild(tbody);

        cardBody.appendChild(cardTitle);
        cardBody.appendChild(table);

        cardInner.appendChild(cardBody);
        card.appendChild(cardInner);

        return card;
    }

    function createSummaryCard(title, revenue, expense, isProfitable, paid, extra, salaries, invoiced) {
        const card = document.createElement('div');
        card.classList.add('col-lg-12', 'grid-margin', 'stretch-card');

        const cardInner = document.createElement('div');
        cardInner.classList.add('card');

        const cardBody = document.createElement('div');
        cardBody.classList.add('card-body');

        const cardTitle = document.createElement('h4');
        cardTitle.classList.add('card-title');
        cardTitle.textContent = title;

        const cardText = document.createElement('p');
        cardText.classList.add('card-text');
        cardText.classList.add('font-weight-bold');
        cardText.classList.add('text-dark');
        cardText.innerHTML = `
            Product Invoiced : ${invoiced}<br>
            Paid By Customer : ${paid}<br>
            Total ExtraIncome :${extra}<br>
            Total Revenue : ${revenue}<br>
            <hr>

            Salary Paid : ${salaries}<br>
            Other Expense : ${expense-salaries}<br>
            Total Expense : ${expense}<br>
            <span class="badge ${isProfitable ? 'badge-success' : 'badge-danger'}">
                ${isProfitable ? 'Profitable' : 'Loss'}
            </span>
        `;

        cardBody.appendChild(cardTitle);
        cardBody.appendChild(cardText);

        cardInner.appendChild(cardBody);
        card.appendChild(cardInner);

        return card;
    }
});

    
</script>
@endsection
