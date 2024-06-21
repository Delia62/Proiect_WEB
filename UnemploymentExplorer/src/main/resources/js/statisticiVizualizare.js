import * as gen from './statisticiGenerare.js';

document.addEventListener('DOMContentLoaded', function() {
    gen.generareSelectJudet();
    gen.generareNivelEducatie();
    gen.generareGrupariVarsta();
    gen.generareGenuri();
    gen.generareMediu();

    const ctx = document.getElementById('myChart').getContext('2d');
    let myChart;

    const jsonData = [
        {"nr_someri": 198, "luna": "ianuarie", "an": 2022},
        {"nr_someri": 193, "luna": "februarie", "an": 2022},
        {"nr_someri": 193, "luna": "martie", "an": 2022},
        {"nr_someri": 180, "luna": "aprilie", "an": 2022},
        {"nr_someri": 180, "luna": "mai", "an": 2022},
        {"nr_someri": 184, "luna": "iunie", "an": 2022},
        {"nr_someri": 166, "luna": "iulie", "an": 2022},
        {"nr_someri": 177, "luna": "august", "an": 2022},
        {"nr_someri": 184, "luna": "septembrie", "an": 2022},
        {"nr_someri": 189, "luna": "octombrie", "an": 2022},
        {"nr_someri": 191, "luna": "noiembrie", "an": 2022},
        {"nr_someri": 190, "luna": "decembrie", "an": 2022},
        {"nr_someri": 219, "luna": "ianuarie", "an": 2023},
        {"nr_someri": 188, "luna": "februarie", "an": 2023},
        {"nr_someri": 190, "luna": "martie", "an": 2023},
        {"nr_someri": 177, "luna": "aprilie", "an": 2023},
        {"nr_someri": 164, "luna": "mai", "an": 2023},
        {"nr_someri": 161, "luna": "iunie", "an": 2023},
        {"nr_someri": 158, "luna": "iulie", "an": 2023},
        {"nr_someri": 163, "luna": "august", "an": 2023},
        {"nr_someri": 162, "luna": "septembrie", "an": 2023},
        {"nr_someri": 176, "luna": "octombrie", "an": 2023},
        {"nr_someri": 185, "luna": "noiembrie", "an": 2023},
        {"nr_someri": 177, "luna": "decembrie", "an": 2023}
    ];

    createChart(jsonData, 'bar');

    window.setChartType = function(chartType) {
        if (myChart) {
            myChart.destroy();
        }
        createChart(jsonData, chartType);
    }

    window.updateChart = function() {
        const xAxis = document.getElementById('x-axis-select').value;
        const yAxis = document.getElementById('y-axis-select').value;
        if (myChart) {
            myChart.destroy();
        }
        createChart(jsonData, myChart.config.type, xAxis, yAxis);
    }

    function createChart(data, type, xAxis = 'luna', yAxis = 'nr_someri') {
        const groupedData = data.reduce((acc, row) => {
            const year = row.an;
            if (!acc[year]) acc[year] = [];
            acc[year].push(row);
            return acc;
        }, {});

        const colors = {
            2022: 'rgba(75, 192, 192, 0.2)',
            2023: 'rgba(153, 102, 255, 0.2)',
            // Adaugă mai multe culori pentru anii următori, dacă este necesar
        };

        const borderColors = {
            2022: 'rgba(75, 192, 192, 1)',
            2023: 'rgba(153, 102, 255, 1)',
            // Adaugă mai multe culori pentru anii următori, dacă este necesar
        };

        const datasets = Object.keys(groupedData).map(year => ({
            label: `Anul ${year}`,
            data: groupedData[year].map(row => row[yAxis]),
            backgroundColor: colors[year],
            borderColor: borderColors[year],
            borderWidth: 1
        }));

        myChart = new Chart(ctx, {
            type: type,
            data: {
                labels: [...new Set(data.map(row => row[xAxis]))],
                datasets: datasets
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

document.getElementById('filterButton').addEventListener('click', postParamCheck);

export const getPHPConnStatus = async () => {
    const response = await fetch('./php/repository/connectionFactory.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    });
    const data = await response.text();
    console.log(data);
}

export function postParamCheck() {
    const judet = document.getElementById('judet').value;
    const educatie = document.getElementById('educatie').value;
    const varsta = document.getElementById('varsta').value;
    const sex = document.getElementById('gen').value;
    const mediu = document.getElementById('mediu').value;
    const perioadaDeTimpStart = document.getElementById('perioadaDeTimpStart').value;
    const perioadaDeTimpEnd = document.getElementById('perioadaDeTimpEnd').value;
    const VenitStart = document.getElementById('VenitStart').value;
    const VenitEnd = document.getElementById('VenitEnd').value;
    const rataStart = document.getElementById('RataSomajStart').value;
    const rataEnd = document.getElementById('RataSomajEnd').value;

    // Send data to seePOSTvals.php for debugging
    $.ajax({
        url: '../php/repository/testService.php',
        type: 'POST',
        data: {
            judet: judet,
            educatie: educatie,
            mediu: mediu,
            sex: sex,
            varsta: varsta,
            perioadaDeTimpStart: perioadaDeTimpStart,
            perioadaDeTimpEnd: perioadaDeTimpEnd,
            rata: "total"
            // grafType: grafType
        },
        success: function(response) {
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        }
    });
}

