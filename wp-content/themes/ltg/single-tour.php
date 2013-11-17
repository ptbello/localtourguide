<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Local Tour Guide
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'tour' ); ?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar('tour'); ?>
<?php get_footer(); ?>