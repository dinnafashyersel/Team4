<p class="save-wpv-config">
	<input type="hidden" name="page" value="<?php echo esc_attr( $_GET['page'] ) ?>" class="static" />
	<input type="hidden" name="action" value="wpv-save-options" class="static" />
	<input type="submit" name="save-wpv-config" class="button-primary autowidth static" value="<?php isset( $_GET['allowreset'] ) ? esc_attr_e( 'Delete options', 'auto-repair' ) : esc_attr_e( 'Save Changes', 'auto-repair' )?>" />
</p>