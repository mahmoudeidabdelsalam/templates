{{--
  Template Name: item edit
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
      
      $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 'false';

      if ( array_intersect($administrator, $user->roles)) {
          $status = 'publish';
      } else {
          $status = 'publish';
      }

      if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "update_post" && $post_id != 'false') {
        
        $post = get_post($post_id);

        $title = $_POST["title"];
        $description = $_POST["description"];
        $short_description = $_POST["short_description"];
        $slide_gallery = $_POST["slide_gallery"];
        $prices = $_POST["prices"];
        $slide_type = $_POST["slide_type"];
        $slide_format = $_POST["slide_format"];
        $tags = $_POST['tags'];

        // dd($tags);
        // $tags = array_map( 'intval', $tags );
        // $tags = array_unique( $tags );

        $cat = $_POST["main_scat"];
        $child = $_POST["sub_scat"];
        $children = $_POST["sub_child"];

        $slide_colors = $_POST["slide_colors"];
        $slide_number = $_POST["slide_number"];
        $slide_pages = $_POST["slide_pages"];
        $slide_date = $_POST["slide_date"];
        $ads_image_update = $_POST["ads_image"];
        $ads_link_update = $_POST["ads_link"];

        $product = wp_update_post(array (
          'ID'           => $post_id,
          'post_type' => 'product',
          'post_title' => $title,
          'post_content' => $description,
          'post_excerpt' => $short_description,
          'post_status' => $status,
          'post_author' => $post->post_author,
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
          update_field( 'field_5d38deb18e564', $ads_image_update, $product );
          update_field( 'field_5d38dee58e565', $ads_link_update, $product );

          // wp_set_object_terms($product, $tags, 'product_tag');
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
    do_action('wp_update_post', 'wp_update_post');

      $post = get_post($post_id);
      // Data Products
      $gallery_images = get_post_meta( $post->ID, '_product_image_gallery', true);
      $price = get_post_meta( $post->ID, '_regular_price', true);
      $downloadable = get_post_meta( $post->ID, '_downloadable_files', true);

      $download = [];
      if($downloadable) {
        foreach($downloadable as $download) {
          $download = [
            "file" => $download["file"],
            "name" => $download["name"],
          ];
        }
      }

      // ACF
      $youtube = get_post_meta( $post->ID, 'slide_gallery', false, false);
      $slide_colors = get_post_meta( $post->ID, 'slide_colors', true );
      $slide_number = get_post_meta( $post->ID, 'slide_number', true );
      $slide_pages = get_post_meta( $post->ID, 'slide_pages', true );
      $slide_date = get_post_meta( $post->ID, 'slide_date', true );
      $slide_type = get_post_meta( $post->ID, 'slide_type', true );
      $slide_format = get_post_meta( $post->ID, 'slide_format', true );
      $ads_image = get_post_meta( $post->ID, 'ads_image', true );
      $ads_link = get_post_meta( $post->ID, 'ads_link', true );

    @endphp

    <form id="publish_product" name="update_post" method="post" action="" enctype="multipart/form-data">
      <div class="row justify-content-center mt-5 pt-5">
        <div class="col-12 mt-5 pt-5"></div>
        <div class="col-md-8 col-12">
          <div class="input-group mb-5 mt-2 arrows right">
            <input type="text" name="title" class="form-control" value="{{ html_entity_decode(get_the_title($post->ID)) }}" placeholder="Enter headline" required>
          </div>
          <div class="row ml-0 mr-0 mb-5 content-single pl-0 pr-0 pt-3">
            <div class="col-12">
              <label for="frontend-button" class="label-upload arrows right">
                <span class="images-files"></span>
                <img class="profile-pic" src="{{ Utilities::global_thumbnails($post->ID,'full') }}">
                <span>{{ _e('upload your cover image here', 'premast') }}</span>
                <span>{{ _e('1104 × 944 pixels', 'premast') }}</span>
              </label>
              <div class="upload-form">
                <div class="form-group">
                  <input type="file" id="frontend-button"  class="files-thumbnail form-control"/>
                  <input name="thumbnail" value="{{ get_post_thumbnail_id($post->ID) }}" id="thumbnails" hidden required/>
                </div>
              </div>
              <div class="upload-gallery mt-5 mb-0">                
                <span>{{ _e('upload your gallery images here', 'premast') }}</span>
                <input type="button" value="Remove All Image" class="remove">
                <div class="input-group mb-3 mt-3">
                  <label class="frontend-gallery" for="frontend-gallery">
                    <img class="profile-gallery" src="{{ get_theme_file_uri().'/dist/images/upload-gallery.png' }}">
                  </label>
                  <div id="thumb-output">
                    @php 
                      $ids_gallery =  explode( ',', $gallery_images );
                    @endphp
                    @foreach ( $ids_gallery as $id_gallery)
                      {!! wp_get_attachment_image( $id_gallery, array('150', '150'), "", array( "class" => "thumb" ) ) !!}
                    @endforeach
                  </div>  
                  <span class="gallery-files d-block"></span> 
                  <div class="custom-file">
                    <input type="text" id="frontend-gallery" hidden>
                    <input name="galler" value="{{ $gallery_images }}" id="gallers" hidden/>
                  </div>
                </div>                    
              </div> 
              <div class="input-group mb-3">
                @if ($youtube)
                  <input type="text" value="{{ $youtube['0'] }}" class="form-control" name="slide_gallery" placeholder="Embed Youtube or Slideshare URL">
                @else 
                  <input type="text" value="" class="form-control" name="slide_gallery" placeholder="Embed Youtube or Slideshare URL">
                @endif
              </div>
              <div class="product-infomation">
                <div id="tab-description">
                  <textarea class="form-control" name="description" placeholder="Add description" rows="5">{{ $post->post_content }}</textarea>
                </div>
              </div>                                            
            </div>
          </div>
        </div>


        <div class="summary entry-summary col-md-4 col-12 sidebar-shop mt-2">
          <div class="download-product price-input arrows left">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">{{ _e('Price', 'premast') }}</span>
              </div>
              <input type="number" value="{{ $price }}" name="prices" class="form-control" placeholder="$ 00.00">
              <div class="input-group-prepend">
                <span class="input-group-text">{{ _e('$', 'premast') }}</span>
              </div>
            </div>
            <textarea class="form-control" name="short_description" placeholder="Short description" rows="3" required>{{ $post->post_excerpt }}</textarea>
          </div>
          <div class="input-group mb-4 mt-4">
            <label class="custom-download-label arrows left mb-0" for="upload_file">
              <div class="upload-response"></div>
              <img class="profile-download" src="{{ get_theme_file_uri().'/dist/images/upload.png' }}">
              <span class="name-files">{{ $download['name'] }}</span>
              <span>{{ _e('Max size 1GB') }}</span>
            </label>
            <div class="custom-file d-none">
              <input type="file" id="upload_file" class="custom-file-input files-download"/>                
              <input name="file_url"  value="{{ $download['file'] }}" id="files_url" hidden required/>
              <input name="file_name" value="{{ $download['name'] }}" id="files_name" hidden required/>
            </div>
          </div>
          <div class="ads-block mb-3">
            <div class="alert alert-light m-0 pt-2 pb-2 pl-0" role="alert">{{ _e('Add Ads Items', 'premast') }}</div>
            <label for="ads-button" class="label-ads">
              <span class="images-files"></span>
              <img class="ads-pic" src="@if($ads_image) {{ wp_get_attachment_image_url($ads_image, 'full') }} @else {{ get_theme_file_uri().'/dist/images/upload-gallery.png' }} @endif">
            </label>
            <div class="upload-form">
              <div class="form-group">
                <input type="file" id="ads-button"  class="files-ads form-control"/>
                <input name="ads_image" value="@if($ads_image){{ $ads_image }}@endif" id="ads" hidden/>
              </div>
            </div>
            <div class="input-group">
              <input type="text" name="ads_link" value="@if($ads_link) {{ $ads_link }} @endif" class="form-control" placeholder="@">
            </div>
          </div>
          <div class="box-taxonomy arrows left">
            <div class="loading small text-center" style="display:none;">
              <i class="fa fa-spinner fa-pulse"></i>
            </div>
            <?php
              $terms = get_the_terms( $post->ID, 'product_cat' );
              $draught_terms= array();
              if ( $terms && ! is_wp_error( $terms ) ) : 
                foreach ( $terms as $term ) {
                  if( $term->parent == 0 ) {
                    $draught_terms[] = $term->term_id;
                  }
                }
              endif;
              $on_term = join( ", ", $draught_terms );
              $args = array(
                'taxonomy' => 'product_cat', 
                'name'=>'main_scat', 
                'selected'  => $on_term,
                'hide_empty'=>1,
                'depth'=>1,
                'hierarchical'=> 1, 
                'show_count' => 0,
              );
              wp_dropdown_categories( $args ); 
            ?>
            <?php 
              $children = get_post_child_list('product_cat', $post->ID);
            ?>
            <?php if($children): ?>
              <select name="sub_scat" id="sub_scat" multiple>
                <option value="0" selected="selected">Sub Select</option>
                <?php 
                  foreach ($children as $child_id): 
                  $child = get_term_by('id', $child_id, 'product_cat')
                  ?>
                  <option value="<?= $child->term_id; ?>" selected="selected"><?= $child->name; ?></option>
                <?php endforeach; ?>
              </select>
            <?php else: ?>
              <select name="sub_scat" id="sub_scat" disabled="disabled" multiple>
                <option value="0" selected="selected">Sub Select</option>
              </select>
          <?php endif; ?>
          <?php 
          $sub_children = get_post_childrdn('product_cat', $children, $post->ID); ?>
            <?php if ($sub_children): ?>
              <select name="sub_child" id="sub_child" multiple>
                <option value="0" selected="selected">Sub Select</option>
                <?php 
                  foreach ($sub_children as $child_id): 
                  $child = get_term_by('id', $child_id, 'product_cat')
                  ?>
                  <option value="<?= $child->term_id; ?>" selected="selected"><?= $child->name; ?></option>
                <?php endforeach; ?>
              </select>
            <?php else: ?>
              <select name="sub_child" id="sub_child" disabled="disabled" multiple>
                <option value="0" selected="selected">Sub Select</option>
              </select>
            <?php endif; ?>
              @php 
                $tags = wp_get_post_terms( $post->ID, 'product_tag' );
                $draught_tags = array();
                if ( $tags && ! is_wp_error( $tags ) ) : 
                  foreach ( $tags as $tag ) {
                      $draught_tags[] = $tag->name;
                  }
                endif;
              @endphp
            <?php 
              wp_dropdown_categories( array(
                'taxonomy'   => 'product_tag',
                'name'       =>'tags', 
                'multiple'   => true,
                'walker'     => new Willy_Walker_CategoryDropdown(),
                'selected'   => $draught_tags,
                'hide_empty' => false,
                'value_field'       => 'name',
              ));
            ?>
          </div> 

          <div class="box-information mt-5">
            <label for="">{{ _e('Other Information', 'premast') }}</label>

            <div class="input-group mb-3 slide-info">
              <input value="{{ $slide_type }}" type="text" name="slide_type" class="form-control" placeholder="Compatible with">
            </div>
            <div class="input-group mb-3 slide-info">
              <input value="{{ $slide_format }}" type="text" name="slide_format" class="form-control" placeholder="Enter Format of Slides">
            </div>
            <div class="input-group mb-3">
              <input value="{{ $slide_colors }}" type="text" class="form-control" name="slide_colors" placeholder="Number of Slides">
            </div>
            <div class="input-group mb-3">
              <select name="slide_number" id="">
                <option value="{{ $slide_number }}" selected="selected">Animation</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
            <div class="input-group mb-3">
              <select name="slide_pages" id="">
                <option value="{{ $slide_pages }}" selected="selected">Vector</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
            <div class="input-group mb-3">
              <select name="slide_date" id="">
                <option value="{{ $slide_date }}" selected="selected">Icons</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>                                
          </div>


          <p class="mt-t col-12">
            <input type="submit" value="Update" tabindex="6" id="submit" name="submit" />
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
		  <input type="hidden" name="action" value="update_post" />
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
