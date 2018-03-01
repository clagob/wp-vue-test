<?php
// JETPACK: SHARING
// Disable the Sharing and Like buttons
function jptweak_remove_share() {
  remove_filter( 'the_content', 'sharing_display',19 );
  remove_filter( 'the_excerpt', 'sharing_display',19 );
  if ( class_exists( 'Jetpack_Likes' ) ) {
    remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
  }
}
add_action( 'loop_start', 'jptweak_remove_share' );


// NOW use the following code where you want to display the sharing buttons
    // <?php
    // if ( function_exists( 'sharing_display' ) ) {
    //   sharing_display( '', true );
    // }
    // if ( class_exists( 'Jetpack_Likes' ) ) {
    //   $custom_likes = new Jetpack_Likes;
    //   echo $custom_likes->post_likes( '' );
    // }
    // 
