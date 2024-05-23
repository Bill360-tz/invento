
$("#addUserTrigure").click(function (e) {
    e.preventDefault();
    $("#adduserModel").show()
});
$("#closAdduser").click(function (e) {
    e.preventDefault();
    $("#adduserModel").hide()
});

$("#saveNewUser").click(function (e) {
    e.preventDefault();
    let fName = $("#fName").val();
    let phone = $("#phone").val();
    let uEmail = $("#uEmail").val();
    let uSPass = $("#uSPass").val();
    let uRpass = $("#uRpass").val();
    let user_role = $("#user_role").val();

    var buttonText = $("#buttonText");
    var loaderContainer = $("#loaderContainer");

    if (fName == "") {
        inputEmpty("#fName")
    } else if (phone == "") {
        inputEmpty("#phone")
    } else if (uEmail == "") {
        inputEmpty("#uEmail")
    } else if (uSPass == "") {
        inputEmpty("#uSPass")
    } else if (uRpass == "") {
        inputEmpty("#uRpass")
    } else if (uSPass != uRpass) {
        $("#passM").fadeIn()
    } else {
        // $(this).attr("disabled", true);
        buttonText.hide();
        loaderContainer.show();
        $.ajax({
            type: "post",
            url: url(),
            data: {
                addNewUser: "dfshdgfj",
                phone: phone,
                fName: fName,
                uEmail: uEmail,
                uSPass: uSPass,
                user_role: user_role
            },
            dataType: "html",
            success: function (response) {
               
                if (response == 1) {
                    location.reload();
                } else {
                    alert(response);
                }
                $("#saveNewUser").removeAttr("disabled");
                buttonText.show();
                loaderContainer.hide();
            }
        });
    }
});

$("#editInfo").click(function (e) {
    e.preventDefault();
    $("#editInfo").hide();
    $("#cancelEditInfo").show();
    $(".disi").removeAttr("disabled");
    $(".disi").addClass("input-edit");
    $(".hidd").fadeIn();
});
$("#cancelEditInfo").click(function (e) {
    e.preventDefault();
    $("#cancelEditInfo").hide();
    $("#editInfo").show();
    // $(selector).attr(attributeName, value);   
    $(".disi").attr("disabled", '');
    $(".disi").removeClass("input-edit");
    $(".hidd").hide();
});

$("#saveEditisU").click(function (e) {
    e.preventDefault();
    let fullNAme = $("#fullNAme").val()
    let loginPhone = $("#loginPhone").val()
    let loginEmail = $("#loginEmail").val()
    let sPass = $("#sPass").val()
    let rPass = $("#rPass").val()

    var buttonText = $("#buttonTextX");
    var loaderContainer = $("#loaderContainerX");
    if (fullNAme == "") {
        inputEmpty("#fullNAme");
    } else if (loginPhone == "") {
        inputEmpty("#loginPhone")
    } else if (loginEmail == "") {
        inputEmpty("#loginEmail")
    } else {
        if (sPass != rPass) {
            $("#ddsjd").fadeIn();
        } else {
            // $(this).attr("disabled", true);
            buttonText.hide();
            loaderContainer.show();
            $.ajax({
                type: "post",
                url: url(),
                data: {
                    updateUserInfo: "jhjlhg",
                    fullNAme: fullNAme,
                    loginPhone: loginPhone,
                    loginEmail: loginEmail,
                    sPass: sPass
                },
                dataType: "html",
                success: function (response) {
                    if (response == 1) {
                       
                        location.reload();
                        $("#saveEditisU").removeAttr("disabled");
                        buttonText.show();
                        loaderContainer.hide();
                    } else {
                        alert(response);
                    }
                }
            });
        }
    }
});