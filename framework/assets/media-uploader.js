(function ($) {
  // When the DOM is ready.
  $(function () {
    var thumbnail_upload; // variable for the wp.media file_frame

    // attach a click event (or whatever you want) to some element on your page
    $('#frontend-button').on('click', function (event) {
      event.preventDefault();
      if (thumbnail_upload) {
        thumbnail_upload.open();
        return;
      }
      thumbnail_upload = wp.media.frames.thumbnail_upload = wp.media({
        title: $(this).data('uploader_title'),
        button: {
          text: $(this).data('uploader_button_text'),
        },
        multiple: false // set this to true for multiple file selection
      });
      thumbnail_upload.on('select', function () {
        attachment = thumbnail_upload.state().get('selection').first().toJSON();
        $('#thumbnails').attr('value', attachment.id);
        $('.profile-pic').attr('src', attachment.url);
      });

      thumbnail_upload.open();
    });


    var ads_upload; // variable for the wp.media file_frame

    // attach a click event (or whatever you want) to some element on your page
    $('#ads-button').on('click', function (event) {
      event.preventDefault();
      if (ads_upload) {
        ads_upload.open();
        return;
      }
      ads_upload = wp.media.frames.ads_upload = wp.media({
        title: $(this).data('uploader_title'),
        button: {
          text: $(this).data('uploader_button_text'),
        },
        multiple: false // set this to true for multiple file selection
      });
      ads_upload.on('select', function () {
        attachment = ads_upload.state().get('selection').first().toJSON();
        $('#ads').attr('value', attachment.id);
        $('.ads-pic').attr('src', attachment.url);
      });

      thumbnail_upload.open();
    });





    var gallery_upload; // variable for the wp.media file_frame
    
    $('.frontend-gallery').on('click', function (event) {
      event.preventDefault();
      if (gallery_upload) {
        gallery_upload.open();
        return;
      }

      $('#thumb-output img').remove();
      

      gallery_upload = wp.media.frames.gallery_upload = wp.media({
        title: $(this).data('uploader_title'),
        frame: 'post',
        state: 'gallery-library',
        button: {
          text: $(this).data('uploader_button_text'),
        },
        multiple: true, // set this to true for multiple file selection
      });

      // when click Insert Gallery, run callback
      gallery_upload.on('update', function () {
        var library = gallery_upload.state().get('library');
        var images = [];
        var image_ids = [];

        library.map(function (image) {
          image = image.toJSON();
          images.push(image.url);
          image_ids.push(image.id);
          $('#thumb-output').append('<img class="thumb"  src="' + image.url + '" alt="" />');
          $('#gallers').attr('value', image_ids);
        });
      });

      gallery_upload.open();

    });




    var file_upload; // variable for the wp.media file_frame

    // attach a click event (or whatever you want) to some element on your page
    $('#upload_file').on('click', function (event) {
      event.preventDefault();
      if (file_upload) {
        file_upload.open();
        return;
      }
      file_upload = wp.media.frames.file_upload = wp.media({
        title: $(this).data('uploader_title'),
        button: {
          text: $(this).data('uploader_button_text'),
        },
        multiple: false // set this to true for multiple file selection
      });
      file_upload.on('select', function () {
        attachment = file_upload.state().get('selection').first().toJSON();
        
        $('#files_url').attr('value', attachment.url);
        $('#files_name').attr('value', attachment.filename);
        $('.name-files').html(attachment.filename);
      });

      file_upload.open();
    });


    var file_item; // variable for the wp.media file_frame

    // attach a click event (or whatever you want) to some element on your page
    $('#upload_item').on('click', function (event) {
      event.preventDefault();
      if (file_item) {
        file_item.open();
        return;
      }
      file_item = wp.media.frames.file_item = wp.media({
        title: $(this).data('uploader_title'),
        button: {
          text: $(this).data('uploader_button_text'),
        },
        multiple: false // set this to true for multiple file selection
      });
      file_item.on('select', function () {
        attachment = file_item.state().get('selection').first().toJSON();
        $('#file_item').attr('value', attachment.id);
        $('.name-files').html(attachment.filename);
      });

      file_item.open();
    });

  });

})(jQuery);