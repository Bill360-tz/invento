<?php
session_start();
if (!isset($_SESSION['welix_loged_in'])) {
    header("location: login.php");
}
if (!isset($_GET['id'])) {
    echo "<script> document.location = 'setting'</script>";
} else {
    $user_id = $_GET['id'];
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
                    <h1 class="theme-text">User Iformation</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main>
            <div class="flex-c fill flex-centered pad-10 ">
                <div class="flex-c bg-w rad-5 width-50 shadow-pri m-fill">
                    <div class="flex flex-s-btn fill pad-10">
                        <h3 class="theme-text "><small title="Go Back"><a href="setting" class="btn-pri"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></small> User Information</h3>
                        <input id="user_id" type="hidden" value="<?= $user_id ?>">
                        <div class="flex">
                            <button id="makeAdminBtn" class="btn-pri" style="display: none;">MAKE ADMIN</button>
                            <button id="unmakeAdminBtn" class="btn-pri" style="display: none;">REMOVE ADMIN</button>
                            <button id="editUser" title="Edit User" class="btn-pri"><i class="fas fa-edit    "></i></button>
                            <button id="canEditUser" title="Cancel User Edit" class="btn-pri" style="display: none;"><i class="fas fa-times-circle"></i></button>
                            <button id="deleteUser" title="Delete User" class="btn-pri"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>

                    <div class="flex-c fill pad-10">
                        <?php
                        if (singleUser($user_id)->num_rows > 0) {

                            foreach (singleUser($user_id) as $userInfo) {
                        ?>
                                <div class="flex-c pad-5 fill">
                                    <label class="normal-text" for="fullNAme">Your Full Name</label>
                                    <input type="text" id="fullNAme" class="input-s disi pad-5" value="<?= $userInfo['user_name'] ?>" disabled>
                                    <input type="hidden" id="hiddenName" class="input-s disi pad-5" value="<?= $userInfo['user_name'] ?>">
                                    <input type="hidden" id="hiddenRole" class="input-s disi pad-5" value="<?= $userInfo['user_role'] ?>">
                                    <input type="hidden" id="hiddenId" class="input-s disi pad-5" value="<?= $userInfo['user_id'] ?>">
                                </div>
                                <div class="flex-c pad-5 fill">
                                    <label for="loginPhone">Login Phone Number</label>
                                    <input type="text" id="loginPhone" class="input-s disi pad-5" value="<?= $userInfo['user_phone'] ?>" disabled>
                                </div>
                                <div class="flex-c pad-5 fill">
                                    <label for="loginEmail">Login Email</label>
                                    <input type="email" id="loginEmail" class="input-s disi pad-5" value="<?= $userInfo['user_email'] ?>" disabled>
                                </div>
                                <div class="hidd flex-c fill" style="display: none;">
                                    <small class="fill flex flex-centered" style="color: grey;"><i class="fa fa-info-circle" aria-hidden="true"></i> Leave Empty not to change password</small>
                                    <div class="flex-c pad-5 fill">
                                        <label for="sPass">Set password</label>
                                        <input type="password" id="sPass" class="input-s disi pad-5">
                                    </div>
                                    <div class="flex-c pad-5 fill">
                                        <label for="rPass">Repeat Password</label>
                                        <input type="password" id="rPass" class="input-s disi pad-5">
                                        <small id="ddsjd" style="color:red;display:none">Passwords do not match!</small>
                                    </div>
                                    <div class="flex pad-10 flex-centered">
                                        <button id="saveEditisU" class="btn-pri width-50 flex flex-centered m-fill">
                                            <span class="loader-container" id="loaderContainerxxx">
                                                <div class="loader" id="loader"></div>
                                            </span>
                                            <span id="buttonTextxxx">SAVE CHANGES</span>
                                        </button>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>
        </main>

    </div>
    <div class="outer_model flex-c deleteUser fill" style="display: none; align-items:center">
        <div class="inner_model width-40 bg-w   pad-10">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text">Delete User <span id="deletedCatNam"></span></h3>
                <button id="clossDeleteUsModel" class="clossDeleteUsModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex">
                    <input type="hidden" id="edit_cat_id">
                    <div class="flex fill">
                        <i style="font-size: 3.5rem;color:red" class="fa fa-trash-alt" aria-hidden="true"></i>
                        <p>This will delete all information on this user.</p>
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="deleteUserConfirmed" class="btn-pri pad-10 flex flex-centered">
                            <span class="loader-container" id="loaderContainerxx">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTextxx">DELETE</span>
                        </button>
                        <button class="clossDeleteUsModel btn-sec pad-10">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="outer_model flex-c makeAdmin fill" style="display: none; align-items:center">
        <div class="inner_model width-40 bg-w   pad-10">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text">Make User <span id="makekAdminNam"></span> Admin</h3>
                <button id="clossMakeUsModel" class="clossMakeUsModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex">
                    <input type="hidden" id="edit_cat_id">
                    <div class="flex fill">
                        <i style="font-size: 3.5rem;color:darkgreen" class="fa fa-id-badge" aria-hidden="true"></i>
                        <p>This will give the user every right in the system.</p>
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="makeAdminConfirmed" class="btn-pri flex flex-centered pad-10">
                            <span class="loader-container" id="loaderContainera">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTexta">CONFIRM</span>
                        </button>
                        <button class="clossMakeUsModel btn-sec pad-10">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="outer_model flex-c unmakeAdmin fill" style="display: none;align-items:center">
        <div class="inner_model width-40 bg-w   pad-10">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text">Remove User <span id="unmakekAdminNam"></span> from Admin</h3>
                <button id="clossunMakeUsModel" class="clossunMakeUsModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex">
                    <input type="hidden" id="edit_cat_id">
                    <div class="flex fill">
                        <i style="font-size: 3.5rem;color:darkgreen" class="fa fa-id-badge" aria-hidden="true"></i>
                        <p>This will remove all the admin prevalage from this use.</p>
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="unmakeAdminConfirmed" class="btn-pri pad-20 flex flex-centered">
                            <span class="loader-container" id="loaderContainerc">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTextc">CONFIRM</span>
                        </button>
                        <button class="clossunMakeUsModel btn-sec pad-10">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/user.js"></script>
    <script>
        // JavaScript to handle sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarTogglex = document.getElementById('sidebar-togglex');

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