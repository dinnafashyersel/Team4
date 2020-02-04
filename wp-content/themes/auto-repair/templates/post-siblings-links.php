<?php

/**
 * Prev/next/view all buttons for posts and portfolio items
 *
 * @package wpv
 * @subpackage auto-repair
 */

global $post;

$same_cat = count( wp_get_object_terms( $post->ID, 'category', array('fields' => 'ids') ) ) > 0;

$tax = $post->post_type === 'post' ? 'category' : 'portfolio_category';

$view_all = wpv_get_option( $post->post_type.'-all-items' );

$prev_anchor = '<span class="icon theme">'.wpv_get_icon( 'theme-arrow-left22' ).'</span>';
$next_anchor = '<span class="icon theme">'.wpv_get_icon( 'theme-arrow-right22' ).'</span>';

?>
<span class="post-siblings">
	<?php previous_post_link( '%link', $prev_anchor, true, array(), $tax ); ?>

	<?php if ( ! empty($view_all) ) : ?>
		<a href="<?php echo esc_url( $view_all ) ?>" class="all-items"><?php echo do_shortcode( '[icon name="theme-grid"]' ) // xss ok ?></a>
	<?php endif ?>

	<?php next_post_link( '%link', $next_anchor, true, array(), $tax ); ?>
</span>