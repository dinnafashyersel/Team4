<div class="wpv-config-row clearfix">
	<div class="rtitle">
		<h4><?php echo $name // xss ok ?></h4>

		<?php wpv_description( 'import-skin', $desc ) ?>
	</div>

	<div class="rcontent">
		<select id="import-config-available" class="static">
			<option value=""><?php _e( 'Available skins', 'auto-repair' )?></option>
		</select>
		<input type="button" id="import-config" class="button static" value="<?php echo esc_attr( $name ) ?>" />
		<input type="button" id="delete-config" class="button static" value="<?php esc_attr_e( 'Delete', 'auto-repair' ) ?>" />
		<span class="spinner" style="float:none"></span>
	</div>
</div>