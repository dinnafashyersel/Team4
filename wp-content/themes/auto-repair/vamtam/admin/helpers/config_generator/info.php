<?php
/*
 * info box
 */

$is_open = isset( $visible ) && $visible;

$close = __( 'Close', 'auto-repair' );
$open  = __( 'Open', 'auto-repair' );

$other  = $is_open ? $open : $close;
$normal = $is_open ? $close : $open;

?>

<div class="wpv-config-row config-info <?php echo esc_attr( $class ) ?>">
	<div class="info-wrapper">
		<div class="title"><?php echo $name // xss ok ?></div>
		<a href="#" data-other="<?php echo esc_attr( $other ) ?>"><?php echo $normal // xss ok ?></a>
		<div class="desc <?php if ( $is_open ) echo 'visible' // xss ok ?>"><?php echo $desc // xss ok ?></div>
	</div>
</div>