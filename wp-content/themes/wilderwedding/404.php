<?php get_header(); ?>

			<div id="content">

				<div class="inner-content wrapwidth row">

					<div id="main" class="large-8 medium-8 columns" role="main">

						<article id="content-not-found">

							<header class="article-header">
								<h1>Error 404 - Article Not Found</h1>
							</header> <!-- end article header -->

							<section class="entry-content">
								<p>The page you were looking for was not found, try searching:</p>
							</section> <!-- end article section -->

							<section class="search">
							    <p><?php get_search_form(); ?></p>
							</section> <!-- end search section -->

						</article> <!-- end article -->

					</div> <!-- end #main -->

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>