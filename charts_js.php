<?php
//charts_js.php
?>


<script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Equipment Usage (Per-Site)"
      },
      data: [{
        dataPoints: [<?php echo checkouts_by_site($connect); ?>]
      }]
    });

    chart.render();
  }
  </script>
















