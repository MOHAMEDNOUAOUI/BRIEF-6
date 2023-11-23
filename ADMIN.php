<?php
include_once('connectDB.php');
session_start();
if(isset($_SESSION['email_register'])) {
    $email = $_SESSION['email_register'];
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>

    <div class="HERO d-flex" style="width:100vw;height:100vh">
        <div class="LEFT w-25 h-100">
            <h1 class="ps-2 py-4 text-success text-center border-bottom border-success border-2">DASHBOARD</h1>
            <div class="h-75 w-100">
                <form action="" method="POST" class="row align-items-center justify-content-evenly h-100">

                   <div class="d-flex flex-column align-items-center gap-3" >
                            <button class="btn btn-success w-75 text-start d-flex align-items-center gap-3">
                            <ion-icon name="home-outline" class="fs-2"></ion-icon> 
                                DASHBOARD
                            </button>
                            <button class="btn btn-success w-75 text-start d-flex align-items-center gap-3"   name="Products">
                            <ion-icon name="leaf-outline" class="fs-2" ></ion-icon> 
                                Products
                            </button>
                            <button class="btn btn-success w-75 text-start d-flex align-items-center gap-3"  name="Categories">
                            <ion-icon name="albums-outline" class="fs-2"></ion-icon> 
                                Categories
                            </button>
                            <button class="btn btn-success w-75 text-start d-flex align-items-center gap-3"   name="Users">
                            <ion-icon name="people-outline" class="fs-2" ></ion-icon>
                                Users
                            </button>
                   </div>

                <button class="btn btn-success w-auto text-start d-flex align-items-center gap-3"  name="Profile">
                <ion-icon name="people-outline" class="fs-2" ></ion-icon>
                    Profile
                </button>
                
                </form>
            </div>
        </div>



        <!--MAINN PLACE -->
        <div class="RIGHT bg-success w-75 h-100">
            <?php
            // echo $email;
                if($_SERVER["REQUEST_METHOD"] == 'POST') {
                    foreach($_POST as $key=>$value) {
                        if($key == 'Products') {
                            echo "Products here";
                        }
                        else if ($key == 'Categories') {
                            echo "Categorie here";
                        }
                        else if ($key == 'Users') {
                            echo "Users here";
                        }
                        else if ($key == 'Profile') {
                            echo "Profile here";
                        }
                    }
                }
                else {
                    ?>

                    <div class="STATISTIQUE w-100 h-25 d-flex justify-content-evenly my-3">
                        <div class="card PRODUCTS STATS  w-25 rounded-4">
                            AAAA
                        </div>
                        <div class="card categories STATS w-25 rounded-4">
                            HHHH
                        </div>
                        <div class="card Users STATS w-25 rounded-4">
                                HHH
                        </div>
                    </div>

                    <?php
                }
            ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>