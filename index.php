<?php session_start(); ?>

<html>
<head>
	<title>CS 4400</title>
    <link rel="stylesheet" type="text/css" href="styleSheet.css" />
</head>

<body>
	<div id="form" class="loginForm">
    	<form action="PHP/login.php" method="post">
        	<span>
                <?php 
                    if ($_SESSION['invalidGTIDorPass'] == TRUE) {
                        echo "GTID or Password invalid!";
                    }
                ?>
            </span>
            <table style="width:100%">
                <tr class="spaceUnder">
                    <td align="center">Georgia Tech Tutors</td>
                </tr>
            </table>
        	<table>
                <tr>
            	   <td><label>GTID</label></td>
                    <td><input type="text" name="gtid"/><br/></td></tr>
                <tr>
                    <td><label>Password</label></td>
                    <td><input type="password" name="password" /></td></tr>
                <tr><td align="center" colspan="2" ><input type="submit" value="LogIn" /></td></tr>	
        </form>
    </div>
</body>
</html>
