<?php
/**
 * Slider or custom content between the menu and the page title
 *
 * @package wpv
 * @subpackage auto-repair
 */

$post_id    = wpv_get_the_ID();
$content    = do_shortcode( wpv_post_meta( $post_id, 'page-middle-header-content', true ) );
$fullwidth  = wpv_post_meta( $post_id, 'page-middle-header-content-fullwidth', true ) === 'true';
$min_height = wpv_post_meta( $post_id, 'page-middle-header-min-height', true );

if ( ! VamtamTemplates::has_header_slider() && empty( $content ) && empty( $min_height ) ) return;
if ( is_page_template( 'page-blank.php' ) ) return;

$style  = VamtamTemplates::get_title_style();
$style .= "min-height:{$min_height}px";

if ( VamtamTemplates::has_header_slider() ):
?>
<header class="header-middle row type-slider">
	<?php
		$slider = wpv_post_meta( $post_id, 'slider-category', true );
		$slider_engine = strpos( $slider, 'layerslider' ) === 0 ? 'layerslider' : 'revslider';
		?>
		<div id="header-slider-container" class="<?php echo esc_attr( $slider_engine ) ?>">
			<div class="header-slider-wrapper">
				<?php
					get_template_part( 'slider', $slider_engine );
				?>
			</div>
		</div>
</header>
<?php endif ?>

<?php if ( $post_id ): ?>
	<header class="header-middle header-middle-bottom row <?php echo esc_attr( $fullwidth ? 'fullwidth' : 'normal' ) ?> type-featured" style="<?php echo esc_attr( $style ) ?>">
		<?php if ( ! $fullwidth ): ?>
			<div class="limit-wrapper">
				<div class="header-middle-content">
					<?php echo $content // xss ok ?>
				</div>
			</div>
		<?php else: ?>
			<?php echo $content // xss ok ?>
		<?php endif ?>
	</header>
<?php endif; ?>