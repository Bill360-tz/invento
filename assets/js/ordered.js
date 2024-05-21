$(document).ready(function () {
    $("#expRecord").DataTable();
});
$("#addExphh").click(function (e) {
    e.preventDefault();
    $(".addExpModel").show();
});
$(".cancelExpAdd").click(function (e) {
    e.preventDefault();
    $(".addExpModel").hide();
});
function setExpSeason(aaa) {

    $.ajax({
        type: "post",
        url: url(),
        data: {
            setExpSeason: "setExpSeason",
            aaa: aaa
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
}

$("#expFilter").change(function (e) {
    e.preventDefault();
    setExpSeason(this.value);
});

$("#saveExpense").click(function (e) {
    e.preventDefault();

    if(pendingMode == false){

        pendingMode = true;
        let expenseName = $("#expenseName").val();
        let expenseAmount = $("#expenseAmount").val();
        let expenseDate = $("#expenseDate").val();
        
        var buttonText = $("#buttonTextxxx");
        var loaderContainer = $("#loaderContainerxxx");
    
        // validations starts here
        if (expenseName == "") {
            inputEmpty("#expenseName");
        } else if (expenseAmount == "") {
            inputEmpty("#expenseAmount");
        } else if (expenseDate == "") {
            inputEmpty("#expenseDate");
        } else {
            // $(this).attr("disabled", true);
            buttonText.hide();
            loaderContainer.show();
            $.ajax({
                type: "post",
                url: url(),
                data: {
                    insetOrder: "insetExpenses",
                    expenseName: expenseName,
                    expenseAmount: expenseAmount,
                    expenseDate: expenseDate,
                   
                },
                dataType: "html",
                success: function (response) {
                    if (response == "success") {
                        location.reload()
                    } else {
                        alert(response);
                    }
    
                    $("#addPayToCustbtn").removeAttr("disabled");
                    buttonText.show();
                    loaderContainer.hide();
                }
            });
        }  
    }
    
});
$("#saveExpenseEdit").click(function (e) {
    e.preventDefault();
    let expenseName = $("#expenseNamee").val();
    let expenseAmount = $("#expenseAmounte").val();
    let expenseDate = $("#expenseDatee").val();
    let ex_id = $("#ex_idxx").val();
    var buttonText = $("#buttonTextxxxe");
    var loaderContainer = $("#loaderContainerxxxe");

    // validations starts here
    if (expenseName == "") {
        inputEmpty("#expenseNamee");
    } else if (expenseAmount == "") {
        inputEmpty("#expenseAmounte");
    } else if (expenseDate == "") {
        inputEmpty("#expenseDatee");
    } else {
        // $(this).attr("disabled", true);
        buttonText.hide();
        loaderContainer.show();
        $.ajax({
            type: "post",
            url: url(),
            data: {
                editOrderedItem: "editExpenses",
                expenseName: expenseName,
                expenseAmount: expenseAmount,
                expenseDate: expenseDate,
                ex_id: ex_id
            },
            dataType: "html",
            success: function (response) {
                if (response == "success") {
                    location.reload()
                } else {
                    console.log(response);
                }

                // $("#addPayToCustbtn").removeAttr("disabled");
                buttonText.show();
                loaderContainer.hide();
            }
        });
    }
});

function editExpense(ex_id, ex_name, ex_amount,ex_date){
    $("#expenseNamee").val(ex_name);
    $("#expenseAmounte").val(ex_amount);
    $("#ex_idxx").val(ex_id);
    $(".editExpModel").show();
}


$(".cancelExpEdit").click(function (e) { 
    e.preventDefault();
    $(".editExpModel").hide();
});

function deleteEx(ex_id, ex_name){
    $("#deletedCatNam").html(ex_name)
    $("#delete_cat_id").val(ex_id)
    $(".delete_cat_model").show();
}

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
        deleteOrderedItem: "deleteCat",
        ex_id: delete_ex_id
      },
      dataType: "html",
      success: function (response) {
        if(response == "success"){
          location.reload()
        }else{
          alert(response)
        }
        buttonText.show();
        loaderContainer.hide();
      }
    });
  });

$(".clossDeleteCatModel").click(function (e) { 
    e.preventDefault();
    $(".delete_cat_model").hide();
});