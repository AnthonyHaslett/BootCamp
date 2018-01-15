<!DOCTYPE html>
<html lang="en-US">
<?php require_once('DatabaseConnection.php')?>
<?php
$database = new DatabaseConnection();
//$values =$database->getConncetion()->prepare("SELECT COUNT(`attended`) FROM event_yp WHERE `attended`=1");
$values =$database->getConncetion()->prepare("SELECT id_participants, SUM(attended) AS attendedCount
FROM event_participants, event_overview, event_yp
WHERE event_participants.id_participants = event_yp.id_yp
AND event_overview.id_event = event_participants.id_event
AND event_yp.attended = 1
AND YEAR(date)=2017
GROUP BY (id_participants)
HAVING attendedCount >=1 AND attendedCount <=5
order by(id_participants);");
$values->execute();
$attended= $values->fetch()[0];
$values =$database->getConncetion()->prepare("SELECT id_participants, SUM(attended) AS attendedCount
FROM event_participants, event_overview, event_yp
WHERE event_participants.id_participants = event_yp.id_yp
AND event_overview.id_event = event_participants.id_event
AND event_yp.attended = 1
AND YEAR(date)=2017
GROUP BY (id_participants)
HAVING attendedCount >=1 AND attendedCount <=5
order by(id_participants);");
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

function year(select) {
    var chart = new String(select.options[select.selectedIndex].getAttribute("year"));
    //alert(select.options[select.selectedIndex].getAttribute("chart"));
    if (chart == "2017")
    {

    }
    else if(chart =="2016")
    {

    }
    else if(chart =="2015")
    {

    }

    else if(chart =="2014")
    {

    }

    else if(chart =="2013")
    {

    }




}


function month(select) {
    var chart = new String(select.options[select.selectedIndex].getAttribute("month"));
    //alert(select.options[select.selectedIndex].getAttribute("chart"));
    if (chart == "jan")
    {

    }
    else if(chart =="feb")
    {

    }
    else if(chart =="mar")
    {

    }
    else if(chart =="apr")
    {

    }
    else if(chart =="may")
    {

    }
    else if(chart =="jun")
    {

    }
    else if(chart =="jul")
    {

    }
    else if(chart =="aug")
    {

    }
    else if(chart =="sep")
    {

    }
    else if(chart =="oct")
    {

    }
    else if(chart =="nov")
    {

    }
    else if(chart =="dec")
    {

    }

}


</script>
<!--Create buttons that call the methods for drawing each chart-->
<select onchange=decide(this)>
    <option chart="">Select attendance chart</option>
    <option chart="attendance">Attendance chart</option>
    <option chart="attendancePie">Attendance pie chart</option>
</select>

<select onchange=decide(this)>
    <option chart="">Select attendee chart</option>
    <option chart="attendee">Attendee chart</option>
    <option chart="attendeePie">Attendee pie chart</option>
</select>
<br>
<select onchange=decide(this)>
    <option month="jan">January</option>
    <option month="feb">February</option>
    <option month="mar">March</option>
    <option month="apr">April</option>
    <option month="may">May</option>
    <option month="jun">June</option>
    <option month="jul">July</option>
    <option month="aug">August</option>
    <option month="sep">September</option>
    <option month="oct">October</option>
    <option month="nov">November</option>
    <option month="dec">December</option>
</select>

<select onchange=decide(this)>
    <option year="2014">2014</option>
    <option year="2015">2015</option>
    <option year="2016">2016</option>
    <option year="2017">2017</option>
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
</script>

</body>
</html>
