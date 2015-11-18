<?php get_header(); ?>
	<div id="container">
            <?php
                if( myThemes::get( 'general-sidebar' ) == 'left'){
            ?>	
                    <aside>
                        <?php get_sidebar(); ?>
                    </aside>
            <?php		
                }
            ?>
            <div id="content">
                <h2 class="title"><?php _e( 'Error 404 - Not Found' , "mythemes" ); ?></h2>
                <p><?php _e( 'We apologize but this page, post or resource does not exist or can not be found. Perhaps it is necessary to change the call method to this page, post or resource.' , "mythemes" ) ?></p>
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