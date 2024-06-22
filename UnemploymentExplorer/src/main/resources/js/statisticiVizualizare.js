import * as gen from './statisticiGenerare.js';

document.addEventListener('DOMContentLoaded', function() {
    Promise.all([
        gen.generareSelectJudet(),
        gen.generareNivelEducatie(),
        gen.generareGrupariVarsta(),
        gen.generareGenuri(),
        gen.generareMediu()
    ]).then(() => {
        console.log("All promises resolved");

        
        // Initial chart
        console.log("Window onload called");
        updateChart();


    }).catch((error) => {
        console.error(error);
    });

    let myChart;

    const colors = {
        2022: 'rgba(75, 192, 192, 0.2)',
        2023: 'rgba(54, 162, 235, 0.2)',
        2024: 'rgba(255, 206, 86, 0.2)'
    };

    const borderColors = {
        2022: 'rgba(75, 192, 192, 1)',
        2023: 'rgba(54, 162, 235, 1)',
        2024: 'rgba(255, 206, 86, 1)'
    };


    function createChart(data, type, xAxis = 'luni', yAxis = 'nr_someri') {
        let labels, datasets;

        switch (xAxis) {
            case 'luni':
                console.log("Luni");
                console.log(data);
                console.log(data.map(row => row.luna));
                labels = [...new Set(data.map(row => row.luna))];
                datasets = Object.keys(data.reduce((acc, row) => {
                    if (!acc[row.an]) acc[row.an] = [];
                    acc[row.an].push(row);
                    return acc;
                }, {})).map(year => {
                    const dataForYear = data.filter(item => item.an === parseInt(year)); // asigură-te că year este tratat ca număr întreg
                    return {
                        label: `Anul ${year}`,
                        data: labels.map(luna => {
                            const dataForLuna = dataForYear.find(item => item.luna === luna);
                            return dataForLuna ? dataForLuna[yAxis] : 0; // returnează valoarea dorită sau 0 dacă nu există
                        }),
                        backgroundColor: colors[year],
                        borderColor: borderColors[year],
                        borderWidth: 1,
                        group: year // setează grupul pentru a grupa barele pe aceeași categorie de axă X
                    };
                });
                
                break;

            case 'ani':
                labels = data.map(row => row.an);
                datasets = [{
                    label: 'Numărul șomerilor',
                    data: data.map(row => row.nr_someri),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }];
                break;

            case 'sex':
                labels = ['Feminin', 'Masculin'];
                datasets = data.map(row => ({
                    label: `Anul ${row.an}`,
                    data: [row.feminin, row.masculin],
                    backgroundColor: colors[row.an],
                    borderColor: borderColors[row.an],
                    borderWidth: 1
                }));
                break;

            case 'educatie':
                labels = ['Fără', 'Primar', 'Gimnazial', 'Liceal', 'Postliceal', 'Profesional', 'Universitar'];
                datasets = data.map(row => ({
                    label: `Anul ${row.an}`,
                    data: [row.fara, row.primar, row.gimnazial, row.liceal, row.postliceal, row.profesional, row.universitar],
                    backgroundColor: colors[row.an],
                    borderColor: borderColors[row.an],
                    borderWidth: 1
                }));
                break;

            case 'mediu':
                labels = ['Urban', 'Rural'];
                datasets = data.map(row => ({
                    label: `Anul ${row.an}`,
                    data: [row.urban, row.rural],
                    backgroundColor: colors[row.an],
                    borderColor: borderColors[row.an],
                    borderWidth: 1
                }));
                break;

            case 'varsta':
                labels = ['sub25', 'intre25si29', 'intre30si39', 'intre40si49', 'intre50si55', 'peste55'];
                datasets = data.map(row => ({
                    label: `Anul ${row.an}`,
                    data: [row.sub25, row.intre25si29, row.intre30si39, row.intre40si49, row.intre50si55, row.peste55],
                    backgroundColor: colors[row.an],
                    borderColor: borderColors[row.an],
                    borderWidth: 1
                }));
                break;

            default:
                labels = [];
                datasets = [];
                break;
        }

        const ctx = document.getElementById('myChart').getContext('2d');

        if (myChart) {
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                scales: {
                    x: {
                    
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false
            }
        });
    }

    window.updateChart = function() {
        console.log("updateChart called");
        const xAxis = document.getElementById('x-axis-select').value;
        const yAxis = document.getElementById('y-axis-select').value;
        console.log("xAxis:", xAxis);
        console.log("yAxis:", yAxis);
        postParamCheck().then(selectedData => {
            console.log("Selected data:", selectedData);
            createChart(selectedData, 'bar', xAxis, yAxis);
        });
    };
    
    window.setChartType = function(type) {
        console.log("setChartType called");
        console.log("Type:", type);
        const xAxis = document.getElementById('x-axis-select').value;
        const yAxis = document.getElementById('y-axis-select').value;
        console.log("xAxis:", xAxis);
        console.log("yAxis:", yAxis);
        postParamCheck().then(selectedData => {
            createChart(selectedData, type, xAxis, yAxis);
        });
    };

        

    
});





document.getElementById('filterButton').addEventListener('click', postParamCheck);

    async function getPHPConnStatus() {
        const response = await fetch('./php/repository/connectionFactory.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        });
        const data = await response.text();
        console.log(data);
    }

    function performAjaxCall() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '../php/repository/testService.php',
                type: 'POST',
                data: {
                    judet: document.getElementById('judet').value, // Assuming these values are defined similarly
                    educatie: document.getElementById('educatie').value,
                    mediu: document.getElementById('mediu').value,
                    sex: document.getElementById('gen').value,
                    varsta: document.getElementById('varsta').value,
                    perioadaDeTimpStart: document.getElementById('perioadaDeTimpStart').value,
                    perioadaDeTimpEnd: document.getElementById('perioadaDeTimpEnd').value,
                    rata: "total",
                    xAxis: document.getElementById('x-axis-select').value,
                    yAxis: document.getElementById('y-axis-select').value,
                },
                success: function(response) {
                    console.log(response);
                    resolve(response); // Resolve the promise with the response
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                    reject(xhr); // Reject the promise
                }
            });
        });
    }
    
    // Step 2: Use async/await to wait for the AJAX call to complete
    async function postParamCheck() {
        try {
            const response = await performAjaxCall(); // Wait for the AJAX call to complete
            console.log(response);
            return JSON.parse(response);
        } catch (error) {
            console.error("AJAX call failed: ", error);
        }
    }