<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <title>Product Management System</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-pms-nav">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">MySupper Supermarket</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="products.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="customer_registration.php">Registration</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="card mt-4">
                        <div class="card-header bg-warning">
                            <h3>Customer Registration</h3> 
                        </div>
                        <?php
//                        print_r($_POST);
//                        echo $_POST["FirstName"];
//                        echo $_POST["LastName"];
//                        echo $_POST["Address"];
//                        echo $_SERVER['REQUEST_METHOD'];
                        include 'system/function.php';
                        $db = dbConn();
                        extract($_POST);
                        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {


                            $FirstName = dataClean($FirstName);
                            $LastName = dataClean($LastName);
                            $Address = dataClean($Address);
                            $Email = dataClean($Email);
                            $error = array();

                            if (empty($FirstName)) {
                                $error['FirstName'] = 'first name should not be empty';
                            }
                            if (empty($LastName)) {
                                $error['LastName'] = 'last name should not be empty';
                            }
                            if (empty($Address)) {
                                $error['Address'] = 'address should not be empty';
                            }
                            if (empty($Email)) {
                                $error['Email'] = 'email should not be empty';
                            }
                            if (empty($District)) {
                                $error['District'] = 'district should not be empty';
                            }


                            if (empty($Gender)) {
                                $error['Gender'] = 'gender should be select';
                            }
//                            print_r($Subject) ;
//                            echo count($Subject);
                            if (empty($Subject)) {
                                $error['Subject'] = 'At least one subject should be select';
                            }
                            if (!empty($FirstName)) {
                                if (!preg_match("/^[a-zA-Z ]*$/", $FirstName)) {
                                    $error['FirstName'] = 'Only letters and white space allowed';
                                }
                            }
                            if (!empty($Email)) {
                                if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                                    $error['Email'] = 'invalid email';
                                }
                            }
                            if (empty($error)) {
                                $sql = "INSERT INTO tbl_customers(FirstName,LastName,Address,District,Email,Gender)VALUES('$FirstName','$LastName','$Address','$District','$Email','$Gender')";
                                $db->query($sql);
                                $CustomerId = $db->insert_id;
                                foreach ($Subject as $value) {
                                    $sql = "INSERT INTO tbl_customers_subjects (CustomerId,Subject) VALUES ('$CustomerId','$value')";
                                    $db->query($sql);
                                }
                            }
                        }
                        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "cancel") {
                            echo 'form submitted cancel';
                        }
                        ?>
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="FirstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="Enter your first name" value="<?php echo @$FirstName; ?>">
                                    <div class="text-danger"><?php echo @$error['FirstName']; ?></div>
                                </div>
                                <div class="mb-3">
                                    <label for="LastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Enter your last name" value="<?php echo @$LastName; ?>">
                                    <div class="text-danger"><?php echo @$error['LastName']; ?></div>
                                </div>
                                <div class="mb-3">
                                    <label for="Address" class="form-label">Address</label>
                                    <textarea class="form-control" id="Address" name="Address" rows="3"></textarea>
                                    <div class="text-danger"><?php echo @$error['Address']; ?></div>
                                </div>
                                <div class="mb-3">
                                    <label for="Email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="Email" name="Email" placeholder="Enter your Email" value="<?php echo @$Email; ?>">
                                    <div class="text-danger"><?php echo @$error['Email']; ?></div>
                                </div>
                                <div class="mb-3">
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM tbl_district";
                                    $result = $db->query($sql);
                                    ?>
                                    <label class="form-label">District</label>
                                    <select class=" form-control form-select"  name="District" id="District" onchange="loadCity(this.value)">
                                        <option value="">--</option>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo $row['district_code']; ?>" <?php if (@$District == $row['district_code']) { ?> selected <?php } ?>><?php echo $row['district_name']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
<!--                                        <option value="kan" <?php if (@$District == "kan") { ?> selected <?php } ?>>Kandy</option>
                                <option value="mat" <?php if (@$District == "mat") { ?> selected <?php } ?>>Matara</option>-->
                                    </select>
                                    <div class="text-danger"><?php echo @$error['District']; ?></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <div id="city_list">
                                        <select class="form-control form-select"  name="City" id="City">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Select a Gender</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Gender" id="male" value="M" <?php if (@$Gender == "M") { ?> checked <?php } ?>>
                                        <label class="form-check-label" for="male">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Gender" id="female" value="F" <?php if (@$Gender == "F") { ?> checked <?php } ?>>
                                        <label class="form-check-label" for="female">
                                            Female
                                        </label>
                                    </div>
                                    <div class="text-danger"><?php echo @$error['Gender']; ?></div>
                                </div>

                                <div class="mb-3">
                                    <?php
                                    if (!empty($Subject)) {
                                        echo in_array("PHP", $Subject);
                                    }
                                    ?>


                                    <label class="form-label">Select Subjects</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="PHP" id="PHP" name="Subject[]"
                                        <?php
                                        if (!empty($Subject)) {
                                            if (in_array("PHP", $Subject)) {
                                                ?>
                                                       checked
                                                       <?php
                                                   }
                                               }
                                               ?>
                                               >
                                        <label class="form-check-label" for="PHP">
                                            PHP
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="HTML" id="HTML" name="Subject[]"
                                        <?php
                                        if (!empty($Subject)) {
                                            if (in_array("HTML", $Subject)) {
                                                ?>
                                                       checked
                                                       <?php
                                                   }
                                               }
                                               ?>
                                               >
                                        <label class="form-check-label" for="HTML">
                                            HTML
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="CSS" id="CSS" name="Subject[]"
                                        <?php
                                        if (!empty($Subject)) {
                                            if (in_array("CSS", $Subject)) {
                                                ?>
                                                       checked
                                                       <?php
                                                   }
                                               }
                                               ?>
                                               >
                                        <label class="form-check-label" for="CSS">
                                            CSS
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Javascript" id="Javascript" name="Subject[]"
                                        <?php
                                        if (!empty($Subject)) {
                                            if (in_array("Javascript", $Subject)) {
                                                ?>
                                                       checked
                                                       <?php
                                                   }
                                               }
                                               ?>
                                               >
                                        <label class="form-check-label" for="Javascript">
                                            Javascript
                                        </label>
                                    </div>
                                    <div class="text-danger"><?php echo @$error['Subject']; ?></div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success" name="action" value="save">Save</button>
                                <button type="submit" class="btn btn-warning" name="action" value="cancel">Cancel</button>
                            </div>
                    </div>
                </div>

            </div>         
        </div>

        <!-- Optional JavaScript; choose one of the two! -->
        <script src="system/plugins/jquery/jquery.min.js" type="text/javascript"></script>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        -->

        <script>
                                        function loadCity(district_code) {
//                alert(district_code)
                                            var d = "district_code=" + district_code + "&";
                                            $.ajax({
                                                type: 'POST',
                                                data: d,
                                                url: 'load_city.php',
                                                success: function (response) {
//                                                   alert(response);
                                                    $("#city_list").html(response)
                                                },
                                                error: function (request, status, error) {
                                                    alert(error);
                                                }
                                            });

                                        }
        </script>
    </body>
</html>
