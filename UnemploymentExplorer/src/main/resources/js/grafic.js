document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Total șomeri', 'Femei', 'Bărbați', 'Șomeri indemizați', 'Rata șomajului (%)', 'Rata șomajului feminină (%)','Rata șomajului masculină (%)'],
        datasets: [{
          label: 'Numărul de șomeri din Alba',
          data: [5533, 2698, 2835, 1975, 3558, 3, 3, 3],
          borderWidth: 1
        },
        {
            label: 'Numărul de șomeri din Arad',
            data: [2623, 1352, 1271, 981, 1642, 1, 1, 1],
            borderWidth: 1
          },
          {
            label: 'Numărul de șomeri din Iași',
            data: [8728, 3763, 4965, 1126, 7602, 3, 2, 3],
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
