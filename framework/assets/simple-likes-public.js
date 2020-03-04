(function ($) {
  // Like and love

  var ajaxurl = sage.ajax_url;

  $(document).on('click', '.sl-button', function () {
    var button = $(this);
    var post_id = button.attr('data-post-id');
    var security = button.attr('data-nonce');
    var iscomment = button.attr('data-iscomment');
    var allbuttons;
    if (iscomment === '1') { /* Comments can have same id */
      allbuttons = $('.sl-comment-button-' + post_id);
    } else {
      allbuttons = $('.sl-button-' + post_id);
    }
    if (post_id !== '') {
      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          action: 'process_simple_like',
          post_id: post_id,
          nonce: security,
          is_comment: iscomment,
        },
        beforeSend: function () {
          $('#sl-loader').show();
        },
        success: function (response) {
          var icon = response.icon;
          allbuttons.html(icon);
          if (response.status === 'unliked') {
            var like_text = ajaxurl.like;
            allbuttons.prop('title', like_text);
            allbuttons.removeClass('liked');
          } else {
            var unlike_text = ajaxurl.unlike;
            allbuttons.prop('title', unlike_text);
            allbuttons.addClass('liked');
          }
          $('#sl-loader').hide();
        },
      });

    }
    return false;
  });


  $(document).on('click', '.sl-comment', function () {
    var button = $(this);
    var post_id = button.attr('data-post-id');
    var security = button.attr('data-nonce');
    var iscomment = button.attr('data-iscomment');
    var allbuttons;
    if (iscomment === '1') { /* Comments can have same id */
      allbuttons = $('.sl-comment-button-' + post_id);
    } else {
      allbuttons = $('.sl-comment-' + post_id);
    }
    if (post_id !== '') {
      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
          action: 'process_comments_like',
          post_id: post_id,
          nonce: security,
          is_comment: iscomment,
        },
        beforeSend: function () {
          $('#sl-loader').show();
        },
        success: function (response) {
          var icon = response.icon;
          var count = response.count;
          allbuttons.html(icon + count);
          if (response.status === 'unliked') {
            var like_text = ajaxurl.like;
            allbuttons.prop('title', like_text);
            allbuttons.removeClass('liked');
          } else {
            var unlike_text = ajaxurl.unlike;
            allbuttons.prop('title', unlike_text);
            allbuttons.addClass('liked');
          }
          $('#sl-loader').hide();
        },
      });

    }
    return false;
  });


})(jQuery);
