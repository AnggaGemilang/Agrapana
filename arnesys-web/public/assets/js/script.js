"use strict";
(function () {
    var isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;

    if (isWindows) {

        if (document.getElementsByClassName('sidenav')[0]) {
            var sidebar = document.querySelector('.sidenav');
            var ps1 = new PerfectScrollbar(sidebar);
        };

    };
})();

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
