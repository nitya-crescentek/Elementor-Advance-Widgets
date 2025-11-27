jQuery(document).ready(function ($) {

    var owl = $('.text-slider');
    owl.owlCarousel({
        items: 1,
        loop: true,
        margin: 10,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeInUp'
    });

    owl.on('changed.owl.carousel', function (event) {
        var currentItem = $(event.target).find('.owl-item').eq(event.item.index).find('.item');

        var newImage = currentItem.data('image');
        var newWidth = currentItem.data('width');
        var newMaxWidth = currentItem.data('max-width');
        var newHeight = currentItem.data('height');
        var newRadius = currentItem.data('radius');

        $('#slider-image').fadeOut(300, function () {
            $(this).attr('src', newImage)
                .css({
                    'width': newWidth,
                    'max-width': newMaxWidth,
                    'height': newHeight,
                    'border-radius': newRadius
                })
                .fadeIn(300);
        });
    });

});