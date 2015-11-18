<?php

/*
 * Tricky Loops v5 Thanks to Richard
 */

class UltimatumCustomContent extends WP_Widget {

	function UltimatumCustomContent() {
		parent::WP_Widget( false, $name = 'WordPress Custom Loop' );
	}


	function widget( $args, $instance ) {
		/*
		 * Ult. 2.6 text Array
		*/
		$loop_text_vars = array(
			"Read More"        => __( "Read More", 'ultimatum' ),
			"More"             => __( "More", 'ultimatum' ),
			"Continue Reading" => __( "Continue Reading", 'ultimatum' ),
			"Continue"         => __( "Continue", 'ultimatum' ),
			"Details"          => __( "Details", 'ultimatum' ),

		);
		remove_all_actions( 'ultimatum_before_featured_image' );
		remove_all_actions( 'ultimatum_after_featured_image' );
		extract( $args );
		$instance['ult_full_image'] = false;
		$title                      = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title ) :
			echo $before_title . $title . $after_title;
		endif;
		// Column Properties
		$colprops  = explode( '-', $instance["multiple"] );
		$colcount  = $colprops[0];
		$i         = 1;
		$count     = $instance["perpage"];
		$gallery   = false;
		$rel       = '';
		$col_class = '';
		switch ( $colcount ) {
			case '1':
				$grid = $grid_width;
				$cols = 1;
				break;
			case '2':
				$grid      = $grid_width / 2;
				$cols      = 2;
				$col_class = 'one_half';
				break;
			case '3':
				$grid      = $grid_width / 3;
				$cols      = 3;
				$col_class = 'one_third';
				break;
			case '4':
				$grid      = $grid_width / 4;
				$cols      = 4;
				$col_class = 'one_fourth';
				break;
		}
		$colcount = $cols;
		if ( $colcount == 1 && ( $colprops[2] == 'ri' || $colprops[2] == 'li' || $colprops[2] == 'gl' || $colprops[2] == 'gr' ) ) {
			$imgw = $instance["multiplew"];
		} else {
			$imgw                       = $grid;
			$instance['ult_full_image'] = true;
		}
		$gallery = false;
		switch ( $colprops[2] ) {
			case 'ri':
				$align = "fimage-align-right";
				$image = true;

				break;
			case 'li':
				$align = "fimage-align-left";
				$image = true;
				break;
			case 'gl':
				$align   = "fimage-align-left";
				$rel     = 'rel="prettyPhoto[]"';
				$gallery = true;
				$image   = true;
				break;
			case 'gr':
				$align   = "fimage-align-right";
				$rel     = 'rel="prettyPhoto[]"';
				$gallery = true;
				$image   = true;
				break;
			case 'g':
				$rel     = 'rel="prettyPhoto[]"';
				$gallery = true;
				$align   = '';
				$image   = true;
				break;
			case 'i':
				$align = '';
				$image = true;
				break;
			default:
				$image = false;
				$align = '';
				break;
		}
		global $wp_filter;
		$source                    = $instance['source'];
		$the_content_filter_backup = $wp_filter['the_content'];
		$looporder1                = isset( $instance['looporder1'] ) ? $instance['looporder1'] : '';
		$looporder2                = isset( $instance['looporder2'] ) ? $instance['looporder2'] : '';
		$skip                      = isset( $instance['skip'] ) ? $instance['skip'] : 0;
		// set order defaults
		$orderby = 'date';
		$order   = 'DESC';
		$order   = isset( $instance['orderdir'] ) ? $instance['orderdir'] : 'DESC';
		if ( $looporder1 ) {
			$orderby = $looporder1;
			$setby1  = true;
		}
		if ( $looporder2 ) {
			if ( $setby1 ) {
				$orderby .= ' ' . $looporder2;
			} else {
				$orderby = $looporder2;
			}
		}
		if ( preg_match( '/ptype-/i', $source ) ) {
			$post_type = str_replace( 'ptype-', '', $source );
		} elseif ( preg_match( '/cat-/i', $source ) ) {
			$post_type = 'post';
			$cat       = str_replace( 'cat-', '', $source );
		} elseif ( preg_match( '/taxonomy-/i', $source ) ) {
			$prop                = explode( '|', str_replace( 'taxonomy-', '', $source ) );
			$post_type           = $prop[0];
			$taxonmy['taxonomy'] = $prop[1];
			$taxonmy['term']     = $prop[2];
		}
		$query = array(
			'posts_per_page' => (int) $count,
			'post_type'      => $post_type,
			'orderby'        => $orderby,
			'order'          => $order,
		);
		if ( $skip > 0 ) {
			$query['offset'] = $skip;
		}
		if ( $cat ) {
			$query['cat'] = $cat;
		}
		if ( isset( $taxonmy ) ) {
			$query['taxonomy'] = $taxonmy['taxonomy'];
			$query['term']     = $taxonmy['term'];
		}
		$query['showposts'] = $count;


		$r                  = new WP_Query( $query );
		$a_custom_loop      = true;
		$loopfile           = null;
		if ( preg_match( '/.php/i', $instance["multiple"] ) ) {
			$loopfile = $instance["multiple"];
		}
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( isset( $loopfile ) && file_exists( THEME_LOOPS_DIR . DS . $loopfile ) ) {
			include( THEME_LOOPS_DIR . DS . $loopfile );
		} elseif ( is_plugin_active( 'wonderloops/wonderloops.php' ) && isset( $loopfile ) && file_exists( ULTLOOPBUILDER_DIR . DS . $loopfile ) ) { //Wonder Loop include
			include( ULTLOOPBUILDER_DIR . DS . $loopfile );

		} else {
			if ( $r->have_posts() ):
				while ( $r->have_posts() ) : $r->the_post();
					global $post;
					if ( $colcount != 1 )://gridd
						if ( $i == 1 ) {
							$i ++;
							$gps = false;
						} elseif ( $i == $colcount ) {
							$gps = true;
							$i   = 1;
						} else {
							$i ++;
							$gps = false;
						}
					else :
						$gps = '';
					endif;//gridd
					?>
                    <article class="post <?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?> <?php if ( get_post_meta( $post->ID, 'ultimatum_video', true ) ) { ?>video-post <?php } ?> post-<?php echo $post->ID; ?> ultimatepost-custom <?php echo $col_class;
                    if ( $gps ) {
                        echo " last";
                    } ?>">
						<div class="post-inner">
							<?php
							if ( $image && ( $imgw != $grid || $instance["mimgpos"] == 'btitle' ) ) {
								?>
								<?php $this->ultimatum_custom_loop_image( $args, $instance, $imgw, $rel, $align, $gallery );?>
								<?php if ( $instance["mmeta"] == 'aimage' ) {
									echo $this->blog_multimeta( $instance );
								} ?>
							<?php
							}

							?>
							<?php if ( $instance["mtitle"] == 'true' ) { ?>
								<h3 class="post-header">
									<?php if ( $rel ) { ?>
										<?php the_title(); ?>
									<?php } else { ?>
										<a class="post-title" href="<?php the_permalink(); ?>"><?php the_title() ?></a>
									<?php } ?>
								</h3>
							<?php } ?>
							<?php if ( $image && ( $imgw == $grid && $instance["mimgpos"] == 'atitle' ) ) { ?>
								<div class="aligner">
									<?php $this->ultimatum_custom_loop_image( $args, $instance, $imgw, $rel, $align, $gallery ); ?>
									<?php if ( $instance["mmeta"] == 'aimage' ) {
										echo $this->blog_multimeta( $instance );
									} ?>
								</div>
							<?php } ?>

							<?php if ( $instance["mmeta"] == 'atitle' ) {
								echo $this->blog_multimeta( $instance );
							} ?>
							<?php if ( $instance["excerpt"] == 'true' ) { ?>
								<p class="post-excerpt"><?php echo wp_html_excerpt( get_the_excerpt(), $instance["excerptlength"] ); ?>
									...</p>
							<?php } elseif ( $instance['excerpt'] == 'content' ) { ?>
								<p class="post-excerpt"><?php the_content(); ?></p>
							<?php } ?>
							<?php if ( $instance["mmeta"] == 'atext' ) {
								echo $this->blog_multimeta( $instance );
							}

							$tax = '';

							if ( $instance["mcats"] == 'acontent' ) {
								$tax  = array();
								$_tax = array();
								$_tax = get_the_taxonomies();
								if ( empty( $_tax ) ) {
								} else {
									foreach ( $_tax as $key => $value ) {
										preg_match( '/(.+?): /i', $value, $matches );
										$tax[] = '<span class="entry-tax-' . $key . '">' . str_replace( $matches[0], '<span class="entry-tax-meta">' . $matches[1] . ':</span> ', $value ) . '</span>';
									}
								}
								echo '<div class="post-meta taxonomy">' . join( '<br />', $tax ) . '</div>';

							}
							if ( $instance["mreadmore"] != 'false' ) {
								?>
								<p style="text-align:<?php echo $instance["mreadmore"]; ?>">
									<a href="<?php the_permalink(); ?>" class="readmorecontent read-more custom-loop">
										<?php echo $loop_text_vars[ $instance['rmtext'] ]; ?>
									</a>
								</p>
							<?php } ?>
						</div>
					</article>


					<?php
					if ( $i == 1 ) {
						echo '<div style="clear:both"></div>';
					}

				endwhile;
			endif;

		}
		?>
		<?php
		echo '<div style="clear:both"></div>';
		?>

		<?php
		wp_reset_postdata();
		$wp_filter['the_content'] = $the_content_filter_backup;
		echo $after_widget;
	}

	function ultimatum_custom_loop_image( $args, $instance, $imgw, $rel, $align, $gallery ) {
		global $post;
		extract( $args );
		$img    = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		$imgsrc = false;
		if ( ! $img && $instance["mnoimage"] == 'true' ) {
			$img[0] = null;
			if ( get_ultimatum_option( 'general', 'noimage' ) ) {
				$img[0] = get_ultimatum_option( 'general', 'noimage' );
			}
			$imgsrc = UltimatumImageResizer( null, $img[0], $imgw, $instance["multipleh"], true );
		} elseif ( is_array( $img ) ) {
			$imgsrc = UltimatumImageResizer( get_post_thumbnail_id(), null, $imgw, $instance["multipleh"], true );
		}
		if ( $imgsrc ) { ?>
		<div class="featured-image <?php echo $align;?>" <?php if ($gallery){ ?>style="position: relative"<?php } ?>>
			<?php
			$video = get_post_meta( $post->ID, 'ultimatum_video', true );
			if ( $gallery ) {
				if ( $video ) {
					$link = $video . '';
				} else {
					$link = $img[0];
					if ( preg_match( '/holder.js/i', $imgsrc ) ) {
						$link = '';
						$rel  = '';
					}
				}
			}
			if ( $instance["mvideo"] == 'true' ) {
				if ( get_post_meta( $post->ID, '_image_ids', true ) && ! $gallery && $instance['ult_full_image'] ) {
					post_gallery( $imgw, $instance["multipleh"], $instance );
				} elseif ( get_post_meta( $post->ID, 'ultimatum_video', true ) && ! $gallery ) {

					$sc = '[ult_video width="' . $imgw . '" height="' . $instance["multipleh"] . '"]' . $video . '[/ult_video]';
					echo do_shortcode( $sc );
				} else { ?>
				<a href="<?php if ( $gallery ) {
					echo $link;
				} else {
					the_permalink();
				} ?>" <?php echo $rel ?> class="preload <?php if ( $gallery ) {
					echo ' overlayed_image';
				} ?>" <?php if ( $gallery ) {
					if ( $video ) {
						echo ' data-overlay="play"';
					} else {
						echo ' data-overlay="image"';
					}
				} ?>>
					<img src="<?php echo $imgsrc; ?>" alt="<?php the_title(); ?>"/>
					</a><?php
				}
			} else { ?>
			<a href="<?php if ( $gallery ) {
				echo $link;
			} else {
				the_permalink();
			} ?>" <?php echo $rel ?> class="preload <?php if ( $gallery ) {
				echo ' overlayed_image';
			} ?>" <?php if ( $gallery ) {
				if ( $video ) {
					echo ' data-overlay="play"';
				} else {
					echo ' data-overlay="image"';
				}
			} ?>>
				<img src="<?php echo $imgsrc; ?>" alt="<?php the_title(); ?>"/>
				</a><?php
			}
			?>
			</div><?php
		}
	}

	function blog_multimeta( $instance ) {
		global $post;
		if ( $instance["mdate"] == 'true' ) {
			$mshowtime = isset( $instance['mshowtime'] ) ? $instance['mshowtime'] : '';
			if ( $mshowtime ) {
				$mtime = the_time();
			}
			$out[] = '<span class="date"><a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_date() . ' ' . $mtime . '</a></span>';
		}
		if ( $instance["mauthor"] == 'true' ) {
			$out[] = '<span class="author">' . __( 'by ', 'ultimatum' ) . '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>';
		}
		if ( $instance["mcomments"] == "true" && ( $post->comment_count > 0 || comments_open() ) ) {
			ob_start();
			comments_popup_link( __( 'No Comments', 'ultimatum' ), __( '1 Comment', 'ultimatum' ), __( '% Comments', 'ultimatum' ), '' );
			$out[] = '<span class="comments">' . ob_get_clean() . '</span>';
		}
		if ( count( $out ) != 0 ) {
			$output = '<div class="post-meta">';
			$output .= join( ' ' . $instance["mmseperator"] . ' ', $out ) . '</div>';
		}
		unset( $out );
		$tax = '';
		if ( $instance["mcats"] == 'ameta' ) {
			$_tax = get_the_taxonomies();
			if ( empty( $_tax ) ) {
			} else {
				foreach ( $_tax as $key => $value ) {
					preg_match( '/(.+?): /i', $value, $matches );
					$tax[] = '<span class="entry-tax-' . $key . '">' . str_replace( $matches[0], '<span class="entry-tax-meta">' . $matches[1] . ':</span> ', $value ) . '</span>';
				}
			}
			if ( count( $tax ) != 0 ) {
				$output .= '<div class="post-taxonomy">' . join( '<br />', $tax ) . '</div>';
			}
			unset( $_tax );
		}

		return $output;
	}


	function update( $new_instance, $old_instance ) {
		$instance['title']         = strip_tags( $new_instance['title'] );
		$instance['perpage']       = $new_instance['perpage'];
		$instance['mseperator']    = $new_instance['mseperator'];
		$instance['multiple']      = $new_instance['multiple'];
		$instance['multipleh']     = $new_instance['multipleh'];
		$instance['multiplew']     = $new_instance['multiplew'];
		$instance['mtitle']        = $new_instance['mtitle'];
		$instance['mvideo']        = $new_instance['mvideo'];
		$instance['mmeta']         = $new_instance['mmeta'];
		$instance['mdate']         = $new_instance['mdate'];
		$instance['mauthor']       = $new_instance['mauthor'];
		$instance['mimgpos']       = $new_instance['mimgpos'];
		$instance['mcomments']     = $new_instance['mcomments'];
		$instance['mcats']         = $new_instance['mcats'];
		$instance['excerpt']       = $new_instance['excerpt'];
		$instance['excerptlength'] = $new_instance['excerptlength'];
		$instance['mreadmore']     = $new_instance['mreadmore'];
		$instance['rmtext']        = $new_instance['rmtext'];
		$instance['mmargin']       = $new_instance['mmargin'];
		$instance['mmseperator']   = $new_instance['mmseperator'];
		$instance['source']        = $new_instance['source'];
		$instance['noimage']       = $new_instance['noimage'];
		$instance['mnoimage']      = $new_instance['mnoimage'];

		$instance['mshowtime'] = $new_instance['mshowtime'];

		$instance['looporder1'] = $new_instance['looporder1'];
		$instance['looporder2'] = $new_instance['looporder2'];
		$instance['skip']       = $new_instance['skip'];
		$instance['orderdir']   = $new_instance['orderdir'];

		return $instance;
	}

	function form( $instance ) {
		$source        = isset( $instance['source'] ) ? $instance['source'] : 'post';
		$excerpt       = isset( $instance['excerpt'] ) ? $instance['excerpt'] : 'true';
		$title         = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$mtitle        = isset( $instance['mtitle'] ) ? $instance['mtitle'] : 'true';
		$mimgpos       = isset( $instance['mimgpos'] ) ? $instance['mimgpos'] : 'btitle';
		$mvideo        = isset( $instance['mvideo'] ) ? $instance['mvideo'] : 'false';
		$perpage       = isset( $instance['perpage'] ) ? $instance['perpage'] : '10';
		$multiple      = isset( $instance['multiple'] ) ? $instance['multiple'] : '1coli';
		$multiplew     = isset( $instance['multiplew'] ) ? $instance['multiplew'] : '220';
		$multipleh     = isset( $instance['multipleh'] ) ? $instance['multipleh'] : '220';
		$excerptlength = isset( $instance['excerptlength'] ) ? $instance['excerptlength'] : '100';
		$mmeta         = isset( $instance['mmeta'] ) ? $instance['mmeta'] : 'aimage';
		$mmargin       = isset( $instance['mmargin'] ) ? $instance['mmargin'] : '30';
		$mdate         = isset( $instance['mdate'] ) ? $instance['mdate'] : 'true';
		$mauthor       = isset( $instance['mauthor'] ) ? $instance['mauthor'] : 'false';
		$mcomments     = isset( $instance['mcomments'] ) ? $instance['mcomments'] : 'true';
		$mcats         = isset( $instance['mcats'] ) ? $instance['mcats'] : 'false';
		$mreadmore     = isset( $instance['mreadmore'] ) ? $instance['mreadmore'] : 'right';
		$mmseperator   = isset( $instance['mmseperator'] ) ? $instance['mmseperator'] : '|';
		$rmtext        = isset( $instance['rmtext'] ) ? $instance['rmtext'] : 'Read More';
		$noimage       = isset( $instance['noimage'] ) ? $instance['noimage'] : 'true';
		$mnoimage      = isset( $instance['mnoimage'] ) ? $instance['mnoimage'] : 'true';

		$mshowtime = isset( $instance['mshowtime'] ) ? $instance['mshowtime'] : '';

		$looporder1 = isset( $instance['looporder1'] ) ? $instance['looporder1'] : '';
		$looporder2 = isset( $instance['looporder2'] ) ? $instance['looporder2'] : '';
		$orderdir   = isset( $instance['orderdir'] ) ? $instance['orderdir'] : 'DESC';
		$skip       = isset( $instance['skip'] ) ? $instance['skip'] : '';

		global $wpdb;
		$termstable = $wpdb->prefix . ULTIMATUM_PREFIX . '_tax';
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'ultimatum' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>"/>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'source' ); ?>"><?php _e( 'Select Content Source', 'ultimatum' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'source' ); ?>"
			        id="<?php echo $this->get_field_id( 'source' ); ?>">
				<optgroup label="Post Type">
					<?php
					$args       = array( 'public' => true, 'publicly_queryable' => true );
					$post_types = get_post_types( $args, 'names' );
					foreach ( $post_types as $post_type ) {
						if ( $post_type != 'attachment' ) {
							echo '<option value="ptype-' . $post_type . '" ' . selected( $source, 'ptype-' . $post_type, false ) . '>' . $post_type . '</option>';
						}
					}
					?>
				</optgroup>
				<?php
				$entries = get_categories( 'title_li=&orderby=name&hide_empty=0' );
				if ( count( $entries ) >= 1 ) {
					echo '<optgroup label="Categories(Post)">';
					foreach ( $entries as $key => $entry ) {
						echo '<option value="cat-' . $entry->term_id . '" ' . selected( $source, 'cat-' . $entry->term_id, false ) . '>' . $entry->name . '</option>';
					}
					echo '</optgroup>';
				}
				?>
				<?php

				$termsql    = "SELECT * FROM $termstable";
				$termresult = $wpdb->get_results( $termsql, ARRAY_A );
				foreach ( $termresult as $term ) {
					$properties = unserialize( $term['properties'] );
					echo '<optgroup label="' . $properties['label'] . '(' . $term['pname'] . ')">';
					$entries = get_terms( $properties['name'], 'orderby=name&hide_empty=0' );
					foreach ( $entries as $key => $entry ) {
						$optiont = 'taxonomy-' . $term['pname'] . '|' . $properties['name'] . '|' . $entry->slug;
						echo '<option value="' . $optiont . '" ' . selected( $source, $optiont, false ) . '>' . $entry->name . '</option>';
					}
					echo '</optgroup>';
				}

				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'mtitle' ); ?>"><?php _e( 'Show Article Titles', 'ultimatum' ) ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'mtitle' ); ?>"
			        id="<?php echo $this->get_field_id( 'mtitle' ); ?>">
				<option value="true" <?php selected( $mtitle, 'true' ); ?>>ON</option>
				<option value="false" <?php selected( $mtitle, 'false' ); ?>>OFF</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'perpage' ); ?>"><?php _e( 'Items Count', 'ultimatum' ) ?></label>
			<input class="widefat" type="text" value="<?php echo $perpage; ?>" name="<?php echo $this->get_field_name( 'perpage' ); ?>"
			       id="<?php echo $this->get_field_id( 'perpage' ); ?>"/>
		</p>

		<p>
			<label
				for="<?php echo $this->get_field_id( 'looporder1' ); ?>"><?php _e( 'Loop Order first', 'ultimatum' ) ?>
				</label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'looporder1' ); ?>"
			        id="<?php echo $this->get_field_id( 'looporder1' ); ?>">
				<option
					value=''            <?php selected( $looporder1, '' ); ?>><?php _e( 'None', 'ultimatum' ) ?></option>
				<option
					value='ID'              <?php selected( $looporder1, 'ID' ); ?>><?php _e( 'ID', 'ultimatum' ) ?></option>
				<option
					value='author'          <?php selected( $looporder1, 'author' ); ?>><?php _e( 'author', 'ultimatum' ) ?></option>
				<option
					value='title'           <?php selected( $looporder1, 'title' ); ?>><?php _e( 'title', 'ultimatum' ) ?></option>
				<option
					value='name'            <?php selected( $looporder1, 'name' ); ?>><?php _e( 'name', 'ultimatum' ) ?></option>
				<option
					value='date'            <?php selected( $looporder1, 'date' ); ?>><?php _e( 'date {default}', 'ultimatum' ) ?></option>
				<option
					value='modified'        <?php selected( $looporder1, 'modified' ); ?>><?php _e( 'modified', 'ultimatum' ) ?></option>
				<option
					value='parent'          <?php selected( $looporder1, 'parent' ); ?>><?php _e( 'parent', 'ultimatum' ) ?></option>
				<option
					value='rand'            <?php selected( $looporder1, 'rand' ); ?>><?php _e( 'rand', 'ultimatum' ) ?></option>
				<option
					value='comment_count'   <?php selected( $looporder1, 'comment_count' ); ?>><?php _e( 'comment_count', 'ultimatum' ) ?></option>
				<option
					value='menu_order'      <?php selected( $looporder1, 'menu_order' ); ?>><?php _e( 'menu_order', 'ultimatum' ) ?></option>
			</select>
		</p>

		<p>
			<label
				for="<?php echo $this->get_field_id( 'looporder2' ); ?>"><?php _e( 'Loop Order second', 'ultimatum' ) ?>
				</label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'looporder2' ); ?>"
			        id="<?php echo $this->get_field_id( 'looporder2' ); ?>">
				<option
					value=''            <?php selected( $looporder2, '' ); ?>><?php _e( 'None', 'ultimatum' ) ?></option>
				<option
					value='ID'              <?php selected( $looporder2, 'ID' ); ?>><?php _e( 'ID', 'ultimatum' ) ?></option>
				<option
					value='author'          <?php selected( $looporder2, 'author' ); ?>><?php _e( 'author', 'ultimatum' ) ?></option>
				<option
					value='title'           <?php selected( $looporder2, 'title' ); ?>><?php _e( 'title', 'ultimatum' ) ?></option>
				<option
					value='name'            <?php selected( $looporder2, 'name' ); ?>><?php _e( 'name', 'ultimatum' ) ?></option>
				<option
					value='date'            <?php selected( $looporder2, 'date' ); ?>><?php _e( 'date {default}', 'ultimatum' ) ?></option>
				<option
					value='modified'        <?php selected( $looporder2, 'modified' ); ?>><?php _e( 'modified', 'ultimatum' ) ?></option>
				<option
					value='parent'          <?php selected( $looporder2, 'parent' ); ?>><?php _e( 'parent', 'ultimatum' ) ?></option>
				<option
					value='rand'            <?php selected( $looporder2, 'rand' ); ?>><?php _e( 'rand', 'ultimatum' ) ?></option>
				<option
					value='comment_count'   <?php selected( $looporder2, 'comment_count' ); ?>><?php _e( 'comment_count', 'ultimatum' ) ?></option>
				<option
					value='menu_order'      <?php selected( $looporder2, 'menu_order' ); ?>><?php _e( 'menu_order', 'ultimatum' ) ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'orderdir' ); ?>"><?php _e( 'Order Direction', 'ultimatum' ) ?>
				</label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'orderdir' ); ?>"
			        id="<?php echo $this->get_field_id( 'orderdir' ); ?>">
				<option
					value='DESC'            <?php selected( $orderdir, 'DESC' ); ?>><?php _e( 'Descending', 'ultimatum' ) ?></option>
				<option
					value='ASC'             <?php selected( $orderdir, 'ASC' ); ?>><?php _e( 'Ascending', 'ultimatum' ) ?></option>

			</select>
		</p>

		<?php ultimatum_custcontent_inptext( 'skip', $skip, __('Skip first','ultimatum'), $this, '3' ); ?> Posts...

		<p>
			<label for="<?php echo $this->get_field_id( 'multiple' ); ?>"><?php _e( 'Loop Layout', 'ultimatum' ) ?>
				</label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'multiple' ); ?>"
			        id="<?php echo $this->get_field_id( 'multiple' ); ?>">
				<?php
                if (file_exists(THEME_LOOPS_DIR . '/extraloops.php')) {
                    include(THEME_LOOPS_DIR . '/extraloops.php');
                    foreach ($extraloops as $loops) {
                        ?>
                        <option
                            value="<?php echo $loops["file"]; ?>" <?php selected($multiple, $loops["file"]); ?>><?php _e($loops["name"], 'ultimatum') ?></option>
                    <?php
                    }
                }
                if(is_plugin_active( 'wonderloops/wonderloops.php' )) {
                    $theme_loops_dir = @opendir(ULTLOOPBUILDER_DIR);
                    $loop_files = array();
                    if ($theme_loops_dir) {
                        while (($file = readdir($theme_loops_dir)) !== false) {
                            if (substr($file, 0, 1) == '.') {
                                continue;
                            }
                            if (substr($file, -4) == '.php') {
                                $loop_files[] = $file;
                            }
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
                                        value="<?php echo $data["file"]; ?>" <?php selected($multiple, $data["file"]); ?>><?php _e($data["name"], 'ultimatum') ?></option>
                                <?php
                                }
                            }
                        }
                    }
                }
				?>
				<option
					value="1-col-i" <?php selected( $multiple, '1-col-i' ); ?>><?php _e( 'One Column With Full Image', 'ultimatum' ) ?></option>
				<option
					value="1-col-li" <?php selected( $multiple, '1-col-li' ); ?>><?php _e( 'One Column With Image On Left', 'ultimatum' ) ?></option>
				<option
					value="1-col-ri" <?php selected( $multiple, '1-col-ri' ); ?>><?php _e( 'One Column With Image On Right', 'ultimatum' ) ?></option>
				<option
					value="1-col-gl" <?php selected( $multiple, '1-col-gl' ); ?>><?php _e( 'One Column Gallery With Image On Left', 'ultimatum' ) ?></option>
				<option
					value="1-col-gr" <?php selected( $multiple, '1-col-gr' ); ?>><?php _e( 'One Column Gallery With Image On Right', 'ultimatum' ) ?></option>
				<option
					value="1-col-n" <?php selected( $multiple, '1-col-n' ); ?>><?php _e( 'One Column With No Image', 'ultimatum' ) ?></option>
				<option
					value="2-col-i" <?php selected( $multiple, '2-col-i' ); ?>><?php _e( 'Two Columns With Image', 'ultimatum' ) ?></option>
				<option
					value="2-col-g" <?php selected( $multiple, '2-col-g' ); ?>><?php _e( 'Two Columns Gallery', 'ultimatum' ) ?></option>
				<option
					value="2-col-n" <?php selected( $multiple, '2-col-n' ); ?>><?php _e( 'Two Columns With No Image', 'ultimatum' ) ?></option>
				<option
					value="3-col-i" <?php selected( $multiple, '3-col-i' ); ?>><?php _e( 'Three Columns With Image', 'ultimatum' ) ?></option>
				<option
					value="3-col-g" <?php selected( $multiple, '3-col-g' ); ?>><?php _e( 'Three Columns Gallery', 'ultimatum' ) ?></option>
				<option
					value="3-col-n" <?php selected( $multiple, '3-col-n' ); ?>><?php _e( 'Three Columns With No Image', 'ultimatum' ) ?></option>
				<option
					value="4-col-i" <?php selected( $multiple, '4-col-i' ); ?>><?php _e( 'Four Columns With Image', 'ultimatum' ) ?></option>
				<option
					value="4-col-g" <?php selected( $multiple, '4-col-g' ); ?>><?php _e( 'Four Columns Gallery', 'ultimatum' ) ?></option>
				<option
					value="4-col-n" <?php selected( $multiple, '4-col-n' ); ?>><?php _e( 'Four Columns With No Image', 'ultimatum' ) ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'mnoimage' ); ?>"><?php _e( 'No Image', 'ultimatum' ) ?>
				</label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'mnoimage' ); ?>"
			        id="<?php echo $this->get_field_id( 'mnoimage' ); ?>">
				<option value="true" <?php selected( $mnoimage, 'true' ); ?>>Show Placeholder</option>
				<option value="false" <?php selected( $mnoimage, 'false' ); ?>>OFF</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'mimgpos' ); ?>"><?php _e( 'Image Position', 'ultimatum' ) ?>
				</label> <i>For Full image and columns 2 or 2+</i>
			<select class="widefat" name="<?php echo $this->get_field_name( 'mimgpos' ); ?>"
			        id="<?php echo $this->get_field_id( 'mimgpos' ); ?>">
				<option
					value="atitle" <?php selected( $mimgpos, 'atitle' ); ?>><?php _e( 'After Title', 'ultimatum' ) ?></option>
				<option
					value="btitle" <?php selected( $mimgpos, 'btitle' ); ?>><?php _e( 'Before Title', 'ultimatum' ) ?></option>


			</select>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'mvideo' ); ?>"><?php _e( 'Replace Featured Image with gallery or Video', 'ultimatum' ) ?>
				</label> <i>Works for non Gallery views only</i>
			<select class="widefat" name="<?php echo $this->get_field_name( 'mvideo' ); ?>"
			        id="<?php echo $this->get_field_id( 'mvideo' ); ?>">
				<option value="true" <?php selected( $mvideo, 'true' ); ?>>ON</option>
				<option value="false" <?php selected( $mvideo, 'false' ); ?>>OFF</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'excerpt' ); ?>"><?php _e( 'Show Content As', 'ultimatum' ) ?>
				</label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'excerpt' ); ?>"
			        id="<?php echo $this->get_field_id( 'excerpt' ); ?>">
				<option value="true" <?php selected( $excerpt, 'true' ); ?>>Excerpt</option>
				<option value="content" <?php selected( $excerpt, 'content' ); ?>>Content</option>
				<option value="false" <?php selected( $excerpt, 'false' ); ?>>OFF</option>
			</select>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'excerptlength' ); ?>"><?php _e( 'Excerpt Length(chars)', 'ultimatum' ) ?>
				</label>
			<input class="widefat" type="text" value="<?php echo $excerptlength; ?>"
			       name="<?php echo $this->get_field_name( 'excerptlength' ); ?>"
			       id="<?php echo $this->get_field_id( 'excerptlength' ); ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'multiplew' ); ?>"><?php _e( 'Image Width', 'ultimatum' ) ?>
				</label>
			<input class="widefat" type="text" value="<?php echo $multiplew; ?>"
			       name="<?php echo $this->get_field_name( 'multiplew' ); ?>"
			       id="<?php echo $this->get_field_id( 'multiplew' ); ?>"/><i>Applied on Image on Left/Right Aligned
				pages</i>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'multipleh' ); ?>"><?php _e( 'Image Height', 'ultimatum' ) ?>
				</label>
			<input class="widefat" type="text" value="<?php echo $multipleh; ?>"
			       name="<?php echo $this->get_field_name( 'multipleh' ); ?>"
			       id="<?php echo $this->get_field_id( 'multipleh' ); ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'mcats' ); ?>"><?php _e( 'Taxonomy', 'ultimatum' ) ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'mcats' ); ?>"
			        id="<?php echo $this->get_field_id( 'mcats' ); ?>">
				<option
					value="ameta" <?php selected( $mcats, 'ameta' ); ?>><?php _e( 'After Meta', 'ultimatum' ) ?></option>
				<option
					value="acontent" <?php selected( $mcats, 'acontent' ); ?>><?php _e( 'After Content', 'ultimatum' ) ?></option>
				<option value="false" <?php selected( $mcats, 'false' ); ?>>OFF</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'mmeta' ); ?>"><?php _e( 'Meta', 'ultimatum' ) ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'mmeta' ); ?>"
			        id="<?php echo $this->get_field_id( 'mmeta' ); ?>">
				<option
					value="atitle" <?php selected( $mmeta, 'atitle' ); ?>><?php _e( 'After Title', 'ultimatum' ) ?></option>
				<option
					value="aimage" <?php selected( $mmeta, 'aimage' ); ?>><?php _e( 'After Image', 'ultimatum' ) ?></option>
				<option
					value="atext" <?php selected( $mmeta, 'atext' ); ?>><?php _e( 'After Content', 'ultimatum' ) ?></option>
				<option value="false" <?php selected( $mmeta, 'false' ); ?>>OFF</option>
			</select>
		</p>
		<fieldset>
			<legend>Post Meta Properties</legend>
			<p>
				<label
					for="<?php echo $this->get_field_id( 'mmseperator' ); ?>"><?php _e( 'Meta Seperator', 'ultimatum' ) ?>
					</label>
				<input name="<?php echo $this->get_field_name( 'mmseperator' ); ?>"
				       id="<?php echo $this->get_field_id( 'mmseperator' ); ?>" value="<?php echo $mmseperator; ?>"/>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'mdate' ); ?>"><?php _e( 'Date', 'ultimatum' ) ?></label>
				<select name="<?php echo $this->get_field_name( 'mdate' ); ?>"
				        id="<?php echo $this->get_field_id( 'mdate' ); ?>">
					<option value="true" <?php selected( $mdate, 'true' ); ?>>ON</option>
					<option value="false" <?php selected( $mdate, 'false' ); ?>>OFF</option>
				</select>
				<?php ultimatum_custcontent_inpcheckbox( 'mshowtime', $mshowtime, 'Show time', $this ); ?>
				<label for="<?php echo $this->get_field_id( 'mauthor' ); ?>"><?php _e( 'Author', 'ultimatum' ) ?>
					</label>
				<select name="<?php echo $this->get_field_name( 'mauthor' ); ?>"
				        id="<?php echo $this->get_field_id( 'mauthor' ); ?>">
					<option value="true" <?php selected( $mauthor, 'true' ); ?>>ON</option>
					<option value="false" <?php selected( $mauthor, 'false' ); ?>>OFF</option>
				</select>

				<label for="<?php echo $this->get_field_id( 'mcomments' ); ?>"><?php _e( 'Comments', 'ultimatum' ) ?>
					</label>
				<select name="<?php echo $this->get_field_name( 'mcomments' ); ?>"
				        id="<?php echo $this->get_field_id( 'mcomments' ); ?>">
					<option value="true" <?php selected( $mcomments, 'true' ); ?>>ON</option>
					<option value="false" <?php selected( $mcomments, 'false' ); ?>>OFF</option>
				</select>
			</p>
		</fieldset>
		<p>
			<label for="<?php echo $this->get_field_id( 'mreadmore' ); ?>"><?php _e( 'Read More Link', 'ultimatum' ) ?>
				</label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'mreadmore' ); ?>"
			        id="<?php echo $this->get_field_id( 'mreadmore' ); ?>">
				<option
					value="right" <?php selected( $mreadmore, 'right' ); ?>><?php _e( 'Right Aligned', 'ultimatum' ) ?></option>
				<option
					value="left" <?php selected( $mreadmore, 'left' ); ?>><?php _e( 'Left Aligned', 'ultimatum' ) ?></option>
				<option value="false" <?php selected( $mreadmore, 'false' ); ?>>OFF</option>
			</select>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'rmtext' ); ?>"><?php _e( 'Read More Text', 'ultimatum' ) ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name( 'rmtext' ); ?>"
			        id="<?php echo $this->get_field_id( 'rmtext' ); ?>">
				<option
					value="Read More" <?php selected( $rmtext, 'Read More' ); ?>><?php _e( 'Read More', 'ultimatum' ) ?></option>
				<option value="More" <?php selected( $rmtext, 'More' ); ?>><?php _e( 'More', 'ultimatum' ) ?></option>
				<option
					value="Continue Reading" <?php selected( $rmtext, 'Continue Reading' ); ?>><?php _e( 'Continue Reading', 'ultimatum' ) ?></option>
				<option
					value="Continue" <?php selected( $rmtext, 'Continue' ); ?>><?php _e( 'Continue', 'ultimatum' ) ?></option>
				<option
					value="Details" <?php selected( $rmtext, 'Details' ); ?>><?php _e( 'Details', 'ultimatum' ) ?></option>

			</select>
		</p>

	<?php
	}

}

add_action( 'widgets_init', create_function( '', 'return register_widget("UltimatumCustomContent");' ) );

function ultimatum_custcontent_inpcheckbox( $fieldid, &$currval, $title, &$that ) {
// ech( $fieldid, $currval);
	?>

	<label for="<?php echo $that->get_field_id( $fieldid ); ?>"><?php echo  $title ; ?></label>
	<input id="<?php echo $that->get_field_id( $fieldid ); ?>" name="<?php echo $that->get_field_name( $fieldid ); ?>"
	       type="checkbox" value="1"  <?php checked( $currval, 1, true ); ?> />

<?php
} // end ultimatum_inpcheckbox

function ultimatum_custcontent_inptext( $fieldid, &$currval, $title, &$that, $size = '' ) {

	$format = '';

	if ( $size !== '' ) {
		$format = ' size="' . $size . '" ';
	}

	?>

	<label for="<?php echo $that->get_field_id( $fieldid ); ?>"><?php echo $title ?>:</label>
	<input type="text" name="<?php echo $that->get_field_name( $fieldid ); ?>"
	       id="<?php echo $that->get_field_id( $fieldid ); ?>" value="<?php echo $currval; ?>" <?php echo $format; ?> />


<?php

}

