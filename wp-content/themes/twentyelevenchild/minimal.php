<?php
/*
Template Name: Minimal
*/

get_header('minimal'); 
?>

		<div id="primary">
			<div id="yohomie" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<!-- <?php comments_template( '', true ); ?> -->

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_footer(); ?>