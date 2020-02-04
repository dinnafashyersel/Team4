<?php
/**
 * Various static template helpers
 *
 * @package  wpv
 */
/**
 * class VamtamTemplates
 */
class VamtamTemplates {

	private static $in_page_wrapper = false;

	/**
	 * Returns the current layout type and defines WPV_LAYOUT accordingly
	 *
	 * @return string current page layout
	 */
	public static function get_layout() {
		global $post;

		if ( ! defined( 'WPV_LAYOUT_TYPE' ) ) {
			if ( wpv_has_woocommerce() ) {
				$id_override = is_single() ? $post->ID : ( wc_get_page_id( 'shop' ) ? wc_get_page_id( 'shop' ) : null );
				if ( is_shop() || is_product_category() || is_product_tag() ) {
					define( 'WPV_LAYOUT_TYPE', wpv_post_meta_default( 'layout-type', 'default-body-layout', $id_override ) );
					return WPV_LAYOUT_TYPE;
				}
			}

			if ( is_404() || is_page_template( 'page-blank.php' ) ) {
				define( 'WPV_LAYOUT_TYPE', 'full' );
				define( 'WPV_LAYOUT', 'no-sidebars' );
				return WPV_LAYOUT_TYPE;
			}

			$layout_type = '';
			if ( is_singular( WpvFramework::$complex_layout ) || ( wpv_has_woocommerce() && is_woocommerce() ) ) {
				$layout_type = wpv_post_meta_default( 'layout-type', 'default-body-layout' );
			} else {
				$layout_type = wpv_get_option( 'default-body-layout' );
			}

			if ( empty( $layout_type ) ) {
				$layout_type = 'full';
			}

			define( 'WPV_LAYOUT_TYPE', $layout_type );

			switch ( $layout_type ) {
				case 'left-only':
					define( 'WPV_LAYOUT', 'left-sidebar' );
				break;
				case 'right-only':
					define( 'WPV_LAYOUT', 'right-sidebar' );
				break;
				case 'left-right':
					define( 'WPV_LAYOUT', 'two-sidebars' );
				break;
				case 'full':
					define( 'WPV_LAYOUT', 'no-sidebars' );
				break;
			}

			return $layout_type;
		}

		return WPV_LAYOUT_TYPE;
	}

	/**
	 * displays the left sidebar if there is one
	 */
	public static function left_sidebar() {
		$layout_type = VamtamTemplates::get_layout();

		self::$in_page_wrapper = true;

		if ( $layout_type == 'left-only' || $layout_type == 'left-right' ): ?>
			<aside class="<?php echo esc_attr( apply_filters( 'wpv_left_sidebar_class', 'left', $layout_type ) ) ?>">
				<?php WpvSidebars::get_instance()->get_sidebar( 'left' ); ?>
			</aside>
		<?php endif;
	}

	/**
	 * displays the right sidebar if there is one
	 */
	public static function right_sidebar() {
		$layout_type = VamtamTemplates::get_layout();

		if ( $layout_type == 'right-only' || $layout_type == 'left-right' ): ?>
			<aside class="<?php echo esc_attr( apply_filters( 'wpv_right_sidebar_class', 'right', $layout_type ) ) ?>">
				<?php WpvSidebars::get_instance()->get_sidebar( 'right' ); ?>
			</aside>
		<?php endif;

		self::$in_page_wrapper = false;
	}

	/**
	 * Checks whether the main content area is currently being printed
	 *
	 * @return bool True immediately before displaying the left sidebar, false after the right sidebar has been displayed
	 */
	public static function in_page_wrapper() {
		return self::$in_page_wrapper;
	}

	/**
	 * Echoes a pagination in the form of 1 2 [3] 4 5
	 */
	public static function pagination_list( $query = null ) {
		if ( is_null( $query ) ) {
			$query = $GLOBALS['wp_query'];
		}

		$total_pages = (int) $query->max_num_pages;

		if ( $total_pages > 1 ) {
			$big = PHP_INT_MAX;

			if ( isset( $query->query_vars['paged'] ) && $query->query_vars['paged'] ) {
				$current_page = $query->query_vars['paged'];
			} else {
				$current_page = ( get_query_var( 'paged' ) > 1 ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
			}

			echo '<div class="wp-pagenavi">';

			echo '<span class="pages">' . sprintf( __( 'Page %d of %d', 'auto-repair' ), $current_page, $total_pages ) . '</span>'; // xss ok

			echo paginate_links(
	   array(
	   'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	   'format' => '?paged=%#%',
	   'current' => $current_page,
	   'total' => $total_pages,
	   'prev_text' => __( 'Prev', 'auto-repair' ),
	   'next_text' => __( 'Next', 'auto-repair' ),
	   )
			);
			// xss ok

			echo '</div>';
		}
	}

	/**
	 * Displays the pagination code based on the theme options or $pagination_type
	 *
	 * @param  string|null $pagination_type		overrides the pagination settings
	 * @param  bool        $echo                print or return the pagination code
	 * @param  array       $other_vars          vars passed to the remote handler - can be anything but elements must be whitelisted in VamtamLoadMore
	 * @param  object|null $query               WP_Query object
	 */
	public static function pagination( $pagination_type = null, $echo = true, $other_vars = array(), $query ) {
		$output = apply_filters( 'vamtam_pagination', null, $pagination_type );

		if ( is_archive() || is_search() ) {
			$pagination_type = 'paged';
		}

		if ( is_null( $output ) ) {
			if ( is_null( $pagination_type ) ) {
				$pagination_type = wpv_get_option( 'pagination-type' );
			}

			if ( 'load-more' === $pagination_type || 'infinite-scrolling' === $pagination_type ) {
				$max   = $query->max_num_pages;
				$paged = 1;

				if ( isset( $query->query_vars['paged'] ) ) {
					$paged = $query->query_vars['paged'];
				} else {
					$paged = ( get_query_var( 'paged' ) > 1 ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
				}

				$new_query = $query->query;

				$new_query['paged'] = $paged + 1;

				$class = 'lm-btn vamtam-button button-border accent1 hover-accent6';
				if ( 'cube-load-more' === $pagination_type ) {
					$class .= ' vamtam-cube-load-more';
				}

				$output = '';
				if ( (int) $max > (int) $paged ) {
					$url  = remove_query_arg( array( 'page', 'paged' ) );
					$url .= ( strpos( $url, '?' ) === false ) ? '?' : '&';
					$url .= 'paged=' . $new_query['paged'];

					if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
						$url = '#';
					}

					$btext = esc_html__( 'Load more', 'auto-repair' );

					$output = '<div class="load-more clearboth vamtam-pagination-wrapper"><a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . '" data-query="' . esc_attr( json_encode( $new_query ) ) . '" data-other-vars="' . esc_attr( json_encode( $other_vars ) ) . '"><span class="btext" data-text="' . esc_attr( strip_tags( $btext ) ) . '">' . $btext . '</span></a></div>'; wp_enqueue_script( 'wp-mediaelement' );
					wp_enqueue_style( 'wp-mediaelement' );
				}
			} else {
				$output = self::pagination_list( $query );
			}
		}

		if ( $echo ) {
			echo $output; // xss ok
		} else {
			return $output;
		}
	}

	public static function has_breadcrumbs() {
		return ( wpv_get_optionb( 'enable-breadcrumbs' ) && ! is_front_page() && ! is_page_template( 'page-blank.php' ) );
	}

	/**
	 * Displays the breadcrumbs if they are enabled
	 */
	public static function breadcrumbs() {
		if ( ! self::has_breadcrumbs() ) return;
		?>
			<h6 id="header-breadcrumbs">
				<?php dimox_breadcrumbs( '&middot;' ) ?>
			</h6>
		<?php
	}

	/**
	 * Checks whether the current page has a title
	 *
	 * @return boolean whether the current page has a title
	 */
	public static function has_page_header() {
		$post_id = wpv_get_the_ID();

		// the event listing has its own title below the filter
		if ( ( function_exists( 'tribe_is_events_home' ) && tribe_is_events_home() ) || is_post_type_archive( 'tribe_events' ) ) {
			return false;
		}

		if ( is_null( $post_id ) )
			return true;

		if ( is_single() && has_post_format( 'aside' ) )
			return false;

		return get_post_meta( $post_id, 'show-page-header', true ) !== 'false' && ! is_page_template( 'page-blank.php' );
	}

	/**
	 * Page title background styles
	 *
	 * @return string background styles
	 */
	public static function page_header_background() {
		$post_id = wpv_get_the_ID();

		if ( is_null( $post_id ) || ! self::has_page_header() || is_archive() || is_search() )
			return '';

		$bgcolor      = wpv_sanitize_accent( wpv_post_meta( $post_id, 'local-page-title-background-color', true ) );
		$bgimage      = wpv_post_meta( $post_id, 'local-page-title-background-image', true );
		$bgrepeat     = wpv_post_meta( $post_id, 'local-page-title-background-repeat', true );
		$bgsize       = wpv_post_meta( $post_id, 'local-page-title-background-size', true );
		$bgattachment = wpv_post_meta( $post_id, 'local-page-title-background-attachment', true );
		$bgposition   = wpv_post_meta( $post_id, 'local-page-title-background-position', true );

		$style = '';
		if ( ! empty( $bgcolor ) ) {
			$style .= "background-color:$bgcolor;";

			if ( empty( $bgimage ) ) {
				$style .= 'background-image:none;';
			}
		}

		if ( ! empty( $bgimage ) ) {
			$style .= "background-image:url('$bgimage' );";

			if ( ! empty( $bgrepeat ) ) {
				$style .= "background-repeat:$bgrepeat;";
			}

			if ( ! empty( $bgsize ) ) {
				$style .= "background-size:$bgsize;";
			}

			if ( ! empty( $bgattachment ) ) {
				$style .= "background-attachment:$bgattachment;";
			}
		}

		return $style;
	}

	/**
	 * Returns a LESS mixin for generating a readable color based on a bg color
	 *
	 * @return string LESS mixin
	 */
	public static function readable_color_mixin() {
		return "
			.readable-color( @bgcolor:#FFF, @treshold:70, @diff:50% ) when ( iscolor( @bgcolor ) ) and ( lightness( @bgcolor ) >= @treshold ) and ( iscolor( @bgcolor ) ) {
				color: darken( @bgcolor, @diff );
			}

			.readable-color( @bgcolor:#FFF, @treshold:70, @diff:50% ) when ( iscolor( @bgcolor ) ) and ( lightness( @bgcolor ) < @treshold ) and ( iscolor( @bgcolor ) ) {
				color: lighten( @bgcolor, @diff );
			}

			.readable-color( @bgcolor:#FFF, @treshold:70, @diff:50% ) when not ( iscolor( @bgcolor ) ) {}
		";
	}

	/**
	 * Page title color
	 *
	 * @return string color styles
	 */
	public static function page_header_title_color() {
		$post_id = wpv_get_the_ID();

		if ( is_null( $post_id ) || ! self::has_page_header() || is_archive() || is_search() )
			return '';

		$bgcolor = wpv_sanitize_accent( wpv_post_meta( $post_id, 'local-page-title-background-color', true ) );

		$style = '';
		if ( ! empty( $bgcolor ) ) {
			$l = new WpvLessc();
			$l->importDir = '.';
			$l->setFormatter( 'compressed' );

			$style = $l->compile(
	   VamtamTemplates::readable_color_mixin() .
	   "
				.readable-color( $bgcolor, 70, 70% );
				"
			);
		}

		return $style;
	}

	/**
	 * Checks whether the current page has post siblings links
	 *
	 * @return boolean whether the current page has post siblings links
	 */
	public static function has_post_siblings_buttons() {
		return is_singular( array( 'post', 'portfolio' ) ) && current_theme_supports( 'wpv-ajax-siblings' ) && ! is_page_template( 'page-blank.php' );
	}

	/**
	 * Displays the page header
	 *
	 * @param  bool $placed whether the title has already been output
	 * @param  string|null $title if set, overrides the current post title
	 */
	public static function page_header( $placed = false, $title = null ) {
		if ( $placed ) return;

		global $post;

		if ( is_null( $title ) )
			$title = get_the_title();

		$needHeaderTitle = VamtamTemplates::has_page_header();
		$needButtons     = VamtamTemplates::has_post_siblings_buttons();
		$titleColor      = VamtamTemplates::page_header_title_color();

		$description = '';

		if ( is_archive() ) {
			if ( wpv_has_woocommerce() && is_shop() ) {
				$description = get_post_meta( wc_get_page_id( 'shop' ), '_vamtam_description', true );
			} else {
				$description = get_the_archive_description();
			}
		} else if ( ! is_search() && is_object( $post ) ) {
			$description = get_post_meta( $post->ID, '_vamtam_description', true );
		}

		if ( has_post_format( 'link' ) && ! empty( $title ) ) {
			$title = "<a href='" . wpv_post_meta( wpv_get_the_ID(), 'wpv-post-format-link', true ) . "' target='_blank'>$title</a>";
		}

		if ( $needHeaderTitle || $needButtons ):
			?><header class="page-header <?php echo esc_attr( $needButtons ? 'has-buttons':'' ) ?>">
				<div class="page-header-content">
					<?php if ( $needHeaderTitle && ! empty( $title ) ): ?>
						<h1 itemprop="headline" style="<?php echo esc_attr( $titleColor ) ?>">
							<span class="title">
								<span class="entry-title" itemprop="headline"><?php echo wp_kses_post( $title ) ?></span>
								<?php if ( ! empty( $description ) ): ?>
									<div class="desc"><?php echo wp_kses_post( $description ) ?></div>
								<?php endif ?>
							</span>
						</h1>
					<?php endif ?>
					<?php if ( $needButtons ) get_template_part( 'templates/post-siblings-links', $post->post_type ) ?>
				</div>
			</header><?php
		endif;
	}

	/**
	 * Displays the header sidebars
	 */
	public static function header_sidebars() {
		self::header_footer_sidebars( 'header' );
	}

	/**
	 * Displays the footer sidebars
	 */
	public static function footer_sidebars() {
		self::header_footer_sidebars( 'footer' );
	}

	/**
	 * displays header/footer sidebars
	 *
	 * @param string $area one of "header" or "footer"
	 */
	private static function header_footer_sidebars( $area ) {
		$is_active     = false;
		$sidebar_count = (int)wpv_get_option( "$area-sidebars" );

		for ( $i = 1; $i <= $sidebar_count; $i++ ) {
			$is_active = $is_active || is_active_sidebar( "$area-sidebars-$i" );
		}

		if ( $is_active && ! is_page_template( 'page-blank.php' ) ) {
			include locate_template( 'templates/header-footer-sidebars.php' );
		}
	}

	/**
	 * Comments template
	 *
	 * @param  object $comment comment data
	 * @param  array $args    comment arguments
	 * @param  int $depth   comment depth
	 */
	public static function comments( $comment, $args, $depth ) {
		include locate_template( 'templates/comment'. ( isset( $args['vamtam-layout'] ) ? '-'.$args['vamtam-layout'] : '' ) .'.php' );
	}

	/**
	 * Check if the current context has share buttons
	 *
	 * @param  string  $context current view ( page, post, etc. )
	 * @return boolean          whether the current context has share buttons
	 */
	public static function has_share( $context ) {
		return apply_filters(
	  'wpv_has_share',
	  ( wpv_get_option( "share-$context-twitter" ) || wpv_get_option( "share-$context-facebook" ) ||
	  wpv_get_option( "share-$context-googleplus" ) || wpv_get_option( "share-$context-pinterest" ) ),
	  $context
		);
	}

	/**
	 * Displays share buttons depending on $context
	 *
	 * @param string $context current view ( page, post, etc. )
	 */
	public static function share( $context ) {
		include( locate_template( 'templates/share.php' ) );
	}

	/**
	 * Displays the icon for a post format $format
	 * @param  string $format post format slug
	 * @return string         icon html
	 */
	public static function post_format_icon( $format ) {
		?>
		<a class="single-post-format" href="<?php echo esc_attr( add_query_arg( 'format_filter',$format, home_url() ) ) ?>" title="<?php echo esc_attr( get_post_format_string( $format ) ) ?>">
			<?php echo do_shortcode( '[icon name="'.WpvPostFormats::get_post_format_icon( $format ).'"]' ) // xss ok ?>
		</a>
		<?php
	}

	/**
	 * Outputs the page title styles
	 */
	public static function get_title_style() {
		$post_id = wpv_get_the_ID();

		if ( ! current_theme_supports( 'wpv-page-title-style' ) || is_null( $post_id ) )
			return;

		$bgcolor      = wpv_sanitize_accent( wpv_post_meta( $post_id, 'local-title-background-color', true ) );
		$bgimage      = wpv_post_meta( $post_id, 'local-title-background-image', true );
		$bgrepeat     = wpv_post_meta( $post_id, 'local-title-background-repeat', true );
		$bgsize       = wpv_post_meta( $post_id, 'local-title-background-size', true );
		$bgattachment = wpv_post_meta( $post_id, 'local-title-background-attachment', true );
		$bgposition   = wpv_post_meta( $post_id, 'local-title-background-position', true );

		$style = '';
		if ( ! empty( $bgcolor ) ) {
			$style .= "background-color:$bgcolor;";
		}

		if ( ! empty( $bgimage ) ) {
			$style .= "background-image:url('$bgimage' );";

			if ( ! empty( $bgrepeat ) ) {
				$style .= "background-repeat:$bgrepeat;";
			}

			if ( ! empty( $bgsize ) ) {
				$style .= "background-size:$bgsize;";
			}
		}

		return $style;
	}

	/**
	 * Checks whether the current page has a header slider
	 * @return boolean true if there is a header slider
	 */
	public static function has_header_slider() {
		$post_id = wpv_get_the_ID();

		return ! is_null( $post_id ) &&
				apply_filters(
		'wpv_has_header_slider',
		( ! is_404() && wpv_post_meta( $post_id, 'slider-category', true ) !== '' && ! is_page_template( 'page-blank.php' ) )
				);
	}

	/**
	 * This is used to determine whether Cube Portfolio should be enqueued as normal,
	 * or if it should be loader later (on DOMContentLoaded)
	 *
	 * @return book   true if cubeportfolio.js should be enqueued early
	 */
	public static function early_cube_load() {
		return ! self::has_header_slider() && ! self::has_page_header() && ! is_home();
	}

	public static function scrollable_columns( $max ) {
		global $content_width;

		if ( 0 === $max ) {
			$max = 11;
		}

		$min = apply_filters( 'vamtam-scrollable-columns-minimum', 1 ); // should be replaced with min( 2, $max ); if a minimum of two columns is required

		$queries = array();

		$step = ( $content_width - 90 ) / 4;

		// start from site_width/4, increment column count by 1 for every $step px
		for ( $cols = $min; $cols <= $max; ++$cols ) {
			$queries[] = array(
				'width' => ( $cols === $min ? 1 : $cols ) * $step - 30,
				'cols'  => $cols,
			);
		}

		$queries = array_reverse( $queries );

		return apply_filters( 'vamtam-scrollable-columns', $queries, $max );
	}

	/**
	 * Returns true if this is the WP login page
	 *
	 * @return bool whether the current page is wp-login
	 */
	public static function is_login() {
		return strpos( $_SERVER['PHP_SELF'], 'wp-login.php' ) !== false;
	}

	/**
	 * Returns the list of all embeddable sliders to be used in the config generator
	 *
	 * @return array list of sliders
	 */
	public static function get_all_sliders() {
		return array_merge( self::get_layer_sliders(), self::get_rev_sliders() );
	}

	/**
	 * Returns the list of Revolution Slider sliders in 'revslider-ID' => 'Name' array
	 * @return array list of Revolution Slider WP sliders
	 */
	public static function get_rev_sliders( $prefix = 'revslider-' ) {
		$result = array();

		if ( class_exists( 'RevSlider' ) ) {
			$revslider = new RevSlider();
			$sliders   = $revslider->getArrSliders();

			foreach ( $sliders as $item ) {
				$result[$prefix . $item->getAlias()] = $item->getTitle();
			}
		}

		return $result;
	}

	/**
	 * Returns the list of LayerSlider sliders in 'layerslider-ID' => 'Name' array
	 * @return array list of LayerSlider WP sliders
	 */
	public static function get_layer_sliders( $prefix = 'layerslider-' ) {
		$result = array();

		if ( class_exists( 'LS_Sliders' ) ) {
			$sliders = LS_Sliders::find(
	   array(
	   'orderby' => 'date_m',
	   'limit' => 10000,
	   'data' => false,
	   )
			);

			foreach ( $sliders as $item ) {
				$result[$prefix . $item['id']] = $item['name'];
			}
		}

		return $result;
	}

	/**
	 * The formatted output of a list of pages.
	 *
	 * Displays page links for paginated posts ( i.e. includes the "nextpage".
	 * Quicktag one or more times ). This tag must be within The Loop.
	 *
	 * The defaults for overwriting are:
	 * 'next_or_number' - Default is 'number' ( string ). Indicates whether page
	 *      numbers should be used. Valid values are number and next.
	 * 'nextpagelink' - Default is 'Next Page' ( string ). Text for link to next page.
	 *      of the bookmark.
	 * 'previouspagelink' - Default is 'Previous Page' ( string ). Text for link to
	 *      previous page, if available.
	 * 'pagelink' - Default is '%' ( String ).Format string for page numbers. The % in
	 *      the parameter string will be replaced with the page number, so Page %
	 *      generates "Page 1", "Page 2", etc. Defaults to %, just the page number.
	 * 'before' - Default is '<p id="post-pagination"> Pages:' ( string ). The html
	 *      or text to prepend to each bookmarks.
	 * 'after' - Default is '</p>' ( string ). The html or text to append to each
	 *      bookmarks.
	 * 'text_before' - Default is '' ( string ). The text to prepend to each Pages link
	 *      inside the <a> tag. Also prepended to the current item, which is not linked.
	 * 'text_after' - Default is '' ( string ). The text to append to each Pages link
	 *      inside the <a> tag. Also appended to the current item, which is not linked.
	 *
	 * @param string|array $args Optional. Overwrite the defaults.
	 * @return string Formatted output in HTML.
	 */
	public static function custom_link_pages( $args = '' ) {
		$defaults = array(
			'before' => '<p id="post-pagination">' . __( 'Pages:', 'auto-repair' ),
			'after' => '</p>',
			'text_before' => '',
			'text_after' => '',
			'next_or_number' => 'number',
			'nextpagelink' => __( 'Next page', 'auto-repair' ),
			'previouspagelink' => __( 'Previous page', 'auto-repair' ),
			'pagelink' => '%',
			'echo' => 1,
		);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );
		extract( $r, EXTR_SKIP );

		global $page, $numpages, $multipage, $more, $pagenow;

		$output = '';
		if ( $multipage ) {
			if ( 'number' == $next_or_number ) {
				$output .= $before;
				for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
					$j = str_replace( '%', $i, $pagelink );
					$output .= ' ';
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= _wp_link_page( $i );
					else
						$output .= '<span class="current">';

					$output .= $text_before . $j . $text_after;
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= '</a>';
					else
						$output .= '</span>';
				}
				$output .= $after;
			} else {
				if ( $more ) {
					$output .= $before;
					$i = $page - 1;
					if ( $i && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $previouspagelink . $text_after . '</a>';
					}
					$i = $page + 1;
					if ( $i <= $numpages && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $nextpagelink . $text_after . '</a>';
					}
					$output .= $after;
				}
			}
		}

		if ( $echo )
			echo $output; // xss ok

		return $output;
	}
}
