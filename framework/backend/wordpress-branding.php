<?php
use Roots\Sage\Assets;
/**
* Function Name: Custom Login Logo - custom_login_logo();
* This Function can Change Login Page LOGO, Title and URL
* @param ()
* @return ()
* @link https://codex.wordpress.org/Customizing_the_Login_Form
*/
function custom_login_logo() {
  $logo = get_field('website_logo', 'option');
  if ($logo):
    $logo = $logo;
  else:
    $logo = Utilities::resources_path('/assers/images/logo.png');
  endif;
  ?>
  <style type="text/css">
  .login {
    <?php
    $select_you_design = get_field('select_you_design', 'option');
    if ($select_you_design == 'background-image' ) {
      $background_image = get_field('upload_you_image', 'option');
      ?>
      background-image:url('<?= $background_image; ?>');
      <?php
    }elseif ($select_you_design == 'background-color' ){
      ?>
      background-color:<?= get_field('select_you_color', 'option') ; ?>;
      <?php
    }
    ?>
    background-size: cover;
  }
  .login h1 a {
    background-image: url('<?= $logo; ?>') !important;
    background-size: auto;
    width: auto;
    height: 100px;
    background-position: center center;
  }
  #login p#nav, #login p#backtoblog {
      background-color: #fff;
      padding: 10px !important;
      border-radius: 3px;
      box-shadow: 1px 1px 1px #333;
  }
  </style>
  <?php
}
add_action('login_head', 'custom_login_logo');
function siteurl_login() {
  return get_bloginfo('url');
}
add_filter('login_headerurl', 'siteurl_login');
function login_headertitle() {
  return get_bloginfo('name');
}
add_filter('login_headertext', 'login_headertext');
/**
* Function removes an wp-icon from the Toolbar
* @param type $wp_admin_bar
*/
function remove_wp_logo($wp_admin_bar) {
  $wp_admin_bar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'remove_wp_logo', 999);
/**
* Change the Footer in WordPress Admin Panel
*/
function change_footer_admin() {
  echo '<span id="footer-thankyou"><a href="http://premast.com/" target="_blank">Premast</a>.</span>';
}
add_filter('admin_footer_text', 'change_footer_admin');

function change_footer_version() {
  return ' ';
}
add_filter('update_footer', 'change_footer_version', 9999);
// remove generator tag fro wordpress version
remove_action('wp_head', 'wp_generator');
