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
                <div class="ybh-account-avatar">
                    <img src="<?php echo esc_url( $data['eshop_logo'] ?? plugin_dir_url( __DIR__ ) . 'img/eshop.png' ); ?>">
                </div>
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
