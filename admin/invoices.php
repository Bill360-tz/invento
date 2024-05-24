<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['welix_loged_in'])) {
    header("location: login.php");
}
?>
<html lang="en">
<?php include("includes/head.php")  ?>
<?php include("functions/functions.php")  ?>

<body class="bg-pri">
    <!-- Sidebar -->
    <?php include("includes/sidebar.php")  ?>

    <!-- Main Content -->
    <div id="main-content" class="shift pad-5 ">
        <!-- Button to open/close the sidebar -->
        <header class="fill flex-s-btn bg-w pad-10 rad-5 shadow-pri">
            <div class="flex flex-s-btn fill">
                <div class="flex">
                    <div id="sidebar-toggle" class=" flex"> <i class="fa fa-bars theme-text-c size-18" aria-hidden="true"></i></div>
                    <!-- Main content goes here -->
                    <h1 class="theme-text disText">All Invoices</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="flex-c fill marg-t-10">
            <div class=" fill flex-c bg-w pad-10" style="min-height: 87vh;">
                <div class="grid-3qs grid-gap-10  fill ">
                    <div class="flex-c">
                        <div class="flex-c  gap-10 bg-w shadow-sec rad-5">
                            <div class="flex theme-border-b-2 pad-5 flex-s-btn fill">
                                <select id="expFilter" class="input-s pad-5">
                                    <?php
                                    if ($_SESSION['expSeasion'] == "today") {
                                    ?>
                                        <option value="today">Today</option>
                                    <?php
                                    } elseif ($_SESSION['expSeasion'] == "week") {
                                    ?>
                                        <option value="week">This Week</option>
                                    <?php
                                    } elseif ($_SESSION['expSeasion'] == "month") {
                                    ?>
                                        <option value="month">This Month</option>
                                    <?php
                                    } elseif ($_SESSION['expSeasion'] == "year") {
                                    ?>
                                        <option value="year">This Year</option>
                                    <?php
                                    }

                                    ?>
                                    <option value="today">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="year">This Year</option>
                                </select>
                                <div class="actions">
                                    <!-- <button title="Print" class="btn-pri"><i class="fa fa-print" aria-hidden="true"></i></button> -->
                                </div>
                            </div>
                            <div class="flex-c fill pad-5">

                                <table id="outstandingCustTable" class="fill">
                                    <thead>
                                        <tr>
                                            <th class="theme-text text-l">Invoice</th>
                                            <th class="theme-text text-l">Total Price</th>
                                            <th class="theme-text text-l">Discount</th>
                                            <th class="theme-text text-l">Amount Due</th>
                                            <th class="theme-text text-l">Date</th>
                                            <th class="theme-text text-l">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows(fetchInvoices()) > 0) {
                                            foreach (fetchInvoices() as $outstanding) {
                                        ?>
                                                <tr>
                                                    <td class=""><?= $outstanding['invoice_no'] ?></td>
                                                    <td class="">
                                                        <?= number_format($outstanding['total_price']) ?>
                                                    </td>
                                                    <td class="">
                                                        <?= number_format($outstanding['discount']) ?>
                                                    </td>
                                                    <td class="">
                                                        <?= number_format($outstanding['amount_due']) ?>
                                                    </td>
                                                    <td class="">
                                                        <?= formatDate($outstanding['invoice_date']) ?>
                                                    </td>
                                                    <td class="">
                                                        <button onclick="loadReqInfo('<?= $outstanding['invoice_id'] ?>','<?= $outstanding['cust_phone'] ?>','<?= $outstanding['cust_name'] ?>','<?= $outstanding['invoice_no'] ?>' )" class="btn-pri-o">info</button>
                                                        <button onclick="deleteInvo('<?= $outstanding['invoice_id'] ?>','<?= $outstanding['invoice_no'] ?>' )" class="btn-pri-o"><i class="fa fa-trash"></i></button>

                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="detailWraper flex-c">
                        <div class="individualWraper flex-c fill scale-u" style="display: none;">
                            <div class="flex flex-s-btn bg-w pad-5 fill marg-5 shadow-sec">
                                <div class="flex flex-s-btn fill">
                                    <div class="flex">
                                    <button id="backToGenStat" title="Back" class="btn-pri"><i class="fas fa-arrow-circle-left" aria-hidden="true"></i></button>
                                    <h3 id="cust_namexx" class="theme-text"></h3>
                                    </div>
                                    <button id="print_recipt" class="btn-pri-o">
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                    </button>
                                </div>

                                <div class="themActions">
                                    <button style="display: none;" class="btn-pri-o"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                                </div>
                            </div>
                            <div class="flex-c fill">
                                <div class="sideOnede flec-x scroll-x">

                                </div>


                            </div>
                        </div>
                        <div class="generalWraper flex-c fill">
                            <?php include("models/general_invoices_summery.php") ?>
                        </div>
                    </div>
                </div>
        </main>

    </div>

    <!-- delete category model -->
    <div class="delete_cat_model fill flex-c" style="display: none;">
        <div class="inner_delete_cat_model width-50 flex-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="normal-text">Delete Invoice <span id="deletedCatNam" class="theme-text"></span></h3>
                <button id="clossDeleteCatModel" class="clossDeleteCatModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex">
                    <input type="hidden" id="delete_cat_id">
                    <div class="flex fill">
                        <i class="fa fa-info-circle normal-text" aria-hidden="true"></i>
                        <p>You are about to delete this invoice</p>
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
    <?php include("models/general_autstand_models.php")  ?>
    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/invoices.js"></script>
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