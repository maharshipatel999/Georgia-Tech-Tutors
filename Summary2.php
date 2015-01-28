<?php
	session_start();
    $conn = mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    
    echo "<html>".
    "<head>".
    "<meta charset='utf-8'>".
    "<title>Tutor Evaluation</title>".
    "<link rel='stylesheet' type='text/css' href='styleSheet.css' />".
    "</head>".
    "<body>";
    
    //checkboxes for which semesters to display results for
    echo "<table><tr><td><h2> Academic Year 2014</h2></td>
         <form method='get' action='Summary2.php'>
         <td><input type='radio' name='Fall' value='Fall'>Fall</td>
         <td><input type='radio' name='Spring' value='Spring'>Spring</td>
         <td><input type='radio' name='Summer' value='Summer'>Summer</td>
         <td><input type='submit' value='OK'></td>
         </form>
         </tr></table>";
    
    header('Cache-Control: private');

    
    //passing on input from checkboxes
    $FallSem = $_GET['Fall'];
    $SpringSem = $_GET['Spring'];
    $SummerSem = $_GET['Summer'];

    
    $view1 = mysqli_query($conn,
                           "CREATE VIEW GradTAs AS
                           SELECT C.CourseSchool, C.CourseNumber, TTS.Semester, COUNT(DISTINCT(T.Email)) AS TA, AVG(R.NumEval) AS Avg1
                           FROM Course AS C, TutorTimeSlot AS TTS, Rates AS R, Tutors AS T
                           WHERE (T.Email = TTS.Email AND T.Email = R.TutorEmail AND TTS.Email = R.TutorEmail)
                           AND (C.CourseSchool = R.CourseSchool)
                           AND (C.CourseNumber = R.CourseNumber)
                           AND T.GTA = 1
                           AND (TTS.Semester= '$FallSem' OR TTS.Semester = '$SpringSem' OR TTS.Semester = '$SummerSem')
                           GROUP BY C.CourseSchool, C.CourseNumber, TTS.Semester"
                          );
    $view2 = mysqli_query($conn,
                           "CREATE VIEW NonGradTAs AS
                           SELECT C.CourseSchool, C.CourseNumber, TTS.Semester, COUNT(DISTINCT(T.Email)) AS NonTA, AVG(R.NumEval) AS Avg2
                           FROM Course AS C, TutorTimeSlot AS TTS, Rates AS R, Tutors AS T
                           WHERE (T.Email = TTS.Email AND T.Email = R.TutorEmail AND
                                  TTS.Email = R.TutorEmail)
                           AND (C.CourseSchool = R.CourseSchool)
                           AND (C.CourseNumber = R.CourseNumber)
                           AND T.GTA = 0
                           AND (TTS.Semester='$FallSem' OR TTS.Semester = '$SpringSem' OR TTS.Semester = '$SummerSem')
                           GROUP BY C.CourseSchool, C.CourseNumber, TTS.Semester"
                          );
                           
    $result = mysqli_query($conn, "SELECT t1.CourseSchool, t1.CourseNumber, t1.Semester, t1.Avg1, t1.TA,
                           t2.CourseSchool, t2.CourseNumber, t2.Semester, t2.Avg2, t2.NonTA
                           FROM GradTAs AS t1
                           LEFT JOIN NonGradTAs t2 ON t2.CourseSchool = t1.CourseSchool AND t1.CourseNumber = t2.CourseNumber
                           GROUP BY t1.CourseSchool, t2.CourseSchool, t1.Semester, t2.Semester
                           
                           UNION
                           
                           SELECT t1.CourseSchool, t1.CourseNumber, t1.Semester, t1.Avg1, t1.TA,
                           t2.CourseSchool, t2.CourseNumber, t2.Semester, t2. t2.Avg2, t2.NonTA
                           FROM GradTAs AS t1
                           RIGHT JOIN NonGradTAs t2 ON t2.CourseSchool = t1.CourseSchool AND t1.CourseNumber = t2.CourseNumber
                           GROUP BY t1.CourseSchool, t2.CourseSchool, t1.Semester, t2.Semester");
    
         
//split up the query into multiple things to call in the table

                           unset($FallSem);
                           unset($SpringSem);
                           unset($SummerSem);
         
    echo "<table border='1'><tr>
         <td>Course School</td>
         <td>Course Number</td>
         <td>Semester</td>
         <td>TA</td>
         <td> Avg Rating </td>
         <td> Non TA </td>
         <td> Avg Rating </td>
         </tr>";
    
         while($row = mysqli_fetch_array($result, MYSQL_NUM)){
         if($row[0]==NULL) {
            $row[0]=$row[5];
        }
         if($row[1]==NULL) {
         $row[1]=$row[6];
         }
        if($row[2]==NULL) {
        $row[2]=$row[7];
        }
         echo "<tr>";
         echo "<td>".$row[0]."</td>";
         echo "<td>".$row[1]."</td>";
         echo "<td>".$row[2]."</td>";
         echo "<td>".$row[3]."</td>";
         echo "<td>".$row[4]."</td>";
         echo "<td>".$row[8]."</td>";
         echo "<td>".$row[9]."</td>";
         echo "</tr>";
         };
         
         echo "
         <table><tr>
            <td>
                <a href=\"../mainMenu.php\">
                    <input type=\"button\" value=\"Cancel\" />
                </a>
            </td>
          </tr></table>";

         echo "</body></html>";
    
        mysqli_query($conn, "DROP VIEW GradTAs");
        mysqli_query($conn, "DROP VIEW NonGradTAs");

         mysqli_close($conn);

?>


