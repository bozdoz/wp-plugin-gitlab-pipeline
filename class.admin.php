<?php
/**
 * Used to generate an admin page
 */

namespace TriggerPipeline;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit();
}

/**
 * Trigger_Pipeline_Admin class
 */
class Admin
{
    /**
     * Singleton Instance
     */
    private static $_instance = null;

    /**
     * Singleton
     */
    public static function init()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Instantiate the class
     */
    private function __construct()
    {
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'admin_menu'));

        /* add settings to plugin page */
        add_filter(
            'plugin_action_links_' .
                plugin_basename(TRIGGER_PIPELINE__PLUGIN_FILE),
            array($this, 'plugin_action_links')
        );
    }

    /**
     * Admin init registers styles
     */
    public function admin_init()
    {
        wp_register_style(
            'trigger_pipeline_admin_stylesheet',
            plugins_url('assets/style.css', TRIGGER_PIPELINE__PLUGIN_FILE)
        );
    }

    /**
     * Add admin menu page when user in admin area
     */
    public function admin_menu()
    {
        add_options_page(
            "Trigger Pipeline",
            "Trigger Pipeline",
            'manage_options',
            'trigger-pipeline',
            array($this, "settings_page")
        );
    }

    /**
     * Main settings page includes form inputs
     */
    public function settings_page()
    {
        wp_enqueue_style('trigger_pipeline_admin_stylesheet');

        $settings = Settings::init();
        $plugin_data = get_plugin_data(TRIGGER_PIPELINE__PLUGIN_FILE);
        include 'templates/settings.php';
    }

    /**
     * Add settings link to the plugin on Installed Plugins page
     *
     * @return array
     */
    public function plugin_action_links($links)
    {
        $links[] =
            '<a href="' .
            esc_url(get_admin_url(null, 'admin.php?page=trigger-pipeline')) .
            '">Settings</a>';
        return $links;
    }
}
