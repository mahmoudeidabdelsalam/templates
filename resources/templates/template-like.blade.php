{{--
  Template Name: User Customer Favourites
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

  @php
    global $current_user;
    wp_get_current_user();
    $args = array(
      'numberposts' => -1,
      'post_type' => 'product',
      'meta_query' => array (
        array (
          'key' => '_user_liked',
          'value' => $current_user->ID,
          'compare' => 'LIKE'
        )
      ) 
    );
    $like_query = new WP_Query( $args );  
  @endphp
  <div class="container-fiuld woocommerce customer-download">
    <div class="row">
      <div class="col-md-3 col-12 side-menu-user">
        <h2 class="headline text-primary">{{ _e('My Account', 'premast') }}</h2>
        @if (has_nav_menu('user_navigation'))
          {!! wp_nav_menu(['theme_location' => 'user_navigation', 'container' => false, 'menu_class' => 'nav nav-pills flex-column flex-sm-row col-12', 'walker' => new NavWalker()]) !!}
        @endif
      </div>
      <div class="col-md-9 col-12">
        <div class="item-columns row mt-5 pt-5 ml-0 mr-0">
          @if($like_query->have_posts())
            @while($like_query->have_posts()) @php($like_query->the_post())
              <div class="item-card col-md-4 col-sm-4 col-sx-6 col-12 grid-item">
                <div class="card">
                  <div class="bg-white bg-images" style="background-image:url('{{ Utilities::global_thumbnails(get_the_ID(),'full')}}');">
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
                      <div class="download">
                        <a class="card-link" href="{{ the_permalink() }}">
                          {{ _e('Download', 'premast') }}
                        </a>
                      </div>
                    </div>
                  </div>
                </div>              
              </div>
            @endwhile
            @php (wp_reset_postdata())
          @else
            <div class="woocommerce-Message woocommerce-Message--info text-center col-12 pt-5 pb-5 mb-5 mt-5">
              <a class="woocommerce-Button button" href="{{ the_field('link_page_login','option') }}">
                <?php esc_html_e( 'Go shop', 'woocommerce' ); ?>
              </a>
              <?php esc_html_e( 'No Likes available yet.', 'woocommerce' ); ?>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

@endif

@endsection