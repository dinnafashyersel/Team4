<?php if ( isset( $image ) ) : ?>
	<img src="<?php echo esc_url( $image ) ?>" alt="<?php echo esc_attr( $name ) ?>" class="alignleft" />
<?php endif ?>
<label class="toggle-radio">
	<input type="radio" name="<?php echo esc_attr( $id ) ?>" value="true" <?php checked( $checked, true ) ?>/>
	<span><?php _e( 'On', 'auto-repair' ) ?></span>
</label>
<label class="toggle-radio">
	<input type="radio" name="<?php echo esc_attr( $id ) ?>" value="false" <?php checked( $checked, false ) ?>/>
	<span><?php _e( 'Off', 'auto-repair' ) ?></span>
</label>
<?php if ( isset( $has_default ) && $has_default ) : ?>
	<label class="toggle-radio">
		<input type="radio" name="<?php echo esc_attr( $id ) ?>" value="default" <?php checked( $checked, 'default' ) ?>/>
		<span><?php _e( 'Default', 'auto-repair' ) ?></span>
	</label>
<?php endif ?>