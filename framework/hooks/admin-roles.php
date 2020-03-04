<?php

add_action( 'init', 'process_user_roles' );

function process_user_roles(){
  global $wp_roles;

  if( is_admin() && !empty( $_GET['page'] ) && $_GET['page'] == 'activate_roles') {
     $current_user = wp_get_current_user();
     $roles = $current_user->roles;
     if(!in_array('administrator', $roles)) return;

      $roles = ['administrator'];
      foreach ($roles as $role) {
          $role = get_role($role);
      }

      remove_role('wcfm_vendor');
      remove_role('disable_vendor');
      remove_role('vendor_staff');
      remove_role('wpseo_editor');
      remove_role('wpseo_manager');
      remove_role('suspended');
      remove_role('pending_user');
      remove_role('css_js_designer');
      remove_role('project_client');
      remove_role('project_collaborator');
      remove_role('project_editor');
      remove_role('project_admin');
      remove_role('shop_worker');
      remove_role('shop_accountant');
      remove_role('manage_schema_options');
      remove_role('seller');
      remove_role('shop_vendor');
      remove_role('shop_manager');


     /************************* products **************************/
     remove_role('vendor');
     add_role('vendor', __('Vendor','premast'), []);
     $roles = ['vendor', 'administrator'];
     foreach ($roles as $role) {
        $role = get_role($role);
        $role->add_cap('read');
        $role->add_cap( 'manage_woocommerce_products' );
        $role->add_cap( 'manage_woocommerce_taxonomies' );
        $role->add_cap( 'manage_woocommerce_orders' );
        $role->add_cap( 'manage_woocommerce_coupons' );
        $role->add_cap( 'edit_product' );
        $role->add_cap( 'read_product' );
        $role->add_cap( 'delete_product' );
        $role->add_cap( 'edit_products' );
        $role->add_cap( 'publish_products' );
        $role->add_cap( 'read_private_products' );
        $role->add_cap( 'delete_products' );
        $role->add_cap( 'delete_private_products' );
        $role->add_cap( 'delete_published_products' );
        $role->add_cap( 'edit_private_products' );
        $role->add_cap( 'edit_published_products' );
        $role->add_cap( 'edit_products' );
        $role->add_cap( 'manage_woocommerce_taxonomies' );
        $role->add_cap( 'manage_woocommerce_orders' );
        $role->add_cap( 'manage_woocommerce' );
        $role->add_cap( 'view_woocommerce_reports' );
        $role->add_cap( 'manage_product_terms' );
        $role->add_cap( 'edit_product_terms' );
        $role->add_cap( 'delete_product_terms' );
        $role->add_cap( 'assign_product_terms' );
        $role->add_cap( 'manage_categories' );
      }

    /************************* products  SEO **************************/
     remove_role('seo');
     add_role('seo', __('SEO','premast'), []);
     $roles = ['seo', 'administrator'];
     foreach ($roles as $role) {
        $role = get_role($role);
        $role->add_cap('read');
        $role->add_cap( 'manage_woocommerce_products' );
        $role->add_cap( 'manage_woocommerce_taxonomies' );
        $role->add_cap( 'manage_woocommerce_orders' );
        $role->add_cap( 'manage_woocommerce_coupons' );
        $role->add_cap( 'manage_options');
        $role->add_cap( 'edit_product' );
        $role->add_cap( 'read_product' );
        $role->add_cap( 'delete_product' );
        $role->add_cap( 'edit_products' );
        $role->add_cap( 'edit_products' );
        $role->add_cap( 'publish_products' );
        $role->add_cap( 'read_private_products' );
        $role->add_cap( 'delete_products' );
        $role->add_cap( 'delete_private_products' );
        $role->add_cap( 'delete_published_products' );
        $role->add_cap( 'edit_private_products' );
        $role->add_cap( 'edit_published_products' );
        $role->add_cap( 'edit_products' );
        $role->add_cap( 'manage_woocommerce_taxonomies' );
        $role->add_cap( 'manage_woocommerce_orders' );
        $role->add_cap( 'manage_woocommerce' );
        $role->add_cap( 'view_woocommerce_reports' );
        $role->add_cap( 'manage_product_terms' );
        $role->add_cap( 'edit_product_terms' );
        $role->add_cap( 'delete_product_terms' );
        $role->add_cap( 'assign_product_terms' );
        $role->add_cap( 'manage_categories' );
        $role->add_cap( 'edit_others_posts' );
        $role->add_cap( 'edit_others_pages' );
        $role->add_cap( 'edit_others_products' );
        $role->add_cap( 'create_posts' );
        $role->add_cap( 'delete_others_posts' );
        $role->add_cap( 'delete_posts' );
        $role->add_cap( 'delete_private_posts' );
        $role->add_cap( 'delete_published_posts' );
        $role->add_cap( 'edit_others_posts' );
        $role->add_cap( 'edit_posts' );
        $role->add_cap( 'edit_private_posts' );
        $role->add_cap( 'edit_published_posts' );
        $role->add_cap( 'publish_posts' );
        $role->add_cap( 'read_private_posts' );
        $role->add_cap( 'manage_schema' );
        $role->add_cap( 'manage_schema_options' );
      }

      // Assign the Pages post type and Media to all roles
      $roles = $wp_roles->role_names;
      foreach ($roles as $role => $role_name) {
        $role = get_role($role);
        $role->add_cap('edit_others_pages');
        $role->add_cap('edit_pages');
        $role->add_cap('edit_private_pages');
        $role->add_cap('edit_published_pages');
        $role->add_cap('publish_pages');
        $role->add_cap('read_private_pages');
        $role->add_cap('upload_files');
      }

      $role = get_role( 'author' );
      // This only works, because it accesses the class instance.
      // would allow the author to edit others' posts for current theme only
      $role->add_cap( 'manage_categories' ); 

    echo "Roles Proceed Succesfully";
    die();
    return;
  }
}


$user = wp_get_current_user();
$allowed_roles = array('vendor');
if( array_intersect($allowed_roles, $user->roles ) ) {  
  function remove_menus() {
    remove_menu_page( 'index.php' );                  //Dashboard                 //Jetpack* 
    remove_menu_page( 'edit.php' );                   //Posts
    remove_menu_page( 'upload.php' );                 //Media
    remove_menu_page( 'edit.php?post_type=page' );    //Pages
    remove_menu_page( 'edit-comments.php' );          //Comments
    remove_menu_page( 'themes.php' );                 //Appearance
    remove_menu_page( 'plugins.php' );                //Plugins
    remove_menu_page( 'users.php' );                  //Users
    remove_menu_page( 'tools.php' );                  //Tools
    remove_menu_page( 'options-general.php' );        //Settings
    remove_menu_page( 'edit-tags.php?taxonomy=category' );        //Settings
    remove_menu_page( 'edit-tags.php?taxonomy=post_tag' );        //Settings
    remove_menu_page('woocommerce');  
  }
  add_action( 'admin_menu', 'remove_menus' );
 }


 /**
 * override output of author drop down to include ALL user roles 
 */ 
add_filter('wp_dropdown_users', 'include_all_users');
function include_all_users($output)
{
  //set the $post global for checking user against author 
  global $post; 
  $args = array('role__in' => array('administrator', 'vendor', 'author')); 
  $users = get_users($args);
	$current_user =  wp_get_current_user();

    $output = '<select id="post_author_override" name="post_author_override" class="">';
    //Loop through each user
    foreach($users as $user){
			if($post->post_author == $user->ID) {
				$select =  'selected';
			} else {
				$select = '';
			}
        $output .= '<option value="'.$user->ID.'"'.$select.'>'.$user->user_login.'</option>';
    }
    $output .= '</select>';

    return $output;
}

$user = wp_get_current_user();
$allowed_roles = array('seo');
if( array_intersect($allowed_roles, $user->roles ) ) {  
  function hide_baby_boy_hide() { ?>
    <style>
    .wp-admin #woocommerce-product-data, #acf_after_title-sortables {
        opacity: 0;
        visibility: hidden;
        display: none;
    }
    li#menu-media {
      display: nono;
    }

    li#toplevel_page_woocommerce {
      display: none;
    }

    li#toplevel_page_wc-admin-path--analytics-revenue {
      display: none;
    }

    li#menu-users {
      display: none;
    }
    li.wp-not-current-submenu.wp-menu-separator.woocommerce {
      display: none;
    }
    #adminmenu li.wp-menu-separator {
      display: none;
    }
    </style>
  <?php
  }
  add_action('admin_head', 'hide_baby_boy_hide');


  function remove_menus() {
    remove_menu_page( 'jetpack' );                    //Jetpack* 
    remove_menu_page( 'upload.php' );                 //Media
    remove_menu_page( 'edit-comments.php' );          //Comments
    remove_menu_page( 'themes.php' );                 //Appearance
    remove_menu_page( 'plugins.php' );                //Plugins
    remove_menu_page( 'users.php' );                  //Users
    remove_menu_page( 'tools.php' );                  //Tools
  }
  add_action( 'admin_menu', 'remove_menus' );

}
