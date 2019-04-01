<?php
//charts_js.php
?>

Still working on this!
<script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Equipment Usage"
      },
      data: [

      {
        dataPoints: [
        { x: 1, y: 297571, label: "Dynamically"},
        { x: 2, y: 267017,  label: "Assign" },
        { x: 3, y: 175200,  label: "Highest"},
        { x: 4, y: 154580,  label: "Value"},
        { x: 5, y: 116000,  label: "Equipment"},
        { x: 6, y: 97800, label: "Right"},
        { x: 7, y: 20682,  label: "Here"},
        { x: 8, y: 20350,  label: "(Somehow)"}
        ]
      }
      ]
    });

    chart.render();
  }
  </script>
















