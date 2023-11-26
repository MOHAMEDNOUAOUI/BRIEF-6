<?php
session_start();
include_once('connectDB.php');
if($_SESSION){
    $email = $_SESSION['emaillogin'];
    $role = $_SESSION['IDROLE'];
    // echo $email;
    $USER = $cnc->prepare("SELECT * FROM users WHERE EMAILuser = ?");
    $USER->bind_param("s",$email);
    $USER->execute();
    $resultuser = $USER->get_result();
    $row = $resultuser->fetch_assoc();
    $iduser = $row['IDuser'];
}


if(isset($_POST['ADDTOCART'])) {
    $produitcart = $_POST['ADDTOCART'];
    $add = $cnc->prepare("INSERT INTO panier (IDuser,IDproduct) values (?,?);");
    $add->bind_param("ii",$iduser,$produitcart);
    $check = $cnc->prepare("SELECT * FROM panier WHERE IDuser = ? AND IDproduct = ?");
    $check->bind_param("ii",$iduser,$produitcart);
    $check->execute();
    $resultchecker = $check->get_result();
    if($rows = $resultchecker->num_rows > 0) {
        $error = "PRODUCT ALREADY EXIST SIR :D";
    }
    else {
        $add->execute();
    }
}



?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 
</head>
  <body>

  <header>
   <div class="top">
   <nav class="border-bottom border-2 d-flex justify-content-between px-3 pt-2" >
        <div class="left d-flex text-center">
        <ion-icon name="call-outline" class="fs-3 me-2"></ion-icon>
        <p>09189368</p>
        <ion-icon name="mail-outline" class="fs-3 ms-3 me-2"></ion-icon>
        <p>jnziz@test?COM</p>
        </div>
        <div class="right d-flex gap-3 text-center">
            <p>ENGLISH</p>
            <p>DH marocain</p>
            <ion-icon name="person-circle-outline" class="fs-3"></ion-icon>
        </div>
    </nav>
   </div>
  </header>
  <div class="px-4 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-5">
    <div class="d-flex align-items-center">
    <ion-icon name="leaf-outline" class="fs-1 text-success"></ion-icon>
    <h1>O'<span class="text-success">PEP</span></h1>
    </div>
    
    
    </div>
    <form action="" method="GET" class="d-flex">
    <input type="text" placeholder="Search for products" name="search_field" class="rounded-0 border-1 pe-5" value="<?php if(isset($_GET['search_field'])) { echo $_GET['search_field'];}?>">    
    <button type="submit" class="btn btn-dark text-light rounded-0"><ion-icon name="search-outline"></ion-icon></button>
    </form>
    <div class="d-flex align-items-center gap-2">
    <div class="position-relative">
    <a href="PANIER.php" class="text-dark">
    <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" fill="currentColor" class="bi bi-bag position-relative" viewBox="0 0 16 16">
  <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
</svg>
    </a>
<div class="bg-success rounded-circle position-absolute w-75 h-75 text-center me-1" style="right:-.6rem;bottom:-.4rem"><?php 

    $number = $cnc->prepare("SELECT * FROM panier WHERE IDuser = ?");
    $number->bind_param("i",$iduser);
    $number->execute();
    $resultnumber=$number->get_result();
    if($resultnumber){
        $row = $resultnumber->num_rows;
        echo $row;
    }


?></div>
    </div>
        <div>
            <p class=" mx-0 my-0">CART</p>
            <p class="mx-0 my-0"><?php
            
            $totalprice = $cnc->prepare("SELECT SUM(price_product) AS total_price
            FROM panier
            JOIN users ON panier.IDuser = users.IDuser
            JOIN products ON panier.IDproduct = products.IDproduct
            WHERE panier.IDuser = ?;");
            $totalprice->bind_param("i",$iduser);
            $totalprice->execute();
            $result=$totalprice->get_result();
        $row = $result->fetch_assoc();
            echo "$" . $row['total_price'];

            
            
            
            
            ?></p>
        </div>
    </div>
  </div>


<form action="" method="GET">
    <SELECT name="FILTER">
        <option disabled>CATEGORY</option>
        <option value="ALL" name="ALL">ALL</option>
        <?php
        $categories = $cnc->prepare("SELECT * FROM category");
        $categories->execute();
        $resultcategories = $categories->get_result();
        while($category = $resultcategories->fetch_assoc()) {
            ?>
            <option value="<?php echo $category ['IDcategory']?>" name="<?php echo $category ['IDcategory']?>"><?php echo $category ['NAMEcategory']?></option>
            <?php
        }
        
        ?>
        
    </SELECT>
    <button class="btn btn-dark"><ion-icon name="search-outline"></ion-icon></button>
</form>


<section class="HERO  row col-md-12 px-5" style="margin-top:6rem">
    <?php
    
    // Check if a search by product name is performed
    if(isset($_GET['search_field'])) {
        $search = $_GET['search_field'];
        $prepare = $cnc->prepare("SELECT * FROM products WHERE NAMEproduct LIKE '%$search%' ");
        $prepare->execute();
        $result = $prepare->get_result();

        // Display products based on the search result
        while($row = $result->fetch_assoc()) {
            ?>
            <div class="card col-md-3 px-0 mx-0 d-flex flex-column align-items-center my-3">
    <div class="d-flex flex-column align-items-center h-100">
        <img src="./assets/IMG/<?php echo $row['image_product']?>" class="w-75 h-75" alt="">
        <div class="text-center">
            <h4><?php echo $row['NAMEproduct']?></h4>
            <form action="" method="POST">
                <button value="<?php echo $row ['IDproduct']?>" name="ADDTOCART" class="btn btn-success">Add to cart</button>
            </form>
        </div>
    </div>
</div>

            <?php
        }
    } elseif (isset($_GET['FILTER'])) {
        $checkFILTER = $_GET['FILTER'];
        if($_GET['FILTER'] === 'ALL') {
            $query = "SELECT * FROM products";
        }
        else {
            $query = "SELECT * FROM products WHERE IDcategory = ?";
        }

        $prepare=$cnc->prepare($query);
        if($checkFILTER !=='ALL') {
            $prepare->bind_param('i',$checkFILTER);
        }
        $prepare->execute();
        $result = $prepare->get_result();
        while($row = $result->fetch_assoc()) {
            ?>
           <div class="card col-md-3 px-0 mx-0 d-flex flex-column align-items-center my-3">
    <div class="d-flex flex-column align-items-center h-100">
        <img src="./assets/IMG/<?php echo $row['image_product']?>" class="w-75 h-75" alt="">
        <div class="text-center">
            <h4><?php echo $row['NAMEproduct']?></h4>
            <form action="" method="POST">
                <button value="<?php echo $row ['IDproduct']?>" name="ADDTOCART" class="btn btn-success">Add to cart</button>
            </form>
        </div>
    </div>
</div>
            <?php
        }
    }
    
    ?>
</section>









  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>