document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('myChart').getContext('2d');
    let myChart;

    const ianuarie = [
        {"judet":"Alba","total":5735},
        {"judet":"Arad","total":2335},
        {"judet":"Argeș","total":8375},
        {"judet":"Bacău","total":5233},
        {"judet":"Bihor","total":3469},
        {"judet":"Bistrița-Năsăud","total":4384},
        {"judet":"Botoșani","total":3792},
        {"judet":"Brăila","total":3756},
        {"judet":"Brașov","total":6368},
        {"judet":"Buzău","total":8112},
        {"judet":"Călărași","total":4103},
        {"judet":"Caraș-Severin","total":2652},
        {"judet":"Cluj","total":4509},
        {"judet":"Constanța","total":6056},
        {"judet":"Covasna","total":3369},
        {"judet":"Dâmbovița","total":4651},
        {"judet":"Dolj","total":16868},
        {"judet":"Galați","total":8852},
        {"judet":"Giurgiu","total":2156},
        {"judet":"Gorj","total":3960},
        {"judet":"Hargita","total":5246},
        {"judet":"Hunedoara","total":7275},
        {"judet":"Ialomița","total":4066},
        {"judet":"Iași","total":8245},
        {"judet":"Ilfov","total":1001},
        {"judet":"Maramureș","total":4494},
        {"judet":"Mehedinți","total":6188},
        {"judet":"București","total":10802},
        {"judet":"Mureș","total":6834},
        {"judet":"Neamț","total":6396},
        {"judet":"Olt","total":7370},
        {"judet":"Prahova","total":6331},
        {"judet":"Sălaj","total":5123},
        {"judet":"Satu-Mare","total":5360},
        {"judet":"Sibiu","total":4283},
        {"judet":"Suceava","total":11571},
        {"judet":"Teleorman","total":8058},
        {"judet":"Timiș","total":2615},
        {"judet":"Tulcea","total":2597},
        {"judet":"Vâlcea","total":5421},
        {"judet":"Vaslui","total":8864},
        {"judet":"Vrancea","total":2967}
    ];

    const februarie = [
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

    const martie = [
        {"judet":"Alba","total":5320},
        {"judet":"Arad","total":2814},
        {"judet":"Argeș","total":8385},
        {"judet":"Bacău","total":5614},
        {"judet":"Bihor","total":4475},
        {"judet":"Bistrița-Năsăud","total":4607},
        {"judet":"Botoșani","total":4788},
        {"judet":"Brăila","total":4178},
        {"judet":"Brașov","total":6467},
        {"judet":"Buzău","total":7668},
        {"judet":"Călărași","total":4080},
        {"judet":"Caraș-Severin","total":2922},
        {"judet":"Cluj","total":4904},
        {"judet":"Constanța","total":5602},
        {"judet":"Covasna","total":3234},
        {"judet":"Dâmbovița","total":4985},
        {"judet":"Dolj","total":19664},
        {"judet":"Galați","total":8664},
        {"judet":"Giurgiu","total":2200},
        {"judet":"Gorj","total":4080},
        {"judet":"Hargita","total":5653},
        {"judet":"Hunedoara","total":7579},
        {"judet":"Ialomița","total":4197},
        {"judet":"Iași","total":9400},
        {"judet":"Ilfov","total":1024},
        {"judet":"Maramureș","total":4445},
        {"judet":"Mehedinți","total":6632},
        {"judet":"București","total":10611},
        {"judet":"Mureș","total":7665},
        {"judet":"Neamț","total":8126},
        {"judet":"Olt","total":7543},
        {"judet":"Prahova","total":6678},
        {"judet":"Sălaj","total":5081},
        {"judet":"Satu-Mare","total":12107},
        {"judet":"Sibiu","total":9452},
        {"judet":"Suceava","total":2904},
        {"judet":"Teleorman","total":2580},
        {"judet":"Timiș","total":4287},
        {"judet":"Tulcea","total":9292},
        {"judet":"Vâlcea","total":2809},
        {"judet":"Vaslui","total":9004},
        {"judet":"Vrancea","total":2845}
    ];

    const aprilie = [
        {"judet":"Alba","total":4997},
        {"judet":"Arad","total":2829},
        {"judet":"Argeș","total":8197},
        {"judet":"Bacău","total":6208},
        {"judet":"Bihor","total":4703},
        {"judet":"Bistrița-Năsăud","total":5464},
        {"judet":"Botoșani","total":4585},
        {"judet":"Brăila","total":4252},
        {"judet":"Brașov","total":6395},
        {"judet":"Buzău","total":7350},
        {"judet":"Călărași","total":4103},
        {"judet":"Caraș-Severin","total":2883},
        {"judet":"Cluj","total":4864},
        {"judet":"Constanța","total":4731},
        {"judet":"Covasna","total":3103},
        {"judet":"Dâmbovița","total":5151},
        {"judet":"Dolj","total":18380},
        {"judet":"Galați","total":8414},
        {"judet":"Giurgiu","total":2070},
        {"judet":"Gorj","total":4086},
        {"judet":"Hargita","total":5571},
        {"judet":"Hunedoara","total":7513},
        {"judet":"Ialomița","total":4095},
        {"judet":"Iași","total":9731},
        {"judet":"Ilfov","total":1031},
        {"judet":"Maramureș","total":4361},
        {"judet":"Mehedinți","total":6663},
        {"judet":"București","total":10510},
        {"judet":"Mureș","total":7428},
        {"judet":"Neamț","total":8330},
        {"judet":"Olt","total":7415},
        {"judet":"Prahova","total":6644},
        {"judet":"Sălaj","total":5140},
        {"judet":"Satu-Mare","total":5789},
        {"judet":"Sibiu","total":4937},
        {"judet":"Suceava","total":11859},
        {"judet":"Teleorman","total":9572},
        {"judet":"Timiș","total":2910},
        {"judet":"Tulcea","total":2477},
        {"judet":"Vâlcea","total":3585},
        {"judet":"Vaslui","total":9383},
        {"judet":"Vrancea","total":2743}
    ];

    window.loadChartData = function(judet) {
        myChart.destroy();
        loadChartData(judet);
    };

    function loadChartData(judet) {
        let data;
        if (judet === 'ianuarie') {
            data = ianuarie;
        } else if (judet === 'februarie') {
            data = februarie;
        } else if (judet === 'martie') {
            data = martie;
        } else if (judet === 'aprilie') {
            data = aprilie;
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

    loadChartData('aprilie');
});
