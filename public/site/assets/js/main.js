// "use strict";

// // ===Project===
// function projectMasonaryLayout() {
//     if ($('.masonary-layout').length) {
//         $('.masonary-layout').isotope({
//             layoutMode: 'masonry'
//         });
//     }
//     if ($('.post-filter').length) {
//         $('.post-filter li').children('.filter-text').on('click', function() {
//             var Self = $(this);
//             var selector = Self.parent().attr('data-filter');
//             $('.post-filter li').removeClass('active');
//             Self.parent().addClass('active');
//             $('.filter-layout').isotope({
//                 filter: selector,
//                 animationOptions: {
//                     duration: 500,
//                     easing: 'linear',
//                     queue: false
//                 }
//             });
//             return false;
//         });
//     }

//     if ($('.post-filter.has-dynamic-filters-counter').length) {
//         // var allItem = $('.single-filter-item').length;
//         var activeFilterItem = $('.post-filter.has-dynamic-filters-counter').find('li');
//         activeFilterItem.each(function() {
//             var filterElement = $(this).data('filter');
//             var count = $('.filter-layout').find(filterElement).length;
//             $(this).children('.filter-text').append('<span class="count">' + count + '</span>');
//         });
//     };
// }


// // ===Project===
// function projectMasonaryLayout1() {
//     if ($('.masonary-layout').length) {
//         $('.masonary-layout').isotope({
//             layoutMode: 'masonry'
//         });
//     }
//     if ($('.post-sub-filter').length) {
//         $('.post-sub-filter li').children('.filter-sub-text').on('click', function() {
//             var Self = $(this);
//             var selector = Self.parent().attr('data-filter');
//             $('.post-sub-filter li').removeClass('active');
//             Self.parent().addClass('active');
//             $('.filter-layout').isotope({
//                 filter: selector,
//                 animationOptions: {
//                     duration: 500,
//                     easing: 'linear',
//                     queue: false
//                 }
//             });
//             return false;
//         });
//     }

//     if ($('.post-sub-filter.has-dynamic-sub-filters-counter').length) {
//         // var allItem = $('.single-filter-item').length;
//         var activeFilterItem = $('.post-sub-filter.has-dynamic-sub-filters-counter').find('li');
//         activeFilterItem.each(function() {
//             var filterElement = $(this).data('filter');
//             var count = $('.filter-layout').find(filterElement).length;
//             $(this).children('.filter-sub-text').append('<span class="count">' + count + '</span>');
//         });
//     };
// }


// // Instance Of Fuction while Window Load event
// jQuery(window).on('load', function() {
//     (function($) {
//         projectMasonaryLayout ();
//         projectMasonaryLayout1 ();
        
//     })(jQuery);
// });
