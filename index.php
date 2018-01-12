<!DOCTYPE html>
<html lang="en-US">
<?php require_once('DatabaseConnection.php')?>
<?php
$database = new DatabaseConnection();
$values =$database->getConncetion()->prepare("SELECT `Attended` FROM Attendance");
$values->execute();
$attended= $values->fetch()[0];
$values =$database->getConncetion()->prepare("SELECT `Unattended` FROM Attendance");
$values->execute();
$unAttended = $values->fetch()[0];
?>

<body>

<h1>Graphical Statistics</h1>



<!--Create buttons that call the methods for drawing each chart-->
<button onclick="drawAttendanceChart()">Attendance chart</button>
<button onclick="drawAttendeeChart()">Attendee chart</button>

<div id="barChart"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load google charts


    google.charts.load('current', {'packages':['corechart']});
    // google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values for the attendance chart
    function drawAttendanceChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Attended', 'Not attending'],

            ['Attended',  <?php echo $attended?>, 0],
            ['Unattended', '0', <?php echo $unAttended?> ]


        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Event Attendance ',
            'width':900,
            'height':900,
            isStacked: true
        };


        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.ColumnChart(document.getElementById('barChart'));
        chart.draw(data, options);

        //Filtering buttons
//        var btn1 = document.createElement("BUTTON");
//        btn1.innerHTML = "pie chart";
//        document.body.appendChild(btn1);
//     //   btn1.addEventListener ("click", drawAttendancePieChart());
    }


    // Draw the chart and set the chart values for the attendee chart
    function drawAttendeeChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Boys', 'Girls'],
            ['Under 14s', 2, 3],
            ['Over 14s', 1, 3]



        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Attendees ', isStacked: true, 'width':900, 'height':900};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.ColumnChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }
</script>

</body>
</html>
