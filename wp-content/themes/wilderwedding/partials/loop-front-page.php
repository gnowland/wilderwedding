	<section class="one-page" id="welcome">
<!--   <div class="starfield"></div> -->
			<div id="content">

				<div class="inner-content wrapwidth row">

						<div id="main" class="large-12 medium-12 columns" role="main">

							<section class="entry-content" itemprop="articleBody">
								<?php the_content(); ?>
							</section> <!-- end article section -->

						</div> <!-- end #main -->

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->
		</section>





<div itemscope itemtype="http://schema.org/WebPage">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article id="<?php $post->post_name(); ?>" <?php post_class('one-page'); ?> role="article" >

		<header class="article-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header> <!-- end article header -->

	    <section class="entry-content" itemprop="articleBody">
		    <?php the_content(); ?>
		    <?php wp_link_pages(); ?>
		</section> <!-- end article section -->

		<footer class="article-footer">

		</footer> <!-- end article footer -->

		<?php //comments_template(); ?>

	</article> <!-- end article -->

<?php endwhile; else : ?>

	<?php get_template_part( 'partials/content', 'missing' ); ?>

<?php endif; ?>

</div>
