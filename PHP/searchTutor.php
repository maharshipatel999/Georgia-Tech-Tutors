<?php
    session_start();
    $conn = mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $course = explode(",", $_POST['course']);
    $course[1] = (int) $course[1];
    $monday = array_map('intval', $_POST['monday']);
    $tuesday = array_map('intval', $_POST['tuesday']);
    $wednesday = array_map('intval', $_POST['wednesday']);
    $thursday = array_map('intval', $_POST['thursday']);
    $friday = array_map('intval', $_POST['friday']);

    $_SESSION['courseSch'] = $course[0];
    $_SESSION['courseNum'] = $course[1];

    if (sizeof($monday) < 1) {
        $monday[0] = 0;
    }
    if (sizeof($tuesday) < 1) {
        $tuesday[0] = 0;
    }
    if (sizeof($wednesday) < 1) {
        $wednesday[0] = 0;
    }
    if (sizeof($thursday) < 1) {
        $thursday[0] = 0;
    }
    if (sizeof($friday) < 1) {
        $friday[0] = 0;
    }

    $query = mysqli_query($conn,
        "SELECT DISTINCT(Email), Name, AvgProfRating, NumProfs, AvgStuRatings, NumStudents
        FROM (

            SELECT TutorEmail, AVG(NumEval) AS AvgProfRating, COUNT(ProfGTID) AS NumProfs
            FROM Recommends
            GROUP BY TutorEmail
            ) AS ProfInfo
            RIGHT OUTER JOIN (

                SELECT TutInfo.Name, TutInfo.Email
                FROM (
                    Tutor
                    NATURAL JOIN TutorTimeSlot
                    NATURAL JOIN Tutors
                    NATURAL JOIN Student AS TutInfo
                )
                WHERE CourseSchool = '$course[0]'
                AND CourseNumber = $course[1]
                AND Semester =  'Summer'
                AND ( (Weekday = 'Monday' AND Time IN (".implode(',',$monday).")) 
                    OR (Weekday = 'Tuesday' AND Time IN (".implode(',',$tuesday)."))
                    OR (Weekday = 'Wednesday' AND Time IN (".implode(',',$wednesday)."))
                    OR (Weekday = 'Thursday' AND Time IN (".implode(',',$thursday)."))
                    OR (Weekday = 'Friday' AND Time IN (".implode(',',$friday).")))

            ) AS TutorInfo ON ProfInfo.TutorEmail = TutorInfo.Email
            LEFT OUTER JOIN (

                SELECT TutorEmail, AVG(NumEval) AS AvgStuRatings, COUNT(UndergradEmail) AS NumStudents
                FROM Rates
                WHERE Rates.CourseSchool = '$course[0]' AND Rates.CourseNumber = $course[1]
                GROUP BY TutorEmail
            ) AS PupilInfo ON Email = PupilInfo.TutorEmail
            ORDER BY AvgStuRatings DESC");

    $query2 = mysqli_query($conn,
        "SELECT Name, Email, Weekday, Time
        FROM (
            Tutor
            NATURAL JOIN TutorTimeSlot
            NATURAL JOIN Tutors
            NATURAL JOIN Student AS TutInfo
        )
        WHERE CourseSchool = '$course[0]'
        AND CourseNumber = $course[1]
        AND Semester =  'Summer'
        AND ( (Weekday = 'Monday' AND Time IN (".implode(',',$monday).")) 
            OR (Weekday = 'Tuesday' AND Time IN (".implode(',',$tuesday)."))
            OR (Weekday = 'Wednesday' AND Time IN (".implode(',',$wednesday)."))
            OR (Weekday = 'Thursday' AND Time IN (".implode(',',$thursday)."))
            OR (Weekday = 'Friday' AND Time IN (".implode(',',$friday).")))");
 

    $output = '';
    while ($row = mysqli_fetch_array($query, MYSQL_NUM)) {
        $output .= '
            <tr>
                <td align="center">' . $row[1] . '</td>
                <td align="center">' . $row[0] . '</td>
                <td align="center">' . $row[2] . '</td>
                <td align="center">' . $row[3] . '</td>
                <td align="center">' . $row[4] . '</td>
                <td align="center">' . $row[5] . '</td>
            </tr>';
    }

    $output2 = '';
    while ($row = mysqli_fetch_array($query2, MYSQL_NUM)) {
        $val = "$row[1]" . "," . "$row[2]" . "," . "$row[3]";
        if ($row[3] == 800) {
            $out = "8 AM";
        } else if ($row[3] == 900) {
            $out = "9 AM";
        } else if ($row[3] == 1000) {
            $out = "10 AM";
        } else if ($row[3] == 1100) {
            $out = "11 AM";
        } else if ($row[3] == 1200) {
            $out = "12 AM";
        } else if ($row[3] == 1300) {
            $out = "1 PM";
        } else if ($row[3] == 1400) {
            $out = "2 PM";
        } else if ($row[3] == 1500) {
            $out = "3 PM";
        } else if ($row[3] == 1600) {
            $out = "4 PM";
        } else {
            $out = $row[3];
        }
        $output2 .= '
            <tr>
                <td align="center">' . $row[0] . '</td>
                <td align="center">' . $row[1] . '</td>
                <td align="center">' . $row[2] . '</td>
                <td align="center">' . $out . '</td>
                <td align="center"> <input type="radio" name="email" value=' . $val . '> </td>
            </tr>';
    }
    $_SESSION['query2'] = $output2;
?>


<html>
<head>
<meta charset="utf-8">
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="../styleSheet.css" />
</head>

<body>
    <div id="form" class="searchForm">
        <form id="searchFormResults" action="searchResults.php" method="post">
            <div style="overflow-y:auto;height:80%">
                <table border="1">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Avg Prof Rating</th>
                        <th>No. of Professors</th>
                        <th>Avg Student Rating</th>
                        <th>No. of Students</th>
                    </tr>
                    <?php
                        echo "$output";
                    ?>
                </table>
            </div>

            <style>
                #bottomTable { position: absolute; bottom: 10; left:25%; margin-left: 50px;}
            </style>
            <div id="bottomTable">
                <table>
                    <tr>
                        <td>
                            <input type="submit" value="Schedule a Tutor"/>
                        </td>
                        <td>
                            <a href="../mainMenu.php">
                                <input type="button" value="Cancel" />
                            </a>
                        </td>
                    </tr>
                </table>
            </div>

        </form>
    </div>
</body>
</html>



