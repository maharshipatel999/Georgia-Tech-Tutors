<?php
    session_start();
    if(!isset($_SESSION['GTID'])){
        header("Location:index.php");
        require('PHP/TutSchedule.php');

    }
    ?>
<html>
<head>
<meta charset="utf-8">
<title>Tutor Evaluation</title>
<link rel="stylesheet" type="text/css" href="styleSheet.css" />
</head>
<body>


<form name="GTID" action="PHP/File5.php" method="get">
Enter Tutor GTID: <input type="number" name="user">
<input type="submit" value="OK">
</form>


</body>
</html>
