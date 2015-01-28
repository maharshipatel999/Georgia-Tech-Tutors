<?php
    session_start();
    $conn = mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $currentGTID = $_SESSION['GTID'];
    $emailDayTime = explode(",", $_POST['email']);
    $courseSch = $_SESSION['courseSch'];
    $emailDayTime[2] = (int) $emailDayTime[2];
    $courseNum = $_SESSION['courseNum'];
    $sem = "Summer";


    $studentEmail = mysqli_query($conn, "SELECT Student.Email FROM Student
        WHERE Student.GTID = $currentGTID AND Student.Email != '$emailDayTime[0]'");
    $studentEmailArray = mysqli_fetch_array($studentEmail, MYSQLI_NUM);

    $result = mysqli_query($conn, "SELECT * FROM Hires WHERE TutorEmail = '$emailDayTime[0]'
        AND TIME = $emailDayTime[2] AND Semester = '$sem' AND Weekday = '$emailDayTime[1]'");
    $resultArray = mysqli_fetch_array($result, MYSQLI_NUM);

    // echo "<h1> $resultArray[0] </h1>";

    // echo "<h1> $courseSch $courseNum $emailDayTime[1] $studentEmailArray[0]</h1>";

    if ($resultArray != null || $studentEmailArray[0] == "") {
        $_SESSION['invalidSelect'] = TRUE;
        header("Location: searchResults.php");
    } else {
        $sqlStatement = mysqli_query($conn, "INSERT INTO Hires (TutorEmail, CourseSchool,
            CourseNumber, UndergradEmail, Time, Semester, Weekday) VALUES
            ('$emailDayTime[0]', '$courseSch', '$courseNum', '$studentEmailArray[0]',
            '$emailDayTime[2]', '$sem', '$emailDayTime[1]')");
        if (!$sqlStatement) {
            echo "<h1> Error: invalid entry </h1>";
        } else {
            header("Location:../mainMenu.php");
        }
    }

    // unset($_SESSION['courseSch']);
    // unset($_SESSION['courseNum']);


?>