document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('myChart').getContext('2d');
    let myChart;
    let currentChartType = 'bar';

    const jsonData = [
        {"judet":"Alba","total":5533},
        {"judet":"Arad","total":2623},
        {"judet":"Argeș","total":8486},
        {"judet":"Bacău","total":5574},
        {"judet":"Bihor","total":4064},
        {"judet":"Bistrița-Năsăud","total":4891},
        {"judet":"Botoșani","total":4568},
        {"judet":"Brăila","total":3998},
        {"judet":"Brașov","total":6531},
        {"judet":"Buzău","total":7851},
        {"judet":"Călărași","total":4068},
        {"judet":"Caraș-Severin","total":2840},
        {"judet":"Cluj","total":4728},
        {"judet":"Constanța","total":5899},
        {"judet":"Covasna","total":3356},
        {"judet":"Dâmbovița","total":4752},
        {"judet":"Dolj","total":17147},
        {"judet":"Galați","total":8896},
        {"judet":"Giurgiu","total":2252},
        {"judet":"Gorj","total":3984},
        {"judet":"Hargita","total":5477},
        {"judet":"Hunedoara","total":7527},
        {"judet":"Ialomița","total":4153},
        {"judet":"Iași","total":8728},
        {"judet":"Ilfov","total":1003},
        {"judet":"Maramureș","total":4395},
        {"judet":"Mehedinți","total":6450},
        {"judet":"București","total":10715},
        {"judet":"Mureș","total":7301},
        {"judet":"Neamț","total":6838},
        {"judet":"Olt","total":7415},
        {"judet":"Prahova","total":6616},
        {"judet":"Sălaj","total":2254},
        {"judet":"Satu-Mare","total":5643},
        {"judet":"Sibiu","total":4789},
        {"judet":"Suceava","total":11898},
        {"judet":"Teleorman","total":8218},
        {"judet":"Timiș","total":2790},
        {"judet":"Tulcea","total":2588},
        {"judet":"Vâlcea","total":5123},
        {"judet":"Vaslui","total":9004},
        {"judet":"Vrancea","total":2845}
    ];

    createChart(jsonData, currentChartType);

    window.setChartType = function(chartType) {
        currentChartType = chartType;
        const judet1 = document.getElementById('judet1').value;
        const judet2 = document.getElementById('judet2').value;

        const filteredData = jsonData.filter(row => row.judet === judet1 || row.judet === judet2);

        myChart.destroy();
        createChart(filteredData, currentChartType);
    }

    function createChart(data, type) {
        myChart = new Chart(ctx, {
            type: type,
            data: {
                labels: data.map(row => row.judet),
                datasets: [{
                    label: 'Total',
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

    document.getElementById('load-countries').addEventListener('click', function() {
        const judet1 = document.getElementById('judet1').value;
        const judet2 = document.getElementById('judet2').value;

        const filteredData = jsonData.filter(row => row.judet === judet1 || row.judet === judet2);

        myChart.destroy();
        createChart(filteredData, currentChartType);
    });
});