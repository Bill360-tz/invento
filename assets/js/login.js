$("#loginWelix").click(function (e) { 
    e.preventDefault();
    
    const username = $("#username").val();
    const password = $("#password").val();

    if(username == ""){
        inputEmpty("#username");
    }else if(password == ""){
        inputEmpty("#password");
    }else{
        $.ajax({
            type: "post",
            url: url(),
            data: {
                loginUser: "loginUser",
                username: username,
                password: password
            },
            dataType: "html",
            success: function (response) {
                if(response === 1){
                    $("#noUser").hide();
                    $("#success").fadeIn();
                    setTimeout(() => {
                        document.location = "index";  
                    }, 600);
                   
                }else if(response === 2){
                    $("#noUser").fadeIn();
                }else{
                    alert(response);
                }
            }
        });
    }

});