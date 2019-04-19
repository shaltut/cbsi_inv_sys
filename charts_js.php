<?php
/*
    charts_js.php

    Implementation of the chartsJS API
*/
?> 
<script>

/* Bar chart showing the number of checkouts on a per-site basis
*   
*
*/
new Chart(document.getElementById("check_by_site"), {
    type: 'bar',
    data: {
        labels: [
            <?php 
                //Returns a CSV string of all active site's names
                echo checkouts_by_site_names($connect); 
            ?>
        ],
        datasets: [
        {
            label: 'Today',
            hidden: true,
            data: [
                <?php 
                    //Returns CSV string of all checkouts for each site that took place on the current system date
                    echo checkouts_by_site_num_checkouts_today($connect); 
                ?>
            ],
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
        }
        ,{
            label: 'This Week',
            hidden: false,
            data: [
                <?php 
                    //Returns CSV string of all checkouts for each site that took place in the last week
                    echo checkouts_by_site_num_checkouts_week($connect); 
                ?>
            ],
            data: [2,6,5,6,2,1],
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
        },
        {
            label: 'This Month',
            hidden: true,
            data: [
                <?php 
                    //Returns CSV string of all checkouts for each site that took place in the last month
                    echo checkouts_by_site_num_checkouts_month($connect); 
                ?>
            ],
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
        }
        ,
        {
            label: 'End of Time',
            hidden: true,
            data: [
                <?php 
                    //Returns CSV string of all checkouts for each site (end of time)
                    echo checkouts_by_site_num_checkouts($connect); 
                ?>
            ],
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
    }
    ,options: {
        //Options for the title
        title: {
            display: true,
            text: 'Checkouts By Site',
            fontColor: 'black',
            fontSize: 18
        },
        //Options for the legend
        legend: {
            position: 'bottom',
            labels: {
                fontColor: 'rgba(54, 162, 255, 1)',
                boxWidth: 0,
                fontStyle: 'bold',
                padding: 3
            }
        },
        // Options for the numbers on the left side of the bar chart
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
                    }
                }
            }]
        },
        // Positioning opitons
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: -13,
                bottom: -12
            }
        },
        //  Display animations (on page load)
        animation: {
            duration: 1500,
            easing: 'easeOutElastic'
        }
    }
});

/*  Bar Chart that receives a user_id as input and returns the number of checkouts and returns for that user. Default user is the currently logged in user_id session variable
*
*
*/
new Chart(document.getElementById("empl_stat"), {
    type: 'bar',
    data: {
        labels: ['Checkouts', 'Returns'],
        datasets: [{
            label: 
                <?php 
                    //Changes the title of the graph depending on the input
                    if(isset($_POST['btn_action']) AND isset($_POST['empl_id'])){
                        echo '\'Selected Employee\'';
                    }else{
                       echo '\'You\'';
                    }
                ?>,
            data: [
                <?php 
                    //Changes the chart data depending on the inputs
                    if(isset($_POST['btn_action']) AND isset($_POST['empl_id'])){
                        echo user_wise_num_checkouts($connect, $_POST['empl_id']).','.user_wise_num_checkins($connect, $_POST['empl_id']);
                    }else{
                       echo user_wise_num_checkouts($connect, $_SESSION['user_id']).','.user_wise_num_checkins($connect, $_SESSION['user_id']);
                    }
                ?>
            ],
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
            data: [
                <?php 
                    echo num_checkouts($connect).','.num_returned($connect);
                ?>
            ],
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
                    // Makes sure the ticks start at 0
                    beginAtZero: true,
                    //Function makes sure that only whole numbers are used for ticks
                    userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number. This gets rid of decimals. (Users cant check out .5 of an item, so this is required)
                     if (Math.floor(label) === label) {
                         return label;
                     }

                 },
                }
            }]
        },
        //Layout options
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

/*  Pie Chart showing the price of equipment in 5 different categories. 
*
*
*/
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

/*  Line Graph showing checkouts by month. Each month, a new bar will be added.
*
*
*/
new Chart(document.getElementById("equip_monthly_checkouts"), {
    type: 'line',
    data: {
        labels: [<?php echo equip_monthly_checkouts_line_graph_labels($connect); ?>],
        datasets: [{ 
            data: [<?php echo equip_monthly_checkouts_line_graph_data($connect); ?>],
            label: "Checkouts",
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            pointBackgroundColor: 'rgba(153, 102, 255, .8)',
            borderColor: 'rgba(255, 99, 132, 1)',
            fill: true,
            lineTension: .3,
            pointRadius: 8,
            pointStyle: 'rectRounded',
            borderWidth: 3,
            pointBorderWidth: 0,
            pointHoverBackgroundColor: 'rgba(153, 102, 255, .7)',
            pointHoverRadius: 20,
            pointHoverBorderWidth: 0,
            pointHoverBorderColor: 'rgba(153, 102, 255, .3)'

        }],
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
                padding: -5,
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