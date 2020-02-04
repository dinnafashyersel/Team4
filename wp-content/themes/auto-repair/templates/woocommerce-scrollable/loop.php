<?php

/**
 * Scrollable blog
 *
 * @package wpv
 */

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
	'mediaQueries'     => VamtamTemplates::scrollable_columns( $columns ),
	'gapHorizontal'    => 0,
	'gapVertical'      => 30,
	'displayTypeSpeed' => 100,
);

wp_enqueue_script( 'cubeportfolio' );
wp_enqueue_style( 'cubeportfolio' );

$GLOBALS['vamtam_inside_cube'] = true;

VamtamOverrides::unlimited_image_sizes();
?>
<div class="woocommerce woocommerce-scrollable">
	<div class="vamtam-cubeportfolio cbp cbp-slider-edge products vamtam-wc" data-options="<?php echo esc_attr( json_encode( $slider_options ) ) ?>">
		<?php
			if ($products->have_posts()) while ( $products->have_posts() ) :  $products->the_post();
				wc_setup_product_data( $GLOBALS['post'] );
			?>
				<div class="cbp-item">
					<div <?php post_class( 'product' ) ?>>
						<?php get_template_part( 'templates/woocommerce-scrollable/item' );	?>
					</div>
				</div>
			<?php
				unset( $GLOBALS['product'] );
			endwhile;
		?>
	</div>
</div>
<?php
VamtamOverrides::limit_image_sizes();
$GLOBALS['vamtam_inside_cube'] = false;
