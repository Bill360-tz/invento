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

<body class="bg-pri m-bg-w">
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
                    <h1 class="theme-text disText">Home</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="flex-c fill marg-t-10">
            <div class="flex-c  bg-w fill" style="min-height: 87vh;">
                <div class="grid-3qe fill m-flex">
                    <div class="flex-c pad-10 rad-5 gap-10 fill m-pad-5">
                        <a href="sale" id="makeSale" class="bg-pri text-w anchor">
                            [ SALE ]
                        </a>
                        <div class="flex-c pad-20 rad-5 bg-w shadow-sec">
                            <h3 class="theme-text theme-border-b-2">Total Product</h3>
                            <h1 class="fill w-500 theme-text-c font-four"><?= countAllItems() ?></h1>
                            <a href="products?category=All" class="btn-pri">View <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                        <div class="flex-c pad-20 rad-5 bg-w shadow-sec">
                            <h3 class="theme-text theme-border-b-2">Re-Orders</h3>
                            <h1 class="fill w-500 theme-text-c font-four"><?= countReorders() ?></h1>
                            <a href="products?category=reorder" class="btn-pri">View <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                        <div class="flex-c pad-20 rad-5 bg-w shadow-sec">
                            <h3 class="theme-text theme-border-b-2">Out of Stock</h3>
                            <h1 class="fill w-500 theme-text-c font-four"><?= fetchOutOfStock() ?></h1>
                            <a href="products?category=outOfStock" class="btn-pri">View <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="flex-c fill gap-10 pad-10 m-pad-5">
                        <div class="flex-c pad-10 fill bg-w rad-5 shadow-sec">
                            <div class="flex flex-s-btn fill pad-5 theme-border-b-2">
                                <h3 class="theme-text">Today's Sales</h3>
                                <div class="flex">
                                    <a href="invoices" class="btn-pri-o">See All <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </div>

                            </div>
                            <div class="flex-c fill pad-5">
                                <?php
                                if (mysqli_num_rows(dashSales()) > 0) {
                                ?>
                                    <table>
                                        <thead class="pad-5">
                                            <tr>
                                                <th class="theme-text text-l">Invoice</th>
                                                <th class="theme-text text-l">Total Price</th>
                                                <th class="theme-text text-l m-hide">Discount</th>
                                                <th class="theme-text text-l">AmountDue</th>
                                                <th class="theme-text text-l ">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach (dashSales() as $dashSale) {
                                            ?>
                                                <tr>
                                                    <td class="pad-5"><?= $dashSale['invoice_no'] ?></td>
                                                    <td class="pad-5"><?= number_format($dashSale['total_price']) ?></td>
                                                    <td class="pad-5 m-hide"><?= number_format( $dashSale['discount']) ?></td>
                                                    <td class="pad-5"><?= number_format($dashSale['amount_due']) ?></td>
                                                    <td class="pad-5"> <a href="invo" class="btn-pri-o "> info </a> </td>
                                                </tr>
                                        <?php
                                            }
                                        }else{
                                            echo "No Sales Made Today";
                                        }
                                        ?>
                                        </tbody>
                                    </table>

                            </div>
                        </div>
                        <div class="flex-c fill pad-10 bg-w rad-5 shadow-sec">
                            <flex class="flex pad-5 flex-s-btn theme-border-b-2">
                                <h3 class="theme-text">Today's Expenses</h3>
                                <div class="flex">
                                    <a href="expenses" class="btn-pri-o">See All <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </div>
                            </flex>
                            <div class="flex-c fill pad-5">
                                <?php
                                if (mysqli_num_rows(dashExpenses()) > 0) {

                                ?>
                                    <table>
                                        <thead class="pad-5">
                                            <tr>
                                                <th class="theme-text text-l">Expense Name</th>
                                                <th class="theme-text text-l">Expense Amount</th>
                                                <th class="theme-text text-l">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach (dashExpenses() as $dashExpenses) {
                                            ?>
                                            <tr>
                                                <td class="pad-5"><?= $dashExpenses['ex_name'] ?></td>
                                                <td class="pad-5"><?= number_format($dashExpenses['ex_amount']) ?></td>
                                                <td class="pad-5"><a href="exp" class="btn-pri-o">info</a></td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php
                                }else{
                                    echo "No Expenses encountered today";
                                }
                                ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
    <!-- <script src="../assets/js/sales_operation.js"></script> -->
    <script src="../assets/js/for_all.js"></script>
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