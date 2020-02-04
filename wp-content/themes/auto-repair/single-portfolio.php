<?php
/**
 * Single portfolio template
 *
 * @package wpv
 * @subpackage auto-repair
 */

get_header(); ?>
	<div class="row page-wrapper">
		<?php VamtamTemplates::left_sidebar() ?>

		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
		?>
				<?php
					$rel_group = 'portfolio_'.get_the_ID();
					extract( wpv_get_portfolio_options( 'true', $rel_group ) );

					list( $terms_slug, $terms_name ) = wpv_get_portfolio_terms();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( VamtamTemplates::get_layout().' '.$type ); ?>>
					<div class="page-content">
						<?php
							global $wpv_has_header_sidebars;
							if ( $wpv_has_header_sidebars ) {
								VamtamTemplates::header_sidebars();
							}

							$column_width = wpv_get_central_column_width();
							$size = $column_width;
						?>

						<div class="clearfix">
						<?php if ( 'document' !== $type ) : ?>
							<div class="portfolio-image-wrapper fullwidth-folio">
								<?php
									if ( 'gallery' === $type ) :
										list( $gallery, ) = WpvPostFormats::get_first_gallery( get_the_content(), null, 'single-portfolio' );
										echo do_shortcode( $gallery ); // xss ok
									elseif ( 'video' === $type ) :
										global $wp_embed;
										echo do_shortcode( $wp_embed->run_shortcode( '[embed width="'.$size.'"]'.$href.'[/embed]' ) ); // xss ok
									elseif ( 'html' === $type ) :
										echo do_shortcode( get_post_meta( get_the_ID(), 'portfolio-top-html', true ) ); // xss ok
									else :
										the_post_thumbnail( 'single-portfolio' );
									endif;
								?>
							</div>
						<?php endif ?>
						</div>

						<div class="portfolio-text-content">
							<?php get_template_part( 'single-portfolio', 'content' ); ?>
						</div>

						<div class="clearboth">
							<?php comments_template(); ?>
						</div>
					</div>
				</article>
			<?php endwhile ?>
		<?php endif ?>

		<?php VamtamTemplates::right_sidebar() ?>

		<?php if ( wpv_get_optionb( 'show-related-portfolios' ) && WPV_Portfolio::in_category( $terms_slug ) > 1 ) : ?>
			<div class="related-portfolios">
				<div class="clearfix">
					<div class="grid-1-1">
						<?php echo apply_filters( 'wpv_related_portfolios_title', '<h2 class="related-content-title">'.wpv_get_option( 'related-portfolios-title' ).'</h3>' ) // xss ok ?>
						<?php echo WPV_Portfolio::shortcode( array(
							'column' => 4,
							'cat' => $terms_slug,
							'ids' => '',
							'max' => 8,
							'height' => 400,
							'title' => 'below',
							'desc' => true,
							'more' => __( 'View', 'auto-repair' ),
							'nopaging' => 'true',
							'group' => 'true',
							'layout' => 'scrollable',
							'post__not_in' => get_the_ID(),
						) ); // xss ok ?>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
<?php get_footer(); ?>
