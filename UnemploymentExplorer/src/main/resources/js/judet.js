document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Total șomeri', 'Fără studii', 'Invățământ primar', 'Învățământ gimnazial', 'Învățământ liceal', 'Învățământ postliceal','Învățământ profesional','Învățământ universitar'],
        datasets: [{
          label: 'Bihor',
          data: [4064, 435, 1068, 1074, 639, 60, 442, 346],
          borderWidth: 1
        },
        {
            label: 'Cluj',
            data: [4728, 767, 847, 1188, 703, 107, 679, 437],
            borderWidth: 1
          },
          {
            label: 'Iași',
            data: [8728, 468, 1919, 3043, 790, 64, 2138, 306],
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
