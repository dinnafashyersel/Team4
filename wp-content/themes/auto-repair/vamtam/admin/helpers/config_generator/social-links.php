<?php
/**
 * social links
 */

$data = wpv_get_option( $id, $default );
if ( empty( $data ) ) {
	$data = '[]';
}
?>

<div class="wpv-config-row social-links <?php echo esc_attr( $class ) ?> <?php echo empty( $desc ) ? 'no-desc' : '' // xss ok ?>">
	<div class="rtitle">
		<h4>
			<label for="<?php echo esc_attr( $id ) ?>"><?php echo $name // xss ok ?></label>
		</h4>

		<?php wpv_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<div class="wpv-config-icons-selector hidden">
			<input type="search" placeholder="<?php esc_attr_e( 'Filter icons', 'auto-repair' ) ?>" class="icons-filter"/>
			<div class="icons-wrapper spinner">
				<input type="radio" value="" checked="checked"/>
			</div>
		</div>
		<div class="social-links-builder"></div>
		<textarea id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>" class="data hidden <?php wpv_static( $value )?>"><?php echo $data // xss ok ?></textarea>
	</div>
</div>
