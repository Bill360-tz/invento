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
                    <div id="sidebar-toggle" class=" flex"> <i class="fa fa-bars theme-text-c size-18" aria-hidden="true"></i></div>
                    <!-- Main content goes here -->
                    <h1 class="theme-text disText">Sales</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="marg-t-10 flex-c fill ">
            <div class="sales_dashboard_wraperx fill bg-w pad-10" style="min-height: 87vh;">
                <div class="flex-c gap-10 fill">
                    <a href="sale" id="makeSale" class="bg-pri text-w anchor">
                        [ SALE ]
                    </a>
                    <div class="filter-box flex-c rad-3 bg-white shadow-pri">
                        <div class="flex fill pad-3 theme-bg">
                            <span class="box-title text-c fill text-w w-600">FILTER</span>
                        </div>
                        <div id="simpleSelectors" class="box-selection gap-3  pad-5 flex-c fill">
                            <span id="today" class="fill flex flex-s-btn theme-text-c pad-3 w-500 pointer shadow-pri-inset">Today <span class="today" style="display: none;"><i class="fa fa-caret-right" aria-hidden="true"></i></span></span>
                            <span id="weak" class="fill flex flex-s-btn theme-text-c pad-3 w-500 pointer shadow-pri-inset">This Week <span class="weak" style="display: none;"><i class="fa fa-caret-right" aria-hidden="true"></i></span></span>
                            <span id="month" class="fill flex flex-s-btn theme-text-c pad-3 w-500 pointer shadow-pri-inset">This Month <span class="month" style="display: none;"><i class="fa fa-caret-right" aria-hidden="true"></i></span></span>
                            <span id="year" class="fill flex flex-s-btn theme-text-c pad-3 w-500 pointer shadow-pri-inset">This Year <span class="year" style="display: none;"><i class="fa fa-caret-right" aria-hidden="true"></i></span></span>
                            <button id="goCustomized" class="btn-sec-o w-600 theme-text">CUSTOMIZE</button>
                        </div>
                        <div id="dateFilter" class="flex-c fill scale-s pad-5" style="display: none;">
                            <label for="p_start" class="fill theme-text">Start Date</label>
                            <input id="p_start" type="date" class="input-s pad-5 theme-text">
                            <label for="p_end" class="fill theme-text">End Date</label>
                            <input id="p_end" type="date" class="input-s pad-5 theme-text">
                            <div class="grid-3qe ">
                                <button id="backToSimple" title="Back" class="btn-sec"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button>
                                <button id="getCust" class="btn-pri">FILTER</button>
                            </div>
                        </div>

                    </div>
                    <div class="filter-box flex-c rad-3 bg-white shadow-pri">
                        <div class="flex fill pad-3 theme-bg">
                            <span class="box-title text-c fill text-w w-600">YEAR</span>
                        </div>
                        <div id="simpleSelectors" class="box-selection gap-3  pad-5 flex-c fill">
                            <?php
                            if (mysqli_num_rows(saleYears()) > 0) {
                                foreach (saleYears() as $yr) {
                            ?>
                                    <span onclick="yearCust('<?= $yr['yr'] ?>')" id="yr_<?= $yr['yr'] ?>" class="fill theme-text-c pad-3 w-500 pointer shadow-pri-inset"><?= $yr['yr'] ?></span>
                            <?php
                                }
                            }
                            ?>
                        </div>

                    </div>

                </div>
                <div class="flex-c fill pad-10 bg-w shadow-sec scroll-x rad-5">

                    <div class="flex fill pad-5 flex-s-btn theme-border-b-1">
                        <h3 class="disText">Sold Items</h3>
                    </div>
                    <div class="flex-c fill pad-5 rad-5">
                        <table id="allSalesRev" class="marg-t-5">
                            <thead class=" text-l fill theme-text w-500">
                                <tr>
                                    <th class="text-l ">Product Name</th>
                                    <th class="text-l ">Cost</th>
                                    <th class="text-l ">Price</th>
                                    <th class="text-l ">Items Count</th>
                                    <th class="text-l ">Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows(allSalesRev()) > 0) {
                                    foreach (allSalesRev() as $salRev) {
                                ?>
                                        <tr>
                                            <td><?= $salRev['item_name'] ?></td>
                                            <td><?= number_format($salRev['item_cost']) ?></td>
                                            <td><?= number_format($salRev['item_price']) ?></td>
                                            <td><?= number_format(saleCount($salRev['item_id'])['counts']) ?></td>
                                            <td><?= number_format($salRev['frequency']) ?></td>
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
        </main>

    </div>


    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/all-sales.js"></script>
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
    <?php
    if ($_SESSION['season'] == 'today') {
    ?>
        <script>
            $("#today").addClass('sesi');
            $(".today").show();
            $("#hTittle").html("Today's Insights")
        </script>
    <?php
    }
    if ($_SESSION['season'] == 'weak') {
    ?>
        <script>
            $("#weak").addClass('sesi');
            $(".weak").show();
            $("#hTittle").html("This Week Insights")
        </script>
    <?php
    }
    if ($_SESSION['season'] == 'month') {
    ?>
        <script>
            $("#month").addClass('sesi');
            $(".month").show();
            $("#hTittle").html("This Month Insights")
        </script>
    <?php
    }
    if ($_SESSION['season'] == 'year') {
    ?>
        <script>
            $("#year").addClass('sesi');
            $(".year").show();
            $("#hTittle").html("This Year Insights")
        </script>
    <?php
    }
    if ($_SESSION['season'] == 'customized') {
    ?>
        <script>
            $("#goCustomized").addClass('sesi');
            $(".cust").show();
            $("#hTittle").html("Insights from " + " <?= formatDate($_SESSION['start_date']) ?>" + " to " + "<?= $_SESSION['end_date'] ?>")
        </script>
    <?php
    }
    if ($_SESSION['season'] == 'byYear') {
    ?>
        <script>
            $("#goCustomized").addClass('sesi');
            $(".byYear").show();
            $("#hTittle").html("Insights for " + " <?= formatDate($_SESSION['year']) ?>")
        </script>
    <?php
    }
    ?>

</body>

</html>