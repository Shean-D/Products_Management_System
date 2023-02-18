<?php
include '../header.php';
include '../nav.php';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary">

                        <!-- /.card-header -->
                        <!-- form start -->
                        <?php
                        extract($_POST);
                        if (empty($action)) {
                            $action = "create_account";
                            $form_title = "Create";
                            $submit = "Create";
                        }

                        $submit = "Save";

                        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "create_account") {
                            $FirstName = dataClean($FirstName);
                            $LastName = dataClean($LastName);
                            $Address = dataClean($Address);
                            $Email = dataClean($Email);
                            $TelNo = dataClean($TelNo);
                            $UserName = dataClean($UserName);

                            $message = array();
                            //start validation
                            if (empty($UserName)) {
                                $message['UserName'] = "User should not be empty";
                            }
                            //End validation
                            if (empty($message)) {
                                $target_dir = "../uploads/";
                                $target_file = $target_dir . basename($_FILES["ProfileImage"]["name"]);
                                $uploadOk = 1;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $check = getimagesize($_FILES["ProfileImage"]["tmp_name"]);
                                if ($check !== false) {
//Multi-purpose Internet Mail Extensions                       
                                    $uploadOk = 1;
                                } else {
                                    $message['ProfileImage'] = "File is not an image.";
                                    $uploadOk = 0;
                                }
                                // Check if file already exists
                                if (file_exists($target_file)) {
                                    $message['ProfileImage'] = "Sorry, file already exists.";
                                    $uploadOk = 0;
                                }
// Check file size
                                if ($_FILES["ProfileImage"]["size"] > 5000000) {
                                    $message['ProfileImage'] = "Sorry, your file is too large.";
                                    $uploadOk = 0;
                                }

                                // Allow certain file formats
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    $message['ProfileImage'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                    $uploadOk = 0;
                                }
                                if ($uploadOk == 1) {
                                    if (move_uploaded_file($_FILES["ProfileImage"]["tmp_name"], $target_file)) {
                                        $Photo = htmlspecialchars(basename($_FILES["ProfileImage"]["name"]));
                                    } else {
                                        $message['ProfileImage'] = "Sorry, there was an error uploading your file.";
                                    }
                                }

                            }
                            //Insert record
                            if (empty($message)) {
                                $db = dbConn();
                                $sql = "INSERT INTO tbl_users ("
                                        . "Title,"
                                        . "FirstName,"
                                        . "LastName,"
                                        . "Address,"
                                        . "Email,"
                                        . "TelNo,"
                                        . "UserName,"
                                        . "Password,ProfilePhoto)VALUES("
                                        . "'$Title',"
                                        . "'$FirstName',"
                                        . "'$LastName',"
                                        . "'$Address',"
                                        . "'$Email',"
                                        . "'$TelNo',"
                                        . "'$UserName',"
                                        . "'" . sha1($Password) . "','$Photo')";
                                $db->query($sql);
                            }
                            //insert Record
                            $action = "create_account";
                            $form_title = "Create";
                            $submit = "Create";
                        }

                        //edit record
                        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "edit_account") {
//                            echo $UserId;
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_users WHERE UserId='$UserId'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();

                            $Title = $row['Title'];
                            $FirstName = $row['FirstName'];
                            $LastName = $row['LastName'];
                            $Address = $row['Address'];
                            $Email = $row['Email'];
                            $TelNo = $row['TelNo'];
                            $UserName = $row['UserName'];
                            $Password = $row['Password'];
                            $UserId = $row['UserId'];
                            $action = "update_account";
                            $form_title = "Update";
                            $submit = "Update";
                        }
                        //end edit record
                        //update record
                        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "update_account") {
                            $db = dbConn();
                            $sql = "UPDATE tbl_users SET "
                                    . "Title='$Title ',"
                                    . "FirstName='$FirstName',"
                                    . "LastName='$LastName',"
                                    . "Address='$Address',"
                                    . "Email='$Email',"
                                    . "TelNo='$TelNo' "
                                    . "WHERE UserId='$UserId'";
                            $db->query($sql);
                            $submit = "Update";
                        }
                        ?>
                        <div class="card-header">
                            <h3 class="card-title"><?php echo @$form_title; ?>User Account</h3>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="Title">Select Title</label>
                                    <select class="form-control" name="Title" id="Title">
                                        <option value="">--</option>
                                        <option value="Mr." <?php if (@$Title == 'Mr.') { ?> selected <?php } ?>>Mr.</option>
                                        <option value="Miss." <?php if (@$Title == 'Miss.') { ?> selected <?php } ?>>Miss.</option>
                                        <option value="Ms." <?php if (@$Title == 'Ms.') { ?> selected <?php } ?>>Ms.</option>
                                        <option value="Mrs." <?php if (@$Title == 'Mrs.') { ?> selected <?php } ?>>Mrs.</option>
                                        <option value="Dr." <?php if (@$Title == 'Dr.') { ?> selected <?php } ?>>Dr.</option>
                                        <option value="Prof." <?php if (@$Title == 'Prof.') { ?> selected <?php } ?>>Prof.</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="FirstName">First Name</label>
                                    <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="Enter First Name" value="<?php echo @$FirstName; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="LastName">Last Name</label>
                                    <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Enter Last Name" value="<?php echo @$LastName; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Address">Address</label>
                                    <textarea class="form-control" id="Address" name="Address" placeholder="Enter Address"><?php echo @$Address; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="Email">Email address</label>
                                    <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter email" value="<?php echo @$Email; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="TelNo">Tel.No</label>
                                    <input type="text" class="form-control" id="TelNo" name="TelNo" placeholder="Enter Tel No" value="<?php echo @$TelNo; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="UserName">User Name</label>
                                    <input type="text" class="form-control" id="UserName" name="UserName" placeholder="Enter User Name" value="<?php echo @$UserName; ?>">

                                </div>
<!--                                <div><?php echo @$message; ?></div>-->
                                <div class="form-group">
                                    <label for="Password">Password</label>
                                    <input type="password" class="form-control" id="Password" name="Password" placeholder="Password" value="<?php echo @$Password; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="ProfileImage" class="form-label">Profile Image</label>
                                    <input class="form-control" type="file" id="ProfileImage" name="ProfileImage">
                                    <div class="text-danger"><?php echo @$message['ProfileImage']; ?></div>

                                </div>


                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="hidden" name="UserId" value="<?php echo @$UserId; ?>">
                                <button type="submit" class="btn btn-primary" name="action" value="<?php echo @$action; ?>"><?php echo $submit; ?></button>
                                <button type="submit" class="btn btn-primary" name="action" value="cancel">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "delete_account") {
//                       echo 'do you want to delete';
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Delete confirmation</h3>
                            </div>
                            <div class="card-body">
                                <h4>Are you sure want to delete this record</h4>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <input type="hidden" name="UserId" value="<?php echo $UserId; ?>">
                                    <button type=""submit" name="action" value="delete_account_confirm" class="btn btn-danger">yes</i></button>
                                    <button type=""submit" name="action" value="delete_account_cancel" class="btn btn-danger">No</i></button>
                                </form>
                            </div>
                        </div>


                        <?php
//                            $db= dbConn();
//                            $sql="DELETE FROM tbl_users WHERE UserId='$UserId'";
//                            $db->query($sql);
//                            $submit="Save";
                    }
                    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "delete_account_confirm") {
                        $db = dbConn();
                        $sql = "DELETE FROM tbl_users WHERE UserId='$UserId'";
                        $db->query($sql);
                    }
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable with minimal features & hover style</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                <input type="text" name="FirstName" id="FirstName" class="form-control" placeholder="enter first name">
                                <button type=""submit" name="action" value="search_account" class="btn btn-warning mt-2">search</button>
                            </form>
                            <?php
                            $where = null;
                            if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "search_account") {
                                if (!empty($FirstName)) {
                                    $where = "WHERE FirstName='$FirstName'";
                                }
                            }
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_users $where";
                            $result = $db->query($sql);
                            ?>
                            <table id="user_list" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Profile Image</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                        <input type="hidden" name="UserId" value="<?php echo $row['UserId']; ?>">
                                                        <button type=""submit" name="action" value="edit_account" class="btn btn-warning"><i class="fas fa-user-edit"></i></button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form id="delete<?php echo $row['UserId']; ?>" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                        <input type="hidden" name="UserId" value="<?php echo $row['UserId']; ?>">
                                                        <input type="hidden" name="action" value="delete_account_confirm">
                                                        <button type="button" name="action" onclick="deleteUser('<?php echo $row['UserId']; ?>')" value="delete_account" class="btn btn-danger"><i class="fas fa-user-times"></i></button>
                                                    </form>
                                                </td>
                                                <td><?php echo $row['Title']; ?><?php echo $row['FirstName']; ?><?php echo $row['LastName']; ?></td>
                                                <td><?php echo $row['Email']; ?></td>
                                                <td><img class="img-fluid" width="100" src="<?php echo SITE_URL;?>uploads/<?php echo $row['ProfilePhoto'];?>"></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>


                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>


                </div>
            </div>
        </div>
    </section>
</div>
<?php
include '../footer.php';
?>

<script>

    function deleteUser(user_id) {
//        var r=confirm("Do you want to submit");
//        if(r==true){
//            document.getElementById("delete"+user_id).submit();
//        }else{
//            alert("No delete");
//        }
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("delete" + user_id).submit();
            }
        })
    }

    $(function () {
//        $("#example1").DataTable({
//            "responsive": true, "lengthChange": false, "autoWidth": false,
//            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
//        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#user_list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
