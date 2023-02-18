<?php
session_start();
//session_destroy();
include 'system/function.php';
$db= dbConn();
?>
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
        <?php
        extract($_POST);
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "add_item") {
//            echo $id;
            $sql="SELECT * FROM tbl_products WHERE id='$id'";
            $result=$db->query($sql);
            $row=$result->fetch_assoc();
//echo $result->num_rows;
            $id=$row['id'];
            $name=$row['name'];
            $code=$row['code'];
            $price=$row['price'];
            $image=$row['image'];
            $qty=1;
            
//            echo $name;
            $cart=array($id=>array("id"=>$id,"name"=>$name,"code"=>$code,"price"=>$price,"image"=>$image,"qty"=>$qty));
//            print_r($cart);
            if(!isset($_SESSION['shopping_cart'])){
               $_SESSION['shopping_cart']=$cart;
            } else {
                //array eke keys variable ekata.index array ekak out karanawa indexed array ekak widiyata
                $array_keys = array_keys($_SESSION["shopping_cart"]);
                if(in_array($id, $array_keys)){
                  echo "Product is already exsist..!";
              } else {
                  //array merge...increment wage..i++
                  $_SESSION['shopping_cart']+=$cart;
                  echo 'Product added to cart';
                   
              }


            }
            print_r($_SESSION['shopping_cart']);
//            print_r($_SESSION['shopping_cart']);
   
        }
        ?>

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
                            <a class="nav-link active" href="products.php">Products</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link active" href="cart.php">My Cart(
                            <?php
                            if(!empty($_SESSION['shopping_cart'])){
                                echo count(array_keys($_SESSION['shopping_cart']));
                            }
                            ?>)
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="customer_registration.php">Registration</a>
                        </li>
                                          </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-2">
            <?php
            $sql="SELECT * FROM tbl_products";
            $result=$db->query($sql);
            ?>

            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    while ($row=$result->fetch_assoc()){
                    ?>

                <div class="col-4">
                    <div class="card">
                        <img src="images/product_images/<?php echo $row['image'];?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name'];?></h5>
                            <h6>Price:<?php echo $row['price'];?></h6>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                                <button type="submit" name="action" value="add_item" class="btn btn-default">Buy Now</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                }
                }
                ?>
                
            </div>
        </div>
        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        -->
    </body>
</html>