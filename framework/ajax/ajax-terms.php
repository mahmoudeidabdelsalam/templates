<?php 

function sub_category() {
  if(isset($_POST['main_catids'])) {
      if($_POST['main_catids'] != 0) {
          $categories=  get_categories('child_of='.$_POST['main_catids'].'&hide_empty=1&taxonomy=product_cat'); 
          foreach ($categories as $cat) {
              $option .= '<option value="'.$cat->term_id.'">';
              $option .= $cat->cat_name;
              $option .= '</option>';
          }
          echo '<option value="0" selected="selected">select child</option>'.$option;
          die();
      } else {
          echo '<option value="0" selected="selected">no child</option>';
      }
  }
}
add_action('wp_ajax_get_sub_category', 'sub_category');
add_action('wp_ajax_nopriv_get_sub_category', 'sub_category');



function sub_child() {
  
  $taxonomyName = "product_cat";
  $parent_terms = $_POST['sub_scat'];
  $terms = get_terms( array('taxonomy' => $taxonomyName, 'include' => $parent_terms, 'hide_empty'  => false, ));

  foreach ( $terms as $term ) {
    $categories = get_terms( $taxonomyName, array( 'parent' => $term->term_id, 'hide_empty' => false ) );
    $option = "";
    foreach ($categories as $cat) {
        $option .= '<option value="'.$cat->term_id.'">';
        $option .= $cat->name;
        $option .= '</option>';
    }   
  }
   
  if($option) {
    echo '<option value="0" selected="selected">select children</option>'.$option;
  } else {
    echo '<option value="0" selected="selected">no children</option>';
  } 

  die();
}
add_action('wp_ajax_get_sub_child', 'sub_child');
add_action('wp_ajax_nopriv_get_sub_child', 'sub_child');
