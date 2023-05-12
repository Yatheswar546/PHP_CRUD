<?php

    require_once('./config.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        echo $id;
        $sql = mysqli_query($db,"DELETE FROM `users` WHERE id=$id");

        if($sql){
            header("Location: index.php");
            exit;
        }
        else{
            die("Something went wrong".mysqli_connect_error());
        }
    }

?>