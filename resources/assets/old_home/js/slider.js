// $(() => {
//   var createSlick = () => {
//     let slider = $(".slider");

//     slider.not(".slick-initialized").slick({
//       autoplay: false,
//       infinite: true,
//       dots: false,
//       slidesToShow: 1,
//       slidesToScroll: 1,
//       responsive: [
//         {
//           breakpoint: 1024,
//           settings: {
//             slidesToShow: 2,
//             slidesToScroll: 2,
//             adaptiveHeight: true
//           }
//         },
//         {
//           breakpoint: 600,
//           settings: {
//             slidesToShow: 1,
//             slidesToScroll: 1
//           }
//         }
//       ]
//     });
//   };

//   createSlick();

//   $(window).on("resize orientationchange", createSlick);
// });


$('.slider-for').slick({
   slidesToShow: 1,
   slidesToScroll: 1,
   arrows: false,
   fade: true,
   asNavFor: '.slider-nav'
 });
 $('.slider-nav').slick({
   slidesToShow: 1,
   slidesToScroll: 1,
   asNavFor: '.slider-for',
   dots: false,
   focusOnSelect: true
 });

 $('a[data-slide]').click(function(e) {
   e.preventDefault();
   var slideno = $(this).data('slide');
   $('.slider-nav').slick('slickGoTo', slideno - 1);
 });