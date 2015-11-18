<?php

// Bootstrap file for getting the ABSPATH constant to wp-load.php
require_once('config.php');

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') ) 
	wp_die(__("You are not allowed to be here", 'ultimatum'));
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo THEME_NAME.' Shortcode Generator'; ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/wonderfoundry/addons/plugins/tinymce/tinymce.js"></script>
	<link rel="stylesheet" href="<?php echo ULTIMATUM_ADMIN_ASSETS; ?>/css/colorpicker.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo ULTIMATUM_ADMIN_ASSETS; ?>/css/mce.css" type="text/css" />
	<script type='text/javascript' src='<?php bloginfo('wpurl');?>/wp-includes/js/jquery/jquery.js'></script>
<?php 
global $wp_version;
if($wp_version>3.2){ ?> 
<script type='text/javascript' src='<?php bloginfo('wpurl');?>/wp-includes/js/jquery/ui/jquery.ui.core.min.js?ver=1.8.12'></script>
<script type='text/javascript' src='<?php bloginfo('wpurl');?>/wp-includes/js/jquery/ui/jquery.ui.widget.min.js?ver=1.8.12'></script>
<script type='text/javascript' src='<?php bloginfo('wpurl');?>/wp-includes/js/jquery/ui/jquery.ui.mouse.min.js?ver=1.8.12'></script>
<script type='text/javascript' src='<?php bloginfo('wpurl');?>/wp-includes/js/jquery/ui/jquery.ui.selectable.min.js?ver=1.8.12'></script>
<?php } else { ?>
<script type='text/javascript' src='<?php bloginfo('wpurl');?>/wp-includes/js/jquery/ui.core.js?ver=1.8.12'></script>
<script type='text/javascript' src='<?php bloginfo('wpurl');?>/wp-includes/js/jquery/ui.widget.js?ver=1.8.12'></script>
<script type='text/javascript' src='<?php bloginfo('wpurl');?>/wp-includes/js/jquery/ui.mouse.js?ver=1.8.12'></script>
<script type='text/javascript' src='<?php bloginfo('wpurl');?>/wp-includes/js/jquery/ui.selectable.js?ver=1.8.12'></script>
<?php } ?>
	<script type="text/javascript" src="<?php echo ULTIMATUM_ADMIN_URL; ?>/js/colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo ULTIMATUM_ADMIN_URL; ?>/js/eye.js"></script>
    <script type="text/javascript" src="<?php echo ULTIMATUM_ADMIN_URL; ?>/js/utils.js"></script>
    <script type="text/javascript" src="<?php echo ULTIMATUM_ADMIN_URL; ?>/js/layoutmce.js"></script>
    <script type="text/javascript" src="<?php echo ULTIMATUM_ADMIN_URL; ?>/js/jquery.table.addrow.js"></script>
	<base target="_self" />
</head>
<body>
<?php 
include ('funcs.php');
$uri = ULTIMATUM_URL.'/wonderfoundry/addons/plugins/tinymce/codeinsert.php';
//$icons = array('32Bit', '64bit', 'add', 'addressbook', 'addressbook_user', 'apple-script', 'applications', 'arrow_down', 'arrow_left', 'arrow_right', 'arrow_up', 'attention-blue', 'attention-green', 'attention-orange', 'attention-red', 'audio_notification', 'badge_3g', 'badge_edge', 'badge_gprs', 'badge_umts', 'badge_wifi', 'battery_10percent', 'battery_20percent', 'battery_40percent', 'battery_60percent', 'battery_80percent', 'battery_charging', 'battery_empty', 'battery_full', 'battery_horizontal_10percent', 'battery_horizontal_20percent', 'battery_horizontal_40percent', 'battery_horizontal_60percent', 'battery_horizontal_80percent', 'battery_horizontal_charging', 'battery_horizontal_empty', 'battery_horizontal_full', 'battery_horizontal_plugged_in', 'battery_pluged_in', 'beer', 'bible', 'bomb', 'box_address', 'box_download', 'box_fragile', 'box_rar', 'box_zip', 'brainstorming', 'brainstorming_alternative', 'browser', 'burning', 'button_blue_add', 'button_blue_close', 'button_blue_delete', 'button_blue_fastforward', 'button_blue_heart', 'button_blue_pause', 'button_blue_play', 'button_blue_record', 'button_blue_rewind', 'button_blue_stop', 'button_green_add', 'button_green_close', 'button_green_delete', 'button_green_fastforward', 'button_green_heart', 'button_green_pause', 'button_green_play', 'button_green_record', 'button_green_rewind', 'button_green_stop', 'button_grey_add', 'button_grey_close', 'button_grey_delete', 'button_grey_fastforward', 'button_grey_heart', 'button_grey_pause', 'button_grey_play', 'button_grey_record', 'button_grey_rewind', 'button_grey_stop', 'button_pink_add', 'button_pink_close', 'button_pink_delete', 'button_pink_fastforward', 'button_pink_heart', 'button_pink_pause', 'button_pink_play', 'button_pink_record', 'button_pink_rewind', 'button_pink_stop', 'button_red_add', 'button_red_close', 'button_red_delete', 'button_red_fastforward', 'button_red_heart', 'button_red_pause', 'button_red_play', 'button_red_record', 'button_red_rewind', 'button_red_stop', 'button_violet_add', 'button_violet_close', 'button_violet_delete', 'button_violet_fastforward', 'button_violet_heart', 'button_violet_pause', 'button_violet_play', 'button_violet_record', 'button_violet_rewind', 'button_violet_stop', 'cake', 'calculator', 'case', 'cd', 'cd_burning', 'cd_burning_spectrum', 'cd_spectrum', 'chart', 'chart_pie', 'check', 'chrome', 'cialis', 'cialis_professional', 'clipboard', 'clipboard_add', 'clipboard_alert', 'clipboard_check', 'clipboard_cut', 'clipboard_delete', 'clipboard_download', 'clipboard_full', 'clock', 'cloud', 'cloud_add', 'cloud_alert', 'cloud_back', 'cloud_backup', 'cloud_check', 'cloud_delete', 'cloud_download', 'cloud_exchange', 'cloud_forward', 'cloud_upload', 'coffee_to_go', 'color_wheel', 'comments', 'comments_add', 'comments_alert', 'comments_check', 'comments_count', 'comments_delete', 'comments_reply', 'comments_report', 'copy-document', 'creative_suite_acrobat', 'creative_suite_after_effects', 'creative_suite_bridge', 'creative_suite_dreamweaver', 'creative_suite_fireworks', 'creative_suite_flash', 'creative_suite_illustrator', 'creative_suite_indesign', 'creative_suite_photoshop', 'creative_suite_premiere', 'creative_suite_sound_booth', 'credit-card_gold_amex', 'credit-card_gold_diners_club', 'credit-card_gold_master_card', 'credit-card_gold_paypal', 'credit-card_gold_visa', 'credit-card_platinum_amex', 'credit-card_platinum_diners_club', 'credit-card_platinum_master_card', 'credit-card_platinum_paypal', 'credit-card_platinum_via', 'cross', 'curriculum_vitae', 'cutting_pad', 'database', 'database_add', 'database_alert', 'database_check', 'database_delete', 'database_download', 'desktop_addictedtocoffee', 'desktop_aqua', 'desktop_aurora_leopard', 'desktop_aurora_snow_leopard', 'desktop_blazeoflight', 'desktop_into_the_sun', 'desktop_lensflare', 'desktop_wallpapers_aqua', 'desktop_wallpapers_aurora', 'digital_camera', 'document-lined-pen', 'document-plaid-pen', 'document_blank', 'document_pen', 'emote_biggrin', 'emote_love', 'emote_nerd', 'emote_nerd_penholder', 'emote_sad', 'emote_smile', 'emote_wink', 'emote_woohoooo', 'entry_add', 'entry_alert', 'entry_delete', 'entry_preview', 'entry_save', 'entry_saved', 'file_aac', 'file_ai', 'file_avi', 'file_bin', 'file_bmp', 'file_cue', 'file_divx', 'file_doc', 'file_eps', 'file_flac', 'file_flv', 'file_gif', 'file_html', 'file_ical', 'file_indd', 'file_inx', 'file_iso', 'file_jpg', 'file_mov', 'file_mp3', 'file_mpg', 'file_pdf', 'file_php', 'file_png', 'file_pps', 'file_ppt', 'file_psd', 'file_qxd', 'file_qxp', 'file_raw', 'file_rtf', 'file_svg', 'file_tif', 'file_txt', 'file_vcf', 'file_wav', 'file_wma', 'file_xls', 'file_xml', 'firefox', 'flag_andorra', 'flag_argentina', 'flag_australia', 'flag_austria', 'flag_belgium', 'flag_botswana', 'flag_brasil', 'flag_bulgaria', 'flag_cameroon', 'flag_canada', 'flag_central_african_republic', 'flag_chile', 'flag_china', 'flag_colombia', 'flag_croatia', 'flag_czech_republic', 'flag_denmark', 'flag_dominican_republic', 'flag_ecuador', 'flag_egypt', 'flag_el_salvador', 'flag_equatorial_guinea', 'flag_estonia', 'flag_european_union', 'flag_france', 'flag_gay_pride', 'flag_germany', 'flag_greece', 'flag_guatemala', 'flag_guinea-bissau', 'flag_guinea', 'flag_honduras', 'flag_hong_kong', 'flag_hungary', 'flag_india', 'flag_indonesia', 'flag_ireland', 'flag_israel', 'flag_italy', 'flag_ivory_coast', 'flag_jamaica', 'flag_japan', 'flag_jordan', 'flag_kenya', 'flag_korea', 'flag_latvia', 'flag_liechtenstein', 'flag_lithuania', 'flag_luxembourg', 'flag_macau', 'flag_macedonia', 'flag_madagascar', 'flag_malaysia', 'flag_mali', 'flag_malta', 'flag_mauritius', 'flag_mexico', 'flag_moldova', 'flag_monaco', 'flag_montenegro', 'flag_netherlands', 'flag_new_zealand', 'flag_nicaragua', 'flag_niger', 'flag_norway', 'flag_panama', 'flag_paraguay', 'flag_peru', 'flag_phillippines', 'flag_poland', 'flag_portugal', 'flag_puerto_rico', 'flag_qatar', 'flag_romania', 'flag_russia', 'flag_saudi_arabia', 'flag_senegal', 'flag_singapore', 'flag_slovakia', 'flag_south_africa', 'flag_spain', 'flag_suomi', 'flag_sweden', 'flag_switzerland', 'flag_taiwan', 'flag_thailand', 'flag_turkey', 'flag_united_arab_emirates', 'flag_united_kingdom', 'flag_uruguay', 'flag_usa', 'flag_vatican', 'flag_venezuela', 'flag_vietnam', 'flickr', 'floppy-disk', 'floppy-disk_dos', 'folder_blue', 'folder_blue_backup', 'folder_blue_conversations', 'folder_blue_favorites', 'folder_blue_ideas', 'folder_blue_mails', 'folder_blue_music', 'folder_blue_stuffed', 'folder_blue_todos', 'folder_green', 'folder_green_backup', 'folder_green_conversations', 'folder_green_favorites', 'folder_green_ideas', 'folder_green_mails', 'folder_green_music', 'folder_green_stuffed', 'folder_green_todos', 'folder_pink', 'folder_pink_backup', 'folder_pink_conversations', 'folder_pink_favorites', 'folder_pink_ideas', 'folder_pink_mails', 'folder_pink_music', 'folder_pink_stuffed', 'folder_pink_todos', 'folder_red', 'folder_red_backup', 'folder_red_conversations', 'folder_red_favorites', 'folder_red_ideas', 'folder_red_mails', 'folder_red_music', 'folder_red_stuffed', 'folder_red_todos', 'folder_remote_backup_blue', 'folder_remote_backup_green', 'folder_remote_backup_pink', 'folder_remote_backup_red', 'folder_remote_backup_violet', 'folder_remote_blue', 'folder_remote_green', 'folder_remote_pink', 'folder_remote_red', 'folder_remote_violet', 'folder_violet', 'folder_violet_backup', 'folder_violet_conversations', 'folder_violet_favorites', 'folder_violet_ideas', 'folder_violet_mails', 'folder_violet_music', 'folder_violet_stuffed', 'folder_violet_todos', 'fullscreen', 'game_controller', 'gift', 'gmail', 'google', 'harddrive', 'heart_empty', 'heart_full', 'heart_half', 'ical', 'iconfinder', 'internet_explorer', 'invoice', 'iphone', 'ipod_nano_blue', 'ipod_nano_green', 'ipod_nano_orange', 'ipod_nano_pink', 'ipod_nano_red', 'ipod_nano_silver', 'ipod_nano_violet', 'jewel_case', 'jewel_case_international-pony', 'jewel_case_keane-under_the_iron_sea', 'jewel_case_linkin-park_reanimation', 'jewel_case_ministryofsound_annual2009', 'jewel_case_spectral', 'key', 'key_0', 'key_1', 'key_2', 'key_3', 'key_4', 'key_5', 'key_6', 'key_7', 'key_8', 'key_9', 'key_A-ê', 'key_A', 'key_alt', 'key_alt_alternative', 'key_ampersand', 'key_apple', 'key_AT', 'key_B', 'key_bracket', 'key_bracket_close', 'key_C', 'key_check', 'key_cmd', 'key_cmd_alternative', 'key_colon', 'key_comma', 'key_ctrl', 'key_ctrl_alternative', 'key_curly_bracket', 'key_curly_bracket_close', 'key_D', 'key_dash', 'key_dollar', 'key_down', 'key_E', 'key_eject', 'key_equal', 'key_escape', 'key_euro', 'key_exclamation', 'key_F', 'key_f1', 'key_f10', 'key_f11', 'key_f12', 'key_f13', 'key_f14', 'key_f15', 'key_f2', 'key_f3', 'key_f4', 'key_f5', 'key_f6', 'key_f7', 'key_f8', 'key_f9', 'key_fast_forward', 'key_fw_slash', 'key_G', 'key_H', 'key_hash', 'key_heart', 'key_I', 'key_J', 'key_K', 'key_L', 'key_left', 'key_M', 'key_minus', 'key_N', 'key_note', 'key_note_double', 'key_O-ê', 'key_O', 'key_P', 'key_paragraph', 'key_percent', 'key_period', 'key_play_pause', 'key_plus', 'key_Q', 'key_question', 'key_R', 'key_record', 'key_return', 'key_rewind', 'key_right', 'key_S', 'key_semicolon', 'key_shift', 'key_slash', 'key_square_bracket', 'key_square_bracket_close', 'key_star', 'key_stop', 'key_T', 'key_tag', 'key_tag_close', 'key_to_infinity_and_beyond', 'key_U-ê', 'key_U', 'key_underscore', 'key_up', 'key_V', 'key_W', 'key_X', 'key_Y', 'key_Z', 'knife', 'knife_bloody', 'last-fm', 'lock_closed', 'lock_open', 'magic_mouse', 'magic_wand', 'mail_add', 'mail_alert', 'mail_check', 'mail_delete', 'mail_download', 'mail_forward', 'mail_plain', 'mail_reply', 'mighty_mouse', 'moleskine_black', 'moleskine_red', 'money_1', 'money_10', 'money_100', 'money_100_coins', 'money_10_coins', 'money_1_coins', 'money_20', 'money_20_coins', 'money_5', 'money_50', 'money_50_coins', 'money_5_coins', 'monitor', 'opera', 'pen', 'pencil', 'podcast', 'preferences', 'presentation', 'printer', 'rss', 'rss_alternative', 'rss_circle', 'rss_circle_comments', 'rss_comments', 'rss_square', 'rss_square_comments', 'safari', 'screen_addicted-to-coffee', 'screen_addicted-to-coffee_glossy', 'screen_aqua', 'screen_aqua_glossy', 'screen_aurora_leopard', 'screen_aurora_leopard_glossy', 'screen_aurora_snowleopard', 'screen_aurora_snowleopard_glossy', 'screen_blaze-of-light', 'screen_blaze-of-light_glossy', 'screen_lensflare', 'screen_lensflare_glossy', 'screen_rulers', 'screen_rulers_glossy', 'screen_sleep', 'screen_sleep_glossy', 'screen_tron-legacy', 'screen_tron-legacy_glossy', 'screen_twitter', 'screen_twitter_glossy', 'screen_windows', 'screen_windows_glossy', 'search', 'security', 'shopping_basket', 'show_reel', 'sign_available', 'sign_available_red', 'sign_busy', 'sign_busy_red', 'sign_free', 'sign_free_red', 'sign_hire_me', 'sign_hire_me_red', 'sign_we-are-hiring', 'sign_we-are-hiring_red', 'smashing-mag', 'social_aim', 'social_amazon', 'social_apple', 'social_appstore', 'social_behance', 'social_blogger', 'social_brightkite', 'social_brightkite_flag', 'social_delicious', 'social_designfloat', 'social_designmoo', 'social_deviantart', 'social_digg', 'social_digg_guy', 'social_dopplr', 'social_dribbble', 'social_ebay', 'social_ebay_colored', 'social_evernote', 'social_facebook', 'social_flickr', 'social_foursquare', 'social_friendfeed', 'social_google', 'social_google_buzz', 'social_google_talk', 'social_gowalla', 'social_last_fm', 'social_linked_in', 'social_meinvz', 'social_mixxt', 'social_mobileme', 'social_mynameisE', 'social_myspace', 'social_netvibes', 'social_ning', 'social_paypal', 'social_posterous', 'social_qik', 'social_reddit', 'social_schuelervz', 'social_sevenload', 'social_skype', 'social_studivz', 'social_stumble_upon', 'social_technorati', 'social_todo', 'social_tumblr', 'social_twitter', 'social_twitter_bird', 'social_twitter_retweet', 'social_vimeo', 'social_vimeo_V', 'social_xing', 'social_yahoo_messenger', 'social_yahoo_messenger_smiley', 'social_you_tube', 'social_zootool', 'speech_bubble_blue', 'speech_bubble_green', 'speech_bubble_grey', 'speech_bubble_pink', 'speech_bubble_red', 'speech_bubble_violet', 'speed_kmh', 'speed_mph', 'splash_beta_blue', 'splash_beta_brown', 'splash_beta_green', 'splash_beta_lightblue', 'splash_beta_lightgreen', 'splash_beta_orange', 'splash_beta_pink', 'splash_beta_rose', 'splash_beta_violet', 'splash_blue', 'splash_brown', 'splash_green1', 'splash_green2', 'splash_lightblue', 'splash_new_blue', 'splash_new_brown', 'splash_new_green1', 'splash_new_green2', 'splash_new_lightblue', 'splash_new_orange', 'splash_new_pink', 'splash_new_rose', 'splash_new_violet', 'splash_orange', 'splash_pink', 'splash_rose', 'splash_violet', 'star', 'star_empty', 'star_half', 'super_mario_coin', 'super_mario_mushroom', 'super_mario_mushroom_one_up', 'super_mario_piranha_plant', 'super_mario_question_box', 'super_mario_rocket', 'sync', 'tablet', 'tag', 'tag_barcode', 'tag_white', 'tag_white_barcode', 'terminal', 'to-do-list', 'to-do-list_checked1', 'to-do-list_checked2', 'to-do-list_checked3', 'trash_empty', 'trash_full', 'twitter', 'twitter_standing', 'universal_binary', 'usb-stick', 'user', 'user_add', 'user_alert', 'user_check', 'user_count', 'user_delete', 'user_download', 'user_group', 'user_group_add', 'user_group_alert', 'user_group_check', 'user_group_count', 'user_group_delete', 'user_group_download', 'vcard', 'vcard_add', 'vcard_check', 'vcard_delete', 'vcard_download', 'vcard_forward', 'viagra', 'viagra_female', 'viagra_professional', 'wacom_intuos4', 'wallet', 'wallet_bills', 'wallet_coins', 'wallet_louis_vuitton', 'wallet_louis_vuitton_bills', 'wallet_louis_vuitton_coins', 'wallet_louis_vuitton_money', 'wallet_money', 'web_blue', 'web_violet', 'window_osx', 'zoom_in', 'zoom_original', 'zoom_out');
$folder = ULTIMATUM_LIBRARY_DIR.'/images/icons/48/';
$folderi = ULTIMATUM_LIBRARY_DIR.'/images/icons/';
if (is_dir($folder) && $handle = opendir($folder)) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != ".." && preg_match('/.png/i', $entry)) {
			if(file_exists($folderi.'32/'.$entry) && file_exists($folderi.'24/'.$entry) && file_exists($folderi.'16/'.$entry)){
				$icons[]=str_replace('.png', '', $entry);
			}
		}
	}
	closedir($handle);
}
$task=false;
if(isset($_GET["task"])) $task=$_GET["task"];
switch ($task){
	default:
		codeGeneratorHome();
	break;
	case 'boxes':
		codeGeneratorBoxes($icons);
	break;
	case 'button':
		codeGeneratorButton($icons);
	break;
	case 'mcols':
		codeGeneratorCols();
	break;
	case 'typo':
		codeGeneratorTypo($uri);
	break;
	case 'list':
		 codeGeneratorList($icons);
	break;
	case 'dcap':
		 codeGeneratorDropCap();
	break;
	case 'icontext':
		 codeGeneratorIcontext($icons);
	break;
	case 'quote':
		 codeGeneratorQuote();
	break;
	case 'forms':
		 codeGeneratorForm();
	break;
	case 'gmap':
		 codeGeneratorMap();
	break;
	case 'content':
		 codeGeneratorContent();
	break;
	case 'tabsh':
		 codeGeneratorTabsh($uri);
	break;
	case 'tabs':
		 codeGeneratorTabs();
	break;
	case 'acc':
		 codeGeneratorAccord();
	break;
	case 'toggle':
		 codeGeneratorToggle();
	break;
	case 'video':
		 codeGeneratorVideo();
	break;
	case 'chart':
		 codeGeneratorChart();
	break;
}
?>

</body>
</html>
<?php 

?>