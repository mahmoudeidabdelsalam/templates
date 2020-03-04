<?php
 /**
 * Load all custome fields folder
 * Load all page templates
 */

 $files = array_merge(
   glob(__DIR__.'/utilities/*.php'),
   glob(__DIR__.'/hooks/*.php'),
   glob(__DIR__.'/custom-fields/*.php'),
   glob(__DIR__.'/post-type/*.php'),
   glob(__DIR__.'/taxonomies/*.php'),
   glob(__DIR__.'/backend/*.php'),
   glob(__DIR__.'/ajax/*.php'),
   glob(__DIR__.'/widgets/*.php')
 );
 
 foreach ($files as $filename)
 {
   include $filename;
 }

add_action('wp_logout','auto_redirect_after_logout');
function auto_redirect_after_logout(){
  wp_redirect( home_url() );
  exit();
}