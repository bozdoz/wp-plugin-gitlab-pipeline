=== Trigger Pipeline ===
Author: bozdoz
Author URI: https://www.twitter.com/bozdoz/
Plugin URI: https://wordpress.org/plugins/trigger-pipeline/
Contributors: bozdoz
Donate link: https://www.paypal.me/bozdoz
Tags: gitlab, pipeline, webhook, hook, trigger, ci, cd, continuous delivery
Requires at least: 3.0.1
Tested up to: 5.0.2
Version: 2.13.0
Stable tag: 2.13.0
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Trigger a GitLab pipeline after a post or page is updated or created.

== Description ==

After a post or page is updated or created, this plugin sends a POST request to a GitLab pipeline trigger, which potentially would trigger a rebuild of a project.  Say you're using WordPress as a headless CMS: use this to build your static website with GitLab.

= More =

Check out the **source code** on [GitHub](https://github.com/bozdoz/trigger-pipeline)!

Shoot me a question [@bozdoz](https://www.twitter.com/bozdoz/).

== Installation ==

1. Choose to add a new plugin, then click upload
2. Upload the trigger-pipeline zip
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to the plugin settings to configure

== Changelog ==

= 0.1.0 =
* First Version. GitLab pipeline triggers on post save event.

== Upgrade Notice ==

= 0.1.0 =
First Version. Tested with 5.0.3.