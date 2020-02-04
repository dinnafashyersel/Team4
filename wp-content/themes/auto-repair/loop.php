<?php

/**
 * Catch-all post loop
 */

// display full post/image or thumbs
if ( ! isset( $called_from_shortcode ) ) {
	$image = 'true';
	$show_content = true;
	$nopaging = false;
	$width = 'full';
	$news = false;
	$layout = 'normal';
	$column = 1;
}

global $vamtam_loop_vars;
$old_vamtam_loop_vars = $vamtam_loop_vars;
$vamtam_loop_vars = array(
	'image' => $image,
	'show_content' => $show_content,
	'width' => $width,
	'news' => $news,
	'column' => $column,
	'layout' => $layout,
);

$wrapper_class = array();

$wrapper_class[] = $news ? 'news row' : 'regular';
$wrapper_class[] = $layout;
$wrapper_class[] = $nopaging ? 'not-paginated' : 'paginated';

$cube_options = array();
$data_options = '';

if ( $layout === 'masonry' ) {
	$cube_options = array(
		'layoutMode'        => 'mosaic',
		'sortToPreventGaps' => true,
		'defaultFilter'     => '*',
		'animationType'     => 'quicksand',
		'gapHorizontal'     => 0,
		'gapVertical'       => 30,
		'gridAdjustment'    => 'responsive',
		'mediaQueries'      => VamtamTemplates::scrollable_columns( $column ),
		'displayType'       => 'bottomToTop',
		'displayTypeSpeed'  => 100,
	);

	$wrapper_class[] = 'vamtam-cubeportfolio cbp';

	$data_options = 'data-options="' . esc_attr( json_encode( $cube_options ) ) . '"';

	wp_enqueue_script( 'cubeportfolio' );
	wp_enqueue_style( 'cubeportfolio' );

	$GLOBALS['vamtam_inside_cube'] = true;
}

?>
<div class="loop-wrapper clearfix <?php echo esc_attr( implode( ' ', $wrapper_class ) ) ?>" data-columns="<?php echo esc_attr( $column ) ?>"  <?php echo $data_options // xss ok ?>>
<?php

	do_action( 'wpv_before_main_loop' );

	$i = 0;

	if ( ! isset( $blog_query ) ) {
		$blog_query = $GLOBALS['wp_query'];
	}

	if ( $blog_query->have_posts() ) :
		while ( $blog_query->have_posts() ) : $blog_query->the_post();
			$post_class   = array();
			$post_class[] = 'page-content post-header';
			$post_class[] = $column > 1 || $news ? "grid-1-$column" : 'clearfix';

			if ( $news && 0 === $i % $column ) {
				$post_class[] = 'clearboth';
			}

			if ( ! $blog_query->is_single() ) {
				$post_class[] = 'list-item';
			}

			if ( $layout === 'masonry' ) {
				$post_class[] = 'cbp-item';
			}
?>
			<div <?php post_class( implode( ' ', $post_class ) ) ?> >
				<div>
					<?php get_template_part( 'templates/post', get_post_type() );	?>
				</div>
			</div>
<?php
			$i++;
		endwhile;
	endif;

	do_action( 'wpv_after_main_loop' );
?>
</div>

<?php

if ( ! $nopaging ) {
	$pagination_type = wpv_get_option( 'pagination-type' );

	if ( 'masonry' !== $layout || defined( 'WPV_ARCHIVE_TEMPLATE' ) ) {
		$pagination_type = 'paged';
	}

	VamtamTemplates::pagination( $pagination_type, true, $vamtam_loop_vars, $blog_query );
}

if ( $layout === 'masonry' ) {
	$GLOBALS['vamtam_inside_cube'] = false;
}

$vamtam_loop_vars = $old_vamtam_loop_vars;
