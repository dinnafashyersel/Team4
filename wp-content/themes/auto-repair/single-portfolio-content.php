<?php

/**
 * Single portfolio content template
 * @package wpv
 */

$client = get_post_meta( get_the_id(), 'portfolio-client', true );
$logo   = get_post_meta( get_the_id(), 'portfolio-logo',   true );

$client = preg_replace( '@</\s*([^>]+)\s*>@', '</$1>', $client );

$content = get_the_content();

$portfolio_options = wpv_get_portfolio_options( 'true', '' );
if ( 'gallery' === $portfolio_options['type'] ) {
	list( , $content ) = WpvPostFormats::get_first_gallery( $content );
}

$content = apply_filters( 'the_content',$content );

$has_right_column  = ! empty( $logo ) || ! empty( $client );
$left_column_width = $has_right_column ? 'grid-4-5' : 'grid-1-1 last';

?>

<div class="row portfolio-content">
	<div class="<?php echo esc_attr( $left_column_width ) ?>">
		<?php echo $content // xss ok ?>
		<?php VamtamTemplates::share( 'portfolio' ) ?>
	</div>

	<?php if ( $has_right_column ) : ?>
		<div class="grid-1-5 last">

			<?php if ( ! empty( $logo ) ) : ?>
				<div class="cell">
					<img src="<?php echo $logo ?>" alt="<?php echo esc_attr( get_the_title() ) ?>"/>
				</div>
			<?php endif ?>

			<div class="cell">
				<div  class="meta-title"><?php _e( 'Date', 'auto-repair' ) ?></div>
				<p class="meta"><?php the_date() ?></p>
			</div>

			<?php if ( ! empty( $client ) ) : ?>
				<div class="cell">
					<div  class="meta-title"><?php _e( 'Client', 'auto-repair' ) ?></div>
					<p class="client-details"><?php echo $client // xss ok ?></p>
				</div>
			<?php endif ?>

			<?php if ( ! empty( $terms_name ) ) : ?>
				<div class="cell">
					<div  class="meta-title"><?php _e( 'Category', 'auto-repair' ) ?></div>
					<p class="meta"><?php echo implode( ', ', $terms_name ); // xss ok ?></p>
				</div>
			<?php endif ?>
		</div>
	<?php endif ?>
</div>
