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

		 document.getElementById('ybhd_logout')?.addEventListener('click', function() {

			 try {
				 //server side update
				 $.ajax({
					 type: 'POST',
					 url: ajaxurl,
					 data: {
						 action: 'ybhd_logout',
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
						 if ( response.status == 'success' ) {
							 location.reload();
						 }
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
