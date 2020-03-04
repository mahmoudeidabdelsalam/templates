{{--
  Template Name: User Profile
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
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-12 side-menu-user">
          <h2 class="headline text-primary">{{ _e('My Account', 'premast') }}</h2>
          @if (has_nav_menu('user_navigation'))
            {!! wp_nav_menu(['theme_location' => 'user_navigation', 'container' => false, 'menu_class' => 'nav nav-pills flex-column flex-sm-row col-12', 'walker' => new NavWalker()]) !!}
          @endif
        </div>
        <div class="col-md-2 col-12">
        </div>
        <div class="entry-content entry col-md-7 col-12 pl-0 pr-0 pt-5 pb-5">
          <?php
            $error = array();
            global $current_user, $wp_roles;
            if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />", $error) . '</p>'; 
          ?>
            <form method="post" id="adduser" action="<?php the_permalink(); ?>">
              <div class="row">
                <div class="col-md-12 col-sm-12 user-images">
                  <?php do_action('edit_user_profile', $current_user); ?>
                </div>
                <div class="col-md-12 col-sm-12 user-forms">
                  <p class="form-username">
                    <label for="first-name">{{ _e('First Name', 'profile') }}</label>
                    <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
                  </p><!-- .form-username -->
                  <p class="form-username">
                    <label for="last-name">{{ _e('Last Name', 'profile') }}</label>
                    <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
                  </p><!-- .form-username -->
                  <p class="form-email">
                    <label for="email">{{ _e('E-mail', 'profile') }} <span class="require">*</span></label>
                    <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
                  </p><!-- .form-email -->
                  <p class="form-url">
                    <label for="description">{{ _e('job title', 'profile') }}</label>
                    <input class="text-input" name="description" type="text" id="description" value="<?php the_author_meta( 'description', $current_user->ID ); ?>" />
                  </p><!-- .form-url -->
                  <p class="form-password">
                    <label for="pass1">{{ _e('Password', 'profile') }} <span class="require">*</span></label>
                    <input class="text-input" name="pass1" type="password" id="pass1" placeholder="********"/>
                  </p><!-- .form-password -->
                  <p class="form-password">
                    <label for="pass2">{{ _e('Repeat Password', 'profile') }} <span class="require">*</span></label>
                    <input class="text-input" name="pass2" type="password" id="pass2" placeholder="********" />
                  </p><!-- .form-password -->

                  <p class="form-submit col-12 mt-5 pl-0">
                    <input name="updateuser" type="submit" id="updateuser" class=" submit button" value="<?php _e('Save changes', 'profile'); ?>" />
                    <?php wp_nonce_field( 'update-user' ) ?>
                    <input name="action" type="hidden" id="action" value="update-user" />
                  </p>
                </div>
              </div>
            </form> 
          <?php 
          endwhile;
          endif; ?>
        </div>
      </div>
    </div>
  </section>

  @endif
@endsection