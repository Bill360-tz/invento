$(document).ready(function () {
    $("#brandItemTable").DataTable();
});


$("#saveBrand").click(function (e) {
    e.preventDefault();
    let brandInput = $("#brandInput").val();
    let cat_id = $("#cat_id").val();
    let reorder = $("#reOrderP").val();

    if (brandInput == "") {
        inputEmpty("#brandInput");
    } else if (reorder == "") {
        reorder = "null"
    } else {

        $.ajax({
            type: "post",
            url: url(),
            data: {
                saveBrand: "Sjhjhda",
                brand: brandInput,
                cat_id: cat_id,
                reorder: reorder
            },
            dataType: "html",
            success: function (response) {
                if (response == 1) {
                    location.reload()
                } else {
                    alert(response)
                }
            }
        });
    }
});


function deleteBrand(brand_id, brand_name) {
    // alert(brand_id)
    if (confirm("Are you sure you want to delete the brand " + brand_name + " and all its Items?")) {
        $.ajax({
            type: "post",
            url: url(),
            data: {
                deleteBrand: "kjfhlks",
                brand_id: brand_id
            },
            dataType: "html",
            success: function (response) {
                if (response == 1) {
                    location.reload()
                } else {
                    alert(response)
                }
            }
        });
    }

}
function deleteCatItem(item_id, item_name) {
    // alert(item_id)

    if (confirm("Aru you sure you want to delete the category " + item_name + "? This will delete and all the items under the category")) {
        $.ajax({
            type: "post",
            url: url(),
            data: {
                deleteCatItem: "deleteCatItem",
                item_id: item_id
            },
            dataType: "html",
            success: function (response) {
                if (response == 1) {
                    location.reload()
                } else {
                    alert(response)
                }
            }
        });
    }


}

$("#trigAddBrand").click(function (e) {
    e.preventDefault();
    $("#trigAddBrand").hide();
    $("#cancelAddBrand").show();
    $("#addBrandDiv").slideDown();
});
$("#cancelAddBrand").click(function (e) {
    e.preventDefault();

    $("#cancelAddBrand").hide();
    $("#addBrandDiv").slideUp();
    $("#trigAddBrand").fadeIn();
});

$('input[type=radio][name=reorder_set]').change(function () {
    if (this.value == 'no') {
        // ... do something when 'yourValue1' is selected
        $("#reOrderInpuDiv").hide(500);
        $("#reOrderP").val('');
    }
    else if (this.value == 'yes') {
        // ... do something when 'yourValue2' is selected
        $("#reOrderInpuDiv").show(500);
    }
});

$("#addItemModelOp").click(function (e) {
    e.preventDefault();
    $(".add_item_model").show();
});
$("#clossAddItemModel").click(function (e) {
    e.preventDefault();
    $(".add_item_model").hide();
});

var checKReorder = 'no'
$('input[type=radio][name=setReO]').change(function () {
    if (this.value == 'no') {
        // ... do something when 'yourValue1' is selected
        $("#reOrdItemSet").slideUp();
        checKReorder = 'no'
        $("#reorderPoint").val('');
    }
    else if (this.value == 'yes') {
        // ... do something when 'yourValue2' is selected
        checKReorder = 'yes'
        $("#reOrdItemSet").slideDown();
    }
});
var setReOEdit = 'no'
$('input[type=radio][name=setReOEdit]').change(function () {
    if (this.value == 'no') {
        // ... do something when 'yourValue1' is selected
        setReOEdit = 'no'
        $("#reOrdItemSetEdit").slideUp();
        $("#reorderPointEdit").val('');
    }
    else if (this.value == 'yes') {
        // ... do something when 'yourValue2' is selected
        setReOEdit = 'yes'
        $("#reOrdItemSetEdit").slideDown();
    }
});

var hasSubsEdit = 'noSubEdit'
$('input[type=radio][name=hasSubsEdit]').change(function () {
    if (this.value == 'yesSubEdit') {
        // ... do something when 'yourValue1' is selected
        hasSubsEdit = 'yesSubEdit'
        $("#setSubDivEdit").slideUp();
        // $("#reorderPointEdit").val('');
    }
    else if (this.value == 'noSubEdit') {
        // ... do something when 'yourValue2' is selected
        hasSubsEdit = 'yesSubEdit';
        $("#setSubDivEdit").slideDown();
    }
});

$("#addItemToCat").click(function (e) {
    e.preventDefault();
    const catIdToAdd = $("#catIdToAdd").val();
    const ItemBrand = $("#ItemBrand").val();
    const itemName = $("#itemName").val();
    const itemDes = $("#itemDes").val();
    const itemUnit = $("#itemUnit").val();
    const itemCost = $("#itemCost").val();
    const itemPrice = $("#itemPrice").val();
    const itemQuantity = $("#itemQuantity").val();
    let reorderPoint = $("#reorderPoint").val();
    var buttonText = $("#buttonTextxxxss");
    var loaderContainer = $("#loaderContainerxxxss");

    alert(ItemBrand)
    // looong validation
    if (itemName == "") {
        inputEmpty("#itemName");
    } else if (itemDes == "") {
        inputEmpty("#itemDes");
    } else if (itemUnit == "") {
        inputEmpty("#itemUnit");
    } else if (itemPrice == "") {
        inputEmpty("#itemPrice");
    } else if (itemQuantity == "") {
        inputEmpty("#itemQuantity");
    } else if (itemCost == "") {
        inputEmpty("#itemCost");
    } else {
        if (reorderPoint == "") {
            reorderPoint = '0'
        }
        // $(this).attr("disabled", true);
        buttonText.hide();
        loaderContainer.show();
        $.ajax({
            type: "post",
            url: url(),
            data: {
                addItem: "addItem",
                catIdToAdd: catIdToAdd,
                itemName: itemName,
                itemDes: itemDes,
                itemUnit: itemUnit,
                itemCost: itemCost,
                itemPrice: itemPrice,
                itemQuantity: itemQuantity,
                reorderPoint: reorderPoint,
                ItemBrand: ItemBrand
            },
            dataType: "html",
            success: function (response) {
                if (response == 1) {
                    location.reload();
                } else {
                    alert(response);
                }
                buttonText.show();
                loaderContainer.hide();
            },
        });
    }
});

function editItem(
    item_id,
    item_name,
    item_des,
    item_unit,
    item_cost,
    item_price,
    item_quantity,
    reorder_point
) {

    // alert(reorder_point)
    $("#itemIdToEdit").val(item_id);
    $("#itemNameEdit").html(item_name);
    $("#itemNameEdit").val(item_name);
    $("#itemDesEdit").val(item_des);
    // $("#itemUnit").val(item_unit);
    $("#itemCostEdit").val(item_cost);
    $("#itemPriceEdit").val(item_price);
    $("#itemQuantityEdit").val(item_quantity);
    $("#itemUnitEdit").val(item_unit);
    $("#reorderPointEdit").val(reorder_point);

    $(".edit_item_model").show();
}

$(".clossEditItemModel").click(function (e) {
    e.preventDefault();
    $(".edit_item_model").hide();
});

var checkBtn = 'noSubs'
$('input[type=radio][name=hasSubs]').change(function () {
    if (this.value == 'hasSubs') {
        // ... do something when 'yourValue1' is selected
        checkBtn = 'hasSubs'
        $("#hasSubDiv").slideUp();
        // $("#reorderPointEdit").val('');
    }
    else if (this.value == 'noSubs') {
        // ... do something when 'yourValue2' is selected
        $("#hasSubDiv").slideDown();
        checkBtn = 'noSubs'
    }
});




$("#addItemToDb").click(function (e) {
    e.preventDefault();
    // let checkBtn = $('input[type=radio][name=hasSubs]').val();
    // let checKReorder = $('input[type=radio][name=setReO]').val();
    const catIdToAdd = $("#catIdToAdd").val();
    let ItemBrand = $("#ItemBrand").val();
    const itemName = $("#itemName").val();
    const itemDes = $("#itemDes").val();
    const itemUnit = $("#itemUnit").val();
    const itemCost = $("#itemCost").val();
    const itemPrice = $("#itemPrice").val();
    const itemQuantity = $("#itemQuantity").val();
    let reorderPoint = $("#reorderPoint").val();
    let subItemOf = $("#subItemOf").val();


    if (ItemBrand == "ALl") {
        ItemBrand = '0';
    }
    var buttonText = $("#buttonTextxxxss");
    var loaderContainer = $("#loaderContainerxxxss");
    if (checkBtn == "hasSubs") {
        // alert('yesSubs')
        if (itemName == "") {
            inputEmpty("#itemName")
        } else if (itemDes == "") {
            inputEmpty("#itemDes");
        } else {
            if (checKReorder == "no") {
                reorderPoint = '0'
            }
            if (subItemOf == "none") {
                subItemOf = '0';
            }
            $.ajax({
                type: "post",
                url: url(),
                data: {
                    itemSaveOne: "itemSaveOne",
                    cat_id: catIdToAdd,
                    brand: ItemBrand,
                    itemName: itemName,
                    itemDes: itemDes,
                    subItemOf: subItemOf,
                    reorderPoint: reorderPoint
                },
                dataType: "html",
                success: function (response) {
                    if (response == 1) {
                        location.reload();
                    } else {
                        alert(response);
                    }
                }
            });
        }
    } else {
        // alert(checkBtn)
        if (itemName == "") {
            inputEmpty("#itemName")
        } else if (itemDes == "") {
            inputEmpty("#itemDes");
        } else if (itemUnit == "") {
            inputEmpty("#itemUnit");
        } else if (itemCost == "") {
            inputEmpty("#itemCost")
        } else if (itemPrice == "") {
            inputEmpty("#itemPrice")
        } else if (itemQuantity == "") {
            inputEmpty("itemQuantity")
        } else {
            if (checKReorder == "no") {
                reorderPoint = '0'
            }
            if (subItemOf == "none") {
                subItemOf = '0';
            }

            $.ajax({
                type: "post",
                url: url(),
                data: {
                    itemSaveTwo: "itemSaveTwo",
                    cat_id: catIdToAdd,
                    brand: ItemBrand,
                    itemName: itemName,
                    itemDes: itemDes,
                    subItemOf: subItemOf,
                    reorderPoint: reorderPoint,
                    itemUnit: itemUnit,
                    itemQuantity: itemQuantity,
                    itemCost: itemCost,
                    itemPrice: itemPrice

                },
                dataType: "html",
                success: function (response) {
                    if (response == 1) {
                        location.reload();
                    } else {
                        alert(response);
                    }
                }
            });
        }
    }
});


$("#EditItemToCat").click(function (e) {
    e.preventDefault();
    let itemIdToEdit = $('#itemIdToEdit').val()
    let itemNameEdit = $("#itemNameEdit").val();
    let subItemOfEdit = $("#subItemOfEdit").val()
    let itemDesEdit = $("#itemDesEdit").val()
    let itemCostEdit = $("#itemCostEdit").val()
    let itemPriceEdit = $("#itemPriceEdit").val()
    let itemQuantityEdit = $("#itemQuantityEdit").val()
    let itemUnitEdit = $("#itemUnitEdit").val()
    let reorderPointEdit = $("#reorderPointEdit").val()
    // alert(setReOEdit)

    // Validation starts

    if (itemNameEdit == "") {
        inputEmpty("#itemNameEdit");
    } else if (subItemOfEdit == "") {
        inputEmpty("#subItemOfEdit ")
    } else if (itemDesEdit == "") {
        inputEmpty("#itemDesEdit");
    } else if (itemCostEdit == "") {
        inputEmpty("#itemCostEdit");
    } else if (itemPriceEdit == "") {
        inputEmpty("#itemPriceEdit");
    } else if (itemQuantityEdit == "") {
        itemQuantityEdit = "0"
    } else if (itemUnitEdit == "") {
        inputEmpty('#itemUnityEdit')
    } else {
        let go = true;
        if (setReOEdit == "no") {
            if (reorderPointEdit == "") {
                reorderPointEdit == "0";
            }
        } else {

            if (reorderPointEdit == "") {
                go = false;
                inputEmpty("#reorderPointEdit");
            } else {

            }
        }
        if (hasSubsEdit == "yesSubEdit") {
            hasSubsEdit = 'yes'
        } else {
            hasSubsEdit = 'no'
        }

        if (go = true) {
            $.ajax({
                type: "post",
                url: url(),
                data: {
                    saveItemsEdits: "SaveItemsEdits",
                    itemNameEdit: itemNameEdit,
                    subItemOfEdit: subItemOfEdit,
                    itemDesEdit: itemDesEdit,
                    itemCostEdit: itemCostEdit,
                    itemPriceEdit: itemPriceEdit,
                    itemQuantityEdit: itemQuantityEdit,
                    itemUnitEdit: itemUnitEdit,
                    reorderPointEdit: reorderPointEdit,
                    itemIdToEdit: itemIdToEdit,
                    hasSubsEdit: hasSubsEdit

                },
                dataType: "html",
                success: function (response) {
                    if (response == 1) {
                        location.reload()
                    } else {
                        alert(response)
                    }
                }
            });
        }


    }

});

function deleteItem(item_id, item_name) {
    // alert(item_id)
    if (confirm("Are you sure you want to delete the item " + item_name + "?")) {
        $.ajax({
            type: "post",
            url: url(),
            data: {
                deleteItem: "deleteItem",
                item_id: item_id
            },
            dataType: "html",
            success: function (response) {
                if (response == 1) {
                    location.reload()
                } else {
                    alert(response);
                }
            }
        });
    }
}

function addItem(item_id, item_name) {
    // alert(item_name);

    $("#nameOfItemToAdd").html(item_name);
    $("#itemToAddId").val(item_id);

    $(".add_to_item_model").show();
}

$(".clossaddItemModel").click(function (e) {
    e.preventDefault();
    $(".add_to_item_model").hide();
});

$("#saveAddItem").click(function (e) {
    e.preventDefault();

    if (pendingMode == false) {
        pendingMode = true;
        const itemToAddId = $("#itemToAddId").val();
        const amountToAdd = $("#amountToAdd").val();

        var buttonText = $("#buttonTextxxxp");
        var loaderContainer = $("#loaderContainerxxxp");

        buttonText.hide();
        loaderContainer.show();

        // validations
        if (amountToAdd == "") {
            inputEmpty("#amountToAdd");
        } else {
            $.ajax({
                type: "post",
                url: url(),
                data: {
                    addToItem: "addToItem",
                    item_id: itemToAddId,
                    amountToAdd: amountToAdd,
                },
                dataType: "html",
                success: function (response) {
                    if (response == 1) {
                        location.reload();
                    } else {
                        alert(response);
                    }

                    buttonText.show();
                    loaderContainer.hide();
                },
            });
        }
    }


});


function editBrand(brand_id, brand_name, re_order) {
    $("#brandNameEdit").val(brand_name)
    $("#reOrderPEdit").val(re_order)
    $("#brand_id_hidden").val(brand_id)

    $("#EditBrandDiv").slideDown();
}

$("#cancelBrandEdit").click(function (e) {
    e.preventDefault();
    $("#EditBrandDiv").slideUp();
});

$("#saveBrandEdits").click(function (e) {
    e.preventDefault();
    let brand_name = $("#brandNameEdit").val();
    let brand_id = $("#brand_id_hidden").val();
    let re_order = $("#reOrderPEdit").val();

    if (brand_name == "") {
        inputEmpty("#brandNameEdit")
    } else {
        $.ajax({
            type: "post",
            url: url(),
            data: {
                saveBrandEdit: "gkjfg",
                brand_name: brand_name,
                brand_id: brand_id,
                re_order: re_order
            },
            dataType: "html",
            success: function (response) {
                if (response == 1) {
                    location.reload()
                } else {
                    alert(response);
                }
            }
        });
    }
});