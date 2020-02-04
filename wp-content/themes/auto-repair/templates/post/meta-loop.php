<?php
/**
 * Post metadata template
 *
 * @package  wpv
 */

?>
<div class="post-meta">
	<nav class="clearfix">
		<?php if ( wpv_get_optionb( 'show-post-author' ) ): ?>
			<div class="author"><span class="icon theme"><?php wpv_icon( 'ink-tool' );?></span><span itemprop="author"><?php the_author_posts_link()?></span></div>
		<?php endif ?>

		<?php if ( ! post_password_required() ): ?>
			<?php if ( wpv_get_optionb( 'meta_posted_in' ) ): ?>
				<div><span class="icon"><?php wpv_icon( 'folder1' ); ?></span><span class="visuallyhidden"><?php _e( 'Category', 'auto-repair' ) ?></span><?php the_category( ', ' ); ?></div>
				<?php
				// Tags
				the_tags( '<div class="the-tags"><span class="icon">' . wpv_get_icon( 'tag' ) . '</span><span class="visuallyhidden">'.__( 'Category', 'auto-repair' ).'</span>', ', ', '</div>' )?>
			<?php endif ?>
		<?php endif ?>
		<?php include locate_template( 'templates/post/main/part-actions.php' ); ?>
	</nav>
</div>