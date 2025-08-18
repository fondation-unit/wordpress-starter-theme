// Add your custom JS here.
import lozad from 'lozad';
//import Swiper from 'swiper';

const observer = lozad('.lozad', {
    threshold: 0
});


($ => {
    /*Bouton pour remonter en haut de page*/
    $('body').append('<div id="back_top" class="bg-primary"><i class="fas fa-arrow-up text-white"></i></div>');
    $('#back_top').click(function () {
        $('html,body').animate({scrollTop: 0}, 'slow');
    });

    let width = $(window).width();
    $(window).scroll(function() {
        // If on top fade the bouton out, else fade it in
        if (0 === $(window).scrollTop()) {
            $('#back_top').fadeOut();
        } else {
            $('#back_top').fadeIn();
        }
    });

    $('.search-toggle').on('click', () => {
        $('.search-form-div').toggleClass('show');
    })



})(jQuery);
//const swiper = new Swiper('.mySwiper', {
//    spaceBetween: 30,
//    centeredSlides: true,
//    pagination: {
//        el: '.swiper-pagination',
//        clickable: true,
//        type: 'bullets'
//    }
//});
