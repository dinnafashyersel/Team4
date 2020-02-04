<?php

/**
 * Portfolio loop template
 *
 * @package wpv
 * @subpackage hair
 */

$li_style = '';

$main_id = uniqid();

$layoutMode = 'grid';

if ( $layout === 'masonry' ) {
	$layoutMode = 'mosaic';
} elseif ( $layout === 'scrollable' ) {
	$layoutMode = 'slider';
}

$cube_options = array(
	'layoutMode'       => $layoutMode,
	'defaultFilter'    => '*',
	'animationType'    => 'slideDelay',
	'gapHorizontal'    => 30,
	'gapVertical'      => 30,
	'gridAdjustment'   => 'responsive',
	'mediaQueries'     => VamtamTemplates::scrollable_columns( $column ),
	'displayType'      => 'bottomToTop',
	'displayTypeSpeed' => 100,
	'showPagination'   => false,
);

if ( 'ajax' === $link_opens ) {
	$cube_options = array_merge( $cube_options, array(
		'singlePageDelegate'         => '.cbp-singlePage',
		'singlePageDeeplinking'      => true,
		'singlePageStickyNavigation' => true,
		'singlePageCounter'          => '<div class="cbp-popup-singlePage-counter">' . esc_html__( '{{current}} of {{total}}', 'auto-repair' ) . '</div>',
		'singlePageCallback'         => 'portfolio',
		'singlePageAnimation'        => 'fade',
	) );

	if ( function_exists( 'sharing_display' ) ) {
		wp_enqueue_style( 'sharedaddy' );

		sharing_display( '', true );
	}
}

wp_enqueue_script( 'cubeportfolio' );
wp_enqueue_style( 'cubeportfolio' );

$GLOBALS['vamtam_inside_cube'] = true;

?>

<section class="portfolios normal clearfix title-<?php echo esc_attr( $title ) ?> <?php echo $desc ? 'has-description' : 'no-description' ?> <?php if ( ! empty( $class ) ) echo esc_attr( $class ) ?>" id="<?php echo esc_attr( $main_id ) ?>">
	<?php
		if ( $layout === 'masonry' || $layout === 'fit-rows' ) {
			include locate_template( 'templates/portfolio/loop/filters.php' );

			$cube_options['filters'] = '#' . $main_id . '-filters';
		}
	?>
	<div class="portfolio-items vamtam-cubeportfolio cbp portfolio-items <?php if( $layoutMode === 'slider' ) echo 'cbp-slider-edge' ?>" data-columns="<?php echo intval( $column ) ?>" data-options="<?php echo esc_attr( json_encode( $cube_options ) ) ?>" data-hidden-by-filters="<?php esc_attr_e( 'New items were loaded, but they are hidden because of your choice of filters', 'auto-repair' ) ?>">
		<?php
			while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
				include locate_template( 'templates/portfolio/loop/item.php' );
			endwhile;
		?>
	</div>
	<?php if ($nopaging == 'false')	VamtamTemplates::pagination( null, true, $atts, $portfolio_query ); ?>
</section>

<?php

$GLOBALS['vamtam_inside_cube'] = false;
