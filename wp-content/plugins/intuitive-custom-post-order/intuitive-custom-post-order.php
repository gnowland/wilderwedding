<?php
/*
Plugin Name: Intuitive Custom Post Order
Plugin URI: http://hijiriworld.com/web/plugins/intuitive-custom-post-order/
Description: Intuitively, Order Items (Posts, Pages, and Custom Post Types) using a Drag and Drop Sortable JavaScript.
Version: 2.1.0
Author: hijiri
Author URI: http://hijiriworld.com/web/
*/

/*  Copyright 2014 hijiri

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/***********************************************************************************

	Define

***********************************************************************************/

define( 'HICPO_URL', plugins_url('', __FILE__) );

define( 'HICPO_DIR', plugin_dir_path(__FILE__) );

load_plugin_textdomain( 'hicpo', false, basename(dirname(__FILE__)).'/lang' );

/***********************************************************************************

	Class & Method

***********************************************************************************/

$hicpo = new Hicpo();

class Hicpo
{
	function __construct()
	{

		if ( !get_option('hicpo_options') ) $this->hicpo_install();
		
		add_action( 'admin_menu', array( &$this, 'admin_menu') );
		
		add_action( 'admin_init', array( &$this, 'refresh' ) );
		add_action( 'admin_init', array( &$this, 'update_options') );
		add_action( 'admin_init', array( &$this, 'load_script_css' ) );
		
		add_action( 'wp_ajax_update-menu-order', array( &$this, 'update_menu_order' ) );
		
		// pre_get_posts
		add_filter( 'pre_get_posts', array( &$this, 'hicpo_filter_active' ) );
		add_filter( 'pre_get_posts', array( &$this, 'hicpo_pre_get_posts' ) );
		
		// previous_post(s)_link, next_post(s)_link
		add_filter( 'get_previous_post_where', array( &$this, 'hicpo_previous_post_where' ) );
		add_filter( 'get_previous_post_sort', array( &$this, 'hicpo_previous_post_sort' ) );
		add_filter( 'get_next_post_where', array( &$this, 'hocpo_next_post_where' ) );
		add_filter( 'get_next_post_sort', array( &$this, 'hicpo_next_post_sort' ) );
		
		// for dev
		//add_action( 'pre_get_posts', array( &$this, 'hicpo_dev' ) );
	}
	
	function hicpo_install()
	{
		global $wpdb;
		
		// Initialize : hicpo_options
		
		$post_types = get_post_types( array (
			'public' => true
			), 'objects' );
		
		$init_objects = array();
		
		foreach ($post_types as $post_type ) {
			if ( $post_type->name != 'attachment' ) {
				$init_objects[] = $post_type->name;
			}
		}
		$input_options = array( 'objects' => $init_objects );
		
		update_option( 'hicpo_options', $input_options );
		
		// Initialize : menu_order
		
		$hicpo_options = get_option( 'hicpo_options' );
		$objects = $hicpo_options['objects'];
		
		if ( !empty( $objects ) ) {
			foreach( $objects as $object) {
				$results = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type = '".$object."' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future') ORDER BY post_date DESC" );
				foreach( $results as $key => $result ) {
					$wpdb->update( $wpdb->posts, array( 'menu_order' => $key+1 ), array( 'ID' => $result->ID ) );
				}
			}
		}
	}
	
	function admin_menu()
	{
		add_options_page( __('Intuitive CPO', 'hicpo'), __('Intuitive CPO', 'hicpo'), 'manage_options', 'hicpo-settings', array( &$this,'admin_page' ));
	}
	
	function admin_page()
	{
		require HICPO_DIR.'admin/settings.php';
	}

	function _check_load_script_css() {
		
		$active = false;
		
		$hicpo_options = get_option( 'hicpo_options' );
		$objects = $hicpo_options['objects'];
		
		if ( is_array( $objects ) ) {
			// exlude addnew Page and edit Page
			if ( !strstr( $_SERVER["REQUEST_URI"], 'action=edit' ) && !strstr( $_SERVER["REQUEST_URI"], 'wp-admin/post-new.php' ) ) {
				
				// if Custom Post Types( include 'Page')
				if ( isset( $_GET['post_type'] ) ) {
					if ( in_array( $_GET['post_type'], $objects ) ) {
						$active = true;
					}
				// if Post 
				} else if ( strstr( $_SERVER["REQUEST_URI"], 'wp-admin/edit.php' ) ) {
					if ( in_array( 'post', $objects ) ) {
						$active = true;
					}
				}
			}
		}
		return $active;
	}

	function load_script_css() {
		
		if ( $this->_check_load_script_css() ) {
			
			// load JavaScript
	
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'hicpojs', HICPO_URL.'/js/hicpo.js', array( 'jquery' ), null, true );
	
			// load CSS
	
			wp_enqueue_style( 'hicpo', HICPO_URL.'/css/hicpo.css', array(), null );
		}
	}
	
	function refresh()
	{
		// menu_orderを再構築する
		global $wpdb;
		
		$hicpo_options = get_option( 'hicpo_options' );
		$objects = $hicpo_options['objects'];
		
		if ( is_array( $objects ) ) {
			foreach( $objects as $object) {
				
				/*
				menu_order の max とレコード数が一致して、かつ min が 0 じゃない時は再構築処理をスキップする
				*/
				
				$result = $wpdb->get_results( "SELECT count(*) as cnt, max(menu_order) as max, min(menu_order) as min FROM $wpdb->posts WHERE post_type = '".$object."' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')" );
				if ( count( $result ) > 0 && $result[0]->cnt == $result[0]->max && $result[0]->min != 0 ) {
					continue;
				}
				
				$results = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type = '".$object."' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future') ORDER BY menu_order ASC" );
				
				foreach( $results as $key => $result ) {
					// 新規追加した場合 menu_order=0 で登録されるため、常に1からはじまるように振っておく
					$wpdb->update( $wpdb->posts, array( 'menu_order' => $key+1 ), array( 'ID' => $result->ID ) );
				}
			}
		}
	}
	
	function update_menu_order()
	{
		global $wpdb;
		
		parse_str($_POST['order'], $data);
		
		if ( is_array($data) ) {
			
			// ページに含まれる記事のIDをすべて取得
			$id_arr = array();
			
			foreach( $data as $key => $values ) {
				foreach( $values as $position => $id ) {
					$id_arr[] = $id;
				}
			}
			
			// ページに含まれる記事の menu_order をすべて取得
			$menu_order_arr = array();
			foreach( $id_arr as $key => $id ) {
				$results = $wpdb->get_results( "SELECT menu_order FROM $wpdb->posts WHERE ID = ".$id );
				foreach( $results as $result ) {
					$menu_order_arr[] = $result->menu_order;
				}
			}
			// menu_order 配列をソート（キーと値の相関関係は維持しない）
			sort($menu_order_arr);
			
			foreach( $data as $key => $values ) {
				foreach( $values as $position => $id ) {
					$wpdb->update( $wpdb->posts, array( 'menu_order' => $menu_order_arr[$position] ), array( 'ID' => $id ) );
				}
			}
		}
	}
	
	function update_options()
	{
		global $wpdb;
		
		if ( isset( $_POST['hicpo_submit'] ) ) {
			
			check_admin_referer( 'nonce_hicpo' );
			
			if ( isset( $_POST['objects'] ) ) {
				$input_options = array( 'objects' => $_POST['objects'] );
			} else {
				$input_options = array( 'objects' => '' );
			}
			
			update_option( 'hicpo_options', $input_options );
			
			/*
			はじめて有効化されたオブジェクトの場合、ディフォルト状態 order=post_date に従って menu_order を振っておく
			*/
			
			$hicpo_options = get_option( 'hicpo_options' );
			$objects = $hicpo_options['objects'];
			
			if ( !empty( $objects ) ) {
				foreach( $objects as $object) {
					// 記事が1つ以上存在し、menu_oredr の最大値が 0 のオブジェクトが該当
					$result = $wpdb->get_results( "SELECT count(*) as cnt, max(menu_order) as max, min(menu_order) as min FROM $wpdb->posts WHERE post_type = '".$object."' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')" );
					if ( count( $result ) > 0 && $result[0]->max == 0 ) {
						$results = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type = '".$object."' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future') ORDER BY post_date DESC" );
						foreach( $results as $key => $result ) {
							$wpdb->update( $wpdb->posts, array( 'menu_order' => $key+1 ), array( 'ID' => $result->ID ) );
						}
					}
				}
			}
			
			wp_redirect( 'admin.php?page=hicpo-settings&msg=update' );
		}
	}
	
	function hicpo_previous_post_where( $where )
	{
		global $post;

		$hicpo_options = get_option('hicpo_options');
		$objects = $hicpo_options['objects'];
		
		if ( in_array( $post->post_type, $objects ) ) {
			$current_menu_order = $post->menu_order;
			$where = "WHERE p.menu_order > '".$current_menu_order."' AND p.post_type = '". $post->post_type ."' AND p.post_status = 'publish'";
		}
		return $where;
	}
	
	function hicpo_previous_post_sort( $orderby )
	{
		global $post;

		$hicpo_options = get_option('hicpo_options');
		$objects = $hicpo_options['objects'];
		
		if ( in_array( $post->post_type, $objects ) ) {
			$orderby = 'ORDER BY p.menu_order ASC LIMIT 1';
		}
		return $orderby;
	}
	
	function hocpo_next_post_where( $where )
	{
		global $post;

		$hicpo_options = get_option('hicpo_options');
		$objects = $hicpo_options['objects'];
		
		if ( in_array( $post->post_type, $objects ) ) {
			$current_menu_order = $post->menu_order;
			$where = "WHERE p.menu_order < '".$current_menu_order."' AND p.post_type = '". $post->post_type ."' AND p.post_status = 'publish'";
		}
		return $where;
	}
	
	function hicpo_next_post_sort( $orderby )
	{
		global $post;
		
		$hicpo_options = get_option('hicpo_options');
		$objects = $hicpo_options['objects'];

		if ( in_array( $post->post_type, $objects ) ) {
			$orderby = 'ORDER BY p.menu_order DESC LIMIT 1';
		}
		return $orderby;
	}
	
	function hicpo_filter_active( $wp_query )
	{
		// get_postsの場合 suppress_filters=true となる為、フィルタリングを有効にする
		if ( isset($wp_query->query['suppress_filters']) ) $wp_query->query['suppress_filters'] = false;
		if ( isset($wp_query->query_vars['suppress_filters']) ) $wp_query->query_vars['suppress_filters'] = false;
		return $wp_query;
	}
	
	function hicpo_pre_get_posts( $wp_query )
	{
		global $args;
		
		$hicpo_options = get_option('hicpo_options');
		$objects = $hicpo_options['objects'];
		
		if ( is_array( $objects ) ) {
		
			// for Admin >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			
			if ( is_admin() && !defined( 'DOING_AJAX' ) ) {
				
				/*
				post_type=post or page or custom post type
				adminの場合、post_type=postも渡される
				*/
				
				if ( isset( $wp_query->query['post_type'] ) ) {
					if ( in_array( $wp_query->query['post_type'], $objects ) ) {
						$wp_query->set( 'orderby', 'menu_order' );
						$wp_query->set( 'order', 'ASC' );
					}
				}
			
			// for Template >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			
			} else {
				
				/*
				
				post_type が有効オブジェクトかどうかを判別
				
				$wp_query->query['post_type'] で判別
				ディフォルトのクエリの場合、$args指定がないため
				
				*/
					
				$active = false;
					
				// post_typeが指定されている場合
				
				if ( isset( $wp_query->query['post_type'] ) ) {
					// 複数指定の場合は、いずれかひとつでも該当すれば有効
					if ( is_array( $wp_query->query['post_type'] ) ) {
						$post_types = $wp_query->query['post_type'];
						foreach( $post_types as $post_type ) {
							if ( in_array( $post_type, $objects ) ) {
								$active = true;
							}
						}
					} else {
						if ( in_array( $wp_query->query['post_type'], $objects ) ) {
							$active = true;
						}
					}
				// post_typeが指定されていなければpost
				} else {
					if ( in_array( 'post', $objects ) ) {
						$active = true;
					}
				}

				/*
				
				$args が存在した場合はそちらを優先する
				
				*/
				
				if ( $active ) {
					
					if ( isset( $args ) ) {
						// args = array( 'orderby' => 'date', 'order' => 'DESC' );
						if ( is_array( $args ) ) {
							if ( !isset( $args['orderby'] ) ) {
								$wp_query->set( 'orderby', 'menu_order' );
							}
							if ( !isset( $args['order'] ) ) {
								$wp_query->set( 'order', 'ASC' );
							}
						// args = 'orderby=date&order=DESC';
						} else {
							if ( !strstr( $args, 'orderby=' ) ) {
								$wp_query->set( 'orderby', 'menu_order' );
							}
							if ( !strstr( $args, 'order=' ) ) {
								$wp_query->set( 'order', 'ASC' );
								
							}
						}
					} else {
						$wp_query->set( 'orderby', 'menu_order' );
						$wp_query->set( 'order', 'ASC' );
					}
				}
			}
		}
	}
	
	// for dev
/*
	function hicpo_dev( $query ) {
		
		global $args;
		
		echo '[$args]';
		echo isset( $args ) ? ' isset ' : ' non-object ';
		echo '/';
		echo is_array( $args ) ? ' array ' : ' no-array ';
		echo '<br>';
		print_r($args);
		echo '<br>';
		
		echo '[$query->query]';
		echo isset( $query->query ) ? ' isset ' : ' non-object ';
		echo '/';
		echo is_array( $query->query ) ? ' array ' : ' no-array ';
		echo '<br>';
		print_r($query->query);
		echo '<br>';
		
	}
*/
}
?>