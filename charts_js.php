<?php
//charts_js.php
?>

<script>
var ctx = document.getElementById('check_by_site').getContext('2d');
var check_by_site = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo checkouts_by_site_names($connect); ?>],
        datasets: [{
            label: 'Today',
            hidden: true,
            data: [<?php echo checkouts_by_site_num_checkouts_today($connect); ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        },{
            label: 'This Week',
            hidden: false,
            data: [<?php echo checkouts_by_site_num_checkouts_week($connect); ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        },{
            label: 'This Month',
            hidden: true,
            data: [<?php echo checkouts_by_site_num_checkouts_month($connect); ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        },{
            label: 'End of Time',
            hidden: true,
            data: [<?php echo checkouts_by_site_num_checkouts($connect); ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        title: {
            display: true,
            text: 'Checkouts By Site',
            fontColor: 'black',
            fontSize: 18
        },
        legend: {
            position: 'bottom',
            labels: {
                fontColor: 'rgba(54, 162, 255, 1)',
                boxWidth: 0,
                fontStyle: 'bold',
                padding: 3
            }
        },
        scales: {
            xAxes: [{
                barPercentage: 1.25,
                ticks:{
                    fontSize: 10
                }
            }],
            yAxes: [{
                ticks: {
                    fontSize: 8,
                    beginAtZero: true,
                     userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }

                 },
                }
            }]
        },
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: -13,
                bottom: -12
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeOutElastic'
        }
    }
});

var emp = document.getElementById('empl_stat').getContext('2d');
var check_by_empl = new Chart(emp, {
    type: 'bar',
    data: {
        labels: ['Checkouts', 'Returns'],
        datasets: [{
            label: <?php 
                if(isset($_POST['btn_action']) AND isset($_POST['empl_id'])){
                    echo '\'Selected Employee\'';
                }else{
                   echo '\'You\'';
                }
                ?>,
            data: [<?php 
                if(isset($_POST['btn_action']) AND isset($_POST['empl_id'])){
                    echo user_wise_num_checkouts($connect, $_POST['empl_id']).','.user_wise_num_checkins($connect, $_POST['empl_id']);
                }else{
                   echo user_wise_num_checkouts($connect, $_SESSION['user_id']).','.user_wise_num_checkins($connect, $_SESSION['user_id']);
            }?>],
                
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 1
        },{
            label: 'All Employees',
            data: [<?php 
                   echo num_checkouts($connect).','.num_returned($connect);
                ?>],
            backgroundColor: [
                'rgba(153, 102, 255, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(153, 102, 255, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        events: ['click'],
        title: {
            display: true,
            text: <?php 
                if(isset($_POST['btn_action']) AND isset($_POST['empl_id'])){
                    echo '\'Selected Employee Stats\'';
                }else{
                   echo '\'Your Stats\'';
                }
                ?>,
            fontColor: 'black',
            fontSize: 18
        },
        legend: {
            position: 'right',
            labels: {
                boxWidth: 18,
                fontColor: 'rgba(54, 162, 255, 1)',
                fontSize: 13,
                fontStyle: 'bold',
                padding: 15
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number. This gets rid of decimals. (Users cant check out .5 of an item, so this is required)
                     if (Math.floor(label) === label) {
                         return label;
                     }

                 },
                }
            }]
        },
        layout: {
            padding: {
                left: -2,
                right: -10,
                top: -5,
                bottom: -9 
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeOutElastic'
        }
    }
});

new Chart(document.getElementById("equip_cost_pie").getContext('2d'), {
    type: 'pie',
    data: {
      labels: ["Under $100", "$100-$999", "$1k-$4,999", "$5k-$9,999", "$10k+"],
      datasets: [
        {
            label: "Population (millions)",
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(0, 225, 90, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(0, 225, 90, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            data: [<?php 
                echo equip_price_range_Under100($connect).','.
                equip_price_range_100To999($connect).','.
                equip_price_range_1000To4999($connect).','.
                equip_price_range_5000To9999($connect).','.
                equip_price_range_Over10000($connect)
            ;?>]
        }
      ]
    },
    options: {
        title: {
            display: true,
            text: 'Equipment Cost Visualized',
            fontColor: 'black',
            fontSize: 16
        },
        legend: {
            position: 'right',
            labels: {
                boxWidth: 15,
                fontColor: 'rgba(54, 162, 255, 1)',
                fontSize: 13,
                fontStyle: 'bold',
                padding: 5
            }
        },
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: -12,
                bottom: 0 
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeOutBack'
        }
    }
});

//Checkouts By Month (Line Chart) for Equipment stats (stats.php#equipment)
new Chart(document.getElementById("equip_monthly_checkouts"), {
    type: 'line',
    data: {
        labels: [<?php echo equip_monthly_checkouts_line_graph_labels($connect); ?>],
        datasets: [{ 
            data: [<?php echo equip_monthly_checkouts_line_graph_data($connect); ?>],
            label: "Checkouts",
            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
            borderColor: ['rgba(255, 99, 132, 1)'],
            fill: true
        }]
    },
    options: {
        title: {
            display: true,
            text: 'Checkouts By Month',
            fontSize: 16,
            fontColor: 'black',
        },
        legend: {
            position: 'top',
            labels: {
                boxWidth: 15,
                fontColor: 'rgba(54, 162, 255, 1)',
                fontSize: 13,
                fontStyle: 'bold',
                padding: -5
            }
        },
        layout: {
            padding: {
                left: -8,
                right: 0,
                top: 0,
                bottom: 0 
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeOutBounce'
        }
    }
});
</script>
















