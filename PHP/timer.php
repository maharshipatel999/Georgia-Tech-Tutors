<?php

    if (isset($_SESSION['LAST_ACTIVITY'])) {
        $lastTime = $_SESSION['LAST_ACTIVITY'];
        echo "<h1> $lastTime </h1>";
        if ((time() - $lastTime > 10)) {
            session_unset();     // unset $_SESSION variable for the run-time 
            session_destroy();   // destroy session data in storage
        }
    }    
    $_SESSION['LAST_ACTIVITY'] = time();

?>