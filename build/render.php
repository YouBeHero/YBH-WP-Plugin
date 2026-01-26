<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! is_admin() ) {
    $ybhd_currency_symbol = get_woocommerce_currency_symbol();
    $youbehero_data       = json_decode( get_option( 'ybhd_dashboard_json' ), true );
    $youbehero_data       = $youbehero_data['data'] ?? [];

    $ybhd_causes  = [];
    $ybhd_amounts = [];

    // Check if is_scheduled or has_ended is set to 1 (block rendering if true)
    $ybhd_is_scheduled = isset( $youbehero_data['is_scheduled'] ) && ( intval( $youbehero_data['is_scheduled'] ) === 1 );
    $ybhd_has_ended    = isset( $youbehero_data['has_ended'] ) && ( intval( $youbehero_data['has_ended'] ) === 1 );

    if ( isset( $youbehero_data['status'] ) && $youbehero_data['status'] == 'active' && ! empty( $youbehero_data ) && ! empty( $youbehero_data['selected_causes'] ) && ! $ybhd_is_scheduled && ! $ybhd_has_ended ) {

        if ( ! empty( $youbehero_data['selected_causes'] ) ) {
            $ybhd_causes = array_map(
                function ( $cause ) {
                return [
                    'label' => $cause['name'],
                    'value' => $cause['id'],
                    'image' => $cause['image']
                ];
                },
                $youbehero_data['selected_causes']
            );

        }
        if ( ! empty( $youbehero_data['donation_settings'] ) && ! empty( $youbehero_data['donation_settings']['fixed_amounts'] ) ) {
            $ybhd_amounts = array_values(
                array_filter(
                    $youbehero_data['donation_settings']['fixed_amounts'],
                    function ( $value ) {
                        return ! empty( $value ); // removes null, "", 0, false, etc.
                    }
                )
            );
        }

        $ybhd_donor         = $youbehero_data['donation_settings']['donor_type'] ?? 'customer'; // fallback to customer if not set
        $ybhd_donation_type = $youbehero_data['donation_settings']['donation_type'] ?? 'fixed'; // fallback to fixed if not set
        $ybhd_check_active  = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['active'] ?? true;

        $ybhd_background_color = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['background_color'] ?? '#ffffff';
        $ybhd_text_color       = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['text_color'] ?? '#000000';
        $ybhd_btn_color        = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['btn_color'] ?? '#3b82f6';
        $ybhd_border           = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['border'] ?? true;
        $ybhd_border_color     = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['border_color'] ?? $ybhd_btn_color;
        $ybhd_margin           = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['margin'] ?? 'bigMargin';
        $ybhd_padding          = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['padding'] ?? 'midPadding';

        $ybhd_config = $youbehero_data['widget_configurations'];
        $ybhd_style  = $ybhd_config['checkout_page']['checkout_page'];

        $ybhd_session_cause = WC()->session->get( 'ybh_donation_cause' );
        $ybhd_classes       = [];

        if ( ! empty( $ybhd_style['padding'] ) ) {
            $ybhd_classes[] = $ybhd_style['padding'];
        }
        if ( ! empty( $ybhd_style['margin'] ) ) {
            $ybhd_classes[] = $ybhd_style['margin'];
        }
        if ( ! empty( $ybhd_style['border_radius'] ) ) {
            $ybhd_classes[] = $ybhd_style['border_radius'];
        }
        if ( ! empty( $ybhd_style['border'] ) ) {
            $ybhd_classes[] = 'bordered'; // optional class for styling border if needed
        }

        $ybhd_class_string = implode( ' ', $ybhd_classes );

        if ( $ybhd_check_active ) {
            $ybhd_html     = '';
            $ybhd_headhtml = '';
            $ybhd_eligible = true;

            if ( $ybhd_donor == 'customer' && $ybhd_donation_type == 'fixed' && ! empty( $ybhd_amounts ) ) {
                $ybhd_donation_amount = WC()->session->get( 'ybh_donation_amount', 0 );
                $ybhd_txt             = __( 'Would you like to make a donation?', 'youbehero' );
                $ybhd_headhtml       .= '<span style="color:' . $ybhd_text_color . '">' . $ybhd_txt . '</span><span style="background: ' . $ybhd_btn_color . '" class="pill-container"><img src="' . esc_url( YBHD_PLUGIN_URL ) . 'public/img/donation-heart.svg" class="donation-heart-icon" alt=""><span class="donation-amount-pill"><span class="donation-amount-text">' . number_format( (float) $ybhd_donation_amount, 2, '.', '' ) . $ybhd_currency_symbol . '</span></span></span>';
                foreach ( $ybhd_amounts as $ybhd_amount ) {
                    $ybhd_amount_cents = (float) str_replace( ',', '.', $ybhd_amount ) * 100;//(float)$amount * 100;

                    $ybhd_selected   = '';
                    $ybhd_don_cause  = '';
                    if ( isset( WC()->session ) && ! empty( $ybhd_session_cause ) ) {
                        $ybhd_don_cause_key   = array_search( $ybhd_session_cause, array_column( $ybhd_causes, 'label' ), true );
                        $ybhd_don_cause       = $ybhd_causes[ $ybhd_don_cause_key ]['value'];
                        $ybhd_donation_amount = WC()->session->get( 'ybh_donation_amount', 0 );
                        $ybhd_float           = str_replace( ',', '.', $ybhd_amount );
                        $ybhd_selected        = ( $ybhd_donation_amount == $ybhd_float ) ? 'selected' : '';
                    } else {
                        // Set first organization as default when no session exists
                        $ybhd_first_cause = reset( $ybhd_causes );
                        $ybhd_don_cause = $ybhd_first_cause['value'];
                    }

                    $ybhd_html .= '<button type="button" class="donation-btn radio-button ' . $ybhd_selected . '" data-btnclr="' . $ybhd_btn_color . '" style="--btn-color: ' . esc_attr( $ybhd_btn_color ) . ';" data-value="' . $ybhd_amount_cents . '" data-label="' . $ybhd_amount . '">' . $ybhd_amount . $ybhd_currency_symbol . '</button>';

                }

                $ybhd_html .= '<button type="button" class="donation-btn delete-button" data-btnclr="' . $ybhd_btn_color . '" style="--btn-color: ' . esc_attr( $ybhd_btn_color ) . ';"><img src="' . esc_url( YBHD_PLUGIN_URL ) . 'public/img/delete.svg"></button>';
                $ybhd_html .= '<input name="donation_cause" id="donation-cause" value="' . $ybhd_don_cause . '" type="hidden"/>
                            <input name="donation_amount" id="donation-amount" type="hidden"/>';

            } elseif ( $ybhd_donor == 'customer' && $ybhd_donation_type == 'roundup' ) {

                if ( function_exists( 'WC' ) && WC() !== null && WC()->cart !== null ) {
                    $ybhd_cart = WC()->cart;
                    $ybhd_cart->calculate_totals();
                    
                    // Get grand total excluding donation fees
                    $ybhd_grand_total = $ybhd_cart->get_total('edit') - array_sum( array_map( function( $fee ) {
                        return ( isset( $fee->ybh_donation_cause ) || isset( $fee->_ybh_donation_amount ) ) ? $fee->get_total() : 0;
                    }, $ybhd_cart->get_fees() ) );

                    $ybhd_rounded = 0;

                    switch (true) {
                        case ( $ybhd_grand_total <= 10 ):
                            // Small: round up to nearest €0.50
                            $ybhd_rounded = ceil( $ybhd_grand_total * 2 ) / 2;
                            // Ensure it's always greater than grand total
                            if ($ybhd_rounded <= $ybhd_grand_total) {
                                $ybhd_rounded = $ybhd_grand_total + 0.50;
                            }
                            break;
                        case ( $ybhd_grand_total <= 50 ):
                            // Medium: round up to nearest €1
                            $ybhd_rounded = ceil( $ybhd_grand_total );
                            // Ensure it's always greater than grand total
                            if ($ybhd_rounded <= $ybhd_grand_total) {
                                $ybhd_rounded = $ybhd_grand_total + 1;
                            }
                            break;
                        case ( $ybhd_grand_total <= 100 ):
                            // Large: round up to nearest €5
                            $ybhd_rounded = ceil( $ybhd_grand_total / 5 ) * 5;
                            // Ensure it's always greater than grand total
                            if ($ybhd_rounded <= $ybhd_grand_total) {
                                $ybhd_rounded = (floor($ybhd_grand_total / 5) + 1) * 5;
                            }
                            break;
                        case ( $ybhd_grand_total <= 500 ):
                            // Maximum: round up to nearest €10
                            $ybhd_rounded = ceil( $ybhd_grand_total / 10 ) * 10;
                            // Ensure it's always greater than grand total
                            if ($ybhd_rounded <= $ybhd_grand_total) {
                                $ybhd_rounded = (floor($ybhd_grand_total / 10) + 1) * 10;
                            }
                            break;
                        default:
                            // Exceptional: round up to nearest €10
                            $ybhd_rounded = ceil( $ybhd_grand_total / 10 ) * 10;
                            // Ensure it's always greater than grand total
                            if ($ybhd_rounded <= $ybhd_grand_total) {
                                $ybhd_rounded = (floor($ybhd_grand_total / 10) + 1) * 10;
                            }
                    }
                } else {
                    $ybhd_rounded = 0;
                    $ybhd_grand_total = 0;
                }

                $ybhd_roundup_value = isset( $ybhd_grand_total ) ? round( $ybhd_rounded - $ybhd_grand_total, 2 ) : 0;
                $ybhd_amount_cents  = (float) str_replace( ',', '.', $ybhd_roundup_value ) * 100;//(float)$roundupValue * 100;
                $ybhd_donation_amount = 0;
                if ( $ybhd_amount_cents > 0 ) {
                    $ybhd_selected  = '';
                    $ybhd_don_cause = '';
                    if ( isset( WC()->session ) && ! empty( $ybhd_session_cause ) ) {
                        $ybhd_don_cause_key   = array_search( $ybhd_session_cause, array_column( $ybhd_causes, 'label' ), true );
                        $ybhd_don_cause       = $ybhd_causes[ $ybhd_don_cause_key ]['value'];
                        $ybhd_donation_amount = WC()->session->get( 'ybh_donation_amount', 0 );
                        $ybhd_selected        = $ybhd_donation_amount == $ybhd_roundup_value ? 'selected' : '';
                    }

                    $ybhd_txt       = __( 'Would you like to make a donation?', 'youbehero' );
                    $ybhd_headhtml .= '<span style="color:' . $ybhd_text_color . '">' . $ybhd_txt . '</span><span style="background: ' . $ybhd_btn_color . '" class="pill-container"><img src="' . esc_url( YBHD_PLUGIN_URL ) . 'public/img/donation-heart.svg" class="donation-heart-icon" alt=""><span class="donation-amount-pill"><span class="donation-amount-text">' . number_format( (float) $ybhd_donation_amount, 2, '.', '' ) . $ybhd_currency_symbol . '</span></span></span>';

                    $ybhd_html .= '<button type="button" class="donation-btn radio-button ' . $ybhd_selected . '" data-btnclr="' . $ybhd_btn_color . '" style="--btn-color: ' . esc_attr( $ybhd_btn_color ) . ';" data-value="' . $ybhd_amount_cents . '" data-label="' . number_format( (float) $ybhd_roundup_value, 2, '.', '' ) . '" >' . number_format( (float) $ybhd_roundup_value, 2, '.', '' ) . $ybhd_currency_symbol . '</button>';
                    $ybhd_html .= '<button type="button" class="donation-btn delete-button" data-btnclr="' . $ybhd_btn_color . '" style="--btn-color: ' . esc_attr( $ybhd_btn_color ) . ';"><img src="' . esc_url( YBHD_PLUGIN_URL ) . 'public/img/delete.svg"></button>';
                    $ybhd_html .= '<input name="donation_cause" id="donation-cause" value="' . $ybhd_don_cause . '" type="hidden"/>
                        <input name="donation_amount" id="donation-amount" type="hidden"/>';
                } else {
                    $ybhd_eligible = false;
                }

            } elseif ( $ybhd_donor == 'eshop' && $ybhd_donation_type == 'fixed' ) {

                $ybhd_fixed_value = $youbehero_data['donation_settings']['fixed_amount'] ?? '0';
                if ( $ybhd_fixed_value > 0 ) {
                    $ybhd_amount_cents = (float) str_replace( ',', '.', $ybhd_fixed_value ) * 100;

                    $ybhd_htxt1     = __( 'Through this market, we will offer', 'youbehero' );
                    $ybhd_htxt2     = __( 'to support a non-profit organization', 'youbehero' );
                    $ybhd_headhtml .= '<span style="color:' . $ybhd_text_color . '">' . $ybhd_htxt1 . ' ' . $ybhd_fixed_value . $ybhd_currency_symbol . ' ' . $ybhd_htxt2 . '</span>';
                    $ybhd_html     .= '<input type="hidden" data-value="' . $ybhd_amount_cents . '" data-label="' . $ybhd_fixed_value . '" />';
                    $ybhd_html     .= '<input name="donation_cause" id="donation-cause" type="hidden"/>
                        <input name="donation_amount" id="donation-amount" type="hidden" value="' . $ybhd_amount_cents . '"/>';
                } else {
                    $ybhd_eligible = false;
                }

            } elseif ( $ybhd_donor == 'eshop' && $ybhd_donation_type == 'percentage' ) {

                $ybhd_percent = $youbehero_data['donation_settings']['fixedPercentage'] ?? '0';
                if ( $ybhd_percent > 0 ) {
                    $ybhd_cart         = WC()->cart;
                    $ybhd_subtotal     = $ybhd_cart->get_subtotal();
                    $ybhd_percentvalue = $ybhd_subtotal * $ybhd_percent / 100;
                    $ybhd_amount_cents = (float) str_replace( ',', '.', $ybhd_percentvalue ) * 100;

                    $ybhd_htxt1 = __( 'We will donate it', 'youbehero' );
                    $ybhd_htxt2 = __( 'of your order to a charity', 'youbehero' );

                    $ybhd_headhtml .= '<span style="color:' . $ybhd_text_color . '"> ' . $ybhd_htxt1 . $ybhd_percent . ' % ' . $ybhd_htxt2 . '</span>';
                    $ybhd_html     .= '<input type="hidden" data-value="' . $ybhd_amount_cents . '" data-label="' . $ybhd_percentvalue . '" />';
                    $ybhd_html     .= '<input name="donation_cause" id="donation-cause" type="hidden"/>
                        <input name="donation_amount" id="donation-amount" type="hidden" value="' . $ybhd_amount_cents . '"/>';
                } else {
                    $ybhd_eligible = false;
                }

            }

            $ybhd_selected_cause = '';

            if ( $ybhd_eligible ) {
                ?>
                <div class="donation-checkout-widget youbehero-donation-widget">
                    <div class="donation-box-container <?php echo wp_kses_post( $ybhd_class_string ); ?>" style="background-color: <?php echo esc_html( $ybhd_style['background_color'] ); ?>; color: <?php echo esc_html( $ybhd_style['text_color'] ); ?>; border-color: <?php echo esc_html( $ybhd_style['border_color'] ); ?>;">
                        <div class="hearts-container"></div>
                        <div class="donation-header">
                            <?php echo wp_kses_post( $ybhd_headhtml ); ?>
                        </div>

                        <div class="custom-dropdown" id="ybh-dd-dropdown">
                            <div class="donation-select  custom-dropdown-toggle" id="ybh-dd-select">

                                <?php if ( count( $ybhd_causes ) == 1 ) { ?>
                                <div class="donation-text">
                                    <?php foreach ( $ybhd_causes as $ybhd_key => $ybhd_cause ) { ?>
                                    <div class="ybh-dd-option" id="<?php echo esc_html( $ybhd_key ); ?>-ybh-dd-option" data-image="<?php echo esc_html( $ybhd_cause['image'] ); ?>" data-text="<?php echo esc_html( $ybhd_cause['label'] ); ?>" data-value="<?php echo esc_html( $ybhd_cause['value'] ); ?>")">
                                    <img id="selected-cause-img" src="<?php echo esc_html( $ybhd_cause['image'] ); ?>" alt="Logo">
                                    <span id="selectedOption"><?php echo esc_html( $ybhd_cause['label'] ); ?></span>
                                </div>
                            <?php } ?>
                            </div>
                            <?php } else { ?>
                                <div class="donation-text">
                                    <?php if ( isset( WC()->session ) && ! empty( $ybhd_session_cause ) ) {
                                        $ybhd_selected_cause = $ybhd_session_cause;
                                        ?>
                                        <img id="selected-cause-img" src="<?php echo esc_html( WC()->session->get( '_donation_org_img' ) ); ?>" alt="Logo">
                                        <span id="selectedOption"><?php echo esc_html( $ybhd_session_cause ); ?></span>
                                    <?php } else { 
                                        // Always select first organization when no session exists
                                        $ybhd_first_cause = reset( $ybhd_causes );
                                        $ybhd_selected_cause = $ybhd_first_cause['label'];
                                        ?>
                                        <img id="selected-cause-img" src="<?php echo esc_html( $ybhd_first_cause['image'] ); ?>" alt="Logo">
                                        <span id="selectedOption"><?php echo esc_html( $ybhd_first_cause['label'] ); ?></span>
                                    <?php }

                                    ?>
                                </div>
                                <span class="dropdown-arrow"><span class="changeOrg"><?php echo esc_html__( 'Change', 'youbehero' ); ?></span><img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/caret.svg" alt=""></span>
                            <?php } ?>
                        </div>

                                <?php if ( count( $ybhd_causes ) > 1 ) { ?>
                            <div class="custom-dropdown-menu" id="dropdownMenu">
                            <?php
                            foreach ( $ybhd_causes as $ybhd_key => $ybhd_cause ) { ?>
                            <div class="custom-dropdown-option ybh-dd-option" id="<?php echo esc_html( $ybhd_key ); ?>-ybh-dd-option" data-image="<?php echo esc_html( $ybhd_cause['image'] ); ?>" data-text="<?php echo esc_html( $ybhd_cause['label'] ); ?>" data-value="<?php echo esc_html( $ybhd_cause['value'] ); ?>")">
                            <img alt="<?php echo esc_html( $ybhd_cause['label'] ); ?>" src="<?php echo esc_html( $ybhd_cause['image'] ); ?>"/>
                            <span class="text-gray-700"><?php echo esc_html( $ybhd_cause['label'] ); ?></span>
                        </div>
                    <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                    <div class="donation-buttons donation-amounts">
                    <?php echo wp_kses_post( $ybhd_html ); ?>
                </div>

                </div>

                <div id="donation-amounts" class="donation-buttons">
                </div>
                </div>
                <?php
            } else {
                ?>
                <div>
                    <?php echo esc_html__( "Sorry, you are not eligible for donation.", "youbehero" ); ?>
                </div>
                <?php
            }
        }
    }
}