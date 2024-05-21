<div id="sidebar" class="open bg-w shadow-pri scroll-x m-hide">
    <nav id="sidebar-content">
        <!-- Sidebar content goes here -->
        <h2 class="flex siteHL pad-10 flex-centered fill "> <img src="../assets/img/logo.png" alt="Arusha Laptops">
            <!-- <div id="sidebar-togglex"><i class="fas fa-bars    "></i></div> -->
        </h2>
        <div class="flex-c">
            <a href="index" class="menu-item flex fill pad-10 btn-pri text-w"><i class="fas fa-layer-group "></i> Dashboard
            </a>
            <?php
            if ($_SESSION['welix_loged_in']['user_role'] == '1') {
            ?>
                <div class="flex-c  rad-5">
                    <div class="flex fill">
                        <a id="saleLink" class="openSubLinks menu-item flex flex-s-btn fill pad-10 btn-pri text-w size-18   " href="#"><span><i class="fas fa-coins    "></i> Sales</span> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    </div>
                    <div class="saleLink subLinks flex-c fill ">
                        <a class=" pad-5 btn-pri-o" href="sales">Statistic</a>
                        <a class=" pad-5 btn-pri-o" href="invoices">Invoices</a>
                        <a class=" pad-5 btn-pri-o" href="expenses">Expenses</a>
                        <a class=" pad-5 btn-pri-o" href="outstanding-invoices">Outstanding Invoices</a>
                        <!-- <a class="text-w" href="#">Transactions</a> -->
                    </div>
                </div>
            <?php
            }
            ?>



            <div class="flex-c  rad-5">
                <div class="flex fill">
                    <a id="stockLink" class="openSubLinks menu-item flex flex-s-btn fill pad-10 btn-pri text-w size-18" href="#"><span><i class="fa fa-boxes" aria-hidden="true"></i> Stock</span> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                </div>
                <div class="stockLink subLinks flex-c fill ">
                    <a href="products?category=All" class="menu-item flex pad-10 btn-pri-o "><i class="fa fa-list" aria-hidden="true"></i> Products
                    </a>
                    <a href="categories" class="menu-item flex pad-10 btn-pri-o "><i class="fa fa-sitemap" aria-hidden="true"></i> Categories
                    </a>
                    <a href="store" class="menu-item flex pad-10 btn-pri-o "><i class="fas fa-store    "></i> Store
                    </a>
                    <a href="ordered" class="menu-item flex pad-10 btn-pri-o "><i class="fa fa-object-group" aria-hidden="true"></i> Ordered
                    </a>
                    <a href="summation" class="menu-item flex pad-10 btn-pri-o "><i class="fa fa-list-alt" aria-hidden="true"></i> Summation
                    </a>
                </div>
            </div>
            <div class="flex-c  rad-5">
                <div class="flex fill">
                    <a id="custLink" class="openSubLinks menu-item flex flex-s-btn fill pad-10 btn-pri text-w size-18" href="#"><span><i class="fa fa-users" aria-hidden="true"></i> Customers</span> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                </div>
                <div class="custLink subLinks flex-c fill " >
                    <a class=" pad-5 btn-pri-o" href="all-customers">All</a>
                    <a class=" pad-5 btn-pri-o" href="outstanding-customers">Outstanding</a>
                    <!-- <a class="text-w" href="#">Transactions</a> -->
                </div>
            </div>
            <a href="setting" class="menu-item flex pad-10 btn-pri text-w"><i class="fa fa-cog" aria-hidden="true"></i>Settings
            </a>
        </div>
    </nav>
</div>