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
    <div id="main-content" class="shift pad-5 ">
        <!-- Button to open/close the sidebar -->
        <header class="fill flex-s-btn bg-w pad-10 rad-5 shadow-pri">
            <div class="flex flex-s-btn fill">
                <div class="flex">
                    <div id="sidebar-toggle" class=" flex"> <i class="fa fa-bars theme-text-c size-18" aria-hidden="true"></i></div>
                    <!-- Main content goes here -->
                    <h1 class="theme-text disText">Outstanding Invoices</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="marg-t-10">
            <div class=" fill flex-c pad-5 ">
                <div class="grid-2 grid-gap-10 fill bg-w pad-10" style="min-height: 87vh;">
                    <div class="flex-c">
                        <div class="flex-c  gap-10 bg-w shadow-pri rad-3">
                            <div class="flex theme-border-b-2 pad-5 flex-s-btn fill">
                                <h3 class="theme-text disText">List</h3>
                                <div class="actions">
                                    <!-- <button title="Print" class="btn-pri"><i class="fa fa-print" aria-hidden="true"></i></button> -->
                                </div>
                            </div>
                            <div class="flex-c fill pad-5">

                                <table id="outstandingCustTable" class="fill">
                                    <thead>
                                        <tr>
                                            <th class="theme-text text-l">Invoice No.</th>
                                            <th class="theme-text text-l">Phone</th>
                                            <th class="theme-text text-l">Date</th>
                                            <th class="theme-text text-l">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows(fetchOutstanding()) > 0) {
                                            foreach (fetchOutstanding() as $outstanding) {
                                        ?>
                                                <tr>
                                                    <td class=""><?= $outstanding['invoice_no'] ?></td>
                                                    <td class="">
                                                        <?= $outstanding['cust_phone'] ?>
                                                    </td>
                                                    <td class="">
                                                        <?= formatDate($outstanding['invoice_date']) ?>
                                                    </td>
                                                    <td class="">
                                                        <button onclick="loadReqInfo('<?= $outstanding['invoice_id'] ?>','<?= $outstanding['invoice_no'] ?>','<?= $outstanding['cust_phone'] ?>','<?= $outstanding['cust_name'] ?>' )" class="btn-pri-o">info</button>

                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "No outstanding customers";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="detailWraper flex-c">
                        <div class="individualWraper flex-c fill scale-u" style="display: none;">
                            <div class="flex flex-s-btn bg-w pad-5 fill marg-5 shadow-pri">
                                <div class="flex">
                                    <button id="backToGenStat" title="Back" class="btn-pri"><i class="fas fa-arrow-circle-left" aria-hidden="true"></i></button>
                                    <h3 id="cust_namexx" class="theme-text">William Kimambo</h3>
                                    <h3 id="cust_phonexx" class="w-500">+255 745 801 564</h3>
                                </div>

                                <div class="themActions">
                                    <input type="hidden" id="invoTop">
                                    <input type="hidden" id="invoNum">
                                    <input type="hidden" id="custTop">
                                    <button id="addPayToCust" title="Add Payment" class="btn-pri-o"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    <button class="btn-pri-o"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                                </div>
                            </div>
                            <div class="grid-2 fill">
                                <div class="sideOnede flec-x scroll-x">

                                </div>
                                <div class="sideTwode flec-x scroll-x">
                                    <div class="balaBox  flex-c fill ">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="generalWraper flex-c fill">
                            <?php include("models/invoice_outstanding_summery.php") ?>
                        </div>
                    </div>
                </div>
        </main>

    </div>

    <div class="addPayMod outer_model fill" style="display: none;">
        <div class="inner_model width-50 rad-3 ">
            <div class="flex flex-s-btn pad-5 theme-border-b-2">
                <h3 class="custName normal-text">Customer Name</h3>
                <h3 class="theme-text">Add Payment</h3>
                <button class="cancelAddCustmod btn-pri-o"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <div class="flex-c fill">
                    <label for="custPayAmount">Amount Paid</label>
                    <input id="custPayAmount" type="number" class="input-s pad-5">
                </div>
                <div class="flex-c fill">
                    <label for="custPayMethod">Payment Method</label>
                    <select id="custPayMethod" class="input-s pad-5">
                        <option value="cash">Cash</option>
                        <option value="Lipa namba - tigo">Lipa namba - Tigo</option>
                        <option value="Lipa namba - vode">Lipa namba - Voda</option>
                        <option value="Lipa namba Airtel">Lipa namba - Airtel</option>
                    </select>
                </div>
                <div class="flex flex-centered fill">
                    <button id="addPayToCustbtn" class="btn-pri width-50 flex flex-centered pad-10">
                    <span class="loader-container" id="loaderContainerxxx">
                    <div class="loader" id="loader"></div>
                </span>
                <span id="buttonTextxxx">ADD PAYMENTS</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <?php include("models/general_autstand_models.php")  ?>
    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/outstanding-invoices.js"></script>
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