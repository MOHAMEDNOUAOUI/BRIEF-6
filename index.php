<?php

include_once('connectDB.php');

if(isset($_POST['1']) || isset($_POST['2'])) {
  $pick = isset($_POST['1']) ? 1 : 2;
  
  $check = $cnc->prepare("UPDATE users SET IDrole = '$pick' WHERE EMAILuser = '$email'");
   $check->execute();
      echo "Database updated successfully";
}


$name = "";
$lastname = "";
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["USERNAME"];
  $lastname = $_POST["LAST"];
  $email = $_POST["EMAIL"];
  $password = $_POST["PASSWORD"];


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



    <section class="d-flex justify-content-center align-items-center">
      <div class="h-auto col-md-12 mx-0 px-0 inside-section card d-flex flex-row justify-content-between">


        <div class="left col-md-6 py-5 mx-0  text-center">
          <h1 class="text-center text-success">Sign UP</h2>
            <form action="" method="POST" class="my-5">
              <div class="mb-3 d-flex align-items-center w-100 justify-content-center gap-2">
                <ion-icon name="person-circle-outline" class="fs-2 text-success"></ion-icon>
                <input type="text" required class="form-control w-75" id="form1" placeholder="USERNAME" name="USERNAME">
              </div>
              <div class="mb-3 d-flex align-items-center w-100 justify-content-center gap-2">
                <ion-icon name="person-circle-outline" class="fs-2 text-success"></ion-icon>
                <input type="text" required class="form-control w-75" id="form2" placeholder="LASTNAME" name="LAST">
              </div>
              <div class="mb-3 d-flex align-items-center w-100 justify-content-center gap-2">
                <ion-icon name="mail-outline" class="fs-2 text-success"></ion-icon>
                <input type="email" required class="form-control w-75" id="form3" value="EMAIL" placeholder="EMAIL" name="EMAIL">
              </div>
              <div class="mb-3 d-flex align-items-center w-100 justify-content-center gap-2">
                <ion-icon name="qr-code-outline" class="fs-2 text-success"></ion-icon>
                <input type="password" required class="form-control w-75" id="form4" placeholder="PASSWORD" name="PASSWORD">
              </div>
              <a href=""><input type="submit" class="btn btn-success" value="REGISTER" name="register"></a>       
            </form>
            <a href="LOGIN.php">do you have an Account already?</a>
            <div class="text-success" >
            <?php
              $Qcheck = "SELECT EMAILuser FROM users WHERE EMAILuser = '$email'";
              $QR = mysqli_query($cnc, $Qcheck);
            if (mysqli_num_rows($QR) > 0) {
              echo "ACCOUNT ALREADY EXIST";
            }
            ?>
            </div>
        </div>


        <div class="right col-md-6 mx-0 px-0">
          <div class="IMG"></div>
        </div>
      </div>


    </section>




    <SCRIPT src="./assets/JS/javascriptindex.js"></SCRIPT>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>

  </html>