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
    <div id="main-content" class="shift pad-5 ">
        <!-- Button to open/close the sidebar -->
        <header class="fill flex-s-btn bg-w pad-10 rad-5 shadow-pri">
            <div class="flex flex-s-btn fill">
                <div class="flex">
                    <div id="sidebar-toggle" class=" flex"> <i class="fa fa-bars theme-text-c size-18" aria-hidden="true"></i></div>
                    <!-- Main content goes here -->
                    <h1 class="theme-text disText">Outstanding Customers</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="">
            <div class=" h-90vh fill flex-c pad-5 marg-t-10">
                <div id="jojo" class="grid-2 grid-3qs grid-gap-10 fill">
                    <div class="flex-c">
                        <div class="flex-c  gap-10 bg-w shadow-pri">
                            <div class="flex  pad-5 flex-s-btn theme-border-b-2 fill">
                                <h3 class="theme-text disText">List</h3>
                                <div class="actions">
                                    <button title="Sms All" id="SmsAllOutstanding" class="btn-pri-o"><i class="fa fa-envelope" aria-hidden="true"></i> SMS ALL</button>
                                </div>
                            </div>
                            <div class="flex-c fill pad-5">

                                <table id="outstandingCustTable" class="fill">
                                    <thead>
                                        <tr>
                                            <th class="theme-text text-l">Customer Name</th>
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
                                                    <td class=""><?= $outstanding['cust_name'] ?></td>
                                                    <td class="">
                                                        <?= $outstanding['cust_phone'] ?>
                                                    </td>
                                                    <td class="">
                                                        <?= formatDate($outstanding['invoice_date']) ?>
                                                    </td>
                                                    <td class="">
                                                        <button onclick="loadReqInfo('<?= $outstanding['invoice_id'] ?>','<?= $outstanding['cust_phone'] ?>','<?= $outstanding['cust_name'] ?>' )" class="btn-pri-o">info</button>

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
                                <div class="flex" >
                                    <button id="backToGenStat" title="Back" class="btn-pri"><i class="fas fa-arrow-circle-left" aria-hidden="true"></i></button>
                                    <h3 id="cust_namexx" class="theme-text"></h3>
                                    <h3 id="cust_phonexx" class="w-500"></h3>
                                </div>

                                <div class="themActions">
                                    <input type="hidden" id="oneCustNumber">
                                    <input type="hidden" id="oneCustName">
                                    <!-- <button title="" class="btn-pri-o"><i class="fa fa-check" aria-hidden="true"></i></button> -->
                                    <button id="smsOneCust" class="btn-pri-o"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

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
                            <?php include("models/general_outstanding_summery.php") ?>
                        </div>
                    </div>
                </div>
        </main>

    </div>

    <div class="outer_model fill" style="display: none;">
        <div class="inner_model width-50 pad-10 rad-5">
            <div class="flex fill pad-5 flex-s-btn theme-border-b-2">
                <h3 class="theme-text disText">Sms Customer <span class="custName"></span></h3>
                <div class="flex"><button class="btn-pri-o"><i class="fa fa-times-circle" aria-hidden="true"></i></button></div>
            </div>
            <div class="flex-c fill pad-5">
                <label for="messageOneCust" class="normal-text"><i class="fas fa-signature    "></i> Wrrite your message</label>
                <textarea id="messageOneCust" cols="10" rows="5" placeholder="Type Here..." class="input-s pad-5"></textarea>
                <div class="flex flex-centered pad-20">
                    <button class="btn-pri width-50 m-fill">SEND</button>
                </div>
            </div>
        </div>
    </div>
    <?php include("models/general_autstand_models.php")  ?>
    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/outstanding-customers.js"></script>
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