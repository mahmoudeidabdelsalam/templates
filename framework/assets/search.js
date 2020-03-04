jQuery(document).ready(function ($) {

  // eslint-disable-next-line no-undef
  var ajaxurl = sage.ajax_url;

  $('#autoblogs').autocomplete({
    minChars: 3,
    noCache: true,
    serviceUrl: ajaxurl,
    type: 'POST',
    containerClass: 'autocomplete-blog',
    dataType: 'json',
    paramName: 'name',
    params: {
      action: 'get_refineblog_names',
    },
    beforeRender: function (container, suggestions) {
      container.find('.autocomplete-blog').each(function (i, suggestion) {
        $(suggestion).wrapInner('<div class="search-resulte"><h3>' + suggestions[i].value + '</h3></div>');
        // eslint-disable-next-line no-undef
        width = 100;
      });
    },
    onSearchStart: function () {
    },
  });

  // Sharing fuctionality
  $('.social-sharer a[data-network]').on('click', function () {
    var title = $(this).data('title'),
      url = $(this).data('url'),
      $network = $(this).data('network'),
      url_object = {
        facebook: 'https://facebook.com/sharer.php?u=' + encodeURIComponent(url) + '&t=' + encodeURIComponent(title),
        twitter: 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(title) + '&url=' + encodeURIComponent(url) + '',
        linkedin: 'https://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(url) + '&title=' + encodeURIComponent(title),
        addtoany: 'https://www.addtoany.com/share_save?linkurl=' + encodeURIComponent(url),
      };
    var
      width = 600,
      height = 300;
    var
      leftPosition,
      topPosition;
    leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
    topPosition = (window.screen.height / 2) - ((height / 2) + 50);
    var windowFeatures = 'status=no,height=' + height + ',width=' + width + ',resizable=yes,left=' + leftPosition + ',top=' + topPosition + ',screenX=' + leftPosition + ',screenY=' + topPosition + ',toolbar=no,menubar=no,scrollbars=no,location=no,directories=no';
    window.open(url_object[$network], 'sharer', windowFeatures);

    var post_id = $(this).data('id');
    var post_event = $(this).data('event');
    var action = $(this).data('action');
    $.ajax({
      url: ajaxurl,
      type: 'post',
      data: {
        action: action,
        event: post_event,
        post_id: post_id,
      },
      success: function (response) {
        $('.namber-share').html(response);
      },
    });
    return false;
  });

  // Sharing fuctionality
  $('#somdn-form-submit-button').on('click', function () {
    var post_id = $(this).data('id');
    var post_event = $(this).data('event');
    var action = $(this).data('action');
    $.ajax({
      url: ajaxurl,
      type: 'post',
      data: {
        action: action,
        event: post_event,
        post_id: post_id,
      },
      success: function (response) {
        $('.download-count').html(response);
      },
    });

  });

});