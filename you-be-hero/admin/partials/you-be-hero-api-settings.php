<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://youbehero.com
 * @since      1.0.0
 *
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/admin/partials
 */
?>
<div class="ybh-main-container">
    <div class="ybh-logo-token"><img src="<?php echo plugin_dir_url(__DIR__) .'img/logo.svg'; ?>"></div>

    <?php if ( isset( $_GET['status'] ) && $_GET['status'] == 'fail' ) { ?>
        <div class="notice notice-error is-dismissible">
            <p><?php echo __( 'We couldn’t verify your API key. Please double-check for any missing characters or extra spaces, then try again.', 'you-be-hero' );?></p>
        </div>
    <?php } ?>

    <h3 class="ybh-token-hdng"><?php echo __( 'Thank you for installing it', 'you-be-hero' ); ?> Add donation to cart! 🥳</h3>

    <div class="ybh-token-txt">
        <p>
            <?php echo __( 'To connect your YouBeHero account with this online store', 'you-be-hero' ); ?>:
        </p>
        <ol>
            <li><?php echo __( 'Copy the API key from your account at', 'you-be-hero' ); ?> YouBeHero</li>
            <li><?php echo __( 'Paste it into the field below', 'you-be-hero' ); ?></li>
            <li><?php echo __( 'Click "Connect"', 'you-be-hero' ); ?></li>
        </ol>
    </div>

    <div class="ybh-token-settings">
<!--        <form method="post" action="options.php">-->
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="ybh_submit_apikey">
            <?php wp_nonce_field( 'ybh_submit_apikey', 'ybh_submit_apikey_nonce' ); ?>

<!--            --><?php //settings_fields('ybh_settings_group'); ?>
            <?php do_settings_sections('ybh-settings'); ?>
            <label for="ybh_token">API <?php echo __( 'key', 'you-be-hero' ); ?>:</label>
            <input type="text" id="ybh_token" name="ybh_token" value="<?php echo esc_attr($ybh_token); ?>"   />
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __( 'Login', 'you-be-hero' );?>">
            </p>
            <p><?php echo __( "Don't have an API key?", 'you-be-hero' );?> <a href="https://dev.youbehero.com/gr/signup-eshop"><?php echo __( "Create an account", 'you-be-hero' );?></a></p>
        </form>
    </div>
    <p><?php echo __( "Add donation to Cart is a YouBeHero plugin for WooCommerce that allows you to increase your corporate social responsibility with every online sale.", 'you-be-hero' );?></p>
</div>
