<?php
	/*
		range input
	*/

	$min   = isset( $min ) ? "min='$min' " : '';
	$max   = isset( $max ) ? "max='$max' " : '';
	$step  = isset( $step ) ? "step='$step' " : '';
	$unit  = isset( $unit ) ? $unit : '';
	$class = isset( $class ) ? $class : '';
?>

<div class="wpv-config-row <?php echo esc_attr( $class ) ?> clearfix">
	<div class="rtitle">
		<h4><?php echo $name // xss ok ?></h4>

		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<div class="range-input-wrap clearfix">
			<span>
				<input name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" type="text" value="<?php echo wpv_get_option( $id, $default )?>" <?php echo $min.$max.$step // xss ok ?> class="wpv-range-input <?php wpv_static( $value )?>" />
				<span><?php echo $unit // xss ok ?></span>
			</span>
		</div>

	</div>
</div>