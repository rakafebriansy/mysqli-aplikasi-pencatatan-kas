<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="node_modules/chart.js/dist/chart.umd.js"></script>
<script src="public/script.js"></script>
<script>
    //LINE CHART
    const jumlah_kas = <?= $data['jumlahPerBulan'] ?>;
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
        data: jumlah_kas,
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

    var myChart = new Chart(document.getElementById('myChart'), config);

</script>
</body>
</html>