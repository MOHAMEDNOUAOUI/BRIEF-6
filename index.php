<?php

if (assert($_POST)) {
  $name = $_POST["USERNAME"];

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


      <div class="left col-md-6 py-5 mx-0 bg-danger text-center">
      <h1 class="text-center text-light" >Sign UP</h2>
        <form action="" method="POST" class="my-5" >
              <div class="mb-3 d-flex align-items-center w-100 justify-content-center gap-2">
                  <ion-icon name="person-circle-outline" class="fs-2 text-light" ></ion-icon>
                  <input type="text" required class="form-control w-75" id="form1" placeholder="USERNAME" name="USERNAME">
              </div>
              <div class="mb-3 d-flex align-items-center w-100 justify-content-center gap-2">
                  <ion-icon name="person-circle-outline" class="fs-2 text-light" ></ion-icon>
                  <input type="text" required class="form-control w-75" id="form2" placeholder="LASTNAME" name="LASNAME">
              </div>
              <div class="mb-3 d-flex align-items-center w-100 justify-content-center gap-2">
              <ion-icon name="mail-outline" class="fs-2 text-light" ></ion-icon>
                  <input type="text" required class="form-control w-75" id="form3" placeholder="EMAIL" name="EMAIL">
              </div>
              <div class="mb-3 d-flex align-items-center w-100 justify-content-center gap-2">
              <ion-icon name="qr-code-outline" class="fs-2 text-white"></ion-icon>
                  <input type="text" required class="form-control w-75" id="form3" placeholder="PASSWORD" name="PASSWORD">
              </div>  
          <a href=""><input type="submit" value="REGISTER" name="register"></a>
        </form>
        <a href="LOGIN.php">do you have an Account already?</a>
      </div>


      <div class="right col-md-6 mx-0 px-0">
        <div class="IMG"></div>
      </div>
    </div>


    </section>





    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>