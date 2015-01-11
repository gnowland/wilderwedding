					<footer class="footer" role="contentinfo">
						<div id="inner-footer" class="row">
							<div class="large-12 medium-12 columns">
								<nav role="navigation">
		    						<?php joints_footer_links(); ?>
		    					</nav>
		    				</div>
			                <div class="large-12 medium-12 columns">
			                <p class="source-org copyright">&copy; <?php echo date('Y').' '; bloginfo('description'); ?><br>Design+Development by <a href="http://www.giffordnowland.com/" target="_blank">Gifford Nowland</a></p>
							</div>
						</div> <!-- end #inner-footer -->
					</footer> <!-- end .footer -->
				</div> <!-- end #container -->
			</div> <!-- end .inner-wrap -->
		</div> <!-- end .off-canvas-wrap -->
		<?php
			// all js scripts are loaded in library/joints.php
			wp_footer();
		?>
	</body>
