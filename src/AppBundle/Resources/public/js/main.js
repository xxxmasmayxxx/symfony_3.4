$('.dropdown-menu a.dropdown-toggle').on('click', function() {
    if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
    }
    var $subMenu = $(this).next(".dropdown-menu");
    $subMenu.toggleClass('show');


    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $('.dropdown-submenu .show').removeClass("show");
    });


    return false;
});

$(".pagination-load").hide();

$(".pagination-button").click(function(){
    $(".pagination-load").animate({
        height: 'toggle'}, 2000
    );
    $(".pagination-button").hide();
});