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
<?php  ?>

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
                    <h1 class="theme-text disText">Ordered Items</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="marg-t-10">
            <div class="flex-c pad-20 flex-centered fill">
                <div class="flex-c fill bg-w rad-3 shadow-pri">
                    <div class="flex fill flex-s-btn pad-5 theme-border-b-2">
                        <div class="flex">
                            <h3 class="normal-text pad-5 ">Total = <span><?= number_format(sumOrdered())." Tshs." ?></span></h3>
                        </div>

                        <button id="addExphh" class="btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> ADD ITEM</button>
                    </div>
                    <div class="flex-c fill pad-10">
                        <table id="expRecord" class="fill">
                            <thead class="theme-text">
                                <tr>
                                    <th class="text-l">S/N</th>
                                    <th class="text-l">Item </th>
                                    <th class="text-l">Amount</th>
                                    <th class="text-l">Date Ordered</th>
                                    <th class="text-l">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows(ordered()) > 0) {
                                    $sn = 1;
                                    foreach (ordered() as $exp) {
                                ?>
                                        <tr>
                                            <td><?= $sn ?></td>
                                            <td><?= $exp['item_name'] ?></td>
                                            <td><?= number_format($exp['item_cost']) ?></td>
                                            <td><?= formatDate($exp['date_ordered'])  ?></td>
                                            <td>
                                                <button onclick="editExpense('<?= $exp['order_id'] ?>', '<?= $exp['item_name'] ?>','<?= $exp['item_cost'] ?>','<?= $exp['date_ordered'] ?>')" class="btn-pri-o">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="deleteEx('<?= $exp['order_id'] ?>', '<?= $exp['item_name'] ?>')" class="btn-pri-o">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                <?php
                                        $sn += 1;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>


    </div>
    <!-- delete category model -->
    <div class="delete_cat_model fill flex-c" style="display: none;">
        <div class="inner_delete_cat_model width-50 flex-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="normal-text">Delete Ordered Item <span id="deletedCatNam" class="theme-text"></span></h3>
                <button id="clossDeleteCatModel" class="clossDeleteCatModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex">
                    <input type="hidden" id="delete_cat_id">
                    <div class="flex fill">
                        <i  class="fa fa-info-circle normal-text" aria-hidden="true"></i>
                        <p>You are about to delete this Items</p>
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
        <div class="addExpModel outer_model fill" style="display: none;">
            <div class="inner_model bg-w width-50">
                <div class="flex flex-s-btn pad-5">
                    <h3 class="theme-text">Add Orderd Product</h3>
                    <button class="cancelExpAdd btn-pri-o"><i class="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <flex-c class="flex-c fill pad-10">
                    <div class="flex-c fill">
                        <label for="expenseName">Product Name</label>
                        <input id="expenseName" type="text" class="input-s pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="expenseAmount">Product Cost</label>
                        <input id="expenseAmount" type="number" class="input-s pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="expenseDate"> Ordered date</label>
                        <input id="expenseDate" type="date" class="input-s pad-5">
                    </div>
                    <div class="flex flex-centered fill pad-10">
                        <div class="grid-2 width-60">
                            <button class="cancelExpAdd btn-sec pad-10"><i class="fa fa-times-circle" aria-hidden="true"></i> CANCEL</button>
                            <button id="saveExpense" class="btn-pri pad-10">
                                <span class="loader-container" id="loaderContainerxxx">
                                    <div class="loader" id="loader"></div>
                                </span>
                                <span id="buttonTextxxx">SAVE</span>
                            </button>

                        </div>
                    </div>
                </flex-c>
            </div>
        </div>
        <div class="editExpModel outer_model fill" style="display: none;">
            <div class="inner_model bg-w width-50">
                <div class="flex flex-s-btn pad-5">
                    <h3 class="theme-text">Edit Ordered Item</h3>
                    <button class="cancelExpEdit btn-pri-o"><i class="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <flex-c class="flex-c fill pad-10">
                    <div class="flex-c fill">
                        <input type="hidden" id="ex_idxx">
                        <label for="expenseNamee">Item Name</label>
                        <input id="expenseNamee" type="text" class="input-s pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="expenseAmounte">Item Cost </label>
                        <input id="expenseAmounte" type="number" class="input-s pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="expenseDatee">Ordered date</label>
                        <input id="expenseDatee" type="date" class="input-s pad-5">
                    </div>
                    <div class="flex flex-centered fill pad-10">
                        <div class="grid-2 width-60">
                            <button class="cancelExpEdit btn-sec pad-10"><i class="fa fa-times-circle" aria-hidden="true"></i> CANCEL</button>
                            <button id="saveExpenseEdit" class="btn-pri pad-10 flex flex-centered">
                                <span class="loader-container" id="loaderContainerxxxe">
                                    <div class="loader" id="loader"></div>
                                </span>
                                <span id="buttonTextxxxe">SAVE EDITS</span>
                            </button>

                        </div>
                    </div>
                </flex-c>
            </div>
        </div>
        <script src="../assets/js/for_all.js"></script>
        <script src="../assets/js/ordered.js"></script>
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