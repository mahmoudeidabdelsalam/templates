{{--
  Template Name: User Customer Download
--}}

@extends('layouts.app')

@section('content')

@if(!is_user_logged_in())
  <div class="container">
    <div class="row justify-content-center m-0">
      <div class="user-not-login">
        <h2>{{ _e('Join us and enjoy with this benefits', 'premast') }}</h2>
        <p>{{ _e('Join Premast today.', 'premast') }}</p>
        <a class="mt-2 login btn btn-blue" href="#" data-toggle="modal" data-target="#LoginUser">{{ _e('Log In', 'premast') }}</a>
      </div>
    </div>
  </div>
@else
  <section class="template-users">
        <?php
        $sort   = isset($_GET['sort']) ? $_GET['sort'] : 'DESC';
        $tabs   = isset($_GET['tabs']) ? $_GET['tabs'] : 'all';

        if ( ! defined( 'ABSPATH' ) ) {
          exit;
        }
        $downloads     = WC()->customer->get_downloadable_products();
        $has_downloads = (bool) $downloads;
        
        $product_ids = [];
        foreach ($downloads as $download) {
          $ids = $download['product_id'];
          $product_ids[] = $ids;
        }

        $somdn_download_history = get_posts(
          array(
            'fields' => 'ids',
            'posts_per_page' => -1,
            'post_type' => 'somdn_tracked',
            'meta_key' => 'somdn_user_id',
            'meta_value' => get_current_user_id(),
          )
        );

        $somdn_download_ids = array();
        foreach( $somdn_download_history as $somdn_history ) {
          $somdn_product = get_post_meta( $somdn_history, 'somdn_product_id', true);
          if ( ! in_array( $somdn_product, $somdn_download_ids ) ) {
            $somdn_download_ids[] = $somdn_product;
          }
        }


        $all_ids = array_merge($somdn_download_ids, $product_ids);
        $All = array(
          'post_type' => 'product',
          'posts_per_page' => -1,
          'post__in' => $all_ids,
          'order'   => $sort,
        );

        $Free = array(
          'post_type' => 'product',
          'posts_per_page' => -1,
          'post__in' => $somdn_download_ids,
          'order'   => $sort,
        );

        $Paid = array(
          'post_type' => 'product',
          'posts_per_page' => -1,
          'post__in' => $product_ids,
          'order'   => $sort,
        );


        $loop_all = new WP_Query( $All );
        $loop_free = new WP_Query( $Free );
        $loop_paid = new WP_Query( $Paid );
        
        ?>

        @if($all_ids)

          <div class="container-fiuld woocommerce customer-download">
            <div class="row justify-content-center">

              <div class="col-md-3 col-12 side-menu-user">
                <h2 class="headline text-primary">{{ _e('My Account', 'premast') }}</h2>
                @if (has_nav_menu('user_navigation'))
                  {!! wp_nav_menu(['theme_location' => 'user_navigation', 'container' => false, 'menu_class' => 'nav nav-pills flex-column flex-sm-row col-12', 'walker' => new NavWalker()]) !!}
                @endif
              </div>

              <div class="col-md-9 col-sm-12 pt-5 mt-5 pb-5">
                <div class="row justify-content-between">
                  <ul class="nav-downloads mb-5 list-inline nav nav-tabs border-0" id="myTab" role="tablist">
                    <li class="show-tabs list-inline-item">{{ _e('Show', 'premast') }}</li>
                    <li class="nav-item list-inline-item">
                      <a class="nav-link @if($tabs == 'all' || !$has_downloads) active @endif" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All</a>
                    </li>
                    @if($somdn_download_ids)
                      <li class="nav-item list-inline-item">
                        <a class="nav-link @if($tabs == 'free') active @endif" id="free-tab" data-toggle="tab" href="#free" role="tab" aria-controls="free" aria-selected="false">Free</a>
                      </li>
                    @endif
                    @if($has_downloads)
                      <li class="nav-item list-inline-item">
                        <a class="nav-link @if($tabs == 'paid') active @endif" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Paid</a>
                      </li>
                    @endif
                  </ul>
                  
                  @while(have_posts()) @php(the_post())
                    <div class="dropdown mr-1">
                      <button type="button" class="dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                        @if ($sort == 'DESC') {{ _e('Newest to oldest', 'premast')}} @else {{ _e('oldest to Newest', 'premast')}} @endif
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                        <a class="dropdown-item" href="{{ the_permalink() }}?sort=DESC">Newest to oldest</a>
                        <a class="dropdown-item" href="{{ the_permalink() }}?sort=ASC">oldest to Newest</a>
                      </div>
                    </div>
                  @endwhile
                </div>

                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade @if($tabs == 'all' || !$has_downloads) active show @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="item-columns row m-0">
                      @if($loop_all->have_posts())
                        @while($loop_all->have_posts()) @php($loop_all->the_post())
                          <div class="item-card col-md-4 col-sm-4 col-sx-6 col-12 grid-item mb-3">
                            <div class="card">
                              <div class="bg-white bg-images" style="background-image:url('{{ Utilities::global_thumbnails(get_the_ID(),'full')}}');min-height:155px;height:155px;">
                                <img src="{{ Utilities::global_thumbnails(get_the_ID(),'full')}}" class="card-img-top" alt="{{ the_title() }}">
                              </div>
                              <div class="card-body pt-2 pl-0 pr-0">
                                <a class="card-link" href="{{ the_permalink() }}">
                                  <h5 class="card-title font-weight-400">{{ wp_trim_words(get_the_title(), '5', ' ...') }}</h5>
                                </a>
                                <div class="review-and-download">
                                  <div class="review">
                                    <a class="card-link" href="{{ the_permalink() }}">
                                      <i class="fa fa-star" aria-hidden="true"></i>
                                      <span itemprop="reviewCount">{{ _e('Rate it', 'premast') }}</span>
                                    </a>
                                  </div>
                                  <div class="download" id="download-all-{{ get_the_ID() }}">
                                    <div class="card-link">
                                      <?php do_action( 'woocommerce_single_product_summary' ); ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>              
                          </div>

                          <script>
                            jQuery(function($) {
                              // Sharing fuctionality
                              $('#download-all-{{ get_the_ID() }} #somdn-form-submit-button').on('click', function () {
                                var post_id = {{ get_the_ID() }};
                                var post_event = "counterdownload";
                                var action = "counterdownload";
                                $.ajax({
                                  url: '<?php echo admin_url('admin-ajax.php'); ?>',
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
                          </script>
                        @endwhile
                        @php (wp_reset_postdata())
                      @endif
                    </div>
                  </div>
                  @if($somdn_download_ids)
                    <div class="tab-pane fade @if($tabs == 'free') active show @endif" id="free" role="tabpanel" aria-labelledby="free-tab">
                      <div class="item-columns row m-0">
                        @while($loop_free->have_posts()) @php($loop_free->the_post())
                          <div class="item-card col-md-4 col-sm-4 col-sx-6 col-12 grid-item mb-3">
                            <div class="card">
                              <div class="bg-white bg-images" style="background-image:url('{{ Utilities::global_thumbnails(get_the_ID(),'full')}}');min-height:155px;height:155px;">
                                <img src="{{ Utilities::global_thumbnails(get_the_ID(),'full')}}" class="card-img-top" alt="{{ the_title() }}">
                              </div>
                              <div class="card-body pt-2 pl-0 pr-0">
                                <a class="card-link" href="{{ the_permalink() }}">
                                  <h5 class="card-title font-weight-400">{{ wp_trim_words(get_the_title(), '5', ' ...') }}</h5>
                                </a>
                                <div class="review-and-download">
                                  <div class="review">
                                    <a class="card-link" href="{{ the_permalink() }}">
                                      <i class="fa fa-star" aria-hidden="true"></i>
                                      <span itemprop="reviewCount">{{ _e('Rate it', 'premast') }}</span>
                                    </a>
                                  </div>
                                  <div class="download" id="download-free-{{ get_the_ID() }}">
                                    <div class="card-link">
                                      <?php do_action( 'woocommerce_single_product_summary' ); ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>              
                          </div>

                          <script>
                            jQuery(function($) {
                              // Sharing fuctionality
                              $('#download-free-{{ get_the_ID() }} #somdn-form-submit-button').on('click', function () {
                                var post_id = {{ get_the_ID() }};
                                var post_event = "counterdownload";
                                var action = "counterdownload";
                                $.ajax({
                                  url: '<?php echo admin_url('admin-ajax.php'); ?>',
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
                          </script>
                        @endwhile
                        @php (wp_reset_postdata())
                      </div>                
                    </div>
                  @endif
                  @if($has_downloads)
                    <div class="tab-pane fade @if($tabs == 'paid') active show @endif" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                      <div class="item-columns row m-0">
                        @while($loop_paid->have_posts()) @php($loop_paid->the_post())
                          <div class="item-card col-md-4 col-sm-4 col-sx-6 col-12 grid-item mb-3">
                            <div class="card">
                              <div class="bg-white bg-images" style="background-image:url('{{ Utilities::global_thumbnails(get_the_ID(),'full')}}');min-height:155px;height:155px;">
                                <img src="{{ Utilities::global_thumbnails(get_the_ID(),'full')}}" class="card-img-top" alt="{{ the_title() }}">
                              </div>
                              <div class="card-body pt-2 pl-0 pr-0">
                                <a class="card-link" href="{{ the_permalink() }}">
                                  <h5 class="card-title font-weight-400">{{ wp_trim_words(get_the_title(), '5', ' ...') }}</h5>
                                </a>
                                <div class="review-and-download">
                                  <div class="review">
                                    <a class="card-link" href="{{ the_permalink() }}">
                                      <i class="fa fa-star" aria-hidden="true"></i>
                                      <span itemprop="reviewCount">{{ _e('Rate it', 'premast') }}</span>
                                    </a>
                                  </div>
                                  <div class="download" id="download-paid-{{ get_the_ID() }}">
                                    <div class="card-link">
                                      <?php do_action( 'woocommerce_single_product_summary' ); ?>
                                    </div>
                                  </div>
                                  <script>
                                    jQuery(function($) {
                                      // Sharing fuctionality
                                      $('#download-paid-{{ get_the_ID() }} #somdn-form-submit-button').on('click', function () {
                                        var post_id = {{ get_the_ID() }};
                                        var post_event = "counterdownload";
                                        var action = "counterdownload";
                                        $.ajax({
                                          url: '<?php echo admin_url('admin-ajax.php'); ?>',
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
                                  </script>
                                </div>
                              </div>
                            </div>              
                          </div>
                        @endwhile
                        @php (wp_reset_postdata())
                      </div>                  
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="container">
            <div class="row">
              <div class="woocommerce-Message woocommerce-Message--info text-center col-12 pt-5 pb-5 mb-5 mt-5">
                <a class="woocommerce-Button button" href="{{ the_field('link_page_login','option') }}">
                  <?php esc_html_e( 'Go shop', 'woocommerce' ); ?>
                </a>
                <?php esc_html_e( 'No downloads available yet.', 'woocommerce' ); ?>
              </div>
            </div>
          </div>
        @endif
  </section>

  @endif
@endsection