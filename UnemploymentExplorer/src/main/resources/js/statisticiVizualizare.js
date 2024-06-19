document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('myChart').getContext('2d');
    let myChart;

    const jsonData = [
        {"month":"Ian","income":1210},
        {"month":"Feb","income":1920},
        {"month":"Mar","income":830},
        {"month":"Apr","income":1300},
        {"month":"Mai","income":990},
        {"month":"Jun","income":1250}
    ];

    createChart(jsonData, 'bar');

    window.setChartType = function(chartType) {
        myChart.destroy();
        createChart(jsonData, chartType);
    }

    function createChart(data, type) {
        myChart = new Chart(ctx, {
            type: type,
            data: {
                labels: data.map(row => row.month),
                datasets: [{
                    label: 'Income',
                    data: data.map(row => row.income),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false
            }
        });
    }
});
