document.addEventListener("DOMContentLoaded", function() {
    // Access the embedded data
    var products = window.dashboardData.products;
    var expenses = window.dashboardData.expenses;

    // Prepare product data for the chart
    var productLabels = products.map(product => product.product_name);
    var productData = products.map(product => product.total_quantity);

    // Prepare expense data for the chart
    var expenseLabels = expenses.map(expense => expense.type);
    var expenseData = expenses.map(expense => expense.total_amount);

    // Function to generate random color
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Generate random colors for the charts
    var productBackgroundColors = productLabels.map(() => getRandomColor());
    var productBorderColors = productBackgroundColors.map(color => color);

    var expenseBackgroundColors = expenseLabels.map(() => getRandomColor());
    var expenseBorderColors = expenseBackgroundColors.map(color => color);

    // Product Pie Chart
    var ctxProduct = document.getElementById('productPieChart').getContext('2d');
    var productPieChart = new Chart(ctxProduct, {
        type: 'pie',
        data: {
            labels: productLabels,
            datasets: [{
                label: 'Quantity Sold',
                data: productData,
                backgroundColor: productBackgroundColors,
                borderColor: productBorderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // Ensure the legend is hidden
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });

    // Expense Pie Chart
    var ctxExpense = document.getElementById('ExpensePieChart').getContext('2d');
    var expensePieChart = new Chart(ctxExpense, {
        type: 'pie',
        data: {
            labels: expenseLabels,
            datasets: [{
                label: 'Amount Spent',
                data: expenseData,
                backgroundColor: expenseBackgroundColors,
                borderColor: expenseBorderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // Ensure the legend is hidden
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
});
