<?php get_header(); ?>

<?php
	// the query
	$query1 = new WP_Query( 'post_type=page' );

	if ( $query1->have_posts() ){
		while ( $query1->have_posts() ){
			$query1->the_post();

			//
			// Welcome section
			//
			if($post->post_name == 'welcome'){

			?>
				<section id="<?php echo $post->post_name; ?>" class="one-page">
					<div id="content">
						<div id="inner-content" class="row">
							<div id="main" class="large-12 medium-12 columns text-center" role="main">
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

			//
			// The Wedding Party
			//
			} elseif($post->post_name == 'the-wedding-party') {

			?>
				<section id="<?php echo $post->post_name; ?>">
					<div id="content">
						<div id="inner-content" class="row">
							<div id="main" class="large-12 medium-12 columns" role="main">
								<article id="<?php the_ID(); ?>" role="article" itemprop="articleBody" >
									<header class="article-header">
										<?php

										if ( has_post_thumbnail() ) {
											the_post_thumbnail('large');
										}

										?>
										<h1 class="article-title"><?php the_title(); ?></h1>
									</header> <!-- end article header -->
									<?php

									// the wedding party query
									$query2 = new WP_Query( 'post_type=wedding_party' );

									if ( $query2->have_posts() ){
										while ( $query2->have_posts() ){
											$query2->the_post();

											?>
											<section id="<?php the_ID(); ?>" role="section" itemprop="articleBody" class="clearfix">
												<header class="article-header">
												<?php
												if ( has_post_thumbnail() ) {
													the_post_thumbnail('thumbnail');
												}
												?>
												<h2 class="section-title"><?php the_title(); ?></h2>
												</header> <!-- end section header -->
												<section class="entry-content" itemprop="articleBody">
													<?php the_content(); ?>
												</section> <!-- end article section -->
											</section><!-- end article section -->
											<?php

										} //end of the loop/endwhile

										wp_reset_postdata();

										} else {

											get_template_part( 'partials/content', 'missing' );

										}

									?>
									</article> <!-- end article -->
								</div> <!-- end #main -->
							</div> <!-- end #inner-content -->
					</div> <!-- end #content -->
				</section>
			<?php

			//
			// All other sections
			//
			} else {

			?>
					<section id="<?php echo $post->post_name; ?>" >
						<div id="content">
							<div id="inner-content" class="row">
								<div id="main" class="large-12 medium-12 columns" role="main">
									<article id="<?php the_ID(); ?>" role="article" itemprop="articleBody" >
										<header class="article-header">
											<?php
											if ( has_post_thumbnail() ) {
												the_post_thumbnail('large');
											}
											?>
											<h1 class="article-title"><?php the_title(); ?></h1>
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

			}

		} //end of the loop/endwhile

		wp_reset_postdata();

	} else {

		get_template_part( 'partials/content', 'missing' );

	}

?>

<?php get_footer(); ?>