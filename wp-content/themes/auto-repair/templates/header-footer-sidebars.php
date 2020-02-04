<div id="<?php echo esc_attr( $area ) ?>-sidebars" data-rows="<?php echo esc_attr( $sidebar_count ) ?>">
	<div class="row" data-num="0">
		<?php for ( $i = 1; $i <= $sidebar_count; $i++ ) : ?>
			<?php
				$active = is_active_sidebar( "$area-sidebars-$i" );
				$empty  = wpv_get_option( "$area-sidebars-$i-empty" );
			?>
			<?php if ( $active || $empty ) : ?>
				<?php
					$width   = wpv_get_option( "$area-sidebars-$i-width" );
					$is_last = wpv_get_option( "$area-sidebars-$i-last" ) || $width == 'full';
					$fit     = ( $width != 'full' ) ? 'fit' : '';
				?>
				<aside class="<?php echo esc_attr( $width ) ?> <?php if ( $is_last ) echo ' last' // xss ok ?><?php if ( $empty ) echo ' empty' // xss ok ?> <?php echo esc_attr( $fit ) ?>">
					<?php dynamic_sidebar( "$area-sidebars-$i" ); ?>
				</aside>
				<?php if ( $is_last && $i !== $sidebar_count ) : ?>
					</div><div class="row" data-num="<?php echo esc_attr( $i ) ?>">
				<?php endif ?>
			<?php endif; ?>
		<?php endfor ?>
	</div>
</div>