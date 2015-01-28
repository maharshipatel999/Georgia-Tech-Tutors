<?php 
	session_start();
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
	<title>Summary 1</title>
    <link rel="stylesheet" type="text/css" href="styleSheet.css" />
</head>

<body>
	<div id="form" class="summary1">
    	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="text">
        	<table width="100%">
            	<tr>
                <td>Academic Year 2014</td> 
                <td>Fall: <input type="checkbox" name="semester[]" value="Fall"/></td>
                <td>Spring: <input type="checkbox" name="semester[]" value="Spring"/></td>
                <td>Summer: <input type="checkbox" name="semester[]" value="Summer"/></td>
                <td><input type="submit" name="submit" value="OK" /></td></tr>
            </table>
         <div style="height:70%;overflow-y:auto;" > 
        	<table width="100%" height="80%">
        	<thead>
        	<tr><th>Semester</th><th>#Students</th><th>#Tutors</th></tr></thead>
            <?php  $courses = mysqli_query($conn, "SELECT * FROM Course");
                           while ($row = mysqli_fetch_array($courses, MYSQLI_NUM)) {
                               if ($_SERVER['REQUEST_METHOD'] == "POST") {
								   		if(!empty($_POST['back'])) {
											header("Location:mainMenu.php");
										}else if(!empty($_POST['semester'])) {
											$semesters = array();
											$semesters = $_POST['semester'];
											$query = "SELECT H.Semester AS Semester,". 
														" COUNT( H.UndergradEmail ) AS TotalStudents,".
														" COUNT( H.TutorEmail ) AS TotalTutors".
														" FROM Hires AS H".
														" WHERE H.CourseSchool =  '$row[0]'".
														" AND H.CourseNumber =  '$row[1]'".
														" AND ( ";
														
											for($i = 0;$i < count($semesters); $i++) { 
												if($i == 0) {
													$query = $query."H.Semester =  '".$semesters[$i]."' ";
													
												} else {
													$query = $query."OR H.Semester =  '".$semesters[$i]."' ";
														
												}
											}
											$query = $query." ) GROUP BY H.Semester;";
											$result = mysqli_query($conn,$query);
											$resultArray = mysqli_fetch_all($result,MYSQLI_NUM);
											if(count($resultArray) > 0 ){
												echo "<tr bgcolor='#CCCCCC'><td colspan='3' align='center'>$row[0]" . " " . "$row[1]</td></tr>";
											}
											foreach($resultArray as $summary) {
												echo "<tr><td align='center'>$summary[0]</td>
														<td align='center' >$summary[1]</td>
														<td align='center' >$summary[2]</td></tr>";
											}
										}
									}		
                               }
                        mysqli_free_result($courses);
                        ?>
                    </table>
        </div>
        <input type="submit" name="back" value="OK" style="display:block" />
        </form>
     </div>
</body>
</html>


