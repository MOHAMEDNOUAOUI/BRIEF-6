<?php

include_once('connectDB.php');


$name = "";
$lastname = "";
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["USERNAME"];
  $lastname = $_POST["LAST"];
  $email = $_POST["EMAIL"];
  $password = $_POST["PASSWORD"];

  if(strlen($name) <= 5 || strlen($lastname) <=5 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<script>alert("Please check your informations.");</script>';
  }
  else {
    $Qcheck = "SELECT EMAILuser FROM users WHERE EMAILuser = '$email'";
    $QR = mysqli_query($cnc, $Qcheck);
  
    if (mysqli_num_rows($QR)==0) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  
      $QUERY = ("INSERT INTO users (NAMEuser,LASTNAMEuser,EMAILuser,PASSWORDuser) 
              values ('$name','$lastname','$email','$hashedPassword')");
      $resultregister = mysqli_query($cnc, $QUERY);
  
      if ($resultregister) {
        session_start();
        $_SESSION['email_register'] = $email;
        header("Location: checker.php");
        exit;
      } else {
        echo "ERROR" . $resultregister . "<br>";
      }
  }
  }


  
 }

 


?>


  <!doctype html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="REGISTER.css">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>

  <body>



  <div class="container d-flex justify-content-center align-items-center" style="height:100vh">
        <div class="row col-md-9 border-1 border border-success" style="height:30rem">
            <div class="LEFT col-md-5 bg-success">
            <ion-icon class="fs-1" name="leaf-outline"></ion-icon>
            <h4>Opep your place for brand new PLANTS</h4>

            </div>
            <div class="RIGHT d-flex col-md-7 align-items-center justify-content-center">
                    
                    <form action="" method="POST">
                    <h4 class="fs-1 text-success mb-4">Sign up</h4>
                        <div class="d-flex">
                            <div class="w-75 form-outline">
                            <label class="form-label" for="formControlReadonly">NAME</label>
                            <input required type="text" class="form-control" placeholder="USERNAME" id="form1" name="USERNAME">
                            </div>
                        
                        <div class="ms-4 w-75">
                            <label for="" class="form-label">LASTNAME</label>
                            <input required type="text"  class="form-control" placeholder="LASTNAME" id="form2" name="LAST">
                        </div>
                        </div>
                        <label for="" class="form-label">Email</label>
                        <input required type="email" class="form-control" placeholder="EMAIL" name="EMAIL" id="form3" class="w-100">
                        <label for="" class="form-label">password</label>
                        <input required type="password" class="form-control" placeholder="PASSWORD" id="form4" name="PASSWORD" class="w-100">
                        <button class="btn btn-success w-100 mt-5">Suivant</button>
                        <a class="d-flex justify-content-center" href="LOGIN.php">do you have an Account already?</a>
                        <div class="text-success" >
            <?php
              $Qcheck = "SELECT EMAILuser FROM users WHERE EMAILuser = '$email'";
              $QR = mysqli_query($cnc, $Qcheck);
            if (mysqli_num_rows($QR) > 0) {
              ?>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content bg-success text-light">
          <div class="modal-body text-center d-flex align-items-center">
          <ion-icon class="fs-1" name="bug-outline"></ion-icon>
            <h3>Sorry Sir but account already exist!!</h3>
          </div>
        </div>
      </div>
    </div>

    <script>
              document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        });
            </script>
              
              <?php
            }
            ?>
            </div>
                    </form>
                    
            </div>
        </div>
    </div>




    <SCRIPT src="./assets/JS/javascriptindex.js"></SCRIPT>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>

  </html>