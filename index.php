<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
</head>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="iframe.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



<?php require_once('DatabaseConnection.php')?>
<?php
$database = new DatabaseConnection();
//$values =$database->getConncetion()->prepare("SELECT COUNT(`attended`) FROM event_yp WHERE `attended`=1");
$values =$database->getConncetion()->prepare("select sum(AttendanceCount) FROM (SELECT young_people.id_yp AS Particpant, COUNT(attended) AS AttendanceCount
FROM young_people, event_yp, event_overview
WHERE young_people.id_yp = event_yp.id_yp
AND event_yp.id_event = event_overview.id_event
AND attended=1 
AND YEAR(event_overview.date) = 2017
GROUP BY (young_people.id_yp)
HAVING AttendanceCount >= 1 AND AttendanceCount <=5
ORDER BY Particpant) AS sessions;");
$values->execute();
$attended= $values->fetch()[0];
$values =$database->getConncetion()->prepare("select sum(AttendanceCount) FROM (SELECT young_people.id_yp AS Particpant, COUNT(attended) AS AttendanceCount
FROM young_people, event_yp, event_overview
WHERE young_people.id_yp = event_yp.id_yp
AND event_yp.id_event = event_overview.id_event
AND attended=1
AND YEAR(event_overview.date) = 2016
GROUP BY (young_people.id_yp)
HAVING AttendanceCount >= 1 AND AttendanceCount <=5
ORDER BY Particpant) AS sessions;");;
$values->execute();
$unAttended = $values->fetch()[0];

$values =$database->getConncetion()->prepare("SELECT young_people.id_yp AS Particpant, count(attended) as AttendanceCount, COUNT(event_yp.id_event) as Event_Count
FROM young_people, event_yp, event_overview
WHERE young_people.id_yp = event_yp.id_yp
AND event_yp.id_event = event_overview.id_event
AND attended=1 
GROUP BY(young_people.id_yp)
HAVING AttendanceCount > 6
ORDER BY Particpant;");;
$values->execute();
$participant = $values->fetch()[0];

$values =$database->getConncetion()->prepare("SELECT  SUM(Sessions_Attended) AS Sessions
FROM(SELECT COUNT(young_people.id_yp) * COUNT(event_yp.id_event) AS Sessions_Attended, count(attended) as AttendanceCount
FROM young_people,event_yp, event_overview
WHERE  young_people.id_yp = event_yp.id_yp
AND event_yp.attended = 1
AND event_yp.id_eventyp = event_overview.id_event
group by (young_people.id_yp)
HAVING AttendanceCount > 6
ORDER BY Sessions_Attended) 

AS sessions;");;
$values->execute();
$sessions = $values->fetch()[0];

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
    else if(chart =="session")
    {
        drawSessionChart()
    }
    else if(chart =="sessionPie")
    {
        drawSessionPieChart()
    }

}




</script>


<div class="styled-select blue semi-square">
<select onchange=decide(this)>
    <option chart="">Select attendance chart</option>
    <option chart="attendance">Attendance chart</option>
    <option chart="attendancePie">Attendance pie chart</option>
</select>
</div>

<div class="styled-select blue semi-square">
<select onchange=decide(this)>
    <option chart="">Select attendee chart</option>
    <option chart="attendee">Attendee chart</option>
    <option chart="attendeePie">Attendee pie chart</option>
</select>
</div>

    <div class="styled-select blue semi-square">
<select onchange=decide(this)>
    <option chart="">Select Session attended chart</option>
    <option chart="session">Session attended chart</option>
    <option chart="sessionPie">Session attended pie chart</option>
</select>
    </div>


<!--<select onchange=decide(this)>-->
<!--    <option year="2014">2014</option>-->
<!--    <option year="2015">2015</option>-->
<!--    <option year="2016">2016</option>-->
<!--    <option year="2017">2017</option>-->
<!--</select>-->

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
            ['Type', '2016', '2017'],

            ['2016',  <?php echo $unAttended?>,  null],
            ['2017', null, <?php echo $participant?> ]


        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Engaged ',
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
            ['Type', '2016', '2017'],

            ['2016',  <?php echo $unAttended?>,  null],
            ['2017', <?php echo $attended?>, null ]


        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Event Attendance ',

            'width':900,
            'height':900

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

    function drawSessionChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', '2016', '2017'],

            ['2016',  <?php echo $unAttended?>,  null],
            ['2017', null, <?php echo $sessions?> ]


        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Sessions participated ',
            'width':900,
            'height':900,
            isStacked: true
        };


        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.ColumnChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }


    function drawSessionPieChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', '2016', '2017'],

            ['2016',  <?php echo $unAttended?>,  null],
            ['2017', <?php echo $sessions?>, null ]


        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Sessions participated ',

            'width':900,
            'height':900

        };


        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('barChart'));
        chart.draw(data, options);


    }

</script>

</body>
</html>
