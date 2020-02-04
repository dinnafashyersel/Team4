<?php
/**
 * color input
 */
?>
<div class="wpv-config-row clearfix <?php echo esc_attr( $class ) ?>">
	<div class="rtitle">
		<h4><?php echo $name // xss ok ?></h4>

		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<div class="color-input-wrap">
			<input name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" type="text" value="<?php echo esc_attr( wpv_get_option( $id, $default ) ) ?>" class="wpv-color-input <?php wpv_static( $value )?>" required />
		</div>
	</div>
</div>