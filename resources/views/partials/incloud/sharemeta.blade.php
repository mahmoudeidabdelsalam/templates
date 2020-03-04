@php
    global $post;
    $permalink = get_permalink($post->ID);
    $title = get_the_title($post->ID);
    $counter = get_post_meta( $post->ID, 'counter', true );
    $counter_download = get_post_meta( $post->ID, 'counterdownload', true );

    $slide_colors = get_post_meta( $post->ID, 'slide_colors', true );
    $slide_number = get_post_meta( $post->ID, 'slide_number', true );
    $slide_pages = get_post_meta( $post->ID, 'slide_pages', true );
    $slide_date = get_post_meta( $post->ID, 'slide_date', true );

    $slide_type = get_post_meta( $post->ID, 'slide_type', true );
    $slide_format = get_post_meta( $post->ID, 'slide_format', true );
    
    global $product;
    $rating_count = method_exists($product, 'get_rating_count')   ? $product->get_rating_count()   : 1;
    $review_count = method_exists($product, 'get_review_count')   ? $product->get_review_count()   : 1;
    $average      = method_exists($product, 'get_average_rating') ? $product->get_average_rating() : 0;

    $tags = wp_get_post_terms( get_the_id(), 'product_tag' );

@endphp

<div class="box-counter">
  <div class="downloader">
    @if ($rating_count > 0)
      <div class="rating-item"> {!! wc_get_rating_html($average, $rating_count) !!} <span itemprop="reviewCount">{{ $review_count }} {{ _e('review', 'premast') }}</span></div>
    @else 
      {!! wc_get_rating_html('1', '5') !!}
      <div class="rating-item"><span itemprop="reviewCount">{{ _e('0 review', 'premast') }}</span></div>
    @endif
    <div class="downloader-item"><span class="counter-download"><strong>{{ empty($counter_download) ? 0 : $counter_download}}</strong> {{ _e('Download', 'premast') }}</span></div>
  </div>
  
  <div class="information-slide">
    @if($slide_type)
      <p class="slide-info">{{ _e('Type', 'premast') }} <span>{{ $slide_type }}</span></p>
    @endif
    @if($slide_format)
      <p class="slide-info">{{ _e('File Format', 'premast') }} <span>{{ $slide_format }}</span></p>
    @endif

    @if ($tags) 
      <div class="tag-post">
      {{ _e('Tags', 'premast') }}
        <ul class="list-inline">
          @foreach( $tags as $tag ) 
            @php 
              $term_link = get_term_link( $tag );
              if ( is_wp_error( $term_link ) ) {
                  continue;
              }
            @endphp
            <li class="list-inline-item"><a href="{{ $term_link  }}">{{ $tag->name }}</a></li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>
  <div class="sharing-posts">
    <ul class="list-inline social-sharer m-0 p-1 pull-left">
      <li class="list-inline-item">
        <span class="counters"> <number id="counter" class="namber-share">{{ empty($counter) ? 0 : $counter}}</number> <small>{{ _e('share', 'premast')}}</small></span>
      </li>  
      <li class="list-inline-item">
        <a class="counter linkedin"  data-network="linkedin" data-url="{{ $permalink}}" data-title="{{ $title}}"   data-action="counter" data-event="counter" data-id="{{ get_the_ID()}}"  data-url="{{ get_the_permalink()}}" href="#"> <i class="fa fa-linkedin"></i></a>
      </li>
      <li class="list-inline-item">
        <a class="counter twitter"   data-network="twitter"  data-url="{{ $permalink}}" data-title="{{ $title}}"   data-action="counter" data-event="counter" data-id="{{ get_the_ID()}}"  data-url="{{ get_the_permalink()}}" href="#"> <i class="fa fa-twitter"></i></a>      
      </li>
      <li class="list-inline-item">
        <a class="counter facebook"  data-network="facebook" data-url="{{ $permalink}}" data-title="{{ $title}}"   data-action="counter" data-event="counter" data-id="{{ get_the_ID()}}"  data-url="{{ get_the_permalink()}}" href="#"> <i class="fa fa-facebook"></i></a>      
      </li>
      <li class="list-inline-item hidden-sm-down">
        <a class="item-share" href="mailto:?subject={{ $title }}&body=I would like to share the attached article from the forum. {{ $permalink }}" target="_top"><i class="fa fa-envelope-o"></i></a>
      </li> 
      <li class="list-inline-item hidden-sm-down">
        <a class="item-share" href="#" onclick="window.print()"><i class="fa fa-print"></i></a>
      </li>
    </ul>
  </div>
</div>
@if ( empty(!$slide_colors) || empty(!$slide_number) || empty(!$slide_pages) ||empty(!$slide_date) || get_field('custom_slide_information') )
<div class="box-counter">
  <h4>{{ _e('information', 'premast') }}</h4>
  <ul class="list-unstyled">
    @if ($slide_colors)
      <li class="list-item"><strong>{{ _e('Unique Slides:', 'premast') }}</strong> <span>{{ $slide_colors }}</span></li>
    @endif
    @if ($slide_number)
      <li class="list-item"><strong>{{ _e('Animation:', 'premast') }}</strong> <span>{{ $slide_number }}</span></li>
    @endif
    @if ($slide_pages)
      <li class="list-item"><strong>{{ _e('Vector:', 'premast') }}</strong> <span>{{ $slide_pages }}</span></li>
    @endif
    @if ($slide_date)
      <li class="list-item"><strong>{{ _e('Icons:', 'premast') }}</strong> <span>{{ $slide_date }}</span></li>
    @endif

    @if( have_rows('custom_slide_information') )
      @while ( have_rows('custom_slide_information') ) @php(the_row())
        <li class="list-item"><strong>{{ the_sub_field('key_slide') }}:</strong> <span>{{ the_sub_field('value_slide') }}</span></li>
      @endwhile
    @endif

  </ul>
</div>
@endif

<script>
  jQuery(document).ready(function ($) {
    var download = document.getElementById("somdn-form-submit-button"); 
    if (download) {
      download.setAttribute("data-id", "{{ get_the_ID()}}");
      download.setAttribute("data-action", "counterdownload");
      download.setAttribute("data-event", "counterdownload");
    }
  });
</script>