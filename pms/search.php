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
                <a class="navbar-brand" href="#">Navbar</a>
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown link
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
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
                            <h3>search</h3> 
                        </div>
                        
                        <form id="search" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Select Subjects</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="PHP" id="PHP" name="Subject[]" onchange="search()">
                                        <label class="form-check-label" for="PHP">
                                            PHP
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="HTML" id="HTML" name="Subject[]" onchange="search()">
                                        <label class="form-check-label" for="HTML">
                                            HTML
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="CSS" id="CSS" name="Subject[]" onchange="search()">
                                        <label class="form-check-label" for="CSS">
                                            CSS
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Javascript" id="Javascript" name="Subject[]" onchange="search()">
                                        <label class="form-check-label" for="Javascript">
                                            Javascript
                                        </label>
                                    </div>
                                    <div class="text-danger"><?php echo @$error['Subject']; ?></div>
                                </div>

                            </div>
                        </form>
                        <div id="result">
                            
                        </div>
                            <div class="card-footer">
<!--                                <button type="submit" class="btn btn-success" name="action" value="save">Save</button>
                                <button type="submit" class="btn btn-warning" name="action" value="cancel">Cancel</button>-->
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
                                        function search() {
//                                            alert("yes");
//                alert(district_code)
                                            var data=$("#search").serialize();
//                                            alert(data)
                                            $.ajax({
                                               type:'POST' ,
                                               data:data,
                                               url:'search_result.php',
                                               success:function(response){
//                                                   alert(response);
                                                    $("#result").html(response)
                                               },
                                               error:function(request,status,error){
                                                   alert(error);
                                               }
                                            });
                                                    
                                        }
        </script>
    </body>
</html>
