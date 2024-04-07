<script src="node_modules/@popperjs/core/dist/umd/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="node_modules/chart.js/dist/chart.umd.js"></script>
<script src="public/script.js"></script>
<script>
function updateConfigByMutating(chart, data) {
    chart.data.datasets[0].data = data;
    chart.update();
}
  const jumlah_kas = <?= $data['jumlahPerBulan'] ?>;
  console.log(jumlah_kas)
  const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
    ];
  const data = {
  labels: labels,
  datasets: [{
      label: 'Jumlah uang kas (Rp)',
      data: jumlah_kas['2024'],
      fill: false,
      borderColor: 'teal',
      backgroundColor: 'teal',
      hoverBackgroundColor: 'thistle',
      tension: 0.1
  }]
  };
  const config = {
  type: 'line',
  data: data,
  options: {
      plugins: {
          title: {
              display: true,
              text: 'Jumlah Penarikan Uang Kas Bulanan'
          },
          legend: {
              position: 'bottom'
          }
      }
  }
  };
  document.addEventListener('click', (event) => {
    if (event.target.classList.contains('dropdown-item')) {
        updateConfigByMutating(myChart, jumlah_kas[event.target.dataset.tahun]);
    }
  });
  var myChart = new Chart(document.getElementById('myChart'), config);

</script>