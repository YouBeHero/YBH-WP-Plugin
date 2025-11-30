jQuery(document).ready(function($) {

    if (!$('form.checkout').length) {
        const $content = $('.elementor'); // or your specific wrapper
        if ($content.length) {
            $content.wrapInner('<form name="checkout" class="checkout woocommerce-checkout" method="post"></form>');
        }
    }
    
        if (!window.ybh_donation_checkout_params || typeof ybh_donation_checkout_params !== 'object') {
            console.error('ybh_donation_checkout_params is not defined or not an object');
            return;
        }


        // Minimal long-press detection - only toggles a class
        // CSS handles all the styling via :hover, :active, and .selected states
        
        $(document).on('touchstart', '.donation-btn', function(e) {
            const $btn = $(this);
            
            // Clear any existing timer
            if ($btn.data('touchTimer')) {
                clearTimeout($btn.data('touchTimer'));
            }
            
            // Start timer for long press (500ms)
            const timer = setTimeout(function() {
                $btn.addClass('long-pressed');
            }, 500);
            
            $btn.data('touchTimer', timer);
        });

        $(document).on('touchend touchcancel touchmove', '.donation-btn', function(e) {
            const $btn = $(this);
            
            // Clear timer
            if ($btn.data('touchTimer')) {
                clearTimeout($btn.data('touchTimer'));
                $btn.removeData('touchTimer');
            }
            
            // If it was a long press, remove the class on release
            // This allows normal tap to work again
            if ($btn.hasClass('long-pressed')) {
                // Remove class after a brief delay to show the state change
                setTimeout(function() {
                    $btn.removeClass('long-pressed');
                }, 100);
            }
        });

        // Handle click to remove long-pressed state if present
        $(document).on('click', '.donation-btn', function(e) {
            const $btn = $(this);
            if ($btn.hasClass('long-pressed')) {
                $btn.removeClass('long-pressed');
            }
        });

        const { causes, amounts, selected_amount } = ybh_donation_checkout_params || {};

        // Populate causes and amounts
        const $causeSelect = $('#donation-cause');
        const $amountsContainer = $('#donation-amounts');
        let currencyCode = wcSettings?.currency?.code || 'USD';
        let currencySymbol = wcSettings?.currency?.symbol || '$';

        // Hide "Please select a nonprofit organization" option if a nonprofit is already selected
        jQuery(document).ready(function() {
            const donationCauseEle = document.getElementById('donation-cause');
            if (donationCauseEle && donationCauseEle.value && donationCauseEle.value != '0' && donationCauseEle.value != '') {
                jQuery('#select-np-ybh-dd-option').addClass('hidden');
            }
        });

        // Helper function to set button loading state
        function setButtonLoading(jQueryButton, isLoading) {
            if (isLoading) {
                if (!jQueryButton.find('.button-spinner').length) {
                    jQueryButton.prepend('<span class="button-spinner"></span>');
                }
                jQueryButton.addClass('loading');
                jQuery('.donation-buttons, .donation-amounts').addClass('disabled');
            } else {
                jQueryButton.removeClass('loading').find('.button-spinner').remove();
                jQuery('.donation-buttons, .donation-amounts').removeClass('disabled');
            }
        }

        const addDonationFee = async (orgId, orgName, amount, orgImg) => {
            try {
                // 1. Get current cart state
                const { getCartData } = wp.data.select('wc/store/cart');
                const currentCart = getCartData();

                    console.log( orgId, orgName, amount )

                let updatedFees = [];

                if (Array.isArray(currentCart.fees)) {
                    updatedFees = currentCart.fees.filter((fee) => {
                        return !fee.name.includes('Donation for');
                    });
                }

                updatedFees.push({
                    name: `Donation for ${orgName}`,
                    totals: {
                        currency_code: currencyCode,
                        currency_minor_unit: 2,
                        total: Math.round(amount).toString(),
                        total_tax: '0'
                    },
                    meta_data: [
                        { key: '_donation_org_id', value: orgId },
                        { key: '_donation_org_name', value: orgName }
                    ]
                });

                await wp.data.dispatch('wc/store/cart').setCartData({
                    ...currentCart,
                    fees: updatedFees
                });

                //Store HTML for widget AJAX
                let wrapper = $('.youbehero-donation-wrapper');
                if (!wrapper.length) {
                    wrapper  = $('.youbehero-donation-widget');
                }
                // if (!wrapper.length) return;
                if (wrapper.length) {
                    var html = wrapper.prop('outerHTML');
                    // Create hidden div if not already present
                    if (!$('#hidden-donation-html').length) {
                        $('body').append('<div id="hidden-donation-html" style="display:none;"></div>');
                    }
                    // Store the HTML in the hidden div
                    $('#hidden-donation-html').text(html);

                    console.log('incond',$('#hidden-donation-html').text() )
                }
                //Store HTML for widget AJAX - End

                // showLoader();
                const amountF = isNaN(Number(amount)) ? 0 : Number(amount)/100;
                const force_remove = isNaN(Number(orgId)) ? 1 : 0;
                //server side update
                $.ajax({
                    type: 'POST',
                    url: ybh_donation_checkout_params.ajax_url,
                    data: {
                        action: 'update_donation_fee',
                        nonce: ybh_donation_checkout_params.nonce,
                        org_id: orgId,
                        amount: amountF,
                        org_name: orgName,
                        org_img: orgImg,
                        force_remove: force_remove,
                        meta_data: [
                            { key: '_donation_org_id', value: orgId },
                            { key: '_donation_org_name', value: orgName },
                            { key: '_donation_org_img', value: orgImg }
                        ]
                    },
                    success: function(response) {
                        console.log('Donation added successfully!');

                        if (jQuery('form.checkout').length) {
                            // Listen for checkout update completion
                            let reEnabled = false;
                            jQuery(document.body).one('updated_checkout', function() {
                                if (!reEnabled) {
                                    reEnabled = true;
                                    setButtonLoading(jQuery('.donation-btn.loading'), false);
                                }
                            });
                            jQuery(document.body).trigger('update_checkout');
                            
                            // Fallback: re-enable after 3 seconds if event doesn't fire
                            setTimeout(function() {
                                if (!reEnabled) {
                                    reEnabled = true;
                                    setButtonLoading(jQuery('.donation-btn.loading'), false);
                                }
                            }, 3000);
                        } else {
                            // For non-checkout contexts, re-enable after totals update
                            update_totals().then(function() {
                                setButtonLoading(jQuery('.donation-btn.loading'), false);
                            }).catch(function() {
                                setButtonLoading(jQuery('.donation-btn.loading'), false);
                            });
                        }
                    },
                    error: function() {
                        // Re-enable buttons on error
                        setButtonLoading(jQuery('.donation-btn.loading'), false);
                        // hideLoader();
                    }
                });
                console.log('Donation process ends!');
                return true;

            } catch (error) {
                console.error('Donation error:', error);
                // Re-enable buttons on error
                setButtonLoading(jQuery('.donation-btn.loading'), false);
                // hideLoader();
                //show elegant notice update this
                wp.data.dispatch('core/notices').createNotice(
                    'error',
                    `Failed to add donation: ${error.message}`,
                    { id: 'donation-error' }
                );
                throw error;
            }
        };
        
        const update_totals = async () => {
            
            try {
                // showLoader();
                // Invalidate the current cart data resolution
                await wp.data.dispatch('wc/store/cart').invalidateResolution('getCartData');
              } catch (error) {
                console.error('Error updating cart totals:', error);
                // Re-enable buttons on error
                setButtonLoading(jQuery('.donation-btn.loading'), false);
              } finally {
                // Hide the loader after the operations are complete
                // hideLoader();
                // Re-enable buttons after totals update (if not already handled)
                if (jQuery('.donation-btn.loading').length > 0 && !jQuery('form.checkout').length) {
                    setButtonLoading(jQuery('.donation-btn.loading'), false);
                }
              }
        };
        
        function add_donation_to_cart(){
            const orgId = $('#donation-cause').val();
            const amount = $('#donation-amount').val();
            console.log( 'add_donation_to_cart', 'orgId: ', orgId )

            const selectedCause = causes.find(cause =>cause.value === parseInt(orgId));
            const orgName = selectedCause ? selectedCause.label : '';
            const orgImg = selectedCause ? selectedCause.image : '';
            const numericAmount = parseFloat(amount);
            addDonationFee( orgId, orgName, numericAmount, orgImg );
        }

        function validate_donation_data(){

            if($('.ybh-dd-option').length == 1) {
                const singleCauseEle = document.getElementById('donation-cause');
                const singleCauseamount = document.getElementById('donation-amount');
                singleCauseEle.value = $('.ybh-dd-option').data("value");
                singleCauseamount.value = $('.donation-amounts .radio-button.selected').data('value');
            }

            const donation_cause = $('#donation-cause').val();
            const donation_amount = $('#donation-amount').val();

            if( !donation_amount ){
                console.log('Please select amount to donate');
                return false;
            }
            if( !donation_cause ){
                console.log('Please select cause to donate');
                return false;
            }
            return true;
        }

        // Handle dynamic updates
        $('#donation-amount').change(function() {
            const donation_amount = $(this).val();
            const donation_cause = $('#donation-cause').val();

            if ( validate_donation_data() ) {
                add_donation_to_cart( );
            }
        });

        $('#donation-cause').change(function() {
            const donation_cause = $(this).val();
            const donation_amount = $('#donation-amount').val();

            if ( validate_donation_data() ) {
                add_donation_to_cart( );
            }
        });

        $(document).on('click', '#ybh-dd-select', function () {
            console.log( $(this).attr('class'),$('#dropdownMenu').hasClass('show'));
            if( $('#dropdownMenu').hasClass('show') ){
                $('#dropdownMenu').removeClass('show');
            }else{
                setTimeout(function(){
                    $('#dropdownMenu').addClass('show');
                },100);
            }
        });

        // Handle if only one organisation is set - START
        setTimeout(function(){
            if (causes && causes.length == 1) {
                $('.ybh-dd-option').trigger('click')

                $('.ybh-dd-option').css({
                    'display': 'flex',
                    'align-items': 'center',
                    'gap': '8px'
                });

                $('.ybh-dd-option img').css({
                    'max-height': '40px',
                    'width': 'auto',
                    'vertical-align': 'middle'
                });

                $('.ybh-dd-option span').css({
                    'font-size': '14px',
                    'line-height': '1.4'
                });
            }
        },1000);
    // Handle if only one organisation is set - END

        $(document).on('click', '.ybh-dd-option', function (event) {
            event.preventDefault();
            const selectedOption = document.getElementById('selectedOption');
            const donationCauseEle = document.getElementById('donation-cause');
            const causeImgEle = document.getElementById('selected-cause-img');

            $('#dropdownMenu').removeClass('show');
            selectedOption.textContent = $(this).data("text");
            console.log('Selected Value:', $(this).data("value"));
            donationCauseEle.value = $(this).data("value");
            causeImgEle.src = $(this).data("image");
            
            // Hide "Please select a nonprofit organization" option when a nonprofit is selected
            if( $(this).data("value") && $(this).data("value") != 0 ){
                $('#select-np-ybh-dd-option').addClass('hidden');
            }else{
                $('#select-np-ybh-dd-option').removeClass('hidden');
            }
            if ( validate_donation_data() ) {
                add_donation_to_cart( );
            }
        });

        // Close the dropdown if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.custom-dropdown-toggle')) {
                const dropdowns = document.querySelectorAll('.custom-dropdown-menu');
                dropdowns.forEach(dropdown => {
                    if (dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                    }
                });
            }
        };
        
        $('.donation-amounts .radio-button:checked').trigger('click');
        jQuery(document).on('click', '.donation-amounts .radio-button', function (event) {
            event.preventDefault();
            const jQueryBtn = jQuery(this);
            
            // Do nothing if button is already selected
            if (jQueryBtn.hasClass('selected')) {
                return;
            }
            
            // Prevent if already loading
            if (jQueryBtn.hasClass('loading')) {
                return;
            }
            
            // Disable buttons and show spinner
            setButtonLoading(jQueryBtn, true);
            
            const donation_amount = jQueryBtn.data('value');
            const donation_label = jQueryBtn.data('label');

            const donationAmountEle = document.getElementById('donation-amount');
            donationAmountEle.value = donation_amount;

            jQuery('.donation-amount-pill').text(donation_label + currencySymbol);
            jQuery('.donation-amounts .radio-button').removeClass('selected');
            jQueryBtn.addClass('selected');
            jQuery('.donation-amounts .donation-amount').change();
            
            if ( validate_donation_data() ) {
                add_donation_to_cart( );
            } else {
                // Re-enable if validation fails
                setButtonLoading(jQueryBtn, false);
            }
        });
        
        jQuery(document).on('click', '.donation-amounts .delete-button', function (event) {
            event.preventDefault();
            const jQueryBtn = jQuery(this);
            
            // Prevent if already loading
            if (jQueryBtn.hasClass('loading')) {
                return;
            }
            
            // Disable buttons and show spinner
            setButtonLoading(jQueryBtn, true);
            
            const donationAmountEle = document.getElementById('donation-amount');
            donationAmountEle.value = '';
            jQuery('.donation-amount-pill').text('0,00' + currencySymbol);
            jQuery('.donation-amounts .radio-button').removeClass('selected');
            jQuery('.donation-amounts .donation-amount').change();

            // Select "Please select a nonprofit organization" option when amount is deleted
            const selectedOption = document.getElementById('selectedOption');
            const donationCauseEle = document.getElementById('donation-cause');
            const causeImgEle = document.getElementById('selected-cause-img');
            const selectNpOption = jQuery('#select-np-ybh-dd-option');
            
            if (selectNpOption.length) {
                donationCauseEle.value = '0';
                selectedOption.textContent = selectNpOption.data('text');
                causeImgEle.src = selectNpOption.data('image');
                selectNpOption.removeClass('hidden');
            }

            add_donation_to_cart();
        });

        // Show the loader
        function showLoader() {
          const loader = document.getElementById('widget-loader');
          const bar = loader.querySelector('.widget-loader-bar');
          loader.classList.remove('hidden');
          bar.style.width = '0%';
          setTimeout(() => {
            bar.style.width = '100%';
          }, 10); // Slight delay to trigger transition
        }

        // Hide the loader
        function hideLoader() {
          const loader = document.getElementById('widget-loader');
          const bar = loader.querySelector('.widget-loader-bar');
          bar.style.width = '100%';
          setTimeout(() => {
            loader.classList.add('hidden');
            bar.style.width = '0%';
          }, 500); // Wait for the transition to complete
        }
        
        console.log( 'selected_amount: ', selected_amount);
        let selected_amount_cents = selected_amount * 100;
        if(  $(`button[data-value="${selected_amount_cents}"]`).length )//let's check if there is any current selected amount
            $(`button[data-value="${selected_amount_cents}"]`).click();
});


const YBH_CHECKOUT_STORE_KEY = 'wc/store/checkout';

function YBHupdateCheckoutBlockData( values ) {
    console.log('YBHupdateCheckoutBlockData');
        // Update Checkout block data if available.
        if ( window.wp && window.wp.data && window.wp.data.dispatch && window.wc && window.wc.wcBlocksData ) {
                window.wp.data.dispatch( window.wc.wcBlocksData.YBH_CHECKOUT_STORE_KEY ).__internalSetExtensionData(
                        'donation-widget/ybh-chekcout-donation',
                        values,
                        true
                );
        }
}
function YBHeventuallyInitializeCheckoutBlock() {
    console.log('YBHeventuallyInitializeCheckoutBlock', window.wp && window.wp.data && typeof window.wp.data.subscribe === 'function');
    console.log(window.wp.data.subscribe);
        if (
                window.wp && window.wp.data && typeof window.wp.data.subscribe === 'function'
        ) {
                // Update checkout block data once more if the checkout store was loaded after this script.
                const unsubscribe = window.wp.data.subscribe( function () {
                        unsubscribe();
                        YBHupdateCheckoutBlockData( wc_order_attribution.getAttributionData() );
                }, YBH_CHECKOUT_STORE_KEY );
        }
};
