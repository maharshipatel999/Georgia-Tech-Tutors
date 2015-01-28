<?php
    session_start();
    $conn = mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
 
    $tempArray = $_SESSION['query2'];
    //var_dump($tempArray);

    //unset($_SESSION['query2']);

?>

<html>
<head>
<meta charset="utf-8">
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="../styleSheet.css" />
</head>

<body>
    <div id="form" class="searchForm">
        <form id="scheduleTutorForm" action="scheduleTutor.php" method="post">
            <span>
                <?php 
                    if ($_SESSION['invalidSelect'] == TRUE) {
                        echo "The time slot is taken or your selection is invalid.
                            Please select again.";
                        $_SESSION['invalidSelect'] = FALSE;
                    }
                ?>
            </span>
            <div style="overflow-y:auto;height:80%">
                <table border="1" style="width:100%">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Weekday</th>
                        <th>Time</th>
                        <th>Select</th>
                    </tr>
                    <?php
                        echo "$tempArray";
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