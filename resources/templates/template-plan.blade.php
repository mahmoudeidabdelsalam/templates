{{--
  Template Name: Plan Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <section class="banner" style="background-image:url('{{ the_field('background_plan_banner') }}');">
      <div class="container">
        <div class="row align-items-center text-center justify-content-center">
          <div class="col-md-7 col-sm-12 col-12">
            <h2>{{ the_field('headline_plan_page') }}</h2>
            <p>{{ the_field('instructions_plan_page') }}</p>
            <p class="time-back"><span>{{ the_field('time_money_back') }}</span> {{ _e('money back guarantee', 'premast') }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="pricing-table" style="background-image:url('{{ the_field('background_plan_table') }}');">
      <div class="container">
        <div class="row align-items-center text-center justify-content-center">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="box-pricing">
              <div class="headline-pricing">
                {{ _e('Basic', 'premast') }}
              </div>
              <div class="box-in-pricing">
                <div class="head-box-pricing">
                  <span class="number-pricing">
                    {{ _e('FREE', 'premast') }}
                  </span>
                  <span class="free-pricing">
                    {{ _e('all you need is to create an account, no need to subscribe!', 'premast') }}
                  </span>
                </div>
                <div class="list-items">
                  <span>{{ _e('Access for all  free items.', 'premast') }}</span>
                  <span>{{ _e('5 downloads/day', 'premast') }}</span>
                  <span>{{ _e('40 downloads/month', 'premast') }}</span>
                  <span>{{ _e('attribution of premast.com', 'premast') }}</span>
                  <span>{{ _e('Personal license Only', 'premast') }}</span>
                </div>
                <div class="choose plan">
                  <a class="mt-2 signup btn-primary" href="#" data-toggle="modal" data-target="#SignupUser">{{ _e('Sign Up', 'premast') }}</a>
                </div>
              </div>
            </div>
          </div>
          @if( have_rows('plan_pricing_box') )
            @while ( have_rows('plan_pricing_box') ) @php the_row() @endphp
              <div class="col-md-3 col-sm-6 col-12">
                <div class="box-pricing @if( get_sub_field('check_best_plan') ) the-best @endif">
                  <div class="headline-pricing">
                    {{ the_sub_field('headline_plan_box') }}
                  </div>
                  <div class="box-in-pricing">
                    <div class="head-box-pricing">
                      <span class="date-access">
                        {{ the_sub_field('date_access') }}
                      </span>
                      <span class="number-pricing">
                        {{ the_sub_field('pricing_number') }}$
                      </span>
                      <span class="date-pricing">
                        {{ the_sub_field('pricing_date') }}
                      </span>
                    </div>
                    <div class="list-items">
                      @if( have_rows('list_plan') )
                        @while ( have_rows('list_plan') ) @php the_row() @endphp
                          <span>{{ the_sub_field('list_item') }}</span>
                        @endwhile
                      @endif
                    </div>
                    @php 
                    $product_id = get_sub_field('choose_plan');  
                    @endphp
                      <div class="choose plan">
                        {!! do_shortcode( '[ajax_add_to_cart id="'.$product_id.'" text="choose plan" style="" show_price="false" /]' ) !!}
                      </div>
                  </div>

                  @if( get_sub_field('check_best_plan') )
                    <p class="best-plane">{{ _e('Best plane -', 'permast') }} <strong>{{ the_sub_field('text_best_plan') }}</strong></p>
                  @endif
                </div>
              </div>
            @endwhile
          @endif

          <div class="col-12 mt-5 mb-5">
            <img src="{{ the_field('image_checkout') }}" alt="{{ the_title() }}">
          </div>
        </div>
      </div>
    </section>
    
    @if( have_rows('featured_item') )
      <section class="featured-item bg-white pt-5 pb-5">
        <div class="container">
          <div class="row align-items-center text-center justify-content-center">
            @while ( have_rows('featured_item') ) @php the_row() @endphp
              <div class="col-md-3 col-sm-6 col-12">
                <div class="box-featured">
                  <img src="{{ the_sub_field('icon_featured_item') }}" alt="{{ the_sub_field('headline_featured_item') }}">
                  <h3>{{ the_sub_field('headline_featured_item') }}</h3>
                  <p>{{ the_sub_field('Instructions_featured_item') }}</p>
                </div>
              </div>
            @endwhile
          </div>
        </div>          
      </section>
    @endif

    @if( have_rows('faq_plans') )
      <section class="faq-item pt-5 pb-5">
        <div class="container">
          <div class="row">
            <h3 class="headline-faq">{{ _e('FAQ', 'permast') }}</h3>
            <p class="tag-faq">{{ _e('Here a some of our frequently asked questions updated frequently to answer all your requests.', 'permast') }}</p>
            <div class="accordion col-12 p-0" id="accordionExample">
              @while ( have_rows('faq_plans') ) @php the_row() @endphp
              
                <div class="card col-12 p-0">
                  <div class="card-header" id="heading-{{ get_row_index() }}">
                    <a class="collapse-btn col-12 p-0" data-toggle="collapse" data-target="#collapse-{{ get_row_index() }}" aria-expanded="true" aria-controls="collapseOne">
                      {{ the_sub_field('ask_plan') }} <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </a>
                  </div>

                  <div id="collapse-{{ get_row_index() }}" class="collapse" aria-labelledby="heading-{{ get_row_index() }}" data-parent="#accordionExample">
                    <div class="card-body">
                      {{ the_sub_field('question_plan') }}
                    </div>
                  </div>
                </div>

              @endwhile
            </div>
            <p class="copy-faq">Can’t find your question here? <span>Ask a question</span></p>
          </div>
        </div>          
      </section>
    @endif
  @endwhile
@endsection


