$("#editUser").click(function (e) {
    e.preventDefault();
    $(".hidd").show();
    $("#editUser").hide();
    $("#canEditUser").show();
    $(".disi").removeAttr("disabled");
    $(".disi").addClass("input-edit");
    $(".hidd").fadeIn();
});
$("#canEditUser").click(function (e) {
    e.preventDefault();
    $(".hidd").hide();
    $("#editUser").show();
    $("#canEditUser").hide();
    $(".disi").attr("disabled");
    $(".disi").removeClass("input-edit");
    // $(".hidd").fadeIn();
});

$("#saveEditisU").click(function (e) {
    e.preventDefault();
    let fullNAme = $("#fullNAme").val()
    let loginPhone = $("#loginPhone").val()
    let loginEmail = $("#loginEmail").val()
    let sPass = $("#sPass").val()
    let rPass = $("#rPass").val()
    let user_id = $("#user_id").val();
    var buttonText = $("#buttonTextxxx");
    var loaderContainer = $("#loaderContainerxxx");



    if (fullNAme == "") {
        inputEmpty("#fullNAme");
    } else if (loginPhone == "") {
        inputEmpty("#loginPhone")
    } else if (loginEmail == "") {
        inputEmpty("#loginEmail")
    } else {

        // $(this).attr("disabled", true);
        buttonText.hide();
        loaderContainer.show();
        if (sPass != rPass) {
            $("#ddsjd").fadeIn();
        } else {
            $.ajax({
                type: "post",
                url: url(),
                data: {
                    updateUserInfodd: "jhjlhg",
                    fullNAme: fullNAme,
                    loginPhone: loginPhone,
                    loginEmail: loginEmail,
                    sPass: sPass,
                    user_id: user_id
                },
                dataType: "html",
                success: function (response) {
                    if (response == 1) {
                        location.reload();
                    } else {
                        alert(response);
                    }
                    $("#saveEditisU").removeAttr("disabled");
                    buttonText.show();
                    loaderContainer.hide();
                }
            });
        }
    }
});

$("#deleteUser").click(function (e) {
    e.preventDefault();
    let hiddenName = $("#hiddenName").val();
    $("#deletedCatNam").html(hiddenName)
    $(".deleteUser").show();
});
$(".clossDeleteUsModel").click(function (e) {
    e.preventDefault();
    // let hiddenName = $("#hiddenName").val();
    // $("#deletedCatNam").html(hiddenName)
    $(".deleteUser").hide();
});

$("#deleteUser").click(function (e) {
    e.preventDefault();

});


$("#deleteUserConfirmed").click(function (e) {
    e.preventDefault();
    let hiddenId = $("#hiddenId").val();
    var buttonText = $("#buttonTextxx");
    var loaderContainer = $("#loaderContainerxx");

    // $(this).attr("disabled", true);
    buttonText.hide();
    loaderContainer.show();

    $.ajax({
        type: "post",
        url: url(),
        data: {
            deleteUser: "hbk",
            hiddenId: hiddenId
        },
        dataType: "html",
        success: function (response) {
            if (response == 1) {
                document.location = "setting";
            } else {
                alert(response);
            }
            $("#deleteUserConfirmed").removeAttr("disabled");
            buttonText.show();
            loaderContainer.hide();
        }
    });
});
$("#makeAdminConfirmed").click(function (e) {
    e.preventDefault();
    let hiddenId = $("#hiddenId").val();
    var buttonText = $("#buttonTexta");
    var loaderContainer = $("#loaderContainera");

    // $(this).attr("disabled", true);
    buttonText.hide();
    loaderContainer.show();
    $.ajax({
        type: "post",
        url: url(),
        data: {
            makeAdmin: "hbk",
            hiddenId: hiddenId
        },
        dataType: "html",
        success: function (response) {

            if (response == 1) {
                location.reload()
            } else {
                alert(response);
            }
            $("#makeAdminConfirmed").removeAttr("disabled");
            buttonText.show();
            loaderContainer.hide();
        }
    });
});
$("#unmakeAdminConfirmed").click(function (e) {
    e.preventDefault();
    let hiddenId = $("#hiddenId").val();
    var buttonText = $("#buttonTextc");
    var loaderContainer = $("#loaderContainerc");

    // $(this).attr("disabled", true);
    buttonText.hide();
    loaderContainer.show();

    $.ajax({
        type: "post",
        url: url(),
        data: {
            unmakeAdmin: "hbk",
            hiddenId: hiddenId
        },
        dataType: "html",
        success: function (response) {

            if (response == 1) {
                location.reload();
            } else {
                alert(response);
            }
            $("#unmakeAdminConfirmed").removeAttr("disabled");
            buttonText.show();
            loaderContainer.hide();
        }
    });
});

$("#makeAdminBtn").click(function (e) {
    e.preventDefault();
    $("#makekAdminNam").html($("#hiddenName").val())
    $(".makeAdmin").show();
});
$(".clossMakeUsModel").click(function (e) {
    e.preventDefault();
    // $("#makekAdminNam").html($("#hiddenName").val())
    $(".makeAdmin").hide();
});

$(document).ready(function () {
    if ($("#hiddenRole").val() == "1") {
        $("#unmakeAdminBtn").show()
    } else {
        $("#makeAdminBtn").show()
    }
});

$(("#unmakeAdminBtn")).click(function (e) {
    e.preventDefault();
    $("#unmakekAdminNam").html($("#hiddenName").val())
    $(".unmakeAdmin").show();
});
$((".clossunMakeUsModel")).click(function (e) {
    e.preventDefault();
    // $("#unmakekAdminNam").html($("#hiddenName").val())
    $(".unmakeAdmin").hide();
});