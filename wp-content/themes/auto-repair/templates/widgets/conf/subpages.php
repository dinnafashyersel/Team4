<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'auto-repair' ); ?></label>
	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>"><?php _e( 'Sort by:', 'auto-repair' ); ?></label>
	<select name="<?php echo esc_attr( $this->get_field_name( 'sortby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>" class="widefat">
		<option value="menu_order"<?php selected( $instance['sortby'], 'menu_order' ); ?>><?php _e( 'Page order', 'auto-repair' ); ?></option>
		<option value="post_title"<?php selected( $instance['sortby'], 'post_title' ); ?>><?php _e( 'Page title', 'auto-repair' ); ?></option>
		<option value="ID"<?php selected( $instance['sortby'], 'ID' ); ?>><?php _e( 'Page ID', 'auto-repair' ); ?></option>
	</select>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>"><?php _e( 'Exclude:', 'auto-repair' ); ?></label>
	<input type="text" value="<?php echo esc_attr( $exclude ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>" class="widefat" />

	<small><?php _e( 'Page IDs, separated by commas.', 'auto-repair' ); ?></small>
</p>