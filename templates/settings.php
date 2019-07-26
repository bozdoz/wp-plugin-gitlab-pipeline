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
    <p><?php _e('Options Updated!', 'trigger-pipeline'); ?></p>
</div>
<?php
} elseif (isset($_POST['reset'])) {
    $settings->reset(); ?>
<div class="notice notice-success is-dismissible">
    <p><?php _e(
        'Options have been reset to default values!',
        'trigger-pipeline'
    ); ?></p>
</div>
<?php
} elseif (isset($_POST['trigger-now'])) {
    Trigger_Pipeline::trigger(); ?>
<div class="notice notice-success is-dismissible">
    <p><?php _e('Pipeline Triggered!', 'trigger-pipeline'); ?></p>
</div>
<?php
} ?>
<div class="wrap">
    <div class="wrap">
    <form method="post">
        <div class="container">
            <h2><?php _e('Settings', 'trigger-pipeline'); ?></h2>
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
            value="<?php _e('Save Changes', 'trigger-pipeline'); ?>" 
        />
        <input type="submit" 
            name="trigger-now" 
            id="trigger-now" 
            class="button button-secondary" 
            value="<?php _e('Trigger Now', 'trigger-pipeline'); ?>"
        />
        <input type="submit" 
            name="reset" 
            id="reset" 
            class="button button-secondary" 
            value="<?php _e('Reset to Defaults', 'trigger-pipeline'); ?>"
        />
    </div>

    </form>
    </div>
</div>
