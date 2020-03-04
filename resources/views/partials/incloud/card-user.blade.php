<div class="item-card col-md-3 col-sm-6 col-sx-6 col-12 grid-item pl-4 pr-4 post-ajax">
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
        <a target="_blank" href="http://pinterest.com/pin/create/button/?url{{ the_permalink() }}=&media={{ Utilities::global_thumbnails(get_the_ID(),'full')}}&description={{ get_the_title() }}" class="pin-it-button" count-layout="horizontal">
          <small>Pin it</small> <i class="fa fa-pinterest-p" aria-hidden="true"></i>
        </a>
      </li>
      @if(current_user_can( 'edit_post', get_the_ID() ) && (get_the_author_meta('ID') == $current_user->ID) || is_super_admin())
        <li class="edit-post button-share">
          <a class="post-edit-link" href="{{ the_field('link_edit_item', 'option') }}?post_id={{ the_ID() }}"><small>Edit</small> <i class="fa fa-pencil" aria-hidden="true"></a></i>
        </li>
      @endif
    </ul>

    <div class="bg-white" style="background-image:url('{{ Utilities::global_thumbnails(get_the_ID(),'full')}}');height: auto; min-height: 1px;">
      <img src="{{ Utilities::global_thumbnails(get_the_ID(),'full')}}" class="card-img-top" alt="{{ the_title() }}">
      <div class="card-overlay"><a class="the_permalink" href="{{ the_permalink() }}"></a></div>
    </div>
    <div class="card-body pt-2 pl-0 pr-0 pb-0">
      <a class="card-link" href="{{ the_permalink() }}">
        <h5 class="card-title font-weight-400">{{ wp_trim_words(get_the_title(), '4', ' ...') }}</h5>
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

<style>
span.custom-onsale {
  background: #FFB800;
  backdrop-filter: blur(10px);
  border-radius: 4px;
  font-size: 14px !important;
  text-align: center;
  color: #000000 !important;
  width: 62px;
  height: 20px;
  display: inline-block;
  line-height: 20px;
  position: absolute;
  left: -10px;
  text-transform: uppercase;
  z-index: 9;
}

span.custom-onsale:before {
  content: "";
  border-top: 8px solid #E6A601;
  border-left: 8px solid transparent;
  position: absolute;
  bottom: -7px;
  z-index: 0;
  left: 1px;
}
</style>