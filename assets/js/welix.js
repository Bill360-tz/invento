let pendingMode = false;
function htmlSpecialCharsDecode(html) {
  var element = document.createElement("div");
  element.innerHTML = html;
  return element.innerText;
}
function numberFormat(number) {
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function phoneNumber(phoneNumber) {
  // Remove any non-digit characters from the phone number
  var digitsOnly = phoneNumber.replace(/\D/g, "");

  // Insert spaces after every three digits
  var formattedNumber = digitsOnly.replace(/(\d{3})(?=\d)/g, "$1 ");

  // Add the '+' sign back to the formatted number
  formattedNumberNew = "+" + formattedNumber;

  return formattedNumberNew;
}

function success(state = false) {
  if (state == true) {
    $(".outer_model").show();

    setTimeout(() => {
      $(".outer_model").hide();
      location.reload();
    }, 1000);
  } else {
    $(".outer_model").show();

    setTimeout(() => {
      $(".outer_model").hide();
    }, 1000);
  }
}
function url() {
  return "https://williamkimambo.azurewebsites.net/admin/functions/data-operation.php";
}

function inputEmpty(a) {
  $(a).addClass("input-error");
  $(a).attr("placeholder", "Please fill here");
}
function removeInputEmpty(a) {
  $(a).removeClass("input-error");
}

function onlyNumber(str) {
  var numericStr = str.replace(/[^0-9.-]/g, ""); // Remove non-numeric characters using regex
  var number = parseFloat(numericStr); // Parse the numeric string to a floating-point number
  return number;
}

function formatDate(inputString) {
  // Split the input string into date and time parts
  var [datePart, timePart] = inputString.split(" ");

  // Split the date part into year, month, and day
  var [year, month, day] = datePart.split("-");

  // Reassemble the date in the desired format
  var formattedDate = `${day}-${month}-${year}`;

  return formattedDate;
}

function getDate() {
  var currentDate = new Date();

  var year = currentDate.getFullYear();
  var month = currentDate.getMonth() + 1; // Month is zero-based, so add 1
  var day = currentDate.getDate();

  // Format the date as "YYYY-MM-DD"
  var formattedDate =
    year + "-" + addLeadingZero(month) + "-" + addLeadingZero(day);

 return formattedDate;
}
function addLeadingZero(number) {
  return number < 10 ? '0' + number : number;
}

function compareDates(userInput) {
  var userDate = new Date(userInput);

  var currentDate = new Date();
  
  if (userDate < currentDate) {
    return false;
  } else if (userDate > currentDate) {
    return true;
  } else {
    return false;
  }

}

function ensurePositive(number) {
  if (number < 0) {
      return -number; // Convert negative number to its positive counterpart
  }
  return number; // Number is already positive or zero, so return it as is
}








