<?php
/**
 * Main class
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit();
}

class Trigger_Pipeline
{
    /**
     * Singleton Instance
     **/
    private static $instance = null;

    /**
     * Singleton Init
     */
    public static function init()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->init_hooks();
    }

    /**
     * Add actions and filters
     */
    private function init_hooks()
    {
        include_once TRIGGER_PIPELINE__PLUGIN_DIR . 'class.settings.php';
        include_once TRIGGER_PIPELINE__PLUGIN_DIR . 'class.admin.php';

        // init admin
        \TriggerPipeline\Admin::init();

        $settings = \TriggerPipeline\Settings::init();

        if ($settings->get('trigger_on_save')) {
            add_action('save_post', array($this, 'save_post'));
        }
    }

    public function save_post($post_id)
    {
        include_once TRIGGER_PIPELINE__PLUGIN_DIR . 'class.settings.php';
        $settings = \TriggerPipeline\Settings::init();
        $url = $settings->get('endpoint');
        $token = $settings->get('token');
        $ref = $settings->get('ref');

        if (
            !$url ||
            !$token ||
            !$ref ||
            wp_is_post_revision($post_id) ||
            wp_is_post_autosave($post_id)
        ):
            return;
        endif;

        // Send email to admin.
        wp_mail('admin@example.com', 'deploy', 'deploying to gitlab');

        $fields = array(
            'token' => $token,
            'ref' => $ref
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, get_site_url());
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $data = curl_exec($ch);
        curl_close($ch);
    }

    /**
     * Triggered when user uninstalls/removes plugin
     */
    public static function uninstall()
    {
        // remove settings in db
        // it needs to be included again because __construct
        // won't need to execute
        include_once TRIGGER_PIPELINE__PLUGIN_DIR . 'class.settings.php';
        $settings = \TriggerPipeline\Settings::init();
        $settings->reset();
    }
}
