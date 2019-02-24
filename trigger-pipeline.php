<?php

/**
 * Plugin Name: Trigger Pipeline
 * Plugin URI: https://wordpress.org/plugins/trigger-pipeline/
 * Description: A plugin to trigger a GitLab pipeline after a post or page is updated or created.
 * Author: bozdoz
 * Author URI: https://twitter.com/bozdoz/
 * Text Domain: trigger-pipeline
 * Version: 0.1.0
 * License: GPL2
 * Trigger Pipeline is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Trigger Pipeline is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Trigger Pipeline. If not, see  https://github.com/bozdoz/wp-plugin-trigger-pipeline/blob/master/LICENSE.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit();
}

define('TRIGGER_PIPELINE__PLUGIN_VERSION', '0.1.0');
define('TRIGGER_PIPELINE__PLUGIN_FILE', __FILE__);
define('TRIGGER_PIPELINE__PLUGIN_DIR', plugin_dir_path(__FILE__));

// import main class
require_once TRIGGER_PIPELINE__PLUGIN_DIR . 'class.trigger-pipeline.php';

// uninstall hook
register_uninstall_hook(__FILE__, array('Trigger_Pipeline', 'uninstall'));

add_action('init', array('Trigger_Pipeline', 'init'));
