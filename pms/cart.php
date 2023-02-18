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
        $message=null;
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "update_item") {
            foreach ($_SESSION["shopping_cart"] as &$value) {
                if ($value['id'] === $id) {
                    $value['qty'] = $quantity;
                    break; // Stop the loop after we've found the product
                }
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "remove_item") {
           if(!empty($_SESSION['shopping_cart'])){
                foreach ($_SESSION['shopping_cart'] as $key=>$value){
                    if($key==$id){
                        unset($_SESSION['shopping_cart'][$key]);
                    }

                }
            }

        }

        ?>

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
        <div class="container mt-2">
           <?php
            if(!empty($_SESSION['shopping_cart'])){
                ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product Name</th>
                        <th>QTY</th>
                        <th>Price</th>
                        <th>Amount(Rs.)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                        $total_amount=0;
                        foreach ($_SESSION['shopping_cart'] as $product) {
                            ?>
                        <tr>
                            <td><img src="images/product_images/<?php echo $product['image']; ?>"></td>
                            <td><?php echo $product['name']; ?></td>
                            <td>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" name="action" value="update_qty">

                                        <select name="quantity" class="quantity" onchange="this.form.submit()">
                                    <option value="1" <?php if($product['qty']=='1') { ?> selected <?php } ?>>1</option>
                                    <option value="2" <?php if($product['qty']=='2') { ?> selected <?php } ?>>2</option>
                                    <option value="3" <?php if($product['qty']=='3') { ?> selected <?php } ?>>3</option>
                                    <option value="4" <?php if($product['qty']=='4') { ?> selected <?php } ?>>4</option>
                                    <option value="5" <?php if($product['qty']=='5') { ?> selected <?php } ?>>5</option>
                                </select>
                                        </form>
</td>
                            <td><?php echo $product['price']; ?></td>
                            <td><?php echo $product['qty']*$product['price']; ?></td>
                            <td>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" >
                                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                    <button class="btn btn-danger" type="submit" name="action" value="remove_item">Remove</button>
                                    </form>

                            </td>
                        </tr>

                            <?php
                            $total_amount+=$product['qty']*$product['price'];
                        }
                        ?>
<tr>
                            <td colspan="4">Total</td>
                            <td><?php echo $total_amount; ?></td>
                        </tr>

                    </tbody>

            </table>

            
            <?php
                
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