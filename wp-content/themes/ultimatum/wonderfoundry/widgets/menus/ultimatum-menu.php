<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
 */
// TODO Woocommerce cart functionality
/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @package  Ultimatum
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.50
 */

?>
<div class="ultimatum-menu">
    <nav class="nav-holder">
        <ul class="navigation ultimatum-menu-nav">
            <?php 
            wp_nav_menu( array(
                'menu' => $nav_menu,
                'menu_class' => 'nav',
                'depth'				=> 5,
                'container' 		=> false,
                'items_wrap' 		=> '%3$s',
                'menu_class'		=> 'nav ultimatum-menu-nav',
                'walker' => new UltimatumMenuFrontendWalker())
                );
            if($instance['ultimatum_menu_wc_login'] =='login'){
            ?>
            <li class="my-account">
    			<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"><?php _e('My Account', 'ultimatum'); ?></a>
    			<?php if(!is_user_logged_in()): ?>
    			<div class="login-box">
    				<?php if( isset($_GET['login']) && $_GET['login']=='failed'): ?>
    					<p class="woo-login-error"><?php echo _e( 'Login failed, please try again','ultimatum' ); ?></p>
    				<?php endif; ?>			
    				<form action="<?php echo wp_login_url(); ?>" name="loginform" method="post">
    					<p>
    						<input type="text" class="input-text" name="log" id="username" value="" placeholder="<?php echo __('Username', 'ultimatum'); ?>" />
    					</p>
    					<p>
    						<input type="password" class="input-text" name="pwd" id="password" value="" placeholder="<?php echo __('Password', 'ultimatum'); ?>" />
    					</p>
    					<p class="forgetmenot">
    						<label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> <?php _e('Remember Me', 'ultimatum'); ?></label>
    					</p>
    						<p class="submit">
    						<input type="submit" name="wp-submit" id="wp-submit" class="btn btn-small" value="<?php _e('Log In', 'ultimatum'); ?>">
    						<input type="hidden" name="redirect_to" value="<?php if(isset($_SERVER['HTTP_REFERER'])): echo $_SERVER['HTTP_REFERER']; endif; ?>">
    						<input type="hidden" name="testcookie" value="1">
    					</p>
    					<div class="clear"></div>
    				</form>
    			</div>
    			<?php else: ?>
    			<ul class="sub-menu">
    				<li><a href="<?php echo wp_logout_url( ); ?>"><?php _e('Logout', 'ultimatum'); ?></a></li>
    			</ul>
    			<?php endif; ?>
    		</li>
    		<?php
            }
            if($instance['ultimatum_menu_wc_cart'] =='cart'){
            ?>
    		<li class="cart">
    			<?php //var_dump($woocommerce->cart); ?>
    			<?php if(!$woocommerce->cart->cart_contents_count): ?>
    			<a class="empty-cart" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><span><?php _e('Cart', 'ultimatum'); ?></span></a>
    			<?php else: ?>
    			<a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php echo $woocommerce->cart->cart_contents_count; ?> <?php _e('Item(s)', 'ultimatum'); ?><span class="amount-with-sep"> - <?php echo wc_price($woocommerce->cart->subtotal); ?></span></a>
    			<div class="cart-contents">
    				<?php foreach($woocommerce->cart->cart_contents as $cart_item): ?>
    				<div class="cart-content">
    					<a href="<?php echo get_permalink($cart_item['product_id']); ?>">
    					<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
    					<?php echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail'); ?>
    					<div class="cart-desc">
    						<span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
    						<span class="product-quantity"><?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?></span>
    					</div>
    					</a>
    				</div>
    				<?php endforeach; ?>
    				<div class="cart-checkout">
    					<div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'ultimatum'); ?></a></div>
    					<div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'ultimatum'); ?></a></div>
    				</div>
    			</div>
    			<?php endif; ?>
    		</li>
            <?php
            }
            if($instance['ultimatum_menu_search'] =='search'){
            ?>
            <li class="nav-search">
        		<a class="search-link"></a>
        		<div class="nav-search-form">
        			<form role="search" id="searchform" method="get" action="<?php echo home_url( '/' ); ?>">
        				<div class="search-table">
        					<div class="search-field">
        						<input type="text" value="" name="s" id="s" />
        					</div>
        					<div class="search-button">
        						<input type="submit" id="searchsubmit" value="&#xf002;" />
        					</div>
        				</div>
        			</form>
        		</div>
        	</li>
        	<?php 
            } //search form
        	?>
        </ul>
        
    </nav>
</div>
