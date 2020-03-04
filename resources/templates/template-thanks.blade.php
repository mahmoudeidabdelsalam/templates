{{--
  Template Name: Thanks Customer
--}}

@extends('layouts.app')

@section('content')
  <section class="header-users page-downloads" style="background-image: linear-gradient(150deg, {{ the_field('gradient_color_one','option') }} 0%, {{ the_field('gradient_color_two','option') }} 100%);">
    <div class="elementor-background-overlay" style="background-image: url('{{ the_field('banner_background_overlay','option') }}');"></div>
    <div class="container">
      <div class="row justify-content-between">
          <h2 class="headline">{{ _e('My Account', 'premast') }}</h2>
          @if (has_nav_menu('user_navigation'))
            {!! wp_nav_menu(['theme_location' => 'user_navigation', 'container' => false, 'menu_class' => 'nav nav-pills flex-column flex-sm-row col-12', 'walker' => new NavWalker()]) !!}
          @endif
      </div>
    </div>        
  </section>
  @while(have_posts()) @php the_post() @endphp
    <div class="container">
      <div class="row text-center height-vh-50">
        <div class="col-12 align-self-center ">
          <img width="100px" class="img-fluid mb-4" src="{{ get_theme_file_uri().'/dist/images/check.png' }}" alt="{{ get_bloginfo('name', 'display') }}" title="{{ get_bloginfo('name') }}"/>
          <h2 class="col-12 text-center align-self-center text-large text-black">{{ _e('Thank You!', 'premast') }}</h2>
          @php the_content() @endphp
          @php ($like_download = get_field('download_page','option') . '?tabs=paid')

          <div class="bottom-summary pr-4 pl-4">
            <a href="{{ $like_download }}">{{ _e("Go to your downloads now", 'premast') }}</a>
          </div>
        </div>
      </div>
    </div>
  @endwhile
@endsection