<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'auto-repair' ); ?></label>
	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
	<label><?php _e( 'Show Avatar:', 'auto-repair' ); ?></label>
	<?php
		$id = $this->get_field_name( 'show_avatar' );
		$checked = $show_avatar;
		include WPV_ADMIN_HELPERS . 'config_generator/toggle-basic.php';
	?>
</p>

<p>
	<label><?php _e( 'Show Post Count:', 'auto-repair' ); ?></label>
	<?php
		$id = $this->get_field_name( 'show_post_count' );
		$checked = $show_post_count;
		include WPV_ADMIN_HELPERS . 'config_generator/toggle-basic.php';
	?>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'How many authors to display?', 'auto-repair' ); ?></label>
	<select id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" class="num_shown" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>">
		<?php for($i=1; $i<=$this->max_authors; $i++): ?>
			<option <?php selected( $i, $count ) ?>><?php echo intval( $i ) ?></option>
		<?php endfor ?>
	</select>
</p>

<div class="authors_wrap hidden_wrap">
	<?php
		for($i=1; $i<=$this->max_authors; $i++):
			$author_id = "author_id_$i";
			$author_desc = "author_desc_$i";
	?>
		<div class="hidden_el" <?php if($i>$count):?>style="display:none"<?php endif;?>>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $author_id ) ); ?>">
					<?php _e( 'Author:', 'auto-repair' )?>
				</label>
				<select name="<?php echo esc_attr( $this->get_field_name( $author_id ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( $author_id ) ); ?>" class="widefat">
					<?php foreach($authors as $user_id => $display_name):?>
						<option value="<?php echo esc_attr( $user_id ) ?>" <?php if($selected_author[$i] == $user_id) echo 'selected="selected"'?>><?php echo esc_html( $display_name ) ?></option>;
					<?php endforeach ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $author_desc ) ); ?>">
					<?php _e( 'Author Description (optional):', 'auto-repair' )?>
				</label>
				<textarea class="widefat" rows="4" cols="20" id="<?php echo esc_attr( $this->get_field_id( $author_desc ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $author_desc ) ); ?>"><?php echo $author_descriptions[$i]; // xss ok ?></textarea>
			</p>

		</div>

	<?php endfor;?>
</div>