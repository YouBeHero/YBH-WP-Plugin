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

$ybhd_status = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$ybhd_logout = isset( $_GET['logout'] ) ? sanitize_text_field( wp_unslash( $_GET['logout'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

?>
<?php if ( $ybhd_logout == 'yes' ) { ?>
        <div class="notice notice-success is-dismissible" style="color: #00a32a">
            <p><?php echo esc_html__( 'You have successfully logged out.', 'youbehero' );?></p>
        </div>
    <?php } ?>

<?php
// Nonce verification not used here because `status` comes from external service.
// The value is sanitized and not used for sensitive operations.
?>
<?php if ( $ybhd_status == 'fail' ) { ?>
    <div class="notice notice-error is-dismissible" style="color: #d63638">
        <p><?php echo esc_html__( 'We couldn’t verify your API key. Please double-check for any missing characters or extra spaces, then try again.', 'youbehero' );?></p>
    </div>
<?php } ?>

<?php
// Nonce verification not used here because `logut` is simply a url not form submission.
// The value is sanitized and not used for sensitive operations.
?>

<div class="ybh-main-container">
    <div class="ybh-logo-token"><img src="<?php echo esc_url( plugin_dir_url(__DIR__) .'img/logo.svg' ); ?>"></div>

    <h3 class="ybh-token-hdng"><?php echo esc_html__( 'Thank you for installing', 'youbehero' ); ?> Add Donation to Cart! 🥳</h3>

    <div class="ybh-token-txt">
        <p>
            <?php echo esc_html__( 'To connect your YouBeHero account with your eshop', 'youbehero' ); ?>:
        </p>
        <ol>
            <li><?php echo esc_html__( 'Copy the API key from your account at', 'youbehero' ); ?> YouBeHero</li>
            <li><?php echo esc_html__( 'Paste it into the field below', 'youbehero' ); ?></li>
            <li><?php echo esc_html__( 'Click "Login"', 'youbehero' ); ?></li>
        </ol>
    </div>

    <div class="ybh-token-settings">
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="ybhd_submit_apikey">
            <?php wp_nonce_field( 'ybhd_submit_apikey', 'ybhd_submit_apikey_nonce' ); ?>
            <?php do_settings_sections('youbehero-settings'); ?>
            <label for="ybhd_token">API <?php echo esc_html__( 'key', 'youbehero' ); ?>:</label>
            <?php
            // Nonce verification not used here because `ybhd_token` is coming from third party api or from wp_options.
            // The value is sanitized and not used for sensitive operations.
            ?>
            <input type="text" id="ybhd_token" name="ybhd_token" value="<?php echo esc_attr( $ybhd_token ); ?>" style="border-color: <?php echo ( $ybhd_status == 'fail' ) ? '#d63638' : ''; ?>" placeholder="<?php echo esc_html__( 'API 🔑', 'youbehero' );?>"/>
            <?php
            if ( $ybhd_status == 'fail' ) {
                ?>
                <span style="color:#d63638;">
                    <?php echo esc_html__( 'We couldn’t verify your API key. Please double-check for any missing characters or extra spaces, then try again.', 'youbehero' );?>
                </span>
            <?php } ?>

            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_html__( 'Login', 'youbehero' );?>">
            </p>
            <p><?php echo esc_html__( "Don't have an API key?", 'youbehero' );?> <a href="https://dev.youbehero.com/gr/signup-eshop" target="_blank"><?php echo esc_html__( "Create an account", 'youbehero' );?></a></p>
        </form>
    </div>
    <p><?php echo esc_html__( "Add Donation to Cart is a YouBeHero plugin for WooCommerce that allows you to increase your corporate social responsibility with every online sale.", 'youbehero' );?></p>
</div>
