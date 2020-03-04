import AOS from 'aos/dist/aos';
import WOW from '../../../../node_modules/wow.js/dist/wow';
import Slideout from '../../../../node_modules/slideout/dist/slideout';

export default {
  init() {
    // JavaScript to be fired on all pages

    AOS.init();

    $('[data-toggle="tooltip"]').tooltip();
    
    jQuery(document).ready(function ($) {
      //function to check if the .cd-image-container is in the viewport here
      // ...

      //make the .cd-handle element draggable and modify .cd-resize-img width according to its position
      $('.cd-image-container').each(function () {
        var actual = $(this);
        drags(actual.find('.cd-handle'), actual.find('.cd-resize-img'), actual);
      });

      //function to upadate images label visibility here
      // ...
    });

    //testimonails slider
    $('.single-item').slick({
      autoplay: true,
      dots: true,
      infinite: true,
      arrows: false,
      responsive: [
        {
          breakpoint: 767,
          settings: {
            dots: false,
            arrows: true,
          },
        },
      ],
    });

    $('.profile-dropdown').on('mouseenter', function () {
      // make sure it is not shown:
      if (!$(this).parent().hasClass('show')) {
        $(this).parent().addClass('show');
      }
    });

    $('body').click(function () {
      if ($('.profile-dropdown').parent().hasClass('show')) {
        $('.profile-dropdown').parent().removeClass('show');
      }
    });

    $('#imageGallery').lightSlider({
      gallery: true,
      item: 1,
      loop: true,
      thumbItem: 6,
      slideMargin: 0,
      enableDrag: false,
      currentPagerPosition: 'left',
      onSliderLoad: function (el) {
        $('.lightSlider').removeClass('cS-hidden');
        el.lightGallery({
          selector: '#imageGallery .lslide',
        });
      },
      responsive: [{
        breakpoint: 480,
        settings: {
          enableDrag: true,
          controls: false,
          thumbItem: 4,
        },
      }],
    });
    
    $('li.dropdown a').click(function (e) {
      e.preventDefault();
      var $this = $(this);
      var href = $this.attr('href');
      
      if (href === 'undefined') {
        return false;
      } else {
        window.location.href = href;
      }
    });

    if ($('.download-footer').length != 0) {
      var bottom = $('footer').offset().top;
      var top = $('.download-product').offset().top;
      $(window).on('scroll', function () {
        if ($(window).scrollTop() >= bottom - 1000) {
          $('.download-footer').removeClass('fixed-content');

        } else if ($(window).scrollTop() >= top + 100) {
          $('.download-footer').addClass('fixed-content');
        } else {
          $('.download-footer').removeClass('fixed-content');
        }
      });
    }

    if ($('.by-filter').length != 0) {
      if ($(window).width() > 960) {
        var $window = $(window);
        var $sidebar = $('.by-filter');
        var $sidebarHeight = $sidebar.innerHeight();
        var $footerOffsetTop = $('.content-info').offset().top - 200;
        var $sidebarOffset = $sidebar.offset();
        $window.scroll(function () {
          if ($window.scrollTop() > $sidebarOffset.top) {
            $sidebar.addClass('fixed');
          } else {
            $sidebar.removeClass('fixed');
          }
          if ($window.scrollTop() + $sidebarHeight > $footerOffsetTop) {
            $sidebar.css({ 'top': -($window.scrollTop() + $sidebarHeight - $footerOffsetTop) });
          } else {
            $sidebar.css({ 'top': '70px' });
          }
        });
      }
    }

    $('.button-close').click(function () {
      $('#search').toggleClass('active');
    });

    // $('.product-list').click(function () {
    //   $('.item-card').show(300);
    //   $('.item-card .bg-white').css('height', 'auto');
    //   $('.item-card .bg-white').css('min-height', '1px');
    //   $('.item-card .bg-white').removeClass('bg-images');

    //   $('.grid').masonry({
    //     itemSelector: '.grid-item',
    //   });
    // });

    var $grid = $('.grid').imagesLoaded(function () {
      // init Isotope after all images have loaded
      $grid.isotope({
        // options...
      });

      $('.grid-item').addClass('is-visible');
      $('.spinner').fadeOut('slow');
    });

    $(window).scroll(function () {
      if ($(window).scrollTop() >= 65) {
        $('.fixed-top-header').addClass('fixed-header');
        $('.navbar-banner-items').addClass('fixed-header');
        $('.header-block').addClass('fixed-header');
      }
      else {
        $('.fixed-top-header').removeClass('fixed-header');
        $('.navbar-banner-items').removeClass('fixed-header');
        $('.header-block').removeClass('fixed-header');
      }
    });

    $(window).scroll(function () {
      if ($(window).scrollTop() >= 200) {
        $('.product-child').addClass('sticky');
      }
      else {
        $('.product-child').removeClass('sticky');
      }

      if ($(window).scrollTop() >= 2000) {
        $('.product-child').removeClass('sticky');
      }

    });


    if ($('#menu').length != 0) {
      // eslint-disable-next-line no-undef
      var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': 320,
        'tolerance': 70,
      });

      // Toggle button
      document.querySelector('.toggle-button').addEventListener('click', function () {
        slideout.toggle();
      });
    }

    if ($('#menu_user').length != 0) {
      $('.menu-toggle').click(function () {
        $('#menu_user').slideToggle(700);
        $('body').toggleClass('is-open-user');
      });
    }

    $(function () {
      function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = 'expires=' + d.toUTCString();
        document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/';
      }

      $('#LimitDownload .cancel, #LimitDownload, #LimitDownload .btn-limit').on('click', function () {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        var hours = today.getHours();
        var minutes = today.getMinutes();
        if (dd < 10) {
          dd = '0' + dd
        }
        if (mm < 10) {
          mm = '0' + mm
        }
        if (minutes < 10) {
          minutes = '0' + minutes
        }
        if (hours < 10) {
          hours = '0' + hours
        }
        // eslint-disable-next-line no-redeclare
        var today = yyyy + '-' + mm + '-' + dd;

        // eslint-disable-next-line no-undef
        setCookie('lastview', today, 1000);

        $(this).find('#LimitDownload').addClass('is-hidden');
      });
    });

    $('.gallery-widgets').slick({
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 5,
      slidesToScroll: 5,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true,
          },
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });


    function drags(dragElement, resizeElement, container) {
      dragElement.on('mousedown vmousedown', function (e) {
        dragElement.addClass('draggable');
        resizeElement.addClass('resizable');

        var dragWidth = dragElement.outerWidth(),
          xPosition = dragElement.offset().left + dragWidth - e.pageX,
          containerOffset = container.offset().left,
          containerWidth = container.outerWidth(),
          minLeft = containerOffset + 10,
          maxLeft = containerOffset + containerWidth - dragWidth - 10;

        dragElement.parents().on('mousemove vmousemove', function (e) {
          var leftValue = e.pageX + xPosition - dragWidth;

          //constrain the draggable element to move inside its container
          if (leftValue < minLeft) {
            leftValue = minLeft;
          } else if (leftValue > maxLeft) {
            leftValue = maxLeft;
          }

          var widthValue = (leftValue + dragWidth / 2 - containerOffset) * 100 / containerWidth + '%';

          $('.draggable').css('left', widthValue).on('mouseup vmouseup', function () {
            $(this).removeClass('draggable');
            resizeElement.removeClass('resizable');
          });

          $('.resizable').css('width', widthValue);

          //function to upadate images label visibility here
          // ...

        }).on('mouseup vmouseup', function () {
          dragElement.removeClass('draggable');
          resizeElement.removeClass('resizable');
        });
        e.preventDefault();
      }).on('mouseup vmouseup', function () {
        dragElement.removeClass('draggable');
        resizeElement.removeClass('resizable');
      });
    }

    var wow = new WOW(
      {
        boxClass: 'wow',      // animated element css class (default is wow)
        animateClass: 'animated', // animation css class (default is animated)
        offset: 0,          // distance to the element when triggering the animation (default is 0)
        mobile: true,       // trigger animations on mobile devices (default is true)
        live: true,       // act on asynchronously loaded content (default is true)
        callback: function () {
          // the callback is fired every time an animation is started
          // the argument that is passed in is the DOM node being animated
        },
        scrollContainer: null,    // optional scroll container selector, otherwise use window,
        resetAnimation: true,     // reset animation on end (default is true)
      }
    );
    wow.init();

    $('document').ready(function () {
      $('.tab-slider--body').hide();
      $('.tab-slider--body:first').show();
    });

    $('.tab-slider--nav li').click(function () {
      $('.tab-slider--body').hide();
      var activeTab = $(this).attr('rel');
      $('#' + activeTab).fadeIn();
      if ($(this).attr('rel') == 'tab2') {
        $('.tab-slider--tabs').addClass('slide');
      } else {
        $('.tab-slider--tabs').removeClass('slide');
      }
      $('.tab-slider--nav li').removeClass('active');
      $(this).addClass('active');
    });

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
