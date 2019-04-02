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
            hidden: false,
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
            hidden: true,
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
            fontColor: '#000',
            fontSize: 22
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                     userCallback: function(label, index, labels) {
                     // when the floored value is the same as the value we have a whole number
                     if (Math.floor(label) === label) {
                         return label;
                     }

                 },
                }
            }]
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
                text: <?php 
                    if(isset($_POST['btn_action']) AND isset($_POST['empl_id'])){
                        echo '\'Selected Employee Stats\'';
                    }else{
                       echo '\'Your Stats\'';
                    }
                    ?>,
                fontColor: '#000',
                fontSize: 22
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
            }
        }
    });
</script>
















