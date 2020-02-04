<?php
/**
 * Sortable portfolio filter header
 *
 * @package wpv
 * @subpackage hair
 */
?>
<nav class="portfolio-filters clearfix" data-for="#<?php echo esc_attr( $main_id ) ?>">
	<div class="cbp-l-filters-alignCenter cbp-l-filters-dropdown" id="<?php echo esc_attr( $main_id ) ?>-filters">
		<div class="cbp-l-filters-dropdownWrap">
			<div class="cbp-l-filters-dropdownHeader"><?php esc_html_e( 'All', 'auto-repair' ) ?></div>
			<div class="cbp-l-filters-dropdownList">
				<span class="inner-wrapper">
					<span data-filter="*" class="cbp-filter-item-active cbp-filter-item"><?php esc_html_e( 'All', 'auto-repair' )?> <span class="cbp-filter-counter"></span></span>
					<?php
						// show the categories present in this listing
						$terms = array();
						if ( ! empty( $cat ) && $cat != 'null' ) {
							foreach ( $cat as $term_slug ) {
								$term = get_term_by( 'slug', $term_slug, 'portfolio_category' );

								if ( $term ) {
									$terms[] = $term;
								}
							}
						} else {
							$terms = get_terms( 'portfolio_category', 'hide_empty=1' );
						}
					?>
					<?php foreach ( $terms as $term ) :  ?>
						<?php $filter = '[data-type~="' . esc_attr( preg_replace( '/[\pZ\pC]+/u', '-', $term->slug ) ) . '"]'; ?>
						<span data-filter="<?php echo esc_attr( $filter ) ?>" class="cbp-filter-item"><span data-text="<?php echo esc_attr( $term->name ) ?>"><?php echo esc_html( $term->name ) ?> <span class="cbp-filter-counter"></span></span></span>
					<?php endforeach ?>
				</span>
			</div>
		</div>
	</div>
</nav>
