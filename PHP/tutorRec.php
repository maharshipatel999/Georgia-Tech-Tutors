<?php
    session_start();
    $conn = mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $currentGTID = $_SESSION['GTID'];
    $tutGTID = (int) $_POST['tutGtid'];
    $descEval = $_POST['descEval'];
    $numEval = (int) $_POST['numEval'];

    $result = mysqli_query($conn, "SELECT Tutor.Email FROM Student, Tutor 
        WHERE Student.GTID = $tutGTID AND Student.Email = Tutor.Email");
    $resultArray = mysqli_fetch_array($result, MYSQLI_NUM);

    if ($descEval == "" || $tutGTID == "" || $resultArray == null) {
        $_SESSION['blankRecForm'] = TRUE;
        header("Location:../tutorRecommendation.php");
    } else {
        $sql = mysqli_query($conn, "INSERT INTO Recommends (TutorEmail, ProfGTID, NumEval, DescEval)
            VALUES ('$resultArray[0]', '$currentGTID', '$numEval', '$descEval')");
        if (!$sql) {
            echo "<h1> Error: invalid entry </h1>";
        } else {
            header("Location:../mainMenu.php");
        }
    }

    mysqli_close($conn);
?>