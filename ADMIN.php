<?php
include_once('connectDB.php');
session_start();
if($_SESSION['IDROLE'] !== "ADMIN") {
        header("location: LOGIN.php");
}
if (isset($_SESSION['emaillogin'])) {
    $email = $_SESSION['emaillogin'];
}

$CG = "";
$error = "";
$cate = $cnc->prepare("INSERT INTO category (NAMEcategory) values (?);");
if (isset($_POST['ADDCATEGORY'])) {
    //add category
    $CG = $_POST['ADDCATEGORY'];
    $check = $cnc->prepare("SELECT * FROM category WHERE NAMEcategory = ?");
    $check->bind_param("s", $CG);
    $check->execute();
    $resultcheck = $check->get_result();

    if ($resultcheck->num_rows > 0) {
        $error = '<ion-icon name="sad-outline" style="font-size:12rem;"></ion-icon>
        <h4>SORRY BUT THE CATEGORY ALREADY EXIST</h4>
        <p>please go back to categories to add more if you liked</p>';
    } else {
        $cate = $cnc->prepare("INSERT INTO category (NAMEcategory) values (?);");
        $cate->bind_param('s', $CG);
        $cate->execute();
        $cate->close();
        $error = '<ion-icon name="happy-outline" style="font-size:12rem;"></ion-icon> 
        <h4>CATEGORY ADDED SUCCEFULLY</h4>
        <p>please go back to categories to add more if you liked</p>';
    }
}


//modify

if(isset($_POST['MODIFYCATEGORY'])){
    $inputvalue = $_POST['MODIFYCATEGORY'];//INPUT VALUE;
    $buttonID = $_POST['IDCATEGORY']; // i want the inside of this //THE ID OF THE CATEGORY;       

    $CATEGORY_MODIFY = $cnc->prepare("UPDATE category SET NAMEcategory = ? WHERE IDcategory = ?");
    $CATEGORY_MODIFY->bind_param("si",$inputvalue,$buttonID);
    $CATEGORY_MODIFY->execute();
    $error = "<h4>CATEGORY MODIFIED SUCCEFULY</h4>";
}

if(isset($_POST['MODIFYPRODUCT'])) {
    $id_produit = $_POST['PRODUCTIDHIDDEN'];
    $NEWNAMEPRODUCT = $_POST['NEWNAMEPRODUCTS'];
    $NEWPRICE = $_POST['NEWPRICEPRODUCTS'];
    $NEWQUANTITY = $_POST['NEWQUANTITYPRODUCTS'];
    $NEWIMAGE = $_POST['NEWIMAGEPRODUCTS'];


    $updateproduct = $cnc->prepare("UPDATE products SET NAMEproduct = ?,price_product = ?, quantity_product = ?,image_product = ? WHERE IDproduct = ?");
    $updateproduct->bind_param("siisi",$NEWNAMEPRODUCT,$NEWPRICE,$NEWQUANTITY,$NEWIMAGE,$id_produit);
    $updateproduct->execute();
    $error = "<h4>PRODUCT UPDATED SUCCEFULLY</h4>";

}




//deleting 

if(isset($_POST['DELETECATEGORY'])) {
    $is_delete = $_POST["DELETECATEGORY"];
    
    $delete = $cnc->prepare("DELETE FROM category WHERE IDcategory = ?");
    $deleteproductcategor = $cnc->prepare("DELETE FROM products WHERE IDcategory = ?");
    $deleteproductcategor->bind_param("i",$is_delete);
    $delete->bind_param("i",$is_delete);
    $deleteproductcategor->execute();

    $delete->execute();
    $error = "<h4>CATEGORY DELETED SUCCEFULLY</h4>
    <p>please go back to Categories to delete more if you want</p>";
}


if(isset($_POST['DELETEPRODUCT'])) {
    $is_deleteproduct = $_POST['DELETEPRODUCT'];
    $deleteproduct = $cnc->prepare("DELETE FROM products WHERE IDproduct = ?");
    $deleteproduct->bind_param("i",$is_deleteproduct);
    $deleteproduct->execute();
    $error = "<h4>PRODUCTS HAVE BEEN DELETED SUCCEFULLY</h4>
    <p>please go back to Categories to delete more if you want</p>";
}



//END DELETING

if(isset($_POST['submitproduct'])) {
    $nameproduct = $_POST['NAMEPRODUCTS'];
    $priceproduct = $_POST['PRICEPRODUCTS'];
    $quantity = $_POST['QUANTITYPRODUCTS'];
    $imageproduct = $_POST['IMAGEPRODUCTS'];
    $category = $_POST['categorySelect'];

    $checkproduct = $cnc->prepare("SELECT NAMEproduct FROM products WHERE NAMEproduct = ?");
    $checkproduct->bind_param('s',$nameproduct);
    $checkproduct->execute();
    $result = $checkproduct->get_result();
    if($result->num_rows > 0) {
        $error = "<h4>SORRY PRODUCT ALREADY EXIST</h4>";
    } 
    else {
        $addproduct = $cnc->prepare("INSERT INTO products (NAMEproduct,price_product,quantity_product,image_product,IDCATEGORY)values (?,?,?,?,?);");
        $addproduct->bind_param("siisi",$nameproduct,$priceproduct,$quantity,$imageproduct,$category);
        $addproduct->execute();
        $error = "<h4>PRODUCT ADDED SUCCEFULLY</h4>";
    }
    
}

if(isset($_POST['LOGOUT'])) {
    session_unset();
    session_destroy();
    header("location: LOGIN.php");
    exit();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>

    <style>
        body,html {
            overflow-x: hidden;
        }
    </style>
</head>

<body style="font-family: 'Rubik';">

    <div class="HERO d-flex" style="width:100vw;height:100vh">
        <div class="LEFT position-fixed z-1  bg-gradient bg-success w-25 h-100">
            <h1 class="ps-2 py-4 text-light text-center border-bottom border-light border-2">DASHBOARD</h1>
            <div class="h-75 w-100">
                <form action="" method="POST" class="row align-items-center justify-content-evenly h-100">

                    <div class="d-flex flex-column align-items-center gap-3">
                        <button class="btn btn-light w-75 text-success fw-bold  text-start d-flex align-items-center gap-3" name="Dashboard">
                            <ion-icon name="home-outline" class="fs-2"></ion-icon>
                            DASHBOARD
                        </button>
                        <button class="btn btn-light w-75 text-success fw-bold text-start d-flex align-items-center gap-3" name="Products">
                            <ion-icon name="leaf-outline" class="fs-2"></ion-icon>
                            Products
                        </button>
                        <button class="btn btn-light w-75 text-success fw-bold text-start d-flex align-items-center gap-3" name="Categories">
                            <ion-icon name="albums-outline" class="fs-2"></ion-icon>
                            Categories
                        </button>
                        <button class="btn btn-light w-75 text-success fw-bold text-start d-flex align-items-center gap-3" name="Users">
                            <ion-icon name="people-outline" class="fs-2"></ion-icon>
                            Users
                        </button>
                    </div>

                    <button class="btn btn-success w-auto text-start d-flex align-items-center gap-3" name="Profile">
                        <ion-icon name="people-outline" class="fs-2"></ion-icon>
                        Profile
                    </button>

                </form>
            </div>
        </div>



        <!--MAINN PLACE -->
        
        <div class="RIGHT h-100 w-100 position-relative" style="margin-left:20rem">

            <div class="position-absolute d-flex text-center align-items-center flex-column" style="top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);">
                <?php echo $error;
                ?>

            </div>
            <?php

            // echo $email;
            if ($_SERVER["REQUEST_METHOD"] == 'POST') {
                foreach ($_POST as $key => $value) {
                    if ($key == 'Products') {

                        ?>

                        <div class="CATE mt-5 top w-100 d-flex justify-content-between px-5 align-items-center" id="test">
                            <div class="">
                                <h4>Add New Product</h4>
                                <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                            </div>

                            <!-- Button trigger modal PRODUCT -->
                            <ion-icon name="add-circle-outline" class="fs-1" data-bs-toggle="modal" data-bs-target="#addproducts"></ion-icon>
                        </div>

                        
                         <!-- Modal add PRODUCT -->
                         <div class="modal fade bg-gradient bg-success align-items-center" id="addproducts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog h-75 d-flex align-items-center">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST" class="d-flex flex-column">
                                            <label for="">PRODUCT NAME</label><br>
                                            <input required type="text" name="NAMEPRODUCTS" id="NAMEPRODUCTS">
                                            <label for="">PRICE</label>
                                            <div class="input-group mb-3">
                                                    <span class="input-group-text bg-dark text-light">DH</span>
                                                    <span class="input-group-text bg-dark text-light">0.00</span>
                                                <input required class="form-control" type="text" name="PRICEPRODUCTS" id="PRICEPRODUCTS" class="w-25">
                                            </div>
                                            

                                            <label for="">QUANTITY</label>

                                            <input required type="number" name="QUANTITYPRODUCTS" id="QUANTITYPRODUCTS" class="w-25" >

                                            
                                                    <label for="">UPLOAD AN IMAGE</label>
                                                     <div class="input-group mb-3">
                                                    <input required type="file" class="form-control" name="IMAGEPRODUCTS" id="IMAGEPRODUCTS" class="w-25">
                                                    </div>


                                                    <label for="">Choose Category</label>

                                                    <select name="categorySelect" class="w-50 py-2 bg-dark text-light" id="" required>
                                                    
                                                        <option value="">Nothing</option>
                                                    <?php
                                                    $CAT = $cnc->prepare("SELECT IDcategory,NAMEcategory FROM category");
                                                        $CAT->execute();
                                                        $rr = $CAT->get_result();
                                                        while($row = $rr->fetch_assoc()) {
                                                            ?>

                                                            <option value="<?php echo $row ['IDcategory']?>"><?php echo $row['NAMEcategory']?></option>

                                                            <?php
                                                        }
                                                        ?>
                                                    </select>


                                            <div class="modal-footer mt-4">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="submitproduct" value="ADDCATEGORY" class="btn btn-success">Submit</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        

                        <table class="table table-dark" style="width:95%">
                            <h1 class="text-center mt-3">PRODUCTS</h1>
                        <thead class="">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">IMAGE</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">QUantity</th>
                            <th scope="col">Category</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $pr = $cnc->prepare("SELECT * FROM products");
                            $pr->execute();
                            $result = $pr->get_result();
                            while($row = $result->fetch_assoc()) {
                                $id_product = $row['IDproduct'];
                                $nameproduct = $row['NAMEproduct'];
                                $price = $row ['price_product'];
                                $quantity = $row ['quantity_product'];
                                $image = $row['image_product'];
                                $category = $row['IDCATEGORY'];
                                ?>
                                <tr>
                            <th scope="row"><?php echo $row['IDproduct']?></th>
                            <td><img src="./assets/IMG/<?php echo $row['image_product']?>" alt="" style="width=5rem;height:5rem"></td>
                            <td><?php echo $row['NAMEproduct']?></td>
                            <td><?php echo $row['price_product']?></td>
                            <td><?php echo $row['quantity_product']?></td>
                            <td><?php 
                            $category_product = $cnc->prepare("SELECT NAMEcategory FROM category WHERE IDcategory = ?");
                            $category_product->bind_param("i",$row['IDCATEGORY']);
                            $category_product->execute();
                            $resultproduct =$category_product->get_result();
                            $row = $resultproduct->fetch_assoc();
                            echo $row['NAMEcategory'];
                            
                            ?></td>
                            <td class="" >
                            <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#MODIFYPRODUCT_<?php echo $id_product; ?>">MODIFY</button>
                            <form action="" method="POST">
                            <button type="submit" name="DELETEPRODUCT" class="btn btn-danger" value="<?php echo $id_product?>">DELETE</button>

                            </form>
                            
                                </td>
                            </tr>

                                          <!-- Modal MODIFY PRODUCT -->
                <div class="modal fade" id="MODIFYPRODUCT_<?php echo $id_product; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">MODIFY PRODUCT</h5>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <form action="" method="POST" class=""> 
                        <label for="">NEW PRODUCT NAME</label><br>
                        <input required type="text" value="<?php echo $nameproduct ?>"  name="NEWNAMEPRODUCTS" id="NEWNAMEPRODUCTS">
                    
                        <label for="">NEW PRICE</label>
                                            <div class="input-group mb-3">
                                                    <span class="input-group-text bg-dark text-light">DH</span>
                                                    <span class="input-group-text bg-dark text-light">0.00</span>
                                                <input required class="form-control" type="text" value="<?php echo $price?>" name="NEWPRICEPRODUCTS" id="NEWPRICEPRODUCTS" class="w-25">
                                            </div>

                                            <label for="">QUANTITY</label>

                                            <input required type="number" value="<?php echo $quantity?>" name="NEWQUANTITYPRODUCTS" id="NEWQUANTITYPRODUCTS" class="w-25" >

                                            <label for="">UPLOAD AN IMAGE</label>
                                                     <div class="input-group mb-3">
                                                    <input required type="file" class="form-control" name="NEWIMAGEPRODUCTS" id="NEWIMAGEPRODUCTS" class="w-25">
                                                    </div>
                    </div>
                    <div class="modal-footer">
                        <input type="text" name="PRODUCTIDHIDDEN" value="<?php echo $id_product?>" style="display:none">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="MODIFYPRODUCT" class="btn btn-primary">Save changes</button>
                    </div>
                         </form>
                    </div>
                </div>
                </div>


                






                                <?php
                            }
                            ?>
                            
                            
                        </tbody>
                        </table>


                  


                        





                        <?php
                    
                    } 
                    
                    
                    else if ($key == 'Categories') {
            ?>

                        <div class="CATE mt-5 top w-100 d-flex justify-content-between px-5 align-items-center" id="test">
                            <div class="">
                                <h4>Add New Category</h4>
                                <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                            </div>
                            <!-- Button trigger modal -->
                            <ion-icon name="add-circle-outline" class="fs-1" data-bs-toggle="modal" data-bs-target="#exampleModal"></ion-icon>
                        </div>


                        <!-- Modal add category -->
                        <div class="modal fade bg-gradient bg-success align-items-center" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog h-75 d-flex align-items-center">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST">
                                            <label for="">CATEGORY NAME</label><br>
                                            <input required type="text" name="ADDCATEGORY" id="ADDCATEGORY">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="submitcategory" value="ADDCATEGORY" class="btn btn-success">Submit</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="bottom w-100 table-responsive">
                            <h1 class="text-center mt-3">CATEGORIES</h1>
                            <table class="table table-dark">

                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">CATEGORY NAME</th>
                                        <th scope="col">PLANTS</th>
                                        <th scope="col">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $pr = $cnc->prepare("SELECT * FROM category");
                                    $pr->execute();
                                    $result = $pr->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row["IDcategory"];
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $row['IDcategory'] ?></th>
                                            <td><?php echo $row['NAMEcategory'] ?></td>
                                            <td>

                                                <?php
                                                $ps = $cnc->prepare("SELECT * FROM products WHERE IDcategory = $id");
                                                $ps->execute();
                                                $resultP = $ps->get_result();
                                                $count = $resultP->num_rows;
                                                echo $count;
                                                ?>
                                            </td>
                                            <td class="d-flex gap-3">
                                            <button class="btn btn-success" name="MODIFY" data-bs-toggle="modal" data-bs-target="#TEST<?php echo $id?>">MODIFY</button>

                                                <form action="" method="POST">
                                                    
                                                    <button class="btn btn-danger" type="submit" value="<?php echo $id?>" name="DELETECATEGORY">DELETE</button>
                                                </form>
                                               


                                            </td>
                                        </tr>


                                        <!-- modify category-->

                                        <div class="modal fade" id="TEST<?php echo $row['IDcategory']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header mx-auto text-center d-flex justify-content-center flex-column">
                                                        <h1 class="modal-title" id="exampleModalLabel" style="font-size=10rem"><?php echo $row["NAMEcategory"]?></h1>
                                                        <h4>ID:<?php echo $row["IDcategory"] ?></h1>
                                                    </div>
                                                    <form action="" method="POST">
                                                    <div class="modal-body">
                                                    
                                                        <label for="">NEW NAME</label><br>
                                                        <input type="text" name="MODIFYCATEGORY" placeholder="newname">
                                                        <input type="text" name="IDCATEGORY" value="<?php echo $row["IDcategory"]?>" placeholder="newname" style="display:none">
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" value="" name="">Save changes</button>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <?php
                                    }
                                    
                                        
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    





                    <?php
                    } else if ($key == 'Users') {
                        ?>
                        <h1 class="text-center my-5">ALL USERS INFORMATION</h1>
                        <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">FirstName</th>
      <th scope="col">LastName</th>
      <th scope="col">EMAIL</th>
      <th scope="col">ROLE</th>
    </tr>
  </thead>
  <tbody>

   <?php
   $users = $cnc->prepare("SELECT * FROM users");
   $users->execute();
   $usersresult = $users->get_result();

   $roles=$cnc->prepare("SELECT * FROM roles");
   $roles->execute();
   $resultrule = $roles->get_result();
   $RR = $resultrule->fetch_assoc();
   while($rowuser = $usersresult->fetch_assoc()) {
    ?>
     <tr>
      <th scope="row"><?php echo $rowuser ['IDuser']?></th>
      <td><?php echo $rowuser ['NAMEuser']?></td>
      <td><?php echo $rowuser ['LASTNAMEuser']?></td>
      <td><?php echo $rowuser ['EMAILuser']?></td>
      <?php
        if($RR['NAMErole'] == 'ADMIN') {
            ?>
            <td>ADMIN</td>
            <?php
        }
        else {
            ?>
            <td>CLIENT</td>
            <?php
        }
      
      ?>
    </tr>
    <?php
   }
   
   ?>
    
  </tbody>
</table>
                        <?php
                    } else if ($key == 'Profile') {
                        $PROFILE = $cnc->prepare("SELECT * FROM users WHERE EMAILuser = ?");
                        $PROFILE->bind_param("s",$email);
                        $PROFILE->execute();
                        $PROFILEresult = $PROFILE->get_result();
                        $row=$PROFILEresult->fetch_assoc();
                        ?>
                        <div class="card d-flex align-items-center justify-content-center" style=" position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);">
                        <ion-icon name="person-circle-outline" style="font-size:10rem"></ion-icon>
                        <h4><?php echo $row['NAMEuser']. ' ' . $row['LASTNAMEuser']?></h4>
                        <p><?php echo $email?></p>
                        <p>ROLE : ADMIN</p>
                        <form action="" method="POST">
                            <button name="LOGOUT" class="btn btn-dark">LogOut</button>
                        </form>
                        </div>
                        <?php
                    } else if ($key == 'Dashboard') {
                        $PRODUCTS = $cnc->prepare("SELECT * FROM products");
                        $CATEGORIES = $cnc->prepare("SELECT * FROM category");
                        $USERS = $cnc->prepare("SELECT * FROM users");
                        $qr = "SELECT NAMEuser,LASTNAMEuser FROM users WHERE EMAILuser = '$email'";

                        //returning CLIENTS
                        $QC = "SELECT * FROM roles WHERE NAMErole = 'CLIENT'";
                        $RC = mysqli_query($cnc, $QC);
                        $CC = mysqli_num_rows($RC);
                        ///RETURNING AMINDS
                        $QA = "SELECT * FROM roles WHERE NAMErole = 'ADMIN'";
                        $RA = mysqli_query($cnc, $QA);
                        $CA = mysqli_num_rows($RA);

                        $user = mysqli_query($cnc, $qr);
                        $result = mysqli_fetch_assoc($user);
                    ?>

                        </h1>
                        <h4 class="mx-5 mt-5">Nice To Have You Back MR,<?php echo $result["NAMEuser"] . ' ' . $result["LASTNAMEuser"]; ?> &#128515;</h4>

                        <div class="STATISTIQUE text-light col-md-12 d-flex justify-content-evenly my-3">
                            <div class="px-2 py-2 PRODUCTS STATS col-md-3 rounded-4" style="background: linear-gradient(to top, #0ba360 0%, #3cba92 100%);box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;height:12rem">
                                <h4 class="fs-5">Products</h4>
                                <div class="mt-3 d-flex align-items-center justify-content-around">
                                    <ion-icon name="leaf-outline" class="text-light " style="font-size: 5rem;"></ion-icon>
                                    <?php
                                    $PRODUCTS->execute();
                                    $result = $PRODUCTS->get_result();
                                    ?>
                                    <h4><?php echo $result->num_rows; ?></h4>
                                    <?php
                                    ?>
                                </div>
                            </div>
                            <div class="px-2 py-2 PRODUCTS STATS col-md-3 rounded-4" style="background: linear-gradient(to top, #0ba360 0%, #3cba92 100%);box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;height:12rem">
                                <h4 class="fs-5">CATEGORIES</h4>
                                <div class="mt-3 d-flex align-items-center justify-content-around">
                                    <ion-icon name="albums-outline" class="" style="font-size: 5rem;"></ion-icon>
                                    <?php
                                    $CATEGORIES->execute();
                                    $result = $CATEGORIES->get_result();
                                    ?>
                                    <h4><?php echo $result->num_rows; ?></h4>
                                    <?php
                                    ?>
                                </div>
                            </div>
                            <div class="px-2 py-2 PRODUCTS STATS col-md-4 rounded-4" style="background: linear-gradient(to top, #0ba360 0%, #3cba92 100%);box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                                <h4 class="fs-5">USERS</h4>
                                <div class="mt-3 d-flex align-items-center flex-column">
                                    <div class="d-flex align-items-center justify-content-around w-100">
                                        <ion-icon name="people-outline" class="" style="font-size: 5rem;"></ion-icon>
                                        <?php
                                        $USERS->execute();
                                        $result = $USERS->get_result();
                                        ?>
                                        <h4><?php echo $result->num_rows; ?></h4>
                                    </div>
                                    <div class="w-100 ">
                                        <div class="d-flex justify-content-evenly w-100">
                                            <p class="fs-4 fw-bold">CLIENTS</p>
                                            <h4><?php echo $CC ?></h4>
                                        </div>
                                        <div class="d-flex justify-content-evenly w-100">
                                            <p class="fs-4 fw-bold">ADMINS&nbsp;</p>
                                            <h4><?php echo $CA ?></h4>
                                        </div>
                                    </div>
                                    <?php
                                    ?>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                }
            } else {
                echo $CG;
                function DASHBOARD($cnc, $email, $error)
                {
                    $PRODUCTS = $cnc->prepare("SELECT * FROM products");
                    $CATEGORIES = $cnc->prepare("SELECT * FROM category");
                    $USERS = $cnc->prepare("SELECT * FROM users");
                    $qr = "SELECT NAMEuser,LASTNAMEuser FROM users WHERE EMAILuser = '$email'";

                    //returning CLIENTS
                    $QC = "SELECT * FROM roles WHERE NAMErole = 'CLIENT'";
                    $RC = mysqli_query($cnc, $QC);
                    $CC = mysqli_num_rows($RC);
                    ///RETURNING AMINDS
                    $QA = "SELECT * FROM roles WHERE NAMErole = 'ADMIN'";
                    $RA = mysqli_query($cnc, $QA);
                    $CA = mysqli_num_rows($RA);

                    $user = mysqli_query($cnc, $qr);
                    $result = mysqli_fetch_assoc($user);
                    ?>

                    </h1>
                    <h4 class="mx-5 mt-5">Nice To Have You Back MR,<?php echo $result["NAMEuser"] . ' ' . $result["LASTNAMEuser"]; ?> &#128515;</h4>

                    <div class="STATISTIQUE text-light col-md-12 d-flex justify-content-evenly my-3">
                        <div class="px-2 py-2 PRODUCTS STATS col-md-3 rounded-4" style="background: linear-gradient(to top, #0ba360 0%, #3cba92 100%);box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;height:12rem">
                            <h4 class="fs-5">Products</h4>
                            <div class="mt-3 d-flex align-items-center justify-content-around">
                                <ion-icon name="leaf-outline" class="text-light " style="font-size: 5rem;"></ion-icon>
                                <?php
                                $PRODUCTS->execute();
                                $result = $PRODUCTS->get_result();
                                ?>
                                <h4><?php echo $result->num_rows; ?></h4>
                                <?php
                                ?>
                            </div>
                        </div>
                        <div class="px-2 py-2 PRODUCTS STATS col-md-3 rounded-4" style="background: linear-gradient(to top, #0ba360 0%, #3cba92 100%);box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;height:12rem">
                            <h4 class="fs-5">CATEGORIES</h4>
                            <div class="mt-3 d-flex align-items-center justify-content-around">
                                <ion-icon name="albums-outline" class="" style="font-size: 5rem;"></ion-icon>
                                <?php
                                $CATEGORIES->execute();
                                $result = $CATEGORIES->get_result();
                                ?>
                                <h4><?php echo $result->num_rows; ?></h4>
                                <?php
                                ?>
                            </div>
                        </div>
                        <div class="px-2 py-2 PRODUCTS STATS col-md-4 rounded-4" style="background: linear-gradient(to top, #0ba360 0%, #3cba92 100%);box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                            <h4 class="fs-5">USERS</h4>
                            <div class="mt-3 d-flex align-items-center flex-column">
                                <div class="d-flex align-items-center justify-content-around w-100">
                                    <ion-icon name="people-outline" class="" style="font-size: 5rem;"></ion-icon>
                                    <?php
                                    $USERS->execute();
                                    $result = $USERS->get_result();
                                    ?>
                                    <h4><?php echo $result->num_rows; ?></h4>
                                </div>
                                <div class="w-100 ">
                                    <div class="d-flex justify-content-evenly w-100">
                                        <p class="fs-4 fw-bold">CLIENTS</p>
                                        <h4><?php echo $CC ?></h4>
                                    </div>
                                    <div class="d-flex justify-content-evenly w-100">
                                        <p class="fs-4 fw-bold">ADMINS&nbsp;</p>
                                        <h4><?php echo $CA ?></h4>
                                    </div>
                                </div>
                                <?php
                                ?>
                            </div>
                        </div>
                    </div>

            <?php
                }
                DASHBOARD($cnc, $email, $error);
            }
            ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>