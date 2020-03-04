@extends('layouts.app')

@section('content')


  @while(have_posts()) @php the_post() @endphp
    @php
    do_action( 'woocommerce_before_single_product' );
    if ( post_password_required() ) {
      echo get_the_password_form(); // WPCS: XSS ok.
      return;
    };
    global $product;
    @endphp

    @php 
      global $current_user;
      wp_get_current_user();

      $limit = somdn_has_user_reached_limit(get_the_ID(), $current_user->ID);

      $limit_membership = wc_memberships_get_user_active_memberships($current_user->ID);

      $author = get_the_author_meta('ID');

    @endphp

    <div id="product-{{ the_ID() }}" {!! wc_product_class() !!}>
      <div class="container custom-container mt-5 mb-5 pt-5">
        <div class="row justify-content-center m-0">
          <div class="col-12">
            <?php woocommerce_breadcrumb(); ?>
            <br>
            <h1 class="product-title">{{ the_title() }}</h1>
          </div>

          <div class="col-md-8 col-12">
            
            <div class="row ml-0 mr-0 mb-5 content-single">
              <div class="col-12">
                @php
                  do_action( 'woocommerce_before_single_product_summary' );
                @endphp
                @php  
                  $attachment_ids = $product->get_gallery_image_ids();
                @endphp                         
                @if ($attachment_ids)
                <ul id="imageGallery" class="cS-hidden">
                  @foreach( $attachment_ids as $attachment_id ) 
                    <li data-thumb="{{ wp_get_attachment_url( $attachment_id ) }}" data-src="{{ wp_get_attachment_url( $attachment_id ) }}">
                      <img src="{{ wp_get_attachment_url( $attachment_id )}}" />
                    </li>
                  @endforeach
                </ul>
                @else 
                  <img src="{{ Utilities::global_thumbnails(get_the_ID(),'full')}}" class="card-img-top" alt="{{ the_title() }}"> 
                @endif
                @if ( !wp_is_mobile() ) 
                  @if (get_field('slide_gallery'))
                    <div class="embed-container">
                      {{ the_field('slide_gallery') }}
                    </div>
                  @endif

                  <div class="product-infomation">
                    <h3>{{ _e('Description', 'premast') }}</h3>
                    <div id="tab-description"> @php the_content() @endphp</div>
                  </div>
                @endif
              </div>
            </div>
            @if ( !wp_is_mobile() ) 
              @include('partials/incloud/comments')
            @endif
          </div>
          
          <div class="summary entry-summary col-md-4 col-12 sidebar-shop">
            <div class="download-product">

              @php 
                $price = get_post_meta( get_the_ID(), '_regular_price', true);
                $sale = get_post_meta( get_the_ID(), '_sale_price', true);
                $symbol = get_woocommerce_currency_symbol();
                $excerpt = get_the_excerpt();

                global $product;
                $product_id = $product->get_id();

                $in_cart = false;
                
                foreach( WC()->cart->get_cart() as $cart_item ) {
                  $product_in_cart = $cart_item['product_id'];
                  if ( $product_in_cart === $product_id ) $in_cart = true;
                }
              @endphp

              

              @if($sale)
                <p class="price">
                  <del>
                    <span class="woocommerce-Price-amount amount">{{ $price }}<span class="woocommerce-Price-currencySymbol">{!! $symbol !!}</span></span>
                  </del> 
                  <span>
                    <span class="woocommerce-Price-amount amount">{{ $sale }}<span class="woocommerce-Price-currencySymbol">{!! $symbol !!}</span></span>
                  </span>
                </p>
              @elseif($price)
                <p class="price">
                  <span>
                    <span class="woocommerce-Price-amount amount">{{ $price }}<span class="woocommerce-Price-currencySymbol">{!! $symbol !!}</span></span>
                  </span> 
                </p>
              @else 
                <p class="price">{{ _e('Free version', 'premast') }}</p>
              @endif

              <div class="short-description">
                <p class="text-description">{!! $excerpt !!}</p>
              </div>

              {!! get_simple_likes_button( get_the_ID() ) !!}


              @php 
                $membership_user = $current_user->ID;
                $count_download = somdn_get_user_downloads_count( $membership_user );
                $download_limits = somdn_get_user_limits( $membership_user );
                $limits_amount = $download_limits['amount'];
                $time = get_the_time('Y-m-d');

                // dd($_COOKIE['lastview']);
              @endphp
              <div class="custom-summary">            
                @if ($limit && !$limit_membership && !$sale && !$price || $count_download == $limits_amount && !$sale && !$price) 
                  @if(get_field('link_limit', 'option'))
                    <div class="bottom-summary col-12 mt-4 mb-4 w-100">
                      <a class="btn-limit" href="{{ get_field('link_limit', 'option') }}" id="somdn-form-submit-button">{{ _e('Download Now', 'premast') }}</a>  
                    </div>
                    @if($time > $_COOKIE['lastview'])
                      <div class="modal" tabindex="-1" role="dialog" id="LimitDownload" >
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-body">
                              <img src="{{ get_theme_file_uri().'/resources/assets/images' }}/laptop.png" alt="Upgrade Your Plan">
                              <h3>{{ _e('You have reached your download limit for today!', 'premast') }}</h3>
                              <h5 class="modal-title">{{ _e('you can come back tomorrow to enjoy 2 more downloads, or upgrade plan for unlimited downloads!', 'premast') }}</h5>
                              <p><a class="btn-limit" href="{{ get_field('link_pricing', 'option') }}">{{ _e('Upgrade Your Plan', 'premast') }}</a>  </p>
                              <p><a class="cancel" href="#" class="close" data-dismiss="modal" aria-label="Close">{{ _e('cancel', 'premast') }}</a></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <script>
                        jQuery(function($) {
                          $('#LimitDownload').modal('show')
                        });
                      </script>
                    @endif

                  @endif
                @else 
                  @if ($in_cart) 
                  @php $link = wc_get_cart_url(); @endphp
                    <p class="full-access">
                      <a href="{{ $link }}">{{ _e('view cart', 'premast') }}</a>
                    </p>
                  @else
                    @php  
                      do_action( 'woocommerce_single_product_summary' );
                    @endphp
                  @endif
                  @if($price != 0)
                    <p class="full-access">
                      <span>{{ _e('OR', 'premast') }}</span>
                      <a href="{{ the_field('link_pricing', 'option') }}">{{ _e('Get Full Access', 'premast') }}</a>
                    </p>
                  @endif
                @endif
              </div>

              @if(current_user_can( 'edit_post', get_the_ID() ) && (get_the_author_meta('ID') == $current_user->ID) || is_super_admin())
                <p class="mb-0 mb-0 text-primary text-center p-2 bottun-edit"><a href="{{ the_field('link_edit_item', 'option') }}?post_id={{ the_ID() }}">{{ _e('edit Product') }}</a></p>
              @endif

              @if ( !is_user_logged_in() && $price == 0)
                <a class="mt-3 login" href="#" data-toggle="modal" data-target="#LoginUser">{{ _e('Login to Download Now', 'premast') }}</a>
              @endif

              @if($price != 0)
                <div class="row secure-payment">
                  <div class="col-md-12 col-12 text-center"><img src="{{ get_theme_file_uri().'/dist/images/2checkout-3.png' }}" alt="2Checkout"></div>
                </div>
              @endif

              @php $form_id = get_field('froms_problem_with_download', 'option' );@endphp
              @if($form_id)
                <p class="form-probelm">{{ _e('there is a problem with download', 'premast') }} <a class="modal-forms" data-toggle="modal" data-target="#ReportAProblem">{{ _e('click here', 'premast') }}</a></p>
                <!-- Modal -->
                <div class="modal fade" id="ReportAProblem" tabindex="-1" role="dialog" aria-labelledby="ReportAProblemTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4>{{ _e('Report a problem', 'premast') }}</h4>
                      </div>
                      <div class="modal-body">              
                          {!! do_shortcode( '[gravityform id="'.$form_id['id'].'" name="" title="false" description="false" ajax="true" ]' ) !!}
                          <button type="button" class="cancel" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">{{ _e('cancel', 'premast') }}</span>
                          </button>    
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            </div>

            @if(get_field('ads_image'))
              <div class="ads-block">
                <a href="{{ the_field('ads_link') }}"><img src="{{ the_field('ads_image') }}" alt="{{ _e('Ads Block', 'premast') }}"></a>
              </div>
            @endif

            @php dynamic_sidebar('sidebar-shop') @endphp

            @include('partials/incloud/sharemeta')




            @if ( wp_is_mobile() ) 
              @if (get_field('slide_gallery'))
                <div class="embed-container">
                  {{ the_field('slide_gallery') }}
                </div>
              @endif

              <div class="product-infomation">
                <h3>{{ _e('Description', 'premast') }}</h3>
                <div id="tab-description">{!! get_the_content() !!}</div>
              </div>
            @endif

            <div class="box-author box-counter">

              <h3>{{ _e('published by', 'premast') }}</h3>

              @php 
                $avatar = get_field('owner_picture', 'user_'. $author );
                $user_post_count = count_user_posts( $author , 'product' );
              @endphp
              <div class="media author-media">
                @if($avatar)
                  <div class="avatar align-self-center mr-3">
                    <img src="{{ $avatar['url'] }}" alt="{!! get_the_author_meta('display_name', $author) !!}">
                  </div>
                @else 
                  {!! get_avatar( get_the_author_meta('ID', $author), '94', null, null, array( 'class' => array( 'align-self-start', 'mr-3' ) ) ) !!}
                @endif
                <div class="media-body pt-3">
                  <h5 class="mt-0 text-black">
                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
                    <a class="follow" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">{{ _e('follow', 'premast') }}</a>
                  </h5>
                  <p>{{ _e('Total uploads:', 'premast') }} {{ $user_post_count }}</p>
                </div>
              </div>
            </div>

              @if ( wp_is_mobile() ) 
                @include('partials/incloud/comments')
              @endif
          </div>
        </div>
      </div>
    </div>

    @php
      $related = related_posts();
    @endphp

    @if($related->have_posts())
      <section class="bg-white pt-5 related">
        <div class="container">
          <h3>{{ _e('related Items', 'premast') }}</h3>
          <div class="item-columns row m-0 col-12 p-0"> 
            @while($related->have_posts() ) @php($related->the_post())
              @include('partials/incloud/card-user')
            @endwhile
            @php (wp_reset_postdata())
          </div>
        </div>
      </section>
    @endif

    <section class="download-footer">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8 col-12">
            <div class="media">
              <img src="{{ Utilities::global_thumbnails(get_the_ID(),'full')}}" class="align-self-center mr-3" alt="{{ the_title() }}"> 
              <div class="media-body pt-4">
                <h5 class="mt-0">{{ the_title() }}</h5>
                <p class="text-description">{!! $excerpt !!}</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-12 d-flex">
            <div class="bottom-summary col align-self-center">
              @if ( !is_user_logged_in() && $price == 0)
                <a class="login" href="#" data-toggle="modal" data-target="#LoginUser">{{ _e('Login to Download Now', 'premast') }}</a>
              @else
              <a class="click-downloads" href="#">
                
                @if($sale)
                  {{ _e('buy Now for', 'premast') }}
                  <span class="price">
                    <del>
                      <span class="woocommerce-Price-amount amount">{{ $price }}<span class="woocommerce-Price-currencySymbol">{!! $symbol !!}</span></span>
                    </del> 
                    <span>
                      <span class="woocommerce-Price-amount amount">{{ $sale }}<span class="woocommerce-Price-currencySymbol">{!! $symbol !!}</span></span>
                    </span>
                  </span>
                @elseif($price)
                  {{ _e('buy Now for', 'premast') }}
                  <span class="price">
                    <span>
                      <span class="woocommerce-Price-amount amount">{{ $price }}<span class="woocommerce-Price-currencySymbol">{!! $symbol !!}</span></span>
                    </span> 
                  </span>
                @else 
                  <span class="price">{{ _e('Download Now', 'premast') }}</span>
                @endif
              </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <script type="text/javascript">
      jQuery(function($) {
        <?php if($price): ?>
          $('.click-downloads').click(function () {
            $('.woocommerce div.product form.cart .button').click();
          });
        <?php else: ?>
          $('.click-downloads').click(function () {
            $('.download-product #somdn-form-submit-button').click();
          });
        <?php endif; ?>
      });
    </script>

  @endwhile
@endsection
