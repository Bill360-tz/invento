<?php
session_start();
if (!isset($_SESSION['welix_loged_in'])) {
    header("location: login.php");
}
if (!isset($_GET['cat']) || $_GET['cat'] == "") {
    $cat = "All";
} else {
    $cat = $_GET['cat'];
}
if (!isset($_GET['prB']) || $_GET['prB'] == "") {
    $prB = "All";
} else {
    $prB = $_GET['prB'];
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
                    <div id="sidebar-toggle" class=" flex"> <i class="fa fa-bars theme-text-c size-18" aria-hidden="true"></i></div>
                    <!-- Main content goes here -->
                    <h1 class="theme-text disText">Make Sale</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main>
            <?php include("models/selectItem_model.php") ?>
            <!-- confirm Complete Sale Model -->


        </main>

    </div>
    <?php include("models/completeSaleModel.php") ?>

    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/sales_operation.js"></script>
    <script src="../assets/js/sale.js"></script>
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