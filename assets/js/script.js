// Floating Hearts Animation - Vanilla JS Implementation
(function() {
    'use strict';
    
    // State management for floating hearts
    const floatingHeartsState = {
        heartKeyCounter: 0,
        animationIdCounter: 0,
        activeTimeouts: new Map(),
        lastHeartTime: new Map(),
        HEART_DEBOUNCE_MS: 1500 // 1.5 seconds debounce
    };
    
    /**
     * Parse RGB color string to get individual RGB values
     * @param {string} colorString - Color string (rgb(r,g,b) or hex)
     * @returns {Object} Object with r, g, b values
     */
    function parseColor(colorString) {
        let baseR = 131, baseG = 32, baseB = 189; // Default purple (#8320bd)
        
        // Try to parse RGB format
        const rgbMatch = colorString.match(/\d+/g);
        if (rgbMatch && rgbMatch.length >= 3) {
            baseR = parseInt(rgbMatch[0]);
            baseG = parseInt(rgbMatch[1]);
            baseB = parseInt(rgbMatch[2]);
        } else {
            // Try to parse hex format
            const hexMatch = colorString.match(/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i);
            if (hexMatch) {
                baseR = parseInt(hexMatch[1], 16);
                baseG = parseInt(hexMatch[2], 16);
                baseB = parseInt(hexMatch[3], 16);
            }
        }
        
        return { r: baseR, g: baseG, b: baseB };
    }
    
    /**
     * Trigger floating hearts animation
     * @param {string|number} elementId - Unique identifier for the element
     * @param {HTMLElement} elementRef - The button element that was clicked
     * @param {string} baseColor - Base color for hearts (default: '#8320bd')
     */
    function triggerFloatingHearts(elementId, elementRef, baseColor) {
        const now = Date.now();
        const lastTime = floatingHeartsState.lastHeartTime.get(elementId) || 0;
        const timeSinceLastHeart = now - lastTime;
        
        // Debounce: only prevent the same element from being triggered rapidly
        if (timeSinceLastHeart < floatingHeartsState.HEART_DEBOUNCE_MS) {
            return;
        }
        
        floatingHeartsState.lastHeartTime.set(elementId, now);
        
        // Find the container (donation-box-container)
        const container = elementRef.closest('.donation-box-container');
        if (!container) {
            return;
        }
        
        // Find or create hearts container
        let heartsContainer = container.querySelector('.hearts-container');
        if (!heartsContainer) {
            heartsContainer = document.createElement('div');
            heartsContainer.className = 'hearts-container';
            container.insertBefore(heartsContainer, container.firstChild);
        }
        
        const elementRect = elementRef.getBoundingClientRect();
        const containerRect = container.getBoundingClientRect();
        
        // Parse RGB color to get individual values
        const colorValues = parseColor(baseColor || '#8320bd');
        const { r: baseR, g: baseG, b: baseB } = colorValues;
        
        // Calculate position relative to container
        const baseX = elementRect.left + elementRect.width / 2 - containerRect.left;
        const baseY = elementRect.top + elementRect.height / 2 - containerRect.top;
        
        const heartCount = 6;
        const animationId = floatingHeartsState.animationIdCounter++;
        
        // Create new hearts with unique animation ID and randomized properties
        for (let i = 0; i < heartCount; i++) {
            // Randomize position horizontally within ±10px of element center
            const positionOffsetX = (Math.random() - 0.5) * 20; // -10px to +10px
            // Position hearts only from the top of the element (negative Y offset)
            const positionOffsetY = -elementRect.height / 2 - Math.random() * 10; // Start from top, random 0-10px above
            
            // Random size between 12px and 24px
            const size = 12 + Math.random() * 12;
            
            // Random rotation between -45deg and 45deg
            const rotation = (Math.random() - 0.5) * 90;
            
            // Add slight color variation (±25 for each RGB channel)
            const colorVariation = 25;
            const r = Math.max(0, Math.min(255, baseR + (Math.random() - 0.5) * colorVariation * 2));
            const g = Math.max(0, Math.min(255, baseG + (Math.random() - 0.5) * colorVariation * 2));
            const b = Math.max(0, Math.min(255, baseB + (Math.random() - 0.5) * colorVariation * 2));
            const heartColor = `rgb(${Math.round(r)}, ${Math.round(g)}, ${Math.round(b)})`;
            
            // Create heart element
            const heartDiv = document.createElement('div');
            heartDiv.className = `heart-float heart-float-${i % 12}`;
            heartDiv.style.left = `${baseX + positionOffsetX}px`;
            heartDiv.style.top = `${baseY + positionOffsetY}px`;
            heartDiv.style.transform = `translate(-50%, -50%) rotate(${rotation}deg)`;
            heartDiv.style.zIndex = '0';
            heartDiv.style.setProperty('--heart-rotate', `${rotation}deg`);
            heartDiv.setAttribute('data-animation-id', animationId.toString());
            
            // Create SVG heart
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('width', size.toString());
            svg.setAttribute('height', (size * 0.9).toString());
            svg.setAttribute('viewBox', '0 0 20 18');
            svg.setAttribute('fill', 'none');
            svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
            
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            // Path data matches public/img/heart.svg but with dynamic fill color
            path.setAttribute('d', 'M0 5.85223C0 10.7152 4.02 13.3062 6.962 15.6262C8 16.4442 9 17.2152 10 17.2152C11 17.2152 12 16.4452 13.038 15.6252C15.981 13.3072 20 10.7152 20 5.85323C20 0.991221 14.5 -2.45977 10 2.21623C5.5 -2.45977 0 0.989223 0 5.85223Z');
            path.setAttribute('fill', heartColor);
            
            svg.appendChild(path);
            heartDiv.appendChild(svg);
            heartsContainer.appendChild(heartDiv);
        }
        
        // Set timeout to remove only this animation's hearts
        const timeout = setTimeout(function() {
            const heartsToRemove = heartsContainer.querySelectorAll(`[data-animation-id="${animationId}"]`);
            heartsToRemove.forEach(function(heart) {
                heart.remove();
            });
            floatingHeartsState.activeTimeouts.delete(animationId);
        }, 3500);
        
        // Store timeout reference for cleanup
        floatingHeartsState.activeTimeouts.set(animationId, timeout);
    }
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        floatingHeartsState.activeTimeouts.forEach(function(timeout) {
            clearTimeout(timeout);
        });
        floatingHeartsState.activeTimeouts.clear();
    });
    
    // Expose function globally
    window.triggerFloatingHearts = triggerFloatingHearts;
})();

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
        // Issue #7: Store data-value instead of jQuery object to avoid stale references
        let pendingDonationAmount = null;
        let pendingDonationLabel = null;
        let pendingDonationButtonValue = null; // Store data-value instead of jQuery object
        
        // Issue #5: Flags to coordinate auto-select and session restore timing
        let autoSelectInProgress = false;
        let sessionRestoreInProgress = false;
        
        // Issue #6: Function to clear pending donation state
        function clearPendingDonationState() {
            if (pendingDonationButtonValue !== null) {
                const button = jQuery(`button[data-value="${pendingDonationButtonValue}"]`);
                if (button.length) {
                    setButtonLoading(button, false);
                }
            }
            pendingDonationAmount = null;
            pendingDonationLabel = null;
            pendingDonationButtonValue = null;
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
                // Issue #4: Check if wp.data is available (Gutenberg/Blocks context)
                let currentCart = null;
                if (window.wp && window.wp.data && window.wp.data.select) {
                    try {
                        const { getCartData } = wp.data.select('wc/store/cart');
                        currentCart = getCartData();
                    } catch (e) {
                        // wp.data not available or store not initialized
                        console.warn('wp.data cart store not available, skipping client-side update');
                    }
                }

                let updatedFees = [];

                if (currentCart && Array.isArray(currentCart.fees)) {
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

                // Issue #4: Only update wp.data if available
                if (currentCart !== null && window.wp && window.wp.data && window.wp.data.dispatch) {
                    try {
                        await wp.data.dispatch('wc/store/cart').setCartData({
                            ...currentCart,
                            fees: updatedFees
                        });
                    } catch (e) {
                        console.warn('Failed to update wp.data cart store:', e);
                    }
                }

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
                    error: function(xhr, status, error) {
                        // Issue #3: Re-enable buttons on error and clear pending state
                        setButtonLoading(jQuery('.donation-btn.loading'), false);
                        
                        // Clear any pending state if AJAX fails
                        clearPendingDonationState();
                        
                        // Issue #16: Handle nonce expiration (403 Forbidden)
                        if (xhr.status === 403) {
                            // Nonce expired - show user-friendly message
                            if (window.wp && window.wp.data && window.wp.data.dispatch) {
                                wp.data.dispatch('core/notices').createNotice(
                                    'error',
                                    'Session expired. Please refresh the page.',
                                    { id: 'donation-nonce-error', isDismissible: true }
                                );
                            } else {
                                alert('Session expired. Please refresh the page.');
                            }
                        } else {
                            console.error('Donation update failed:', error);
                        }
                    }
                });
                return true;

            } catch (error) {
                // Re-enable buttons on error
                setButtonLoading(jQuery('.donation-btn.loading'), false);
                // Issue #3: Clear pending state on error
                clearPendingDonationState();
                
                // Issue #4: Only show notice if wp.data is available
                if (window.wp && window.wp.data && window.wp.data.dispatch) {
                    wp.data.dispatch('core/notices').createNotice(
                        'error',
                        `Failed to add donation: ${error.message}`,
                        { id: 'donation-error' }
                    );
                }
                throw error;
            }
        };
        
        const update_totals = async () => {
            try {
                // Issue #4: Only invalidate if wp.data is available
                if (window.wp && window.wp.data && window.wp.data.dispatch) {
                    await wp.data.dispatch('wc/store/cart').invalidateResolution('getCartData');
                }
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

        // Issue #5: Auto-select first organization on page load if not already selected
        // Increased delay to 500ms to let session restore complete first
        setTimeout(function(){
            // Skip if session restore is in progress or pending amount exists
            if (sessionRestoreInProgress || pendingDonationAmount !== null) {
                return;
            }
            
            if (causes && causes.length > 1) {
                const donationCauseEle = jQuery('#donation-cause');
                
                // Check if no org is selected (value is 0 or empty)
                // If org is already selected, don't change it
                const hasNoOrg = !donationCauseEle.val() || donationCauseEle.val() == '0';
                
                if (hasNoOrg) {
                    autoSelectInProgress = true;
                    // Auto-select first org
                    const firstOrgOption = jQuery('.ybh-dd-option').first();
                    if (firstOrgOption.length) {
                        firstOrgOption.trigger('click');
                    }
                    autoSelectInProgress = false;
                }
            }
        }, 500);

        $(document).on('click', '.ybh-dd-option', function (event) {
            event.preventDefault();
            const selectedOption = document.getElementById('selectedOption');
            const donationCauseEle = document.getElementById('donation-cause');
            const causeImgEle = document.getElementById('selected-cause-img');

            $('#dropdownMenu').removeClass('show');
            selectedOption.textContent = $(this).data("text");
            donationCauseEle.value = $(this).data("value");
            causeImgEle.src = $(this).data("image");
            
            // Process organization selection
            if( $(this).data("value") && $(this).data("value") != 0 ){
                
                // Issue #7: Auto-apply pending donation amount if one was stored
                // Re-query button by data-value to avoid stale references
                let wasPendingApplied = false;
                if (pendingDonationAmount !== null && pendingDonationButtonValue !== null) {
                    // Re-query button by data-value (always gets current DOM element)
                    const buttonToUpdate = jQuery(`button[data-value="${pendingDonationButtonValue}"]`);
                    
                    if (buttonToUpdate.length) {
                        // Show loading spinner on the button (consistent with normal flow)
                        setButtonLoading(buttonToUpdate, true);
                        
                        // Set the amount value
                        jQuery('#donation-amount').val(pendingDonationAmount);
                        jQuery('.donation-amount-text').text(pendingDonationLabel + currencySymbol);
                        
                        // Update button states
                        jQuery('.donation-amounts .radio-button').removeClass('selected');
                        buttonToUpdate.addClass('selected');
                        
                        // Mark that we applied pending amount
                        wasPendingApplied = true;
                        
                        // Clear pending values
                        pendingDonationAmount = null;
                        pendingDonationLabel = null;
                        pendingDonationButtonValue = null;
                        
                        // Now that both org and amount are set, add to cart
                        // The spinner will be removed by the AJAX success handler
                        if (validate_donation_data()) {
                            add_donation_to_cart();
                        } else {
                            // Re-enable if validation fails
                            setButtonLoading(buttonToUpdate, false);
                        }
                    } else {
                        // Button not found, clear pending state
                        clearPendingDonationState();
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
            const buttonElement = this; // Native DOM element for floating hearts
            
            // Do nothing if button is already selected
            if (jQueryBtn.hasClass('selected')) {
                return;
            }
            
            // Prevent if already loading
            if (jQueryBtn.hasClass('loading')) {
                return;
            }
            
            // Organization should always be selected, so we can proceed directly
            
            // Trigger floating hearts animation
            if (typeof window.triggerFloatingHearts === 'function') {
                try {
                    // Get button background color for heart color
                    const computedStyle = window.getComputedStyle(buttonElement);
                    const buttonColor = computedStyle.backgroundColor || computedStyle.getPropertyValue('--btn-color') || '#8320bd';
                    const elementId = jQueryBtn.data('value') || 'donation-btn-' + Date.now();
                    
                    window.triggerFloatingHearts(elementId, buttonElement, buttonColor);
                } catch (e) {
                    // Silently fail if hearts animation fails
                    console.warn('Floating hearts animation error:', e);
                }
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
            
            // Issue #6: Clear pending donation amount if exists
            clearPendingDonationState();
            
            // Disable buttons and show spinner
            setButtonLoading(jQueryBtn, true);
            
            const donationAmountEle = document.getElementById('donation-amount');
            donationAmountEle.value = '';
            jQuery('.donation-amount-text').text('0,00' + currencySymbol);
            jQuery('.donation-amounts .radio-button').removeClass('selected');
            jQuery('#donation-amount').trigger('change');

            // Get current organization data before clearing amount
            // This ensures the org is preserved in session when amount is deleted
            const orgId = jQuery('#donation-cause').val();
            const selectedOption = document.getElementById('selectedOption');
            const causeImgEle = document.getElementById('selected-cause-img');
            const orgName = selectedOption ? selectedOption.textContent : '';
            const orgImg = causeImgEle ? causeImgEle.src : '';
            
            // Find the org data from causes array if we have the ID
            let finalOrgName = orgName;
            let finalOrgImg = orgImg;
            if (orgId && causes) {
                const selectedCause = causes.find(cause => cause.value === parseInt(orgId));
                if (selectedCause) {
                    finalOrgName = selectedCause.label;
                    finalOrgImg = selectedCause.image;
                }
            }
            
            // Call addDonationFee with org data but amount = 0 to preserve org in session
            if (orgId && orgId !== '0' && finalOrgName) {
                addDonationFee(orgId, finalOrgName, 0, finalOrgImg);
            } else {
                // Fallback to add_donation_to_cart if org data not available
                add_donation_to_cart();
            }
        });
        
        // Issue #5: Session restore - coordinate with auto-select timing
        if (selected_amount && selected_amount > 0) {
            sessionRestoreInProgress = true;
            let selected_amount_cents = selected_amount * 100;
            const currentAmount = jQuery('#donation-amount').val();
            const currentCause = jQuery('#donation-cause').val();
            
            // Only auto-click if:
            // 1. No amount is currently set in the input
            // 2. No org is selected (or org is '0')
            // 3. No pending amount exists
            // 4. Auto-select is not in progress
            // This prevents auto-clicking when user has explicitly cleared everything
            if (!currentAmount && (!currentCause || currentCause == '0') && !autoSelectInProgress && pendingDonationAmount === null) {
                if (jQuery(`button[data-value="${selected_amount_cents}"]`).length) {
                    jQuery(`button[data-value="${selected_amount_cents}"]`).click();
                }
            }
            sessionRestoreInProgress = false;
        }
        
        // Issue #6: Clear pending state on checkout updates (widget may have re-rendered)
        jQuery(document.body).on('updated_checkout', function() {
            clearPendingDonationState();
        });
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
