<?php
class UltimatumContent extends WP_Widget
{
    /*
     * Tricky Loops v5 Thanks to Richard
    */
    function UltimatumContent()
    {
        parent::WP_Widget(false, $name = 'WordPress Default Loop');
    }


    function widget($args, $instance)
    {
        /*
         * Ult. 2.6 text Array
         */
        $instance['loop_text_vars'] = array(
            "Read More" => __("Read More", 'ultimatum'),
            "More" => __("More", 'ultimatum'),
            "Continue Reading" => __("Continue Reading", 'ultimatum'),
            "Continue" => __("Continue", 'ultimatum'),
            "Details" => __("Details", 'ultimatum'),
            "daily" => __("Daily Archives %s", "ultimatum"),
            "monthly" => __("Monthly Archives %s", "ultimatum"),
            "yearly" => __("Yearly Archives %s", "ultimatum"),
            "archives" => __("Archives for %s", "ultimatum"),
            "author" => __("Posts by %s", "ultimatum"),
            "search" => __("Search Results for %s", "ultimatum"),

        );
        extract($args);
        echo str_replace('widget_ultimatumcontent ', '', str_replace('widget ', '', $before_widget));
        do_action('ultimatum_before_loop');
        do_action('ultimatum_loop', $args, $instance);
        do_action('ultimatum_after_loop');
        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance['single'] = $new_instance['single'];
        $instance['singlew'] = $new_instance['singlew'];
        $instance['singleh'] = $new_instance['singleh'];
        $instance['title'] = $new_instance['title'];
        $instance['meta'] = $new_instance['meta'];
        $instance['date'] = $new_instance['date'];
        $instance['author'] = $new_instance['author'];
        $instance['comments'] = $new_instance['comments'];
        $instance['cats'] = $new_instance['cats'];
        $instance['gallery'] = $new_instance['gallery'];
        $instance['imgpos'] = $new_instance['imgpos'];

        $instance['perpage'] = $new_instance['perpage'];
        $instance['mseperator'] = $new_instance['mseperator'];
        $instance['multiple'] = $new_instance['multiple'];
        $instance['multipleh'] = $new_instance['multipleh'];
        $instance['multiplew'] = $new_instance['multiplew'];
        $instance['atitle'] = $new_instance['atitle'];
        $instance['mtitle'] = $new_instance['mtitle'];
        $instance['mvideo'] = $new_instance['mvideo'];
        $instance['mmeta'] = $new_instance['mmeta'];
        $instance['mdate'] = $new_instance['mdate'];
        $instance['mauthor'] = $new_instance['mauthor'];
        $instance['mimgpos'] = $new_instance['mimgpos'];
        $instance['mcomments'] = $new_instance['mcomments'];
        $instance['mcats'] = $new_instance['mcats'];
        $instance['excerpt'] = $new_instance['excerpt'];
        $instance['excerptlength'] = $new_instance['excerptlength'];
        $instance['mreadmore'] = $new_instance['mreadmore'];
        $instance['rmtext'] = $new_instance['rmtext'];
        $instance['mmargin'] = $new_instance['mmargin'];
        $instance['mmseperator'] = $new_instance['mmseperator'];
        $instance['noimage'] = $new_instance['noimage'];
        $instance['mnoimage'] = $new_instance['mnoimage'];
        $instance['navigation'] = $new_instance['navigation'];
        $instance['show_comments_form'] = $new_instance['show_comments_form'];
        $instance['showtime'] = $new_instance['showtime'];
        $instance['mshowtime'] = $new_instance['mshowtime'];
        $instance['newmetas'] = $new_instance['newmetas'];
        $instance['newmetasm'] = $new_instance['newmetasm'];
        $instance['postnavigation'] = $new_instance['postnavigation'];
        return $instance;
    }

    function form($instance)
    {

        $single             = isset($instance['single']) ? $instance['single'] : 'fimage';
        $title              = isset($instance['title']) ? $instance['title'] : 'true';
        $excerpt            = isset($instance['excerpt']) ? $instance['excerpt'] : 'true';
        $singlew            = isset($instance['singlew']) ? $instance['singlew'] : '220';
        $singleh            = isset($instance['singleh']) ? $instance['singleh'] : '220';
        $meta               = isset($instance['meta']) ? $instance['meta'] : 'false';
        $mseperator         = isset($instance['mseperator']) ? $instance['mseperator'] : '|';
        $date               = isset($instance['date']) ? $instance['date'] : 'true';
        $author             = isset($instance['author']) ? $instance['author'] : 'false';
        $comments           = isset($instance['comments']) ? $instance['comments'] : 'true';
        $cats               = isset($instance['cats']) ? $instance['cats'] : 'false';
        $gallery            = isset($instance['gallery']) ? $instance['gallery'] : 'false';
        $imgpos             = isset($instance['imgpos']) ? $instance['imgpos'] : 'btitle';
        $show_comments_form = isset($instance['show_comments_form']) ? $instance['show_comments_form'] : 'true';
        $atitle             = isset($instance['atitle']) ? $instance['atitle'] : 'ON';
        $mtitle             = isset($instance['mtitle']) ? $instance['mtitle'] : 'true';
        $mimgpos            = isset($instance['mimgpos']) ? $instance['mimgpos'] : 'btitle';
        $mvideo             = isset($instance['mvideo']) ? $instance['mvideo'] : 'false';
        $perpage            = isset($instance['perpage']) ? $instance['perpage'] : '10';
        $multiple           = isset($instance['multiple']) ? $instance['multiple'] : '1coli';
        $multiplew          = isset($instance['multiplew']) ? $instance['multiplew'] : '220';
        $multipleh          = isset($instance['multipleh']) ? $instance['multipleh'] : '220';
        $excerptlength      = isset($instance['excerptlength']) ? $instance['excerptlength'] : '100';
        $mmeta              = isset($instance['mmeta']) ? $instance['mmeta'] : 'atitle';
        $mmargin            = isset($instance['mmargin']) ? $instance['mmargin'] : '30';
        $mdate              = isset($instance['mdate']) ? $instance['mdate'] : 'true';
        $mauthor            = isset($instance['mauthor']) ? $instance['mauthor'] : 'false';
        $mcomments          = isset($instance['mcomments']) ? $instance['mcomments'] : 'true';
        $mcats              = isset($instance['mcats']) ? $instance['mcats'] : 'false';
        $mreadmore          = isset($instance['mreadmore']) ? $instance['mreadmore'] : 'right';
        $mmseperator        = isset($instance['mmseperator']) ? $instance['mmseperator'] : '|';
        $rmtext             = isset($instance['rmtext']) ? $instance['rmtext'] : 'Read More';
        $noimage            = isset($instance['noimage']) ? $instance['noimage'] : 'true';
        $mnoimage           = isset($instance['mnoimage']) ? $instance['mnoimage'] : 'true';
        $navigation         = isset($instance['navigation']) ? $instance['navigation'] : 'numeric';
        $showtime           = isset($instance['showtime']) ? $instance['showtime'] : '';
        $mshowtime          = isset($instance['mshowtime']) ? $instance['mshowtime'] : '';
        $newmetas           = isset($instance['newmetas']) ? $instance['newmetas'] : false;
        $newmetasm          = isset($instance['newmetasm']) ? $instance['newmetasm'] : false;
        $postnavigation     = isset($instance['postnavigation']) ? $instance['postnavigation'] : 'false';
        // Random div and ul ids
        $tabsing    = ultimatum_generateRandomString();
        $tabmulti   = ultimatum_generateRandomString();
        $sort1      = ultimatum_generateRandomString();
        $sort2      = $sort1.'2';
        $sort12     = $sort1.'12';
        $singmeta   = ultimatum_generateRandomString();
        $sort3      = $sort1.'3';
        $sort4      = $sort1.'4';
        $sort34     = $sort1.'34';
        $multimeta  = ultimatum_generateRandomString();

        ?>
        <div class="ult-content-tabs">
            <ul>
                <li><a href="#<?php echo $tabsing; ?>"><?php _e('Single Post Layout', 'ultimatum') ?></a></li>
                <li><a href="#<?php echo $tabmulti; ?>"><?php _e('Multi Post Layout', 'ultimatum') ?></a></li>
            </ul>
            <div id="<?php echo $tabsing; ?>">
            <div>
                <p>
                    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ultimatum') ?></label>
                    <select class="widefat" name="<?php echo $this->get_field_name('title'); ?>"
                            id="<?php echo $this->get_field_id('title'); ?>">
                        <option value="true" <?php selected($title, 'true'); ?>>ON</option>
                        <option value="false" <?php selected($title, 'false'); ?>>OFF</option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('single'); ?>"><?php _e('Layout', 'ultimatum') ?></label>
                    <select class="widefat" name="<?php echo $this->get_field_name('single'); ?>" id="<?php echo $this->get_field_id('single'); ?>" onchange="ult_loop_image_div(this);">
                        <?php
                        if (file_exists(THEME_LOOPS_DIR . '/extraloops.php')) {
                            include(THEME_LOOPS_DIR . '/extraloops.php');
                            foreach ($extraloops as $loops) {
                                ?>
                                <option
                                    value="<?php echo $loops["file"];?>" <?php selected($single, $loops["file"]);?>><?php _e($loops["name"], 'ultimatum') ?></option>
                            <?php
                            }
                        }
                        if (is_plugin_active('wonderloops/wonderloops.php')) {
                            $theme_loops_dir = @opendir(ULTLOOPBUILDER_DIR);
                            $loop_files = array();
                            if ($theme_loops_dir) {
                                while (($file = readdir($theme_loops_dir)) !== false) {
                                    if (substr($file, 0, 1) == '.')
                                        continue;
                                    if (substr($file, -4) == '.php')
                                        $loop_files[] = $file;
                                }
                            }
                            @closedir($theme_loops_dir);
                            if ($theme_loops_dir && !empty($loop_files)) {
                                foreach ($loop_files as $loop_file) {
                                    if (is_readable(ULTLOOPBUILDER_DIR . "/$loop_file")) {
                                        unset($data);
                                        $data = ultimatum_get_loop_files(ULTLOOPBUILDER_DIR . "/$loop_file");
                                        if (isset($data['generator']) && !empty($data['generator'])) {
                                            ?>
                                            <option
                                                value="<?php echo $data["file"]; ?>" <?php selected($single, $data["file"]); ?>><?php _e($data["name"], 'ultimatum') ?></option>
                                        <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                        <option value="fimage" <?php selected($single, 'fimage'); ?>><?php _e('Full image on Top', 'ultimatum') ?></option>
                        <option value="nimage" <?php selected($single, 'nimage'); ?>><?php _e('No image', 'ultimatum') ?></option>
                        <option value="limage" <?php selected($single, 'limage'); ?>><?php _e('Image On Left', 'ultimatum') ?></option>
                        <option value="rimage" <?php selected($single, 'rimage'); ?>><?php _e('Image On Right', 'ultimatum') ?></option>
                    </select>
                </p>
                    <fieldset <?php if($single!='nimage'){echo ' style="display:block"';} else { echo 'style="display:none"';} ?>>
                    <p>
                        <label for="<?php echo $this->get_field_id('noimage'); ?>"><?php _e('No Image', 'ultimatum') ?></label>
                        <select class="widefat" name="<?php echo $this->get_field_name('noimage'); ?>" id="<?php echo $this->get_field_id('noimage'); ?>">
                            <option value="true" <?php selected($noimage, 'true'); ?>>Show Placeholder</option>
                            <option value="false" <?php selected($noimage, 'false'); ?>>OFF</option>
                        </select>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('singlew'); ?>"><?php _e('Image Width on Single Post', 'ultimatum') ?></label>
                        <input class="widefat" type="text" value="<?php echo $singlew; ?>" name="<?php echo $this->get_field_name('singlew'); ?>" id="<?php echo $this->get_field_id('singlew'); ?>"/>
                        <small><em>Applied on Image on Left/Right Aligned pages</em></small>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('singleh'); ?>"><?php _e('Image Height on Single Post', 'ultimatum') ?></label>
                        <input class="widefat" type="text" value="<?php echo $singleh; ?>"  name="<?php echo $this->get_field_name('singleh'); ?>" id="<?php echo $this->get_field_id('singleh'); ?>"/>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('imgpos'); ?>"><?php _e('Image Position', 'ultimatum') ?></label>
                        <select class="widefat" name="<?php echo $this->get_field_name('imgpos'); ?>" id="<?php echo $this->get_field_id('imgpos'); ?>">
                            <option value="atitle" <?php selected($imgpos, 'atitle'); ?>><?php _e('After Title', 'ultimatum') ?></option>
                            <option value="btitle" <?php selected($imgpos, 'btitle'); ?>><?php _e('Before Title', 'ultimatum') ?></option>
                        </select>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('gallery'); ?>"><?php _e('Replace Featured Image with gallery or Video', 'ultimatum') ?></label>
                        <select class="widefat" name="<?php echo $this->get_field_name('gallery'); ?>" id="<?php echo $this->get_field_id('gallery'); ?>">
                            <option value="false" <?php selected($gallery, 'false'); ?>>OFF</option>
                            <option value="true" <?php selected($gallery, 'true'); ?>>ON</option>
                        </select>
                    </p>
                    </fieldset>
                </div>
                <p>
                    <label for="<?php echo $this->get_field_id('show_comments_form'); ?>"><?php _e('Show Comment Form and Comments',  'ultimatum') ?></label>
                    <select class="widefat" name="<?php echo $this->get_field_name('show_comments_form'); ?>" id="<?php echo $this->get_field_id('show_comments_form'); ?>">
                        <option value="true" <?php selected($show_comments_form, 'true'); ?>>ON</option>
                        <option value="false" <?php selected($show_comments_form, 'false'); ?>>OFF</option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Taxonomy', 'ultimatum') ?></label>
                    <select class="widefat" name="<?php echo $this->get_field_name('cats'); ?>" id="<?php echo $this->get_field_id('cats'); ?>">
                        <option value="ameta" <?php selected($cats, 'ameta'); ?>><?php _e('After Meta', 'ultimatum') ?></option>
                        <option value="acontent" <?php selected($cats, 'acontent'); ?>><?php _e('After Content', 'ultimatum') ?></option>
                        <option value="false" <?php selected($cats, 'false'); ?>>OFF</option>
                    </select>
                </p>
                <div>
                    <p>
                        <label for="<?php echo $this->get_field_id('meta'); ?>"><?php _e('Meta', 'ultimatum') ?></label>
                        <select class="widefat meta-selector" name="<?php echo $this->get_field_name('meta'); ?>" id="<?php echo $this->get_field_id('meta'); ?>" onchange="ult_meta_div(this);">
                            <option value="atitle" <?php selected($meta, 'atitle'); ?>><?php _e('After Title', 'ultimatum') ?></option>
                            <option value="atext" <?php selected($meta, 'atext'); ?>><?php _e('After Content', 'ultimatum') ?></option>
                            <option value="false" <?php selected($meta, 'false'); ?>>OFF</option>
                        </select>
                    </p>
                    <fieldset class="meta" <?php if($meta!='false'){echo ' style="display:block"';} else { echo 'style="display:none"';} ?>>
                        <legend><?php _e('Single Post Meta Properties', 'ultimatum') ?></legend>
                        <p><?php _e('Drag&drop then order items from left to right column to show','ultimatum');?></p>
                        <?php
                            $metaprops = array('date'=>'Date','author'=>'Author','comments'=>'Comments');
                            if(!($newmetas)){
                                $newmeta = array();
                                if($date=='true'){
                                    $newmeta[]='date';
                                }
                                if($author=='true'){
                                    $newmeta[]='author';
                                }
                                if($comments=='true'){
                                    $newmeta[]='comments';
                                }
                                if(count($newmeta)!=0){
                                    $newmetas = implode(',',$newmeta);
                                }
                            } else {
                                $newmeta = explode(',',$newmetas);
                            }
                        ?>
                        <div style="padding:0 1px;background:#D9EDF7;width:45%;margin-left:10px;float:right;">
                        <ul id="<?php echo $sort1; ?>" class="<?php echo $sort12 ?>" style="min-height:15px;" >
                            <?php
                            foreach ($newmeta as $nmet){
                                echo '<li id="'.$nmet.'">'.ucfirst($nmet);
                                if($nmet=='date'){
                                    echo ' --';
                                    ultimatum_content_inpcheckbox( 'showtime', $showtime, 'Show time', $this);
                                }
                                echo '</li>';
                                unset($metaprops[$nmet]);
                            }
                            ?>
                        </ul>
                        </div>
                        <div style="padding:0 1px;background:#FCF8E3;width:45%;float:left;">
                        <ul id="<?php echo $sort2; ?>" class="<?php echo $sort12 ?>" style="min-height:15px;" >
                            <?php
                            foreach ($metaprops as $key=>$value){
                                echo '<li id="'.$key.'">'.$value;
                                if($key=='date'){
                                    echo ' --';
                                    ultimatum_content_inpcheckbox( 'showtime', $showtime, 'Show time', $this);
                                }
                                echo '</li>';
                            }
                            ?>
                        </ul>
                        </div>
                        <input id="<?echo $singmeta;?>" class="widefat" type="hidden" value="<?php echo $newmetas; ?>"  name="<?php echo $this->get_field_name('newmetas'); ?>" />
                        <div style="clear: both;"></div>
                        <p>
                            <label for="<?php echo $this->get_field_id('mseperator'); ?>"><?php _e('Meta Seperator', 'ultimatum') ?></label>
                            <input class="widefat" name="<?php echo $this->get_field_name('mseperator'); ?>" id="<?php echo $this->get_field_id('mseperator'); ?>" value="<?php echo $mseperator; ?>" />
                        </p>

                    </fieldset>
                </div>
                <p>
                    <label for="<?php echo $this->get_field_id('meta'); ?>"><?php _e('Show Post Navigation', 'ultimatum') ?></label>
                    <select class="widefat" name="<?php echo $this->get_field_name('postnavigation'); ?>" id="<?php echo $this->get_field_id('postnavigation'); ?>">
                        <option value="ontop" <?php selected($postnavigation, 'ontop'); ?>><?php _e('On Top', 'ultimatum') ?></option>
                        <option value="atbottom" <?php selected($postnavigation, 'atbottom'); ?>><?php _e('At Bottom', 'ultimatum') ?></option>
                        <option value="false" <?php selected($postnavigation, 'false'); ?>>OFF</option>
                    </select>
                    <em>Works for posts only</em>
                </p>


            </div>
            <div id="<?php echo $tabmulti; ?>">
                <div>
                    <p>
                        <label for="<?php echo $this->get_field_id('atitle'); ?>"><?php _e('Archive Title', 'ultimatum') ?></label>
                        <select class="widefat" name="<?php echo $this->get_field_name('atitle'); ?>" id="<?php echo $this->get_field_id('atitle'); ?>">
                            <option value="ON" <?php selected($atitle, 'ON'); ?>>ON</option>
                            <option value="OFF" <?php selected($atitle, 'OFF'); ?>>OFF</option>
                        </select>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('mtitle'); ?>"><?php _e('Title', 'ultimatum') ?></label>
                        <select class="widefat" name="<?php echo $this->get_field_name('mtitle'); ?>" id="<?php echo $this->get_field_id('mtitle'); ?>">
                            <option value="true" <?php selected($mtitle, 'true'); ?>>Yes With Links</option>
                            <option value="nolink" <?php selected($mtitle, 'nolink'); ?>>Yes Without Links</option>
                            <option value="false" <?php selected($mtitle, 'false'); ?>>OFF</option>
                        </select>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('perpage'); ?>"><?php _e('Items Per Page', 'ultimatum') ?></label>
                        <input class="widefat" type="text" value="<?php echo $perpage; ?>" name="<?php echo $this->get_field_name('perpage'); ?>" id="<?php echo $this->get_field_id('perpage'); ?>"/>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('multiple'); ?>"><?php _e('Layout When Page has Multiple Posts', 'ultimatum') ?></label>
                        <select class="widefat" name="<?php echo $this->get_field_name('multiple'); ?>" id="<?php echo $this->get_field_id('multiple'); ?>" onchange="ult_loop_image_div(this);">
                            <?php
                            if (file_exists(THEME_LOOPS_DIR . '/extraloops.php')) {
                                include(THEME_LOOPS_DIR . '/extraloops.php');
                                foreach ($extraloops as $loops) {
                                    ?>
                                    <option value="<?php echo $loops["file"];?>" <?php selected($multiple, $loops["file"]);?>><?php _e($loops["name"], 'ultimatum') ?></option>
                                <?php
                                }
                            }
                            if (is_plugin_active('wonderloops/wonderloops.php')) {
                                $theme_loops_dir = @opendir(ULTLOOPBUILDER_DIR);
                                $loop_files = array();
                                if ($theme_loops_dir) {
                                    while (($file = readdir($theme_loops_dir)) !== false) {
                                        if (substr($file, 0, 1) == '.')
                                            continue;
                                        if (substr($file, -4) == '.php')
                                            $loop_files[] = $file;
                                    }
                                }
                                @closedir($theme_loops_dir);
                                if ($theme_loops_dir && !empty($loop_files)) {
                                    foreach ($loop_files as $loop_file) {
                                        if (is_readable(ULTLOOPBUILDER_DIR . "/$loop_file")) {
                                            unset($data);
                                            $data = ultimatum_get_loop_files(ULTLOOPBUILDER_DIR . "/$loop_file");
                                            if (isset($data['generator']) && !empty($data['generator'])) {
                                                ?>
                                                <option value="<?php echo $data["file"]; ?>" <?php selected($multiple, $data["file"]); ?>><?php _e($data["name"], 'ultimatum') ?></option>
                                            <?php
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                            <option value="1-col-i" <?php selected($multiple, '1-col-i'); ?>> <?php _e('One Column With Full Image', 'ultimatum') ?> </option>
                            <option value="1-col-li" <?php selected($multiple, '1-col-li'); ?>> <?php _e('One Column With Image On Left', 'ultimatum') ?> </option>
                            <option value="1-col-ri" <?php selected($multiple, '1-col-ri'); ?>> <?php _e('One Column With Image On Right', 'ultimatum') ?> </option>
                            <option value="1-col-gl" <?php selected($multiple, '1-col-gl'); ?>> <?php _e('One Column Gallery With Image On Left', 'ultimatum') ?> </option>
                            <option value="1-col-gr" <?php selected($multiple, '1-col-gr'); ?>><?php _e('One Column Gallery With Image On Right', 'ultimatum') ?></option>
                            <option value="1-col-n" <?php selected($multiple, '1-col-n'); ?>><?php _e('One Column With No Image', 'ultimatum') ?></option>
                            <option value="2-col-i" <?php selected($multiple, '2-col-i'); ?>><?php _e('Two Columns With Image', 'ultimatum') ?></option>
                            <option value="2-col-g" <?php selected($multiple, '2-col-g'); ?>><?php _e('Two Columns Gallery', 'ultimatum') ?></option>
                            <option value="2-col-n" <?php selected($multiple, '2-col-n'); ?>><?php _e('Two Columns With No Image', 'ultimatum') ?></option>
                            <option value="3-col-i" <?php selected($multiple, '3-col-i'); ?>><?php _e('Three Columns With Image', 'ultimatum') ?></option>
                            <option value="3-col-g" <?php selected($multiple, '3-col-g'); ?>> <?php _e('Three Columns Gallery', 'ultimatum') ?> </option>
                            <option value="3-col-n" <?php selected($multiple, '3-col-n'); ?>> <?php _e('Three Columns With No Image', 'ultimatum') ?> </option>
                            <option value="4-col-i" <?php selected($multiple, '4-col-i'); ?>><?php _e('Four Columns With Image', 'ultimatum') ?></option>
                            <option value="4-col-g" <?php selected($multiple, '4-col-g'); ?>><?php _e('Four Columns Gallery', 'ultimatum') ?></option>
                            <option value="4-col-n" <?php selected($multiple, '4-col-n'); ?>><?php _e('Four Columns With No Image', 'ultimatum') ?></option>
                        </select>
                    </p>
                    <fieldset <?php if($multiple!='1-col-n' && $multiple!='2-col-n' && $multiple!='3-col-n' && $multiple!='4-col-n'){echo ' style="display:block"';} else { echo 'style="display:none"';} ?>>
                        <p>
                            <label for="<?php echo $this->get_field_id('mnoimage'); ?>"><?php _e('No Image', 'ultimatum') ?></label>
                            <select class="widefat" name="<?php echo $this->get_field_name('mnoimage'); ?>" id="<?php echo $this->get_field_id('mnoimage'); ?>">
                                <option value="true" <?php selected($mnoimage, 'true'); ?>>Show Placeholder</option>
                                <option value="false" <?php selected($mnoimage, 'false'); ?>>OFF</option>
                            </select>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('mimgpos'); ?>"><?php _e('Image Position', 'ultimatum') ?></label>
                            <select name="<?php echo $this->get_field_name('mimgpos'); ?>" class="widefat" id="<?php echo $this->get_field_id('mimgpos'); ?>">
                                <option value="atitle" <?php selected($mimgpos, 'atitle'); ?>><?php _e('After Title', 'ultimatum') ?></option>
                                <option value="btitle" <?php selected($mimgpos, 'btitle'); ?>><?php _e('Before Title', 'ultimatum') ?></option>
                            </select>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('mvideo'); ?>"><?php _e('Replace Featured Image with gallery or Video', 'ultimatum') ?></label>
                            <select name="<?php echo $this->get_field_name('mvideo'); ?>" class="widefat" id="<?php echo $this->get_field_id('mvideo'); ?>">
                                <option value="false" <?php selected($mvideo, 'false'); ?>>OFF</option>
                                <option value="true" <?php selected($mvideo, 'true'); ?>>ON</option>
                            </select>
                        </p>
                        <p>
                            <label for="<?php echo $this->get_field_id('multiplew'); ?>"><?php _e('Image Width', 'ultimatum') ?></label>
                            <input type="text" value="<?php echo $multiplew; ?>" class="widefat" name="<?php echo $this->get_field_name('multiplew'); ?>"id="<?php echo $this->get_field_id('multiplew'); ?>"/>
                            <small><em>Applied on Image on Left/Right Aligned pages</em></small>
                        </p>
                        <p>
                            <label  for="<?php echo $this->get_field_id('multipleh'); ?>"><?php _e('Image Height', 'ultimatum') ?></label>
                            <input type="text" value="<?php echo $multipleh; ?>" class="widefat" name="<?php echo $this->get_field_name('multipleh'); ?>" id="<?php echo $this->get_field_id('multipleh'); ?>"/>
                        </p>
                    </fieldset>
                </div>
                <p>
                    <label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Show Content As', 'ultimatum') ?></label>
                    <select name="<?php echo $this->get_field_name('excerpt'); ?>" class="widefat" id="<?php echo $this->get_field_id('excerpt'); ?>">
                        <option value="true" <?php selected($excerpt, 'true'); ?>>Excerpt</option>
                        <option value="content" <?php selected($excerpt, 'content'); ?>>Content</option>
                        <option value="false" <?php selected($excerpt, 'false'); ?>>OFF</option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('excerptlength'); ?>"><?php _e('Excerpt Length(words)', 'ultimatum') ?></label>
                    <input type="text" value="<?php echo $excerptlength; ?>" class="widefat"  name="<?php echo $this->get_field_name('excerptlength'); ?>" id="<?php echo $this->get_field_id('excerptlength'); ?>"/>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('mcats'); ?>"><?php _e('Taxonomy', 'ultimatum') ?></label>
                    <select name="<?php echo $this->get_field_name('mcats'); ?>" class="widefat"  id="<?php echo $this->get_field_id('mcats'); ?>">
                        <option value="ameta" <?php selected($mcats, 'ameta'); ?>><?php _e('After Meta', 'ultimatum') ?></option>
                        <option value="acontent" <?php selected($mcats, 'acontent'); ?>><?php _e('After Content', 'ultimatum') ?></option>
                        <option value="false" <?php selected($mcats, 'false'); ?>>OFF</option>
                    </select>
                </p>
                <div>
                    <p>
                        <label for="<?php echo $this->get_field_id('mmeta'); ?>"><?php _e('Meta', 'ultimatum') ?></label>
                        <select name="<?php echo $this->get_field_name('mmeta'); ?>" class="widefat" id="<?php echo $this->get_field_id('mmeta'); ?>" onchange="ult_meta_div(this);">
                            <option value="atitle" <?php selected($mmeta, 'atitle'); ?>><?php _e('After Title', 'ultimatum') ?></option>
                            <option value="atext" <?php selected($mmeta, 'atext'); ?>><?php _e('After Content', 'ultimatum') ?></option>
                            <option value="false" <?php selected($mmeta, 'false'); ?>>OFF</option>
                        </select>
                    </p>
                    <fieldset>
                        <p><?php _e('Drag&drop then order items from left to right column to show','ultimatum');?></p>
                        <?php
                        $metaprops = array('date'=>'Date','author'=>'Author','comments'=>'Comments');
                        if(!($newmetasm)){
                            $newmeta = array();
                            if($mdate=='true'){
                                $newmeta[]='date';
                            }
                            if($mauthor=='true'){
                                $newmeta[]='author';
                            }
                            if($mcomments=='true'){
                                $newmeta[]='comments';
                            }
                            if(count($newmeta)!=0){
                                $newmetasm = implode(',',$newmeta);
                            }
                        } else {
                            $newmeta = explode(',',$newmetasm);
                        }
                        ?>
                        <div style="padding:0 1px;background:#D9EDF7;width:45%;margin-left:10px;float:right;">
                            <ul id="<?php echo $sort3; ?>" class="<?php echo $sort34 ?>" style="min-height:15px;" >
                                <?php
                                foreach ($newmeta as $nmet){
                                    echo '<li id="'.$nmet.'">'.ucfirst($nmet);
                                    if($nmet=='date'){
                                        echo ' --';
                                        ultimatum_content_inpcheckbox( 'mshowtime', $mshowtime, 'Show time', $this);
                                    }
                                    echo '</li>';
                                    unset($metaprops[$nmet]);
                                }
                                ?>
                            </ul>
                        </div>
                        <div style="padding:0 1px;background:#FCF8E3;width:45%;float:left;">
                            <ul id="<?php echo $sort4; ?>" class="<?php echo $sort34 ?>" style="min-height:15px;" >
                                <?php
                                foreach ($metaprops as $key=>$value){
                                    echo '<li id="'.$key.'">'.$value;
                                    if($key=='date'){
                                        echo ' --';
                                        ultimatum_content_inpcheckbox( 'mshowtime', $mshowtime, 'Show time', $this);
                                    }
                                    echo '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <input id="<?echo $multimeta;?>" class="widefat" type="text" value="<?php echo $newmetasm; ?>"  name="<?php echo $this->get_field_name('newmetasm'); ?>" />
                       <p>
                            <label for="<?php echo $this->get_field_id('mmseperator'); ?>"><?php _e('Meta Seperator', 'ultimatum') ?> </label>
                            <input name="<?php echo $this->get_field_name('mmseperator'); ?>" class="widefat"  id="<?php echo $this->get_field_id('mmseperator'); ?>" value="<?php echo $mmseperator; ?>"/>
                        </p>
                    </fieldset>
                </div>
                <p>
                    <label for="<?php echo $this->get_field_id('mreadmore'); ?>"><?php _e('Read More Link', 'ultimatum') ?> </label>
                    <select class="widefat" name="<?php echo $this->get_field_name('mreadmore'); ?>" id="<?php echo $this->get_field_id('mreadmore'); ?>">
                        <option value="after" <?php selected($mreadmore, 'after'); ?>><?php _e('Right after excerpt', 'ultimatum') ?></option>
                        <option value="right" <?php selected($mreadmore, 'right'); ?>><?php _e('Right Aligned', 'ultimatum') ?></option>
                        <option value="left" <?php selected($mreadmore, 'left'); ?>><?php _e('Left Aligned', 'ultimatum') ?></option>
                        <option value="false" <?php selected($mreadmore, 'false'); ?>>OFF</option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('rmtext'); ?>"><?php _e('Read More Text:', 'ultimatum') ?></label>
                    <select class="widefat" name="<?php echo $this->get_field_name('rmtext'); ?>" id="<?php echo $this->get_field_id('rmtext'); ?>">
                        <option value="Read More" <?php selected($rmtext, 'Read More'); ?>><?php _e('Read More', 'ultimatum') ?></option>
                        <option value="More" <?php selected($rmtext, 'More'); ?>><?php _e('More', 'ultimatum') ?></option>
                        <option value="Continue Reading" <?php selected($rmtext, 'Continue Reading'); ?>><?php _e('Continue Reading', 'ultimatum') ?></option>
                        <option value="Continue" <?php selected($rmtext, 'Continue'); ?>><?php _e('Continue', 'ultimatum') ?></option>
                        <option value="Details" <?php selected($rmtext, 'Details'); ?>><?php _e('Details', 'ultimatum') ?></option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('navigation'); ?>"><?php _e('Navigation', 'ultimatum') ?></label>
                    <select class="widefat" name="<?php echo $this->get_field_name('navigation'); ?>" id="<?php echo $this->get_field_id('navigation'); ?>">
                        <option value="numeric" <?php selected($navigation, 'numeric'); ?>><?php _e('Numeric', 'ultimatum') ?></option>
                        <option value="prenext" <?php selected($navigation, 'prenext'); ?>><?php _e('Prev-Next', 'ultimatum') ?></option>
                        <option value="oldnew" <?php selected($navigation, 'oldnew'); ?>><?php _e('Older-Newer', 'ultimatum') ?></option>
                    </select>
                </p>

            </div>
        </div>
        <script>
            jQuery(function() {
                jQuery( "#<?php echo $sort1;?>, #<?php echo $sort2;?>" ).sortable({
                    connectWith: ".<?php echo $sort12;?>",
                    stop: function(event, ui) {
                        var ids = jQuery('#<?php echo $sort1;?>').sortable('toArray').toString();
                        jQuery('#<?php echo $singmeta;?>').val(ids);
                    }
                }).disableSelection();
                jQuery( "#<?php echo $sort3;?>, #<?php echo $sort4;?>" ).sortable({
                    connectWith: ".<?php echo $sort34;?>",
                    stop: function(event, ui) {
                        var ids = jQuery('#<?php echo $sort3;?>').sortable('toArray').toString();
                        jQuery('#<?php echo $multimeta;?>').val(ids);
                    }
                }).disableSelection();
                jQuery( ".ult-content-tabs" ).tabs();
            });
        </script>
    <?php
    }

}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumContent");'));


function ultimatum_content_inpcheckbox( $fieldid, &$currval, $title, &$that){
// ech( $fieldid, $currval);
?>
      <label for="<?php echo $that->get_field_id($fieldid); ?>"><?php echo $title; ?></label>
      <input  id="<?php echo $that->get_field_id($fieldid); ?>" name="<?php echo $that->get_field_name($fieldid); ?>" type="checkbox" value="1"  <?php checked($currval, 1, true); ?> />

<?php
} // end ultimatum_inpcheckbox


function ultimatum_content_inptextarea( $fieldid, &$currval, $title, &$that, $rows = '', $cols =''){

   $format ='';

   if ($rows !== '' ){  $format = ' rows="' .$rows. '" ';  }
   if ($cols !== '' ){  $format .= ' cols="' .$cols. '" ';  }
?>
<p>
    <label for="<?php echo $that->get_field_id($fieldid); ?>"><?php echo $title; ?>:</label>
    <textarea class="widefat" name="<?php echo $that->get_field_name($fieldid); ?>" id="<?php echo $that->get_field_id($fieldid); ?>" <?php echo $format; ?> ><?php echo $currval; ?></textarea>
</p>
<?php
}
?>