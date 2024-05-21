<?php
session_start();
if (!isset($_SESSION['welix_loged_in'])) {
    header("location: login");
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include("includes/head.php")  ?>
<?php include("functions/functions.php")  ?>

<body class="bg-pri">
    <!-- Sidebar -->
    <?php include("includes/sidebar.php")  ?>

    <!-- Main Content -->
    <div id="main-content" class="shift pad-5">
        <!-- Button to open/close the sidebar -->
        <header class="fill flex-s-btn bg-w pad-10 rad-5 shadow-pri">
            <div class="flex flex-s-btn fill">
                <div class="flex">
                    <div id="sidebar-toggle" class=" flex"> <i class="fa fa-bars theme-text size-18" aria-hidden="true"></i></div>
                    <!-- Main content goes here -->
                    <h1 class="theme-text disText">Settings</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main>
            <div class="grid-2 pad-10  m-flex m-gap-10">
                <div class="flex-c pad-10 bg-w rad-5 shadow-pri m-fill">
                    <div class="flex fill flex-s-btn">
                        <h3 class="theme-text">Profile Information</h3>
                        <div class="flex">
                            <button id="editInfo" title="Edit Information" class="btn-pri pad-10"><i class="fas fa-edit    "></i></button>
                            <button id="cancelEditInfo" title="Cancel" style="display: none;" class="btn-pri-o pad-10"><i class="fas fa-times-circle    "></i></button>
                        </div>

                    </div>
                    <div class="flex-c fill">
                        <?php
                        if (mysqli_num_rows(currentUsers()) > 0) {
                            foreach (currentUsers() as $curUser) {
                        ?>
                                <div class="flex-c pad-5 fill">
                                    <label class="normal-text" for="fullNAme">Your Full Name</label>
                                    <input type="text" id="fullNAme" class="input-s disi pad-5" value="<?= $curUser['user_name'] ?>" disabled>
                                </div>
                                <div class="flex-c pad-5 fill">
                                    <label for="loginPhone">Login Phone Number</label>
                                    <input type="text" id="loginPhone" class="input-s disi pad-5" value="<?= $curUser['user_phone'] ?>" disabled>
                                </div>
                                <div class="flex-c pad-5 fill">
                                    <label for="loginEmail">Login Email</label>
                                    <input type="email" id="loginEmail" class="input-s disi pad-5" value="<?= $curUser['user_email'] ?>" disabled>
                                </div>
                                <div class="hidd flex-c fill" style="display: none;">
                                    <small class="fill flex flex-centered" style="color: grey;"><i class="fa fa-info-circle" aria-hidden="true"></i> Leave Empty not to change password</small>
                                    <div class="flex-c pad-5 fill">
                                        <label for="sPass">Set password</label>
                                        <input value="" type="password" id="sPass" class="input-s disi pad-5">
                                    </div>
                                    <div class="flex-c pad-5 fill">
                                        <label for="rPass">Repeat Password</label>
                                        <input type="password" id="rPass" class="input-s disi pad-5">
                                        <small id="ddsjd" style="color:red;display:none">Passwords do not match!</small>
                                    </div>
                                    <div class="flex pad-10 flex-centered">
                                        <button id="saveEditisU" class="btn-pri width-50 m-fill flex flex-centered">
                                            <span class="loader-container" id="loaderContainerX">
                                                <div class="loader" id="loader"></div>
                                            </span>
                                            <span id="buttonTextX">SAVE CHANGES</span>
                                        </button>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "Something went wrong";
                        }
                        ?>

                    </div>
                </div>
                <?php
 if ($_SESSION['welix_loged_in']['user_role'] == '1'){
?>
 <div class="flex-c pad-10 rad-5 bg-w shadow-pri m-fill m-marg-t-10">
                    <div class="flex fill flex-s-btn">
                        <h3 class="theme-text">List of your Users</h3>
                        <div class="flex">
                            <button id="addUserTrigure" title="Add User" class="btn-pri pad-10"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="flex-c pad-5">
                        <?php
                        if (mysqli_num_rows(officeUsers()) > 0) {
                            foreach (officeUsers() as $user) {
                        ?>
                                <div class="grid-2">
                                    <div class="flex"><?= $user['user_name'] ?></div>
                                    <div class="flex flex-s-btn">
                                        <span><?= $user['user_phone'] ?></span>
                                        <span><?php
                                                if ($user['user_role'] == "1") {
                                                    echo "is Admin";
                                                } else {
                                                    echo "not Admin";
                                                }
                                                ?></span>
                                        <a href="user?id=<?= $user['user_id'] ?>" class="btn-pri-o"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "You have not added any other user yet!";
                        }
                        ?>
                    </div>
                </div>
<?php
 }
                ?>
               
            </div>
        </main>

    </div>

    <div id="adduserModel" class="outer_model flex-c fill" style="display: none;align-items:center">
        <div class="inner_model width-50 m-fill rad-5 m-marg-10">
            <div class="flex fill flex-s-btn pad-5">
                <h3 class="theme-text"><i class="fa fa-user-plus" aria-hidden="true"></i> Add User</h3>
                <div class="flex">
                    <button id="closAdduser" class="btn-pri-o"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="flex-c pad-10 normal-text">
                <label for="fName">User full Name</label>
                <input type="text" id="fName" class="input-s pad-5">
                <label for="phone">User Phone Number</label>
                <input type="text" id="phone" class="input-s pad-5">
                <label for="uEmail">User Email</label>
                <input type="email" id="uEmail" class="input-s pad-5">
                <label for="user_role">Admin Permissions</label>
                <select class="input-s pad-5" id="user_role">
                    <option value="2">No</option>
                    <option value="1">Yes</option>
                </select>
                <label for="uSPass">Set User Password</label>
                <input type="password" id="uSPass" class="input-s pad-5">
                <label for="uRpass">Repeat User Password</label>
                <input type="password" id="uRpass" class="input-s pad-5">
                <small id="passM" style="color: red;display:none"> Passwords do not match!</small>
                <div class="flex fill flex-centered">
                    <button id="saveNewUser" class="width-50 flex flex-centered btn-pri pad-10">
                        <span class="loader-container" id="loaderContainer">
                            <div class="loader" id="loader"></div>
                        </span>
                        <span id="buttonText">SAVE NEW USER</span>
                    </button>
                </div>

            </div>
        </div>
    </div>


    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/setting.js"></script>
    <script>
        // JavaScript to handle sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        // const sidebarTogglex = document.getElementById('sidebar-togglex');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            mainContent.classList.toggle('shift');
        });
        // sidebarTogglex.addEventListener('click', () => {
        //     sidebar.classList.toggle('open');
        //     mainContent.classList.toggle('shift');
        // });
    </script>
</body>

</html>