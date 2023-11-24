<?php
include_once('connectDB.php');
session_start();
if (isset($_SESSION['email_register'])) {
    $email = $_SESSION['email_register'];
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

if(isset($_POST['MODIFYCATEGORY'])){
    $inputvalue = $_POST['MODIFYCATEGORY'];//INPUT VALUE;
    $buttonID = $_POST['IDCATEGORY']; // i want the inside of this //THE ID OF THE CATEGORY;       

    $CATEGORY_MODIFY = $cnc->prepare("UPDATE category SET NAMEcategory = ? WHERE IDcategory = ?");
    $CATEGORY_MODIFY->bind_param("si",$inputvalue,$buttonID);
    $CATEGORY_MODIFY->execute();
    $error = "<h4>CATEGORY MODIFIED SUCCEFULY</h4>";
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


</head>

<body style="font-family: 'Rubik';">


    <div class="HERO d-flex" style="width:100vw;height:100vh">
        <div class="LEFT  top-0 bottom-0 bg-gradient bg-success w-25 h-100">
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
        <div class="RIGHT w-75 h-100 position-relative">

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
                        echo "Products here";
                    } else if ($key == 'Categories') {
            ?>

                        <div class="CATE mt-5 top w-100 d-flex justify-content-between px-5 align-items-center" id="test">
                            <div class="">
                                <h4>Add New Category</h4>
                                <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                            </div>
                            <!-- Button trigger modal -->
                            <ion-icon name="add-circle-outline" class="fs-1" data-bs-toggle="modal" data-bs-target="#exampleModal"></ion-icon>
                        </div>


                        <!-- Modal -->
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
                            <h1 class="text-center">CATEGORIES</h1>
                            <table class="table table-success w-75 mx-auto">

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
                                            <td>
                                                <form action="" method="POST">
                                                
                                                    <button class="btn btn-danger" name="DELETE">DELETE</button>
                                                </form>
                                                <button class="btn btn-primary" name="MODIFY" data-bs-toggle="modal" data-bs-target="#TEST<?php echo $id?>">MODIFY</button>



                                            </td>
                                        </tr>


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
                        echo "Users here";
                    } else if ($key == 'Profile') {
                        echo "Profile here";
                    } else if ($key == 'Dashboard') {
                        $PRODUCTS = $cnc->prepare("SELECT * FROM products");
                        $CATEGORIES = $cnc->prepare("SELECT * FROM category");
                        $USERS = $cnc->prepare("SELECT * FROM users");
                        $qr = "SELECT NAMEuser,LASTNAMEuser FROM users WHERE EMAILuser = '$email'";

                        //returning CLIENTS
                        $QC = "SELECT * FROM users WHERE IDrole = 2";
                        $RC = mysqli_query($cnc, $QC);
                        $CC = mysqli_num_rows($RC);
                        ///RETURNING AMINDS
                        $QA = "SELECT * FROM users WHERE IDrole = 1";
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
                    $QC = "SELECT * FROM users WHERE IDrole = 2";
                    $RC = mysqli_query($cnc, $QC);
                    $CC = mysqli_num_rows($RC);
                    ///RETURNING AMINDS
                    $QA = "SELECT * FROM users WHERE IDrole = 1";
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