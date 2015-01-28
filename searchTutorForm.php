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
    <title>Search Tutor</title>
    <link rel="stylesheet" type="text/css" href="styleSheet.css" />
</head>

<body>
    <div id="form" class="searchForm">
        <form id="searchTutForm" action="PHP/searchTutor.php" method="post">
            <table>
                <tr class="spaceUnder">
                    <td><label>Course: </label>
                    <select name="course">
                        <?php
                            $courses = mysqli_query($conn, "SELECT * FROM Course");
                            while ($row = mysqli_fetch_array($courses, MYSQLI_NUM)) {
                                $val = "$row[0]" . "," . "$row[1]";
                                echo "<option value=$val>" . $row[0] . " " . $row[1] . "</option>";
                            }
                            mysqli_free_result($courses);
                            mysqli_free_result($val);
                            mysqli_free_result($row);
                        ?>
                    </select>
                    </td>
                </tr>
                <tr class="spaceUnder">
                    <td><label>Availability: Note - tutor sessions can only be scheduled 1 hr/week per course</label></td>
                </tr>
                <table>
                <tr><td>Time</td><td>Monday</td><td>Tuesday</td><td>Wednesday</td><td>Thursday</td><td>Friday</td></tr>
                    <tr><td>8 AM</td>
                    <td align="center"><input type="checkbox" name="monday[]" value="800"></td>
                    <td align="center"><input type="checkbox" name="tuesday[]" value="800"></td>
                    <td align="center"><input type="checkbox" name="wednesday[]" value="800"></td>
                    <td align="center"><input type="checkbox" name="thursday[]" value="800"></td>
                    <td align="center"><input type="checkbox" name="friday[]" value="800"></td></tr>
                    <tr><td>9 AM</td>
                    <td align="center"><input type="checkbox" name="monday[]" value="900"></td>
                    <td align="center"><input type="checkbox" name="tuesday[]" value="900"></td>
                    <td align="center"><input type="checkbox" name="wednesday[]" value="900"></td>
                    <td align="center"><input type="checkbox" name="thursday[]" value="900"></td>
                    <td align="center"><input type="checkbox" name="friday[]" value="900"></td></tr>
                    <tr><td>10 AM</td>
                    <td align="center"><input type="checkbox" name="monday[]" value="1000"></td>
                    <td align="center"><input type="checkbox" name="tuesday[]" value="1000"></td>
                    <td align="center"><input type="checkbox" name="wednesday[]" value="1000"></td>
                    <td align="center"><input type="checkbox" name="thursday[]" value="1000"></td>
                    <td align="center"><input type="checkbox" name="friday[]" value="1000"></td></tr>
                    <tr><td>11 AM</td>
                    <td align="center"><input type="checkbox" name="monday[]" value="1100"></td>
                    <td align="center"><input type="checkbox" name="tuesday[]" value="1100"></td>
                    <td align="center"><input type="checkbox" name="wednesday[]" value="1100"></td>
                    <td align="center"><input type="checkbox" name="thursday[]" value="1100"></td>
                    <td align="center"><input type="checkbox" name="friday[]" value="1100"></td></tr>
                    <tr><td>12 PM</td>
                    <td align="center"><input type="checkbox" name="monday[]" value="1200"></td>
                    <td align="center"><input type="checkbox" name="tuesday[]" value="1200"></td>
                    <td align="center"><input type="checkbox" name="wednesday[]" value="1200"></td>
                    <td align="center"><input type="checkbox" name="thursday[]" value="1200"></td>
                    <td align="center"><input type="checkbox" name="friday[]" value="1200"></td></tr>
                    <tr><td>1 PM</td>
                    <td align="center"><input type="checkbox" name="monday[]" value="1300"></td>
                    <td align="center"><input type="checkbox" name="tuesday[]" value="1300"></td>
                    <td align="center"><input type="checkbox" name="wednesday[]" value="1300"></td>
                    <td align="center"><input type="checkbox" name="thursday[]" value="1300"></td>
                    <td align="center"><input type="checkbox" name="friday[]" value="1300"></td></tr>
                    <tr><td>2 PM</td>
                    <td align="center"><input type="checkbox" name="monday[]" value="1400"></td>
                    <td align="center"><input type="checkbox" name="tuesday[]" value="1400"></td>
                    <td align="center"><input type="checkbox" name="wednesday[]" value="1400"></td>
                    <td align="center"><input type="checkbox" name="thursday[]" value="1400"></td>
                    <td align="center"><input type="checkbox" name="friday[]" value="1400"></td></tr>
                    <tr><td>3 PM</td>
                    <td align="center"><input type="checkbox" name="monday[]" value="1500"></td>
                    <td align="center"><input type="checkbox" name="tuesday[]" value="1500"></td>
                    <td align="center"><input type="checkbox" name="wednesday[]" value="1500"></td>
                    <td align="center"><input type="checkbox" name="thursday[]" value="1500"></td>
                    <td align="center"><input type="checkbox" name="friday[]" value="1500"></td></tr>
                    <tr class="spaceUnder"><td>4 PM</td>
                    <td align="center"><input type="checkbox" name="monday[]" value="1600"></td>
                    <td align="center"><input type="checkbox" name="tuesday[]" value="1600"></td>
                    <td align="center"><input type="checkbox" name="wednesday[]" value="1600"></td>
                    <td align="center"><input type="checkbox" name="thursday[]" value="1600"></td>
                    <td align="center"><input type="checkbox" name="friday[]" value="1600"></td></tr>
                </table>
                <tr> 
                    <td><input type="submit" value="Submit"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>