require([
    'jquery',
    'mage/mage',
    'rokanthemes/owl'
], function ($) {
    'use strict';

    jQuery(document).ready(function() {
        jQuery(".categories-owl").owlCarousel({
            autoPlay : true,
            items : 4,
            itemsDesktop : [1199,4],
            itemsDesktopSmall : [980,3],
            itemsTablet: [768,2],
            itemsMobile : [479,1],
            slideSpeed : 500,
            paginationSpeed : 500,
            rewindSpeed : 500,
            navigation : true,
            stopOnHover : true,
            pagination :false,
            scrollPerPage:true,
        });
    });
});
