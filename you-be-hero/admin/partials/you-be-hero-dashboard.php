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

$currency_symbol = get_woocommerce_currency_symbol();
$blur =  isset( $data ) && empty( $data ) ? 'ybh-blur' : '';
?>
<header class="ybh-header">
    <div class="ybh-logo"><img src="<?php echo plugin_dir_url(__DIR__) .'img/logo.svg'; ?>"></div>
    <div class="ybh-header-right <?php echo $blur; ?>">
        <span><img src="<?php echo plugin_dir_url(__DIR__) .'img/store.svg'; ?>"> <?php echo $data['store'] ?? '-'; ?></span>
        <div class="ybh-status-indicator">
            <span class="ybh-status-dot <?php echo ( isset( $data['status'] ) && $data['status'] != 'Active' ) ? 'ybh-red-dot' : ''; ?>"></span>
            <span class="ybh-status-text <?php echo ( isset( $data['status'] ) && $data['status'] != 'Active' ) ? 'ybh-red-text' : ''; ?>"><?php echo isset( $data['status'] ) ? __( $data['status'], 'you-be-hero' ) : '-'; ?></span>
        </div>
        <span class="ybh-balance"><?php echo isset( $data['account_balance'] ) ? number_format((float)$data['account_balance'], 2, ',', '') . $currency_symbol : '-'; ?>
            <a href="https://youbehero.com" target="_blank">
                <img src="<?php echo plugin_dir_url(__DIR__) .'img/fa-solid_plus-circle.svg'; ?>">
            </a>
        </span>
        <span>
            <a href="https://youbehero.com" target="_blank"><img src="<?php echo plugin_dir_url(__DIR__) .'img/setting.svg'; ?>"></a>
        </span>
    </div>
</header>

<div class="ybh-main-container">
    <div class="ybh-stats-grid">
        <div class="ybh-stat-card ybh-flex-box-1">
            <div class="ybh-account-info <?php echo $blur; ?>">
                <div class="ybh-account-avatar">
                    <img src="<?php echo $data['logo'] ?? plugin_dir_url(__DIR__) .'img/company.svg'; ?>">
                </div>
                <div class="ybh-account-details">
                    <h3><?php echo isset( $data['store'] ) ? __( $data['store'], 'you-be-hero' ) : '-'; ?></h3>
                    <div class="ybh-account-status">
                        <span><?php echo __( 'Status', 'you-be-hero' ); ?> : </span>
                        <div class="ybh-status-indicator">
                            <span class="ybh-status-dot <?php echo ( isset( $data['status'] ) && $data['status'] != 'Active' ) ? 'ybh-red-dot' : ''; ?>"></span>
                            <span class="ybh-status-text <?php echo ( isset( $data['status'] ) && $data['status'] != 'Active' ) ? 'ybh-red-text' : ''; ?>"><?php echo isset( $data['status'] ) ? __( $data['status'], 'you-be-hero' ) : '-'; ?></span>
                        </div>
                    </div>
                    <div><?php echo __( 'Account Balance', 'you-be-hero' ); ?> :<span id="ybh-account-balance"><?php echo isset( $data['account_balance'] ) ? number_format((float)$data['account_balance'], 2, ',', '') . $currency_symbol : '-'; ?></span></div>
                </div>
            </div>
        </div>

        <div class="ybh-flex-cards">
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo __( 'Total Gifts', 'you-be-hero' ); ?></h4>
                <div class="ybh-stat-value <?php echo $blur; ?>" id="ybh-total-gifts"><?php echo isset( $data['summary']['total_donations'] ) ? number_format((float)$data['summary']['total_donations'], 2, ',', '') . $currency_symbol : '-'; ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo __( 'Total Sales', 'you-be-hero' ); ?></h4>
                <div class="ybh-stat-value <?php echo $blur; ?>" id="ybh-total-sales"><?php echo isset( $data['summary']['total_sales'] ) ? number_format((float)$data['summary']['total_sales'], 2, ',', '') . $currency_symbol : '-'; ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo __( 'Average Basket Value', 'you-be-hero' ); ?></h4>
                <div class="ybh-stat-value <?php echo $blur; ?>" id="ybh-avg-basket"><?php echo isset( $data['summary']['average_order_value'] ) ? number_format((float)$data['summary']['average_order_value'], 2, ',', '') . $currency_symbol : '-'; ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo __( 'Number of Orders', 'you-be-hero' ); ?></h4>
                <div class="ybh-stat-value <?php echo $blur; ?>" id="ybh-order-count"><?php echo $data['summary']['total_orders'] ?? '-'; ?></div>
            </div>
            <div class="ybh-stat-card ybh-flex-box-2">
                <h4><?php echo __( "Benefited NGO's", 'you-be-hero' ); ?></h4>
                <div class="ybh-stat-value <?php echo $blur; ?>" id="ybh-pending-ngo"><?php echo $data['summary']['benefited_organizations'] ?? '-'; ?></div>
            </div>
        </div>
    </div>

    <div class="ybh-orders-section" id="ybh-orders-section">
        <div class="ybh-orders-header">
            <h2 class="ybh-orders-title"><?php echo __( 'Transaction Table', 'you-be-hero' ); ?></h2>
            <button id="ybh-refresh-btn" class="ybh-refresh-btn">
                <img src="<?php echo plugin_dir_url(__DIR__) .'img/refresh.svg'; ?>"> <?php echo __( 'Refresh', 'you-be-hero' ); ?>
            </button>
        </div>

        <?php if( !empty( $data ) ) { ?>

            <table class="ybh-orders-table" id="ybh-orders-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo __( 'Order', 'you-be-hero' ); ?></th>
                    <th><?php echo __( 'Date', 'you-be-hero' ); ?></th>
                    <th><?php echo __( 'Total', 'you-be-hero' ); ?></th>
                    <th><?php echo __( 'Donation', 'you-be-hero' ); ?></th>
                    <th><?php echo __('Organization', 'you-be-hero' ); ?></th>
                </tr>
                </thead>
                <tbody id="ybh-orders-tbody">
                    <?php foreach ( $data['transactions'] as $transaction ) { ?>
                        <tr>
                            <td><?php echo $transaction['id']; ?></td>
                            <td><?php echo $transaction['order_number']; ?></td>
                            <td><?php echo $transaction['date']; ?></td>
                            <td><?php echo number_format((float)$transaction['total'], 2, ',', '') . $currency_symbol; ?></td>
                            <td><?php echo number_format((float)$transaction['donation'], 2, ',', '') . $currency_symbol;?></td>
                            <td><a href="<?php echo $transaction['link']; ?>" target="_blank" class="ybh-order-link"><?php echo $transaction['organization']; ?></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <?php } else { ?>

            <div class="ybh-empty-state" id="ybh-empty-state">
                <div class="ybh-empty-illustration">
                    <img src="<?php echo plugin_dir_url(__DIR__) .'img/welcome-illustration.svg'; ?>">
                </div>
                <div class="ybh-empty-message">
                    <?php echo __( 'Transaction details will appear here once the first donation purchase is made!', 'you-be-hero' ); ?>
                </div>
            </div>

        <?php } ?>
    </div>
</div>
