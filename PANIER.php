<?php
include_once('connectDB.php');
session_start();
if($_SESSION['emaillogin']){
    $email = $_SESSION['emaillogin'];
    $idrole = $_SESSION['IDROLE'] = 2;
    $ID = $cnc->prepare("SELECT * FROM users WHERE EMAILuser = ?");
    $ID->bind_param("s",$email);
    $ID->execute();
    $result = $ID->get_result();
    $row = $result->fetch_assoc();
    $iduser = $row['IDuser'];
}

if(isset($_GET['DELETE_PRODUCT'])) {
    $delete = $_GET['DELETE_PRODUCT'];
    $DELETING = $cnc->prepare("DELETE FROM panier WHERE IDproduct = ?");
    $DELETING->bind_param("i",$delete);
    $DELETING->execute();
}


if(isset($_POST['checkout'])) {
    $address = $_POST['Adress'];
    $phone = $_POST['Phone'];

    //panier
    $getproduct = $cnc->prepare("SELECT IDproduct FROM panier WHERE IDuser = ? ");
    $getproduct->bind_param("i",$iduser);
    $getproduct->execute();
    $resultproducts = $getproduct->get_result();

    //command
    $command = $cnc->prepare("INSERT INTO command (IDuser, IDproduct, address_user, phone_user) VALUES (?,?,?,?)");
    $command->bind_param("iiss",$iduser,$idproductcommand,$address,$phone);

    while($row = $resultproducts->fetch_assoc()) {
        $idproductcommand = $row['IDproduct'];
        $command->execute();
    }

    $deleting_panier = $cnc->prepare("DELETE FROM panier WHERE iduser = ?");
    $deleting_panier->bind_param("i",$iduser);
    $deleting_panier->execute();

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
  <section class="h-100 h-custom" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card">
          <div class="card-body p-4">

            <div class="row">

              <div class="col-lg-7">
                <h5 class="mb-3"><a href="CLIENT.php" class="text-body"><i
                      class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a></h5>
                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <p class="mb-1">Shopping cart</p>
                    <p class="mb-0">You have <?php  $number = $cnc->prepare("SELECT * FROM panier WHERE IDuser = ?");
    $number->bind_param("i",$iduser);
    $number->execute();
    $resultnumber=$number->get_result();
    if($resultnumber){
        $row = $resultnumber->num_rows;
        echo $row;
    } ?> items in your cart</p>
                  </div>
                </div>


                <?php
                $checkout = $cnc->prepare("SELECT NAMEproduct,IDcategory,price_product,image_product,panier.IDproduct
                FROM panier
                JOIN products ON products.IDproduct = panier.IDproduct
                WHERE IDuser = ?;");
                $checkout->bind_param("i",$iduser);
                $checkout->execute();
                $resultnumber=$checkout->get_result();
                if($row = $resultnumber->num_rows == 0) {
                        ?>
                        <div class="d-flex justify-content-center flex-column">
                        <ion-icon style="font-size:10rem" class="text-center mx-auto" name="sad-outline"></ion-icon>
                        <h3 class="text-center" >SORRY YOU HAVE NO PRODUCTS</h3>
                        </div>
                        <?php
                }
                while($row=$resultnumber->fetch_assoc()){
                    ?>
                    <div class="card  mb-3">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">

                      <div class="d-flex flex-row align-items-center">
                        <div>
                          <img
                            src="./assets/IMG/<?php echo $row['image_product']?>"
                            class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                        </div>
                        <div class="ms-3">
                          <h5><?php echo $row['NAMEproduct']?></h5>
                          <p class="small mb-0"><?php echo $row['IDcategory'] ?></p>
                        </div>
                      </div>

                      <div class="d-flex flex-row align-items-center">
                        <div class="d-flex align-items-center gap-2">
                          <h5 class="mb-0"><?php echo $row['price_product']?>$</h5>
                          <form action="" method="GET">
                          <button name="DELETE_PRODUCT" class="border-0 bg-transparent" value="<?php echo $row['IDproduct']?>"><ion-icon name="trash-outline" class="fs-4"></ion-icon></button>
                          </form>
                        </div>
                        <a href="#!" style="color: #cecece;"><i class="fas fa-trash-alt"></i></a>
                      </div>
                      
                    </div>
                  </div>
                </div>
                    <?php
                }
                
                ?>

              </div>
              <?php

                if($resultnumber->num_rows != 0 ) {
                    ?>
                    <div class="col-lg-5">

<div class="card bg-success text-white rounded-3">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="mb-0">Client Details</h5>
    </div>


    <form class="mt-4" method="POST">
      <div class="form-outline form-white mb-4">
        <input type="text" name="Adress" id="typeName" class="form-control form-control-lg" siez="17"
          placeholder="Address" />
        <label class="form-label" for="typeName">Address</label>
      </div>
      
      <div class="form-outline form-white mb-4">
        <input type="text" name="Phone" id="typeName" class="form-control form-control-lg" siez="17"
          placeholder="+212600000000" />
        <label class="form-label" for="typeName">Phone Number</label>
      </div>
      <div class="form-outline form-white mb-4">
        <?php
        $USER = $cnc->prepare("SELECT * FROM users WHERE EMAILuser = ?");
        $USER->bind_param("s",$email);
        $USER->execute();
        $result=$USER->get_result();
        while($row =  $result->fetch_assoc()) {
            ?>
            <p>Email : <?php echo $row ['EMAILuser']?></p>
            <p>USERNAME : <?php echo $row ['NAMEuser'] ?></p>
            <p>LASTNAME : <?php echo $row ['LASTNAMEuser'] ?></p>
            <?php
        }
        
        ?>
      </div>


    

    <hr class="my-4">

    <div class="d-flex justify-content-between">
      <p class="mb-2">Subtotal</p>
      <p class="mb-2"><?php
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

    <div class="d-flex justify-content-between">
      <p class="mb-2">Shipping</p>
      <p class="mb-2">$20.00</p>
    </div>

    <div class="d-flex justify-content-between mb-4">
      <p class="mb-2">Total(Incl. taxes)</p>
      <p class="mb-2"><?php
        $totalprice = $cnc->prepare("SELECT (SUM(price_product)+20) AS total_priceTTC
        FROM panier
        JOIN users ON panier.IDuser = users.IDuser
        JOIN products ON panier.IDproduct = products.IDproduct
        WHERE panier.IDuser = ?;");
        $totalprice->bind_param("i",$iduser);
        $totalprice->execute();
        $result=$totalprice->get_result();
    $row = $result->fetch_assoc();
        echo "$" . $row['total_priceTTC'];

        
        
        
        
        ?></p>
    </div>

    <button type="submit" name="checkout"  class="btn btn-info btn-block bg-light btn-lg">
      <div class="d-flex justify-content-between">
      <span>Checkout<i class="fas fa-long-arrow-alt-right ms-2"></i></span>
        <span><?php echo "$" . $row['total_priceTTC'];?></span>
      </div>
    </button>


    </form>
  </div>
</div>

</div>
                    <?php
                }
              
              ?>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>