<?php
include_once('connectDB.php');
session_start ();
if(isset($_SESSION['email_register'])) {
    $email = $_SESSION['email_register'];
    echo $email;
}

//1 == ADMIN
//2 == CLIENT
if (isset($_POST['1'])) {
    $pick = 1; 
} elseif (isset($_POST['2'])) {
    $pick = 2; 
}

if (isset($pick)) {
    $check = $cnc->prepare("UPDATE users SET IDrole = '$pick' WHERE EMAILuser = '$email'");
    if ($check) {
        $check->execute();
        header("Location: LOGIN.php");
    } else {
        echo "Failed to update database";
    }

    $check->close();
    $cnc->close();
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


    <div class= "w-100 d-flex align-items-center justify-content-center text-center" style="height:100vh">
    <div class="container text-center">
            <form action="" method="POST">
                <h1 class="text-success my-5">Account Type</h1>
            <div class="row justify-content-center gap-4">
            <div class="col-3 card border-0 d-flex gap-5 align-items-center">
                <ion-icon name="person-outline" class="text-success" style="font-size:10rem"></ion-icon>
                <input type="submit" class="btn btn-success" name="1" value="ADMIN">
                </div>
                <div class="col-3 card border-0 d-flex gap-5 align-items-center">
                <ion-icon name="person-outline" class="text-success" style="font-size:10rem"></ion-icon>
                <input type="submit" class="btn btn-success" name="2" value="CLIENT">
                </div>
            </div>
            </form>
        </div>
    </div>



    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>