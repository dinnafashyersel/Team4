<?php
/**
 * textarea
 */

	$rows = isset( $rows ) ? $rows : 5;
?>

<div class="wpv-config-row textarea <?php echo esc_attr( $class ) ?> <?php echo empty( $desc ) ? 'no-desc':'' // xss ok ?>">
	<div class="rtitle">
		<h4>
			<label for="<?php echo esc_attr( $id ) ?>"><?php echo $name // xss ok ?></label>
		</h4>

		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<textarea id="<?php echo esc_attr( $id ) ?>" rows="<?php echo esc_attr( $rows ) ?>" name="<?php echo esc_attr( $id ) ?>" class="large-text code <?php wpv_static( $value )?>"><?php echo esc_textarea( wpv_get_option( $id, $default ) ) ?></textarea>
	</div>
</div>
