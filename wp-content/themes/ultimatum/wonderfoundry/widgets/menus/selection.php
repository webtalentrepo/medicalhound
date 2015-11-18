<div class="ultimatum-responsive-menu">
<form id="responsive-nav-<?php echo $this->id; ?>" action="" method="post" class="responsive-nav-form">
    <div>
        <select class="responsive-nav-menu">
            <?php
            if(strlen($instance['mdmlabel'])){
            ?>
                <option value=""><?php echo $instance['mdmlabel']; ?></option>
            <?php

            } else {
            ?>
                <option value=""><?php _e('Navigation', 'ultimatum');?></option>
            <?php
            }
            $menu = wp_nav_menu(array('fallback_cb' => '', 'menu' => $nav_menu, 'echo' => false));
            if (preg_match_all('#(<a [^<]+</a>)#',$menu,$matches)) {
                $hrefpat = '/(href *= *([\"\']?)([^\"\' ]+)\2)/';
                foreach ($matches[0] as $link) {
                    // Do something with the link
                    if (preg_match($hrefpat,$link,$hrefs)) {
                        $href = $hrefs[3];
                    }
                    if (preg_match('#>([^<]+)<#',$link,$names)) {
                        $name = $names[1];
                    }
                    echo "<option value=\"$href\">$name</option>";
                }
            }
            ?>
        </select>
    </div>
</form>
</div>
