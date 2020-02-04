<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"><?php _e( 'Title:', 'auto-repair' ); ?></label>
	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ) ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'tooltip' ) ) ?>"><?php _e( 'Tooltip:', 'auto-repair' ); ?></label>
	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tooltip' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name( 'tooltip' ) ) ?>" type="text" value="<?php echo esc_attr( $tooltip ); ?>" />
</p>
