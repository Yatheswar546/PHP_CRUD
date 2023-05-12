<?php

    $db = mysqli_connect('localhost','root','','crud');

    if($db){
        // echo "Database Successfully Connected";
    }
    else{
        die("Error".mysqli_connect_error());
    }

?>