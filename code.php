<?php

    require('./config.php');

    if(isset($_POST['checking_view'])){
        $row_id = $_POST['row_id'];
        // echo $return = $row_id;

        $result = mysqli_query($db,"SELECT * FROM `users` WHERE id='$row_id'");
                            
        if(!$result){
            die("Invalid Query !!!".mysqli_connect_error());
        }
        else{
            while($row = mysqli_fetch_assoc($result)){
                $file = $row['image'];
                $target = './images/';

                if ($file && file_exists($target . $file)) {
                    $image = "<img src='$target$file' alt='user image'>";
                } else {
                    $image = "No Image";
                }

                echo $return = "
                    <h5> ID : $row[id]</h5>
                    <h5> Name : $row[name]</h5>
                    <h5> Email : $row[email]</h5>
                    <h5> Phone : $row[phone]</h5>
                    <h5> Role : $row[role] </h5>
                    <h5> Gender : $row[gender]</h5>
                    <h5> Aadhar : $row[aadhar]</h5>
                    <h5> Pic : $image </h5>
                ";

            }
        }
    }

?>