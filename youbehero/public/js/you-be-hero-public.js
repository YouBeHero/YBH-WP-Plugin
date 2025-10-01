(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 */
	 $(function() {
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
    jQuery(document).ready(function($) {
	});

	document.addEventListener("DOMContentLoaded", function () {
		const modal = document.getElementById("youbehero-modal");
		if (!modal) {
			return;
		}
		const btn = document.getElementById("learn-more-btn");
		const closeX = document.querySelector(".youbehero-close");
		const closeBtn = document.querySelector(".youbehero-close-btn");

		if (!modal || !btn || !closeX || !closeBtn) {
			console.error("Modal elements not found in DOM");
			return;
		}

		// Open modal
		btn.onclick = function () {
			modal.style.display = "block";
		};

		// Close modal on X
		closeX.onclick = function () {
			modal.style.display = "none";
		};

		// Close modal on Κλείσιμο button
		closeBtn.onclick = function () {
			modal.style.display = "none";
		};

		// Close if clicking outside the modal content
		window.onclick = function (e) {
			if (e.target === modal) {
				modal.style.display = "none";
			}
		};
	});

})( jQuery );
