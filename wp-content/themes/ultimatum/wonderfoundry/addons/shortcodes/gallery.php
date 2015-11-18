<?php

// By Justin Tadlock (http://justintadlock.com)
function shortcode_gallery( $output, $attr ) {
	global $post;

	static $cleaner_gallery_instance = 0;
	$cleaner_gallery_instance++;

	/* We're not worried abut galleries in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;

	/* Orderby. */
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
	
	/* Default gallery settings. */
	$defaults = array(
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'id' => $post->ID,
		'link' => '',
		'itemtag' => 'dl',
		'icontag' => 'dt',
		'captiontag' => 'dd',
		'columns' => 3,
		'caption' => 'false',
		'lightboxtitle' => 'caption',//title,caption,none
		'size' => 'thumbnail',
		'include' => '',
		'exclude' => '',
		'numberposts' => -1,
		'offset' => ''
	);
	
	/* Merge the defaults with user input. Make sure $id is an integer. */
	$attr = shortcode_atts( $defaults, $attr );
	extract( $attr );
	$id = intval( $id );

	/* Arguments for get_children(). */
	$children = array(
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => $order,
		'orderby' => $orderby,
		'exclude' => $exclude,
		'include' => $include,
		'numberposts' => $numberposts,
		'offset' => $offset,
	);

	/* Get image attachments. If none, return. */
	$attachments = get_posts( $children );

	if ( empty( $attachments ) )
		return '';

	/* Properly escape the gallery tags. */
	$itemtag = tag_escape( $itemtag );
	$icontag = tag_escape( $icontag );
	$captiontag = tag_escape( $captiontag );
	$i = 0;

	/* Count the number of attachments returned. */
	$attachment_count = count( $attachments );

	/* If there are fewer attachments than columns, set $columns to $attachment_count. */
	//$columns = ( ( $columns <= $attachment_count ) ? intval( $columns ) : intval( $attachment_count ) );

	/* Open the gallery <div>. */
	$output = "\n\t\t\t<div id='gallery-{$id}-{$cleaner_gallery_instance}' class='gallery gallery-{$id}'>";

	/* Loop through each attachment. */
	foreach ( $attachments as $attachment ) {

		/* Open each gallery row. */
		if ( $columns > 0 && $i % $columns == 0 )
			$output .= "\n\t\t\t\t<div class='gallery-row'>";

		/* Open each gallery item. */
		$output .= "\n\t\t\t\t\t<{$itemtag} class='gallery-item col-{$columns}'>";

		/* Open the element to wrap the image. */
		$output .= "\n\t\t\t\t\t\t<{$icontag} class='gallery-icon'>";

		/* Add the image. */
		$img_lnk = wp_get_attachment_image_src($attachment->ID, 'full');
		$img_lnk = $img_lnk[0];

		$img_src = wp_get_attachment_image_src( $attachment->ID, $size );
		$img_src = $img_src[0];
		
		$img_alt = wptexturize( esc_html($attachment->post_excerpt) );
		
		if ( $img_alt == null )
			$img_alt = $attachment->post_title;
		switch($lightboxtitle){
			case 'caption':
				$lightbox_title = wptexturize( esc_html($attachment->post_excerpt) );
				break;
			case 'title':
				$lightbox_title = $attachment->post_title;
				break;
			case 'none':
			default:
				$lightbox_title = '';
		}
		$img_class = apply_filters( 'gallery_img_class', (string) 'gallery-image' ); // Available filter: gallery_img_class
		$img_rel = 'group-' . $post->ID.'[]';
		$image  =  '<img src="' . $img_src . '" alt="' . $img_alt . '" class="' . $img_class . ' attachment-' . $size . '" />';
		
		
			$image = '<a href="' . $img_lnk . '" class="prettyPhoto image_icon_zoom gallery-image-wrap" title="' . $lightbox_title . '" rel="' . $img_rel . '">'.$image.'</a>';
		
		$output .= $image;
		
		/* Close the image wrapper. */
		$output .= "</{$icontag}>";
		
		/* Get the caption. */
		if($caption != 'false'){
			/* If image caption is set. */
			if ( !empty( $img_alt ) )
				$output .= "\n\t\t\t\t\t\t<{$captiontag} class='gallery-caption'>{$img_alt}</{$captiontag}>";
		}		

		/* Close individual gallery item. */
		$output .= "\n\t\t\t\t\t</{$itemtag}>";

		/* Close gallery row. */
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= "\n\t\t\t\t</div>";
	}

	/* Close gallery row. */
	if ( $columns > 0 && $i % $columns !== 0 )
		$output .= "\n\t\t\t</div>";

	/* Close the gallery <div>. */
	$output .= "\n\t\t\t</div><!-- .gallery -->\n";

	/* Return out very nice, valid HTML gallery. */
	return $output;
}
/* Filter the post gallery shortcode output. */
add_filter( 'post_gallery', 'shortcode_gallery', 20, 2 );