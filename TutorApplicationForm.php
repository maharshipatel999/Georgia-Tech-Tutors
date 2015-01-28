<?php require('PHP/TutorApplication.php');?>

<html>
<head>
	<title>Tutor Application</title>
    <link rel="stylesheet" type="text/css" href="styleSheet.css" />
</head>

<body>
	<div id="form" class="tutorAppForm">
    	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="text">
        	
            <table style="width:100%">
                <tr class="spaceUnder">
                    <td align="center">Tutor Application</td>
                </tr>
            </table>
            <div id="tutorAppFormLeft">
        	<table>
                	<tr>
            	  	<td><label>GTID</label></td>
                    <td><input type="text" name="gtid" value="<?php echo $gtid; ?>"/><span id="errorSpan"><?php echo $gtidError ?></span><br/></td></tr>
               		<tr>
                    <td><label>First Name</label></td>
                    <td><input type="text" name="firstName" value="<?php echo $firstName; ?>"/><span id="errorSpan"><?php echo $fnameError ?></span></td></tr>
                 	<tr>
                    <td><label>Last Name</label></td>
                    <td><input type="text" name="lastName" value="<?php echo $lastName; ?>"/><span id="errorSpan"><?php echo $lnameError ?></span></td></tr>
                    <tr>
                    <td><label>Email</label></td>
                    <td><input type="text" name="email" value="<?php echo $email; ?>" /><span id="errorSpan"><?php echo $emailError ?></span></td></tr>
                    <tr>
                    <td><label>Phone</label></td>
                    <td><input type="text" name="phone" value="<?php echo $phone; ?>" /><span id="errorSpan"><?php echo $phoneError ?></span></td></tr>
                    <tr>
                    <td><label>GPA</label></td>
                    <td><input type="text" name="gpa" value="<?php echo $gpa; ?>" /><span id="errorSpan"><?php echo $gpaError ?></span></td></tr>
                    <tr>
            </table>
            </div>
            <div id="tutorAppFormMiddle">
            <table>
            	<tr><td colspan="2"><span id="errorSpan"><?php echo $gradStatusError; ?></span></td></tr>
                <tr>
                <td><input type="radio" name="gradStatus" value="UnderGrad"></td><td colspan="2">Undergraduate</td></tr>
                <tr>
                <td><input type="radio" name="gradStatus" value="grad"></td><td colspan="2">Graduate</td></tr>
            </table>
            <br/>
            	<table><tr><td colspan="2"><span id="errorSpan"><?php echo $courseError; ?></span></td></tr></table>
                <div style="overflow-y:auto;height:50%">
                    <table>
                    <tr><td colspan="2" align="center"><strong>Course</strong></td><td>GTA</td></tr>
                        <?php  $courses = mysqli_query($conn, "SELECT * FROM Course");
                                        while ($row = mysqli_fetch_array($courses, MYSQLI_NUM)) {
                                            $val = "$row[0]" . "," . "$row[1]";
											echo "<tr>
                                                    <td><input type='checkbox' name='course[]' value='$val' ></td>
                                                    <td>" . $row[0] . " " . $row[1] . "</td>
                                                    <td align='center' ><input type='checkbox' name='$val-gta' value='$val-gta'></td></tr>";
                                        }
                                        mysqli_free_result($courses);
                        ?>
                    </table>
                </div>
            </div>
            <div id="tutorAppFormRight">
           	<table>
            <tr><td colspan="6"><span id="errorSpan"><?php echo $timeSlotError; ?></span></td></tr>
            <tr><td>Time</td><td>Monday</td><td>Tuesday</td><td>Wednesday</td><td>Thursday</td><td>Friday</td></tr>
            	<tr><td>8 AM</td>
            	<td align="center"><input type="checkbox" name="Monday[]" value="800"></td>
                <td align="center"><input type="checkbox" name="Tuesday[]" value="800"></td>
                <td align="center"><input type="checkbox" name="Wednesday[]" value="800"></td>
                <td align="center"><input type="checkbox" name="Thursday[]" value="800"></td>
                <td align="center"><input type="checkbox" name="Friday[]" value="800"></td></tr>
             	<tr><td>9 AM</td>
            	<td align="center"><input type="checkbox" name="Monday[]" value="900"></td>
                <td align="center"><input type="checkbox" name="Tuesday[]" value="900"></td>
                <td align="center"><input type="checkbox" name="Wednesday[]" value="900"></td>
                <td align="center"><input type="checkbox" name="Thursday[]" value="900"></td>
                <td align="center"><input type="checkbox" name="Friday[]" value="900"></td></tr>
                <tr><td>10 AM</td>
            	<td align="center"><input type="checkbox" name="Monday[]" value="1000"></td>
                <td align="center"><input type="checkbox" name="Tuesday[]" value="1000"></td>
                <td align="center"><input type="checkbox" name="Wednesday[]" value="1000"></td>
                <td align="center"><input type="checkbox" name="Thursday[]" value="1000"></td>
                <td align="center"><input type="checkbox" name="Friday[]" value="1000"></td></tr>
                <tr><td>11 AM</td>
            	<td align="center"><input type="checkbox" name="Monday[]" value="1100"></td>
                <td align="center"><input type="checkbox" name="Tuesday[]" value="1100"></td>
                <td align="center"><input type="checkbox" name="Wednesday[]" value="1100"></td>
                <td align="center"><input type="checkbox" name="Thursday[]" value="1100"></td>
                <td align="center"><input type="checkbox" name="Friday[]" value="1100"></td></tr>
                <tr><td>12 PM</td>
            	<td align="center"><input type="checkbox" name="Monday[]" value="1200"></td>
                <td align="center"><input type="checkbox" name="Tuesday[]" value="1200"></td>
                <td align="center"><input type="checkbox" name="Wednesday[]" value="1200"></td>
                <td align="center"><input type="checkbox" name="Thursday[]" value="1200"></td>
                <td align="center"><input type="checkbox" name="Friday[]" value="1200"></td></tr>
                <tr><td>1 PM</td>
            	<td align="center"><input type="checkbox" name="Monday[]" value="1300"></td>
                <td align="center"><input type="checkbox" name="Tuesday[]" value="1300"></td>
                <td align="center"><input type="checkbox" name="Wednesday[]" value="1300"></td>
                <td align="center"><input type="checkbox" name="Thursday[]" value="1300"></td>
                <td align="center"><input type="checkbox" name="Friday[]" value="1300"></td></tr>
                <tr><td>2 PM</td>
            	<td align="center"><input type="checkbox" name="Monday[]" value="1400"></td>
                <td align="center"><input type="checkbox" name="Tuesday[]" value="1400"></td>
                <td align="center"><input type="checkbox" name="Wednesday[]" value="1400"></td>
                <td align="center"><input type="checkbox" name="Thursday[]" value="1400"></td>
                <td align="center"><input type="checkbox" name="Friday[]" value="1400"></td></tr>
                <tr><td>3 PM</td>
            	<td align="center"><input type="checkbox" name="Monday[]" value="1500"></td>
                <td align="center"><input type="checkbox" name="Tuesday[]" value="1500"></td>
                <td align="center"><input type="checkbox" name="Wednesday[]" value="1500"></td>
                <td align="center"><input type="checkbox" name="Thursday[]" value="1500"></td>
                <td align="center"><input type="checkbox" name="Friday[]" value="1500"></td></tr>
                <tr><td>4 PM</td>
            	<td align="center"><input type="checkbox" name="Monday[]" value="1600"></td>
                <td align="center"><input type="checkbox" name="Tuesday[]" value="1600"></td>
                <td align="center"><input type="checkbox" name="Wednesday[]" value="1600"></td>
                <td align="center"><input type="checkbox" name="Thursday[]" value="1600"></td>
                <td align="center"><input type="checkbox" name="Friday[]" value="1600"></td></tr>
            </table>
            </div>
            <table style="width:100%;marign-top:5px;">
                <tr><td align="center" colspan="2" ><input type="submit" value="Submit" /></td></tr>
            </table>
        </form>
    </div>
</body>
</html>