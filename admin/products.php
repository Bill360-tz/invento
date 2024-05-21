<?php
session_start();
if (!isset($_SESSION['welix_loged_in'])) {
    header("location: login");
}
if (!isset($_GET['category']) || $_GET['category'] == "") {
    $category = "All";
} else {
    $category = htmlspecialchars_decode($_GET['category']);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("includes/head.php")  ?>
<?php include("functions/functions.php")  ?>
<?php

?>

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
                    <h1 class="theme-text disText"><?php
                                                    if ($category == "reorder") {
                                                        echo "Re-order";
                                                    } else if ($category == "outOfStock") {
                                                        echo "Out of Stock";
                                                    } else {
                                                        echo $category;
                                                    }
                                                    ?> Products</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="fill pad-10 marg-t-10 bg-w" style="min-height: 87vh;">
            <div class="flex-c fill flex-centered">
                <div class="flex-c fill ">
                    <div class="flex-c fill flex-centered">
                        <div class="flex flex-centered fill pad-10">
                            <div class="grid-4 gap-10 fill">

                                <div class="flex-c pad-20 rad-5 bg-w shadow-sec">
                                    <h3 class="theme-text theme-border-b-2">Total Product</h3>
                                    <h1 class="fill w-500 theme-text-c font-four"><?= number_format(countAllItems()) ?></h1>
                                    <a href="products?category=All" class="btn-pri flex-centered">View <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </div>
                                <div class="flex-c pad-20 rad-5 bg-w shadow-sec">
                                    <h3 class="theme-text theme-border-b-2">Re-Orders</h3>
                                    <h1 class="fill w-500 theme-text-c font-four"><?= countReorders() ?></h1>
                                    <a href="products?category=reorder" class="btn-pri flex flex-centered">View <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </div>
                                <div class="flex-c pad-20 rad-5 bg-w shadow-sec">
                                    <h3 class="theme-text theme-border-b-2">Out of Stock</h3>
                                    <h1 class="fill w-500 theme-text-c font-four"><?= number_format(fetchOutOfStock()) ?></h1>
                                    <a href="products?category=outOfStock" class="btn-pri flex flex-centered">View <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                </div>
                                <div class="flex-c pad-20 rad-5 bg-w shadow-sec">
                                    <h3 class="theme-text theme-border-b-2">Stock Cost</h3>
                                    <h1 class="fill w-500 theme-text-c font-four" style="display: none;"><?= number_format(stockWorth()) ?></h1>
                                    <input id="stoPass" type="password" class="input-s fill pad-5" placeholder="Type your Password">
                                    <button id="toggleStockValue" class="btn-pri-o flex flex-centered">View <i class="fa fa-eye" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="flex-c fill shadow-sec bg-w rad-3 marg-5">
                            <div class="flex flex-s-btn fill pad-5 theme-border-b-2">

                                <div class="flex">
                                    <select class="input-s pad-5" id="itemCatFilter">
                                        <option value="<?= $category ?>"><?php
                                                                            if ($category == 'reorder') {
                                                                                echo "Re-Order";
                                                                            } elseif ($category == 'outOfStock') {
                                                                                echo "Out of Stock";
                                                                            } else {
                                                                                echo $category;
                                                                            }
                                                                            ?></option>
                                        <option value="All">All</option>
                                        <option value="reorder">Re-Order</option>
                                        <option value="outOfStock">Out of Stock</option>
                                        <?php
                                        foreach (fetchCats() as $cat) {
                                        ?>
                                            <option value="<?= $cat['cat_name'] ?>"><?= $cat['cat_name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="flex">
                                    <a href="categories" class="btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Add Item</a>
                                </div>
                            </div>
                            <?php
                            if ($category != 'reorder') {
                            ?>
                                <div class="flex-c fill">
                                    <table id="itemsTable">
                                        <thead class="theme-text">
                                            <tr>
                                                <th class="text-l">Item Name</th>
                                                <th class="text-l">Category</th>
                                                <th class="text-l">Cost</th>
                                                <th class="text-l">Price</th>
                                                <th class="text-l">Quantity</th>
                                                <th class="text-l">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (fetchItem($category) != '0') {
                                                foreach (fetchItem($category) as $item) {
                                            ?>

                                                    <tr>
                                                        <td><?= $item['item_name'] ?></td>
                                                        <td><?= $item['cat_name'] ?></td>
                                                        <td><?= number_format($item['item_cost']) ?></td>
                                                        <td><?= number_format($item['item_price']) ?></td>
                                                        <td><?= number_format($item['item_quantity']) ?></td>

                                                        <td>
                                                            <button onclick="addItem('<?= $item['item_id'] ?>','<?= $item['item_name'] ?>')" class="btn-pri-o "><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                            <button title="Delete Item" onclick="deleteItem('<?= $item['item_id'] ?>','<?= $item['item_name'] ?>')" class="btn-pri-o"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                            <button title="Item Information" onclick="showInfo('<?= $item['item_name'] ?>','<?= $item['item_des'] ?>','<?= $item['item_cost'] ?>','<?= $item['item_price'] ?>','<?= $item['item_quantity'] ?>')" class="btn-pri-o"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="grid-2 gap-10 fill pd-10">
                                    <div class="flex-c pad-10">
                                        <div class="flex fill pad-5 normal-border-b-1">
                                            <h3 class="normal-text">Categories and Brands to re-order</h3>
                                        </div>
                                        <div class="flex-c fill pad-5">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-l normal-text">Brand Name</th>
                                                        <th class="text-l normal-text">Re-order Point</th>
                                                        <th class="text-l normal-text">Items Left</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (mysqli_num_rows(getReorders()) > 0) {
                                                        foreach (getReorders() as $brandI) {
                                                            $limit = $brandI['re_order'];
                                                            $brand_id = $brandI['brand_id'];

                                                            $sql3 = "SELECT SUM(item_quantity) as quantSum FROM items where brand_id = '$brand_id' and items.delete_status ='no'";

                                                            $query3 = mysqli_query(conn(), $sql3);

                                                            if (!$query3) {
                                                                echo mysqli_error(conn());
                                                            } else {
                                                                if (mysqli_num_rows($query3) > 0) {
                                                                    $hhh = mysqli_fetch_assoc($query3);

                                                                    if ((int) $hhh['quantSum'] <= (int)$limit) {
                                                    ?>
                                                                        <tr>
                                                                            <td><?= $brandI['brand_name'] ?></td>
                                                                            <td><?= $brandI['re_order'] ?></td>
                                                                            <td><?= $hhh['quantSum'] ?></td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }

                                                    if (mysqli_num_rows(subReoder()) > 0) {
                                                        foreach (subReoder() as $reSub) {
                                                            $sub_limit = $reSub['reorder_point'];
                                                            $sub_id = $reSub['item_id'];

                                                            $sql4 = "SELECT SUM(item_quantity) as quantSuB FROM items where 	sub_item_of = '$sub_id' and items.delete_status ='no'";

                                                            $query4 = mysqli_query(conn(), $sql4);

                                                            if (!$query4) {
                                                                echo mysqli_error(conn());
                                                            } else {
                                                                if (mysqli_num_rows($query4) > 0) {
                                                                    $res = mysqli_fetch_assoc($query4);

                                                                    if ((int) $res['quantSuB'] <= (int) $sub_limi) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?= $reSub['item_name'] ?></td>
                                                                            <td><?= $reSub['reorder_point'] ?></td>
                                                                            <td><?= $res['quantSuB'] ?></td>
                                                                        </tr>
                                                    <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="flex-c pad-10">
                                        <div class="flex fill pad-5 normal-border-b-1">
                                            <h3 class="normal-text">Items To Re-Order</h3>
                                        </div>
                                        <div class="flex-c fill pad-5">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="normal-text text-l">Item Name</th>
                                                        <th class="normal-text text-l">Re-order Point</th>
                                                        <th class="normal-text text-l">Items Left</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (mysqli_num_rows(reOrderItem()) > 0) {
                                                        foreach (reOrderItem() as $itemRe) {
                                                    ?>
                                                            <tr>
                                                                <td><?= $itemRe['item_name'] ?></td>
                                                                <td><?= $itemRe['reorder_point'] ?></td>
                                                                <td><?= $itemRe['item_quantity'] ?></td>
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
                            <?php
                            }
                            ?>




                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
    <!-- add items model -->
    <div class="add_item_model fill flex-c" style="display: none;">
        <div class="inner_add_item_model width-50 fle-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text"><i class="fas fa-edit    "></i> Edit the Item <span id="itemAddName"></span></h3>
                <button id="clossAddItemModel" class="clossAddItemModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex-c">
                    <input type="hidden" id="itemIdToEdit">
                    <div class="flex-c fill">
                        <label for="itemName" class="fill">Item Name</label>
                        <input type="text" id="itemName" class="input-s fill pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="itemDes" class="fill">Item Discription</label>
                        <textarea id="itemDes" cols="30" rows="5" class="input-s fill pad-5"></textarea>
                    </div>
                    <div class="flex-c fill">
                        <label for="itemUnit" class="fill">Item Unity</label>
                        <input type="text" id="itemUnit" class="input-s fill pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="itemCost" class="fill">Item Cost</label>
                        <input type="number" id="itemCost" class="input-s fill pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="itemPrice" class="fill">Item Price</label>
                        <input type="number" id="itemPrice" class="input-s fill pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="itemQuantity" class="fill">Item Quantity</label>
                        <input type="number" id="itemQuantity" class="input-s fill pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="reorderPoint" class="fill">Re-order Level</label>
                        <input type="number" id="reorderPoint" class="input-s fill pad-5">
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="addItemToCat" class="btn-pri pad-10">UPDATE ITEM</button>
                        <button class="clossAddItemModel btn-sec pad-10">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- add to item model -->
    <div class="add_to_item_model fill flex-c" style="display:none">
        <div class="inner_add_to_item_model width-50 flex-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text"><i class="fas fa-calendar-plus    "></i> Add Item to <span id="nameOfItemToAdd"></span></h3>
                <button id="clossaddItemModel" class="clossaddItemModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex-c">
                    <input type="hidden" id="itemToAddId">
                    <div class="grid-2 fill">
                        <label for="amountToAdd"> Amount To Add</label>
                        <input class="input-s pad-5" type="number" id="amountToAdd">
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button class="clossaddItemModel btn-sec pad-10">CANCEL</button>
                        <button id="saveAddItem" class="btn-pri pad-10 flex flex-centered">
                        <span class="loader-container" id="loaderContainerxxx">
                                    <div class="loader" id="loader"></div>
                                </span>
                                <span id="buttonTextxxx">SAVE</span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="outer_model deleteItemModel fill" style="display: none;">
        <div class="inner_model width-40 bg-w   pad-10">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text">Delete the Item <span id="deletedNam"></span> </h3>
                <button id="clossdeleteItemModel" class="clossdeleteItemModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex">
                    <input type="hidden" id="deleteItemHidden">
                    <div class="flex fill">
                        <i style="font-size: 3.5rem;color:red" class="fa fa-trash-alt" aria-hidden="true"></i>
                        <p>You are about to delete this item from your stock.</p>
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="deleteItemConfirm" class="btn-pri pad-10">DELETE</button>
                        <button class="clossdeleteItemModel btn-sec pad-10">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="outer_model itemDescrip fill" style="display: none;">
        <div class="inner_model width-50 shadow-pri pad-10 rad-5">
            <div class="flex fill flex-s-btn pad-5 theme-border-b-1">
                <h3 class="theme-text">Product Information</h3>
                <div class="flex">
                    <button class="btn-pri-o closeDescr"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="flex-c fill">
                <h3 class=" itemName">Itema Name</h3>
                <p class="normal-text itemDescr">Item Description</p>
                <p class="normal-text "><b>Unit Cost: </b><span class="unitCost"></span></p>
                <p class="normal-text "><b>Unit Price: </b><span class="unitPrice"></span></p>
                <p class="normal-text "><b>Items in Store: </b><span class="storeCount"></span></p>

            </div>
            <div class="flex pad-10 flex-centered">
                <button class="btn-pri closeDescr">OK</button>
            </div>
        </div>

    </div>

    <script src="../assets/js/products.js"></script>
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