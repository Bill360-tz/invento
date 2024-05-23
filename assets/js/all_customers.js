$(document).ready(function () {
    $("#cutomersTable").DataTable();
  });

function deleteCust(cust_id, cust_name){
  $("#deletedCatNam").html(cust_name)
  $("#delete_cat_id").val(cust_id)
  $(".delete_cat_model").show();
}

$(".clossDeleteCatModel").click(function (e) {
  e.preventDefault();
  $(".delete_cat_model").hide();
});

$("#deleteCatConfirmed").click(function (e) {
  e.preventDefault();
  // alert($("#delete_cat_id").val())
  var buttonText = $("#buttonTextyt");
  var loaderContainer = $("#loaderContaineryt");
  buttonText.hide();
  loaderContainer.show();
  let delete_ex_id = $("#delete_cat_id").val();

  // alert(delete_ex_id);
  $.ajax({
    type: "post",
    url: url(),
    data: {
      deleteCust: "deleteCat",
      cust_phone: delete_ex_id
    },
    dataType: "html",
    success: function (response) {
      if (response == 1) {
        location.reload()
      } else {
        alert(response)
      }
      buttonText.show();
      loaderContainer.hide();
    }
  });
});

$("#senMessageToAllCusts").click(function (e) { 
  e.preventDefault();
  const message = $("#message").val();
  var buttonText = $("#buttonTextxxxaa");
    var loaderContainer = $("#loaderContainerxxxaa");

  if(message == ""){
    inputEmpty("#message")
  }else{
    $.ajax({
      type: "post",
      url: url(),
      data: {
        smsAllCusts: "gjf",
        message:message
      },
      dataType: "html",
      success: function (response) {
        if(response == 1){
          location.reload()
        }else{
          alert(response)
        }

        buttonText.show();
          loaderContainer.hide();
      }
    });
  }

});


$("#trigSmsAllModel").click(function (e) { 
  e.preventDefault();
  
  $('.smsAllCustModel').show();
});
$("#closeSmMo").click(function (e) { 
  e.preventDefault();
  
  $('.smsAllCustModel').hide();
});

