$(document).ready(function () {
  $("#outstandingCustTable").DataTable();
});

//   ***********************
$("#viewTempsBtn").click(function (e) {
  e.preventDefault();
  if (onlyNumber($("#tempCountSpan").html()) < 1) {
    $("#tempCountSpan").addClass("text-red");
    setTimeout(() => {
      $("#tempCountSpan").removeClass("text-red");
    }, 2000);
  } else {
    $(".smsTempsModel").show();
  }
});

$(".closeTempsModel").click(function (e) {
  e.preventDefault();
  $(".smsTempsModel").hide();
});

$("#viewScheBtn").click(function (e) {
  e.preventDefault();
  if (onlyNumber($("#scheCountSpan").html()) < 1) {
    $("#scheCountSpan").addClass("text-red");
    setTimeout(() => {
      $("#scheCountSpan").removeClass("text-red");
    }, 2000);
  } else {
    showScheduled();
  }
});

$("#addTempsBtn").click(function (e) {
  e.preventDefault();
  $(".addTemplate").show();
});
$(".closeTemMode").click(function (e) {
  e.preventDefault();
  $(".addTemplate").hide();
  location.reload();
});

$("#saveSMSTemplate").click(function (e) {
  e.preventDefault();

  // validating the input
  let smsTarget = $("#smsTarget").val();
  let smsContent = $("#smsContent").val();
  let smsTitle = $("#smsTitle").val();

  if (smsTarget == "") {
    inputEmpty("#smsTarget");
  } else if (smsContent == "") {
    inputEmpty("#smsContent");
  } else if (smsTitle == "") {
    inputEmpty("#smsTitle");
  } else {
    $.ajax({
      type: "post",
      url: url(),
      data: {
        saveSMSTemplate: "saveSMSTemplate",
        smsTitle: smsTitle,
        smsTarget: smsTarget,
        smsContent: smsContent,
      },
      dataType: "html",
      success: function (response) {
        if (response == 1) {
          location.reload();
        } else {
          alert(response);
        }
      },
    });
  }
});

// Working with scheduled sms

let scheduledList = [];

$("#addSchediledList").click(function (e) {
  e.preventDefault();
  let tempSelected = $("#tempSelected").val();
  let sendDate = $("#sendDate").val();
  let sendTime = $("#sendTime").val();
  let tempSelectedText = $("#sel_" + tempSelected).text();

  //  validating the values
  if (tempSelected == "") {
    inputEmpty("#tempSelected");
  } else if (compareDates(sendDate) == false) {
    inputEmpty("#sendDate");
  } else if (sendTime == "") {
    inputEmpty("#sendTime");
  } else {
    removeInputEmpty("#tempSelected");
    removeInputEmpty("#sendDate");
    removeInputEmpty("#sendTime");
    $.ajax({
      type: "post",
      url: url(),
      data: {
        tempSelected: "tempSelected",
        temp_id: tempSelected,
        sendDate: sendDate,
        sendTime: sendTime,
        scheduled_type: "scheduled_type",
      },
      dataType: "html",
      success: function (response) {
        if (response == 1) {
          fetchSchdules();
        } else {
          alert(response);
        }
      },
    });
  }
});

function fetchSchdules() {
  $.ajax({
    type: "post",
    url: url(),
    data: {
      fetchSchdules: "fetchSchdules",
    },
    dataType: "json",
    success: function (response) {
      $("#newSchedules").empty();
      $.each(response, function (i, valueOfElement) {
        $("#newSchedules").append(
          ` <div class="flex flex-s-btn ">
            <div class="grid-2 fill">
                <div class="grid-2">
                <div class="">` +
          response[i]["date"] +
          `</div>
                <div>` +
          response[i]["time"] +
          `</div>
                </div>
                <div>` +
          response[i]["smsTitle"] +
          `</div>
            </div>
            <button onclick="removeSc('` +
          response[i]["scheduled_id"] +
          `')" title="Remove" class="btn-pri-o"><i class="fa fa-times" aria-hidden="true"></i></button>
        </div>`
        );
      });
    },
  });
}

function showScheduled() {
  fetchSchdules();

  $(".smsSchedulModel").show();
}

$("#addScheBtn").click(function (e) {
  e.preventDefault();
  $("#addScheBox").show();
  showScheduled();
});

$(".closeSceModel").click(function (e) {
  e.preventDefault();
  $(".smsSchedulModel").hide();
  $("#addScheBox").hide();
  location.reload();
});

function removeSc(aaa) {
  $.ajax({
    type: "post",
    url: url(),
    data: {
      deleteSch: "aaa",
      scheduled_id: aaa,
    },
    dataType: "html",
    success: function (response) {
      if (response == 1) {
        fetchSchdules();
      } else {
        alert(response);
      }
    },
  });
}

$("#addScTri").click(function (e) {
  e.preventDefault();
  $("#addScTri").hide();
  $("#addScheBox").show();
});

var targ_id;

function loadReqInfo(invo_id, cust_phone, cust_name, invoice_no) {

  targ_id = invoice_no;

  $.ajax({
    type: "post",
    url: url(),
    data: {
      fetchInvoInfo: "kj",
      invoice_id: invo_id,
    },
    dataType: "json", 
    success: function (response) {
      $("#cust_namexx").html(cust_name)
      $(".sideOnede").empty();
      $.each(response, function (i, value) {
        $(".sideOnede").append(
          `
          <div class="flex-c pad-10 shadow-sec bg-w">
          <h3 class="custInvonumber flex flex-s-btn fill theme-text pad-5 theme-border-b-2"> <span>Invoice </span> <span>` +
          response[i]["invoice_no"] +
          `</span></h3>
          <div class="custInvoBind flex-c fill ">
              <div class="fill grid-2 text-right pad-5">
                  <span>Invoice Date</span>
                  <span>` +
          formatDate(response[i]["invoice_date"]) +
          `</span>
              </div>
              <div class="fill grid-2 text-right pad-5">
                  <span>Total Price</span>
                  <span>` +
          numberFormat(response[i]["total_price"]) +
          `</span>
              </div>
              <div class="fill grid-2 text-right pad-5">
                  <span>Total Discount</span>
                  <span>` +
          numberFormat(response[i]["discount"]) +
          `</span>
              </div>
              <div class="fill grid-2 text-right pad-5">
                  <span>Amount Due</span>
                  <span>` +
          numberFormat(response[i]["amount_due"]) +
          `</span>
              </div>
          </div>
          <a style="display:none" href="payments?invo_id=`+ response[i]["invoice_no"] + `" class="fill btn-pri-o">See Payments</a>
          <div class="flex-c fill">
              <h4 class="theme-text fill pad-5 theme-border-b-1">Items</h4>
              <div class="flex-c fill">
              
                  <div class=" invoItems_` +
          response[i]["invoice_no"] +
          ` flex-c flex-s-btn pad-5 ">
                      
                  </div>
              </div>
          </div>
      </div>
          `
        );
        invoItems(response[i]["invoice_no"]);
        invoBalances(response[i]["invoice_no"], response[i]["amount_due"]);
        $('.generalWraper').hide();
        $('.individualWraper').show();
      });
    },
  });
}

$("#print_recipt").click(function (e) { 
  e.preventDefault();
  // alert(targ_id)

  printWindo = window.open('printReceipt?invoice_no=' + targ_id, 'WindowName', 'height=700,width=850');
});
$("#backToGenStat").click(function (e) {
  e.preventDefault();
  $('.individualWraper').hide();
  $('.generalWraper').show();
});

function invoItems(aaa) {
  $.ajax({
    type: "post",
    url: url(),
    data: {
      fetcInvoItems: "jkk",
      invoice_id: aaa,
    },
    dataType: "json",
    success: function (response) {
      $(".invoItems_" + aaa).empty();

      $.each(response, function (i, value) {
        $(".invoItems_" + aaa).append(
          `
            <div class="flex flex-s-btn fill">
            <span>` +
          response[i]["item_name"] +
          ` <span style="color:grey;">(` +
          response[i]["item_count"] +
          `)</span></span>
            <span>` +
          numberFormat(response[i]["item_price"]) +
          `</span>
            </div>
          `
        );
      });
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // Error callback - handle the failed request here
      console.error("Error:", errorThrown);
    },
  });
}

function invoBalances(aaa, bbb) {
  $.ajax({
    type: "post",
    url: url(),
    data: {
      fetchPaiAmount: "jkj",
      invoice_no: aaa,
    },
    dataType: "json",
    success: function (response) {
      // calculating amount paid
      let amoutPaid = 0,
        amoutPaidPerc = 0,
        outstandingBalance = 0,
        outstandingBalancePerc = 0;

      $.each(response, function (i, valueOfElement) {
        amoutPaid = amoutPaid + response[i]["paid_amount"];
      });
      amoutPaidPerc = (amoutPaid / Number(bbb)) * 100;

      amoutPaidPerc = amoutPaidPerc.toFixed(2);

      outstandingBalance = Number(bbb) - amoutPaid;

      outstandingBalancePerc = (100 - amoutPaidPerc).toFixed(2);

      // Appending to the view
      $(".balaBox").empty();

      $(".balaBox").append(`
        <div class="flex-c fill ">
          <div class="amountDue flex-c fill ">
              <div class="flex-c fill bg-w pad-10 shadow-sec">
                  <h3 class="theme-text fill pad-5">Amount Due</h3>
                  <div class="flex flex-s-btn fill pad-5 ">
                      <p class="balFigure font-two">`+ numberFormat(bbb) + `</p>
  
                  </div>
              </div>
            </div>
            <div class="amountDue flex-c fill ">
                <div class="flex-c fill bg-w pad-10 shadow-sec">
                    <h3 class="theme-text fill">Amount Paid</h3>
                    <div class="flex flex-s-btn fill pad-5 ">
                        <p id="paidAmount" class="balFigure font-two">`+ numberFormat(amoutPaid) + `</p>
                        <p class="balFigure font-two">`+ amoutPaidPerc + `%</p>
                    </div>
                </div>
            </div>
            <div class="amountDue flex-c fill">
                <div class="flex-c fill bg-w pad-10 shadow-sec">
                    <h3 class="theme-text fill">Outstanding Balance</h3>
                    <div class="flex flex-s-btn fill pad-5 ">
                        <p id="paidAmount" class="balFigure font-two">`+ numberFormat(outstandingBalance) + `</p>
                        <p class="balFigure font-two">`+ outstandingBalancePerc + `%</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
        `);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // Error callback - handle the failed request here
      console.error("Error:", errorThrown);
    },
  });
}

function deleteInvo(invo_id, invoice_no) {
  $("#deletedCatNam").html(invoice_no)
  $("#delete_cat_id").val(invo_id)
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
      deleteInvo: "deleteCat",
      invoice_id: delete_ex_id
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
          if (response == 1) {
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