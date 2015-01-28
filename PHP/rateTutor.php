<?php
    session_start();
    $conn = mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $currentGTID = $_SESSION['GTID'];
    $tutName = $_POST['tutName'];
    $course = explode(",", $_POST['course']);
    $course[1] = (int) $course[1];
    $descEval = $_POST['descEval'];
    $numEval = (int) $_POST['numEval'];



    $stuEmail = mysqli_query($conn, "SELECT Student.Email FROM Student
        WHERE Student.GTID = $currentGTID AND Student.Name != '$tutName'");
    $stuEmailArray = mysqli_fetch_array($stuEmail, MYSQLI_NUM);

    $result = mysqli_query($conn, "SELECT Student.Email FROM Student, Tutors
        WHERE Tutors.CourseSchool = '$course[0]' AND Tutors.CourseNumber = $course[1]
        AND Tutors.Email = Student.Email AND Student.Name = '$tutName'");
    $resultArray = mysqli_fetch_array($result, MYSQLI_NUM);

    if ($tutName == "" && $descEval == "") {
        header("Location:../mainMenu.php");
    } else if ($resultArray == null || $stuEmailArray[0] == "") {
        $_SESSION['invalidRateTutForm'] = TRUE;
        header("Location:../rateTutorForm.php");
    } else {
        $sql = mysqli_query($conn, "INSERT INTO Rates (UndergradEmail, TutorEmail, NumEval, DescEval,
            CourseSchool, CourseNumber) VALUES ('$stuEmailArray[0]', '$resultArray[0]', '$numEval',
            '$descEval', '$course[0]', '$course[1]')");
        if (!$sql) {
            echo "<h1> Error: invalid entry </h1>";
        } else {
            header("Location:../mainMenu.php");
        }
    }


    mysqli_close($conn);

?>