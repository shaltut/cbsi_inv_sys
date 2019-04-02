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
        type: 'radar',
        data: {
            labels: ['Check-outs', 'Check-ins', 'Sites'],
            datasets: [{
                label: 'Selected User',
                data: [15, 12, 18],
                backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Employee Stats',
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
</script>
















