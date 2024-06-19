document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'polarArea',
      data: {
        labels: ['Total șomeri', 'Femei', 'Bărbați', 'Din mediul urban', 'Femei din urban', 'Bărbați din urban','Din mediul rural','Femei din mediul rural','Bărbați din mediul rural'],
        datasets: [{
          label: 'Brașov',
          data: [6531, 3113, 3418, 1733, 960, 733, 4798, 2153,2645],
          borderWidth: 1
        },
        {
            label: 'Gorj',
            data: [3984, 2007, 1977, 1127, 674, 453, 2857, 1333,1524],
            borderWidth: 1
          },
          {
            label: 'Iași',
            data: [8728, 3763, 4965, 1219, 633, 586, 7509, 3130,4379],
            borderWidth: 1
          }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }

      }
    });
});
