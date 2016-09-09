$(window).scroll(function() {
    if ($(".navbar").offset().top > 5) {
        $(".navbar-fixed-top").addClass("nav-scrolled");
        $(".navbar-fixed-top").removeClass("nav-unscrolled");
    } else {
        $(".navbar-fixed-top").removeClass("nav-scrolled");
        $(".navbar-fixed-top").addClass("nav-unscrolled");
    }
});