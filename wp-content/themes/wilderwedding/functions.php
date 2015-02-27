<?php
ob_start();
/*********************
INCLUDE NEEDED FILES
*********************/

// LOAD JOINTSWP CORE (if you remove this, the theme will break)
require_once(get_template_directory().'/library/joints.php');

// Custom Post Types
//require_once(get_template_directory().'/library/custom-post-type.php');
require_once(get_template_directory().'/library/custom-post-type-wedding-party.php');

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
require_once(get_template_directory().'/library/admin.php');

// SUPPORT FOR OTHER LANGUAGES (off by default)
// require_once(get_template_directory().'/library/translation/translation.php');

/*********************
MENUS & NAVIGATION
*********************/
// REGISTER MENUS
register_nav_menus(
	array(
		'top-nav' => __( 'The Top Menu' ),   // main nav in header
		'main-nav' => __( 'The Main Menu' ),   // main nav in header
    'main-nav-home' => __( 'The Homepage Menu' ),   // homepage nav
		'footer-links' => __( 'Footer Links' ) // secondary nav in footer
	)
);

// THE TOP MENU
function joints_top_nav() {
    wp_nav_menu(array(
    	'container' => false,                           // remove nav container
    	'container_class' => '',           // class of container (should you choose to use it)
    	'menu' => __( 'The Top Menu', 'jointstheme' ),  // nav name
    	'menu_class' => '',         // adding custom nav class
    	'theme_location' => 'top-nav',                 // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
    	'fallback_cb' => 'joints_main_nav_fallback'      // fallback function
	));
} /* end joints main nav */

// THE MAIN MENU
function joints_main_nav() {
    wp_nav_menu(array(
    	'container' => false,                           // remove nav container
    	'container_class' => '',           // class of container (should you choose to use it)
    	'menu' => __( 'The Main Menu', 'jointstheme' ),  // nav name
    	'menu_class' => '',         // adding custom nav class
    	'theme_location' => 'main-nav',                 // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
    	'fallback_cb' => 'joints_main_nav_fallback'      // fallback function
	));
} /* end joints main nav */

// THE HOME MENU
function joints_home_main_nav() {
    wp_nav_menu(array(
      'container' => false,                           // remove nav container
      'container_class' => '',           // class of container (should you choose to use it)
      'menu' => __( 'The Homepage Menu', 'jointstheme' ),  // nav name
      'menu_class' => '',         // adding custom nav class
      'theme_location' => 'main-nav-home',                 // where it's located in the theme
      'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
      'fallback_cb' => 'joints_main_nav_fallback'      // fallback function
  ));
} /* end joints main nav */

// THE FOOTER MENU
function joints_footer_links() {
    wp_nav_menu(array(
    	'container' => '',                              // remove nav container
    	'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
    	'menu' => __( 'Footer Links', 'jointstheme' ),   // nav name
    	'menu_class' => 'sub-nav',      // adding custom nav class
    	'theme_location' => 'footer-links',             // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 0,                                   // limit the depth of the nav
    	'fallback_cb' => 'joints_footer_links_fallback'  // fallback function
	));
} /* end joints footer link */

// HEADER FALLBACK MENU
function joints_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => '',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                            // before each link
        'link_after' => ''                             // after each link
	) );
}

// FOOTER FALLBACK MENU
function joints_footer_links_fallback() {
	/* you can put a default here if you like */
}

/*********************
SIDEBARS
*********************/

// SIDEBARS AND WIDGETIZED AREAS
function joints_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __('Sidebar 1', 'jointstheme'),
		'description' => __('The first (primary) sidebar.', 'jointstheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'offcanvas',
		'name' => __('Offcanvas', 'jointstheme'),
		'description' => __('The offcanvas sidebar.', 'jointstheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __('Sidebar 2', 'jointstheme'),
		'description' => __('The second (secondary) sidebar.', 'jointstheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!

/*********************
COMMENT LAYOUT
*********************/

// Comment Layout
function joints_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('panel'); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix large-12 columns">
			<header class="comment-author">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<!-- custom gravatar call -->
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<?php printf(__('<cite class="fn">%s</cite>', 'jointstheme'), get_comment_author_link()) ?> on
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__(' F jS, Y - g:ia', 'jointstheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'jointstheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e('Your comment is awaiting moderation.', 'jointstheme') ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!


/*********************
CUSTOM CATEGORY WALKER (GN)
*********************/

class My_Category_Walker extends Walker_Category {

  var $lev = -1;
  var $skip = 0;
  static $current_parent;

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $this->lev = 0;
//    $output .= "<ul>" . PHP_EOL;
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
//    $output .= "</ul>" . PHP_EOL;
    $this->lev = -1;
  }

  function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
    extract($args);
    $cat_name = esc_attr( $category->name );
    if ( ! $category->parent ) {
      if ( ! get_term_children( $category->term_id, $category->taxonomy ) ) {
          $this->skip = 1;
      } else {
//        $output .= "<li class='" . $class . $level_class . "'>" . PHP_EOL;
        $output .= "<section class='" . $class . $level_class . "'>" . PHP_EOL;
        $output .= sprintf($parent_title_format, $cat_name) . PHP_EOL;
      }
    } else {
      if ( $this->lev == 0 && $category->parent) {
        $link = get_term_link(intval($category->parent) , $category->taxonomy);
        $stored_parent = intval(self::$current_parent);
        $now_parent = intval($category->parent);
        self::$current_parent = null;
      }
      //$output .= print_r($category);

//HARD CODED BECAUSE FTS
      $post_args = array(
      'post_type' => 'wedding_party',
      'tax_query' => array(
          array(
          'taxonomy' => $category->taxonomy,
          'field' => 'id',
          'terms' => $category->term_id
           )
        )
      );
      $query2 = new WP_Query( $post_args );

      if ( $query2->have_posts() ){

        while ( $query2->have_posts() ){
          $query2->the_post();

          $outpost .= '<section id="'. get_the_ID() .'" role="section" itemprop="articleBody" class="clearfix">' . PHP_EOL;
          $outpost .= '<header class="article-header">' . PHP_EOL;
            if ( has_post_thumbnail() ) {
          $outpost .= '<div class="post-image-banner">' . PHP_EOL;
          $outpost .= get_the_post_thumbnail($post->ID,'thumbnail') . PHP_EOL;
          $outpost .= '<h3 class="section-title">' . get_the_title() .'</h3>' . PHP_EOL;
          $outpost .= '<h4 class="category-title">' . $cat_name . '</h4>' . PHP_EOL;
          $outpost .= '</div>' . PHP_EOL;
            } else {
          $outpost .= '<h3 class="section-title">' . get_the_title() .'</h3>' . PHP_EOL;
          $outpost .= '<h4 class="category-title">' . $cat_name . '</h4>' . PHP_EOL;
            }
          $outpost .= '</header> <!-- end section header -->' . PHP_EOL;
          $outpost .= '<section class="entry-content" itemprop="articleBody">' . PHP_EOL;
          $outpost .= get_the_content() . PHP_EOL;
          $outpost .= '</section> <!-- end article section -->' . PHP_EOL;
          $outpost .= '</section><!-- end article section -->' . PHP_EOL;

        } //end of the loop/endwhile

        wp_reset_postdata();

      }

      //$output .= "<li";
      //$class .= $category->taxonomy . '-item ' . $category->taxonomy . '-item-' . $category->term_id;
      //$output .= ' class="' . $class . '"';
      //$output .= '>';
      $output .= $outpost;
      $output .= "</section><hr>" . PHP_EOL;
    }
  }

  function end_el( &$output, $page, $depth = 0, $args = array() ) {
    $this->lev++;
    if ( $this->skip == 1 ) {
      $this->skip = 0;
      return;
    }

//    $output .= "</li>" . PHP_EOL;
  }

}

function custom_list_categories( $args = '' ) {
  $defaults = array(
    'taxonomy' => 'category',
    'show_option_none' => '',
    'echo' => 1,
    'depth' => 2,
    'wrap_class' => '',
    'level_class' => '',
    'parent_title_format' => '%s',
  );
  $r = wp_parse_args( $args, $defaults );
  if ( ! isset( $r['wrap_class'] ) ) $r['wrap_class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];
  extract( $r );
  if ( ! taxonomy_exists($taxonomy) ) return false;
  $categories = get_categories( $r );
//  $output = "<ul class='" . esc_attr( $wrap_class ) . "'>" . PHP_EOL;
  if ( empty( $categories ) ) {
    if ( ! empty( $show_option_none ) ) $output .= /*"<li>" .*/ $show_option_none /*. "</li>"*/ . PHP_EOL;
  } else {
    $depth = $r['depth'];
    $walker = new My_Category_Walker;
    $output .= $walker->walk($categories, $depth, $r);
  }
//  $output .= "</ul>" . PHP_EOL;
  if ( $echo ) echo $output; else return $output;
}

?>