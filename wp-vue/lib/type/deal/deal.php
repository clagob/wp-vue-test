<?php
/////////////
// DEAL
//////////////

// Deal POST TYPE
function deal_post_type() {
  $labels = array(
    'name'               => _x( 'Deals', 'post type general name (plural)', 'your-plugin-textdomain' ),
    'singular_name'      => _x( 'Deal', 'post type singular name', 'your-plugin-textdomain' ),
    'add_new'            => _x( 'Add New', 'Deal', 'your-plugin-textdomain' ),
    'add_new_item'       => __( 'Add New Deals', 'your-plugin-textdomain' ),
    'new_item'           => __( 'New Deal', 'your-plugin-textdomain' ),
    'edit_item'          => __( 'Edit Deal', 'your-plugin-textdomain' ),
    'view_item'          => __( 'View Deal', 'your-plugin-textdomain' ),
    'view_items'         => __( 'View Deals', 'your-plugin-textdomain' ),
    'search_items'       => __( 'Search Deals', 'your-plugin-textdomain' ),
    'not_found'          => __( 'No deal found.', 'your-plugin-textdomain' ),
    'not_found_in_trash' => __( 'No deal found in Trash.', 'your-plugin-textdomain' ),
    'parent_item_colon'  => __( 'Parent Deals:', 'your-plugin-textdomain' ),
    'all_items'          => __( 'All Deals', 'your-plugin-textdomain' ),
    'menu_name'          => _x( 'Deals', 'admin menu', 'your-plugin-textdomain' ),
    'name_admin_bar'     => _x( 'Deal', 'add new on admin bar', 'your-plugin-textdomain' )
  );
  $args = array(
    'labels'             => $labels,
    //'description'        => __( 'Description', 'your-plugin-textdomain' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'deal', 'with_front' => false ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 5,
    'menu_icon'          => 'dashicons-money',
    'supports'           => array( 'title', 'editor', 'excerpt', 'custom-fields', 'revisions' ), //array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'revisions' ),
    'taxonomies'         => array( 'deal_provider', 'deal_product' ),
    'show_in_rest'       => true,
    'rest_base'          => 'deals',
    'rest_controller_class' => 'WP_REST_Posts_Controller',
  );
  register_post_type( 'deal', $args );
}
add_action( 'init', 'deal_post_type' );


// Deal Provider taxonomy
function deal_provider_tax() {
  $labels = array(
    'name'              => _x( 'Providers', 'taxonomy general name (plural)', 'your-plugin-textdomain' ),
    'singular_name'     => _x( 'Provider', 'taxonomy singular name', 'your-plugin-textdomain' ),
    'search_items'      => __( 'Search Provider', 'your-plugin-textdomain' ),
    'all_items'         => __( 'All Providers', 'your-plugin-textdomain' ),
    'parent_item'       => __( 'Parent Provider', 'your-plugin-textdomain' ),
    'parent_item_colon' => __( 'Parent Provider:', 'your-plugin-textdomain' ),
    'edit_item'         => __( 'Edit Provider', 'your-plugin-textdomain' ),
    'update_item'       => __( 'Update Provider', 'your-plugin-textdomain' ),
    'add_new_item'      => __( 'Add New Provider', 'your-plugin-textdomain' ),
    'new_item_name'     => __( 'New Provider Name', 'your-plugin-textdomain' ),
    'menu_name'         => __( 'Providers', 'your-plugin-textdomain' ),
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'providers', 'with_front' => false ),
    'show_in_rest'      => true,
    'rest_base'         => 'providers',
  );
  register_taxonomy('deal_provider', array('deal'), $args);
}
add_action( 'init', 'deal_provider_tax' );


// Deal Type taxonomy
function deal_type_tax() {
  $labels = array(
    'name'              => _x( 'Deal Types', 'taxonomy general name (plural)', 'your-plugin-textdomain' ),
    'singular_name'     => _x( 'Type', 'taxonomy singular name', 'your-plugin-textdomain' ),
    'search_items'      => __( 'Search Type', 'your-plugin-textdomain' ),
    'all_items'         => __( 'All Types', 'your-plugin-textdomain' ),
    'parent_item'       => __( 'Parent Type', 'your-plugin-textdomain' ),
    'parent_item_colon' => __( 'Parent Type:', 'your-plugin-textdomain' ),
    'edit_item'         => __( 'Edit Type', 'your-plugin-textdomain' ),
    'update_item'       => __( 'Update Type', 'your-plugin-textdomain' ),
    'add_new_item'      => __( 'Add New Type', 'your-plugin-textdomain' ),
    'new_item_name'     => __( 'New Type Name', 'your-plugin-textdomain' ),
    'menu_name'         => __( 'Types', 'your-plugin-textdomain' ),
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'deal-types', 'with_front' => false ),
    'show_in_rest'      => true,
    'rest_base'         => 'deal-types',
  );
  register_taxonomy('deal_type', array('deal'), $args);
}
add_action( 'init', 'deal_type_tax' );



// Filter search results to add deal post type.
// function deal_filter_search($query) {
//   if ($query->is_search && !$query->is_author) {
//       $query->set('post_type', array('page', 'post', 'deal'));
//   }
//   return $query;
// };
// add_filter('pre_get_posts', 'deal_filter_search');


////////////////////////////////////////////////////////////////
//
// Add Advanced Custom Fields Fields to the WP REST API
//
////////////////////////////////////////////////////////////////

function wp_rest_api_acf() {
  register_rest_field( 'deal',
      'fields',
      array(
        'get_callback'    => 'wp_rest_api_acf_get_fields',
        'update_callback' => null,
        'schema'          => null,
      )
  );
}
function wp_rest_api_acf_get_fields( $data ){
  if( function_exists('get_fields') ) {
    return get_fields( $data['id'] );
  }
  return [];
}
add_action( 'rest_api_init', 'wp_rest_api_acf');




////////////////////////////////////////////////////////////////
//
// FILTER LOGIC & FORM
//
////////////////////////////////////////////////////////////////

// Global arrays for the filter
function set_deal_filter_arrays() {

  global $provider;
  global $deal_type;
  global $contract;
  global $bb_type;
  global $bb_usage;
  global $bb_download;
  global $bb_upload;
  global $sort_by;

  global $deal_type_fa_icons;

  $provider = get_terms_array('deal_provider');
  $deal_type = get_terms_array('deal_type');
  $contract = array( '1'=>'1 month', '6'=>'6 months', '12'=>'12 months', '18'=>'18 months', '24'=>'24 months');
  $bb_type = array( 'Broadband', 'Fibre' );
  $bb_usage = array( 'Unlimited', 'Unlimited - Fair Usage', 'Limited' );
  $bb_download = array_filter( get_all_meta_value('bb-download','deal') );
  $bb_upload = array_filter( get_all_meta_value('bb-upload','deal') );

  $sort_by = array( 'price'=>'Montly Price', 'total-first-year'=>'First Year Cost', 'total-contract'=>'Total overall contract cost'  );

  $deal_type_fa_icons = array( "broadband" => "fas fa-wifi fa-fw", "tv" => "fas fa-tv fa-fw", "phone" => "fas fa-phone fa-fw");


}
add_action( 'init', 'set_deal_filter_arrays' );


////////////////////////////////////////////////////////////////

function deal_pre_get_posts( $query ) {

  global $provider;
  global $deal_type;
  global $contract;
  global $bb_type;
  global $bb_usage;
  global $bb_download;
  global $bb_upload;
  global $sort_by;

	// do not modify queries in the admin
	if( is_admin() ) {
		return $query;
	}

  // DEV: disable cache for now
  $query->set('cache_results', false);
  $query->set('update_post_meta_cache', false);
  $query->set('update_post_term_cache', false);


  // Expand HOME
  if ( !isset($_GET['st']) && $query->is_main_query() && $query->is_home() && !$query->is_posts_page ) {
    $query->set('post_type', array('post', 'deal'));
  }

  // // Expand POSTS page
  // if ( !isset($_GET['st']) && $query->is_main_query() && $query->is_posts_page ) {
  //   $query->set('post_type', array('post'));
  // }

  // Expand generic SEARCH
  if ( !isset($_GET['st']) && $query->is_search() && $query->is_main_query() ) {
    $query->set('post_type', array('page', 'post', 'deal'));
  }


  // SPECIAL FILTER: POST TYPES
  if ( isset($_GET['st']) && $query->is_main_query() ) {
    // reset
    $query->set('is_search', false);
		$query->set('is_home', true);
		$query->set('is_front_page', false);

    // post type
    $query->set('post_type', array('deal'));


    // TAXONOMY
    ////////////////////////////////
    $tax_query = array();


    // Taxonomy query: PROVIDER
    if ( isset($_GET['provider']) && array_key_exists($_GET['provider'], $provider) ) {
      $tax_query[] = array( 'taxonomy'=>'deal_provider', 'field' => 'slug', 'terms'=>$_GET['provider'] );
    }
    // Taxonomy query: Type
    if ( isset($_GET['deal-type']) && array_keys_exists($_GET['deal-type'], $deal_type) ) {
      $tax_query[] = array( 'taxonomy'=>'deal_type', 'field' => 'slug', 'terms'=>$_GET['deal-type'] );
    }


    // Set meta_query
    if( count($tax_query) > 1 ) {
      $tax_query[] = array( 'relation'=>'AND' );
    }
    // Set tax_query
    if( count($tax_query) > 0 ) {
      $query->set('tax_query', $tax_query);
    }
    ////////////////////////////////


    // META QUERY
    ////////////////////////////////
    $meta_query = array();


    // Meta query: CONTRACT
    if ( isset($_GET['contract']) && array_key_exists($_GET['contract'], $contract) ) {
      $meta_query[] = array( 'key'=>'bb-contract', 'value'=>$_GET['contract'] );
    }


    // Meta query: BB TYPE
    if ( isset($_GET['bb-type']) && in_array($_GET['bb-type'], $bb_type) ) {
      $meta_query[] = array( 'key'=>'bb-type', 'value'=>$_GET['bb-type'] );
    }
    // Meta query: BB USAGE
    if ( isset($_GET['bb-usage']) && in_array($_GET['bb-usage'], $bb_usage) ) {
      $meta_query[] = array( 'key'=>'bb-usage', 'value'=>$_GET['bb-usage'] );
    }


    // Set meta_query
    if( count($meta_query) > 1 ) {
      $meta_query[] = array( 'relation'=>'AND' );
    }
    // Set meta_query
    if( count($meta_query) > 0 ) {
      $query->set('meta_query', $meta_query);
    }
    ////////////////////////////////


    // SORTING
    ////////////////////////////////
    if ( isset($_GET['sortBy']) && array_key_exists($_GET['sortBy'], $sort_by) ) {

      $selected_key = $_GET['sortBy'];

      switch ($selected_key) {
        case 'price':
          $query->set('orderby', 'meta_value_num');
          $query->set('meta_key', 'deal-price');
          $query->set('order', 'ASC');
          break;

        case 'total-first-year':
          $query->set('orderby', 'meta_value_num');
          $query->set('meta_key', 'deal-total-first-year');
          $query->set('order', 'ASC');
          break;

        case 'total-contract':
          $query->set('orderby', 'meta_value_num');
          $query->set('meta_key', 'deal-total-contract');
          $query->set('order', 'ASC');
          break;

        default:
          // default sorting
          break;
      }

    }
    ////////////////////////////////


  }

  // DEBUG
  //$query->is_main_query() ? print_r($query): '';

	// return edited query
	return $query;

}
add_action('pre_get_posts', 'deal_pre_get_posts');

// Extend PHP functions
function array_keys_exists( $array, $array_with_key ) {
  if( gettype($array)=='array') {
    foreach( $array as $value ) {
      if( array_key_exists($value, $array_with_key) ) {
        return true;
      }
    }
  } else {
    return array_key_exists($array, $array_with_key);
  }
  return false;
}


////////////////////////////////////////////////////////////////

// HTML FORM
function deal_html_filter_form( $display = true ) {

  $html = new HTML();
  global $provider;
  global $deal_type;
  global $contract;
  global $bb_type;
  global $bb_usage;
  global $bb_download;
  global $bb_upload;
  global $sort_by;

  global $deal_type_fa_icons;

  $txt = '';
  if( isset($_GET['st']) ) {
    $txt .= '<p class="filter_reset"><a href="'.str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']).'">Reset filter</p>';
  }
  $txt .= '<form action="." method="get" class="filter_form">';
  $txt .= '<input name="st" value="" type="hidden">';


  $txt .= '<div class="form-group">';
  $txt .= '<label><i class="fas fa-sort-numeric-down fa-fw"></i> Sort by </label>';
  $txt .= $html->get_select_key_array($sort_by, 'sortBy', 'Latest');
  $txt .= '</div>';
  $txt .= '<hr>';

  $txt .= '<div class="form-group">';
  $txt .= '<label>Deal on</label>';
  $txt .= $html->get_checkboxs_key_array($deal_type, 'deal-type');
  $txt .= '</div>';

  //$txt .= $html->get_checkboxs_key_array($provider, 'provider[]');

  $txt .= '<div class="form-group">';
  $txt .= '<label>Provider</label>';
  $txt .= $html->get_select_key_array($provider, 'provider', 'ALL');
  $txt .= '</div>';

  // $txt .= '<label class="">';
  // $txt .= $html->get_select_key_array($deal_type, 'deal-type', 'Any type');
  // $txt .= '</label>';

  $txt .= '<div class="form-group">';
  $txt .= '<label>Contract</label>';
  $txt .= $html->get_select_key_array($contract, 'contract', 'ALL');
  $txt .= '</div>';

  $txt .= '<hr>';
  $txt .= '<h3><i class="fas fa-wifi fa-fw"></i> Broadband</h3>';

  $txt .= '<div class="form-group">';
  $txt .= '<label>Type</label>';
  $txt .= $html->get_select_array($bb_type, 'bb-type', 'Any broadband');
  $txt .= '</div>';

  $txt .= '<div class="form-group">';
  $txt .= '<label>Usage</label>';
  $txt .= $html->get_select_array($bb_usage, 'bb-usage', 'Any broadband usage');
  $txt .= '</div>';

  $txt .= '<div class="form-group">';
  $txt .= '<label>Download</label>';
  $txt .= $html->get_select_array($bb_download, 'bb-download', 'Any download', '', 'Mb');
  $txt .= '</div>';

  $txt .= '<div class="form-group">';
  $txt .= '<label>Upload</label>';
  $txt .= $html->get_select_array($bb_upload, 'bb-upload', 'Any upload', '', 'Mb');
  $txt .= '</div>';

  // $txt .= '<hr>';
  // $txt .= '<div class="form-group">';
  // $txt .= '<input name="s" type="search" placeholder="Search..." class="form-control" value="'.esc_attr(get_search_query()).'">';
  // $txt .= '</div>';

  $txt .= '<hr>';
  $txt .= '<div class="form-group">';
  $txt .= '<button type="submit"><i class="fas fa-filter fa-fw"></i> FILTER</button>';
  $txt .= '</div>';

  $txt .= '</form>';

  if (!$display)
    $display = false;

  if ($display) {
    echo $txt;
    return null;
  } else {
    return $txt;
  }
}
