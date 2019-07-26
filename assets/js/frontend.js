jQuery(function($) {

    "use strict";

    /* Off Canvas Product Filter */
    $('.canvas-filter-open').on('click', function(){
        $(".filter-overlay").addClass('open');
        $(".canvas-filter-left").addClass('open');
        $(".canvas-filter-right").addClass('open');
    });

    $('.filter-overlay').on('click', function(){
        $(".canvas-filter-left").removeClass("open");
        $(".canvas-filter-right").removeClass("open");
        $(".filter-overlay").removeClass("open");
    });

    /* Add Expand/Collapse Button after widget title */
    $('.filter-button').on('click', function(){
        var $this = $(this);
        $this.siblings('.woo-product-filter-list').toggle();
        $this.children('.fa').toggleClass("fa-chevron-up fa-chevron-down");
    });

    /* Add horizon filter button*/
    $('.horizon-filter-button').on('click', function(){
        var $this = $(this);
        $this.children('.fa').toggleClass("fa-chevron-up fa-chevron-down");
        $('.horizon-woo-product-filter').toggle();
    });

});
