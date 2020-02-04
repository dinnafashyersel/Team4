<?php

/**
 * Displays social sharing buttons
 *
 * @package wpv
 */

if ( function_exists( 'sharing_display' ) || class_exists( 'Jetpack_Likes' ) ) {
	if ( function_exists( 'sharing_display' ) ) {
		sharing_display( '', true );
	}

	if ( class_exists( 'Jetpack_Likes' ) ) {
		$custom_likes = new Jetpack_Likes;
		echo $custom_likes->post_likes( '' );
	}

	return;
}

if ( function_exists( 'Easy_Social_Share_Buttons' ) ) {
	if ( ! wpv_get_option( "share-$context-ess" ) ) {
		return;
	}

	$output = do_shortcode( '[ess_post]' );

	if ( ! empty( $output ) ):
	?>
		<div class="clearfix <?php echo apply_filters('wpv_share_class', 'share-btns')?>">
			<div class="sep-3"></div>
			<?php echo $output ?>
		</div>
	<?php
	endif;

	return;
}

global $post;

$networks = array(
	'facebook' => array(
		'link' => 'https://www.facebook.com/sharer/sharer.php?u=',
		'title' => __('Share on Facebook', 'auto-repair'),
		'text' => __('Like', 'auto-repair'),
	),
	'twitter' => array(
		'link' => 'https://twitter.com/intent/tweet?text=',
		'title' => __('Share on Twitter', 'auto-repair'),
		'text' => __('Tweet', 'auto-repair'),
	),
	'googleplus' => array(
		'link' => 'https://plus.google.com/share?url=',
		'title' => __('Share on Google Plus', 'auto-repair'),
		'text' => __('+1', 'auto-repair'),
	),
	'pinterest' => array(
		'link' => 'https://pinterest.com/pin/create/button/?url=',
		'title' => __('Share on Pinterest', 'auto-repair'),
		'text' => __('Pin it', 'auto-repair'),
	),
);

if(VamtamTemplates::has_share($context)):
?>
<div class="clearfix <?php echo apply_filters('wpv_share_class', 'share-btns')?>">
	<div class="sep-3"></div>
	<ul class="socialcount" data-url="<?php esc_attr_e(get_permalink()) ?>" data-share-text="<?php esc_attr_e(get_the_title()) ?>" data-media="">
		<?php foreach($networks as $slug => $cfg): ?>
			<?php if(wpv_get_option("share-$context-$slug")): ?>
				<li class="<?php echo $slug ?>">
					<?php
						$link = $cfg['link'] . urlencode( get_permalink() );

						if ( $slug === 'pinterest' ) {
							$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );

							$link .= '&media=' . urlencode( $thumbnail[0] );
						}
					?>
					<a href="<?php echo esc_url( $link ) ?>" title="<?php esc_attr_e($cfg['title']) ?>">
						<?php echo do_shortcode( "[icon name='$slug']" ) ?>
						<span class="count"><?php echo $cfg['text'] ?></span>
					</a>
				</li>&nbsp;
			<?php endif ?>
		<?php endforeach ?>
	</ul>
</div>
<?php
endif;