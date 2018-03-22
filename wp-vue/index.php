<?php get_header();

// global $wp_rewrite;
// echo '<pre>';
//print_r($wp_rewrite);
// print_r($_SERVER);
// echo '</pre>';
?>

<div id="seo-content">
  <?php
  if ( have_posts() ) :
    if ( is_home() && ! is_front_page() ) {
      //echo '<h1>' . single_post_title( '', false ) . '</h1>';
      echo '<h1>' . get_bloginfo('name') . '</h1>';
    }
    while ( have_posts() ) : the_post();
      if ( is_singular() ) {
        the_title( '<h1>', '</h1>' );
      } else {
        the_title( '<h2><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
      }
      the_content();
    endwhile;
    ?>
    <nav class="paging clearfix">
      <?php
      echo paginate_links( array(
        'base' 			=> str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
        'format' 		=> '',
        'current' 		=> max( 1, get_query_var('paged') ),
        'total' 		=> $wp_query->max_num_pages,
        'prev_text' 	=> '&larr;',
        'next_text' 	=> '&rarr;',
        'type'			=> 'list',
        'end_size'		=> 2,
        'mid_size'		=> 2
      ) );
      ?>
  	</nav>
  <?php else : ?>
    <h1>Not Found</h1>
    <p>Sorry, but you are looking for something that isn't here.</p>
  <?php endif; ?>
</div>

<div id="app"></div>

<?php get_footer();
