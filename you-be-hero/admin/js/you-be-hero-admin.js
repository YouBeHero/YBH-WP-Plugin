(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 */
	 $(function() {

		 $('body').append(`
			<div class="ybh-fullpage-loading" style="display:none;">
				<span class="spinner is-active"></span>
			</div>
		 `);

		 document.getElementById('fetch-token')?.addEventListener('click', function() {
			 let button = this;
			 button.disabled = true;
			 document.getElementById('token-status').innerText = "Fetching token...";

			 fetch(ajaxurl+'?action=ybh_get_token', {
				 method: 'POST',
				 headers: { 'Content-Type': 'application/json' }
			 })
				 .then(response => response.json())
				 .then(data => {
					 if (data.success) {
						 document.getElementById('token-status').innerText = "Token received successfully! Reloading...";
						 setTimeout(() => location.reload(), 2000);
					 } else {
						 document.getElementById('token-status').innerText = "Error: " + data.message;
						 button.disabled = false;
					 }
				 })
				 .catch(error => {
					 document.getElementById('token-status').innerText = "Failed to fetch token.";
					 button.disabled = false;
				 });
		 });

		 document.getElementById('ybh_logout')?.addEventListener('click', function() {

			 try {
				 //server side update
				 $.ajax({
					 type: 'POST',
					 url: ajaxurl,
					 data: {
						 action: 'ybh_logout',
					 },
					 success: function(response) {
						 if ( response.status == 'success' ) {
							 let url = new URL(window.location.href);
							 url.searchParams.set('logout', 'yes'); // Set or update parameter
							 window.location.href = url.toString();
						 }
					 }
				 });

			 } catch (error) {
				 throw error;
			 }
		 });

		 /**
		  *
		  */
		 document.getElementById('ybh-refresh-btn')?.addEventListener('click', function() {

			 $('.ybh-fullpage-loading').show();
			 ybhRefreshData()

		 });


		 let isDataLoaded = false;

		 async function ybhFetchData() {

			 try {
				 let data;
				 //server side update
				 $.ajax({
					 type: 'POST',
					 url: ajaxurl,
					 data: {
						 action: 'ybh_update_dashboard_json',
					 },
					 success: function(response) {
						 // const result = response.json();
						 // console.log(response)
						 // data = response.data;

						 // console.log(data.status)
						 if ( response.status == 'success' ) {
							 location.reload();
						 }
						 // Update stats
	// 					 document.getElementById('ybh-account-balance').textContent = data.account_balance || '0,00€';
	// 					 document.getElementById('ybh-total-gifts').textContent = data.stats?.totalGifts || '-';
	// 					 document.getElementById('ybh-total-sales').textContent = data.stats?.totalSales || '-';
	// 					 document.getElementById('ybh-avg-basket').textContent = data.stats?.avgBasket || '-';
	// 					 document.getElementById('ybh-order-count').textContent = data.stats?.orderCount || '-';
	// 					 document.getElementById('ybh-pending-ngo').textContent = data.stats?.pendingNgo || '-';
	//
	// 					 // Populate table
	// 					 const tbody = document.getElementById('ybh-orders-tbody');
	// 					 tbody.innerHTML = '';
	//
	// 					 const orders = data.transactions || [];
	// 					 orders.forEach(order => {
	// 						 const row = document.createElement('tr');
	// 						 row.innerHTML = `
	// 							<td>${order.id}</td>
	// 							<td>${order.order_number}</td>
	// 							<td>${order.date}</td>
	// 							<td>${order.total}</td>
	// 							<td>${order.donation}</td>
	// <!--                            <td><a href="#" class="ybh-order-link">${order.org}</a></td>-->
	// 						`;
	// 						 tbody.appendChild(row);
	// 					 });
	//
	// 					 // Show table, hide empty state
	// 					 document.getElementById('ybh-orders-section').classList.add('ybh-show-table');
					 }
				 });
				 return data;

			 } catch (error) {
				 throw error;
			 }
		 }

		 async function ybhRefreshData() {

			 if (!isDataLoaded) {
				 // Show loading state
				 const refreshBtn = document.querySelector('.ybh-refresh-btn');
				 // refreshBtn.innerHTML = '⏳ Φόρτωση...';

				 refreshBtn.disabled = true;

				 try {
					 const data = await ybhFetchData();
					 isDataLoaded = true;

				 } catch (error) {
					 // console.error('Failed to load data:', error);
					 // alert('Σφάλμα κατά τη φόρτωση των δεδομένων. Παρακαλώ δοκιμάστε ξανά.');
				 } finally {
					 // Reset button
					 // refreshBtn.innerHTML = '🔄 Ανανέωση';
					 refreshBtn.disabled = false;
				 }
			 }
		 }

	 });
	 /*
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
