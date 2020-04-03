<canvas id="myChart" width="400" height="250"></canvas>
<script>
  $(function () {
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
      // type: 'horizontalBar',
      type: 'bar',
      data: {
        labels: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
        datasets: <?= $datasets ?>
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: "<?= $title ?>"
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true,
              stacked: true,
              callback: function (value, index, values) {
                return value + '%';
              }
            }
          }]
        }
      }
    });
  });
</script>
