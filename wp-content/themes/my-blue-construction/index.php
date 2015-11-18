<?php get_header(); ?>
	
    <div id="container">
        <?php
            if( myThemes::get( 'general-sidebar' ) == 'left' ) {
        ?>	
                <aside>
                    <?php get_sidebar(); ?>
                </aside>
        <?php		
            }
        ?>
        <div id="content">
            <h2 class="title"><?php _e( 'Archive' , "mythemes" ); ?></h2>
            <?php 
                if( have_posts( ) ) : 
                    while( have_posts( ) ) : the_post( );
            ?>

                        <!-- start post -->
                        <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">

                            <!-- title of post -->
                            <?php 
                                if( strlen( $post -> post_title ) ) { 
                            ?>  
                                    <h2 class="title">
                                            <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to' , "mythemes" ); ?> <?php the_title(); ?>"><?php the_title(); ?></a>
                                    </h2>
                            <?php 
                                }
                            ?>

                            <!-- header-->
                            <div class="meta">
                                <span class="meta-info meta-text meta-link"><?php _e( 'Posted on' , "mythemes" ); ?> <?php the_time( get_option( 'date_format' ) ) ?> <?php _e( 'in' , "mythemes" ); ?> <?php the_category(', ') ?></span>
                                <div class="clear"></div>
                            </div>	

                            <!-- content  -->								
                            <div class="entry">
                                
                                <?php
                                    if( has_post_thumbnail() ){
                                        the_post_thumbnail( 'thumbnail' ); 
                                    }
                                ?>
                                <?php if(strlen($post -> post_title) == 0){ ?> <p><a href="<?php the_permalink() ?>"><?php _e( 'Read more about this' , "mythemes" ); ?>..</a></p> <?php }?>
                                <?php the_excerpt( ); ?>

                            </div>

                            <!-- footer-->
                            <div class="meta meta-bottom">
                                <span class="meta-utility meta-text meta-link"><?php _e( 'comments' , "mythemes" ); ?>: 
                                        <?php if ('open' == $post->comment_status) : ?> 
                                                <?php comments_popup_link(' 0 &#187;', ' 1 &#187;', ' % &#187;'); ?>
                                        <?php else : ?>
                                                <?php _e( 'Closed' , "mythemes" ); ?>
                                        <?php endif; ?>
                                </span>	

                                <span class="meta-utility meta-text meta-link">
                                                <?php edit_post_link( __( 'Edit' , "mythemes" ) , '', ''); ?>
                                </span>


                                <span class="meta-tags meta-text meta-link">	
                                        <?php the_tags('tags: ',', ',''); ?>
                                </span>	
                                <div class="clear"></div>
                            </div>
                        </div><!-- end post -->

                    <?php endwhile; ?><!-- end loop post -->

                    <!-- Navigation-->
                    <div class="navigation">
                      <span class="previous-posts"><?php next_posts_link('&laquo; ' . __( 'Previous' , "mythemes" ) ) ?></span> <span class="next-posts"><?php previous_posts_link( __( 'Next' , "mythemes" ) . ' &raquo;') ?></span>
                    </div><!-- end navigation-->

                <?php else : ?>

                    <h2><?php _e( 'Not Found' , "mythemes" ); ?></h2>
                    <p><?php _e( 'We apologize but this page, post or resource does not exist or can not be found. Perhaps it is necessary to change the call method to this page, post or resource.' , "mythemes" ) ?></p>

            <?php endif; ?>
        </div>
        <?php
            if( myThemes::get( 'general-sidebar' ) == 'right' ) {
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
