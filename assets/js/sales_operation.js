$(document).ready(function () {
  $("#selectItemTable").DataTable();
});

$("#makeSale").click(function (e) {
  e.preventDefault();
  $(".selectItem_model").show();
});
$(".closemakeSale").click(function (e) {
  e.preventDefault();
  $(".selectItem_model").hide();

  location.reload();
});

let totalPrice = 0;
let cartItemIds = [];
let invoLast = false;
let salesData = []
function processDiscount(aaa) {
  if (aaa < 0 || aaa == "") {
    $("#discount").val(0);
  }
  setAmountDue();
}
function setTotalPrice() {
  totalPrice = 0;
  $.each(cartItemIds, function (index, value) {
    totalPrice =
      Number(totalPrice) +
      Number(onlyNumber($("#itemTotalPrice_" + value).val()));
  });
  $("#totalPrice").val(numberFormat(totalPrice));

  setAmountDue();
}

function setAmountDue() {
  let nowTotalPrice = onlyNumber($("#totalPrice").val());
  let discount = onlyNumber($("#discount").val());
  let amountDue = numberFormat(Number(nowTotalPrice) - Number(discount));

  $("#amountDue").val(amountDue);

  if (Number(onlyNumber($("#amountDue").val())) < 1) {
    selectionBack();
  }
}

function removeFromCart(item_id) {
  // alert(item_id);

  cartItemIds = cartItemIds.filter(function (item) {
    return item !== String(item_id);
  });
  $(".selectedItems .itemS_" + item_id).remove();
  setTotalPrice();

}

function itemCounterSet(item_id, item_price) {
  let item_counter = $("#itemConter_" + item_id).val();

  if (Number(item_counter) <= 1 || Number(item_counter) == "") {
    $("#itemTotalPrice_" + item_id).val(numberFormat(item_price));
  } else {
    $("#itemTotalPrice_" + item_id).val(
      numberFormat(Number(item_counter) * Number(item_price))
    );
  }
  setTotalPrice();
}

function processTotalPrice(item_id, item_price) {
  let itemTotalPrice = onlyNumber($("#itemTotalPrice_" + item_id).val());

  let item_total_price = Number(itemTotalPrice) + Number(item_price);
  $("#itemTotalPrice_" + item_id).val(numberFormat(item_total_price));
}
// **** fuction to add to cart
function addToCart(item_id, item_name, item_price, item_cost) {
  if (cartItemIds.includes(String(item_id))) {
    processTotalPrice(item_id, item_price);
    let item_counter = $("#itemConter_" + item_id).val();
    let itemInCount = Number(item_counter) + 1;
    $("#itemConter_" + item_id).val(itemInCount);
  } else {
    cartItemIds.push(item_id);
    $(".selectedItems").append(
      `
    <div class="itemS_` +
      item_id +
      ` fill pad-5 grid-3qs theme-text-c">
        <div class="grid-3qs">
            <span id="item_name_` +
      item_id +
      `" class="flex">` +
      item_name +
      `</span>
            <span id="item_price_` +
      item_id +
      `" class="flex">` +
      numberFormat(item_price) +
      `</span>
            <input id="item_cost_` +
      item_id +
      `" type="hidden" value="` + item_cost +
      `">
        </div>
        <div class="flex">
            <span class="flex flex-centered">
                <input id="itemConter_` +
      item_id +
      `" oninput="if(this.value <1){this.value =1;
          document.getElementById('itemTotalPrice_` +
      item_id +
      `').value = '` +
      item_price +
      `';
          itemCounterSet('` +
      item_id +
      `','` +
      item_price +
      `')}else{itemCounterSet('` +
      item_id +
      `','` +
      item_price +
      `')}" class="input-s pad-3" value="1" type="number" style="width:40px;text-align:center">
            </span>
            <span class="flex flex-centered ">
                <input id="itemTotalPrice_` +
      item_id +
      `" style="width: 90px; border:none;font-weight:600;font-size:15px;" class="text-r pad-3 no-border" type="text" value="` +
      numberFormat(item_price) +
      `" disabled>
            </span>
            <span>
                <button title="Remove from cart" onclick="removeFromCart('` +
      item_id +
      `')" class="btn-pri-o no-border"><i class="fa fa-times" aria-hidden="true"></i></button>
            </span>

        </div>
    </div>
    `
    );
    if (invoLast != true) {

      $("#invoLast").show();
      invoLast = true
    }

    $("#itemsP").append(
      `<div class="grid-3qs fill normal-text">
      <div class="flex">
          <span>`+ item_name + ` </span><span class="grey">(Count)</span>
      </div>
      <div class="">(figure)</div>
  </div>`
    )
  }
  setTotalPrice();
}

$("#startMakeSale").click(function (e) {
  e.preventDefault();
  if ($("#amountDue").val() < 1) {
    inputEmpty("#amountDue");
  } else {
    removeInputEmpty("#amountDue")
    $("#selectItemWraper").hide();
    $(".startMakeSaleBtns").hide();
    $(".finalizingSale").show();
  }

});

function phoneinpu(value) {
  $("#custName").val("Customer_" + value)
}

$("#completeSaleBtnss").click(function (e) {
  e.preventDefault();
  let amountPaid = $("#amountPaid").val();
  let custPhoness = $("#custPhoness").val();
  let custName = $("#custName").val();

  if (amountPaid == "") {
    inputEmpty("#amountPaid")
  } else if (custPhoness == "" || custPhoness.length < 10 || isNaN(Number(custPhoness)) == true) {
    inputEmpty("#custPhoness")
  } else {
    removeInputEmpty("#amountPaid");
    removeInputEmpty("#custPhoness");
    $(".completeSaleModel").show();
  }
});

$("#closemakeSaleConfirmedModel").click(function (e) {
  e.preventDefault();
  $(".completeSaleModel").hide();
});

function selectionBack() {
  $(".finalizingSale").hide();
  $("#selectItemWraper").show();
  $(".startMakeSaleBtns").show();
}

$("#selectionBackBtn").click(function (e) {
  e.preventDefault();
  selectionBack()
});
function checkPayStatus() {
  var payment_status;
  if (Number(onlyNumber($("#amountDue").val())) - Number(onlyNumber($("#amountPaid").val())) > 0) {
    payment_status = 'not_full_paid';
  } else {
    payment_status = 'full_paid';
  }
  return payment_status;
}
function setForInvoice() {
  let invoiceTarget = {
    target: 'invoice',
    invoice_no: $("#invoiceNumber").val(),
    cust_phone: $("#custPhoness").val(),
    total_price: onlyNumber($("#totalPrice").val()),
    discount: onlyNumber($("#discount").val()),
    amout_due: onlyNumber($("#amountDue").val()),
    amount_paid: onlyNumber($("#amountPaid").val()),
    payment_status: checkPayStatus()
  }
  salesData.push(invoiceTarget)

}

function setPayment() {
  let payentTarget = {
    target: "payment",
    invoice_no: $("#invoiceNumber").val(),
    paid_amount: onlyNumber($("#amountPaid").val()),
    pay_method: $("#paymentMethod").val()
  }
  salesData.push(payentTarget)
}

function setItems() {
  var itemsTarget;

  $.each(cartItemIds, function (index, element) {
    itemsTarget = {
      target: "items",
      item_id: element,
      item_count: Number($("#itemConter_" + element).val())
    }
    salesData.push(itemsTarget)
  });
}
var elementx = 0;
function setSoldItems() {
  var soldItemstarget;
  $.each(cartItemIds, function (index, element) {
    // elementx = element
    console.log($("#item_cost_"+element).val())
    soldItemstarget = {
      target: "sold_items",
      invoice_no: $("#invoiceNumber").val(),
      item_id: element,
      item_count: Number($("#itemConter_" + element).val()),
      item_cost: Number($("#item_cost_" + element).val()),
      item_price: onlyNumber($("#item_price_"+element).val())
    } 
    salesData.push(soldItemstarget)
  });
}
function setCustomer() {
  let customerTarget = {
    target: "customers",
    cust_phone: $("#custPhoness").val(),
    cust_name: $("#custName").val()
  }
  salesData.push(customerTarget)
}
$("#makeSaleConfirmed").click(function (e) {
  // alert($("#item_price_"+elementx).val())
  if (pendingMode == false) {

    pendingMode = true;
    e.preventDefault();
    setForInvoice();
    setPayment();
    setItems();
    setSoldItems()
    setCustomer();

    var buttonText = $("#buttonTextxxx");
    var loaderContainer = $("#loaderContainerxxx");

    buttonText.hide();
    loaderContainer.show();
    $.ajax({
      url: "../admin/functions/sales-operation.php", // Replace with your actual backend URL
      type: "POST",
      data: JSON.stringify(salesData),
      contentType: "application/json",
      success: function (response) {
        // Handle success response from the backend
        if (response == "success") {
          location.reload();
        } else {
          pendingMode = false
          alert(response)
        }

        $("#makeSaleConfirmed").removeAttr("disabled");
        buttonText.show();
        loaderContainer.hide();
      },
      error: function (xhr, status, error) {
        // Handle error response from the backend
        console.error("Error:", status, error);
      }
    });

  }

  // console.log(salesData);
});

var printWindo
function goToPrint(invoice_no) {

  if (pendingMode == false) {

    pendingMode = true;
    setForInvoice();
    setPayment();
    setItems();
    setSoldItems()
    setCustomer();

    var buttonText = $("#buttonTextxxxp");
    var loaderContainer = $("#loaderContainerxxxp");

    buttonText.hide();
    loaderContainer.show();
    $.ajax({
      url: "../admin/functions/sales-operation.php", // Replace with your actual backend URL
      type: "POST",
      data: JSON.stringify(salesData),
      contentType: "application/json",
      success: function (response) {
        // Handle success response from the backend
        if (response == "success") {
          printWindo = window.open('printReceipt?invoice_no=' + invoice_no, 'WindowName', 'height=700,width=850');
        } else {
          alert(response)
        }

        $("#makeSaleConfirmed").removeAttr("disabled");
        buttonText.show();
        loaderContainer.hide();

      },
      error: function (xhr, status, error) {
        // Handle error response from the backend
        console.error("Error:", status, error);
      }
    });

  }

}

var checkPopupClosed = setInterval(function () {
  if (printWindo.closed) {
    // If the popup window is closed, reload the main window and clear the interval
    location.reload();
    clearInterval(checkPopupClosed);
  }
}, 1000);