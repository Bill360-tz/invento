<?php
session_start();
if (!isset($_SESSION['welix_loged_in'])) {
    header("location: login");
}

if (!isset($_GET['cat']) || $_GET['cat'] == "") {
    echo "<script>document.location = categories</script>";
} else {
    $cat_id = $_GET['cat'];
}

if (!isset($_GET['brand']) || $_GET['brand'] == "") {
    $brand = "All";
} else {
    $brand = $_GET['brand'];
}
if (!isset($_GET['sub']) || $_GET['sub'] == "") {
    $sub = "All";
} else {
    $sub = $_GET['sub'];
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
                    <h1 class="theme-text disText"><?= oneCat($cat_id, $brand)['cat_name'] ?></h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="marg-t-5">
            <input type="hidden" id="cat_id" value="<?= $cat_id ?>">
            <div class="grid-3qe gap-10 pad-10 fill bg-w">
                <div class="flex-c  rad-3 shadow-sec">
                    <div class="flex pad-10 fill flex-s-btn theme-border-b-2 ">
                        <h3 class="theme-text"> <i class="fas fa-boxes    "></i> Brands & Sub-Categories</h3>
                        <div class="flex">
                            <button id="cancelAddBrand" class="btn-pri-o" style="display: none;"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                            <button id="trigAddBrand" class="btn-pri-o"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div id="addBrandDiv" class="flex-c  fill flex-centered pad-3 gradient_1" style="display: none;">
                        <div class="flex-c fill">
                            <label for="brandName" class="normal-text">Brand/Sub-category Name</label>
                            <input id="brandInput" type="text" placeholder="Type Brand/Sub-Cat Name" class="input-s pad-5 fill">
                        </div>
                        <div class="flex-c fill">
                            <div class="flex fill">
                                <label for="re_orderSet" class="normal-text">Has Re-order Point</label>
                                <label for="no_reorder" class="theme-text-c">
                                    <input type="radio" checked value="no" name="reorder_set" id="no_reorder"> No
                                </label>
                                <label for="yes_reorder" class="theme-text-c">
                                    <input type="radio" value="yes" name="reorder_set" id="yes_reorder"> Yes
                                </label>
                            </div>
                            <div class="flex-c flex-centered fill">
                                <div id="reOrderInpuDiv" class="flex fill" style="display: none;">
                                    <input id="reOrderP" type="number" placeholder="Set re-order point" class="input-s pad-5 fill">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-centered fill pad-3" id="addBrand">
                            <button id="saveBrand" class="btn-pri-o fill bg-w"><i class="fas fa-save    "></i> SAVE</button>
                        </div>
                    </div>
                    <div id="EditBrandDiv" class="flex-c  fill flex-centered pad-3 gradient_1" style="display: none;">
                        <div class="flex flex-s-btn fill">
                            <label for="brandNameEdit" class="normal-text">Edit Brand/Sub-category Name</label>
                            <button id="cancelBrandEdit" title="Cancel" class="btn-pri-o no-border pad-0"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                        </div>
                        <div class="flex-c fill">
                            <input id="brandNameEdit" type="text" placeholder="Type Brand/Sub-Cat Name" class="input-s pad-5 fill">
                            <input type="hidden" id="brand_id_hidden">
                            <div class="flex-c flex-centered fill">
                                <label for="reOrderPEdit" class="normal-text fill">Re-Order Point</label>
                                <div id="reOrderInpuDiv" class="flex fill">
                                    <input id="reOrderPEdit" type="number" placeholder="Set re-order point" class="input-s pad-5 fill">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-centered fill pad-3" id="saveBrandEdit">
                            <button id="saveBrandEdits" class="btn-pri-o fill bg-w"><i class="fas fa-save    "></i> SAVE</button>
                        </div>
                    </div>
                    <div class="flex-c pad-10 fill ">
                        <div class="flex fill gradient_1 pad-3">
                            <a href="cat-info?cat=<?= $cat_id ?>&brand=All" class="flex normal-text anchor pointer hover-pri  width-80 ">
                                In All Brands & Categoris
                            </a>
                            <div class="flex">
                                <a href="cat-info?cat=<?= $cat_id ?>&brand=All" class="btn btn-pri-o pad-3" style="font-size: 14px;"> View</a>
                            </div>
                        </div>


                        <?php
                        if (mysqli_num_rows(brands($cat_id)) > 0) {

                            foreach (brands($cat_id) as $brandInfo) {

                        ?>
                                <div class="flex fill gradient_1 pad-3">
                                    <a href="cat-info?cat=<?= $brandInfo['cat_id'] ?>&brand=<?= $brandInfo['brand_id'] ?>" class="flex normal-text anchor pointer hover-pri  width-80">
                                        <h3 class=" width-80 w-500 hover-pri"><?= $brandInfo['brand_name'] ?></h3>
                                        <h3 class=" w-500 flex  hover-pri"><?= $brandInfo['re_order'] ?></h3>
                                    </a>

                                    <div class="flex">
                                        <button onclick="editBrand('<?= $brandInfo['brand_id'] ?>', '<?= $brandInfo['brand_name'] ?>', '<?= $brandInfo['re_order'] ?>')" class="btn-pri-o no-border pad-0" style="font-size: 14px;"><i class="fas fa-edit"></i></button>
                                        <button title="Click to delete" id="deleBra_<?= $brandInfo['brand_id']  ?>" onclick="deleteBrand('<?= $brandInfo['brand_id'] ?>', '<?= $brandInfo['brand_name'] ?>')" class="btn-pri-o no-border pad-0 deleteBtn"><i class="fa fa-trash" aria-hidden="true"></i></button>

                                    </div>
                                </div>
                            <?php
                            }
                        }
                        if (mysqli_num_rows(catsInItems($cat_id)) > 0) {

                            foreach (catsInItems($cat_id) as $catsInItems) {

                            ?>
                                <div class="flex fill gradient_1 pad-3">
                                    <a href="cat-info?cat=<?= $cat_id ?>&brand=<?= $brand ?>&sub=<?= $catsInItems['item_id'] ?>" class="flex normal-text anchor pointer hover-pri  width-80">
                                        <h3 class=" width-80 w-500 hover-pri"><?= $catsInItems['item_name'] ?></h3>
                                        <h3 class=" w-500 flex  hover-pri"><?php if ($catsInItems['reorder_point'] == '0') {
                                                                                echo "--";
                                                                            } else {
                                                                                echo $catsInItems['reorder_point'];
                                                                            } ?></h3>
                                    </a>

                                    <div class="flex">
                                        <button class="btn-pri-o no-border pad-0" style="font-size: 14px;"><i class="fas fa-edit"></i></button>
                                        <button title="Click to delete" style="color:maroon" id="deleBra_<?= $catsInItems['item_id']  ?>" onclick="deleteCatItem('<?= $catsInItems['item_id'] ?>', '<?= $catsInItems['item_name'] ?>')" class="btn-pri-o no-border pad-0 deleteBtn"><i class="fa fa-trash" aria-hidden="true"></i></button>

                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="flex-c fill rad-5 shadow-sec">
                    <div class="flex gradient_2 fill pad-10 flex-s-btn theme-border-b-2">
                        <div class="flex">
                            <h3 class="theme-text"><i class="fas fa-layer-group    "></i> Items in
                                <?php
                                if ($brand == "All") {
                                    echo oneCat($cat_id, $brand)['cat_name'];
                                } else {
                                    echo oneBrands($brand)['brand_name'];
                                }

                                ?>
                            </h3> <span class="theme-text w-600 ">
                                <div class="flex" id="hgh"></div>
                        </div>
                        <div class="flex">
                            <button id="addItemModelOp" class="btn-pri-o"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="flex-c fill pad-10 scroll-x" style="height: 78vh;">
                        <table class="table fill" id="brandItemTable">
                            <thead class="">
                                <tr>
                                    <th class="theme-text-c text-l font-two">Item Name</th>
                                    <th class="theme-text-c text-l font-two">Item Count</th>
                                    <th class="theme-text-c text-l font-two">Item Cost</th>
                                    <th class="theme-text-c text-l font-two">Item Price</th>
                                    <th class="theme-text-c text-l font-two">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows(itemsPerBranda($cat_id, $brand, $sub)) > 0) {
                                    $itemCount = 0;
                                    $totalCost = 0;
                                    foreach (itemsPerBranda($cat_id, $brand, $sub) as $ItemPB) {

                                ?>
                                        <tr>
                                            <td><?= $ItemPB['item_name'] ?></td class="w-600">
                                            <td><?= number_format($ItemPB['item_quantity']) ?></td>
                                            <td><?= number_format($ItemPB['item_cost']) ?></td>
                                            <td><?= number_format($ItemPB['item_price']) ?></td>
                                            <td class="w-600">
                                                <button onclick="editItem(`<?= $ItemPB['item_id'] ?>`,`<?= $ItemPB['item_name'] ?>`,`<?= $ItemPB['item_des'] ?>`,`<?= $ItemPB['item_unit'] ?>`,`<?= $ItemPB['item_cost'] ?>`,`<?= $ItemPB['item_price'] ?>`,`<?= $ItemPB['item_quantity'] ?>`,`<?= $ItemPB['reorder_point'] ?>`)" title="Edit Item" class="btn-pri-o  no-border pad-0"><i class="fas fa-edit    "></i></button>
                                                <button title="Delete Item" onclick="deleteItem('<?= $ItemPB['item_id'] ?>', '<?= $ItemPB['item_name'] ?>')" class="btn-pri-o no-border pad-0 deleteBtn"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                <button onclick="addItem('<?= $ItemPB['item_id'] ?>','<?= $ItemPB['item_name'] ?>')" title="Add Item" class="btn-pri-o no-border pad-0"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                <?php
                                        $itemCount += (1 * $ItemPB['item_quantity']);
                                        $totalCost += ($ItemPB['item_cost'] * $ItemPB['item_quantity']);
                                    }


                                    echo '<script>
                                document.getElementById("hgh").innerHTML= `|</span>
                                <span class="normal-text font-two ">Total Items: <Span class="font-two">' . number_format($itemCount) . '</Span></span> <span class="theme-text w-600">|</span>
                                <span class="normal-text font-two">Total Worth: <Span class="font-two">' . number_format($totalCost) . '</Span></span>`
                                </script>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Add ItemModel -->
    <div class="add_item_model fill flex-c" style="display: none;">
        <div class="inner_add_item_model width-50 fle-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text">Add Item to <span id="itemAddCatName"><?= oneCat($cat_id, $brand)['cat_name'] ?></span></h3>
                <button id="clossAddItemModel" class="clossAddItemModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10 scroll-x" style=" max-height: 87vh;">
                <form action="#" class="fill flex-c">
                    <div class="flex-c fill">
                        <label for="itemName" class="fill">Item Name</label>
                        <input type="text" id="itemName" class="input-s fill pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="itemCategory" class="fill">Item Category</label>
                        <input type="hidden" value="<?= oneCat($cat_id, $brand)['cat_id'] ?>" id="catIdToAdd">
                        <input type="text" value="<?= oneCat($cat_id, $brand)['cat_name'] ?>" readonly id="itemCategory" class="input-s fill pad-5 grey">
                    </div>
                    <div class="flex-c fill">
                        <label for="itemName" class="fill">Item Brand & Sub Category</label>
                        <?php

                        if ($brand == "All") {
                        ?>
                            <input type="hidden" id="ItemBrand" name="newItemBrand" value="0">
                            <input type="text" readonly id="itemName" value="None" class="input-s fill pad-5 grey">
                        <?php
                        } else {
                        ?>
                            <input type="hidden" id="ItemBrand" name="newItemBrand" value="<?= $brand ?>">
                            <input type="text" readonly id="itemName" value="<?= oneBrands($brand)['brand_name'] ?>" class="input-s fill pad-5 grey">
                        <?php
                        }
                        ?>

                    </div>
                    <div class="flex-c fill">
                        <label for="itemDes" class="fill">Item Discription</label>
                        <textarea id="itemDes" cols="30" rows="5" class="input-s fill pad-5"></textarea>
                    </div>
                    <div class="flex-c fill">
                        <label for="subItemOf" class="fill">Sub-item Of</label>
                        <select id="subItemOf" class="input-s fill pad-5">
                            <option value="none">None</option>
                            <?php
                            if (mysqli_num_rows(itemsPerBrandaToSubs($cat_id, $brand, $sub))) {
                                foreach (itemsPerBrandaToSubs($cat_id, $brand, $sub) as $itemOfSub) {


                            ?>
                                    <option value="<?= $itemOfSub['item_id'] ?>"><?= $itemOfSub['item_name'] ?></option>

                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="flex fill">
                        <span class="normal-text">Has Sub-Items</span>
                        <div class="flex">
                            <label for="yesSub" class="theme-text-c"><input type="radio" value="hasSubs" name="hasSubs" id="yesSub">Yes</label>
                            <label for="noSub" class="theme-text-c"><input type="radio" checked value="noSubs" name="hasSubs" id="noSub">No</label>
                        </div>
                    </div>
                    <div id="hasSubDiv" class="flex-c fll">
                        <div class="flex-c fill">
                            <label for="itemCost" class="fill">Unity Cost</label>
                            <input type="number" id="itemCost" class="input-s fill pad-5">
                        </div>
                        <div class="flex-c fill">
                            <label for="itemPrice" class="fill">Unity Price</label>
                            <input type="number" id="itemPrice" class="input-s fill pad-5">
                        </div>
                        <div class="flex-c fill">
                            <label for="itemQuantity" class="fill">Items Quantity</label>
                            <input type="number" id="itemQuantity" class="input-s fill pad-5">
                        </div>
                        <div class="flex-c fill">
                            <label for="itemUnit" class="fill">Unity of Measurement</label>
                            <input type="text" id="itemUnit" class="input-s fill pad-5">
                        </div>
                    </div>
                    <div class="flex fill">
                        <label for="">Set re-Order Point</label>
                        <div class="flex theme-text-c">
                            <label for="no" class="">
                                <input checked value="no" type="radio" name="setReO" id="no"> No</label>
                            <label for="yes" class="">
                                <input value="yes" type="radio" name="setReO" id="yes"> Yes</label>
                        </div>
                    </div>
                    <div id="reOrdItemSet" class="flex-c fill" style="display: none;">
                        <label for="reorderPoint" class="fill">Re-order Level</label>
                        <input type="number" id="reorderPoint" class="input-s fill pad-5">
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="addItemToDb" class="btn-pri flex flex-centered pad-10">
                            <span class="loader-container" id="loaderContainerxxxss">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTextxxxss">ADD ITEM</span>
                        </button>
                        <button class="clossAddItemModel btn-sec pad-10">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Item Model -->
    <div class=" edit_item_model outer_model fill " style="display: none;">
        <div class="inner_add_item_model width-50 fle-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text">Add Item to <span id="itemAddCatName"><?= oneCat($cat_id, $brand)['cat_name'] ?></span></h3>
                <button id="clossEditItemModel" class="clossEditItemModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10 scroll-x" style=" max-height: 87vh;">
                <form action="#" class="fill flex-c">
                    <input type="hidden" id="itemIdToEdit">
                    <div class="flex-c fill">
                        <label for="itemNameEdit" class="fill">Item Name</label>
                        <input type="text" id="itemNameEdit" class="input-s fill pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="itemCetgoryEdit" class="fill">Item Category</label>
                        <input type="hidden" value="<?= oneCat($cat_id, $brand)['cat_id'] ?>" id="catIdToAddEdit">
                        <input type="text" value="<?= oneCat($cat_id, $brand)['cat_name'] ?>" readonly id="itemCetgoryEdit" class="input-s fill pad-5 grey">
                    </div>
                    <div class="flex-c fill">
                        <label for="subItemOfEdit" class="fill">Sub-item Of</label>
                        <select id="subItemOfEdit" class="input-s fill pad-5">
                            <option value="none">None</option>
                            <?php
                            if (mysqli_num_rows(itemsPerBrandaToSubs($cat_id, $brand, $sub))) {
                                foreach (itemsPerBrandaToSubs($cat_id, $brand, $sub) as $itemOfSub) {


                            ?>
                                    <option value="<?= $itemOfSub['item_id'] ?>"><?= $itemOfSub['item_name'] ?></option>

                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="flex-c fill">
                        <label for="itemDesEdit" class="fill">Item Discription</label>
                        <textarea id="itemDesEdit" cols="30" rows="5" class="input-s fill pad-5"></textarea>
                    </div>
                    <div class="flex fill">
                        <span class="normal-text">Has Sub-Items</span>
                        <div class="flex">
                            <label for="yesSubEdit" class="theme-text-c"><input type="radio" name="hasSubsEdit" value="yesSubEdit" id="yesSubEdit">Yes</label>
                            <label for="noSubEdit" class="theme-text-c"><input type="radio" checked name="hasSubsEdit" id="noSubEdit" value="noSubEdit">No</label>
                        </div>
                    </div>
                    <div id="setSubDivEdit" class="flex-c fill">
                        <div class="flex-c fill">
                            <label for="itemCostEdit" class="fill">Unity Cost</label>
                            <input type="number" id="itemCostEdit" class="input-s fill pad-5">
                        </div>
                        <div class="flex-c fill">
                            <label for="itemPriceEdit" class="fill">Unity Price</label>
                            <input type="number" id="itemPriceEdit" class="input-s fill pad-5">
                        </div>
                        <div class="flex-c fill">
                            <label for="itemQuantityEdit" class="fill">Items Quantity</label>
                            <input type="number" id="itemQuantityEdit" class="input-s fill pad-5">
                        </div>
                        <div class="flex-c fill">
                            <label for="itemUnitEdit" class="fill">Unity of Measurement</label>
                            <input type="text" id="itemUnitEdit" class="input-s fill pad-5">
                        </div>
                    </div>
                    <div class="flex fill">
                        <label for="">Set re-Order Point</label>
                        <div class="flex theme-text-c">
                            <label for="noEdit" class="">
                                <input checked value="no" type="radio" name="setReOEdit" id="noEdit"> No</label>
                            <label for="yesEdit" class="">
                                <input value="yes" type="radio" name="setReOEdit" id="yesEdit"> Yes</label>
                        </div>
                    </div>
                    <div id="reOrdItemSetEdit" class="flex-c fill" style="display: none;">
                        <label for="reorderPointEdit" class="fill">Re-order Level</label>
                        <input type="number" id="reorderPointEdit" class="input-s fill pad-5">
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="EditItemToCat" class="btn-pri flex flex-centered pad-10">
                            <span class="loader-container" id="loaderContainerxxxss">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTextxxxss">ADD ITEM</span>
                        </button>
                        <button class="clossEditItemModel btn-sec pad-10">CANCEL</button>
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

                        <button class="clossaddItemModel btn-sec pad-10 pointer">CANCEL</button>
                        <button id="saveAddItem" class="btn-pri pad-10 flex flex-centered">
                            <span class="loader-container" id="loaderContainerxxxp">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTextxxxp">SAVE</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/js/for_all.js"></script>
    <script src="../assets/js/cat_info.js"></script>
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