<?php
session_start();
if (isset($_SESSION['welix_loged_in'])) {
    header("location: index");
}

$tk = "agsvdvuyefyfFJKFKUYfvyfukyf";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/welix.css">
    <link rel="stylesheet" href="../assets/fontawasome5/css/all.min.css">
    <script src="../assets/js/jquery-3.6.0.js"></script>
    <script src="../assets/fontawasome5/js/all.min.js"></script>
    <script src="../assets/js/welix.js"></script>
</head>

<body class="bg-pri">
    <main class="fill flex-c">
        <div class="flex fill">
            <div class="flex fill bg-w shadow-pri pad-10 flex-s-btn">
                <h1 class="flex theme-text w-600"><img src="../assets/img/logo-full.png" style="width: 150px;" alt="ARUSHA LAPTOPS"> </h1>
                <div class="flex">
                    <!-- <a class="anchor theme-text-c" href=""><i class="fa fa-lock" aria-hidden="true"></i> Register</a> -->
                </div>
            </div>

        </div>
        <div class="flex-c fill flex-centered">
            <div class="flex-c pad-20 width-50 bg-w shadow-pri rad-5 marg-t-10">
                <div class="flex fill ">
                    <p>Enter your registered Email Below</p>
                </div>
                <div class="fill pad-10 flex-c flex-centered">
                    <input type="email" id="userEmail" class="input-s pad-10 width-80">
                    <a id="checkEmail" class="btn-pri pad-10 width-50">CONTINUE <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/js/password-reset.js"></script>
</body>

</html>