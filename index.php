<!DOCTYPE html>

<html lang="en-US">
<body>

<h1>My Web Page</h1>

<div id="barChart"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Individuals Attending'],
            ['Attended', 8],
            ['Unattended', 2]
        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'My Average Day', 'width':900, 'height':900};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.ColumnChart(document.getElementById('barChart'));
        chart.draw(data, options);
    }
</script>
</body>
</html>
<?php
    $database = new DatabaseConnection();
    $values =$database->getConncetion()->prepare("SELECT * FROM Attendance");
    $values->execute();
    print_r($values->fetchAll());
?>
