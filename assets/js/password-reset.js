$("#pasReTCd").click(function (e) { 
    e.preventDefault();
    let codeGiven = $("#codeGiven").val();
    let tk = $("#tk").val();

    $.ajax({
        type: "post",
        url: url(),
        data: {
            chackCode: "checkCode",
            codeGiven: codeGiven,
            tk: tk
        },
        dataType: "html",
        success: function (response) {
            if(response == "success"){
                
            }else{
                alert(response);
            }
        }
    });

});