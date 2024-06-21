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
    
    window.updateChart = function() {
        const xAxis = document.getElementById('x-axis-select').value;
        const yAxis = document.getElementById('y-axis-select').value;
        myChart.destroy();
        createChart(jsonData, myChart.config.type, xAxis, yAxis);
    }

 
    function createChart(data, type, xAxis = 'month', yAxis = 'income') {
        myChart = new Chart(ctx, {
            type: type,
            data: {
                labels: data.map(row => row[xAxis]),
                datasets: [{
                    label: yAxis,
                    data: data.map(row => row[yAxis]),
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
    
    var judet = document.getElementById('judet').value;
    var educatie = document.getElementById('educatie').value;
    var varsta = document.getElementById('varsta').value;
    var sex = document.getElementById('gen').value;
    var mediu = document.getElementById('mediu').value;
    var perioadaDeTimpStart = document.getElementById('perioadaDeTimpStart').value;
    var perioadaDeTimpEnd = document.getElementById('perioadaDeTimpEnd').value;
    var VenitStart = document.getElementById('VenitStart').value;
    var VenitEnd = document.getElementById('VenitEnd').value;
    var rataStart = document.getElementById('RataSomajStart').value;
    var rataEnd = document.getElementById('RataSomajEnd').value;
    // var grafType = document.getElementById('grafType').value;

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

