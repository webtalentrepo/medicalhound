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
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<!-- start post -->
					<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					
						<!-- title of post -->
						<?php 
							if(strlen($post -> post_title) > 0){ 
						?>  
							<h1 class="title">
								<?php the_title(); ?>
							</h1>
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
                                    echo '<div class="feat-img">';
                                    the_post_thumbnail( 'full' ); 
                                    echo '</div>';
                                }
                            ?>
							<?php if(strlen($post -> post_title) == 0){ ?> <p><a href="<?php the_permalink() ?>"><?php _e( 'Read more about this' , "mythemes" ); ?>..</a></p> <?php }?>
							<?php the_content( __( 'Click here to read more' , "mythemes" ). '.. &raquo;'); ?>
							<?php wp_link_pages( array( 'before' => '<p><div class="navigation"><div id="previous-posts">' . __( 'Pages', "mythemes" ) . ':', 'after' => '</div></div></p>' ) ); ?>
						</div>
						
						<!-- footer-->
						<div class="meta meta-bottom">
							<span class="meta-utility meta-text meta-link">comments: 
								<?php if ('open' == $post->comment_status) : ?> 
									<?php comments_popup_link(' 0 &#187;', ' 1 &#187;', ' % &#187;'); ?>
								<?php else : ?>
									<?php _e( 'Closed' , "mythemes" ); ?>
								<?php endif; ?>
							</span>	
							
							<span class="meta-utility meta-text meta-link">
									<?php edit_post_link( __( 'Edit' , "mythemes" ), '', ''); ?>
							</span>
							
							
							<span class="meta-tags meta-text meta-link">	
								<?php the_tags( __( 'tags' , "mythemes" ) . ': ',', ',''); ?>
							</span>
                                                        <div class="clear"></div>
						</div>
					</div><!-- end post -->
					
					
					<!-- navigation -->
					<div class="navigation">
                                            <span class="previous-posts"><?php previous_post_link( '%link', '&laquo; Previous' ); ?></span>
                                            <span class="next-posts"><?php next_post_link( '%link', 'Next &raquo;' ); ?></span>
					</div> <!-- end navigation -->

					<?php comments_template(); ?>
				
				<?php endwhile; else : ?>
					<p><?php _e( 'We apologize but this page, post or resource does not exist or can not be found. Perhaps it is necessary to change the call method to this page, post or resource.' , "mythemes" ) ?></p>
				<?php endif; ?>
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