<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! is_admin() ) {
    $currency_symbol = get_woocommerce_currency_symbol();
    $youbehero_data = json_decode( get_option('ybhd_dashboard_json' ), true );
    $youbehero_data = $youbehero_data['data'] ?? [];

    $causes = [];
    $amounts = [];

    if( isset( $youbehero_data['status'] ) && $youbehero_data['status'] == 'active' && !empty($youbehero_data) && !empty($youbehero_data['selected_causes']) ){

        if( !empty($youbehero_data['selected_causes']) ){
            $causes = array_map(function ($cause) {
                return [
                    'label' => $cause['name'],
                    'value' => $cause['id'],
                    'image' => $cause['image']
                ];
            }, $youbehero_data['selected_causes']);

        }
        if( !empty($youbehero_data['donation_settings']) && !empty($youbehero_data['donation_settings']['fixed_amounts']) ){
            $amounts = array_values(
                array_filter($youbehero_data['donation_settings']['fixed_amounts'], function( $value ) {
                    return !empty( $value ); // removes null, "", 0, false, etc.
                })
            );
//            $amounts = array_values($youbehero_data['donation_settings']['fixed_amounts']);
        }

        $donor = $youbehero_data['donation_settings']['donor_type'] ?? 'customer'; // fallback to customer if not set
        $donationType = $youbehero_data['donation_settings']['donation_type'] ?? 'fixed'; // fallback to fixed if not set
        $checkWActive = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['active'] ?? true;

        $background_color = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['background_color'] ?? "#ffffff";
        $text_color = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['text_color'] ?? "#000000";
        $btn_color = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['btn_color'] ?? "#3b82f6";
        $border = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['border'] ?? true;
        $border_color = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['border_color'] ?? $btn_color;
        $margin = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['margin'] ?? "bigMargin";
        $padding = $youbehero_data['widget_configurations']['checkout_page']['checkout_page']['padding'] ?? "midPadding";

        $config = $youbehero_data['widget_configurations'];
        $style = $config['checkout_page']['checkout_page'];

        $session_cause = WC()->session->get( 'ybh_donation_cause' );
        $classes = [];

        if (!empty($style['padding'])) {
            $classes[] = $style['padding'];
        }
        if (!empty($style['margin'])) {
            $classes[] = $style['margin'];
        }
        if (!empty($style['border_radius'])) {
            $classes[] = $style['border_radius'];
        }
        if (!empty($style['border'])) {
            $classes[] = 'bordered'; // optional class for styling border if needed
        }

        $classString = implode(' ', $classes);

        if( $checkWActive ){
            $html = $headHtml = '';
            $eligible = true;

            if ( $donor == 'customer' &&  $donationType == 'fixed' && !empty($amounts) ) {
                $donation_amount = WC()->session->get('ybh_donation_amount', 0);
                $txt = __( "Would you like to make a donation?", "youbehero" );
                $headHtml .= '<span style="color:'.$text_color.'">'.$txt.'</span><span style="background: '.$btn_color.'" class="pill-container"><span class="donation-amount-pill">' .number_format((float)$donation_amount, 2, '.', '') . $currency_symbol.'</span></span>';
                foreach ($amounts as $amount) {
                    $amount_cents = (float) str_replace(',', '.', $amount) * 100;//(float)$amount * 100;

                    $selected = $don_cause = '';
                    if( isset( WC()->session ) && !empty( $session_cause ) ) {
                        $don_cause_key = array_search($session_cause, array_column($causes, 'label'));
                        $don_cause = $causes[$don_cause_key]['value'];
                        $donation_amount = WC()->session->get('ybh_donation_amount', 0);
                        $float = str_replace(',', '.', $amount);
                        $selected = ($donation_amount == $float) ? 'selected' : '';
                    }

                    $html .= '<button class="donation-btn radio-button '.$selected.'" data-btnclr="'.$btn_color.'" style="--btn-color: '.esc_attr($btn_color).';" data-value="'.$amount_cents.'" data-label="'.$amount.'">'.$amount . $currency_symbol . '</button>';

                }

                $html .= '<button class="donation-btn delete-button" data-btnclr="'.$btn_color.'" style="--btn-color: '.esc_attr($btn_color).';"><img src="'.esc_url( YBHD_PLUGIN_URL ).'public/img/delete.svg"></button>';
                $html .= '<input name="donation_cause" id="donation-cause" value="'.$don_cause.'" type="hidden"/>
                            <input name="donation_amount" id="donation-amount" type="hidden"/>';

            } else if ($donor == 'customer' &&  $donationType == 'roundup') {

                if (function_exists('WC') && WC() !== null && WC()->cart !== null) {
                    $cart = WC()->cart;
                    $subtotal = $cart->get_subtotal();

                    $rounded = 0;

                    switch (true) {
                        case ($subtotal <= 10):
                            // Small: round up to nearest €0.50
                            $rounded = ceil($subtotal * 2) / 2;
                            break;
                        case ($subtotal <= 50):
                            // Medium: round up to nearest €1
                            $rounded = ceil($subtotal);
                            break;
                        case ($subtotal <= 100):
                            // Large: round up to nearest €5
                            $rounded = ceil($subtotal / 5) * 5;
                            break;
                        case ($subtotal <= 500):
                            // Maximum: round up to nearest €10
                            $rounded = ceil($subtotal / 10) * 10;
                            break;
                        default:
                            // Exceptional: round up to nearest €10
                            $rounded = ceil($subtotal / 10) * 10;
                    }
                } else {
                    $rounded = 0;
                }

                $roundupValue = round($rounded - $subtotal, 2);
                $amount_cents = (float) str_replace(',', '.', $roundupValue) * 100;//(float)$roundupValue * 100;
                $donation_amount = 0;
                if ( $amount_cents > 0 ) {
                    $selected = $don_cause = '';
                    if( isset( WC()->session ) && !empty( $session_cause ) ) {
                        $don_cause_key = array_search($session_cause, array_column($causes, 'label'));
                        $don_cause = $causes[$don_cause_key]['value'];
                        $donation_amount = WC()->session->get('ybh_donation_amount', 0);
                        $selected = $donation_amount == $roundupValue ? 'selected' : '';
                    }

                    $txt = __( "Would you like to make a donation?", "youbehero" );
                    $headHtml .= '<span style="color:'.$text_color.'">'.$txt.'</span><span style="background: '.$btn_color.'" class="pill-container"><span class="donation-amount-pill">' .number_format((float)$donation_amount, 2, '.', '') . $currency_symbol.'</span></span>';

                    $html .= '<button class="donation-btn radio-button ' . $selected . '" data-btnclr="'.$btn_color.'" style="--btn-color: '.esc_attr($btn_color).';" data-value="' . $amount_cents . '" data-label="' . number_format((float)$roundupValue, 2, '.', '') . '" >' . number_format((float)$roundupValue, 2, '.', '') . $currency_symbol . '</button>';
                    $html .= '<button class="donation-btn delete-button" data-btnclr="'.$btn_color.'" style="--btn-color: '.esc_attr($btn_color).';"><img src="'.esc_url( YBHD_PLUGIN_URL ).'public/img/delete.svg"></button>';
                    $html .= '<input name="donation_cause" id="donation-cause" value="'.$don_cause.'" type="hidden"/>
                        <input name="donation_amount" id="donation-amount" type="hidden"/>';
                } else {
                    $eligible = false;
                }

            } else if ($donor == 'eshop' &&  $donationType == 'fixed') {

                $fixedValue = $youbehero_data['donation_settings']['fixed_amount'] ?? '0';
                if ( $fixedValue > 0 ) {
                    $amount_cents = (float) str_replace(',', '.', $fixedValue) * 100;

                    $htxt1 = __( "Through this market, we will offer", "youbehero" );
                    $htxt2 = __( "to support a non-profit organization", "youbehero" );
                    $headHtml .= '<span style="color:' . $text_color . '">' . $htxt1 .' '. $fixedValue . $currency_symbol . ' ' .$htxt2 .'</span>';
                    $html .= '<input type="hidden" data-value="' . $amount_cents . '" data-label="' . $fixedValue . '" />';
                    $html .= '<input name="donation_cause" id="donation-cause" type="hidden"/>
                        <input name="donation_amount" id="donation-amount" type="hidden" value="' . $amount_cents . '"/>';
                } else {
                    $eligible = false;
                }

            } else if ($donor == 'eshop' &&  $donationType == 'percentage') {

                $percent = $youbehero_data['donation_settings']['fixedPercentage'] ?? '0';
                if ( $percent > 0 ) {
                    $cart = WC()->cart;
                    $subtotal = $cart->get_subtotal();
                    $percentValue = $subtotal * $percent / 100;
                    $amount_cents = (float) str_replace(',', '.', $percentValue) * 100;

                    $htxt1 = __( "We will donate it", "youbehero" );
                    $htxt2 = __( "of your order to a charity", "youbehero" );

                    $headHtml .= '<span style="color:' . $text_color . '"> ' . $htxt1 . $percent . ' % '. $htxt2 . '</span>';
                    $html .= '<input type="hidden" data-value="' . $amount_cents . '" data-label="' . $percentValue . '" />';
                    $html .= '<input name="donation_cause" id="donation-cause" type="hidden"/>
                        <input name="donation_amount" id="donation-amount" type="hidden" value="' . $amount_cents . '"/>';
                } else {
                    $eligible = false;
                }

            }

            $selected_cause = '';

            if ( $eligible ) {
                ?>
                <div class="donation-checkout-widget youbehero-donation-widget">
                    <div class="donation-box-container <?php echo wp_kses_post( $classString ); ?>" style="background-color: <?php echo esc_html( $style['background_color'] ); ?>; color: <?php echo esc_html( $style['text_color'] ); ?>; border-color: <?php echo esc_html( $style['border_color'] ); ?>;">
                        <div class="donation-header">
                            <?php echo wp_kses_post($headHtml ); ?>
                        </div>

                        <div class="custom-dropdown" id="ybh-dd-dropdown">
                            <div class="donation-select  custom-dropdown-toggle" id="ybh-dd-select">

                                <?php if( count( $causes ) == 1 ) { ?>
                                    <div class="donation-text">
                                        <?php foreach ( $causes as $key=>$cause ) { ?>
                                            <div class="ybh-dd-option" id="<?php echo esc_html( $key );?>-ybh-dd-option" data-image="<?php echo esc_html( $cause['image'] ) ?>" data-text="<?php echo esc_html( $cause['label'] )?>" data-value="<?php echo esc_html( $cause['value'] )?>")">
                                                <img id="selected-cause-img" src="<?php echo esc_html( $cause['image'] )?>" alt="Logo">
                                                <span id="selectedOption"><?php echo esc_html( $cause['label'] )?></span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                <div class="donation-text">
                                    <?php if( isset( WC()->session ) && !empty( $session_cause ) ) {
                                        $selected_cause = $session_cause;
                                        ?>
                                        <img id="selected-cause-img" src="<?php echo esc_html( WC()->session->get( '_donation_org_img' ) ); ?>" alt="Logo">
                                        <span id="selectedOption"><?php echo esc_html( $session_cause ); ?></span>
                                    <?php } else { ?>
                                        <img id="selected-cause-img" src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/ybh.svg" alt="Logo">
                                        <span id="selectedOption"><?php echo esc_html__( 'Please select a nonprofit organization', 'youbehero' )?></span>
                                    <?php }

                                    ?>
                                </div>
                                <span class="dropdown-arrow"><img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/caret.svg" alt=""></span>
                                <?php } ?>
                            </div>

                            <?php if( count( $causes ) > 1 ) { ?>
                                <div class="custom-dropdown-menu" id="dropdownMenu">
                                    <div class="custom-dropdown-option ybh-dd-option <?php echo ( empty($selected_cause) )?'hidden':'';?>" id="select-np-ybh-dd-option" data-image="<?php echo esc_url( YBHD_PLUGIN_URL );?>public/img/ybh.svg" data-text="<?php echo esc_html__( 'Please select a nonprofit organization', 'youbehero' ); ?>" data-value="0">
                                        <img alt="<?php echo esc_url( YBHD_PLUGIN_URL );?>public/img/ybh.svg" src="<?php echo esc_url( YBHD_PLUGIN_URL );?>public/img/ybh.svg"  style="width: min(5%, 2em);"/>
                                        <span class="text-gray-700"><?php echo esc_html__( 'Please select a nonprofit organization', 'youbehero' ); ?></span>
                                    </div>
                                    <?php
                                    foreach ( $causes as $key=>$cause ) { ?>
                                        <div class="custom-dropdown-option ybh-dd-option" id="<?php echo esc_html( $key );?>-ybh-dd-option" data-image="<?php echo esc_html( $cause['image'] ) ?>" data-text="<?php echo esc_html( $cause['label'] )?>" data-value="<?php echo esc_html( $cause['value'] )?>")">
                                            <img alt="<?php echo esc_html( $cause['label'] )?>" src="<?php echo esc_html( $cause['image'] )?>"/>
                                            <span class="text-gray-700"><?php echo esc_html( $cause['label'] )?></span>
                                        </div>
                                    <?php } ?>
                                </div>
                        <?php } ?>
                    </div>

                    <div class="donation-buttons donation-amounts">
                        <?php echo wp_kses_post( $html ); ?>
                    </div>

                </div>

                <div id="donation-amounts" class="donation-buttons">
                </div>

                <div id="widget-loader" class="widget-loader hidden">
                    <div class="widget-loader-bar">
                        <?php echo esc_html__( "Updating", "youbehero" ); ?>...</div>
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