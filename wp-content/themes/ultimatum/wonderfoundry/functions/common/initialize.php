<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
 */

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @package  Ultimatum
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @link     http://ultimatumtheme.com
 * @version  2.8
 */

$check = getAllTemplates();
if(!$check) {
    $option = THEME_SLUG . '_layouts_installed';
    if (!get_option($option)) {
        require_once(ULTIMATUM_ADMIN_FUNCTIONS . '/template_import.php');
        $folder = THEME_DIR . DS . 'ultinstall';
        if (is_dir($folder)) {
            $files = WonderWorksHelper::getUTX($folder);
            if ($files) {
                foreach ($files as $file) {
                    importTemplate($folder . DS . $file, $folder, false, true);
                }
            }
            if (file_exists($folder . '/' . THEME_SLUG . '.fonts')) {
                $raw_content = file_get_contents($folder . '/' . THEME_SLUG . '.fonts');
                add_option(THEME_SLUG . '_fonts', $raw_content, false);
            }
            add_option($option, 'DONE', false);
        }
    }
}