$(document).ready(function() {
    // Use the embedded data directly
    if (typeof monthlySales !== 'undefined') {
        renderMonthlySalesChart(monthlySales);
    } else {
        console.error('monthlySales data is not defined');
    }

    function renderMonthlySalesChart(data) {
        const labels = data.map(item => `${item.year}-${item.month}`);
        const totalAmountData = data.map(item => item.total_amount);
        const totalPaidData = data.map(item => item.total_paid);

        const ctx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Amount Invoiced',
                        data: totalAmountData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                    },
                    {
                        label: 'Total Amount Paid',
                        data: totalPaidData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'category',
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Amount'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
