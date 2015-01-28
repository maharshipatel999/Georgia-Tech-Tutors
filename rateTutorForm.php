<?php session_start(); 
//include 'php/timer.php';
$conn=mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 if(!isset($_SESSION['GTID'])){
    header("Location:index.php");
 }
?>
<html>
<head>
<meta charset="utf-8">
    <title>Rate Tutor</title>
    <link rel="stylesheet" type="text/css" href="styleSheet.css" />
</head>

<body>
    <div id="form" class="evalForm">
        <form id="rateTutForm" action="PHP/rateTutor.php" method="post">
            <span>
                <?php 
                    if ($_SESSION['invalidRateTutForm'] == TRUE) {
                        echo "Invalid data was inputted.";
                        $_SESSION['invalidRateTutForm'] = FALSE;
                    }
                ?>
            </span>
            <table>
                <tr>
                    <td><label>Tutor Name: </label><input type="text" name="tutName"/><br/></td>
                </tr>
                <tr class="spaceUnder">
                    <td><label>Course: </label>
                    <select name="course">
                        <?php
                            $courses = mysqli_query($conn, "SELECT * FROM Course");
                            while ($row = mysqli_fetch_array($courses, MYSQLI_NUM)) {
                                $val = "$row[0]" . "," . "$row[1]";
                                echo "<option value=$val>" . $row[0] . " " . $row[1] . "</option>";
                            }
                        ?>
                    </select>
                </tr>

                <tr>
                    <td><label>Descriptive Evaluation:</label><br/></td>
                </tr>
                <tr>
                    <td><textarea cols="40" name="descEval"></textarea></td>
                </tr>
                <tr>
                    <td><label>Numeric Evaluation:</label><br/></td>
                </tr>
                <tr>
                    <td><input type="radio" name="numEval" value="4"> 4 - Highly Recommend</td>
                </tr>
                <tr>
                    <td><input type="radio" name="numEval" value="3"> 3 - Recommend</td>
                </tr>
                <tr>
                    <td><input type="radio" name="numEval" value="2"> 2 - Moderatly Recommend</td>
                </tr>
                <tr class="spaceUnder">
                    <td><input type="radio" name="numEval" value="1" checked="checked"> 1 - Do Not Recommend</td>
                </tr>
                <tr> 
                    <td><input type="submit" value="Submit"></td>
                </tr>
            </table>

        </form>
    </div>
</body>
</html>