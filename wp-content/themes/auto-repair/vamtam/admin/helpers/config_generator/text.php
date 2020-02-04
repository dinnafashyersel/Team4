<?php
/**
 * text input
 */
?>

<div class="wpv-config-row text clearfix <?php echo esc_attr( $class ) ?>">

	<div class="rtitle">
		<h4>
			<label for="<?php echo esc_attr( $id ) ?>"><?php echo $name // xss ok ?></label>
		</h4>

		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<input name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" type="text" class="large-text <?php wpv_static( $value )?>" size="<?php echo intval( isset( $size ) ? $size : 10 ) ?>" value="<?php echo esc_attr( wpv_get_option( $id, $default ) ) ?>" />
	</div>
</div>
