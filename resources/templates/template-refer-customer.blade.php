{{--
  Template Name: User Customer Refer
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

  <section class="template-users">
    <div class="container-fiuld woocommerce customer-download">
      <div class="row">
        <div class="col-md-3 col-12 side-menu-user">
          <h2 class="headline text-primary">{{ _e('My Account', 'premast') }}</h2>
          @if (has_nav_menu('user_navigation'))
            {!! wp_nav_menu(['theme_location' => 'user_navigation', 'container' => false, 'menu_class' => 'nav nav-pills flex-column flex-sm-row col-12', 'walker' => new NavWalker()]) !!}
          @endif
        </div>
        <div class="col-md-7 col-12 pt-5 mt-5">
          <div class="row align-content-center justify-content-center">
            <div class="col-md-7 col-12">
              <h3>{{ _e('Share the Experience, Invite friends', 'premast') }}</h3>
              <h4 class="headline-linear">{{ _e('& Earn free monthly subscriptions', 'premast') }}</h4>
            </div>
            <div class="col-md-5 col-12 the-content">@php the_content() @endphp</div>
          </div>
          <div class="row ml-0 mr-0 mt-5 mb-5 align-content-center justify-content-center">
            <div class="col-12 p-0">
              <div class="custom-share">
                @php 
                  global $current_user;
                  wp_get_current_user();
                  $form = get_field('forms_referral', 'option');
                  $inputs = get_all_form_fields($form['id']);
                  $link = get_field('link_signup', 'option').'?refer='.$current_user->ID.'&token='.get_the_date('U').'';
                @endphp

                <form class="form-inline" role="" method="post" id="gform_<?= $form['id']; ?>" action="<?= the_permalink(); ?>?send=gf_<?= $form['id']; ?>">
                  <?php foreach ($inputs as $input): ?>
                    <?php if($input["type"] == "email"): ?>
                      <div class="form-group mb-2">
                        <input type="email" name="input_<?= $input["id"]; ?>" class="form-control" id="emailInput" placeholder="write an email">
                      </div>
                    <?php elseif($input["type"] == "hidden"): ?>
                      <input type="text" name="input_<?= $input["id"]; ?>" class="form-control" hidden value="<?= $current_user->display_name; ?>">
                    <?php else: ?>
                      <input type="text" name="input_<?= $input["id"]; ?>" class="form-control" hidden value="<?= $link; ?>">
                    <?php endif; ?>
                  <?php endforeach; ?>
                  <button id="gform_submit_button_<?= $form['id']; ?>" class="btn btn-primary mb-2 shadow-none py-2 px-4"><span>{{ _e('Send Invite', 'premast') }}</span></button>
                  <input type="hidden" class="gform_hidden" name="is_submit_<?= $form['id']; ?>" value="1">
                  <input type="hidden" class="gform_hidden" name="gform_submit" value="<?= $form['id']; ?>">
                  <input type="hidden" class="gform_hidden" name="gform_unique_id" value="">
                  <input type="hidden" class="gform_hidden" name="state_<?= $form['id']; ?>" value="WyJbXSIsImU5YjY1MWMyNzBhYjc5MDI0ZjlmYzlkZjVhMzVmMTZmIl0=">
                  <input type="hidden" class="gform_hidden" name="gform_target_page_number_<?= $form['id']; ?>" id="gform_target_page_number_<?= $form['id']; ?>" value="0">
                  <input type="hidden" class="gform_hidden" name="gform_source_page_number_<?= $form['id']; ?>" id="gform_source_page_number_<?= $form['id']; ?>" value="1">
                  <input type="hidden" name="gform_field_values" value="">
                </form>
               
                <ul class="list-inline social-sharer">
                  <li class="head"><span>{{ _e('Share your link', 'premast') }}</span></li>
                  <li class="list-inline-item">
                    <a class="item" data-network="linkedin" data-url="{{ home_url('/') }}" data-title="{{ $link}}" href="#"> <i class="fa fa-linkedin"></i></a>
                  </li>
                  <li class="list-inline-item">
                    <a class="item" data-network="twitter"  data-url="{{ home_url('/') }}" data-title="{{ $link}}" href="#"> <i class="fa fa-twitter"></i></a>      
                  </li>
                  <li class="list-inline-item">
                    <a class="item" data-network="facebook" data-url="{{ home_url('/') }}" data-title="{{ $link}}" href="#"> <i class="fa fa-facebook"></i></a>      
                  </li>
                  <li class="list-inline-item">
                    <a class="item" data-network="addtoany" data-url="{{ $link }}" data-title="{{ $link }}" href="#"> <i class="fa fa-ellipsis-v"></i></a>      
                  </li>
                </ul>
                <div id="inviteCode" class="invite-page">
                  <input id="link" value="{{ $link }}" readonly>
                  <div id="copy">
                    <i data-copytarget="#link">{{ _e('Copy Link', 'premast') }}</i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 p-0 mt-4">
              <a href="#" class="text-primary">{{ _e('Know more about referral system', 'permast') }} <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
          </div>


          @php 
          $limit = get_field('limit_referral_gift', 'option');
          $token   = isset($_GET['token']) ? $_GET['token'] : '';
          $active   = isset($_GET['active']) ? $_GET['active'] : '';
          $login   = isset($_GET['login']) ? $_GET['login'] : '';

            $args = array(
              'post_type' => 'wc_user_membership',
              'post_status'   => array('wcm-active', 'wcm-expired', 'wcm-pending'),
              'suppress_filters' => 0,
              'numberposts'   => $limit,
              'author' => $current_user->ID
            );
            $posts = get_posts($args);

            $end_date = date('Y-m-d H:i:s', strtotime('+1 months'));
            $start_date = date('Y-m-d H:i:s');
          @endphp

          @if($login == $current_user->ID && $active == 'done' && $token) 
            <h4>{{ _e('Check your progress', 'premast') }}</h4>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">date</th>
                  <th scope="col">Referrals <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" title="name a friend from Invitation"></i></th>
                  <th scope="col">Rewards <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" title="status of Invitation with acion"></i></th>
                  <th scope="col">Expires on <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" title="Date Invitation completed"></i></th>
                </tr>
              </thead>
              <tbody>
              <?php
                foreach ($posts as $post):
                setup_postdata( $post ); 
                $author = get_user_by( 'ID', $post->post_author );
                $author_display_name = $author->display_name;
                $date_stamp = strtotime($post->post_date);
                $postdate = date("M d, Y", $date_stamp);
                $expired = date('M d, Y', strtotime(get_post_meta( $post->ID, '_end_date', true )));
                $ex_active = date('M d, Y', strtotime($post->post_date. ' + 7 days'));
                $status = get_post_status($post->ID, 'post_status', TRUE);
                if($status == 'wcm-active'):
                  $label = '<span class="text-green"> <i class="fa fa-check" aria-hidden="true"></i> Activated</span>';
                elseif($status == 'wcm-pending'):
                  $label = '<a data-id="'.$post->ID.'" href="javascript:void(0)" class="activate-now text-blue" >Activate Now</a>';
                elseif($status == 'wcm-expired'):
                  $label = '<span class="text-red">expired</span>';
                else: 
                  $label = '-';
                endif;

                $user_ref = get_user_by('ID', $token);
                if (get_post_meta($post->ID, 'email_referrals', TRUE) == $user_ref->user_email):
              ?>
                <tr>
                  <td><?= $postdate; ?></td>
                  <td><?= (get_post_meta($post->ID, 'email_referrals', TRUE))? get_post_meta($post->ID, 'email_referrals', TRUE):'-'; ?></td>
                  <td class="rewards" id="<?= $post->ID; ?>"><?= $label; ?></td>
                  <td><?= ($status == 'wcm-pending')? $ex_active:$expired; ?></td>
                </tr>

                @if($status == 'wcm-pending')
                  <script>
                    jQuery(function($) {
                      $( window ).load(function() {
                        var active_id = $('.activate-now').data('id');
                        var status = $('td#' + active_id);
                        
                        $.ajax({
                          url:"<?= admin_url( 'admin-ajax.php' ); ?>",       
                          type:'POST',
                          data: {
                            action: 'get_active',
                            post_id: active_id,
                          },
                          success: function (data) {
                            status.html('<span class="text-green"> <i class="fa fa-check" aria-hidden="true"></i> Activated</span>');
                          },
                        });
                      });
                    });
                  </script>
                @endif
                <?php endif; ?>
              <?php endforeach; ?>
              </tbody>
            </table>
        @else
          <h4>{{ _e('Check your progress', 'premast') }}</h4>
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">date</th>
                <th scope="col">Referrals <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" title="name a friend from Invitation"></i></th>
                <th scope="col">Rewards <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" title="status of Invitation with acion"></i></th>
                <th scope="col">Expires on <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" title="Date Invitation completed"></i></th>
              </tr>
            </thead>
            <tbody>
            <?php
              foreach ($posts as $post):
              setup_postdata( $post ); 
              $author = get_user_by( 'ID', $post->post_author );
              $author_display_name = $author->display_name;
              $date_stamp = strtotime($post->post_date);
              $postdate = date("M d, Y", $date_stamp);
              $expired = date('M d, Y', strtotime(get_post_meta( $post->ID, '_end_date', true )));
              $ex_active = date('M d, Y', strtotime($post->post_date. ' + 7 days'));
              $status = get_post_status($post->ID, 'post_status', TRUE);
              if($status == 'wcm-active'):
                $label = '<span class="text-green"> <i class="fa fa-check" aria-hidden="true"></i> Activated</span>';
              elseif($status == 'wcm-pending'):
                $label = '<a data-id="'.$post->ID.'" href="javascript:void(0)" class="activate-now text-blue" >Activate Now</a>';
              elseif($status == 'wcm-expired'):
                $label = '<span class="text-red">expired</span>';
              else: 
                $label = '-';
              endif;
            ?>
              <tr>
                <td><?= $postdate; ?></td>
                <td><?= (get_post_meta($post->ID, 'email_referrals', TRUE))? get_post_meta($post->ID, 'email_referrals', TRUE):'-'; ?></td>
                <td class="rewards" id="<?= $post->ID; ?>"><?= $label; ?></td>
                <td><?= ($status == 'wcm-pending')? $ex_active:$expired; ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        @endif 
        </div>
        
        <script>
          jQuery(function($) {
            
            $('#copy').on('click', function(event) {
              console.log(event);
              copyToClipboard(event);
            });
            
            function copyToClipboard(e) {
              var
                t = e.target, 
                c = t.dataset.copytarget,
                inp = (c ? document.querySelector(c) : null);
              console.log(inp);
              if (inp && inp.select) {
                inp.select();
                try {
                  document.execCommand('copy');
                  inp.blur();
                  t.classList.add('copied');
                  setTimeout(function() {
                    t.classList.remove('copied');
                  }, 1500);
                } catch (err) {
                  alert('please press Ctrl/Cmd+C to copy');
                }
              }
            }

            $('.activate-now').on('click', function () {
              var active_id = $(this).data('id');
              var status = $('td#' + active_id);
              
              $.ajax({
                url:"<?= admin_url( 'admin-ajax.php' ); ?>",       
                type:'POST',
                data: {
                  action: 'get_active',
                  post_id: active_id,
                },
                success: function (data) {
                  status.html('<span class="text-green"> <i class="fa fa-check" aria-hidden="true"></i> Activated</span>');
                },
              });
            });
          });
        </script>

      </div>
    </div>
  </section>


  <style>
    table.table {
      background: #FFFFFF;
      border: 1px solid #E3E3E3;
      box-sizing: border-box;
      box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
      border-radius: 8px !important;
      overflow: hidden;
      margin: 30px 0;
      border-collapse: initial !important;
    }

    .table thead th {
      border: none !important;
      font-weight: bold;
      font-size: 14px;
      line-height: 21px;
      letter-spacing: 0.04px;
      text-transform: capitalize;
      color: #3F4A59;
      padding-bottom: 20px !important;
    }

    table.table tbody tr:first-child td {
      border: none !important;
    }

    .table td.first {
      font-weight: bold;
      font-size: 14px;
      line-height: 21px;
      letter-spacing: 0.04px;
      color: #646464;
    }

    .table td {
      font-weight: 500;
      font-size: 14px;
      line-height: 21px;
      letter-spacing: 0.04px;
      color: #282F39;
    }
    .table thead th i {
      font-size: 14px;
      line-height: 16px;
      color: #A6A6A6;
      cursor: help;
    }
    .the-content {
    font-size: 16px;
    line-height: 24px;
    letter-spacing: 0.04px;
    color: #000000;
}
  </style>
@endif
@endsection
