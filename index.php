<!DOCTYPE html>
<html lang="en-US">
<?php require_once('DatabaseConnection.php')?>
<?php
$database = new DatabaseConnection();
$values =$database->getConncetion()->prepare("SELECT COUNT(`attended`) FROM event_yp WHERE `attended`=1");
$values->execute();
$attended= $values->fetch()[0];
$values =$database->getConncetion()->prepare("SELECT COUNT(`attended`) FROM event_yp WHERE `attended`=0");
$values->execute();
$unAttended = $values->fetch()[0];
?>

<body>

<h1>Graphical Statistics</h1>

<script>
    
function decide(select) {
    var chart = new String(select.options[select.selectedIndex].getAttribute("chart"));
    //alert(select.options[select.selectedIndex].getAttribute("chart"));
    if (chart == "attendance")
    {
        drawAttendanceChart();
    }
    else if(chart =="attendancePie")
    {
        drawAttendancePieChart()
    }
    else if(chart =="attendee")
    {
        drawAttendeeChart()
    }
    else if(chart =="attendeePie")
    {
        drawAttendeePieChart()
    }


}
</script>
<!--Create buttons that call the methods for drawing each chart-->
<select onchange=decide(this)>
    <option chart="attendance">Attendance chart</option>
    <option chart="attendancePie">Attendance pie chart</option>
</select>

<select onchange=decide(this)>
    <option chart="attendee">Attendee chart</option>
    <option chart="attendeePie">Attendee pie chart</option>
</select>
<!--<button onclick="drawAttendanceChart()">Attendance chart</button>-->
<!--<button onclick="drawAttendancePieChart()">Attendance Pie chart</button>-->
<!--<button onclick="drawAttendeeChart()">Attendee chart</button>-->
<!--<button onclick="drawAttendeePieChart()">Attendee Pie chart</button>-->

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

            ['Attended',  <?php echo $attended?>,  null],
            ['Unattended', null, <?php echo $unAttended?> ]


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
//        btn1.onclick = drawAttendancePieChart();
//        btn1.addEventListener ("click", drawAttendancePieChart());
    }


    function drawAttendancePieChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Attended', 'Not attending'],

            ['Attended',  <?php echo $attended?>,  null],
            ['Unattended', <?php echo $unAttended?>, null ]


        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Event Attendance '

        };


        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('barChart'));
        chart.draw(data, options);

        //Filtering buttons

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

    function drawAttendeePieChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Boys', 'Girls', 'under 14s', 'over 14s'],
            ['Under 14s', 5, null, null, null],
            ['Over 14s', 4, null, null, null],
            ['Boys', 3, null, null, null],
            ['Girls', 6, null, null, null]



        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Attendees ', isStacked: true, 'width':900, 'height':900};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }
</script>

</body>
</html>
