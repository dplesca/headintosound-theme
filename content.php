<?php
/**
 * @package headintobootstrap
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header><!-- .entry-header -->
	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php headintobootstrap_posted_on(); ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'headintobootstrap' ) );
				if ( $categories_list && headintobootstrap_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( '<i class="icon-folder-open"></i> %1$s', 'headintobootstrap' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'headintobootstrap' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( '<i class="icon-tags"></i> %1$s', 'headintobootstrap' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( '<i class="icon-comment"></i> Comment', 'headintobootstrap' ), __( '1 Comment', 'headintobootstrap' ), __( '% Comments', 'headintobootstrap' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( '<i class="icon-edit"></i> Edit', 'headintobootstrap' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
	
	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'headintobootstrap' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'headintobootstrap' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	
</article><!-- #post-## -->
