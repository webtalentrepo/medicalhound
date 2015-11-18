<?php
/*
Plugin Name: MedHound Custom plugin
Plugin URI: http://ntmatter.com/
Description: 
Version: 1.0
Author: NTMatter
Author URI: 
License: GPLv2 o posterior
*/

add_action( 'wp_enqueue_scripts', 'ifstudio_load_scripts' );

 

function ifstudio_load_scripts() {

  wp_register_script( 'yadcf',  plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.yadcf.js', array('jquery','wpdatatables'), '1.0', true );

  wp_enqueue_script( 'yadcf' );

  wp_register_style( 'yadcfcss', plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.yadcf.css' );

  wp_enqueue_style('yadcfcss');

  wp_register_style( 'yadcfcss', plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.yadcf.css' );

  wp_enqueue_style('yadcfcss');

  wp_register_script( 'select2', plugin_dir_url( __FILE__ ) . 'js/select2.full.min.js', array('jquery' ), '1.0', true );

  wp_enqueue_script( 'select2' );

  wp_register_style( 'select2css', plugin_dir_url( __FILE__ ) . 'css/select2.css' );

  wp_enqueue_style('select2css');

  wp_register_script( 'tablesaw', plugin_dir_url( __FILE__ ) . 'js/tablesaw.js', array('jquery' ), '1.0', true );

  wp_enqueue_script( 'tablesaw' );

  wp_register_style( 'tablesawcss', plugin_dir_url( __FILE__ ) . 'css/tablesaw.css' );

  wp_enqueue_style('tablesawcss');

 
};

function mhTables_function() { ?>
	
	<script>
	jQuery(document).ready(function () {
      jQuery.each( wpDataTables, function( key, value ) {

        /* Begin New functions */
        var mhTableId = key;
        var mhTable = wpDataTables[mhTableId];
        var mhOptions = mhOptionsHounds = mhOptionsTrends ='';
        
        var mhFilters = [
        	"hounds", 
        	"trends"
        ];

        /* Get columns and create Dropdown */
        jQuery.each(mhTable.fnSettings().aoColumns, function(c){
            if(mhTable.fnSettings().aoColumns[c].mData != 0 ){
	            var mhVisib = mhTable.fnSettings().aoColumns[c].bVisible;
    	        mhTable.fnSetColumnVis( c, false );

        	    var mhClasses = mhTable.fnSettings().aoColumns[c].sClass;
            	var fHound =  /filter-hounds/g;
            	var isHound = fHound.test(mhClasses);
            	var fTrends = /filter-trends/g;
            	var isTrend = fTrends.test(mhClasses);

            	if(isHound) mhOptionsHounds = mhOptionsHounds.concat('<option value="'+mhTable.fnSettings().aoColumns[c].mData+'" class="'+mhClasses+'">'+mhTable.fnSettings().aoColumns[c].sTitle + '</option>');
            	if(isTrend) mhOptionsTrends = mhOptionsTrends.concat('<option value="'+mhTable.fnSettings().aoColumns[c].mData+'" class="'+mhClasses+'">'+mhTable.fnSettings().aoColumns[c].sTitle + '</option>');
        	}
        });
        jQuery('#' + mhTableId + '_filter').append('<div class="mhfilters"><span id="' + mhTableId + 'external_filter_container_1" ><span class="lab">Schools list <i class="fa fa-info-circle tt-schools"></i></span></span><div class="allschools"><input type="checkbox" id="schoolscheckbox" ><span class="cboxlabel">Select All Schools</span></div><span id="' + mhTableId + 'external_filter_container_3"><span class="lab">Pick Trends <i class="fa fa-info-circle tt-trends"></i></span><select data-placeholder="Select your trends" multiple="multiple" id="' + mhTableId + '_columntogglerhounds">'+mhOptionsHounds+'</select></span><span id="' + mhTableId + 'external_filter_container_4"><span class="lab">Pick Hounds <i class="fa fa-info-circle tt-hounds"></i></span><select data-placeholder="Select your Hound Originals" multiple="multiple" id="' + mhTableId + '_columntogglertrends">'+mhOptionsTrends+'</select></span><span id="' + mhTableId + 'external_filter_container_5"><span class="lab">Year <i class="fa fa-info-circle tt-years"></i></span></span><a id="tableaction" href="#">Fetch!</a></div>');
        
        /* Initialize Advanced Filters */
        mhTable.yadcf([
          {column_number: 0,filter_container_id: mhTableId + 'external_filter_container_1',filter_default_label: "Select your schools",filter_type: "multi_select",select_type: 'select2'},
          {column_number : 1, filter_container_id: mhTableId + 'external_filter_container_5', column_data_type: "html", html_data_type: "text", filter_default_label: "Data from..." }
        ],{externally_triggered: true}); 

        function formatState (state) {
          if (!state.id) { return state.text; }
            var mhMatch = state.element.className.match(/tt-([A-Za-z0-9-]+)/);
              if (mhMatch !== null && typeof mhMatch !== 'undefined') {
                mhMatch = ' <i class="fa fa-info-circle ' + mhMatch[0] +'"></i>' ;
                var $state = jQuery('<span class="dropoption">' + state.text + mhMatch + '</span>');
              } else {
                return state.text;
              }
            
            return $state;
        };


         
        jQuery.each( mhFilters, function(index, el) {
        	jQuery('#' + mhTableId + '_columntoggler' + mhFilters[index] ).select2( {templateResult: formatState} ).on("select2:open", function (e) {
            jQuery.each(jQuery('.dropoption .fa-info-circle'),function(index, el) {
                var dropItem = jQuery(this);
                var popClass = dropItem.attr("class");
                var mhClassMatch = popClass.match(/tt-([A-Za-z0-9-]+)/);
                  if (mhClassMatch !== null && typeof mhClassMatch !== 'undefined') {
                    mhClassMatch = mhClassMatch[1];
                  }
                var popUp = jQuery('#box-' + mhClassMatch );
                if(popUp.length) {
                  dropItem.mouseover(function(){
                    eleOffset = dropItem.offset();
                    popUp.fadeIn("fast").css({
                    
                          left: eleOffset.left + dropItem.outerWidth(),
                          top: eleOffset.top
                    
                        });
                  }).mouseout( function(){
                    popUp.hide();
                  }); 
                }                              
            }); 

          });
        });

        jQuery.each(jQuery('.lab .fa-info-circle'),function(index, el) {
            var dropItem = jQuery(this);
            var popClass = dropItem.attr("class");
            var mhClassMatch = popClass.match(/tt-([A-Za-z0-9-]+)/);
              if (mhClassMatch !== null && typeof mhClassMatch !== 'undefined') {
                mhClassMatch = mhClassMatch[1];
              }
            var popUp = jQuery('#box-' + mhClassMatch );
            if(popUp.length) {
              dropItem.mouseover(function(){
                eleOffset = dropItem.offset();
                popUp.fadeIn("fast").css({
                
                      left: eleOffset.left + dropItem.outerWidth(),
                      top: eleOffset.top
                
                    });
              }).mouseout( function(){
                popUp.hide();
              }); 
            }                              
        });    

        /* Tablesaw parameters */
        jQuery('#' + mhTableId + ' th:first-child').attr('data-tablesaw-priority','persist');
        jQuery('#' + mhTableId ).attr('data-tablesaw-mode','swipe');

        /* Start with the table hidden */
        jQuery('.wpDataTables .dataTable thead, .wpDataTables .dataTable tbody').hide();

		/* Render and show table on button pressing */
        jQuery('#tableaction').click(function(event) {
        	event.preventDefault();
	        jQuery.each(mhTable.fnSettings().aoColumns, function(c){
	            if(mhTable.fnSettings().aoColumns[c].mData != 0 ){
	    	        mhTable.fnSetColumnVis( c, false );
	    	    }
	        });
	        var mhCols = new Array(); 
	        jQuery.each( mhFilters, function(index, el) {
	        	if (jQuery('#' + mhTableId + '_columntoggler' + mhFilters[index] ).val() != null) {
	        		mhCols = jQuery.merge(jQuery('#' + mhTableId + '_columntoggler' + mhFilters[index] ).val(),mhCols);
	       		};
	        });   
        	var uniqueCols = [];
        	jQuery.each(mhCols, function(i, el){
        	    if(jQuery.inArray(el, uniqueCols) === -1) uniqueCols.push(el);
        	});
        	jQuery.each(uniqueCols, function(i, el){
        	    mhTable.fnSetColumnVis( el, true );
        	});
        	yadcf.exFilterExternallyTriggered(mhTable);        	
        	jQuery('#' + mhTableId ).removeData();
        	jQuery('.tablesaw-advance').remove();
        	//
        	jQuery('.wpDataTables .dataTable thead,.wpDataTables .dataTable tbody').show();
          jQuery('#' + mhTableId ).table().data("table").refresh();

          });
        
        jQuery("#schoolscheckbox").click(function(){
            if(jQuery("#schoolscheckbox").is(':checked') ){
                jQuery( "#" + mhTableId + "external_filter_container_1 option").prop("selected","selected");
                jQuery( "#yadcf-filter--" + mhTableId + "-0").trigger("change");
            }else{
                jQuery( "#" + mhTableId + "external_filter_container_1 option").removeAttr("selected");
                 jQuery( "#yadcf-filter--" + mhTableId + "-0").trigger("change");
             }
        });
        /* End new functions */

      });


    });
    </script>

    <?php 
    $cargs = array(
      'post_type' => 'tooltip',
      'posts_per_page' => -1
    );
    $ttquery = new WP_Query( $cargs );
    while ( $ttquery->have_posts() ) {
      $ttquery->the_post();
      echo '<div id="box-'.$ttquery->post->post_name.'" class="mhtooltip" style="display:none;">' . get_the_content() . '</div>';
    }
    wp_reset_postdata();
}
add_action( 'wp_footer', 'mhTables_function', 100 );



/**
 * Register a tooltips post type
 */
function mh_tooltips_init() {
  $labels = array(
    'name'               => _x( 'Tooltips', 'post type general name', 'medhound' ),
    'singular_name'      => _x( 'Tooltip', 'post type singular name', 'medhound' ),
    'menu_name'          => _x( 'Tooltips', 'admin menu', 'medhound' ),
    'name_admin_bar'     => _x( 'Tooltip', 'add new on admin bar', 'medhound' ),
    'add_new'            => _x( 'Add New', 'tooltip', 'medhound' ),
    'add_new_item'       => __( 'Add New Tooltip', 'medhound' ),
    'new_item'           => __( 'New Tooltip', 'medhound' ),
    'edit_item'          => __( 'Edit Tooltip', 'medhound' ),
    'view_item'          => __( 'View Tooltip', 'medhound' ),
    'all_items'          => __( 'All Tooltips', 'medhound' ),
    'search_items'       => __( 'Search Tooltips', 'medhound' ),
    'parent_item_colon'  => __( 'Parent Tooltips:', 'medhound' ),
    'not_found'          => __( 'No tooltips found.', 'medhound' ),
    'not_found_in_trash' => __( 'No tooltips found in Trash.', 'medhound' )
  );

  $args = array(
    'labels'             => $labels,
    'description'        => __( 'Description.', 'medhound' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'tooltip' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'editor')
  );

  register_post_type( 'tooltip', $args );
}

add_action( 'init', 'mh_tooltips_init' );