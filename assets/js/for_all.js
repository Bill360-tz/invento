// script.js
$("#notfyBtn").mouseover(function (e) {
  e.preventDefault();
  $("#notifyContainer").toggle();
  $(".alert-circle").hide();
});
document.addEventListener("DOMContentLoaded", function () {
  // var notfyBtn = document.getElementById("notfyBtn");
  // var notifyContainer = document.getElementById("notifyContainer");

  // notfyBtn.addEventListener("click", function () {
  //   // Toggle the visibility of the dropdown container
  //   if (notifyContainer.style.display === "none") {
  //     notifyContainer.style.display = "block";
  //   } else {
  //     notifyContainer.style.display = "none";
  //   }
  // });

  document.addEventListener("click", function (event) {
    var target = event.target;
    // Check if the click target is inside the dropdown container or the button
    if (target !== notifyContainer && target !== notfyBtn) {
      // Hide the dropdown container if the click is outside the dropdown and button
      notifyContainer.style.display = "none";
    }
  });
});

// script.js
document.addEventListener("DOMContentLoaded", function () {
  var profileBtn = document.getElementById("profileBtn");
  var profileDropDown = document.getElementById("profileDropDown");

  profileBtn.addEventListener("click", function () {
    // Toggle the visibility of the dropdown container
    if (profileDropDown.style.display === "none") {
      profileDropDown.style.display = "block";
    } else {
      profileDropDown.style.display = "none";
    }
  });

  document.addEventListener("click", function (event) {
    var target = event.target;
    // Check if the click target is inside the dropdown container or the button
    if (target !== profileDropDown && target !== profileBtn) {
      // Hide the dropdown container if the click is outside the dropdown and button
      profileDropDown.style.display = "none";
    }
  });
});

// $("#custLink").click(function (e) {
//   e.preventDefault();
//   $(".subLinks").hide();
//   // $(".subLinks").removeClass("theme-bg");
//   $("." + this.id).toggle();
// });
// $("#stockLink").click(function (e) {
//   e.preventDefault();
//   $(".subLinks").hide();
//   // $(".subLinks").removeClass("theme-bg");
//   $("." + this.id).toggle();
// });
// $("#saleLink").click(function (e) {
//   e.preventDefault();
//   $(".subLinks").hide();
//   alert(this.id);
//   // $(".subLinks").removeClass("theme-bg");
//   $("." + this.id).toggle();
// });
