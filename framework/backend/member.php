<?php
/**
 * Create admin Page to list unsubscribed emails.
 */
 // Hook for adding admin menus
 add_action('admin_menu', 'membership_add_pages');
 
 // action function for above hook
 
/**
 * Adds a new top-level page to the administration menu.
 */
function membership_add_pages() {
  add_menu_page( 'Member ship List', 'Member ship', 'manage_options', 'membership-csutom', 'membership_page_callback', '', 1 );
}
 
/**
 * Disply callback for the Unsub page.
 */
 function membership_page_callback() {
    $args = array(
      'post_type' => 'wc_user_membership',
      'post_status'   => array('wcm-active', 'wcm-cancelled', 'wcm-expired', 'wcm-pending'),
      'suppress_filters' => 0,
      'numberposts'   => -1,
      'meta_key'   => 'email_referrals',
    );

    $posts = get_posts($args);

    ?>
    <h3>Member ship List With Referrals</h3>

    <table style="width:100%">
      <tr>
        <th>User</th>
        <th>Referrals</th> 
        <th>Status</th>
        <th>Expires on</th>
      </tr>
      <?php
        foreach ($posts as $post):
        setup_postdata( $post ); 
        $author = get_user_by( 'ID', $post->post_author );
        $author_display_name = $author->display_name;
        ?>
        <tr>
          <td><?= $author_display_name; ?></td>
          <td><?= get_post_meta($post->ID, 'email_referrals', TRUE); ?></td>
          <td><?= get_post_status($post->ID, 'post_status', TRUE); ?></td>
          <td><?= (get_post_meta( $post->ID, '_end_date', true ))? get_post_meta( $post->ID, '_end_date', true ):'-'; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <style>
        th {
          text-align: left;
        }
        th, td {
          border: 1px solid #ccc;
          padding: 10px;
        }
    </style>
    <?php 
 }