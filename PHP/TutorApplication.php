<?php session_start();
	if(!isset($_SESSION['GTID'])){
 		header("Location:index.php");
 	}
	
	$conn=mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$gtid = $firstName = $lastName = $phone = $gpa = $email = $name = $gradStatus =
	$timeSlot = "";
	$courses = array();
	
	$fnameError = $lnameError = $gtidError = $emailError = $phoneError = $gpaError =
	$gradStatusError = $courseError = $timeSlotError = "";
	
	$valid = true;
	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$name = "";
		$floatVal = floatval($_POST["gpa"]);
		$days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
		$emptyTimeSlots = true;
		$timeSlots = array();
		
		if(!empty($_POST['gtid']) && $_SESSION['GTID'] == $_POST['gtid']) {
			$gtid = $_POST['gtid'];
		} else {
			$gtidError = "*";
			$valid = false;
		}
		
		if(!empty($_POST["lastName"]) && !empty($_POST["lastName"]) && $gtid != "") {
			$firstName = $_POST['firstName'];
			$lastName = $_POST["lastName"];
			$name = $firstName." ".$lastName;
			
			$result = mysqli_query($conn,"SELECT * FROM Student WHERE GTID ='$gtid' and Name ='$name'");
			$resultArray = mysqli_fetch_array($result,MYSQLI_NUM);
			$count = count($resultArray);
			
			if($count == 0) {
				$fnameError = "*";
				$lnameError = "*";
				$valid = false;
			}
			
		} else { 
			if(empty($_POST['firstName'])) {
				$fnameError = "*";
				$valid = false;
			}
			
			if(empty($_POST["lastName"])) {
				$lnameError = "*";
				$valid = false;
			}
		}
		
		if(!empty($_POST["email"])) {
			$email = $_POST["email"];
			$result = mysqli_query($conn,"SELECT * FROM Student WHERE GTID ='$gtid' and Email ='$email'");
			$resultArray = mysqli_fetch_array($result,MYSQLI_NUM);
			$count = count($resultArray);
			
			if($count == 0) {
				$emailError = "*";
				$valid = false;
			}
		} else {
			$emailError = "*";
			$valid = false;
		}
		
		if(!empty($_POST["phone"]) && !preg_match('/[^0-9]/',$_POST["phone"])) {
			$phone = $_POST["phone"];
		} else {
			$phoneError = "*";
			$valid = false;
		}
		
		if(!empty($_POST["gpa"]) && !($floatVal > (float) 4)) {
			$gpa = $_POST["gpa"];
		} else {
			$gpaError = "*";
			$valid = false;
		}
		
		if(!empty($_POST["gradStatus"])) {
			$gradStatus = $_POST["gradStatus"];
		} else {
			$gradStatusError = "*Select One";
			$valid = false;
		}
		
		if(!empty($_POST["course"])) {
			$courses = $_POST["course"];
		} else {
			$courseError = "*Select a Course";
			$valid = false;
		}
		
		foreach($days as $day) {
			if(!empty($_POST[$day])) {
				$emptyTimeSlots = false;
				$timeSlots[$day] = array();
				$timeSlots[$day] = $_POST[$day];
			}
		}
		
		if($emptyTimeSlots) {
			$timeSlotError = "*Select a time slot";
			$valid = false;
		}
		
		if($valid) {
			mysqli_query($conn,"INSERT INTO Tutor (Email,Phone,GPA) VALUES ('$email','$phone','$gpa');");
			if (mysqli_connect_errno()) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
				
			}
			
			foreach($timeSlots as $key => $value){
			  foreach($value as $time) {
				  	mysqli_query($conn,"INSERT INTO TutorTimeSlot (Email,Time,Semester,Weekday)".
											"VALUES ('$email',$time,'Summer','$key');");
					if (mysqli_connect_errno()) {
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
						
					}
			  }
			}
			
			foreach($courses as $course) {
				$isGTA = 0;
				if(!empty($_POST[$course."-gta"])){
					$isGTA = 1;
				}
				list($school,$number) = explode(",", $course);
				
				mysqli_query($conn,"INSERT INTO Tutors	 (Email,CourseSchool,CourseNumber,GTA)".
											"VALUES ('$email','$school','$number',$isGTA);");
					if (mysqli_connect_errno()) {
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
						
					}
			}
		}
	}
?>