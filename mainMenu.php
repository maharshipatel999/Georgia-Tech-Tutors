<?php session_start(); 

if(!isset($_SESSION['GTID'])){
 	header("Location:index.php");
 }

$conn=mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
?>

<html>
<head>
<meta charset="utf-8">
	<title>Main Menu</title>
    <link rel="stylesheet" type="text/css" href="styleSheet.css" />
</head>
	
<body>
	<div id="form" class="mainMenu">
    	<table>
        <?php
            $currentGTID = $_SESSION['GTID'];
            $result = mysqli_query($conn, "SELECT GTID FROM Student, Undergrad WHERE Student.GTID = $currentGTID
                AND Student.Email = Undergrad.Email");
            $resultArray = mysqli_fetch_array($result, MYSQLI_NUM);
            if ($resultArray != null) {
                //enable options
                echo "
                <tr><td><b>Student Options</b></td>
                    <td><a href=\"searchTutorForm.php\">Search Tutor</a></td>
                    <td><a href=\"rateTutorForm.php\">Rate Tutor</a></td>
                </tr> ";
            } else {
                //disable options (aka, leave the href the way it is)
                echo "
                <tr><td><b>Student Options</b></td>
                    <td><a href=\"#\">Search Tutor</a></td> 
                    <td><a href=\"#\">Rate Tutor</a></td>
                </tr> ";
            }
            $result2 = mysqli_query($conn, "SELECT Tutor.Email FROM Tutor, Student WHERE
                Student.GTID =  $currentGTID AND Student.Email = Tutor.Email");
            $resultArray2 = mysqli_fetch_array($result2, MYSQLI_NUM);
            $result2b = mysqli_query($conn, "SELECT GTID FROM Student, Undergrad WHERE Student.GTID = $currentGTID");
            $resultArray2b = mysqli_fetch_array($result2b, MYSQLI_NUM);
            if ($resultArray2 != null || $resultArray2b != null) {
                //enable options 
                echo "
                <tr><td><b>Tutor Options</b></td>
                    <td><a href=\"TutorApplicationForm.php\">Apply</a></td>
                    <td><a href=\"TutorSchedule.php\">Find my schedule</a></td>
                </tr> ";
            } else {
                //disable options (aka, leave the href the way it is)
                echo "
                <tr><td><b>Tutor Options</b></td>
                    <td><a href=\"#\">Apply</a></td>
                    <td><a href=\"#\">Find my schedule</a></td>
                </tr> ";               
            }
            $result3 = mysqli_query($conn, "SELECT GTID FROM Professor WHERE GTID = $currentGTID");
            $resultArray3 = mysqli_fetch_array($result3, MYSQLI_NUM);
            if ($resultArray3 != null) {
                echo "
                <tr><td><b>Professor Options</b></td>
                    <td colspan=\"2\"><a href=\"tutorRecommendation.php\">Add recomendation</a></td>
                </tr>";
            } else {
                echo "
                <tr><td><b>Professor Options</b></td>
                    <td colspan=\"2\"><a href=\"#\">Add recomendation</a></td>
                </tr>";
            }
            $result4 = mysqli_query($conn, "SELECT GTID FROM Administrator WHERE GTID = '$currentGTID'");
			$resultArray4 = mysqli_fetch_array($result4, MYSQLI_NUM);
            if ($resultArray4 != null) {
                //enable options
                echo "
                    <tr class=\"spaceUnder\"><td><b>Adminstrator Options</b></td>
                        <td><a href=\"Summary1.php\">Summary 1</a></td>
                        <td><a href=\"Summary2.php\">Summary 2</a></td>
                    </tr> ";
            } else {
                //disable options (aka, leave the href the way it is)
                echo "
                    <tr class=\"spaceUnder\"><td><b>Adminstrator Options</b></td>
                        <td><a href=\"#\">Summary 1</a></td>
                        <td><a href=\"#\">Summary 2</a></td>
                    </tr> ";
            }
            mysqli_free_result($result);
            mysqli_free_result($result2);
            mysqli_free_result($result2b);    
            mysqli_free_result($result3);
			mysqli_free_result($result4);
            

            echo " <tr><td><a href=\"php/exit.php\">Exit</a></td></tr> ";
            mysqli_close($conn);
        ?>
        </table>
    </div>
</body>
</html>
