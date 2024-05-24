<?php
session_start();
if(!isset($_SESSION['welix_loged_in'])){
    header("location: login.php");
}
if(!isset($_GET['invo_id']) || $_GET['invo_id'] == ""){
    echo "<script>document.location = 'invoices.php'</script>";
}else{
    $invo_id = $_GET['invo_id'];
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
                    <h2 class="theme-text disText">Payments History</h2>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="marg-t-10">
            <div class="flex-c fill pad-5 bg-w rad-5 shadow-pri">
                <table id="payTable" class="fill">
                    <thead class="theme-text">
                        <tr>
                            <th class="text-l">Inoice Number</th>
                            <th class="text-l">Amount Paid</th>
                            <th class="text-l">Payment Method</th>
                            <th class="text-l">Date of Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(payments($invo_id)-> num_rows > 0){
                                foreach(payments($invo_id) as $ment){
                                    ?>
                                        <tr>
                                            <td><?= $ment['invoice_no'] ?></td>
                                            <td><?= number_format($ment['paid_amount']  ) ?></td>
                                            <td><?= $ment['pay_method'] ?></td>
                                            <td><?= formatDate($ment['pay_date']) ?></td>
                                        </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>


    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/payments.js"></script>
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