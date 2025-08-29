<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://youbehero.com
 * @since      1.0.1
 *
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$status = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$logout = isset( $_GET['logout'] ) ? sanitize_text_field( wp_unslash( $_GET['logout'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

?>
<div class="ybh-main-container">
    <div class="ybh-logo-token"><img src="<?php echo esc_url( plugin_dir_url(__DIR__) .'img/logo.svg' ); ?>"></div>

    <?php
    // Nonce verification not used here because `status` comes from external service.
    // The value is sanitized and not used for sensitive operations.
    ?>
    <?php if ( $status == 'fail' ) { ?>
        <div class="notice notice-error is-dismissible" style="color: #d63638">
            <p><?php echo esc_html__( 'We couldn’t verify your API key. Please double-check for any missing characters or extra spaces, then try again.', 'youbehero' );?></p>
        </div>
    <?php } ?>

    <?php
    // Nonce verification not used here because `logut` is simply a url not form submission.
    // The value is sanitized and not used for sensitive operations.
    ?>
    <?php if ( $logout == 'yes' ) { ?>
        <div class="notice notice-success is-dismissible" style="color: #00a32a">
            <p><?php echo esc_html__( 'You have successfully logged out.', 'youbehero' );?></p>
        </div>
    <?php } ?>

    <h3 class="ybh-token-hdng"><?php echo esc_html__( 'Thank you for installing it', 'youbehero' ); ?> Add donation to cart! 🥳</h3>

    <div class="ybh-token-txt">
        <p>
            <?php echo esc_html__( 'To connect your YouBeHero account with this online store', 'youbehero' ); ?>:
        </p>
        <ol>
            <li><?php echo esc_html__( 'Copy the API key from your account at', 'youbehero' ); ?> YouBeHero</li>
            <li><?php echo esc_html__( 'Paste it into the field below', 'youbehero' ); ?></li>
            <li><?php echo esc_html__( 'Click "Connect"', 'youbehero' ); ?></li>
        </ol>
    </div>

    <div class="ybh-token-settings">
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="ybh_submit_apikey">
            <?php wp_nonce_field( 'ybh_submit_apikey', 'ybh_submit_apikey_nonce' ); ?>
            <?php do_settings_sections('ybh-settings'); ?>
            <label for="ybh_token">API <?php echo esc_html__( 'key', 'youbehero' ); ?>:</label>
            <?php
            // Nonce verification not used here because `ybh_token` is coming from third party api or from wp_options.
            // The value is sanitized and not used for sensitive operations.
            ?>
            <input type="text" id="ybh_token" name="ybh_token" value="<?php echo esc_attr($ybh_token); ?>" style="border-color: <?php echo ( $status == 'fail' ) ? '#d63638': ''; ?>" />
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_html__( 'Login', 'youbehero' );?>">
            </p>
            <p><?php echo esc_html__( "Don't have an API key?", 'youbehero' );?> <a href="https://dev.youbehero.com/gr/signup-eshop"><?php echo esc_html__( "Create an account", 'youbehero' );?></a></p>
        </form>
    </div>
    <p><?php echo esc_html__( "Add donation to Cart is a YouBeHero plugin for WooCommerce that allows you to increase your corporate social responsibility with every online sale.", 'youbehero' );?></p>
</div>
