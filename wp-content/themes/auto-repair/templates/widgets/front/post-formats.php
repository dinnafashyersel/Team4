<ul class="clearfix">
	<li class="post-format-pad"><a title="<?php esc_attr_e( 'Standard', 'auto-repair' )?>" href="<?php echo esc_url( add_query_arg( 'format_filter', 'standard', home_url() ) ) ?>" class="standard"><?php echo do_shortcode( '[icon name="'.WpvPostFormats::get_post_format_icon( 'standard' ).'"]' ) // xss ok ?></a></li>
	<?php
		$tooltip = empty( $instance['tooltip'] ) ? __( 'View all %format posts', 'auto-repair' ) : $instance['tooltip'];
		foreach ( get_post_format_strings() as $slug => $string ) {
			if ( get_post_format_link( $slug ) ) {
				$post_format = get_term_by( 'slug', 'post-format-' . $slug, 'post_format' );
				if ( $post_format->count > 0 ) {
					echo '<li class="post-format-pad"><a title="' . esc_attr( str_replace( '%format', $string, $tooltip ) ) . '" href="' . esc_url( add_query_arg( 'format_filter', $slug, home_url() ) ) . '" class="' . esc_attr( $slug ) . '">' . do_shortcode( '[icon name="'.WpvPostFormats::get_post_format_icon( $slug ).'"]' ) . '</a></li>'; // xss ok
				}
			}
		}
	?>
</ul>
