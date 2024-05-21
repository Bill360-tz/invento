$("#changeCat").change(function (e) { 
    e.preventDefault();
    let cat = $("#changeCat").val();
    let priceBelow = $("#priceBelow").val();

    document.location = "sale?cat="+cat;
}); 

$("#priceBelowFetch").click(function (e) { 
    e.preventDefault();
    let cat = $("#changeCat").val();
    let priceBelow = $("#priceBelow").val();

    if(priceBelow == ""){
        document.location = "sale?cat="+cat;
    }else{
        document.location = "sale?cat="+cat+"&prB="+priceBelow;
    }
    
});