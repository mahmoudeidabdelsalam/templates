<?php 

function rudr_custom_status_creation(){
	register_post_status( 'rejected', array(
		'label'                     => _x( 'rejected', 'post' ), // I used only minimum of parameters
		'label_count'               => _n_noop( 'rejected <span class="count">(%s)</span>', 'rejected <span class="count">(%s)</span>'),
		'public'                    => true
	));
}
add_action( 'init', 'rudr_custom_status_creation' );


add_action('admin_footer-edit.php','rudr_status_into_inline_edit');
 
function rudr_status_into_inline_edit() { // ultra-simple example
	echo "<script>
	jQuery(document).ready( function() {
		jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"rejected\">rejected</option>' );
	});
	</script>";
}