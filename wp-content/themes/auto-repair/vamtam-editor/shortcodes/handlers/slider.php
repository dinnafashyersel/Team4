<?php

function wpv_shortcode_slider($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'pager'           => false,
		'controls'        => true,
		'auto'            => false,
		'class'           => '',
		'adaptive_height' => false,
	), $atts));

	$id = md5( uniqid( '', true ) );

	$slides = json_decode( trim( $content ) );

	ob_start();
?>
	<div class="bxslider-wrapper">
		<ul class="bxslider-container" id="<?php echo esc_attr( $id ) ?>">
			<?php foreach ( $slides as $slide ) : ?>
				<li>
					<?php if ( $slide->type == 'img' ) : ?>
						<img src="<?php echo esc_url( $slide->url ) ?>" />
					<?php elseif ( $slide->type == 'html' ) : ?>
						<?php echo $slide->html // xss ok ?>
					<?php endif ?>
				</li>
			<?php endforeach ?>
		</ul>
		<script>
			jQuery(function($) {
				var el = $('#<?php echo esc_attr( $id ) ?>');
				el.data('bxslider', el.bxSlider({
					pager: <?php echo json_encode( $pager ) ?>,
					controls: <?php echo json_encode( $controls ) ?>,
					auto: <?php echo json_encode( $auto ) ?>,
					pause: <?php echo apply_filters( 'vamtam_bxslider_delay', 7000 ) ?>,
					autoHover: true,
					adaptiveHeight: <?php echo json_encode( $adaptive_height ) ?>
				}));
			});
		</script>
	</div>

<?php
	return ob_get_clean();
}
add_shortcode( 'slider', 'wpv_shortcode_slider' );
