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

$currency_symbol = get_woocommerce_currency_symbol();

$blur =  isset( $data['transactions'] ) && empty( $data['transactions'] ) ? 'ybh-blur' : '';

$status_txt = isset( $data['status'] ) ? esc_html(ucfirst( $data['status'] ) ) : '-';
$red_dot = ( isset( $data['status'] ) && $data['status'] != 'active' ) ? 'ybh-red-dot' : '';
$red_txt = ( isset( $data['status'] ) && $data['status'] != 'active' ) ? 'ybh-red-text' : '';
$company_name = $data['company_name'] ?? '-';

?>
<header class="ybh-header">
    <div class="ybh-logo"><img src="<?php echo esc_url( plugin_dir_url(__DIR__) .'img/logo.svg' ); ?>"></div>
    <div class="ybh-header-right">
        <span><img src="<?php echo esc_url( plugin_dir_url(__DIR__) .'img/store.svg' ); ?>"> <?php echo esc_html( $company_name ); ?></span>
        <div class="ybh-status-indicator">
            <span class="ybh-status-dot <?php echo esc_html( $red_dot ); ?>"></span>
            <span class="ybh-status-text <?php echo esc_html( $red_txt ); ?>"><?php echo esc_html( $status_txt ); ?></span>
        </div>
        <span class="ybh-balance"><?php echo esc_html( isset( $data['total_credits'] ) ? number_format((float)$data['total_credits'], 2, ',', '') . $currency_symbol : '-' ); ?>
            <a href="https://youbehero.com" target="_blank">
                <img src="<?php echo esc_url( plugin_dir_url(__DIR__) .'img/fa-solid_plus-circle.svg' ); ?>">
            </a>
        </span>
        <span>
            <a href="https://youbehero.com" target="_blank"><img src="<?php echo esc_url( plugin_dir_url(__DIR__) .'img/setting.svg' ); ?>"></a>
        </span>
        <span>
            <a id="ybhd_logout"><img src="<?php echo esc_url( plugin_dir_url(__DIR__) .'img/logout.svg' ); ?>"></a>
        </span>
    </div>
</header>

<div class="ybh-main-container">
    <div class="ybh-stats-grid">
        <div class="ybh-stat-card ybh-flex-box-1">
            <div class="ybh-account-info">
                <div class="ybh-account-avatar">
                    <img src="<?php echo esc_url( $data['eshop_logo'] ?? plugin_dir_url(__DIR__) .'img/company.svg' ); ?>">
                </div>
                <div class="ybh-account-details">
                    <h3><?php echo esc_html( $company_name ); ?></h3>
                    <div class="ybh-account-status">
                        <span><?php echo esc_html__( 'Status', 'youbehero' ); ?> : </span>
                        <div class="ybh-status-indicator">
                            <span class="ybh-status-dot <?php echo esc_html( $red_dot ); ?>"></span>
                            <span class="ybh-status-text <?php echo esc_html( $red_txt ); ?>"><?php echo esc_html( $status_txt ); ?></span>
                        </div>
                    </div>
                    <div><?php echo esc_html__( 'Account Balance', 'youbehero' ); ?> :<span id="ybh-account-balance"><?php echo esc_html( isset( $data['total_credits'] ) ? number_format((float)$data['total_credits'], 2, ',', '') . $currency_symbol : '-' ); ?></span></div>
                </div>
            </div>
        </div>

        <div class="ybh-flex-cards">
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo esc_html__( 'Total Gifts', 'youbehero' ); ?></h4>
                <div class="ybh-stat-value <?php echo esc_html( $blur ); ?>" id="ybh-total-gifts"><?php echo esc_html( isset( $data['summary']['total_donations'] ) ? number_format((float)$data['summary']['total_donations'], 2, ',', '') . $currency_symbol : '-' ); ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo esc_html__( 'Total Sales', 'youbehero' ); ?></h4>
                <div class="ybh-stat-value <?php echo esc_html( $blur ); ?>" id="ybh-total-sales"><?php echo esc_html( isset( $data['summary']['total_sales'] ) ? number_format((float)$data['summary']['total_sales'], 2, ',', '') . $currency_symbol : '-' ); ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo esc_html__( 'Average Basket Value', 'youbehero' ); ?></h4>
                <div class="ybh-stat-value <?php echo esc_html( $blur ); ?>" id="ybh-avg-basket"><?php echo esc_html( isset( $data['summary']['average_order_value'] ) ? number_format((float)$data['summary']['average_order_value'], 2, ',', '') . $currency_symbol : '-' ); ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo esc_html__( 'Number of Orders', 'youbehero' ); ?></h4>
                <div class="ybh-stat-value <?php echo esc_html( $blur ); ?>" id="ybh-order-count"><?php echo esc_html( $data['summary']['total_orders'] ?? '-' ); ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo esc_html__( "Benefited NGO's", 'youbehero' ); ?></h4>
                <div class="ybh-stat-value <?php echo esc_html( $blur ); ?>" id="ybh-pending-ngo"><?php echo esc_html( $data['summary']['benefited_organizations'] ?? '-' ); ?></div>
            </div>
        </div>
    </div>

    <div class="ybh-orders-section" id="ybh-orders-section">
        <div class="ybh-orders-header">
            <h2 class="ybh-orders-title"><?php echo esc_html__( 'Transaction Table', 'youbehero' ); ?></h2>
            <button id="ybh-refresh-btn" class="ybh-refresh-btn">
                <img src="<?php echo esc_url( plugin_dir_url(__DIR__) .'img/refresh.svg' ); ?>"> <?php echo esc_html__( 'Refresh', 'youbehero' ); ?>
            </button>
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
                    <?php foreach ( $data['transactions'] as $transaction ) { ?>
                        <tr>
                            <td><?php echo esc_html( $transaction['id'] ); ?></td>
                            <td><?php echo esc_html( $transaction['order_number'] ); ?></td>
                            <td><?php echo esc_html( $transaction['date'] ); ?></td>
                            <td><?php echo esc_html( number_format((float)$transaction['total'], 2, ',', '') . $currency_symbol ); ?></td>
                            <td><?php echo esc_html( number_format((float)$transaction['donation'], 2, ',', '') . $currency_symbol );?></td>
                            <td><a href="<?php echo esc_url( $transaction['link'] ); ?>" target="_blank" class="ybh-order-link"><?php echo esc_html( $transaction['organization'] ); ?></a></td>
                        </tr>
                    <?php } ?>
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
