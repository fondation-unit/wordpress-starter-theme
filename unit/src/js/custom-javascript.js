// Add your custom JS here.
import lozad from 'lozad';

const observer = lozad();
observer.observe();


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
        $('.offcanvas-header .btn-close').trigger('click');
    });

    let height = $('body').height();
    $(document).ready(() => {
        reAdaptBg(height);
        let dataSrc = $('.custom-logo-link img').attr('data-src')
        $('.custom-logo-link img').attr('src', dataSrc);

        $('.second-level').each(function () {
            console.log('second');
            $('.field').each(function () {
                console.log('field');
                let input = $(this).find('input');
                if (input.is(':checked')) {
                    if (! $(this).parents('.accordion-collapse').hasClass('show')) {
                        $(this).parents('.accordion-collapse').addClass('show');
                    }
                    if (! $(this).closest('.accordion-collapse').hasClass('show')) {
                        $(this).closest('.accordion-collapse').addClass('show');
                    }
                    if ($(this).closest('.accordion-button').hasClass('collapsed')) {
                        $(this).closest('.accordion-button').attr('aria-expanded', true);
                        $(this).closest('.accordion-button').removeClass('collapsed');
                    }
                }

            });
        });
    });

    $('#recherche-out').keyup(function () {
        $('.search-facets #recherche').val($(this).val());
    });

    $('#search-text').submit(function (e) {
        e.preventDefault();
        let rech = $('#recherche-out').val();
        $('.search-facets #recherche').val(rech);
        $('form.search-facets').submit();
    });

    $('#tri-out').on('change', function () {
        let tri = $(this).val();
        $('.search-facets #tri').val(tri);
        $('form.search-facets').submit();
    });

    $('.first-input').on('click', function (e) {
        onValueChanged(e);
    });

    $('.btn-advanced ').on('click', function(e){
        e.preventDefault();
        $(this).toggleClass('active');
        if(!$('.search-cards .search-liste').hasClass('facets-hidden')){
            $('.search-cards .search-liste').addClass('facets-hidden').removeClass('col-md-8').addClass('col-md-12');
            $('.search-cards .search-aside').addClass('d-none');
        }else{
            $('.search-cards .search-liste').removeClass('facets-hidden').addClass('col-md-8').removeClass('col-md-12');
            $('.search-cards .search-aside').removeClass('d-none');
        }

    });


})(jQuery);

function reAdaptBg(height){
    if(height < 3000){
        jQuery('.both-bgs').css('background-position', "left 120%, right 300%");
        jQuery('.one-bg').css('background-position', "left 120%");
    }else{
        jQuery('.both-bgs').css('background-position', "left 35%, right 115%");
        jQuery('.one-bg').css('background-position', "left 35%");

    }
}

function onValueChanged(e) {
    e.stopPropagation();
}