<?php

// Return an array of all meta values in use per a defined custom field (meta key)
// across a specific post tyoe (optional)
function get_all_meta_value($meta_key, $post_type = false){
  global $wpdb;
  if ( !$post_type )
    $post_type = false;
  if ( $post_type ) {
    $result = $wpdb->get_results($wpdb->prepare(
        "SELECT distinct meta_value
        FROM wp_posts,wp_postmeta
        WHERE wp_posts.ID = wp_postmeta.post_id
        AND post_type = %s
        AND wp_postmeta.meta_key = %s
        ORDER BY meta_value", $post_type, $meta_key
    ), OBJECT);
  } else {
    $result = $wpdb->get_results($wpdb->prepare(
        "SELECT distinct meta_value
        FROM wp_posts,wp_postmeta
        WHERE wp_posts.ID = wp_postmeta.post_id
        AND wp_postmeta.meta_key = %s
        ORDER BY meta_value", $meta_key
    ), OBJECT);
  }
  $a = array();
  foreach( $result as $key=>$value ){
    $a[] = $value->meta_value;
  }
  return $a;
}
