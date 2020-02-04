<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"><?php _e( 'Title:', 'auto-repair' ); ?></label>
	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ) ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ) ?>"><?php _e( 'Type:', 'auto-repair' ); ?></label>
	<select name="<?php echo esc_attr( $this->get_field_name( 'type' ) ) ?>" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ) ?>" class="widefat">
		<option value="user"<?php selected( $type,'user' );?>>User</option>
		<option value="group"<?php selected( $type,'group' );?>>Group</option>
	</select>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'flickr_id' ) ) ?>"><?php _e( 'Flickr ID (<a href="http://www.idgettr.com" target="_blank">idGettr</a>):', 'auto-repair' ); ?></label>
	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'flickr_id' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr_id' ) ) ?>" type="text" value="<?php echo esc_attr( $flickr_id ); ?>" />
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ) ?>"><?php _e( 'Number of photo to show:', 'auto-repair' ); ?></label>
	<input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ) ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3" />
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'display' ) ) ?>"><?php _e( 'Method for display your photos:', 'auto-repair' ); ?></label>
	<select id="<?php echo esc_attr( $this->get_field_id( 'display' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name( 'display' ) ) ?>">
		<option<?php selected( $display, 'latest' )?> value="latest"><?php _e( 'Latest', 'auto-repair' ); ?></option>
		<option<?php selected( $display, 'random' )?> value="random"><?php _e( 'Random', 'auto-repair' ); ?></option>
	</select>
</p>
