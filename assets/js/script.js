jQuery(document).ready(function($) {
        if (!window.ybh_donation_checkout_params || typeof ybh_donation_checkout_params !== 'object') {
            return;
        }

        const { causes, amounts, selected_amount } = ybh_donation_checkout_params || {};

        // Populate causes and amounts
        const $causeSelect = jQuery('#donation-cause');
        const $amountsContainer = jQuery('#donation-amounts');
        let currencyCode = wcSettings?.currency?.code || 'USD';
        let currencySymbol = wcSettings?.currency?.symbol || '$';

        // Store pending donation amount when clicked without org selected
        let pendingDonationAmount = null;
        let pendingDonationLabel = null;
        let pendingDonationButton = null;

        // Hide "Please select a cause" option if a nonprofit is already selected
        const donationCauseEle = jQuery('#donation-cause');
        if (donationCauseEle.length && donationCauseEle.val() && donationCauseEle.val() != '0' && donationCauseEle.val() != '') {
            jQuery('#select-np-ybh-dd-option').addClass('hidden');
        }

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

                let updatedFees = [];

                if (Array.isArray(currentCart.fees)) {
                    updatedFees = currentCart.fees.filter((fee) => {
                        return !fee.name.includes('Donation for');
                    });
                }

                // Only add donation fee if amount > 0 and orgId is valid
                if (amount > 0 && orgId && orgId !== '0' && orgId !== 0) {
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
                }

                await wp.data.dispatch('wc/store/cart').setCartData({
                    ...currentCart,
                    fees: updatedFees
                });

                const amountF = isNaN(Number(amount)) ? 0 : Number(amount)/100;
                const force_remove = isNaN(Number(orgId)) || orgId === '0' || orgId === 0 ? 1 : 0;
                
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
                        if (jQuery('form.checkout').length) {
                            // Listen for checkout update completion
                            let reEnabled = false;
                            jQuery(document.body).one('updated_checkout', function() {
                                if (!reEnabled) {
                                    reEnabled = true;
                                    setButtonLoading(jQuery('.donation-btn.loading'), false);
                                }
                            });
                            
                            // Add a delay to ensure session is fully committed on server
                            // This is critical - WooCommerce's update_order_review needs the session to be set
                            const triggerDelay = 1200;
                            setTimeout(function() {
                                jQuery(document.body).trigger('update_checkout');
                            }, triggerDelay);
                            
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
                    }
                });
                return true;

            } catch (error) {
                // Re-enable buttons on error
                setButtonLoading(jQuery('.donation-btn.loading'), false);
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
                // Invalidate the current cart data resolution
                await wp.data.dispatch('wc/store/cart').invalidateResolution('getCartData');
              } catch (error) {
                // Re-enable buttons on error
                setButtonLoading(jQuery('.donation-btn.loading'), false);
              } finally {
                // Hide the loader after the operations are complete
                // Re-enable buttons after totals update (if not already handled)
                if (jQuery('.donation-btn.loading').length > 0 && !jQuery('form.checkout').length) {
                    setButtonLoading(jQuery('.donation-btn.loading'), false);
                }
              }
        };
        
        function add_donation_to_cart(){
            const orgId = jQuery('#donation-cause').val();
            const amount = jQuery('#donation-amount').val();

            const selectedCause = causes.find(cause =>cause.value === parseInt(orgId));
            const orgName = selectedCause ? selectedCause.label : '';
            const orgImg = selectedCause ? selectedCause.image : '';
            const numericAmount = parseFloat(amount);
            
            addDonationFee( orgId, orgName, numericAmount, orgImg );
        }

        function validate_donation_data(){
            // Handle single org case - but only set values if they're empty (initial load)
            // Don't override values that user has explicitly set or cleared
            if(jQuery('.ybh-dd-option').length == 1) {
                const singleCauseEle = document.getElementById('donation-cause');
                const singleCauseamount = document.getElementById('donation-amount');
                
                // Only set org value if it's empty or 0 (initial load)
                if (!singleCauseEle.value || singleCauseEle.value == '0') {
                    singleCauseEle.value = jQuery('.ybh-dd-option').data("value");
                }
                
                // Only set amount value if it's empty AND there's a selected button
                // This prevents overriding user's explicit selection/clearing
                if (!singleCauseamount.value) {
                    const selectedAmount = jQuery('.donation-amounts .radio-button.selected').data('value');
                    if (selectedAmount) {
                        singleCauseamount.value = selectedAmount;
                    }
                }
            }

            const donation_cause = jQuery('#donation-cause').val();
            const donation_amount = jQuery('#donation-amount').val();

            if( !donation_amount ){
                return false;
            }
            if( !donation_cause ){
                return false;
            }
            return true;
        }

        // Handle dynamic updates
        $('#donation-amount').change(function() {
            const donation_amount = jQuery(this).val();
            const donation_cause = jQuery('#donation-cause').val();

            if ( validate_donation_data() ) {
                add_donation_to_cart( );
            }
        });

        $('#donation-cause').change(function() {
            const donation_cause = jQuery(this).val();
            const donation_amount = jQuery('#donation-amount').val();

            if ( validate_donation_data() ) {
                add_donation_to_cart( );
            }
        });

        $(document).on('click', '#ybh-dd-select', function () {
            if( jQuery('#dropdownMenu').hasClass('show') ){
                jQuery('#dropdownMenu').removeClass('show');
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

        // Auto-select first organization on page load (if multiple orgs exist and none selected)
        setTimeout(function(){
            if (causes && causes.length > 1) {
                const donationCauseEle = jQuery('#donation-cause');
                const selectedOption = jQuery('#selectedOption');
                
                // Check if no org is selected (value is 0 or empty, or text is "Please select a cause")
                const hasNoOrg = !donationCauseEle.val() || 
                                 donationCauseEle.val() == '0' || 
                                 selectedOption.text() === 'Please select a cause' ||
                                 selectedOption.text() === jQuery('#select-np-ybh-dd-option').data('text');
                
                if (hasNoOrg) {
                    // Auto-select first org (skip the "Please select" option)
                    const firstOrgOption = jQuery('.ybh-dd-option').not('#select-np-ybh-dd-option').first();
                    if (firstOrgOption.length) {
                        firstOrgOption.trigger('click');
                    }
                }
            }
        }, 300);

        $(document).on('click', '.ybh-dd-option', function (event) {
            event.preventDefault();
            const selectedOption = document.getElementById('selectedOption');
            const donationCauseEle = document.getElementById('donation-cause');
            const causeImgEle = document.getElementById('selected-cause-img');

            $('#dropdownMenu').removeClass('show');
            selectedOption.textContent = $(this).data("text");
            donationCauseEle.value = $(this).data("value");
            causeImgEle.src = $(this).data("image");
            
            // Hide "Please select a cause" option when a nonprofit is selected
            if( $(this).data("value") && $(this).data("value") != 0 ){
                $('#select-np-ybh-dd-option').addClass('hidden');
                // Remove rainbow glow animation when org is selected
                jQuery('#ybh-dd-select').removeClass('animate-rainbow-glow');
                
                // Auto-apply pending donation amount if one was stored
                let wasPendingApplied = false;
                if (pendingDonationAmount !== null && pendingDonationButton !== null) {
                    // Show loading spinner on the button (consistent with normal flow)
                    setButtonLoading(pendingDonationButton, true);
                    
                    // Set the amount value
                    jQuery('#donation-amount').val(pendingDonationAmount);
                    jQuery('.donation-amount-text').text(pendingDonationLabel + currencySymbol);
                    
                    // Update button states
                    jQuery('.donation-amounts .radio-button').removeClass('selected');
                    pendingDonationButton.addClass('selected');
                    
                    // Mark that we applied pending amount
                    wasPendingApplied = true;
                    
                    // Store button reference before clearing pending values (needed for spinner removal)
                    const buttonToUpdate = pendingDonationButton;
                    
                    // Clear pending values
                    pendingDonationAmount = null;
                    pendingDonationLabel = null;
                    pendingDonationButton = null;
                    
                    // Now that both org and amount are set, add to cart
                    // The spinner will be removed by the AJAX success handler
                    if (validate_donation_data()) {
                        add_donation_to_cart();
                    } else {
                        // Re-enable if validation fails
                        setButtonLoading(buttonToUpdate, false);
                    }
                }
                
                // Only update cart if amount is already selected (user has committed to donating)
                // This prevents auto-add when only org is selected, but updates when org changes
                // Skip if we just auto-applied a pending amount (already handled above)
                if (!wasPendingApplied) {
                    const donation_amount = jQuery('#donation-amount').val();
                    if ( donation_amount && validate_donation_data() ) {
                        add_donation_to_cart( );
                    }
                }
            }else{
                $('#select-np-ybh-dd-option').removeClass('hidden');
            }
        });

        // Close the dropdown if clicked outside
        jQuery(document).on('click', function(event) {
            if (!jQuery(event.target).closest('.custom-dropdown-toggle').length) {
                jQuery('.custom-dropdown-menu.show').removeClass('show');
            }
        });
        
        jQuery('.donation-amounts .radio-button:checked').trigger('click');
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
            
            // Check if organization is selected before allowing amount selection
            const donationCauseEle = jQuery('#donation-cause');
            const selectedOption = jQuery('#selectedOption');
            const hasNoOrg = !donationCauseEle.val() || 
                            donationCauseEle.val() == '0' || 
                            selectedOption.text() === 'Please select a cause' ||
                            selectedOption.text() === jQuery('#select-np-ybh-dd-option').data('text');
            
            if (hasNoOrg) {
                // Store the amount for later auto-application when org is selected
                const donation_amount = jQueryBtn.data('value');
                const donation_label = jQueryBtn.data('label');
                
                pendingDonationAmount = donation_amount;
                pendingDonationLabel = donation_label;
                pendingDonationButton = jQueryBtn;
                
                // Show visual feedback (animation only, no dropdown pop)
                const $dropdown = jQuery('#ybh-dd-select');
                
                // Add rainbow glow animation
                $dropdown.addClass('animate-rainbow-glow');
                
                // Remove animation class after animation completes (shake is 0.3s, glow is longer)
                setTimeout(function() {
                    $dropdown.removeClass('animate-rainbow-glow');
                }, 3000);
                
                // Don't open dropdown - just show animation to guide user
                // User can click dropdown when ready
                
                return false;
            }
            
            // Disable buttons and show spinner
            setButtonLoading(jQueryBtn, true);
            
            const donation_amount = jQueryBtn.data('value');
            const donation_label = jQueryBtn.data('label');

            // Use jQuery to set the value for consistency (matches how it's read in validate_donation_data)
            jQuery('#donation-amount').val(donation_amount);

            jQuery('.donation-amount-text').text(donation_label + currencySymbol);
            jQuery('.donation-amounts .radio-button').removeClass('selected');
            jQueryBtn.addClass('selected');
            
            // Direct call to update cart (change handler is for other scenarios like manual input)
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
            
            // Clear pending donation amount if exists
            pendingDonationAmount = null;
            pendingDonationLabel = null;
            pendingDonationButton = null;
            
            // Disable buttons and show spinner
            setButtonLoading(jQueryBtn, true);
            
            const donationAmountEle = document.getElementById('donation-amount');
            donationAmountEle.value = '';
            jQuery('.donation-amount-text').text('0,00' + currencySymbol);
            jQuery('.donation-amounts .radio-button').removeClass('selected');
            jQuery('#donation-amount').trigger('change');

            // Select "Please select a cause" option when amount is deleted
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
        
        if (selected_amount && selected_amount > 0) {
            let selected_amount_cents = selected_amount * 100;
            const currentAmount = jQuery('#donation-amount').val();
            const currentCause = jQuery('#donation-cause').val();
            
            // Only auto-click if:
            // 1. No amount is currently set in the input
            // 2. No org is selected (or org is '0')
            // This prevents auto-clicking when user has explicitly cleared everything
            if (!currentAmount && (!currentCause || currentCause == '0')) {
                if (jQuery(`button[data-value="${selected_amount_cents}"]`).length) {
                    jQuery(`button[data-value="${selected_amount_cents}"]`).click();
                }
            }
        }
});


const YBH_CHECKOUT_STORE_KEY = 'wc/store/checkout';

function YBHupdateCheckoutBlockData( values ) {
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
        if (
                window.wp && window.wp.data && typeof window.wp.data.subscribe === 'function'
        ) {
                // Update checkout block data once more if the checkout store was loaded after this script.
                const unsubscribe = window.wp.data.subscribe( function () {
                        unsubscribe();
                        // Check if wc_order_attribution exists before calling it
                        if ( typeof wc_order_attribution !== 'undefined' && wc_order_attribution && typeof wc_order_attribution.getAttributionData === 'function' ) {
                                YBHupdateCheckoutBlockData( wc_order_attribution.getAttributionData() );
                        }
                }, YBH_CHECKOUT_STORE_KEY );
        }
};
