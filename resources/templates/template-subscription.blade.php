{{--
  Template Name: User Subscription
--}}

@extends('layouts.app')

@section('content')

@if(!is_user_logged_in())
  <div class="container">
    <div class="row justify-content-center m-0">
      <div class="user-not-login">
        <h2>{{ _e('Join us and enjoy with this benefits', 'premast') }}</h2>
        <p>{{ _e('Join Premast today.', 'premast') }}</p>
        <a class="mt-2 login btn btn-blue" href="#" data-toggle="modal" data-target="#LoginUser">{{ _e('Log In', 'premast') }}</a>
      </div>
    </div>
  </div>
@else

@php 
global $current_user;
wp_get_current_user();

$membership  = sv_wc_memberships_my_memberships_shortcode();


$membership_user = $current_user->ID;

$download_limits = somdn_get_user_limits( $membership_user );
$limits_type   = $download_limits['type'];
$limits_amount = $download_limits['amount'];
$limits_freq   = $download_limits['freq'];
$limits_error  = $download_limits['error'];
$freq_name     = $download_limits['freq_name'];


$limit_membership = wc_memberships_get_user_active_memberships($current_user->ID);

if($limit_membership) {
  $plan_id = $limit_membership[0]->plan_id;
  $post_id = $limit_membership[0]->id;
} else {
  $plan_id = false;
  $post_id = false;
}

$downloads_count_total = somdn_get_user_downloads_count_total($current_user->ID);
$downloads_count = somdn_get_user_downloads_count($current_user->ID);


$args = array(
  'post__in' => array($post_id)
);

$posts = get_post($post_id);

$_end_date = get_post_meta( $posts->ID, '_end_date', true );
$end_date = date_i18n('M d, Y', strtotime($_end_date));

$_start_date = get_post_meta( $posts->ID, '_start_date', true );
$start_date = date_i18n('M d, Y', strtotime($_start_date));

$today = date('M d, Y');

$startTimeStamp = strtotime($today);
$endTimeStamp = strtotime($_end_date);

$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400;  // 86400 seconds in one day
$numberDays = intval($numberDays);

@endphp

  <section class="template-users my-membership mt-5">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-3 col-12 side-menu-user">
          <h3 class="headline text-primary">{{ _e('My Account', 'premast') }}</h3>
          @if (has_nav_menu('user_navigation'))
            {!! wp_nav_menu(['theme_location' => 'user_navigation', 'container' => false, 'menu_class' => 'nav nav-pills flex-column flex-sm-row col-12', 'walker' => new NavWalker()]) !!}
          @endif
        </div>
        <div class="col-md-9 col-12 p-0 mb-5 p-5">
          @if ($membership)
            <div class="download-information">
              <div class="plan-information">
                <p>{{ get_the_title($plan_id) }}</p> <p>@if($_end_date) {{ $numberDays }} {{ _e('days left', 'premast') }} @else {{ _e('Free', 'premast') }} @endif</p>
              </div>
              <div class="limit-information">
                <h3>{{ _e('your downloads', 'premast') }}</h3>
                <p><?php printf( _x( '<strong>%1s</strong>', 'premast' ),  somdn_get_user_downloads_count( $membership_user ) ); ?> / <span><?php printf( __( '<strong>%1s</strong>', 'premast' ), $limits_amount ); ?></span></p>
                @php 
                $download_left = $limits_amount - somdn_get_user_downloads_count( $membership_user );
                @endphp
                {{ _e('You’ve', 'premast') }} {{$download_left}} {{ _e('download left this, if you want more you can upgrade your plan', 'premast' )}} {{$freq_name}}
                <a class="btn-limit" href="{{ get_field('link_limit', 'option') }}">{{ _e('upgrade your plan', 'premast') }}</a>  
                <p class="red-limit"> {{ _e('Your subscription expires on') }} {{ $end_date }}</p>
              </div>
            </div>

            <p class="renewed-plan">{{ _e('To continue using our services, please note that your subscribtion needs to be renewed every', 'premast') }} {{($freq_name)? $freq_name:'year'}}</p>
          @endif
        </div>
      </div>
    </div>
  </section>

  @endif
@endsection