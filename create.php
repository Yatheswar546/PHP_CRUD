<?php

    require_once('./config.php');
    
    if($db){
        // echo "Database Successfully Connected";
    }
    else{
        die("Error".mysqli_connect_error());
    }

    $username = "";
    $email = "";
    $phone = "";
    $gender = "";
    $role = "";
    $aadhar = "";
    $file = "";
    $password = "";
    $passwordConf = "";

    $errormsg = "";
    $successmsg = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $role = $_POST['role'];
        $aadhar = $_POST['aadhar'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];

        $target = './images/';
        $filename = $_FILES['image']['name'];
        $filetype = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $target_file = $target.basename(md5('userid'.$_FILES['image']['name']).".".$filetype);
        $file = md5('userid'.$_FILES['image']['name']).".".$filetype;

        $userid = md5(substr($username,0,3).substr($email,0,3).substr($phone,0,3).random_int(10000,99999));

        $enc_password = md5($password);

        do{
            if(empty($username) || empty($email) || empty($phone) || empty($gender) || empty($role) || empty($aadhar) || empty($password) || empty($passwordConf) || empty($file)){
                $errormsg = "All Fields are Required!!!";
                break;
            }
            else{
                if($password != $passwordConf){
                    $errormsg = "Password Should Match!!!";
                }else{
                    if(strlen($aadhar) != 12 or !is_numeric($aadhar)){
                        $errormsg = "Enter Valid Aadhar Number!!!";        
                    }else{
                        if($filetype == "jpg" || $filetype == "jpeg" || $filetype == "png"){
                            if(move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
                                $sql = mysqli_query($db,"INSERT INTO `users`(`name`, `email`, `phone`, `gender`, `role`, `aadhar`, `image`, `password`, `userid`) VALUES ('$username','$email','$phone','$gender','$role','$aadhar','$file','$enc_password','$userid')");
                                if($sql){
                                    $successmsg = "You have succesfully added a Member";
                                    header('Location: index.php');
                                    exit;
                                }else{
                                    $errormsg = "Something went wrong !!!";
                                }
                            }else{
                                $errormsg = "Image Not Moved!!!";
                            }
                        }else{
                            $errormsg = "Image Not Accepted !!!";
                        }
                    }
                }
            }
        }while(false);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operations</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./style.css">
    
    <!-- Box Icons Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>


    <!----------------MAIN SECTION ----------------------------->
    <div class="main">

        <!-- Admin Content -->
        <div class="admin-content">
            <div class="button-group">
                <a href="./create.php" class="admin-btn btn-blg">Add Member</a>
                <a href="./index.php" class="admin-btn btn-blg">Manage Members</a>
            </div>

            <div class="content">
                <h2 class="page-title">Add Member</h2>

                <?php
                    if(!empty($errormsg)){
                        echo"
                            <div class='error_msg'>
                                <strong>$errormsg</strong>
                            </div>
                        ";
                    }
                ?>

                <form action="#" method="post" enctype="multipart/form-data">
                    <div>
                        <label>Username</label>
                        <input type="text" name="name" class="text-input">
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" class="text-input">
                    </div>
                    <div>
                        <label>Phone No.</label>
                        <input type="text" name="phone" class="text-input">
                    </div>
                    <div>
                        <label>Gender</label>
                        <div class="gender">
                            <input type="radio" name="gender" id="male" value="Male">
                            <label>Male</label>
                        </div>
                        <div class="gender">
                            <input type="radio" name="gender" id="female" value="Female">
                            <label>Female</label>
                        </div>
                    </div>
                    <div>
                        <label>Role</label>
                        <select name="role" class="text-input">
                            <option value="Student">Student</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Non Teaching Staff">Non Teaching Staff</option>
                        </select>
                    </div>
                    <div>
                        <label>Aadhar Card No.</label>
                        <input type="text" name="aadhar" class="text-input">
                    </div>
                    <div>
                        <label>Profile Pic</label>
                        <input type="file" name="image" class="text-input">
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="password" name="password" class="text-input">
                    </div>
                    <div>
                        <label>Confirm Password</label>
                        <input type="password" name="passwordConf" class="text-input">
                    </div>

                    <?php
                        if(!empty($successmsg)){
                            echo"
                                <div class='success_msg'>
                                    <strong>$successmsg</strong>
                                </div>
                            ";
                        }
                    ?>

                    <div>
                        <button type="submit" class="admin-btn btn-blg">Add Member</button>
                        <a href="./index.php" class="admin-btn btn-blg">Cancel</a>
                    </div>
                </form>

            </div>

        </div>
    </div>


    <!----- CkEditor 5 Script -------------------->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>

    <script src="./script.js"></script>
    
</body>
</html>