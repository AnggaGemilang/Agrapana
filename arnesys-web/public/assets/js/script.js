function closeLoader(){
    $(".loader").hide()
    $("main").show()
    $("body").css("overflow-y", "auto")
}

function openLoader(){
    $(".loader").show()
    $("main").hide()
    $("body").css("overflow-y", "hidden")
}
