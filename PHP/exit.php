<?php
	session_start();
    $_SESSION['GTID'] = null;
    session_destroy();
	header("Location:../index.php");
?>