<?php session_start(); 
 if(!isset($_SESSION['GTID'])){
    header("Location:index.php");
 }
?>
<html>
<head>
<meta charset="utf-8">
    <title>Tutor Evaluation</title>
    <link rel="stylesheet" type="text/css" href="styleSheet.css" />
</head>

<body>
    <div id="form" class="evalForm">
        <form action="PHP/tutorRec.php" method="post">
            <span>
                <?php 
                    if ($_SESSION['blankRecForm'] == TRUE) {
                        echo "Invalid data was inputted.";
                        $_SESSION['blankRecForm'] = FALSE;
                    }
                ?>
            </span>
            <table>
                <tr class="spaceUnder">
                    <td><label>Student GTID: </label><input type="text" name="tutGtid"/><br/></td>
                </tr>
                <tr>
                    <td><label>Descriptive Evaluation:</label><br/></td>
                </tr>
                <tr class="spaceUnder">
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