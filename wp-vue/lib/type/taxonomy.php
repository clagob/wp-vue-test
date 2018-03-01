<?php

// Used in place of the_category(), the_tag() to show custom taxonomy as links
// @return HTML links (string)
function tax_links($taxonomy_slug, $separator=', ') {
    echo get_tax_links( $taxonomy_slug, $separator );
}
function get_tax_links($taxonomy_slug, $separator=', ') {
    global $post;
    $out = array();
    $terms = get_the_terms( $post->ID, $taxonomy_slug );
    if ( !empty( $terms ) ) {
        foreach ( $terms as $term ) {
            $term_link = get_term_link( $term->slug, $taxonomy_slug );
            $out[] = '<a href="' . $term_link . '">' . $term->name . '</a>';
        }
    }
    return implode( $separator, $out );
}



// Used in place of the_category(), the_tag() to show custom taxonomy as icon links
// $icons_array = array( 'term-slug-name' => 'fa fa-wifi fw', ... );
// @return HTML icon links (string)
function tax_icons($taxonomy_slug, $icons_array, $separator=' ') {
    echo get_tax_icons( $taxonomy_slug, $separator );
}
function get_tax_icons($taxonomy_slug, $icons_array, $separator=' ') {
    global $post;
    $out = array();
    $terms = get_the_terms( $post->ID, $taxonomy_slug );
    if ( !empty( $terms ) ) {
        foreach ( $terms as $term ) {
            $term_link = get_term_link( $term->slug, $taxonomy_slug );
            $out[] = '<a href="' . $term_link . '"><i class="'.$icons_array[$term->slug].'"></i> <span>' . $term->name . '</span></a>';
        }
    }
    return implode( $separator, $out );
}



// Get taxonomy term array (labels as per WP_Term Object)
// @return key array
function get_terms_array( $taxonomy, $key_label="slug", $value_label="name" ) {
  $terms = get_terms( array('taxonomy'=>$taxonomy, 'hide_empty'=>false) );
  $a = array();
  foreach ( $terms as $term ) {
    $a[$term->{$key_label}] = $term->{$value_label};
  }
  return $a;
}
