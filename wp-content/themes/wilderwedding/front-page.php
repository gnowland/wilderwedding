<?php get_header(); ?>

	<?php
		// the query
		$query1 = new WP_Query( 'post_type=page' );

			if ( $query1->have_posts() ){
				while ( $query1->have_posts() ){
					$query1->the_post(); ?>
					<section id="<?php echo $post->post_name; ?>" <?php if($post->post_name == 'welcome'){ echo 'class="one-page"'; } ?> >
						<div id="content">
							<div id="inner-content" class="row">
								<div id="main" class="large-12 medium-12 columns <?php if($post->post_name == 'welcome'){ echo 'text-center'; } ?>" role="main">
									<article id="<?php the_ID(); ?>" role="article" itemprop="articleBody" >
										<header class="article-header">
											<?php
											if ( has_post_thumbnail() ) {
												the_post_thumbnail('large');
											}
											?>
											<h1 class="page-title"><?php the_title(); ?></h1>
										</header> <!-- end article header -->
										<section class="entry-content" itemprop="articleBody">
											<?php the_content(); ?>
										</section> <!-- end article section -->
									</article> <!-- end article -->
								</div> <!-- end #main -->
							</div> <!-- end #inner-content -->
						</div> <!-- end #content -->
					</section>
							<?php
									} //end of the loop/endwhile

									wp_reset_postdata();

								} else {
									get_template_part( 'partials/content', 'missing' );
								} ?>

<?php get_footer(); ?>