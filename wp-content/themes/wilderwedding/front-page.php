<?php get_header(); ?>

		<div id="background">
				<div id="content">
					<div id="inner-content" class="row"></div>
				</div>
		</div>

		<section class="one-page" id="welcome">
				<div id="content">
					<div id="inner-content" class="row">
							<div id="main" class="large-12 medium-12 columns" role="main">

								<?php
								// the query
								$query1 = new WP_Query( 'pagename=welcome' );

								if ( $query1->have_posts() ){
									while ( $query1->have_posts() ){
													$query1->the_post(); ?>
													<article id="<?php the_ID(); ?>" <?php post_class('entry-content'); ?> role="article" itemprop="articleBody" >
														<header class="article-header">
															<h1 class="page-title"><?php the_title(); ?></h1>
														</header> <!-- end article header -->
														<section class="entry-content" itemprop="articleBody">
															<?php the_content(); ?>
														</section> <!-- end article section -->
													</article> <!-- end article -->
									<?php
									} //end of the loop/endwhile

									wp_reset_postdata();

								} else {
									get_template_part( 'partials/content', 'missing' );
								} ?>

							</div> <!-- end #main -->

					</div> <!-- end #inner-content -->

				</div> <!-- end #content -->
			</section>
			<section class="" id="the-couple">
					<div id="content">

						<div id="inner-content" class="row">

								<div id="main" class="large-12 medium-12 columns" role="main">

								<p></p>

								</div> <!-- end #main -->

						</div> <!-- end #inner-content -->

					</div> <!-- end #content -->
				</section>
<?php get_footer(); ?>