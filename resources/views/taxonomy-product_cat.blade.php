@php 
  $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
  $Name   = isset($_GET['refine']) ? $_GET['refine'] : '0';
  $sort   = isset($_GET['sort']) ? $_GET['sort'] : '0';
  $refine   = isset($_GET['refine']) ? $_GET['refine'] : '0';
  if ( $sort == 'date' ):
    $orderby = 'date';
    $order = 'DESC';
    $meta_key = '';
  elseif( $sort == 'view') :
    $orderby = 'meta_value_num';
    $order = 'DESC';
    $meta_key = 'c95_post_views_count';
  elseif ( $sort == 'download' ):
    $orderby = 'meta_value_num';
    $order = 'DESC';
    $meta_key = 'counterdownload';
  else :
    $orderby = 'date';
    $order = 'DESC';
    $meta_key = '';
  endif;
  $taxonomy_query = get_queried_object();
  global $wp;
@endphp

@extends('layouts.app')

@section('content')

@php 
  global $current_user;
  wp_get_current_user();
  global $wp;
@endphp


@if ( wp_is_mobile() ) 
  <form class="is-mobile-search" role="search" method="get" id="searchform" action="{{ home_url( $wp->request ) }}">
    <button type="submit"><i class="fa fa-search"></i></button>
    <input id="autoblogs" class="form-control w-100" type="search" value="@if($refine != '0') {!! $refine !!} @endif" name="refine" autocomplete="on" autocorrect="off" autocapitalize="on" spellcheck="false" placeholder="{{ _e('Search items', 'premast') }}" aria-label="Search">    
  </form>
  <div class="col-12 d-flex">
    <div class="dropdown">
      <a class="btn-toggle dropdown-toggle" href="#" role="button" id="dropdownMenuCat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="{{ get_theme_file_uri().'/resources/assets/images' }}/categories.svg" alt=""> {{ _e('Categories', 'premast') }}
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuCat">
        @if($taxonomy_query->parent) 
          @php 
          $term_parent = get_term_parents_list( $taxonomy_query->parent, 'product_cat' );
            $term_link = get_term_link( $taxonomy_query );
          @endphp
          <li class="dropdown-item">
            <i class="fa fa-angle-left" aria-hidden="true"></i> {!! rtrim($term_parent,'/')  !!}
          </li>
          <li class="dropdown-item">
            <a class="text-term  active " href="{{ $term_link }}">{{ $taxonomy_query->name }} <span class="count-term">{{ $taxonomy_query->count }}</span></a>
          </li>
        @else
          @php 
            $terms = get_terms( 'product_cat', array( 'parent' => $taxonomy_query->term_id, 'orderby' => 'slug', 'hide_empty' => false ) );
          @endphp
          @foreach ( $terms as $term )
            @php
              $term_link = get_term_link( $term );
              if ( is_wp_error( $term_link ) ) {
                  continue;
              }
            @endphp
            <li class="dropdown-item">
              <a class="text-term @if($term->term_id == $taxonomy_query->term_id) active @endif" href="{{ $term_link }}">{{ $term->name }} <span class="count-term">{{ $term->count }}</span></a>
            </li>
          @endforeach
        @endif
      </div>
    </div>
    <div class="dropdown">
      <a class="btn-toggle dropdown-toggle" href="#" role="button" id="dropdownMenuFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ _e('Sort by featured', 'premast') }}
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuFilter">
        <a class="dropdown-item" href="{{ home_url( $wp->request ) }}?sort=featured">{{ _e('featured', 'premast') }}</a>
        <a class="dropdown-item" href="{{ home_url( $wp->request ) }}?sort=view">{{ _e('Popular', 'premast') }}</a>
        <a class="dropdown-item" href="{{ home_url( $wp->request ) }}?sort=date">{{ _e('Recent', 'premast') }}</a>
        <a class="dropdown-item" href="{{ home_url( $wp->request ) }}?sort=download">{{ _e('Download', 'premast') }}</a>
      </div>
    </div>
  </div>
@endif



<div class="container-fiuld">
  <div class="row justify-content-center m-0">
    @if ( !wp_is_mobile() ) 
      <div class="col-md-3 col-sm-12">
        <div class="by-filter">
          <div class="accordion" id="accordionExample">
            <div class="card">
              <div class="card-header" id="headingOne">
                <p class="mb-0">
                  <button class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    @if ($sort != '0')
                      {{ _e('Sort by', 'premast') }} {{ $sort }} <i class="fa fa-chevron-down text-term float-right" aria-hidden="true"></i>
                    @else
                      {{ _e('Sort by date', 'premast') }} <i class="fa fa-chevron-down text-term float-right" aria-hidden="true"></i>
                    @endif
                  </button>
                </p>
              </div>
              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <ul class="list-unstyled mb-0">
                    <li class="list-item">
                      <a class="text-term" href="{{ home_url( $wp->request ) }}?sort=featured">{{ _e('featured', 'premast') }}</a>
                    </li>
                    <li class="list-item">
                      <a class="text-term" href="{{ home_url( $wp->request ) }}?sort=view">{{ _e('Popular', 'premast') }}</a>
                    </li>
                    <li class="list-item">
                      <a class="text-term" href="{{ home_url( $wp->request ) }}?sort=date">{{ _e('Recent', 'premast') }}</a>
                    </li>
                    <li class="list-item">
                      <a class="text-term" href="{{ home_url( $wp->request ) }}?sort=download">{{ _e('Download', 'premast') }}</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingTwo">
                <p class="mb-0">
                  <button class="btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    {{ _e('filter by', 'premast') }} <i class="fa fa-chevron-down" aria-hidden="true"></i>
                  </button>
                </p>
              </div>
              <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                <ul class="list-unstyled mb-0">
                  @if($taxonomy_query->parent) 
                    @php 
                      $term_parent = get_term_parents_list( $taxonomy_query->parent, 'product_cat' );
                      $term_link = get_term_link( $taxonomy_query );
                      $termchildren = get_term_children( $taxonomy_query->term_id, 'product_cat' );
                    @endphp
                    <li class="list-item term-parent">
                      <i class="fa fa-angle-left" aria-hidden="true"></i> {!! rtrim($term_parent,'/')  !!}
                    </li>
                    <li class="list-item">
                      <a class="text-term active" href="{{ $term_link }}">{{ $taxonomy_query->name }} <span class="count-term">{{ $taxonomy_query->count }}</span></a>
                    </li>
                    @if ($termchildren)
                      @foreach ($termchildren as $child)
                      @php 
                      $term = get_term_by( 'id', $child, 'product_cat' );
                      @endphp
                        <li class="list-item">
                          <a class="text-term" href="{{ get_term_link( $term ) }}">{{ $term->name }} <span class="count-term">{{ $term->count }}</span></a>
                        </li>
                      @endforeach
                    @endif
                  @else
                    <li class="list-item">
                      <a class="text-term active" href="#">{{ _e('All Categories', 'premast') }} <span class="count-term">{{ $taxonomy_query->count }}</span></a>
                    </li>
                    @php 
                      $terms = get_terms( 'product_cat', array( 'parent' => $taxonomy_query->term_id, 'orderby' => 'slug', 'hide_empty' => false ) );
                    @endphp
                    @foreach ( $terms as $term )
                      @php
                        $term_link = get_term_link( $term );
                        if ( is_wp_error( $term_link ) ) {
                            continue;
                        }
                      @endphp
                      <li class="list-item">
                        <a class="text-term @if($term->term_id == $taxonomy_query->term_id) active @endif" href="{{ $term_link }}">{{ $term->name }} <span class="count-term">{{ $term->count }}</span></a>
                      </li>
                    @endforeach
                  @endif
                </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif

    <div class="col-md-9 col-sm-12 position-relative">
      <div class="item-columns container-ajax items-categories item-card grid grid-custom row">
        @php
        if ($sort != '0') {
            $second_ids = get_posts( array(
              'post_type' => 'product',
              'posts_per_page' => 20,
              'fields'         => 'ids',
              'paged' => $paged,
              'meta_key' => $meta_key,
              'orderby' => $orderby,
              'order' => $order,
              'tax_query' => array(
                array(
                  'taxonomy' => 'product_cat',
                  'field' => 'term_id',
                  'terms' => $taxonomy_query->term_id
                )
              )
            ));
            $per_page = 21 - count($second_ids);
          } else {
            $second_ids = [];
            $per_page = 20;
          }
          $orders = array(
            'post_type' => 'product',
            'posts_per_page' => 19,
            'paged' => $paged,
            'meta_key' => $meta_key,
            'orderby' => $orderby,
            'order' => $order,
            'tax_query' => array(
              array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $taxonomy_query->term_id
              )
            )
          );
          $args = array(
            'post_type' => 'product',
            'posts_per_page' => $per_page,
            'post__not_in' => $second_ids,
            'paged' => $paged,
            'tax_query' => array(
              array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $taxonomy_query->term_id
              )
            )
          );
          if($Name != '0') {
            $args['tax_query'] = array(
              array(
                'taxonomy' => 'product_tag',
                'field'    => 'name',
                'terms'    => $Name,
              ),
            );
          }
          
          if( $sort == 'featured') {
            $orders['tax_query'] = array(
              'relation' => 'AND',
              array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
              ),
              array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $taxonomy_query->term_id
              )
            );
          }
          $my_query = new \WP_Query( $args );
          if ($sort != '0') {
            $more_query = new \WP_Query( $orders ); 
            $my_query->posts = array_merge( $more_query->posts, $my_query->posts);
            $my_query->post_count = count( $my_query->posts );
          }
        @endphp

        @if (get_field('show_card_pricing', 'option'))
          <div class="col-md-4 col-6 grid-item">
            <div class="card">
              <span class="custom-onsale">
                {{ the_field('tag_card_pricing', 'option') }}
              </span>
              <div class="bg-white" style="background-image:url('{{ the_field('images_card_pricing', 'option') }}');height:auto;min-height:180px;">
                <img src="{{ the_field('images_card_pricing', 'option') }}" class="card-img-top" alt="{{ the_field('heading_card_pricing', 'option') }}">
                <div class="card-overlay"><a class="the_permalink" href="{{ the_field('lik_card_pricing', 'option') }}"></a></div>
              </div>
              <div class="card-body pt-2 pl-0 pr-0 pb-0">
                <a class="card-link" href="{{ the_field('lik_card_pricing', 'option') }}">
                  <h5 class="card-title font-weight-400">{{ the_field('heading_card_pricing', 'option') }}</h5>
                </a>
                <div class="review-and-download">
                  {{ the_field('description_card_pricing', 'option') }}
                  <span class="premium"><i class="fa fa-star"></i></span>
                </div>
              </div>
            </div>
          </div>
        @endif

        @if($my_query->have_posts())
          @while($my_query->have_posts()) @php($my_query->the_post())
          @php ($sale = get_post_meta( get_the_ID(), '_sale_price', true))
            <div class="col-md-4 col-6 grid-item">
              <div class="card">
                  @if($sale)
                    <span class="custom-onsale">
                      {{ _e('on Sale', 'premast') }}
                    </span>
                  @endif
                <ul class="meta-buttons">
                  <li class="likes-button">
                    {!! get_simple_likes_button( get_the_ID() ) !!}
                  </li>
                  <li class="pinterest-share button-share">
                    <a target="_blank" href="http://pinterest.com/pin/create/button/?url{{ the_permalink() }}=&media={{ Utilities::global_thumbnails(get_the_ID(),'medium')}}&description={{ get_the_title() }}" class="pin-it-button" count-layout="horizontal">
                     <small>Pin it</small> <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                    </a>
                  </li>
                  @if(current_user_can( 'edit_post', get_the_ID() ) && (get_the_author_meta('ID') == $current_user->ID) || is_super_admin())
                    <li class="edit-post button-share">
                      <a class="post-edit-link" href="{{ the_field('link_edit_item', 'option') }}?post_id={{ the_ID() }}"><small>Edit</small> <i class="fa fa-pencil" aria-hidden="true"></a></i>
                    </li>
                  @endif
                </ul>

                <div class="bg-white" style="background-image:url('{{ Utilities::global_thumbnails(get_the_ID(),'medium')}}');height:auto;min-height:180px;">
                  <img src="{{ Utilities::global_thumbnails(get_the_ID(),'medium')}}" class="card-img-top" alt="{{ the_title() }}">
                  <div class="card-overlay"><a class="the_permalink" href="{{ the_permalink() }}"></a></div>
                </div>
                <div class="card-body pt-2 pl-0 pr-0 pb-0">
                  <a class="card-link" href="{{ the_permalink() }}">
                    <h5 class="card-title font-weight-400">{{ html_entity_decode(wp_trim_words(get_the_title(), '4', ' ...')) }}</h5>
                  </a>
                  <div class="review-and-download">
                    <div class="review">
                      @if (get_option('woocommerce_enable_review_rating' ) == 'yes') 
                        <?php 
                          global $product;
                          $rating_count = method_exists($product, 'get_rating_count')   ? $product->get_rating_count()   : 1;
                          $review_count = method_exists($product, 'get_review_count')   ? $product->get_review_count()   : 1;
                          $average      = method_exists($product, 'get_average_rating') ? $product->get_average_rating() : 0;
                          $counter_download = get_post_meta( get_the_ID(), 'counterdownload', true );
                          $counter_view = get_post_meta( get_the_ID(), 'c95_post_views_count', true );
                          $like = get_post_meta(get_the_ID(), '_post_like_count', true);
                          $price = get_post_meta( get_the_ID(), '_regular_price', true);
                        ?>
                        @if ($rating_count > 0)
                          {!! wc_get_rating_html($average, $rating_count) !!}
                          <span class="icon-review icon-meta" itemprop="reviewCount">{{ $average }}</span>
                        @else 
                          {!! wc_get_rating_html('1', '5') !!}
                          <span class="icon-review icon-meta" itemprop="reviewCount">{{ _e('0', 'premast') }}</span>
                        @endif
                      @endif

                      <span class="icon-download icon-meta"> <img class="img-meta" src="{{ get_theme_file_uri().'/dist/images/icon-download.svg' }}" alt="Download"> {{ ($counter_download)? $counter_download:'0' }}</span>
                      @if(current_user_can( 'edit_post', get_the_ID() ) && (get_the_author_meta('ID') == $current_user->ID) || is_super_admin())
                        <span class="icon-download icon-meta"> <img class="img-meta" src="{{ get_theme_file_uri().'/dist/images/icon-view.svg' }}" alt="Download"> {{ ($counter_view)? $counter_view:'0' }}</span>
                      @endif
                      <span class="icon-download icon-meta"> <img class="img-meta" src="{{ get_theme_file_uri().'/dist/images/like.png' }}" alt="like"> {{ ($like)? $like:'0' }}</span>
                    </div>

                    @if($price)
                      <span class="premium"><i class="fa fa-star"></i></span>
                    @endif

                  </div>
                </div>
              </div>              
            </div>
          @endwhile

        @else
          <div class="col-12">
            {{ __('Sorry, no results were found.', 'sage') }}
          </div>
        @endif
        @php (wp_reset_postdata())
      </div>

      <div class="spinner">
        <div class="cube1"></div>
        <div class="cube2"></div>
      </div>


      <div class="col-12 pt-5 pb-5">
        @if ($sort != '0')
          <nav aria-label="Page navigation example">{{ premast_base_pagination(array(), $more_query) }}</nav>
        @else 
          <nav aria-label="Page navigation example">{{ premast_base_pagination(array(), $my_query) }}</nav>
        @endif
        
      </div>
    </div>
  </div>
</div>
@endsection