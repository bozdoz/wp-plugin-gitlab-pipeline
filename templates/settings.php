<?php
/**
 * Settings View
 */

$title = $plugin_data['Name'];
$description = __(
    'A plugin to trigger a GitLab pipeline after a post or page is updated or created.',
    'trigger-pipeline'
);
$version = $plugin_data['Version'];
?>
<div class="wrap">
    <h1><?php echo $title; ?> <small>version: <?php echo $version; ?></small></h1>
    <p><?php echo $description; ?></p>
<?php if (isset($_POST['submit'])) {

    /* copy and overwrite $post for checkboxes */
    $form = $_POST;

    foreach ($settings->options as $name => $option) {
        if (!$option->type) {
            continue;
        }

        /* checkboxes don't get sent if not checked */
        if ($option->type === 'checkbox') {
            $form[$name] = isset($_POST[$name]) ? 1 : 0;
        }

        $value = trim(stripslashes($form[$name]));

        $settings->set($name, $value);
    }
    ?>
<div class="notice notice-success is-dismissible">
    <p><?php _e('Options Updated!', 'leaflet-map'); ?></p>
</div>
<?php
} elseif (isset($_POST['reset'])) {
    $settings->reset(); ?>
<div class="notice notice-success is-dismissible">
    <p><?php _e(
        'Options have been reset to default values!',
        'leaflet-map'
    ); ?></p>
</div>
<?php
} elseif (isset($_POST['clear-geocoder-cache'])) {

    include_once LEAFLET_MAP__PLUGIN_DIR . 'class.geocoder.php';
    Leaflet_Geocoder::remove_caches();
    ?>
<div class="notice notice-success is-dismissible">
    <p><?php _e('Location caches have been cleared!', 'leaflet-map'); ?></p>
</div>
<?php
} ?>
<div class="wrap">
    <div class="wrap">
    <form method="post">
        <div class="container">
            <h2><?php _e('Settings', 'leaflet-map'); ?></h2>
            <hr>
        </div>
    <?php foreach ($settings->options as $name => $option) {
        if (!$option->type) {
            continue;
        } ?>
    <div class="container">
        <label>
            <span class="label"><?php echo $option->display_name; ?></span>
            <span class="input-group">
            <?php $option->widget($name, $settings->get($name)); ?>
            </span>
        </label>

        <?php if ($option->helptext) { ?>
        <div class="helptext">
            <p class="description"><?php echo $option->helptext; ?></p>
        </div>
        <?php } ?>
    </div>
    <?php
    } ?>
    <div class="submit">
        <input type="submit" 
            name="submit" 
            id="submit" 
            class="button button-primary" 
            value="<?php _e('Save Changes', 'trigger-pipeline'); ?>">
    </div>

    </form>
    </div>
</div>
