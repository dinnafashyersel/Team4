<?php
/**
 * Post content template
 *
 * @package wpv
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$page_links = VamtamTemplates::custom_link_pages( array(
	'before' => '<div class="wp-pagenavi"><span class="visuallyhidden">' . __( 'Pages:', 'auto-repair' ) . '</span>',
	'after' => '</div>',
	'echo' => false,
) );

if ( empty( $post_data['content'] ) && isset( $post_data['media'] ) && ( is_single() ? !VamtamTemplates::has_share( 'post' ) : true ) && empty( $page_links ) ) return;

?>
<div class="post-content the-content">
	<?php
		do_action( 'wpv_before_post_content' );

		if ( !empty( $post_data['content'] ) ) {
			if ( !is_single() || !has_post_format( 'quote' ) )
				echo $post_data['content']; // xss ok
		}

		do_action( 'wpv_after_post_content' );

		echo $page_links; // xss ok
	?>
</div>