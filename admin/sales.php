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

<body>
    <!-- Sidebar -->
    <?php include("includes/sidebar.php")  ?>

    <!-- Main Content -->
    <div id="main-content" class="shift pad-5 bg-pri">
        <!-- Button to open/close the sidebar -->
        <header class="fill flex-s-btn bg-w pad-10 rad-5 shadow-pri">
            <div class="flex flex-s-btn fill">
                <div class="flex">
                    <div id="sidebar-toggle" class=" flex"> <i class="fa fa-bars theme-text-c size-18" aria-hidden="true"></i></div>
                    <!-- Main content goes here -->
                    <h1 id="hTittle" class="theme-text disText">...</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="marg-t-10">
            <div class="fill flex-c flex-centered marg-t-5">
                <div class="sales_dashboard_wraper fill gap-10">
                    <div class="flex-c marg-l-5 gap-10">
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
                                <span id="month" class="fill flex flex-s-btn theme-text-c pad-3 w-500 pointer shadow-pri-inset">This Month  <span class="month" style="display: none;"><i class="fa fa-caret-right" aria-hidden="true"></i></span></span>
                                <span id="year" class="fill flex flex-s-btn theme-text-c pad-3 w-500 pointer shadow-pri-inset">This Year  <span class="year" style="display: none;"><i class="fa fa-caret-right" aria-hidden="true"></i></span></span>
                                <button id="goCustomized" class="btn-sec-o w-600 theme-text goCustomized">CUSTOMIZE<span class="cust" style="display: none;"><i class="fa fa-caret-right" aria-hidden="true"></i></span></button>
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
                                if(mysqli_num_rows(saleYears())>0){
                                    foreach(saleYears() as $yr){
                                        ?>
                                            <span onclick="yearCust('<?=  $yr['yr'] ?>')" id="yr_<?=  $yr['yr'] ?>" class="fill theme-text-c pad-3 w-500 pointer shadow-pri-inset"><?= $yr['yr'] ?></span>
                                        <?php
                                    }
                                }
                                ?>
                            </div>

                        </div>
                        <div class="marg-t-10 flex fill pad-5 bg-w shadow-pri rad-5">
                            <button id="compareNow" class="btn-sec-o fill pointer"><i class="fa fa-signal" aria-hidden="true"></i> COMPARE</button>
                        </div>
                    </div>
                    <div class="flex-c scroll-x gap-10 pad-r-5 pad-b-5">
                        <div class="grid-4 gap-10 fill ">
                            <div class="flex-c pad-10 rad-5 theme-text bg-w shadow-pri">
                                <div class="box-title fill flex w-600">
                                    TOTAL SALES
                                </div>
                                <div class="flex theme-text-c flex-s-btn fill" style="font-size:1.7rem">
                                    <div class="fifgure font-two" style="font-size:1.4rem">
                                        <?= number_format(totalSales()) ?>
                                    </div>
                                    <span class="fas fa-coins" aria-hidden="true"></span>
                                </div>
                                <div class="fill flex ">
                                    <span class="fill text-r theme-text-c">Sales Revenue</span>
                                </div>
                            </div>
                            <div class="flex-c pad-10 rad-5 bg-w theme-text shadow-pri">
                                <div class="box-title fill flex w-600">
                                    ITEMS SOLD
                                </div>
                                <div class="flex theme-text-c flex-s-btn fill" style="font-size:1.7rem">
                                    <div class="fifgure font-two" style="font-size:1.4rem">
                                        <?= itemSold();  ?>
                                    </div>
                                    <i class="fas fa-layer-group    "></i>
                                </div>
                                <div class="fill flex ">
                                    <span class="fill text-r theme-text-c">Units Sold</span>
                                </div>
                            </div>
                            <div class="flex-c pad-10 rad-5 bg-w theme-text shadow-pri">
                                <div class="box-title w-600 fill flex ">
                                    COGS
                                </div>
                                <div class="flex theme-text-c flex-s-btn fill" style="font-size:1.7rem">
                                    <div class="fifgure  font-two" style="font-size:1.4rem">
                                        <?= number_format(productCots()) ?>
                                    </div>
                                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                                </div>
                                <div class="fill flex ">
                                    <span class="fill text-r theme-text-c">Cost of goods Sold </span>
                                </div>
                            </div>
                            <div class="flex-c pad-10 rad-5 bg-w theme-text shadow-pri">
                                <div class="box-title w-600 fill flex ">
                                    EXPENSES
                                </div>
                                <div class="flex theme-text-c flex-s-btn  fill" style="font-size:1.7rem">
                                    <div class="fifgure font-two " style="font-size:1.4rem">
                                        <?= number_format(sum_xpenses())?>
                                    </div>
                                    <i class="fas fa-adjust    "></i>
                                </div>
                                <div class="fill flex ">
                                    <span class="fill text-r theme-text-c">Operational Costs</span>
                                </div>
                            </div>
                        </div>
                        <?php include("models/no_compare.php") ?>
                        
                    </div>
                    <div class="flex-c pad-5 pad-t-0 scroll-x">
                    <div class="flex-c pad-10 rad-5 bg-w theme-text shadow-pri">
                                <div class="box-title w-600 fill flex ">
                                    SALES PROFIT
                                </div>
                                <div class="flex theme-text-c flex-s-btn  fill" style="font-size:1.7rem">
                                    <div class="fifgure font-two " style="font-size:1.4rem">
                                        <?= profit()?>
                                    </div>
                                    <i class="fas fa-wallet    "></i>
                                </div>
                                <div class="fill flex ">
                                    <span class="fill text-r theme-text-c">Margin Made</span>
                                </div>
                            </div>
                        <div class="flex-c fill bg-w shadow-pri">
                            <div class="flex fill theme-bg">
                                <h3 class="fill  text-w text-c">SUMMERY</h3>
                            </div>
                            <div class="flex-c pad-10">
                                <div class="flex flex-s-btn normal-text">
                                    <span>Total Sales</span>
                                    <span><?= number_format(totalSales()) ?></span>
                                </div>
                                <div class="flex flex-s-btn normal-text">
                                    <span>COGS</span>
                                    <span><?= number_format(productCots()) ?></span>
                                </div>
                                <div class="flex flex-s-btn normal-text theme-border-b-1">
                                    <span>Expenses</span>
                                    <span><?= number_format(sum_xpenses()) ?></span>
                                </div>
                                <div class="flex flex-s-btn theme-text w-500">
                                    <span>Profit</span>
                                    <span><?= profit() ?></span>
                                </div>
                                <div class="flex flex-s-btn normal-text theme-border-b-1">
                                    <span>Outstanding</span>
                                    <span><?= number_format(ensurePositive(perOutstanding()) ) ?></span>
                                </div>
                                <div class="flex flex-s-btn theme-text w-500">
                                    <span>Cash at Hand</span>
                                    <span><?= number_format((int) ((int)str_replace(',', '', profit())) - ((int)ensurePositive(perOutstanding()))) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>

    <script src="../assets/js/sales.js"></script>
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
    </script>

        <?php
            if ( $_SESSION['season'] == 'today') {
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
            if ( $_SESSION['season'] == 'month') {
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
            if ( $_SESSION['season'] == 'customized') {
                ?>
                <script>
                $("#goCustomized").addClass('sesi');
                $(".cust").show();
                $("#hTittle").html("Insights from "+" <?= formatDate($_SESSION['start_date']) ?>"+" to "+"<?= $_SESSION['end_date'] ?>")
                </script>
                <?php
            }
            if ( $_SESSION['season'] == 'byYear') {
                ?>
                <script>
                $("#goCustomized").addClass('sesi');
                $(".byYear").show();
                $("#hTittle").html("Insights for "+" <?= formatDate($_SESSION['year']) ?>")
                </script>
                <?php
            }
        ?>

        
</body>

</html>