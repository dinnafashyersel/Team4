<?php
/**
 * single checkbox
 */

$option = $value;
$value = wpv_sanitize_bool( wpv_get_option( $id, $default ) );
?>

<div class="wpv-config-row <?php echo esc_attr( $class ) ?>">
	<div class="ritlte">
		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent clearfix">
		<label>
			<input type="checkbox" name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" value="true" class="<?php wpv_static( $option )?>" <?php checked( $value, true ) ?> />
			<?php echo $name // xss ok ?>
		</label>
	</div>
</div>
