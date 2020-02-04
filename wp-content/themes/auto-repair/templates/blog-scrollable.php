<?php

/**
 * Scrollable blog
 *
 * @package wpv
 */

global $vamtam_loop_vars;

$old_vamtam_loop_vars = $vamtam_loop_vars;

$vamtam_loop_vars = array(
	'image'        => $image,
	'show_content' => $show_content,
	'width'        => $width,
	'news'         => true,
	'column'       => $column,
	'scrollable'   => true,
	'layout'       => 'scroll-x',
);

$slider_options = array(
	'layoutMode'       => 'slider',
	'drag'             => true,
	'auto'             => false,
	'autoTimeout'      => 5000,
	'autoPauseOnHover' => true,
	'showNavigation'   => true,
	'showPagination'   => false,
	'scrollByPage'     => false,
	'gridAdjustment'   => 'responsive',
	'mediaQueries'     => VamtamTemplates::scrollable_columns( $column ),
	'gapHorizontal'    => 0,
	'gapVertical'      => 30,
	'displayTypeSpeed' => 100,
);

wp_enqueue_script( 'cubeportfolio' );
wp_enqueue_style( 'cubeportfolio' );

$GLOBALS['vamtam_inside_cube'] = true;

?>
<div class="loop-wrapper clearfix news scroll-x">
	<div class="vamtam-cubeportfolio cbp cbp-slider-edge" data-options="<?php echo esc_attr( json_encode( $slider_options ) ) ?>">
		<?php
			$useColumns = $column > 1;
			$i = 0;
			if ( $blog_query->have_posts() ) while ( $blog_query->have_posts() ) : $blog_query->the_post();
				$last_in_row = (($i + 1) % $column == 0 ||  $blog_query->post_count == $blog_query->current_post + 1);

				$post_class = array();
				$post_class[] = 'page-content post-head';
				$post_class[] = 'list-item';
				$post_class[] = 'cbp-item';
			?>
				<div <?php post_class( implode( ' ', $post_class ) ) ?>>
					<?php include locate_template( 'templates/post.php' );	?>
				</div>
			<?php
				$i++;
			endwhile;
		?>
	</div>
</div>

<?php

$vamtam_loop_vars = $old_vamtam_loop_vars;

$GLOBALS['vamtam_inside_cube'] = false;
