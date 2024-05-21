$(document).ready(function () {
  $("#itemsTable").DataTable();
});
$("#itemCatFilter").change(function (e) {
  e.preventDefault();
  const category = $("#itemCatFilter").val();
  document.location = "products?category=" + category;
});

function addItem(item_id, item_name) {
  // alert(item_name);

  $("#nameOfItemToAdd").html(item_name);
  $("#itemToAddId").val(item_id);

  $(".add_to_item_model").show();
}

$("#saveAddItem").click(function (e) {
  e.preventDefault();

  if (pendingMode == false) {
    pendingMode = true;
    const itemToAddId = $("#itemToAddId").val();
    const amountToAdd = $("#amountToAdd").val();

    var buttonText = $("#buttonTextxxx");
    var loaderContainer = $("#loaderContainerxxx");
    // validations
    if (amountToAdd == "") {
      inputEmpty("#amountToAdd");
    } else {
      buttonText.hide();
      loaderContainer.show();
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
          if (response == "success") {
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

$(".clossaddItemModel").click(function (e) {
  e.preventDefault();
  $(".add_to_item_model").hide();
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
  $("#itemIdToEdit").val(item_id);
  $("#itemAddName").html(item_name);
  $("#itemName").val(item_name);
  $("#itemDes").val(item_des);
  $("#itemUnit").val(item_unit);
  $("#itemCost").val(item_cost);
  $("#itemPrice").val(item_price);
  $("#itemQuantity").val(item_quantity);
  $("#reorderPoint").val(reorder_point);

  $(".add_item_model").show();
}
$(".clossAddItemModel").click(function (e) {
  e.preventDefault();
  $(".add_item_model").hide();
});

$("#addItemToCat").click(function (e) {
  e.preventDefault();
  const itemIdToEdit = $("#itemIdToEdit").val();
  const itemName = $("#itemName").val();
  const itemDes = $("#itemDes").val();
  const itemUnit = $("#itemUnit").val();
  const itemCost = $("#itemCost").val();
  const itemPrice = $("#itemPrice").val();
  const itemQuantity = $("#itemQuantity").val();
  const reorderPoint = $("#reorderPoint").val();

  // alert(itemIdToEdit);
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
  } else if (reorderPoint == "") {
    inputEmpty("#reorderPoint");
  } else if (itemCost == "") {
    inputEmpty("#itemCost");
  } else {
    $.ajax({
      type: "post",
      url: url(),
      data: {
        editItem: "editItem",
        itemIdToEdit: itemIdToEdit,
        itemName: itemName,
        itemDes: itemDes,
        itemUnit: itemUnit,
        itemCost: itemCost,
        itemPrice: itemPrice,
        itemQuantity: itemQuantity,
        reorderPoint: reorderPoint,
      },
      dataType: "html",
      success: function (response) {
        if (response == "success") {
          location.reload();
        } else {
          alert(response);
        }
      },
    });
  }
});

function deleteItem(item_id, item_name) {
  $("#deleteItemHidden").val(item_id)
  $("#deletedNam").html(item_name)
  $(".deleteItemModel").show()
}

$(".clossdeleteItemModel").click(function (e) {
  e.preventDefault();
  $(".deleteItemModel").hide()
});

$("#deleteItemConfirm").click(function (e) {
  e.preventDefault();
  let item_id = $("#deleteItemHidden").val();

  $.ajax({
    type: "post",
    url: url(),
    data: {
      deleteItem: "kgkj",
      item_id: item_id
    },
    dataType: "html",
    success: function (response) {
      if (response == "success") {
        location.reload();
      } else {
        alert(response);
      }
    }
  });
});

function showInfo(title, des, unit_cost, unit_price, store_count) {
  $(".itemName").html(title);
  $(".itemDescr").html(des);
  $(".unitCost").html(unit_cost);
  $(".unitPrice").html(unit_price);
  $(".storeCount").html(store_count);
  $(".itemDescrip").show();
}

$(".closeDescr").click(function (e) {
  e.preventDefault();
  $(".itemDescrip").hide();
});


$("#toggleStockValue").click(function (e) {
  e.preventDefault();
  // alert("ok")

  const stoPass = $("#stoPass").val();
  let view = true;

  if (view == true) {
    if (stoPass === "") {
      inputEmpty("#stoPass")
    } else {
      // alert(stoPass);


      $.ajax({
        type: "post",
        url: url(),
        data: {
          checkPassword: "Check",
          password: stoPass
        },
        dataType: "html",
        success: function (response) {
          alert(response)
        }
      });
    }
  }


});

