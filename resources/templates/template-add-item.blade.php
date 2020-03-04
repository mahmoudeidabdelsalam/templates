{{--
  Template Name: item Publish
--}}

@php acf_form_head() @endphp

@extends('layouts.app')
@section('content')

@php 
  $args = array(
    'post_type' => 'product',
  );
  $loop = new WP_Query( $args );
  $count = $loop->found_posts;
  global $current_user;
  wp_get_current_user();
  $user = wp_get_current_user();
  $allowed_roles = array('vendor', 'administrator');
  $administrator = array('administrator');
@endphp

@if (get_field('banner_items_headline', 'option'))
<section class="banner-items mb-5" style="background-image: linear-gradient(150deg, {{ the_field('gradient_color_one','option') }} 0%, {{ the_field('gradient_color_two','option') }} 100%);">
  <div class="elementor-background-overlay" style="background-image: url('{{ the_field('banner_background_overlay','option') }}');"></div>
  <div class="container">
    <div class="row justify-content-center align-items-center text-center">
      <h2 class="col-12 text-white"><strong class="font-weight-600">{{ _e('Discover', 'premast') }} +{{  $count }}</strong> <span class="font-weight-300">{{ the_field('banner_items_headline','option') }}</span></h2>
      <p class="col-md-5 col-12 text-white font-weight-300">{{ the_field('banner_items_sub_headline','option') }}</p>
    </div>
  </div>
</section>
@endif
<div class="container single-product">
  @if(!is_user_logged_in())
    <div class="row justify-content-center m-0">
      <div class="publish">
        <div class="user-not-login">
          <h2>{{ _e('See what’s happening in the Premast right now', 'premast') }}</h2>
          <p>{{ _e('Join Pre Vendors today.', 'premast') }}</p>
          <a class="mt-2 login btn btn-blue" href="#" data-toggle="modal" data-target="#LoginUser">{{ _e('Log In', 'premast') }}</a>
        </div>
      </div>
    </div>
  @elseif (array_intersect($allowed_roles, $user->roles))
    @php

      if ( array_intersect($administrator, $user->roles)) {
          $status = 'publish';
      } else {
          $status = 'pending';
      }

      if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post") {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $short_description = $_POST["short_description"];
        $slide_gallery = $_POST["slide_gallery"];
        $prices = $_POST["prices"];
        $slide_type = $_POST["slide_type"];
        $slide_format = $_POST["slide_format"];
        $tags = $_POST['tags'];

        // $tags = array_map( 'intval', $tags );
        // $tags = array_unique( $tags );

        $cat = $_POST["main_scat"];
        $child = $_POST["sub_scat"];
        $children = $_POST["sub_child"];

        $slide_colors = $_POST["slide_colors"];
        $slide_number = $_POST["slide_number"];
        $slide_pages = $_POST["slide_pages"];
        $slide_date = $_POST["slide_date"];
        $ads_image = $_POST["ads_image"];
        $ads_link = $_POST["ads_link"];

        $product = wp_insert_post(array (
          'post_type' => 'product',
          'post_title' => $title,
          'post_content' => $description,
          'post_excerpt' => $short_description,
          'post_status' => $status,
          'post_author' => $current_user->ID,
          'tax_input' => array( 'product_cat' => array($cat, $child, $children), 'product_tag' => $tags),
          // 'tax_input' => array( 'product_tag' => $tags),
        ));
               
        $image_id = $_POST["thumbnail"];
        $gallery_id = $_POST["galler"];
        $file_url = $_POST["file_url"];
        $file_name = $_POST["file_name"];
        $downloads[] = array(
            'name' => $file_name,
            'file' => $file_url
        );

        if ($product) {
          update_field( 'field_5cr243sfsfcca58d1e19b', $slide_type, $product );
          update_field( 'field_5cr24wqtwe434343sfsfcca58d1e19b', $slide_format, $product );
          update_field( 'field_5ccca58d1e19b', $slide_gallery, $product );
          update_field( 'field_5ccca59b1e19c', $slide_colors, $product );
          update_field( 'field_5ccca5a81e19d', $slide_number, $product );
          update_field( 'field_5ccca5b61e19e', $slide_pages, $product );
          update_field( 'field_5ccca5b81e19f', $slide_date, $product );
          update_field( 'field_5d38deb18e564', $ads_image, $product );
          update_field( 'field_5d38dee58e565', $ads_link, $product );


          // wp_add_post_tags($product, $tags, 'product_tag');
          update_post_meta($product, '_regular_price', $prices);
          update_post_meta($product, '_price', $prices);
          update_post_meta($product, '_downloadable', 'yes');
          update_post_meta($product, '_virtual', 'yes');
          update_post_meta($product, '_downloadable_files', $downloads);
          update_post_meta( $product, '_product_image_gallery', $gallery_id);
          set_post_thumbnail($product, $image_id);
          update_post_meta($product, '_stock_status', 'instock', true);
          update_post_meta($product, '_visibility', 'visible', true);
          $link = get_permalink($product);
          wp_redirect($link);
        }
      } 
    // do_action('wp_insert_post', 'wp_insert_post');
    @endphp

    <form id="publish_product" name="new_post" method="post" action="" enctype="multipart/form-data">
      <div class="row justify-content-center m-0">
        
        <div class="col-md-8 col-12">
          <?php woocommerce_breadcrumb(); ?>
          <div class="input-group mb-5 mt-2 arrows right">
            <input type="text" name="title" class="form-control"  placeholder="Enter headline" required>
          </div>

          <div class="row ml-0 mr-0 mb-5 content-single pl-0 pr-0 pt-3">
            <div class="col-12">
              
              <label for="frontend-button" class="label-upload arrows right">
                <span class="images-files"></span>
                <img class="profile-pic" src="{{ get_theme_file_uri().'/dist/images/upload-image.png' }}">
                <span>{{ _e('upload your cover image here', 'premast') }}</span>
                <span>{{ _e('1104 × 944 pixels', 'premast') }}</span>
              </label>
              <div class="upload-form">
                <div class="form-group">
                  <input type="file" id="frontend-button"  class="files-thumbnail form-control"/>
                  <input name="thumbnail" value="" id="thumbnails" hidden required/>
                </div>
              </div>

              <div class="upload-gallery mt-5 mb-0">                
                <span>{{ _e('upload your gallery images here', 'premast') }}</span>
                <input type="button" value="Remove All Image" class="remove">
                <div class="input-group mb-3 mt-3">
                  <label class="frontend-gallery" for="frontend-gallery">
                    <img class="profile-gallery" src="{{ get_theme_file_uri().'/dist/images/upload-gallery.png' }}">
                  </label>
                  <div id="thumb-output"></div>  
                  <span class="gallery-files d-block"></span> 
                  <div class="custom-file">
                    <input type="text" id="frontend-gallery" hidden>
                    <input name="galler" value="" id="gallers" hidden/>
                  </div>
                </div>                    
              </div> 


              <div class="input-group mb-3">
                <input type="text" class="form-control" name="slide_gallery" placeholder="Embed Youtube or Slideshare URL">
              </div>

              <div class="product-infomation">
                <div id="tab-description">
                  <textarea class="form-control" name="description" placeholder="Add description" rows="5"></textarea>
                </div>
              </div> 
                                                               
            </div>
          </div>
        </div>

        <div class="summary entry-summary col-md-4 col-12 sidebar-shop">
          <div class="download-product price-input arrows left">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">{{ _e('Price', 'premast') }}</span>
              </div>
              <input type="number" name="prices" class="form-control" placeholder="$ 00.00">
              <div class="input-group-prepend">
                <span class="input-group-text">{{ _e('$', 'premast') }}</span>
              </div>
            </div>
            <textarea class="form-control" name="short_description" placeholder="Short description" rows="3" required></textarea>
          </div>
          
          <div class="ads-block">
            <div class="alert alert-light m-0 pt-2 pb-2 pl-0" role="alert">{{ _e('Add Ads Items', 'premast') }}</div>
            <label for="ads-button" class="label-ads">
              <span class="images-files"></span>
              <img class="ads-pic" src="{{ get_theme_file_uri().'/dist/images/upload-gallery.png' }}">
            </label>
            <div class="upload-form">
              <div class="form-group">
                <input type="file" id="ads-button"  class="files-ads form-control"/>
                <input name="ads_image" value="" id="ads" hidden/>
              </div>
            </div>

            <div class="input-group">
              <input type="text" name="ads_link" class="form-control" placeholder="@">
            </div>
          </div>

          <div class="input-group mb-4 mt-4">
            <label class="custom-download-label arrows left mb-0" for="upload_file">
              <div class="upload-response"></div>
              <img class="profile-download" src="{{ get_theme_file_uri().'/dist/images/upload.png' }}">
              <span class="name-files">{{ _e('upload your download file here', 'premast') }}</span>
              <span>{{ _e('Max size 1GB') }}</span>
            </label>
            <div class="custom-file d-none">
              <input type="file" id="upload_file" class="custom-file-input files-download"/>                
              <input name="file_url" value="" id="files_url" hidden required/>
              <input name="file_name" value="" id="files_name" hidden required/>
            </div>
          </div>
          <div class="box-taxonomy arrows left">
            <div class="loading small text-center" style="display:none;">
              <i class="fa fa-spinner fa-pulse"></i>
            </div>
            <?php
            $args = array(
              'taxonomy' => 'product_cat', 
              'name'=>'main_scat', 
              'hide_empty'=>1,
              'depth'=>1,
              'hierarchical'=> 1, 
              'show_count' => 0,
              'show_option_all'=>'Select Category'
            );
            wp_dropdown_categories( $args ); 
            ?>
            <select name="sub_scat" id="sub_scat" disabled="disabled" multiple>
              <option value="0" selected="selected">Sub Select</option>
            </select>
            <select name="sub_child" id="sub_child" disabled="disabled" multiple>
              <option value="0" selected="selected">Sub Select</option>
            </select>
            <?php 
              wp_dropdown_categories( array(
                'taxonomy'   => 'product_tag',
                'name'=>'tags', 
                'multiple'   => true,
                'walker'     => new Willy_Walker_CategoryDropdown(),
                'show_option_all'=>'selected tag...',
                'hide_empty' => false,
                'value_field'       => 'name',
              ));
            ?>
          </div> 

          <div class="box-information mt-5">
            <label for="">{{ _e('Other Information', 'premast') }}</label>
            <div class="input-group mb-3 slide-info">
              <input type="text" name="slide_type" class="form-control" placeholder="Compatible with">
            </div>
            <div class="input-group mb-3 slide-info">
              <input type="text" name="slide_format" class="form-control" placeholder="Enter Format of Slides">
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="slide_colors" placeholder="Number of Slides">
            </div>
            <div class="input-group mb-3">
              <select name="slide_number" id="">
                <option value="0" selected="selected">Animation</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
            <div class="input-group mb-3">
              <select name="slide_pages" id="">
                <option value="0" selected="selected">Vector</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
            <div class="input-group mb-3">
              <select name="slide_date" id="">
                <option value="0" selected="selected">Icons</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>                                
          </div>
          <p class="mt-t col-12">
            <input type="submit" value="publish" tabindex="6" id="submit" name="submit" />
          </p>
          <p class="error-field">
            <span id="error-headline" class="alert alert-danger" style="display:none;">{{ _e('Alert headline field input required (kindly check!)', 'premast') }}</span>
            <span id="error-thumb" class="alert alert-danger" style="display:none;">{{ _e('Alert image field input required (kindly check!)', 'premast') }}</span>
            <span id="error-description" class="alert alert-danger" style="display:none;">{{ _e('Alert description field input required (kindly check!)', 'premast') }}</span>
            <span id="error-file" class="alert alert-danger" style="display:none;">{{ _e('Alert file field input required (kindly check!)', 'premast') }}</span>
            <span id="error-category" class="alert alert-danger" style="display:none;">{{ _e('Alert category field input required (kindly check!)', 'premast') }}</span>
            <span id="error-tags" class="alert alert-danger" style="display:none;">{{ _e('Alert tags field input required (kindly check!)', 'premast') }}</span>
          </p>
        </div><!-- End Sidebar -->
      </div>  <!-- End row -->
		  <input type="hidden" name="action" value="new_post" />
      <?php wp_nonce_field( 'new-post' ); ?>
    </form>
  @else 
    <div class="row justify-content-center m-0">
      <div class="publish">
        <div class="user-not-login">
          <h2>{{ _e('See what’s happening in the Premast right now', 'premast') }}</h2>
          <p>{{ _e('Join Pre Vendors today.', 'premast') }}</p>
          <a class="mt-2 login btn btn-blue" href="#" data-toggle="modal" data-target="#LoginUser">{{ _e('Log In', 'premast') }}</a>
        </div>
      </div>
    </div>
  @endif
</div>

@if (array_intersect($allowed_roles, $user->roles))
  <script type = "text/javascript">
    jQuery(function($) {
      // Errors
      $('#submit').on('click', function(){
        if($('input[name="title"]').val() === ""){
          $("#error-headline").show();
        } else {
          $("#error-headline").hide();
        }
        if($('#thumbnails').val() === ""){
          $("#error-thumb").show();
        } else {
          $("#error-thumb").hide();
        }
        if($('textarea[name="short_description"]').val() === ""){
          $("#error-description").show();
        } else {
          $("#error-description").hide();
        }
        if($('#files_url').val() === ""){
          $("#error-file").show();
        } else {
          $("#error-file").hide();
        }
        if($('#main_scat').val() === ""){
          $("#error-category").show();
        } else {
          $("#error-category").hide();
        }
        if($('#tags').val() === ""){
          $("#error-tags").show();
        } else {
          $("#error-tags").hide();
        }                                     
      }); 

      $(".remove").click(function (e) {
        e.preventDefault();
        $('#gallers').val('');
        $('#thumb-output img').remove();
      });

      $('#main_scat').change(function(){
        var $mainsCat = $('#main_scat').val();
        $("#sub_scat").empty();
        $.ajax({
            url:"<?= admin_url( 'admin-ajax.php' ); ?>",       
            type:'POST',
            data:'action=get_sub_category&main_catids=' + $mainsCat,
            beforeSend: function () {
              $('.loading').show();
            },
            success:function(results){
              $("#sub_scat").removeAttr("disabled");      
              $("#sub_scat").append(results);
              $('.loading').hide();
            }
        });
    });

    $('#sub_scat').change(function(){
      var $sub_scat = $('#sub_scat').val();
      $("#sub_child").empty();
      $.ajax({
          url:"<?= admin_url( 'admin-ajax.php' ); ?>",       
          type:'POST',
          data:'action=get_sub_child&sub_scat=' + $sub_scat,
          beforeSend: function () {
            $('.loading').show();
          },
          success:function(results){
            $("#sub_child").removeAttr("disabled");      
            $("#sub_child").append(results);
            $('.loading').hide();
          }
      });
    });
    
    $('select').select2({
      theme: 'bootstrap4',
    });

    $('#tags').select2({
      theme: 'bootstrap4',
      tags: true,
    });
    
  });
  </script>
@endif

@endsection
