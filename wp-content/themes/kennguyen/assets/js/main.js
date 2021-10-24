
$('.navbar-toggler').click(function(){
    $(this).toggleClass('toggle_menu');
    $(this).parents('body').toggleClass('active_menu');
    $('.modal-backdrop').hide();
});

// scroll add class
$(function() {
  var header = $("header");
  $(window).scroll(function() {    
      var scroll = $(window).scrollTop();
      if (scroll >= 50) {
          header.addClass("scrolled");
      } else {
          header.removeClass("scrolled");
      }
  });

});
  // $('form.on .toggle_content').hide();
$('.toggle_parent .toggle_btn').on('click', function (e) {
    $(this).closest(".toggle_parent").find(".on").removeClass('on').find('> .toggle_content').slideToggle();
    $(this).closest(".toggle_parent").toggleClass("on");
    $(this).closest(".toggle_parent").find('> .toggle_content').slideToggle(100);
    $(this).closest(".toggle_parent").siblings().removeClass('on').find('> .toggle_content').slideUp(100);
    e.preventDefault();
    e.stopPropagation()
});
  (function($) {
    $('#search-button').on('click', function(e) {
      if($('#header').hasClass('active_search')) {
        e.preventDefault();
        $('#header').removeClass('active_search')
        return false;
      }
    });
    
    $('#hide-search-input-container').on('click', function(e) {
      e.preventDefault();
      $('#header').addClass('active_search')
      return false;
    });
    
  })(jQuery);

  var scrollTop = $(".scrollTop");
  $(window).scroll(function() {
    var topPos = $(this).scrollTop();
    if (topPos > 100) {
      $(scrollTop).css("opacity", "1");

    } else {
      $(scrollTop).css("opacity", "0");
    }

  }); 
  $(scrollTop).click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 100);
    return false;
  }); // click() scroll top EMD
// --------------------------
// .slider
// ----------------------------
// $('.reviews .slider').slick({
//     infinite: true,
//     slidesToShow: 1,
//     speed: 800,
//     autoplay: true,
//     focusOnSelect: false,
//     // fade: true,
//     arrows: true,
//     // dots: true,
// });
$('.news .slider').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    focusOnSelect: false,
    autoplay: true,
    arrows: false,
    dots: true,
    responsive: [{
        breakpoint: 787,
        settings: {
            slidesToShow: 2,
        }
    },{
        breakpoint: 480,
        settings: {
            slidesToShow: 1,
            centerMode: true,
            centerPadding: '40px',
        }
    }]
});
$('.clients .slider').slick({
  infinite: true,
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  focusOnSelect: false,
  autoplay: true,
  arrows: true,
  dots: true,
  responsive: [{
      breakpoint: 787,
      settings: {
          slidesToShow: 2,
      }
  },{
      breakpoint: 480,
      settings: {
          slidesToShow: 2,
          centerMode: true,
          centerPadding: '0',
      }
  }]
});
$('.packaging .slider').slick({
  infinite: true,
  slidesToShow: 2,
  slidesToScroll: 1,
  autoplay: true,
  focusOnSelect: false,
  autoplay: true,
  arrows: true,
  dots: true,
  responsive: [{
      breakpoint: 480,
      settings: {
          slidesToShow: 1,
          centerMode: true,
          centerPadding: '40px',
      }
  }]
});

$('.product_detail .product_main').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  dots: false,
  fade: true,
  asNavFor: '.product_thum'
});
$('.product_detail .product_thum').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  asNavFor: '.product_main',
  dots: false,
  arrows: false,
  // centerMode: true,
  focusOnSelect: true,
});

/* -------------------------------
  video
  --------------------------------- */
  $('.video_production').each(function() {
    var src = $(this).find('iframe').attr('src');
    $(this).find('iframe').attr('data-src', src).attr('src', ' ');
    $(this).on('click', function() {
        $(this).addClass('show');
        $(this).find('iframe').show().attr('src', src);
        $(this).find('.img_bg').fadeOut(1500);
        // $(this).parents('.owl-item').siblings().find('.video_production').removeClass('show').find('iframe').hide().attr('src', '').siblings('.img_bg').fadeIn(1500);
    });
})

// height alqua
function MatchHeight() {
    $('.match')
      .matchHeight({})
    ;
  }
  $(document).ready(function() {
    MatchHeight(); 
  });

// fade in scroll animation
$(document).ready(function() {
    // Whenever the window is scrolled ... 
    $(window).scroll( function(){
        // Check the location of the object
        $('.fade-in').each( function(i){
            var bottom_of_object = $(this).offset().top + $(this).outerHeight();
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            
            // If the object is inside the window, fade it in!
            if( bottom_of_window > bottom_of_object ){
                $(this).animate({'opacity':'1'},1000);
            }
        }); 
    });
})

// video  show
var owl = $('.screenshot_slider').owlCarousel({
  loop: true,
  responsiveClass: true,
  nav: true,
  margin: 0,    
  autoplayTimeout: 4000,
  smartSpeed: 400,
  navText: ['&#8592;', '&#8594;'],
  responsive: {
      0: {
          items: 2,
      },
      600: {
          items: 3,
          center: true,
      }
  }
});

/****************************/

jQuery(document.documentElement).keydown(function (event) {  
  if (event.keyCode == 37) {
    owl.trigger('prev.owl.carousel', [400]);
  } else if (event.keyCode == 39) {
      owl.trigger('next.owl.carousel', [400]);
  }

});
$(".toggle-password").click(function() {
  $(this).toggleClass("show");
  var input = $(this).siblings('input');
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});