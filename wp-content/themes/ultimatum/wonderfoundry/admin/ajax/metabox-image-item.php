<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
this file under any circumstances.
*/

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @category Ultimatum
 * @package  Templates
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.38
 */
 ?>
<li id="image-<?php echo $image->ID;?>" class="imageItemWrap">
<div class="sortItem">
	<table width="100%" cellspacing="0" cellpadding="3">
		<tr>
			<td class="handle" width="10"><div><i class="fa fa-sort"></i></div></td>
			<td width="70">
				<a title="<?php echo $image->post_title;?>" class="thickbox" href="<?php echo $image->guid;?>?" style="display:block;">
					<?php echo wp_get_attachment_image($image->ID,array(60,60));?>
				</a>
			</td>
			<td>
				<strong><a title="<?php echo $image->post_title;?>" class="thickbox" href="<?php echo $image->guid;?>?"><?php echo $image->post_title;?></a></strong>
				<br />
				<?php echo $date;?>
				<br />
				<?php echo $size;?>
			</td>
			<td>
				<?php echo mb_substr($image->post_content,0,50,get_option('blog_charset'));?>
			</td>
			<td width="90" align="center">
				<div class="button-secondary edit-item" style="margin-bottom: 2px;">Edit</div>
				<div class="button-secondary delete-item">Delete</div>
			</td>

		</tr>
	</table>
</div>
</li>