<?php

    require_once('./config.php');

    // phpinfo();

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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Box Icons Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- Jquery Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js">

</head>

<body>

    <!-- Row View Modal using Bootstrap -->
    <div class="modal fade" id="row_view_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row_viewing_data">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <!----------------MAIN SECTION ----------------------------->
    <div class="main">

        <!-------------- Admin Content ------------------------------>
        <div class="admin-content">
            <div class="button-group">
                <a href="./create.php" class="admin-btn btn-blg">Add Member</a>
                <a href="./index.php" class="admin-btn btn-blg">Manage Members</a>
            </div>

            <div class="content">
                <h2 class="page-title">Manage Members</h2>

                <table>
                    <thead>
                        <th>S. No.</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        <th>Photo</th>
                        <th>Role</th>
                        <th colspan="3">Action</th>
                    </thead>
                    <tbody>

                        <?php 

                            $result = mysqli_query($db,"SELECT * FROM `users`");
                            
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

                                    echo "
                                        <tr>
                                            <td class='row_id'>$row[id]</td>
                                            <td>$row[name]</td>
                                            <td>$row[email]</td>
                                            <td>$row[phone]</td>
                                            <td>$image</td>
                                            <td>$row[role]</td>
                                            <td><a href='#' class='view'>View</a></td>
                                            <td><a href='./edit.php?id=$row[id]' class='edit'>Edit</a></td>
                                            <td><a href='./delete.php?id=$row[id]' class='delete' onclick='return checkdelete()'>Delete</a></td>
                                        </tr>
                                    ";
                                }
                            }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Jquery Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script>
        function checkdelete(){
            return confirm('Are you sure you want to delete ?');
        }

        $(document).ready(function () {
            
            $('.view').click(function (e) { 
                e.preventDefault();
                // alert('Hello.......');

                var row_id = $(this).closest('tr').find('.row_id').text();
                // console.log($row_id);

                $.ajax({
                    type: "POST",
                    url: "code.php",
                    data: {
                        'checking_view' : true,
                        'row_id' : row_id,

                    },
                    success: function (response) {
                        // console.log(response);
                        $('.row_viewing_data').html(response);
                        $('#row_view_modal').modal('show');
                    }
                });
            });
        });

    </script>
        
</body>

</html>