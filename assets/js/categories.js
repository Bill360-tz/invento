$(document).ready(function () {
  $("#catTable").DataTable();
});

function toggleMenu() {
  // JavaScript to handle sidebar toggle
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.getElementById("main-content");

  sidebar.classList.toggle("open");
  mainContent.classList.toggle("shift");
}

var openedStatus = false;
$("#addCatBtn").click(function (e) {
  e.preventDefault();
  $(".addCatModel").show();
});
$(".clossAddCatModel").click(function (e) {
  e.preventDefault();
  $(".addCatModel").hide();

  if (openedStatus == true) {
    setTimeout(() => {
      toggleMenu();
    }, 400);
  }
});
function editCat(edit_cat_id, cat_name, cat_des) {
  $("#edit_cat_id").val(edit_cat_id);
  $("#catNameEdit").val(cat_name);
  $("#catDesEdit").val(cat_des);

  $(".edit_cat_model").show();
}
$(".clossEditCatModel").click(function (e) {
  e.preventDefault();
  $(".edit_cat_model").hide();

  if (openedStatus == true) {
    setTimeout(() => {
      toggleMenu();
    }, 400);
  }
});
function deleteCat(delet_cat_id, cat_name) {
  $("#delete_cat_id").val(delet_cat_id);
  $("#deletedCatNam").html(cat_name);


  $(".delete_cat_model").show();
}
$(".clossDeleteCatModel").click(function (e) {
  e.preventDefault();
  $(".delete_cat_model").fadeOut();

  if (openedStatus == true) {
    setTimeout(() => {
      toggleMenu();
    }, 400);
  }
});
function addCatItem(AddItemcat_id, cat_name) {
  $("#catIdToAdd").val(AddItemcat_id);
  $("#itemAddCatName").html(cat_name);

  $(".add_item_model").show();
}
$(".clossAddItemModel").click(function (e) {
  e.preventDefault();
  $(".add_item_model").fadeOut();

  if (openedStatus == true) {
    setTimeout(() => {
      toggleMenu();
    }, 400);
  }
});

$("#saveNewCat").click(function (e) {
  e.preventDefault();

  if (pendingMode == false) {
    pendingMode = true;
    const newCat = $("#newCat").val();
    const newCatDes = $("#newCatDes").val();
    var buttonText = $("#buttonTextxxxaa");
    var loaderContainer = $("#loaderContainerxxxaa");

    if (newCat == "") {
      inputEmpty("#newCat");
    } else if (newCatDes == "") {
      inputEmpty("#newCatDes");
    } else {
      // $(this).attr("disabled", true);
      buttonText.hide();
      loaderContainer.show();
      $.ajax({
        type: "post",
        url: url(),
        data: {
          saveNewCat: "saveNewCat",
          cat_name: newCat,
          cat_des: newCatDes,
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

$("#saveCatEdit").click(function (e) {
  e.preventDefault();
  const edit_cat_id = $("#edit_cat_id").val();
  const catNameEdit = $("#catNameEdit").val();
  const catDesEdit = $("#catDesEdit").val();
  var buttonText = $("#buttonTextxxx");
  var loaderContainer = $("#loaderContainerxxx");

  if (newCat == "") {
    inputEmpty("#newCat");
  } else if (newCatDes == "") {
    inputEmpty("#newCatDes");
  } else {
    // $(this).attr("disabled", true);
    buttonText.hide();
    loaderContainer.show();
    $.ajax({
      type: "post",
      url: url(),
      data: {
        saveCatEdit: "saveCatEdit",
        edit_cat_id: edit_cat_id,
        catNameEdit: catNameEdit,
        catDesEdit: catDesEdit,
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
});

$("#addItemToCat").click(function (e) {
  e.preventDefault();
  const catIdToAdd = $("#catIdToAdd").val();
  const itemName = $("#itemName").val();
  const itemDes = $("#itemDes").val();
  const itemUnit = $("#itemUnit").val();
  const itemCost = $("#itemCost").val();
  const itemPrice = $("#itemPrice").val();
  const itemQuantity = $("#itemQuantity").val();
  const reorderPoint = $("#reorderPoint").val();
  var buttonText = $("#buttonTextxxxss");
  var loaderContainer = $("#loaderContainerxxxss");

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
});

$("#deleteCatConfirmed").click(function (e) {
  e.preventDefault();
  // alert($("#delete_cat_id").val())

  let delete_cat_id = $("#delete_cat_id").val();

  $.ajax({
    type: "post",
    url: url(),
    data: {
      deleteCat: "deleteCat",
      cat_id: delete_cat_id
    },
    dataType: "html",
    success: function (response) {
      if (response == "success") {
        location.reload()
      } else {
        alert(response)
      }
    }
  });
});