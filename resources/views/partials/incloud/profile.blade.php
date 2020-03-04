@php 
  global $wp;
@endphp


@if ( is_user_logged_in() ) 
  @php 
    global $current_user;
    wp_get_current_user();
    $user = wp_get_current_user();
    $allowed_roles = array('vendor', 'administrator');
    $limit_membership = wc_memberships_get_user_active_memberships($current_user->ID);
  @endphp
  <ul class="link-dropdown">
      <li class="item-dropdown"><a class="border-0" href="{{ the_field('admin_dashborad_page','option') }}">{{ _e('My Profile', 'premast') }}</a></li>
      <li class="item-dropdown"><a class="border-0" href="{{ the_field('download_page','option') }}">{{ _e('My Downloads', 'premast') }}</a></li>
      @if ($limit_membership)
        <li class="item-dropdown"><a class="border-0" href="{{ the_field('link_subscription','option') }}">{{ _e('My Subscription', 'premast') }}</a></li>
      @endif
      <li class="item-dropdown"><a class="border-0" href="{{ the_field('link_like_page','option') }}">{{ _e('My Favourites', 'premast') }}</a></li>  
      <hr class="m-0">
    @if (array_intersect($allowed_roles, $user->roles))
      <li class="item-dropdown"><a class="border-0" href="{{ get_author_posts_url( $current_user->ID) }}?dashboard=true">{{ _e('Dashboard', 'premast') }}</a></li>
      <li class="item-dropdown"><a class="border-0" href="{{ get_author_posts_url( $current_user->ID) }}?items=true">{{ _e('My items', 'premast') }}</a></li>
      <li class="item-dropdown"><a class="border-0" href="{{ the_field('link_add_new','option') }}">{{ _e('Upload item', 'premast') }}</a></li>
      <hr class="m-0">
      <li class="item-dropdown"><a class="border-0" href="{{ home_url('/') }}/help-center/">{{ _e('Help Center', 'premast') }}</a></li>
      <li class="item-dropdown" class="border-0">{{ wp_loginout() }}</li>
    @else
      <li class="item-dropdown"><a class="border-0" href="#">{{ _e('become a contributor', 'premast') }}</a></li>
      <li class="item-dropdown"><a class="border-0" href="{{ home_url('/') }}/faq">{{ _e('Help Center', 'premast') }}</a></li>
      <li class="item-dropdown" class="border-0">{{ wp_loginout() }}</li>
    @endif
    <div class="premast-social-icons"> 
      <a class="premast-icon icon-facebook" href="http://facebook.com/premast.co/" target="_blank" rel="nofollow"> <span class="sr-only">Facebook</span> <i class="fa fa-facebook-square"></i> </a> 
      <a class="premast-icon icon-twitter" href="https://twitter.com/Premast_co" target="_blank" rel="nofollow"> <span class="sr-only">Twitter</span> <i class="fa fa-twitter-square"></i> </a> 
      <a class="premast-icon icon-instagram" href="https://www.instagram.com/premast.co/" target="_blank" rel="nofollow"> <span class="sr-only">instagram</span> <i class="fa fa-instagram"></i> </a>
      <a class="premast-icon icon-behance" href="http://behance.net/Premast" target="_blank" rel="nofollow"> <span class="sr-only">Behance</span> <i class="fa fa-behance-square"></i> </a>       
    </div>
  </ul>
@endif


<style>
ul.link-dropdown hr {
    border-color: rgba(151, 151, 151, 0.24);
}
</style>