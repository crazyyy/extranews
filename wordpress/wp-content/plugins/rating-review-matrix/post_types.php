<?php
add_action( 'init', 'build_taxonomies_main', 0 );

function build_taxonomies_main() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels_pv_types = array(
    'name' => _x( 'Review Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Review Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Review types' ),
    'all_items' => __( 'All Review types' ),
    'parent_item' => __( 'Parent Review type' ),
    'parent_item_colon' => __( 'Parent Review Type:' ),
    'edit_item' => __( 'Edit Review Type' ), 
    'update_item' => __( 'Update Review Type' ),
    'add_new_item' => __( 'Add New Review Type' ),
    'new_item_name' => __( 'New Review Type' ),
    'menu_name' => __( 'Review Types' ),
  ); 	

  register_taxonomy('review_types','post', array(
    'hierarchical' => true,
    'labels' => $labels_pv_types,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'review-types' ),
  ));
}
  
add_action('init', 'my_post_type_reviews');
function my_post_type_reviews() 
{
  $labels_reviews = array(
    'name' => _x('Review Matrices', 'post type general name'),
    'singular_name' => _x('Review Matrix', 'post type singular name'),
    'add_new' => _x('Add New', 'Review'),
    'add_new_item' => __('Add New Review matrix'),
    'edit_item' => __('Edit Review matrix'),
    'new_item' => __('New Review matrix'),
    'view_item' => __('View Review matrix'),
    'search_items' => __('Search Review matrices'),
    'not_found' =>  __('No Review matrices found'),
    'not_found_in_trash' => __('No Review matrices found in Trash'), 
    'parent_item_colon' => ''
  );
  $args_reviews = array(
    'labels' => $labels_reviews,
    'public' => false,
    'publicly_queryable' => false,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'review-matrix', 'with_front' => false ),
	'can_export' => true,
	/*'register_meta_box_cb' => 'your_callback_function_name',*/
    'capability_type' => 'post',
    'hierarchical' => false,
    'supports' => array('title',/**/'custom-fields','editor'),
	'taxonomies' => array(   'review_types' ),
	'permalink_epmask' => EP_PERMALINK,
	
	
  ); 
  register_post_type('matrix',$args_reviews);
  
  
}

 ?>