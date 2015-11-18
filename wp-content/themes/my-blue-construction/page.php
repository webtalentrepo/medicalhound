<?php
    if( myThemes::get( 'front-page-type' ) == 'posts'  ){
        
        if( myThemes::get( 'front-page-blog-page' ) == $post -> ID ){
            global $wp_query;
            
            $paged = myThemes::pagination();
            
            $wp_query = new WP_Query( array( 'post_type' => 'post' , 'post_status' => 'publish', 'paged' => $paged ) );
            get_template_part( 'index' );
            exit;
        }
    }
    
?>
<?php get_header(); ?>
	<div id="container">
        <?php
            global $myLayout;
            $myLayout = new layout();
            $myLayout -> width = 630;
            if( myThemes::get( 'general-sidebar' ) == 'left'){
        ?>	
                <aside>
                    <?php get_sidebar(); ?>
                </aside>
        <?php		
            }
        ?>
        <div id="content">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                        <h2 class="title"><?php the_title(); ?></h2>
                        <div class="entry">	
                                <?php the_content('<p class="serif">' . __( 'Read the rest of this page' , "mythemes" ) . '.. &raquo;</p>'); ?>
                                <?php wp_link_pages('<p><strong>' . __( 'Pages' , "mythemes" ) . ':</strong> ', '</p>', 'number' ); ?>
                        </div>
                </div>
                <br /><br />
                <?php comments_template(); ?>

            <?php endwhile; endif; ?>
        </div>
        <?php
            if( myThemes::get( 'general-sidebar' ) == 'right'){
        ?>	
                <aside>
                    <?php get_sidebar(); ?>
                </aside>
        <?php		
            }
        ?>
        <div class="content-bottom"></div>
  </div>
<?php get_footer(); ?>