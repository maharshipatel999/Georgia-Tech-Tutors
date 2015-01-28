<?php
    session_start();
    $conn = mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    header('Cache-Control: private');
    
    $currentGTID = $_SESSION['GTID'];
    $TutorGTID = $_GET['user'];


    
    if ($TutorGTID == $currentGTID) {
        $TutorEmail = mysqli_query($conn, "SELECT Email FROM Student WHERE $currentGTID = Student.GTID");
        
        $TutorEmailArray = mysqli_fetch_array($TutorEmail, MYSQL_NUM);
        
        $name = mysqli_query($conn, "SELECT Name FROM Student WHERE '$TutorEmailArray[0]' = Email");
        
        $nameArray = mysqli_fetch_array($name, MYSQL_NUM);
       
        $schedule = mysqli_query($conn, "SELECT TutorTimeSlot.Weekday, TutorTimeSlot.Time, Student.Name, Student.Email, Hires.CourseSchool, Hires.CourseNumber FROM Hires, Student, TutorTimeSlot WHERE Student.Email = Hires.UndergradEmail AND Hires.TutorEmail = '$TutorEmailArray[0]' AND TutorTimeSlot.Email = '$TutorEmailArray[0]' AND Hires.Weekday = TutorTimeSlot.Weekday AND Hires.Time = TutorTimeSlot.Time AND Hires.Semester = 'Summer'");

        
    echo"<html><body> Tutor Schedule for: ".$nameArray[0]."<br>";
    
        echo $TutorGTID;
        
    echo"<table border='1' style='width:600px'>
    <tr>
    <th>Weekday</th>
    <th>Time</th>
    <th>Student Name</th>
    <th>Student Email</th>
    <th>Course School</th>
    <th>Course Number</th>
    </tr>";
    
        
    while($row = mysqli_fetch_array($schedule, MYSQL_NUM)){
        echo "<tr>";
        echo "<td>".$row[0]."</td>";
        echo "<td>".$row[1]."</td>";
        echo "<td>".$row[2]."</td>";
        echo "<td>".$row[3]."</td>";
        echo "<td>".$row[4]."</td>";
        echo "<td>".$row[5]."</td>";
        echo "</tr>";
    };
        
    echo"</table>";

     echo "
     <table><tr>
        <td>
            <a href=\"../mainMenu.php\">
                <input type=\"button\" value=\"Cancel\" />
            </a>
        </td>
      </tr></table>";
    
    echo"</body></html>";
        
    };
    
    
    if($TutorGTID != $currentGTID){
        echo"Invalid GTID";
    };
    
    
    mysqli_close($conn);

    ?>