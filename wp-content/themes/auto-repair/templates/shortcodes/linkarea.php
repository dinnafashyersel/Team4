<?php
$class = array(
	'linkarea',
	'clearfix',
	$hover_color,
	$class,
	( empty( $background_color ) ? 'background-transparent' : 'background-'.$background_color ),
);

$attrs = '';

if ( ! empty( $hoverclass ) )
	$attrs .= ' data-hoverclass="' . esc_attr( $hoverclass ) . '"';

if ( ! empty( $activeclass ) )
	$attrs .= ' data-activeclass="' . esc_attr( $activeclass ) . '"';

if ( ! empty( $href ) ) {
	$attrs .= ' data-href="' . esc_url( $href ) . '"';
	$attrs .= ' tabindex="1"';
}

if ( ! empty( $target ) )
	$attrs .= ' data-target="' . esc_attr( $target ) . '"';

if ( ! empty( $style ) )
	$attrs .= ' style="' . esc_attr( $style ) . '"';
?>

<div <?php echo $attrs // xss ok ?> class="<?php echo esc_attr( implode( ' ', $class ) ) ?>">
	<?php if ( ! empty( $image ) ): ?>
		<div class="first"><?php wpv_url_to_image( $image ) ?></div>
	<?php elseif ( ! empty( $icon ) ): ?>
		<div class="first"><?php
			echo wpv_shortcode_icon( array(
	   'name' => $icon,
	   'size' => $icon_size,
	   'color' => wpv_sanitize_accent( $icon_color ),
			) ); // xss ok
		?></div>
	<?php endif ?>
	<?php if ( !empty( $content ) ): ?>
		<div class="last"><?php echo do_shortcode( $content ) // xss ok ?></div>
	<?php endif ?>
</div>