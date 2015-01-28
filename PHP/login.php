<?php
	session_start();
	$conn=mysqli_connect('academic-mysql.cc.gatech.edu','cs4400_Group_9','PY56oMC0','cs4400_Group_9');
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$gtid = $_POST['gtid'];
    $pass = $_POST['password'];
	
   	$result = mysqli_query($conn,"SELECT * FROM User WHERE GTID ='$gtid' and Password ='$pass'");
	
	$resultArray = mysqli_fetch_array($result,MYSQLI_NUM);
	
	$count = count($resultArray);
	
	if($count != 0) {
		$GLOBALS["GTID"] = $gtid;
		$_SESSION['GTID'] = $gtid;
		$_SESSION['invalidGTIDorPass'] = FALSE;
		header("Location:../mainMenu.php");
	} else {
		$_SESSION['invalidGTIDorPass'] = TRUE;
		header("Location:../index.php");
	}
	mysqli_close($conn);
?>