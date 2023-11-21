<?php
include_once('connectDB.php');

$emailLOGIN = "";
$passwordLOGIN = "";



if($_SERVER["REQUEST_METHOD"] == "POST") {
$emailLOGIN = $_POST["EMAIL"];
$passwordLOGIN = $_POST["PASSWORD"];
$Loginquery = "SELECT * FROM users WHERE EMAILuser = '$emailLOGIN'";
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


    <div class="bg-danger w-100 d-flex align-items-center justify-content-center text-center" style="height:100vh">
        <form action="" method="POST" class="my-5 bg-primary w-25 h-50 d-flex flex-column  justify-content-center">
              <div class="mb-3 d-flex align-items-center w-100 justify-content-center gap-2">
                <ion-icon name="mail-outline" class="fs-2 text-light"></ion-icon>
                <input type="email" required class="form-control w-75" id="form3" placeholder="EMAIL" name="EMAIL">
              </div>
              <div class="mb-3 d-flex align-items-center w-100 justify-content-center gap-2">
                <ion-icon name="qr-code-outline" class="fs-2 text-white"></ion-icon>
                <input type="password" required class="form-control w-75" id="form4" placeholder="PASSWORD" name="PASSWORD">
              </div>
              <a href=""><input type="submit" value="LOGIN" name="LOGIN"></a>       
            </form>
    </div>
          
    


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>