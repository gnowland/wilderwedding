<?php get_header(); ?>
			
			<div id="content">
			
				<div class="inner-content wrapwidth row">
			
				    <div id="main" class="large-8 medium-8 columns" role="main">
					 
					  <!-- To see additional archive styles, visit the /partials directory -->
					    <?php get_template_part( 'partials/loop', 'archive-grid' ); ?>
								
				    </div> <!-- end #main -->
    
				    <?php get_sidebar(); ?>
				    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>