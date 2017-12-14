(function(){
    "use strict";

    var date = new Date();
    var year = date.getFullYear();

    $("#copyright").text(year);
    $(".navbar-nav a").smoothScroll();

}).call(this);