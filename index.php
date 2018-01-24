<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

//=--------------------------------------

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


//-----------------------------------------------------------
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


//$values =$database->getConncetion()->prepare("SELECT  SUM(Sessions_Attended) AS Sessions
//FROM(SELECT COUNT(young_people.id_yp) * COUNT(event_yp.id_event) AS Sessions_Attended, count(attended) as AttendanceCount
//FROM young_people,event_yp, event_overview
//WHERE  young_people.id_yp = event_yp.id_yp
//AND event_yp.attended = 1
//AND event_yp.id_eventyp = event_overview.id_event
//group by (young_people.id_yp)
//HAVING AttendanceCount > 6
//ORDER BY Sessions_Attended)
//
//AS sessions;");;



$values =$database->getConncetion()->prepare("SELECT SUM(AttendanceCount) FROM (SELECT young_people.id_yp AS Particpant, COUNT(attended) as AttendanceCount
FROM young_people, event_yp
WHERE young_people.id_yp = event_yp.id_yp
AND attended=1 
group by young_people.id_yp
HAVING AttendanceCount >= 1 AND AttendanceCount <=5) AS AttendanceCount;");

$values->execute();
$sessions1 = $values->fetch()[0];
//--------------------------------------------------------

$values =$database->getConncetion()->prepare("select SUM(boys + girls) * COUNT(id_event) from event_participants
where id_cohort <= 5 AND id_cohort>=1;");

$values->execute();
$sessions2 = $values->fetch()[0];

//-----------------------------------------------------
$values =$database->getConncetion()->prepare("select SUM(boys + girls) from event_participants
where id_cohort >= 6;");
$values->execute();
$Participants = $values->fetch()[0];

//----------------------------------------
$values =$database->getConncetion()->prepare("SELECT SUM(AttendanceCount) FROM (SELECT young_people.id_yp AS Particpant, COUNT(attended) as AttendanceCount
FROM young_people, event_yp
WHERE young_people.id_yp = event_yp.id_yp
AND attended=1 
group by young_people.id_yp
HAVING AttendanceCount >= 6) AS AttendanceCount;");
$values->execute();
$youngPeople = $values->fetch()[0];

//---------------------------------------

$values =$database->getConncetion()->prepare("SELECT COUNT(event_yp.id_yp)
FROM event_yp, young_people
WHERE event_yp.id_yp = young_people.id_yp
AND  YEAR(CURDATE())- YEAR(dob) <= 14;");
$values->execute();
$youngUnder = $values->fetch()[0];

//---------------------------------------

$values =$database->getConncetion()->prepare("SELECT COUNT(event_yp.id_yp)
FROM event_yp, young_people
WHERE event_yp.id_yp = young_people.id_yp
AND  YEAR(CURDATE())- YEAR(dob) > 14;");
$values->execute();
$youngOver = $values->fetch()[0];
//-----------------------------------------
$values =$database->getConncetion()->prepare("SELECT SUM(boys) AS Boys_2017, SUM(girls) AS Girls_2017
FROM event_participants, event_overview
WHERE event_participants.id_event =  event_overview.id_event
AND YEAR(event_overview.date) = 2016;");
$values->execute();
$boys = $values->fetch()[0];
$girls = $values->fetch()[1];
//---------------------------------

$values =$database->getConncetion()->prepare("SELECT SUM(boys) AS Boys_2017, SUM(girls) AS Girls_2017
FROM event_participants, event_overview
WHERE event_participants.id_event =  event_overview.id_event
AND YEAR(event_overview.date) = 2017");
$values->execute();
$boys2017 = $values->fetch()[0];
$girls2017 = $values->fetch()[1];

$values =$database->getConncetion()->prepare("SELECT SUM(under14) FROM event_participants;");
$values->execute();
$u14Bulk = $values->fetch()[0];

//--------------------------

$values =$database->getConncetion()->prepare("SELECT COUNT(event_yp.id_yp)
FROM event_yp, young_people
WHERE event_yp.id_yp = young_people.id_yp
AND  YEAR(CURDATE())- YEAR(dob) <= 14;");
$values->execute();
$u14 = $values->fetch()[0];

//------------------------------

$values =$database->getConncetion()->prepare("SELECT SUM(14plus) FROM event_participants;");
$values->execute();
$o14Bulk = $values->fetch()[0];
//-------------------------------------

$values =$database->getConncetion()->prepare("SELECT COUNT(event_yp.id_yp)
FROM event_yp, young_people
WHERE event_yp.id_yp = young_people.id_yp
AND  YEAR(CURDATE())- YEAR(dob) > ");
$values->execute();
$o14 = $values->fetch()[0];

//---------------------------------------------------

$values =$database->getConncetion()->prepare("SELECT COUNT(gender) FROM young_people, event_yp, event_overview
WHERE young_people.id_yp = young_people.id_yp
AND event_overview.id_event = event_yp.id_event
AND YEAR(event_overview.date) = 2016
AND attended=1
AND gender = 'M'
;");
$values->execute();
$youngMale2016 = $values->fetch()[0];

//---------------------------------------------------
$values =$database->getConncetion()->prepare("SELECT COUNT(gender) FROM young_people, event_yp, event_overview
WHERE young_people.id_yp = young_people.id_yp
AND event_overview.id_event = event_yp.id_event
AND YEAR(event_overview.date) = 2016
AND attended=1
AND gender = 'F'
;
");
$values->execute();
$youngFemale2016 = $values->fetch()[0];

//---------------------------------------------------
$values =$database->getConncetion()->prepare("SELECT COUNT(gender) FROM young_people, event_yp, event_overview
WHERE young_people.id_yp = young_people.id_yp
AND event_overview.id_event = event_yp.id_event
AND YEAR(event_overview.date) = 2017
AND attended=1
AND gender = 'M'
;
");
$values->execute();
$youngMale2017 = $values->fetch()[0];


//---------------------------------------------------
$values =$database->getConncetion()->prepare("SELECT COUNT(gender) FROM young_people, event_yp, event_overview
WHERE young_people.id_yp = young_people.id_yp
AND event_overview.id_event = event_yp.id_event
AND YEAR(event_overview.date) = 2017
AND attended=1
AND gender = 'F'
;
");
$values->execute();
$youngFemale2017 = $values->fetch()[0];

?>

<body>

<h1>Graphical Statistics</h1>

<script>

    setInterval(refresh(), 1000);
    function refresh()
    {
        <?php require_once('DatabaseConnection.php')?>
        <?php
        $database = new DatabaseConnection();
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

//=--------------------------------------

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


//-----------------------------------------------------------
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


//$values =$database->getConncetion()->prepare("SELECT  SUM(Sessions_Attended) AS Sessions
//FROM(SELECT COUNT(young_people.id_yp) * COUNT(event_yp.id_event) AS Sessions_Attended, count(attended) as AttendanceCount
//FROM young_people,event_yp, event_overview
//WHERE  young_people.id_yp = event_yp.id_yp
//AND event_yp.attended = 1
//AND event_yp.id_eventyp = event_overview.id_event
//group by (young_people.id_yp)
//HAVING AttendanceCount > 6
//ORDER BY Sessions_Attended)
//
//AS sessions;");;



        $values =$database->getConncetion()->prepare("SELECT SUM(AttendanceCount) FROM (SELECT young_people.id_yp AS Particpant, COUNT(attended) as AttendanceCount
        FROM young_people, event_yp
        WHERE young_people.id_yp = event_yp.id_yp
        AND attended=1
        group by young_people.id_yp
        HAVING AttendanceCount >= 1 AND AttendanceCount <=5) AS AttendanceCount;");

        $values->execute();
        $sessions1 = $values->fetch()[0];
//--------------------------------------------------------

        $values =$database->getConncetion()->prepare("select SUM(boys + girls) * COUNT(id_event) from event_participants
        where id_cohort <= 5 AND id_cohort>=1;");

        $values->execute();
        $sessions2 = $values->fetch()[0];

//-----------------------------------------------------
        $values =$database->getConncetion()->prepare("select SUM(boys + girls) from event_participants
        where id_cohort >= 6;");
        $values->execute();
        $Participants = $values->fetch()[0];

//----------------------------------------
        $values =$database->getConncetion()->prepare("SELECT SUM(AttendanceCount) FROM (SELECT young_people.id_yp AS Particpant, COUNT(attended) as AttendanceCount
        FROM young_people, event_yp
        WHERE young_people.id_yp = event_yp.id_yp
        AND attended=1
        group by young_people.id_yp
        HAVING AttendanceCount >= 6) AS AttendanceCount;");
        $values->execute();
        $youngPeople = $values->fetch()[0];

//---------------------------------------

        $values =$database->getConncetion()->prepare("SELECT COUNT(event_yp.id_yp)
        FROM event_yp, young_people
        WHERE event_yp.id_yp = young_people.id_yp
        AND  YEAR(CURDATE())- YEAR(dob) <= 14;");
        $values->execute();
        $youngUnder = $values->fetch()[0];

//---------------------------------------

        $values =$database->getConncetion()->prepare("SELECT COUNT(event_yp.id_yp)
        FROM event_yp, young_people
        WHERE event_yp.id_yp = young_people.id_yp
        AND  YEAR(CURDATE())- YEAR(dob) > 14;");
        $values->execute();
        $youngOver = $values->fetch()[0];
//-----------------------------------------
        $values =$database->getConncetion()->prepare("SELECT SUM(boys) AS Boys_2017, SUM(girls) AS Girls_2017
        FROM event_participants, event_overview
        WHERE event_participants.id_event =  event_overview.id_event
        AND YEAR(event_overview.date) = 2016;");
        $values->execute();
        $boys = $values->fetch()[0];
        $girls = $values->fetch()[1];
//---------------------------------

        $values =$database->getConncetion()->prepare("SELECT SUM(boys) AS Boys_2017, SUM(girls) AS Girls_2017
        FROM event_participants, event_overview
        WHERE event_participants.id_event =  event_overview.id_event
        AND YEAR(event_overview.date) = 2017");
        $values->execute();
        $boys2017 = $values->fetch()[0];
        $girls2017 = $values->fetch()[1];

        $values =$database->getConncetion()->prepare("SELECT SUM(under14) FROM event_participants;");
        $values->execute();
        $u14Bulk = $values->fetch()[0];

//--------------------------

        $values =$database->getConncetion()->prepare("SELECT COUNT(event_yp.id_yp)
        FROM event_yp, young_people
        WHERE event_yp.id_yp = young_people.id_yp
        AND  YEAR(CURDATE())- YEAR(dob) <= 14;");
        $values->execute();
        $u14 = $values->fetch()[0];

//------------------------------

        $values =$database->getConncetion()->prepare("SELECT SUM(14plus) FROM event_participants;");
        $values->execute();
        $o14Bulk = $values->fetch()[0];
//-------------------------------------

        $values =$database->getConncetion()->prepare("SELECT COUNT(event_yp.id_yp)
        FROM event_yp, young_people
        WHERE event_yp.id_yp = young_people.id_yp
        AND  YEAR(CURDATE())- YEAR(dob) > ");
        $values->execute();
        $o14 = $values->fetch()[0];

//---------------------------------------------------

        $values =$database->getConncetion()->prepare("SELECT COUNT(gender) FROM young_people, event_yp, event_overview
        WHERE young_people.id_yp = young_people.id_yp
        AND event_overview.id_event = event_yp.id_event
        AND YEAR(event_overview.date) = 2016
        AND attended=1
        AND gender = 'M'
    ;");
        $values->execute();
        $youngMale2016 = $values->fetch()[0];

//---------------------------------------------------
        $values =$database->getConncetion()->prepare("SELECT COUNT(gender) FROM young_people, event_yp, event_overview
        WHERE young_people.id_yp = young_people.id_yp
        AND event_overview.id_event = event_yp.id_event
        AND YEAR(event_overview.date) = 2016
        AND attended=1
        AND gender = 'F'
    
        ");
        $values->execute();
        $youngFemale2016 = $values->fetch()[0];

//---------------------------------------------------
        $values =$database->getConncetion()->prepare("SELECT COUNT(gender) FROM young_people, event_yp, event_overview
        WHERE young_people.id_yp = young_people.id_yp
        AND event_overview.id_event = event_yp.id_event
        AND YEAR(event_overview.date) = 2017
        AND attended=1
        AND gender = 'M'
    ;
        ");
        $values->execute();
        $youngMale2017 = $values->fetch()[0];


//---------------------------------------------------
        $values =$database->getConncetion()->prepare("SELECT COUNT(gender) FROM young_people, event_yp, event_overview
        WHERE young_people.id_yp = young_people.id_yp
        AND event_overview.id_event = event_yp.id_event
        AND YEAR(event_overview.date) = 2017
        AND attended=1
        AND gender = 'F'
    ;
        ");
        $values->execute();
        $youngFemale2017 = $values->fetch()[0];
?>
    }
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
    else if(chart =="boyGirl")
    {
        drawBoyGirlChart()
    }
    else if(chart =="boyGirlPie")
    {
        drawBoyGirlPieChart()
    }
    else if(chart =="age")
    {
        drawAgeChart()
    }
    else if(chart =="agePie")
    {
        drawAgePieChart()
    }

    else if(chart =="youngGender")
    {
        drawYoungGenderChart()
    }
    else if(chart =="youngGenderPie")
    {
        drawYoungGenderPieChart()
    }
}




</script>

<div class="styled-select blue semi-square">
<select onchange=decide(this)>
    <option chart="">Select engaged chart</option>
    <option chart="attendance">Engaged chart</option>
    <option chart="attendancePie">Engaged pie chart</option>
</select>
</div>

<div class="styled-select blue semi-square">
<select onchange=decide(this)>
    <option chart="">Select Participant chart</option>
    <option chart="attendee">Participant chart</option>
    <option chart="attendeePie">Participant pie chart</option>
</select>
</div>

    <div class="styled-select blue semi-square">
<select onchange=decide(this)>
    <option chart="">Select Session attended chart</option>
    <option chart="session">Session attended chart</option>
    <option chart="sessionPie">Session attended pie chart</option>
</select>
    </div>

<div class="styled-select blue semi-square">
    <select onchange=decide(this)>
        <option chart="">Select Boy and girl chart</option>
        <option chart="boyGirl">Boy and Girl chart</option>
        <option chart="boyGirlPie">Boy and Girl pie chart</option>
    </select>
</div>

<div class="styled-select blue semi-square">
    <select onchange=decide(this)>
        <option chart="">Select age chart</option>
        <option chart="age">Age chart</option>
        <option chart="agePie">Age pie chart</option>
    </select>
</div>

<div class="styled-select blue semi-square">
    <select onchange=decide(this)>
        <option chart="">Select Young Gender chart</option>
        <option chart="youngGender">Young Gender chart</option>
        <option chart="youngGenderPie">Young Gender pie chart</option>
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
            ['Type', 'Young People', 'Under 14s', 'Over 14s'],
            ['Young People', <?php echo ($Participants + $youngPeople)?>, null, null],
                ['Under 14s', null, <?php echo $youngUnder?>, null],
                ['Over 14s', null, null, <?php echo $youngOver?>]



        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Participants ', isStacked: true, 'width':900, 'height':900};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.ColumnChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }
//
    function drawAttendeePieChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Young People'],
            ['Young People', <?php echo ($Participants + $youngPeople)?>],
                ['Under 14s', <?php echo $youngUnder?>],
                ['Over 14s', <?php echo $youngOver?>]


        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Attendees ', 'width':900, 'height':900};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }

    function drawSessionChart() {

        var data = google.visualization.arrayToDataTable([
            ['Type', '2016', '2017'],

            ['2016',  <?php echo $unAttended?>,  null],
            ['2017', null, <?php echo ($finalValue = $sessions1 + $sessions2)?> ]


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
            ['2017', <?php echo ($finalValue = $sessions1 + $sessions2)?>, null ]


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

    function drawBoyGirlChart() {

        var data = google.visualization.arrayToDataTable([
            ['Type', 'boys', 'girls'],

            ['2016 boys', 0,  null],
            ['2016 girls', null, 1334],
            ['2017 boys', 2464, null],
            ['2017 girls', null, 0 ]



        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Boys and girls participated ',
            'width':900,
            'height':900,
            isStacked: true
        };


        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.ColumnChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }

    function drawBoyGirlPieChart() {

        var data = google.visualization.arrayToDataTable([
            ['Type', 'boys 2016', 'girls 2016', 'boys 2017', 'girls 2017'],

            ['2016 boys', 0,  null, null, null],
            ['2016 girls',1334, null, null, null],
            ['2017 boys', 2464, null,null , null],
            ['2017 girls',0, null, null,null  ]


        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Boys and girls participated ',
            'width':900,
            'height':900,

        };


        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }

    function drawAgeChart() {

        var data = google.visualization.arrayToDataTable([
            ['Type', 'under 14s', 'over 14s'],

            ['Under 14s', <?php echo ($u14 + $u14Bulk) ?>,  null],
            ['Over 14s', null, <?php echo ($o14 + $o14Bulk) ?>,]



        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Boys and girls participated ',
            'width':900,
            'height':900,
            isStacked: true
        };


        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.ColumnChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }

    function drawAgePieChart() {

        var data = google.visualization.arrayToDataTable([
            ['Type', 'under 14s', 'over 14s'],

            ['Under 14s', <?php echo ($u14 + $u14Bulk) ?>,  null],
            ['Over 14s', <?php echo ($o14 + $o14Bulk) ?>, null]


        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Age charts ',
            'width':900,
            'height':900,

        };


        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }

    function drawYoungGenderChart() {

        var data = google.visualization.arrayToDataTable([
            ['Type', 'Young Male', 'Young Female'],

            ['2016 Young Male', <?php echo $youngMale2016 ?>,  null],
            ['2016 Young Female', null, <?php echo $youngFemale2016 ?>],
            ['2017 Young Male', <?php echo $youngMale2017 ?>,  null],
            ['2017 Young Female', null, <?php echo $youngFemale2017 ?>]



        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Young People genders ',
            'width':900,
            'height':900,
            isStacked: true
        };


        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.ColumnChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }

    function drawYoungGenderPieChart() {

        var data = google.visualization.arrayToDataTable([
                ['Type', 'Young Male 2016', 'Young Female 2016'],

                ['2016 Young Male', 23,  null],
                ['2016 Young Female', 20, null],
                    ['2017 Young Male', 55,  null],
            ['2017 Young Female', 77, null]

//                    ['2016 Young Male', <?php //echo $youngMale2016 ?>//,  null, null, null],
//            ['2016 Young Male', <?php //echo $youngMale2016 ?>//, null, null, null],
//            ['2017 Young Male', <?php //echo $youngMale2017 ?>//, null,null , null],
//            ['2017 Young Female', <?php //echo $youngFemale2017 ?>//, null, null,null  ]

        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Young People genders ',
            'width':900,
            'height':900,

        };


        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('barChart'));
        chart.draw(data, options);

    }



</script>

</body>
</html>
