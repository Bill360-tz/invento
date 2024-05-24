<?php
session_start();
if (!isset($_SESSION['welix_loged_in'])) {
    header("location: login.php");
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
                    <h1 class="theme-text disText">All Customers</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main>
            <div class="flex-c fill bg-w shadow-pri marg-t-10">
                <div class="flex flex-s-btn fill pad-5 theme-bg">
                    <h3 class="text-w w-500">All Customers</h3>
                    <div class="flex"><button id="trigSmsAllModel" title="SMS Them All" class="btn-pri-o-w"><i class="fa fa-envelope" aria-hidden="true"></i> SMS ALL</button></div>
                </div>
                <div class="flex-c fill pad-5">
                    <table id="cutomersTable">
                        <thead class="theme-text">
                            <tr>
                                <th class="text-l">Customer Name</th>
                                <th class="text-l">Customer Phone</th>
                                <th class="text-l">No. Purchases</th>
                                <th class="text-l">Last Purchase</th>
                                <th class="text-l">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows(customers()) > 0) {

                                $inPrint = array();
                                foreach (customers() as $custInfo) {

                                    if (!in_array($custInfo['cust_phone'], $inPrint)) {
                            ?>
                                        <tr>
                                            <td><?= $custInfo['cust_name'] ?></td>
                                            <td><?= $custInfo['cust_phone'] ?></td>
                                            <td><?= purchaseTimes($custInfo['cust_phone']) ?></td>
                                            <td><?= formatDate(resentPurc($custInfo['cust_phone'])['invoice_date']) ?></td>
                                            <td>
                                                <button style="display: none;" onclick="deleteCust('<?= $custInfo['cust_phone'] ?>', '<?= $custInfo['cust_name'] ?>')" class="btn-pri-o">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                                <button class="btn-pri-o"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                            <?php
                                    }

                                    array_push($inPrint, $custInfo['cust_phone']);
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

     <!-- delete category model -->
     <div class="delete_cat_model fill flex-c" style="display: none;">
        <div class="inner_delete_cat_model width-50 flex-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="normal-text">Delete Customer <span id="deletedCatNam" class="theme-text"></span></h3>
                <button id="clossDeleteCatModel" class="clossDeleteCatModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex">
                    <input type="hidden" id="delete_cat_id">
                    <div class="flex fill">
                        <i  class="fa fa-info-circle normal-text" aria-hidden="true"></i>
                        <p>You are about to delete this customer</p>
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="deleteCatConfirmed" class="btn-pri flex flex-centered pad-10">
                            <span class="loader-container" id="loaderContaineryt">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTextyt">DELETE</span>
                        </button>
                        <button class="clossDeleteCatModel btn-sec pad-10">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="outer_model smsAllCustModel fill" style="display: none;">
        <div class="inner_model width-50 pad-10 rad-3">
            <div class="flex fill pad-5 flex-s-btn theme-border-b-2">
                <h3 class="theme-text"><i class="fa fa-paper-plane" aria-hidden="true"></i> Sms All Customer</h3>
                <div class="flex"><button id="closeSmMo" class="btn-pri-o"><i class="fa fa-times-circle" aria-hidden="true"></i></button></div>
            </div>
            <div class="flex-c fill pad-5">
                <label for="message" class="normal-text"><i class="fas fa-signature    "></i> Write your message</label>
                <textarea id="message" placeholder="Type Here..." cols="10" rows="5" class="input-s pad-5"></textarea>
                <small class="grey">Write <strong>_name_</strong> for the system to automatic insert a name</small>
            </div>
            <div class="flex flex-centered pad-20">
                <button id="senMessageToAllCusts" class="btn-pri width-50 flex flex-centered">
                <span class="loader-container" id="loaderContainerxxxaa">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTextxxxaa">SEND</span>
                </button>
            </div>
        </div>
    </div>

    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/all_customers.js"></script>
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

    </script>
</body>

</html>