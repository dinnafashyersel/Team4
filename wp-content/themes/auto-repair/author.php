<?php
/**
 * Author template
 *
 * @package wpv
 * @subpackage auto-repair
 */

$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
$description = get_the_author_meta( 'description', $author->ID );

$wpv_title = "<a href='" . get_author_posts_url( $author->ID ) . "' rel='me'>" . ( $author->data->display_name ) . '</a>';

rewind_posts();
get_header();

?>

<div class="row page-wrapper">
	<?php VamtamTemplates::left_sidebar() ?>

	<article class="<?php echo esc_attr( VamtamTemplates::get_layout() ) ?>">
		<?php
			global $wpv_has_header_sidebars;
			if ( $wpv_has_header_sidebars ) {
				VamtamTemplates::header_sidebars();
			}
		?>
		<div class="page-content">
			<?php if ( ! empty( $description ) ) : ?>
				<div class="author-info-box clearfix">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email', $author->ID ), 60 ); // xss ok ?>
					</div>
					<div class="author-description">
						<h4><?php printf( __( 'About %s', 'auto-repair' ), $author->data->display_name ); ?></h4>
						<?php echo wp_kses_post( $description ) ?>
					</div>
				</div>
			<?php endif; ?>
			<?php rewind_posts() ?>
			<?php if ( have_posts() ) : ?>
				<?php get_template_part( 'loop', 'archive' ) ?>
			<?php else : ?>
				<h2 class="no-posts-by-author"><?php printf( __( '%s has not published any posts yet', 'auto-repair' ), $author->data->display_name ) ?></h2>
			<?php endif ?>
		</div>
	</article>

	<?php VamtamTemplates::right_sidebar() ?>
</div>

<?php get_footer(); ?>