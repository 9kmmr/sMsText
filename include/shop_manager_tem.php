<?php
/**
 * Template Name: Shop Manager Template
 *
 * Description: Use this page template for a page with no sidebars.
 *
 * @package WordPress

 */

get_header(); ?>

<div class="page-full-width">

	<div id="primary" class="site-content" style="width: 100%!important">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

</div><!-- .page-full-width -->
<?php get_footer(); ?>
