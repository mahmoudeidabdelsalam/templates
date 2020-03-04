<ul class="nav nav-tabs" id="myTabPlus" role="tablist">
  <li class="nav-item nav-first">
    {{ _e('category', 'premast') }}
  </li>
  @php 
    $terms = get_terms( 'graphics-category', array( 'hide_empty' =>  1, 'parent' =>0 ));
    $counter = 0;
  @endphp  
  @foreach($terms as $term) 
    @php 
      $counter++; 
    @endphp
    <li class="nav-item">
      <a class="nav-link @if($counter == '1') active @endif" id="term-{{ $term->term_id }}-tab" data-toggle="tab" href="#tabs-{{ $term->term_id }}" role="tab" aria-controls="tabs-{{ $term->term_id }}" aria-selected="true">{{ $term->name }}</a>
    </li>
  @endforeach
</ul>
<div class="tab-content" id="myTabContent">
  @php
    $counter = 0;
  @endphp
  @foreach($terms as $term) 
    @php
      $counter++; 
    @endphp
    <div class="tab-pane fade @if($counter == '1') show active @endif" id="tabs-{{ $term->term_id }}" role="tabpanel" aria-labelledby="tabs-{{ $term->term_id }}-tab">
      @php
        $args = array(
          'post_type' => 'graphics',
          'posts_per_page' => 20,
          'paged' => $paged,
          'tax_query' => array(
            array(
              'taxonomy' => 'graphics-category',
              'field' => 'term_id',
              'terms' => $term->term_id
            )
          )
        );
        $query = new \WP_Query( $args );
      @endphp
        <div class="row">
          @if($query->have_posts())
            @while($query->have_posts()) @php($query->the_post())
              <div class="col-md-2 col-sm-4 co-xs-12 col-12 plus-all-item" id="{{ the_ID() }}">
                <div class="card">
                  <div class="img-top-card">
                    <img src="{{ Utilities::global_thumbnails(get_the_ID(),'full')}}" class="card-img-top" alt="...">
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">{{ the_title() }}</h5>
                  </div>
                  <div class="card-event">
                    <a herf="#" class="item-deleted item-event" data-deleted="{{ the_ID() }}" data-nonce="<?php echo wp_create_nonce('testdel') ?>"><i class="fa fa-trash-o" aria-hidden="true"></i> <span class="text-white">{{ _e('Delete', 'premast') }}</span></a> 
                  </div>
                </div>
              </div>
            @endwhile
          @endif
        </div>

      <div class="col-12 pt-5 pb-5">
        <nav aria-label="Page navigation example">{{ premast_base_pagination(array(), $query) }}</nav>
      </div>
    </div>
  @endforeach
</div>


<script>
  jQuery(function($) {
    $('.item-deleted').on('click', function(e){
      var post = $(this).attr('data-deleted'); // get post id from hidded field
      var nonce = $(this).attr('data-nonce'); // get nonce from hidded field
      
      $.ajax({
        url: "<?php echo admin_url('admin-ajax.php'); ?>", // in backend you should pass the ajax url using this variable
        type: 'POST',
        data: { 
          action : 'ajaxtestdel', 
          postid: post, 
          ajaxsecurity: nonce 
        },
        success: function(data){
          if(data === 'success') {
            $('#' + post).remove()
          }
        }
      });
    });
  });
</script>
