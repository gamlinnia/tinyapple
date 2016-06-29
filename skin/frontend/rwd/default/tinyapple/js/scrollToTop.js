jQuery(document).ready(function () {
    jQuery(window).scroll(function(event) {

        var threshold = jQuery(document).height() - jQuery(window).height() - jQuery('footer').height();
        if (jQuery(window).scrollTop() > jQuery(window).innerHeight() / 2) {
            jQuery('div.pagetopbtn img').css({
                opacity: 1
            });
            if (jQuery(window).scrollTop() >= threshold) {
                jQuery('#PageTopBtn').css({
                    top: "-46px",
                    right: "20px",
                    bottom: "auto",
                    position: "absolute"
                });
            } else {
                jQuery('#PageTopBtn').css({
                    top: "auto",
                    right: "20px",
                    bottom: "-9px",
                    position: "fixed"
                });
            }
        } else {
            jQuery('div.pagetopbtn img').css({
                opacity: 0
            });
        }
    });

    jQuery('div.pagetopbtn').click(function() {
        jQuery("html, body").animate({
            scrollTop: 0
        }, 500, 'swing');
    });
});
