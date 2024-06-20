document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('myChart').getContext('2d');
    let myChart;


    const optimistData = [
        {"an":"2024","total":400000},
        {"an":"2025","total":380000},
        {"an":"2026","total":360000},
        {"an":"2027","total":350000},
        {"an":"2028","total":340000},
        {"an":"2029","total":330000},
        {"an":"2030","total":320000},
        {"an":"2031","total":310000},
        {"an":"2032","total":300000},
        {"an":"2033","total":290000},
        {"an":"2034","total":280000}
    ];

    const moderatData = [
        {"an":"2024","total":450000},
        {"an":"2025","total":460000},
        {"an":"2026","total":470000},
        {"an":"2027","total":480000},
        {"an":"2028","total":490000},
        {"an":"2029","total":500000},
        {"an":"2030","total":510000},
        {"an":"2031","total":520000},
        {"an":"2032","total":530000},
        {"an":"2033","total":540000},
        {"an":"2034","total":550000}
    ];

    const pesimistData = [
        {"an":"2024","total":550000},
        {"an":"2025","total":580000},
        {"an":"2026","total":610000},
        {"an":"2027","total":640000},
        {"an":"2028","total":670000},
        {"an":"2029","total":700000},
        {"an":"2030","total":730000},
        {"an":"2031","total":760000},
        {"an":"2032","total":790000},
        {"an":"2033","total":820000},
        {"an":"2034","total":850000}
    ];
    window.loadChartData = function(scenario) {
        myChart.destroy();
        loadChartData(scenario);
    }

    function loadChartData(scenario) {
        let data;
        if (scenario === 'optimist') {
            data = optimistData;
        } else if (scenario === 'moderat') {
            data = moderatData;
        } else if (scenario === 'pesimist') {
            data = pesimistData;
        }
        createChart(data);
    }

   
    function createChart(data) {
        if (myChart) {
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(row => row.an),
                datasets: [{
                    label: 'total',
                    data: data.map(row => row.total),
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


    loadChartData('optimist');
});
