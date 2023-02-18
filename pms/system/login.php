<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PMS | Log in</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="../../index2.html" class="h1"><b>PMS</b>LOGIN</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <?php
                    
                    include 'function.php';
                    extract($_POST);
                    
                    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "login") {
                        $UserName = dataClean($UserName);
                        $message=array();
                        
                        if(empty($UserName)){
                            $message['UserName']="User Name should not be empty..!";
                        }
                        if(empty($Password)){
                            $message['Password']="Password should not be empty..!";
                        }
                        
                        if(empty($message)){
                            $db= dbConn();
                            $sql="SELECT * FROM tbl_users WHERE UserName='$UserName' AND Password='".sha1($Password)."'AND status='1'";
                            $result=$db->query($sql);
                            if($result->num_rows==1){
                                while ($row=$result->fetch_assoc()){
                                    $_SESSION['USERID'] = $row['UserId'];
                                    $_SESSION['FIRSTNAME']= $row['FirstName'];
                                    $_SESSION['LASTNAME'] =$row['LastName'];
                                    $_SESSION['ROLE'] =$row['RoleCode'];
                                }
                                header("Location:index.php");
                            } else {
                                $message['Password']="UserName or Password Invalid";
                            }
                        }
                    }
                    
                    ?>

                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="input-group mt-3">
                            <input type="text" class="form-control" placeholder="User Name" id="UserName" name="UserName">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-danger"><?php echo @$message['UserName']; ?></div>
                        
                        <div class="input-group mt-3">
                            <input type="password" class="form-control" placeholder="Password" id="Password" name="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-danger"><?php echo @$message['Password']; ?></div>
                        
                        <div class="row mt-3">
                            <div class="col-8">

                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block" name="action" value="login">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>


                    <!-- /.social-auth-links -->



                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
    </body>
</html>

