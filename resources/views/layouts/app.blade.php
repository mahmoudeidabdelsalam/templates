<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    @if(get_field('body_scripts', 'option'))
      {{ the_field('body_scripts', 'option') }}
    @endif

    @php do_action('get_header') @endphp
    @include('partials/header')
    <div class="wrap" role="document" id="panel">
      <div class="content">
        <main class="main">
          @yield('content')
        </main>
        @if (App\display_sidebar())
          <aside class="sidebar">
            @include('partials.sidebar')
          </aside>
        @endif
      </div>
    </div>
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @php wp_footer() @endphp
  </body>
</html>
