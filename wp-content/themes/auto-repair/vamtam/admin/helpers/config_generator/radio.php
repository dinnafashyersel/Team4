<?php
/**
 * radio
 */

	if ( isset( $target ) ) {
		if ( isset( $options ) ) {
			$options = $options + WpvConfigGenerator::get_select_target_config( $target );
		} else {
			$options = WpvConfigGenerator::get_select_target_config( $target );
		}
	}

	$checked = wpv_get_option( $id, $default );

	$ff = empty( $field_filter ) ? '' : 'data-field-filter="' . esc_attr( $field_filter ) . '"';
?>

<div class="wpv-config-row radio clearfix <?php echo esc_attr( $class ) ?>" <?php echo $ff // xss ok  ?>>

	<div class="rtitle">
		<h4><label for="<?php echo esc_attr( $id ) ?>"><?php echo $name // xss ok ?></label></h4>

		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<?php foreach ( $options as $key => $option ) : ?>
			<label class="toggle-radio">
				<input type="radio" name="<?php echo esc_attr( $id ) ?>" value="<?php echo esc_attr( $key )  ?>" <?php checked( $checked, $key ) ?>/>
				<span><?php echo $option // xss ok ?></span>
			</label>
		<?php endforeach ?>
	</div>
</div>
