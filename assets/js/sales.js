

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

$("#bestProShow").click(function (e) {
  e.preventDefault();
  let best_target = this.id;

  $("." + best_target).toggle()
});
$("#bestCatShow").click(function (e) {
  e.preventDefault();
  let best_target = this.id;

  $("." + best_target).toggle()
});
$("#slowProShow").click(function (e) {
  e.preventDefault();
  let best_target = this.id;

  $("." + best_target).toggle()
});
$("#slowCatShow").click(function (e) {
  e.preventDefault();
  let best_target = this.id;

  $("." + best_target).toggle()
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
      if (response == 1) {
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

$(document).ready(function () {
  $.ajax({
    url: url(), // Replace with the actual path to your PHP script
    method: 'post',
    data: {
      fetchTop: "fetchTop"
    },
    dataType: 'json',
    success: function (data) {
      // alert(data)
      var productNames = [];
      var salesCounts = [];

      data.forEach(function (item) {
        productNames.push(item.item_name);
        salesCounts.push(item.frequency);
      });

      var ctx = document.getElementById('barChart_salesUnit').getContext('2d');
      var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: productNames,
          datasets: [{
            label: 'Sales Count',
            data: salesCounts,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    },
    error: function (xhr, status, error) {
      // alert(error)
      console.error('Error: ' + error);
    }
  });
});

//  ************* For PieChart **************
$(document).ready(function () {
  $.ajax({
    url: url(), // Replace with the actual path to your PHP script
    method: 'post',
    data: {
      fetchTopReve: "fetchTopReve"
    },
    dataType: 'json',
    success: function (data) {
      // alert(data)
      var productNames = [];
      var sales = [];

      data.forEach(function (item) {
        productNames.push(item.item_name);
        sales.push(item.frequency);
      });
      // Create the pie chart
      var ctx = document.getElementById("barChart_revenueByUnit").getContext("2d");
      var myPieChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: productNames,
          datasets: [{
            data: sales,
            backgroundColor: [
              "rgba(75, 192, 192, 0.2)",
              "rgba(255, 99, 132, 0.2)",
              "rgba(255, 205, 86, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(153, 102, 255, 0.2)",
              "rgba(255, 159, 64, 0.2)",
              "rgba(255, 99, 132, 0.2)",
              "rgba(75, 192, 192, 0.2)",
              "rgba(255, 205, 86, 0.2)",
              "rgba(54, 162, 235, 0.2)",
            ],
            borderColor: [
              "rgba(75, 192, 192, 1)",
              "rgba(255, 99, 132, 1)",
              "rgba(255, 205, 86, 1)",
              "rgba(54, 162, 235, 1)",
              "rgba(153, 102, 255, 1)",
              "rgba(255, 159, 64, 1)",
              "rgba(255, 99, 132, 1)",
              "rgba(75, 192, 192, 1)",
              "rgba(255, 205, 86, 1)",
              "rgba(54, 162, 235, 1)",
            ],
            borderWidth: 1,
          },],
        },
      });



    },
    error: function (xhr, status, error) {
      // alert(error)
      console.error('Error: ' + error);
    }
  });
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
        if(response == 1){
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
      if(response == 1){
        location.reload()
      }else{
        alert(response);
      }
    }
  });
}