<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Knote
 */

if ( ! function_exists( 'knote_single_postmeta' ) ) :
	/**
	 * Single post meta
	 */
	function knote_single_postmeta( $location = '') {

		$classes = array();
		$alignment = get_theme_mod( 'knote_single_title_alignment', 'left' );
		$delimiter = get_theme_mod( 'knote_archive_delimiter_style', 'none' );
		$elements 	=  get_theme_mod( 'knote_single_meta_elements', array( 'date', 'author' ) );

		$alignment = ( $alignment == 'right' ) ? 'flex-end': 'flex-'.$alignment;
		$classes[] = $location;
		$classes[] = $alignment;
		$classes[] = 'delimiter'.$delimiter;

		echo '<div class="entry-meta ' . esc_attr( implode( ' ', $classes ) ) . '">';
		foreach( $elements as $element ) {
			switch( $element ){
				case 'date':
					knote_posted_on();
					break;

				case 'author':
					knote_posted_by();
					break;

				case 'categories':
					knote_post_categories();
					break;

				case 'comments':
					knote_comment();
					break;
			}
		}
		echo '</div>';
	}
endif;

if ( ! function_exists( 'knote_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function knote_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
		$posted_on = sprintf(
			/* translators: %s: post date */
			__( '<span class="date-label"> </span>%s', 'knote' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$raw = '<span class="posted-on">';
		$raw .= '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>';
		$raw .= $posted_on;
		$raw .= '</span>';
		echo $raw; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'knote_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function knote_posted_by() {
		// Get the author name; wrap it in a link.
		$byline = sprintf(
			/* translators: %s: post author */
			__( '<span class="author-label screen-reader-text">By</span>%s', 'knote' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		$raw = '<span class="byline">';
		$raw .= '<svg width="15" height="14" version="1.1" id="author" fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 512 512">
						<path d="M437.02,330.98c-27.883-27.882-61.071-48.523-97.281-61.018C378.521,243.251,404,198.548,404,148
						C404,66.393,337.607,0,256,0S108,66.393,108,148c0,50.548,25.479,95.251,64.262,121.962
						c-36.21,12.495-69.398,33.136-97.281,61.018C26.629,379.333,0,443.62,0,512h40c0-119.103,96.897-216,216-216s216,96.897,216,216
						h40C512,443.62,485.371,379.333,437.02,330.98z M256,256c-59.551,0-108-48.448-108-108S196.449,40,256,40
						c59.551,0,108,48.448,108,108S315.551,256,256,256z"/>
					</svg>';
		$raw .=  $byline;
		$raw .=  '</span>';
		echo $raw; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'knote_comment' ) ) :
	/**
	 * Prints HTML with meta information for the comment.
	 */
	function knote_comment() {
		if ( is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			$before = '<span class="comments-link">';
            $before .= '<svg height="15" viewBox="-21 -47 682.66669 682" width="14px" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
							<path d="m552.011719-1.332031h-464.023438c-48.515625 0-87.988281 39.464843-87.988281 87.988281v283.972656c0 48.414063 39.300781 87.816406 87.675781 87.988282v128.863281l185.191407-128.863281h279.144531c48.515625 0 87.988281-39.472657 87.988281-87.988282v-283.972656c0-48.523438-39.472656-87.988281-87.988281-87.988281zm50.488281 371.960937c0 27.835938-22.648438 50.488282-50.488281 50.488282h-290.910157l-135.925781 94.585937v-94.585937h-37.1875c-27.839843 0-50.488281-22.652344-50.488281-50.488282v-283.972656c0-27.84375 22.648438-50.488281 50.488281-50.488281h464.023438c27.839843 0 50.488281 22.644531 50.488281 50.488281zm0 0"/>
							<path d="m171.292969 131.171875h297.414062v37.5h-297.414062zm0 0"/>
							<path d="m171.292969 211.171875h297.414062v37.5h-297.414062zm0 0"/>
							<path d="m171.292969 291.171875h297.414062v37.5h-297.414062zm0 0"/>
						</svg>';
			$after = '</span>';
			echo $before; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( '0 Comment<span class="screen-reader-text"> on %s</span>', 'knote' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo $after; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

	}
endif;

function knote_post_categories(){
	if ( 'post' === get_post_type() ) {
		$categories_list = get_the_category_list( esc_html__( ', ', 'knote' ) );
		if ( $categories_list ) { ?>
			<div class="block-category-links">
				<svg id="folder" fill="currentColor" width="14" height="12" viewBox="0 0 520 520" xmlns="http://www.w3.org/2000/svg">
					<path d="m475 125.016v-35.016c0-24.813-20.187-45-45-45h-210.599l-7.859-12.834c-2.727-4.452-7.571-7.166-12.792-7.166h-153.75c-24.813 0-45 20.187-45 45v380c0 24.813 20.187 45 45 45h430c24.813 0 45-20.187 45-45v-279.984c0-24.813-20.187-45-45-45zm-45-50.016c8.271 0 15 6.729 15 15v35h-176.606l-20.075-32.781-10.546-17.219zm60 375c0 8.271-6.729 15-15 15h-430c-8.271 0-15-6.729-15-15v-380c0-8.271 6.729-15 15-15h145.347l7.858 12.831c.001.001.001.002.002.003l28.917 47.219 20.085 32.797c2.727 4.452 7.571 7.166 12.792 7.166h215c8.271 0 15 6.729 15 15v279.984z"/>
				</svg>
				<?php
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="cat-text screen-reader-text">Categories</span>', 'Used before category names.', 'knote' ) ),
					$categories_list
				); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php
		}
	}
}

if ( ! function_exists( 'knote_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function knote_entry_footer() {
		$knote_single_tags 	= get_theme_mod( 'knote_single_post_tags_enable', 1 );
		$knote_single_category = get_theme_mod( 'knote_single_post_category_enable', 1 );

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {


			if( $knote_single_category ):
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( esc_html__( ', ', 'knote' ) );
				if ( $categories_list ) { ?>
					<div class="block-category-links">
						<svg id="folder" fill="currentColor" width="14" height="12" viewBox="0 0 520 520" xmlns="http://www.w3.org/2000/svg">
							<path d="m475 125.016v-35.016c0-24.813-20.187-45-45-45h-210.599l-7.859-12.834c-2.727-4.452-7.571-7.166-12.792-7.166h-153.75c-24.813 0-45 20.187-45 45v380c0 24.813 20.187 45 45 45h430c24.813 0 45-20.187 45-45v-279.984c0-24.813-20.187-45-45-45zm-45-50.016c8.271 0 15 6.729 15 15v35h-176.606l-20.075-32.781-10.546-17.219zm60 375c0 8.271-6.729 15-15 15h-430c-8.271 0-15-6.729-15-15v-380c0-8.271 6.729-15 15-15h145.347l7.858 12.831c.001.001.001.002.002.003l28.917 47.219 20.085 32.797c2.727 4.452 7.571 7.166 12.792 7.166h215c8.271 0 15 6.729 15 15v279.984z"/>
						</svg>
						<?php
						/* translators: 1: list of categories. */
						printf( '<span class="cat-links">%1$s%2$s</span>',
							sprintf( _x( '<span class="cat-text screen-reader-text">Categories</span>', 'Used before category names.', 'knote' ) ),
							$categories_list
						); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php
				}
			endif;

			if( $knote_single_tags ):
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'knote' ) );
				if ( $tags_list ) { ?>
					<div class="block-tags-links">
						<svg height="12px" viewBox="0 0 512.0015 512" width="14px" xmlns="http://www.w3.org/2000/svg">
							<path d="m456.882812 0h-194.308593c-3.976563 0-7.792969 1.582031-10.605469 4.394531l-235.855469 235.847657c-21.484375 21.492187-21.484375 56.457031 0 77.941406l177.699219 177.695312c10.375 10.375 24.214844 16.089844 38.964844 16.09375h.003906c14.753906 0 28.59375-5.71875 38.972656-16.097656l235.847656-235.851562c2.8125-2.8125 4.394532-6.628907 4.394532-10.605469l.003906-194.308594c-.003906-30.386719-24.730469-55.109375-55.117188-55.109375zm25.113282 243.207031-231.457032 231.457031c-4.710937 4.714844-11.019531 7.308594-17.757812 7.308594-6.742188 0-13.046875-2.59375-17.757812-7.304687l-177.699219-177.695313c-9.789063-9.789062-9.789063-25.726562 0-35.519531l231.460937-231.453125h188.097656c13.847657 0 25.117188 11.265625 25.117188 25.113281zm0 0"/>
							<path d="m379.785156 85.078125c-12.589844 0-24.425781 4.90625-33.328125 13.808594-8.902343 8.898437-13.804687 20.734375-13.804687 33.324219 0 12.589843 4.902344 24.425781 13.804687 33.328124 8.902344 8.902344 20.738281 13.804688 33.328125 13.804688 12.585938 0 24.421875-4.902344 33.324219-13.804688 8.902344-8.902343 13.804687-20.738281 13.804687-33.328124 0-12.589844-4.902343-24.425782-13.800781-33.324219-8.902343-8.902344-20.738281-13.808594-33.328125-13.808594zm12.113282 59.246094c-3.234376 3.238281-7.539063 5.019531-12.113282 5.019531-4.578125 0-8.878906-1.78125-12.113281-5.019531-3.238281-3.234375-5.019531-7.539063-5.019531-12.113281 0-4.574219 1.78125-8.878907 5.019531-12.113282 3.234375-3.238281 7.539063-5.019531 12.113281-5.019531 4.574219 0 8.875 1.78125 12.113282 5.019531 3.238281 3.234375 5.019531 7.539063 5.019531 12.113282 0 4.574218-1.785157 8.878906-5.019531 12.113281zm0 0"/>
						</svg>
						<?php
						/* translators: 1: list of tags. */
							printf( '<span class="tags-links">%1$s%2$s</span>',
							sprintf( _x( '<span class="tags-text screen-reader-text">Tags</span>', 'Used before tag names.', 'knote' ) ),
							$tags_list
						); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php
				}
			endif;
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			$before = '<span class="comments-link">';
            $before .= '<svg height="12px" viewBox="-21 -47 682.66669 682" width="14px" xmlns="http://www.w3.org/2000/svg">
							<path d="m552.011719-1.332031h-464.023438c-48.515625 0-87.988281 39.464843-87.988281 87.988281v283.972656c0 48.414063 39.300781 87.816406 87.675781 87.988282v128.863281l185.191407-128.863281h279.144531c48.515625 0 87.988281-39.472657 87.988281-87.988282v-283.972656c0-48.523438-39.472656-87.988281-87.988281-87.988281zm50.488281 371.960937c0 27.835938-22.648438 50.488282-50.488281 50.488282h-290.910157l-135.925781 94.585937v-94.585937h-37.1875c-27.839843 0-50.488281-22.652344-50.488281-50.488282v-283.972656c0-27.84375 22.648438-50.488281 50.488281-50.488281h464.023438c27.839843 0 50.488281 22.644531 50.488281 50.488281zm0 0"/>
							<path d="m171.292969 131.171875h297.414062v37.5h-297.414062zm0 0"/>
							<path d="m171.292969 211.171875h297.414062v37.5h-297.414062zm0 0"/>
							<path d="m171.292969 291.171875h297.414062v37.5h-297.414062zm0 0"/>
						</svg>';
			$after = '</span>';

			echo $before; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'knote' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo $after; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'knote' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'knote_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function knote_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :

			$classes = 'aligncenter';
			$alignment = get_theme_mod( 'knote_single_image_wide_alignment', 1 );
			if ( $alignment ){
				$classes = 'alignwide';
			}
			?>

			<div class="post-thumbnail <?php echo esc_attr( $classes ); ?>">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>
			<div class="post-thumbnail">
				<a class="image-thumb" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
						$knote_thumb_size = 'knote-post-thumbnails-list';
						$knote_archive_layout	= get_theme_mod( 'knote_archive_layout', 'grid' );
						$knote_archive_column	= get_theme_mod( 'knote_archives_grid_columns', 2 );

						$knote_thumb_size = 'knote-post-thumbnails-list';
						if( $knote_archive_layout == 'grid' ){
							$knote_thumb_size = 'knote-post-thumbnails-grid-xlarge';
							if( $knote_archive_column == 3 ){
								$knote_thumb_size = 'knote-post-thumbnails-grid-large';
							}elseif( $knote_archive_column == 4 ){
								$knote_thumb_size = 'knote-post-thumbnails-grid-medium';
							}elseif( $knote_archive_column == 5  ){
								$knote_thumb_size = 'knote-post-thumbnails-grid-small';
							}
						}
						the_post_thumbnail(
							$knote_thumb_size,
							array(
								'alt' => the_title_attribute(
									array(
										'echo' => false,
									)
								),
							)
						);
					?>
				</a>
			</div>
			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;
