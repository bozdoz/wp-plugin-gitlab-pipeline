<?php
/**
 * Used to get and set values
 *
 * Features:
 * * Add prefixes to db options
 * * built-in admin settings page method
 */

namespace TriggerPipeline;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit();
}

require_once TRIGGER_PIPELINE__PLUGIN_DIR . 'class.option.php';

class Settings
{
    /**
     * Prefix for options, for unique db entries
     */
    public $prefix = 'trigger_pipeline_';

    /**
     * Singleton instance
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
     * Default values and admin form information
     * Needs to be created within __construct
     * in order to use a function such as __()
     *
     * @var array $options
     */
    public $options = array();

    private function __construct()
    {
        $this->options = array(
            'endpoint' => array(
                'display_name' => __('Endpoint', 'trigger-pipeline'),
                'default' => '',
                'type' => 'text',
                'helptext' =>
                    'Where to make the POST request.  Looks like this: https://gitlab.com/api/v4/projects/1234567/trigger/pipeline'
            ),
            'token' => array(
                'display_name' => __('Token', 'trigger-pipeline'),
                'default' => '',
                'type' => 'text',
                'helptext' =>
                    'Token given in the CI/CD page.  Looks like this: bdff06466ded19aae3757611a7b643'
            ),
            'ref' => array(
                'display_name' => __('Ref Name', 'trigger-pipeline'),
                'default' => 'master',
                'type' => 'text',
                'helptext' => 'This can be a branch name or tag name.'
            ),
            'trigger_on_save' => array(
                'display_name' => __('Trigger On Save', 'trigger-pipeline'),
                'default' => '0',
                'type' => 'checkbox',
                'helptext' =>
                    'Pipeline triggers after every post/page update/create'
            )
        );

        foreach ($this->options as $name => $details) {
            $this->options[$name] = new Option($details);
        }
    }

    /**
     * Wrapper for WordPress get_options (adds prefix to default options)
     *
     * @param string $key
     *
     * @return varies
     */
    public function get($key)
    {
        $default = $this->options[$key]->default;
        $key = $this->prefix . $key;
        return get_option($key, $default);
    }

    /**
     * Wrapper for WordPress update_option (adds prefix to default options)
     *
     * @param string $key   Unique db key
     * @param varies $value Value to insert
     */
    public function set($key, $value)
    {
        $key = $this->prefix . $key;
        update_option($key, $value);
        return $this;
    }

    /**
     * Wrapper for WordPress delete_option (adds prefix to default options)
     *
     * @param string $key Unique db key
     *
     * @return boolean
     */
    public function delete($key)
    {
        $key = $this->prefix . $key;
        return delete_option($key);
    }

    /**
     * Delete all options
     */
    public function reset()
    {
        foreach ($this->options as $name => $option) {
            if (
                !array_key_exists('noreset', $options) ||
                $options['noreset'] != true
            ) {
                $this->delete($name);
            }
        }
    }
}
