<?php

@include 'config.php';

session_start();
session_unset();    // remove all session variables
session_destroy();  // destroy the session 
//All session variables are now removed, and the session is destroyed.
                    
header('location:login.php');

?>

<!-- Session variables hold information about one single user, and 
are available to all pages in one application.

it knows when you start the application and when you end. 

-->