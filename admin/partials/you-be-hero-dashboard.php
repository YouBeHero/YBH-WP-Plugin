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

$ybhd_currency_symbol = get_woocommerce_currency_symbol();

$ybhd_blur = isset( $data['transactions'] ) && empty( $data['transactions'] ) ? 'ybh-blur' : '';

// Translate status values from JSON
$ybhd_status_value = isset( $data['status'] ) ? $data['status'] : '';
if ( ! empty( $ybhd_status_value ) ) {
    $ybhd_status_map = array(
        'active'   => esc_html__( 'Active', 'youbehero' ),
        'inactive' => esc_html__( 'Inactive', 'youbehero' ),
    );
    $ybhd_status_txt = isset( $ybhd_status_map[ $ybhd_status_value ] ) ? $ybhd_status_map[ $ybhd_status_value ] : esc_html( ucfirst( $ybhd_status_value ) );
} else {
    $ybhd_status_txt = '-';
}
$ybhd_red_dot     = ( isset( $data['status'] ) && $data['status'] != 'active' ) ? 'ybh-red-dot' : '';
$ybhd_red_txt     = ( isset( $data['status'] ) && $data['status'] != 'active' ) ? 'ybh-red-text' : '';
$ybhd_company_name = $data['company_name'] ?? '-';

// Get diagnostic data for checkout widget
$ybhd_diagnostics = You_Be_Hero_Admin::get_checkout_widget_diagnostics();

// Get installation guidelines
$ybhd_guidelines = You_Be_Hero_Admin::get_installation_guidelines();

?>
<header class="ybh-header">
    <div class="ybh-logo"><img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'img/logo.svg' ); ?>"></div>
    <div class="ybh-header-bothright">
        <div class="ybh-header-right">
            <span><img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'img/store.svg' ); ?>"> <?php echo esc_html( $ybhd_company_name ); ?></span>
            <div class="ybh-status-indicator">
                <span class="ybh-status-dot <?php echo esc_html( $ybhd_red_dot ); ?>"></span>
                <span class="ybh-status-text <?php echo esc_html( $ybhd_red_txt ); ?>"><?php echo esc_html( $ybhd_status_txt ); ?></span>
            </div>
            <a href="https://youbehero.com/gr/topup" target="_blank" class="ybh-balance-link" title="<?php echo esc_html__( 'Account topup', 'youbehero' ); ?>">
                <span class="ybh-balance"><?php echo esc_html( isset( $data['total_credits'] ) ? number_format( (float) $data['total_credits'], 2, ',', '' ) . $ybhd_currency_symbol : '-' ); ?>
                    <img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'img/fa-solid_plus-circle.svg' ); ?>?v=1.1">
                </span>
            </a>
        </div>
        <button id="ybh-refresh-btn" class="ybh-refresh-btn" title="<?php echo esc_attr__( 'Fetch latest settings from YouBeHero (colors, organizations, etc.)', 'youbehero' ); ?>">
            <img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'img/refresh.svg' ); ?>">
            <span><?php echo esc_html__( 'Update', 'youbehero' ); ?></span>
        </button>
        <div class="ybh-header-outright">
            <span>
                <a href="https://youbehero.com/gr/eshop-dashboard" target="_blank" title="<?php echo esc_html__( 'Settings', 'youbehero' ); ?>"><img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'img/setting.svg' ); ?>?v=1.1"></a>
            </span>
            <span>
                <a id="ybhd_logout" title="<?php echo esc_html__( 'Logout', 'youbehero' ); ?>"><img src="<?php echo esc_url( plugin_dir_url( __DIR__ ) . 'img/logout.svg' ); ?>?v=1.1"></a>
            </span>
        </div>
    </div>
</header>
<div class="ybh-main-container">
    <div class="ybh-stats-grid">
        <div class="ybh-stat-card ybh-flex-box-1">
            <div class="ybh-account-info">
                <a href="https://youbehero.com/gr/eshop-info" target="_blank" class="ybh-account-avatar-link" title="<?php echo esc_attr__( 'Change eshop avatar', 'youbehero' ); ?>">
                    <div class="ybh-account-avatar">
                        <img src="<?php echo esc_url( $data['eshop_logo'] ?? plugin_dir_url( __DIR__ ) . 'img/eshop.png' ); ?>">
                    </div>
                </a>
                <div class="ybh-account-details">
                    <h3><?php echo esc_html( $ybhd_company_name ); ?></h3>
                    <div class="ybh-account-status">
                        <span><?php echo esc_html__( 'Status', 'youbehero' ); ?>: </span>
                        <div class="ybh-status-indicator">
                            <span class="ybh-status-dot <?php echo esc_html( $ybhd_red_dot ); ?>"></span>
                            <span class="ybh-status-text <?php echo esc_html( $ybhd_red_txt ); ?>"><?php echo esc_html( $ybhd_status_txt ); ?></span>
                        </div>
                    </div>
                    <div><?php echo esc_html__( 'Account Balance', 'youbehero' ); ?>: <span id="ybh-account-balance"><?php echo esc_html( isset( $data['total_credits'] ) ? number_format( (float) $data['total_credits'], 2, ',', '' ) . $ybhd_currency_symbol : '-' ); ?></span></div>
                </div>
            </div>
        </div>

        <div class="ybh-flex-cards">
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo esc_html__( 'Total donations', 'youbehero' ); ?></h4>
                <div class="ybh-stat-value <?php echo esc_html( $ybhd_blur ); ?>" id="ybh-total-gifts"><?php echo esc_html( isset( $data['summary']['total_donations'] ) ? number_format( (float) $data['summary']['total_donations'], 2, ',', '' ) . $ybhd_currency_symbol : '-' ); ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo esc_html__( 'Total sales', 'youbehero' ); ?></h4>
                <div class="ybh-stat-value <?php echo esc_html( $ybhd_blur ); ?>" id="ybh-total-sales"><?php echo esc_html( isset( $data['summary']['total_sales'] ) ? number_format( (float) $data['summary']['total_sales'], 2, ',', '' ) . $ybhd_currency_symbol : '-' ); ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo esc_html__( 'Average cart value', 'youbehero' ); ?></h4>
                <div class="ybh-stat-value <?php echo esc_html( $ybhd_blur ); ?>" id="ybh-avg-basket"><?php echo esc_html( isset( $data['summary']['average_order_value'] ) ? number_format( (float) $data['summary']['average_order_value'], 2, ',', '' ) . $ybhd_currency_symbol : '-' ); ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo esc_html__( 'Number of orders', 'youbehero' ); ?></h4>
                <div class="ybh-stat-value <?php echo esc_html( $ybhd_blur ); ?>" id="ybh-order-count"><?php echo esc_html( $data['summary']['total_orders'] ?? '-' ); ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo esc_html__( "Supported NGOs", 'youbehero' ); ?></h4>
                <div class="ybh-stat-value <?php echo esc_html( $ybhd_blur ); ?>" id="ybh-pending-ngo"><?php echo esc_html( $data['summary']['benefited_organizations'] ?? '-' ); ?></div>
            </div>
        </div>
    </div>

    <!-- Installation Guidelines Section -->
    <?php if ( ! $ybhd_diagnostics['widget_already_installed'] && $ybhd_diagnostics['checkout_page_exists'] ) : ?>
    <div class="ybh-installation-guide-section" style="margin: 30px 0; background: #fff; border: 1px solid #0073aa; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h2 style="margin: 0 0 20px 0; font-size: 18px; color: #1d2327;">📚 <?php echo esc_html__( 'Installation Guide', 'youbehero' ); ?></h2>
        
        <div style="margin-bottom: 20px; padding: 15px; background: #f0f6fc; border-left: 4px solid #0073aa; border-radius: 4px;">
            <p style="margin: 0 0 10px 0; font-size: 14px; font-weight: 600; color: #1d2327;">
                <?php echo esc_html__( 'Detected Editor:', 'youbehero' ); ?> 
                <span style="color: #0073aa;"><?php echo esc_html( $ybhd_guidelines['editor'] ); ?></span>
            </p>
            <?php if ( ! empty( $ybhd_guidelines['editor_link'] ) ) : ?>
                <a href="<?php echo esc_url( $ybhd_guidelines['editor_link'] ); ?>" target="_blank" class="button button-primary" style="text-decoration: none; display: inline-block; padding: 8px 16px; margin-top: 10px;">
                    <?php echo esc_html( $ybhd_guidelines['editor_link_text'] ); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $ybhd_guidelines['steps'] ) ) : ?>
        <div style="background: #f9f9f9; padding: 20px; border-radius: 6px;">
            <h3 style="margin: 0 0 15px 0; font-size: 16px; color: #1d2327; font-weight: 600;">
                <?php echo esc_html__( 'Step-by-Step Instructions', 'youbehero' ); ?>
            </h3>
            <ol style="margin: 0; padding-left: 25px; font-size: 14px; line-height: 1.8; color: #1d2327;">
                <?php foreach ( $ybhd_guidelines['steps'] as $ybhd_index => $ybhd_step ) : ?>
                    <li style="margin-bottom: 12px;">
                        <?php echo esc_html( $ybhd_step ); ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $ybhd_guidelines['additional_info'] ) ) : ?>
        <p style="margin-top: 20px; font-size: 14px; color: #1d2327;">
            <strong><?php echo esc_html__( 'Additionally:', 'youbehero' ); ?></strong><br>
            <?php echo esc_html( $ybhd_guidelines['additional_info'] ); ?>
        </p>
        <?php endif; ?>

        <?php if ( $ybhd_guidelines['editor'] === 'Unknown' ) : ?>
        <div style="margin-top: 15px; padding: 15px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
            <p style="margin: 0; font-size: 13px; color: #856404;">
                <strong><?php echo esc_html__( 'Note:', 'youbehero' ); ?></strong> 
                <?php echo esc_html__( 'Could not detect the page editor. Please manually add the YouBeHero donation widget to your checkout page using your page builder.', 'youbehero' ); ?>
            </p>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="ybh-orders-section" id="ybh-orders-section">
        <div class="ybh-orders-header">
            <h2 class="ybh-orders-title"><?php echo esc_html__( 'Transaction Table', 'youbehero' ); ?></h2>
        </div>

        <?php if( !empty( $data['transactions'] ) ) { ?>

            <table class="ybh-orders-table" id="ybh-orders-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo esc_html__( 'Order', 'youbehero' ); ?></th>
                    <th><?php echo esc_html__( 'Date', 'youbehero' ); ?></th>
                    <th><?php echo esc_html__( 'Total', 'youbehero' ); ?></th>
                    <th><?php echo esc_html__( 'Donation', 'youbehero' ); ?></th>
                    <th><?php echo esc_html__('Organization', 'youbehero' ); ?></th>
                </tr>
                </thead>
                <tbody id="ybh-orders-tbody">
                    <?php 
                    $ybhd_total_donations = count( $data['transactions'] );
                    $ybhd_donation_count  = $ybhd_total_donations;
                    foreach ( $data['transactions'] as $ybhd_transaction ) { 
                    ?>
                        <tr>
                            <td><?php echo esc_html( $ybhd_donation_count ); ?></td>
                            <td><a href="<?php echo esc_url( admin_url( 'admin.php?page=wc-orders&action=edit&id=' . $ybhd_transaction['order_number'] ) ); ?>" target="_blank" class="ybh-order-link"><?php echo esc_html( $ybhd_transaction['order_number'] ); ?></a></td>
                            <td><?php echo esc_html( $ybhd_transaction['date'] ); ?></td>
                            <td><?php echo esc_html( number_format( (float) $ybhd_transaction['total'], 2, ',', '' ) . $ybhd_currency_symbol ); ?></td>
                            <td><?php echo esc_html( number_format( (float) $ybhd_transaction['donation'], 2, ',', '' ) . $ybhd_currency_symbol ); ?></td>
                            <td><a href="<?php echo esc_url( $ybhd_transaction['link'] ); ?>" target="_blank" class="ybh-order-link"><?php echo esc_html( $ybhd_transaction['organization'] ); ?></a></td>
                        </tr>
                    <?php 
                        $ybhd_donation_count--;
                    } ?>
                </tbody>
            </table>

        <?php } else { ?>

            <div class="ybh-empty-state" id="ybh-empty-state">
                <div class="ybh-empty-illustration">
                    <img src="<?php echo esc_url( plugin_dir_url(__DIR__) .'img/welcome-illustration.svg' ); ?>">
                </div>
                <div class="ybh-empty-message">
                    <?php echo esc_html__( 'Transaction details will appear here once the first donation purchase is made!', 'youbehero' ); ?>
                </div>
            </div>

        <?php } ?>
    </div>
</div>
