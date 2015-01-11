<?php
/*
 *  Wedding Party Custom Post Type
 */

function wedding_party() {
	register_post_type( 'wedding_party',
		array('labels' => array(
			'name' => __('Wedding Party', 'jointstheme'),
			'singular_name' => __('Wedding Party', 'jointstheme'),
			'all_items' => __('All', 'jointstheme'),
			'add_new' => __('Add New', 'jointstheme'),
			'add_new_item' => __('Add New Wedding Party Member', 'jointstheme'),
			'edit' => __( 'Edit', 'jointstheme' ),
			'edit_item' => __('Edit Wedding Party', 'jointstheme'),
			'new_item' => __('New Wedding Party Member', 'jointstheme'),
			'view_item' => __('View Wedding Party Member', 'jointstheme'),
			'search_items' => __('Search Wedding Party', 'jointstheme'),
			'not_found' =>  __('Nothing found in the Database.', 'jointstheme'),
			'not_found_in_trash' => __('Nothing found in Trash', 'jointstheme'),
			'parent_item_colon' => ''
			),
			'description' => __( 'This is the Wedding Party List', 'jointstheme' ),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 5,
			'menu_icon' => 'dashicons-exerpt-view',
			'rewrite'	=> array( 'slug' => 'wedding_party', 'with_front' => false ),
			'has_archive' => 'wedding_party',
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'revisions', 'sticky')
	 	)
	);

}

	// init
	add_action( 'init', 'wedding_party');

	// Custom Categories
    register_taxonomy( 'custom_cat',
    	array('wedding_party'),
    	array('hierarchical' => true,
    		'labels' => array(
    			'name' => __( 'Wedding Party Categories', 'jointstheme' ),
    			'singular_name' => __( 'Wedding Party Category', 'jointstheme' ),
    			'search_items' =>  __( 'Search Wedding Party Categories', 'jointstheme' ),
    			'all_items' => __( 'All Wedding Party Categories', 'jointstheme' ),
    			'parent_item' => __( 'Parent Wedding Party Category', 'jointstheme' ),
    			'parent_item_colon' => __( 'Parent Wedding Party Category:', 'jointstheme' ),
    			'edit_item' => __( 'Edit Wedding Party Category', 'jointstheme' ),
    			'update_item' => __( 'Update Wedding Party Category', 'jointstheme' ),
    			'add_new_item' => __( 'Add New Wedding Party Category', 'jointstheme' ),
    			'new_item_name' => __( 'New Wedding Party Category Name', 'jointstheme' )
    		),
    		'show_admin_column' => true,
    		'show_ui' => true,
    		'query_var' => true,
    		'rewrite' => array( 'slug' => 'wedding-party' ),
    	)
    );

?>