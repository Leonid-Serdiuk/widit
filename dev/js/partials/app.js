//$('.navigation-wraper').css('height', $('.main-content').height() + 2);

$(document).ready(function () {
    fixed_header();

    $(window).on('resize', function () {
        if ( $(this).width() >= 980 && $('.navigation-wraper').hasClass('navigation-mobile'))
        {
            toogle_navigation_mobile($('#navigation_icon'));
        }
    })
});

function toogle_navigation_mobile(elem)
{
    elem.find('i').toggle();
    $('.navigation-wraper').toggleClass('navigation-mobile');
    $('.main-content').toggleClass('content-mobile');
}

$('#navigation_icon').off('click').click(function (e) {
    e.preventDefault();
    toogle_navigation_mobile($(this));
});

function fixed_header() {
    $(window).on('scroll', function (e) {
        if(this.pageYOffset >= 50 && $(this).width() < 980)
        {
            $('.header, .content').addClass('scroll');
        }
        else
        {
            $('.header, .content').removeClass('scroll');
        }
    });
}