{{--
  Template Name: Custom Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <div class="custom-header">
    <div class="elementor-background-overlay" style="background-image:url('{{ the_field('header_section_image', 'option') }}')"></div>
      @include('partials.page-header')
    </div>

    <div class="container">
      <div class="row align-items-center">
        @include('partials.content-page')
      </div>
    </div>
  @endwhile
@endsection
