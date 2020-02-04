<div class="price-outer-wrapper">
	<div class="price-wrapper <?php echo $featured == 'true'? 'featured':'' // xss ok ?>">
		<h3 class="price-title"><?php echo $title // xss ok ?></h3>
		<div class="price" style="text-align:<?php echo esc_attr( $text_align ) ?>">
			<div class="value-box">
				<div class="value-box-content">
					<span class="value">
						<i><?php echo $currency // xss ok ?></i><span class="number"><?php echo $price // xss ok ?></span>
					</span>
					<span class="meta <?php if ( empty( $duration ) ) echo 'invisible' // xss ok ?>"><?php echo $duration // xss ok ?></span>
				</div>
			</div>

			<div class="content-box">
				<?php echo do_shortcode( $content ) // xss ok ?>
			</div>
			<div class="meta-box">
				<?php if ( !! $summary ):?><p class="description"><?php echo htmlspecialchars_decode( $summary ) // xss ok ?></p><?php endif?>
				<?php
					echo wpv_shortcode_button( array(
		 'link' => $button_link,
		 'bgcolor' => 'accent1',
		 'hover_color' => 'accent1',
		 'style' => 'border',
					), $button_text, 'button' ); // xss ok
				?>
			</div>
		</div>
	</div>
</div>