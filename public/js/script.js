//===== jquery code for sidebar menu
$('.menu-item.has-submenu .menu-link').on('click', function (e) {
    e.preventDefault();
    if ($(this).next('.submenu').is(':hidden')) {
        $(this).parent('.has-submenu').siblings().find('.submenu').slideUp(200);
    }
    $(this).next('.submenu').slideToggle(200);
});

// mobile offnavas triggerer for generic use
$("[data-trigger]").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    var offcanvas_id = $(this).attr('data-trigger');
    $(offcanvas_id).toggleClass("show");
    $('body').toggleClass("offcanvas-active");
    $(".screen-overlay").toggleClass("show");

});

$(".screen-overlay, .btn-close").click(function (e) {
    $(".screen-overlay").removeClass("show");
    $(".mobile-offcanvas, .show").removeClass("show");
    $("body").removeClass("offcanvas-active");
});

// minimize sidebar on desktop

$('.btn-aside-minimize').on('click', function () {
    if (window.innerWidth < 768) {
        $('body').removeClass('aside-mini');
        $(".screen-overlay").removeClass("show");
        $(".navbar-aside").removeClass("show");
        $("body").removeClass("offcanvas-active");
    } else {
        // minimize sideber on desktop
        $('body').toggleClass('aside-mini');
        if ($('body').hasClass('aside-mini')) {
            localStorage.setItem("aside-minimize", "1");
        } else {
            localStorage.setItem("aside-minimize", "0");
        }
    }
});

//load sidebar status from localStorage
$(() => {
    const status = localStorage.getItem("aside-minimize");
    if (window.innerWidth >= 768) {
        if (status == "1") {
            $('body').addClass('aside-mini');
        }
    }
})
