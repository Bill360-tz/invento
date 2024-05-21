$(document).ready(function () {
    $("#allSalesRev").DataTable();
});

function toSeason(season) {
    // alert(season)
    $.ajax({
        type: "post",
        url: url(),
        data: {
            setSeason: "setSeason",
            season: season
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

$("#today").click(function (e) {
    e.preventDefault();
    toSeason(this.id);
});

$("#weak").click(function (e) {
    e.preventDefault();
    toSeason(this.id);
});

$("#month").click(function (e) {
    e.preventDefault();
    toSeason(this.id);
});

$("#year").click(function (e) {
    e.preventDefault();
    toSeason(this.id);
});

$("#goCustomized").click(function (e) {
    e.preventDefault();
    $("#simpleSelectors").hide();
    $("#simpleSelectors").addClass('scale-s');
    $("#dateFilter").show();
  });
  $("#backToSimple").click(function (e) {
    e.preventDefault();
    $("#dateFilter").hide();
    $("#simpleSelectors").show();
  });

  $("#getCust").click(function (e) {
    e.preventDefault();
    // alert("hello")
    let start_date = $("#p_start").val()
    let end_date = $("#p_end").val()
  // alert(start_date)
    // valdation
    if (start_date == "") {
      inputEmpty("#p_start");
    } else if (end_date == "") {
      inputEmpty("#p_end")
    } else {
      $.ajax({
        type: "post",
        url: url(),
        data: {
          getCust: "getCust",
          start_date: start_date,
          end_date: end_date
        },
        dataType: "html",
        success: function (response) {
          if(response == "success"){
            location.reload();
          }else{
            alert(response);
          }
        }
      });
    }
  
  
  });
  
  function yearCust(year){
    // alert(year)
    $.ajax({
      type: "post",
      url: url(),
      data: {
        byYear: "hjshsdgf",
        year: year
      },
      dataType: "html",
      success: function (response) {
        if(response == "success"){
          location.reload()
        }else{
          alert(response);
        }
      }
    });
  }