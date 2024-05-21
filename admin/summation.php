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
                    <div id="sidebar-toggle" class=" flex"> <i class="fa fa-bars theme-text size-18" aria-hidden="true"></i></div>
                    <!-- Main content goes here -->
                    <h1 class="theme-text disText">Heading</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="marg-t-10 fill">
            <div class="flex flex-c fill justify-center bg-w pad-20 h-90vh">
                <div class="width-60 bg-w pad-5 shadow-pri">
                    <div class="flex fill theme-border-b-2 pad-5">
                        <h3 class="theme-text disText">Your Stock Summery</h3>
                    </div>
                    <div class="flex-c fill pad-5">
                        <table class="fill" id="f">
                            <thead>
                                <tr>
                                    <th class="theme-text  text-l">Item</th>
                                    <th class="theme-text  text-l">Figure</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr >
                                    <td class="pad-7">Shelf Products</td>
                                    <td><?= number_format(stockWorth()) ?></td>
                                    <td><a href="" class="btn-pri-o">View</a></td>
                                </tr>
                                <tr class="">
                                    <td class="pad-7">Store Products</td>
                                    <td><?= number_format(sumStore())  ?></td>
                                    <td><a href="" class="btn-pri-o">View</a></td>
                                </tr>
                                <tr class="">
                                    <td class="pad-7">Ordered Products</td>
                                    <td><?= number_format(sumOrdered()) ?></td>
                                    <td><a href="" class="btn-pri-o">View</a></td>
                                </tr>
                                <tr>
                                    <td class="pad-6 w-600 disText normal-text">TOTAL</td>
                                    <td class="pad-6 w-600 disText normal-text"><?= number_format(stockWorth() + sumOrdered() + sumStore())." Tshs." ?></td>
                                    <td></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        
    </div>


    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/summation.js"></script>
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