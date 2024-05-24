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
    <div id="main-content" class="shift pad-5">
        <!-- Button to open/close the sidebar -->
        <header class="fill flex-s-btn bg-w pad-10 rad-5 shadow-pri">
            <div class="flex flex-s-btn fill">
                <div class="flex">
                    <div id="sidebar-toggle" class=" flex"> <i class="fa fa-bars theme-text-c size-18" aria-hidden="true"></i></div>
                    <!-- Main content goes here -->
                    <h1 class="theme-text disText">Categories</h1>
                </div>
                <?php include("includes/not.php") ?>
            </div>
        </header>
        <main class="fill flex-c flex-centered">
            <div class="flex-c fill bg-w pad-10 marg-t-10 " style="min-height: 87vh; align-items:center;">
                <div class="flex-c width-90 rad-5  bg-w shadow-pri">
                    <div class="flex-s-btn fil pad-5 theme-border-b-2">
                        <h3 class=" pad-5 theme-text flex"><i class="fa fa-sitemap" aria-hidden="true"></i><?= countCats() ?> Categories</h3>
                        <button id="addCatBtn" class="btn-pri flex"><i class="fa fa-plus" aria-hidden="true"></i> ADD CATEGORY</button>
                    </div>
                    <div class="fill flex-c pad-10 pad-t-0 bg-w">
                        <table id="catTable" class="fill">
                            <thead class=" rad-5-t-l-5 theme-text">
                                <tr class="rad-5-t-l-5">
                                    <th class="text-l">S/N</th>
                                    <th class="text-l">CATEGORY</th>
                                    <th class="text-l">DESCRIPTION</th>
                                    <th class="text-l">ITEM COUNT</th>
                                    <th class="text-l theme-text">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (fetchCats()->num_rows > 0) {
                                    $sna = 1;
                                    foreach (fetchCats() as $cat) {
                                ?>
                                        <tr class="bg-w ">
                                            <td><?= $sna ?></td>
                                            <td class="pad-5"><?= $cat['cat_name']  ?></td>
                                            <td class="width-40 pad-5"><?= $cat['cat_des'] ?></td>
                                            <td><?= countCatItems($cat['cat_id']) ?></td>
                                            <td class="pad-5 flex">
                                                <a onclick="editCat('<?= $cat['cat_id'] ?>','<?= $cat['cat_name'] ?>','<?= $cat['cat_des'] ?>')" title="Edit" class="btn-pri-o flex"><i class="fas fa-edit    "></i></a>
                                                <a onclick="deleteCat('<?= $cat['cat_id'] ?>','<?= $cat['cat_name'] ?>')" title="Delete" class="btn-pri-o flex"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                <a href="cat-info?cat=<?= $cat['cat_id'] ?>" class="btn-pri-o flex"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>

                                <?php
                                        $sna = $sna + 1;
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
    <!-- delete category model -->
    <div class="delete_cat_model fill flex-c" style="display: none;">
        <div class="inner_delete_cat_model width-50 flex-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text">Delete Category <span id="deletedCatNam"></span></h3>
                <button id="clossDeleteCatModel" class="clossDeleteCatModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex">
                    <input type="hidden" id="delete_cat_id">
                    <div class="flex fill">
                        <i class="fa fa-info-circle normal-text" aria-hidden="true"></i>
                        <p>This will delete all Items in this cateory</p>
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="deleteCatConfirmed" class="btn-pri flex flex-centered pad-10">
                            <span class="loader-container" id="loaderContainerxxxdd">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTextxxxdd">DELETE</span>
                        </button>
                        <button class="clossDeleteCatModel btn-sec pad-10">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- edit category model -->
    <div class="edit_cat_model fill flex-c" style="display: none;">
        <div class="inner_edit_cat_model width-50 fle-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text">Edit Category</h3>
                <button id="clossEditCatModel" class="clossEditCatModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex-c">
                    <input type="hidden" id="edit_cat_id">
                    <div class="flex-c fill">
                        <label for="catNameEdit" class="fill">Category Name</label>
                        <input type="text" id="catNameEdit" class="input-s fill pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="catDesEdit" class="fill">Category Discription</label>
                        <textarea id="catDesEdit" cols="30" rows="5" class="input-s fill pad-5"></textarea>
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="saveCatEdit" class="btn-pri pad-10 flex flex-centered">
                            <span class="loader-container" id="loaderContainerxxx">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTextxxx">SAVE EDITS</span>
                        </button>
                        <button class="clossEditCatModel btn-sec pad-10">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Cat Model -->
    <div class="outer_model addCatModel fill" style="display: none;">
        <div class="inner_model width-50 fle-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text">Define New Category</h3>
                <button id="clossAddCatModel" class="clossAddCatModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex-c">
                    <div class="flex-c fill">
                        <label for="catName" class="fill">Category Name</label>
                        <input type="text" id="newCat" class="input-s fill pad-5">
                    </div>
                    <div class="flex-c fill">
                        <label for="catDes" class="fill">Category Discription</label>
                        <textarea id="newCatDes" cols="30" rows="5" class="input-s fill pad-5"></textarea>
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button class="clossAddCatModel btn-sec pad-10">CANCEL</button>
                        <button id="saveNewCat" class="btn-pri flex flex-centered pad-10">
                            <span class="loader-container" id="loaderContainerxxxaa">
                                <div class="loader" id="loader"></div>
                            </span>
                            <span id="buttonTextxxxaa">SAVE</span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add ItemModel -->
    <div class="add_item_model fill flex-c" style="display: none;">
        <div class="inner_add_item_model width-50 fle-c rad-5">
            <div class="flex flex-s-btn fill pad-5 bg-sec rad-5-t-r-5 rad-5-t-l-5">
                <h3 class="theme-text">Add Item to <span id="itemAddCatName"></span></h3>
                <button id="clossAddItemModel" class="clossAddItemModel btn-pri"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <form action="#" class="fill flex-c">
                    <input type="hidden" id="catIdToAdd">
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
                        <label for="reorderPoint" class="fill">Re-order Level</label>
                        <input type="number" id="reorderPoint" class="input-s fill pad-5">
                    </div>
                    <div class="grid-2 fill pad-5">
                        <button id="addItemToCat" class="btn-pri flex flex-centered pad-10">
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

    <script src="../assets/js/categories.js"></script>
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