<?php
session_start();
if(isset($_SESSION['welix_loged_in'])){
    header("location: index");
}

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
                <div class="flex-c pad-10 width-50 bg-w shadow-pri rad-5 marg-t-10">
                    <div class="fill flex-c flex-centered pad-10">
                        <h1 class="theme-text"><i class="fa fa-key" aria-hidden="true"></i> Login</h1>
                        <small id="noUser" style="color: red;display:none">Incorrect Username or Password</small>

                        <small id="success" style="color: green;display:none"><i class="fa fa-check-circle" aria-hidden="true"></i> Success</small>
                    </div>
                    <div class="flex-c fill pad-10">
                        <label for="username"><i class="fa fa-user-circle" aria-hidden="true"></i> Enter Phone number</label>
                        <input id="username" type="text" class="input-s pad-5" placeholder="Phone">
                    </div>
                    <div class="flex-c fill pad-10">
                        <label for="password"><i class="fa fa-lock" aria-hidden="true"></i> Enter Password</label>
                        <input type="password" id="password" class="input-s pad-5" placeholder="password">
                    </div>
                    <div class="flex-c fill flex-centered pad-10">
                        <button id="loginWelix" class="btn-pri width-50 pad-10">LOGIN</button>
                        <!-- <a href="enter-email" class="theme-text-c width-50  text-c">forget password?</a> -->
                    </div>
                </div>
            </div>
    </main>

    <script src="../assets/js/login.js"></script>
</body>

</html>