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
?>
<header class="ybh-header">
    <div class="ybh-logo"><img src="<?php echo plugin_dir_url(__DIR__) .'img/logo-2.png'; ?>"></div>
    <div class="ybh-header-right">
        <span>📱 <?php echo $data['store'] ?? '-'; ?></span>
        <span class="<?php echo !empty( $data ) ? 'ybh-status-dot' : ''; ?>"></span>
        <span><?php echo isset( $data['status'] ) ? __( $data['status'], 'you-be-hero' ) : '-'; ?></span>
        <span class="ybh-balance"><?php echo isset( $data['account_balance'] ) ? number_format((float)$data['account_balance'], 2, ',', '') . $currency_symbol : '-'; ?> 💰</span>
    </div>
</header>

<div class="ybh-main-container">
    <div class="ybh-account-info">
        <div class="ybh-account-avatar">🔍</div>
        <div class="ybh-account-details">
            <h3><?php echo isset( $data['store'] ) ? __( $data['store'], 'you-be-hero' ) : '-'; ?></h3>
            <div class="ybh-account-status">
                <span><?php echo __( 'Account Status:', 'you-be-hero' ); ?></span>
                <span class="<?php echo !empty( $data ) ? 'ybh-status-dot' : ''; ?>"></span>
                <span><?php echo isset( $data['status'] ) ? __( $data['status'], 'you-be-hero' ) : '-'; ?></span>
            </div>
            <div><?php echo __( 'Account Balance:', 'you-be-hero' ); ?><span id="ybh-account-balance"><?php echo isset( $data['account_balance'] ) ? number_format((float)$data['account_balance'], 2, ',', '') . $currency_symbol : '-'; ?></span></div>
        </div>
    </div>

    <div class="ybh-stats-grid">
        <div class="ybh-stat-card">
            <h4><?php echo __( 'Total Gifts', 'you-be-hero' ); ?></h4>
            <div class="ybh-stat-value" id="ybh-total-gifts"><?php echo isset( $data['summary']['total_donations'] ) ? number_format((float)$data['summary']['total_donations'], 2, ',', '') . $currency_symbol : '-'; ?></div>
        </div>
        <div class="ybh-stat-card">
            <h4><?php echo __( 'Total Sales', 'you-be-hero' ); ?></h4>
            <div class="ybh-stat-value" id="ybh-total-sales"><?php echo isset( $data['summary']['total_sales'] ) ? number_format((float)$data['summary']['total_sales'], 2, ',', '') . $currency_symbol : '-'; ?></div>
        </div>
        <div class="ybh-stat-card">
            <h4><?php echo __( 'Average Basket Value', 'you-be-hero' ); ?></h4>
            <div class="ybh-stat-value" id="ybh-avg-basket"><?php echo isset( $data['summary']['average_order_value'] ) ? number_format((float)$data['summary']['average_order_value'], 2, ',', '') . $currency_symbol : '-'; ?></div>
        </div>
        <div class="ybh-stat-card">
            <h4><?php echo __( 'Number of Orders', 'you-be-hero' ); ?></h4>
            <div class="ybh-stat-value" id="ybh-order-count"><?php echo $data['summary']['total_orders'] ?? '-'; ?></div>
        </div>
        <div class="ybh-stat-card">
            <h4><?php echo __( 'Pending NGOs', 'you-be-hero' ); ?></h4>
            <div class="ybh-stat-value" id="ybh-pending-ngo"><?php echo $data['summary']['benefited_organizations'] ?? '-'; ?></div>
        </div>
    </div>

    <div class="ybh-orders-section" id="ybh-orders-section">
        <div class="ybh-orders-header">
            <h2 class="ybh-orders-title"><?php echo __( 'Transaction Table', 'you-be-hero' ); ?></h2>
            <button id="ybh-refresh-btn" class="ybh-refresh-btn">
                🔄 <?php echo __( 'Refresh', 'you-be-hero' ); ?>
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
                            <td><a href="<?php echo $transaction['link']; ?>" class="ybh-order-link"><?php echo $transaction['organization']; ?></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <?php } else { ?>

            <div class="ybh-empty-state" id="ybh-empty-state">
                <div class="ybh-empty-illustration">
                    <svg viewBox="0 0 200 150" fill="none">
                        <rect x="50" y="40" width="100" height="70" rx="8" fill="#e3f2fd" stroke="#4285f4" stroke-width="2"/>
                        <circle cx="75" cy="55" r="8" fill="#4285f4"/>
                        <circle cx="125" cy="55" r="8" fill="#4285f4"/>
                        <path d="M70 75 Q100 90 130 75" stroke="#4285f4" stroke-width="3" fill="none"/>
                        <rect x="90" y="85" width="40" height="12" rx="6" fill="#4285f4"/>
                        <text x="100" y="93" fill="white" font-size="8" text-anchor="middle"><?php echo __( 'Refresh', 'you-be-hero' ); ?></text>
                    </svg>
                </div>
                <div class="ybh-empty-message">
                    <?php echo __( 'Transaction details will appear here once the first donation purchase is made!', 'you-be-hero' ); ?>
                </div>
            </div>

        <?php } ?>
    </div>
</div>

<script>
//     let isDataLoaded = false;
//
//     async function ybhFetchData() {
//         // Try multiple methods to fetch data
//         const urls = [
//             'https://pastefy.app/V0aW0kRi/raw',
//             'https://api.allorigins.win/get?url=' + encodeURIComponent('https://pastefy.app/V0aW0kRi/raw'),
//             'https://corsproxy.io/?' + encodeURIComponent('https://pastefy.app/V0aW0kRi/raw')
//         ];
//
//         for (let i = 0; i < urls.length; i++) {
//             try {
//                 console.log(`Trying URL ${i + 1}: ${urls[i]}`);
//                 const response = await fetch(urls[i]);
//
//                 if (!response.ok) {
//                     throw new Error(`HTTP error! status: ${response.status}`);
//                 }
//
//                 let data;
//                 if (i === 1) {
//                     // allorigins returns data in a different format
//                     const result = await response.json();
//                     data = JSON.parse(result.contents);
//                 } else {
//                     data = await response.json();
//                 }
//
//                 console.log('Successfully fetched data:', data);
//                 return data;
//             } catch (error) {
//                 console.error(`Error with URL ${i + 1}:`, error);
//                 if (i === urls.length - 1) {
//                     // Last attempt failed, throw error
//                     throw error;
//                 }
//             }
//         }
//     }
//
//     async function ybhRefreshData() {
//         if (!isDataLoaded) {
//             // Show loading state
//             const refreshBtn = document.querySelector('.ybh-refresh-btn');
//             refreshBtn.innerHTML = '⏳ Φόρτωση...';
//             refreshBtn.disabled = true;
//
//             try {
//                 const data = await ybhFetchData();
//
//                 // Update stats
//                 document.getElementById('ybh-account-balance').textContent = data.accountBalance || '29,00€';
//                 document.getElementById('ybh-total-gifts').textContent = data.stats?.totalGifts || '21,00€';
//                 document.getElementById('ybh-total-sales').textContent = data.stats?.totalSales || '263,12€';
//                 document.getElementById('ybh-avg-basket').textContent = data.stats?.avgBasket || '32,18€';
//                 document.getElementById('ybh-order-count').textContent = data.stats?.orderCount || '7';
//                 document.getElementById('ybh-pending-ngo').textContent = data.stats?.pendingNgo || '7';
//
//                 // Populate table
//                 const tbody = document.getElementById('ybh-orders-tbody');
//                 tbody.innerHTML = '';
//
//                 const orders = data.transactions || [];
//                 orders.forEach(order => {
//                     const row = document.createElement('tr');
//                     row.innerHTML = `
//                             <td>${order.id}</td>
//                             <td>${order.order_number}</td>
//                             <td>${order.date}</td>
//                             <td>${order.total}</td>
//                             <td>${order.donation}</td>
// <!--                            <td><a href="#" class="ybh-order-link">${order.org}</a></td>-->
//                         `;
//                     tbody.appendChild(row);
//                 });
//
//                 // Show table, hide empty state
//                 document.getElementById('ybh-orders-section').classList.add('ybh-show-table');
//                 isDataLoaded = true;
//
//             } catch (error) {
//                 console.error('Failed to load data:', error);
//                 alert('Σφάλμα κατά τη φόρτωση των δεδομένων. Παρακαλώ δοκιμάστε ξανά.');
//             } finally {
//                 // Reset button
//                 refreshBtn.innerHTML = '🔄 Ανανέωση';
//                 refreshBtn.disabled = false;
//             }
//         }
//     }
</script>