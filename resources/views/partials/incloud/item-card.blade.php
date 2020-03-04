@php 
$status = get_post_status(get_the_ID());
if($status == 'draft'):
  $label = 'drafts';
elseif($status == 'pending'):
  $label = 'pending';
elseif($status == 'publish'):
  $label = 'live';
elseif($status == 'rejected'):
  $label = 'rejected';
else: 
  $label = 'status';
endif;

@endphp
<div class="item-card col-md-3 col-sm-4 col-sx-6 col-12 grid-item pl-4 pr-4">
  <div class="card">
    <div class="bg-white" style="background-image:url('{{ Utilities::global_thumbnails(get_the_ID(),'full')}}');">
      <img src="{{ Utilities::global_thumbnails(get_the_ID(),'full')}}" class="card-img-top" alt="{{ the_title() }}">
      <span class="status {{ $label }}">{{ $label }}</span>
      <div class="card-overlay">
        @if(current_user_can( 'edit_post', get_the_ID() ) && (get_the_author_meta('ID') == $current_user->ID) || is_super_admin())
          <p><a class="post-edit-link" href="{{ the_field('link_edit_item', 'option') }}?post_id={{ the_ID() }}">{{ _e('edit Product') }}</a></p>
        @endif
      </div>
    </div>
    <div class="card-body pt-3 pl-1 pr-1">
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
          <span class="icon-download icon-meta"> <img class="img-meta" src="{{ get_theme_file_uri().'/dist/images/icon-view.svg' }}" alt="Download"> {{ ($counter_view)? $counter_view:'0' }}</span>
        </div>
        <div class="download">
          @if($price)
            <span>{{ _e('premium', 'premast') }}</span>
          @else 
            <span>{{ _e('free', 'premast') }}</span>
          @endif
        </div>
      </div>
    </div>
  </div>              
</div>