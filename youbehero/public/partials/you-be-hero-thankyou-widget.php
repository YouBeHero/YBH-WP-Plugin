<?php

/**
 * Provide a public-facing view for the plugin's Thank You Widget
 *
 * @link       https://youbehero.com
 * @since      1.1.1
 *
 * @package    You_Be_Hero
 * @subpackage You_Be_Hero/public/partials
 */

if( isset( $youbehero_data['status'] ) && $youbehero_data['status'] == 'active' && !empty( $youbehero_data ) ) {

    $check_w_active = $youbehero_data['widget_configurations']['confirmation_page']['confirmation_page']['active'] ?? false;

    if ( $check_w_active ) {
        $selected_cause_info = $this->youbehero_get_ordered_cause( $youbehero_data['selected_causes'], $donation_org_id );

        $social_links = $selected_cause_info['social_links'];
        $org_logo = $selected_cause_info['image'] ?? esc_url( YBHD_PLUGIN_URL ) . 'public/img/humanity_fund.png';
        $background_color = $youbehero_data['widget_configurations']['confirmation_page']['confirmation_page']['background_color'] ?? "#ffffff";
        $text_color = $youbehero_data['widget_configurations']['confirmation_page']['confirmation_page']['text_color'] ?? "#000000";
        $plaisio_color = $youbehero_data['widget_configurations']['confirmation_page']['confirmation_page']['plaisio_color'] ?? "#cccccc";
?>

        <section class="youbehero-thankyou-widget">
            <div class="youbehero-tk-card" style="background: <?php echo esc_attr( $background_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>;">
            <!-- Top Icon -->
                <img class="youbehero-tk-icon" src="<?php echo esc_url( $org_logo ); ?>" alt="icon">

                <!-- Title -->
                <h3 style="color: <?php echo esc_attr( $text_color ); ?>;"><?php echo esc_html__( "Your donation has been recorded." , "youbehero");  ?></h3>
                <p class="tk-p1" style="color: <?php echo esc_attr( $text_color ); ?>;"><?php echo esc_html__( 'Thank you very much for your support and generosity.', 'youbehero' ); ?></p>

                <!-- Organization box -->
                <div class="youbehero-tk-org-box" style="background: <?php echo esc_attr( $plaisio_color ); ?>;">
                    <p style="color: <?php echo esc_attr( $text_color ); ?>;"><b><?php echo esc_html( $selected_cause_info['name'] ); ?></b></p>

                    <!-- Social Icons -->
                    <div class="youbehero-tk-social-icons">
                        <?php if( !empty( $selected_cause_info['url'] ) ) { ?>
                            <a href="<?php echo esc_url( $selected_cause_info['url'] ); ?>"><img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/ybh.svg" alt="icon"></a>
                        <?php }
                            if ( !empty( $social_links['twitter'] ) ) { ?>
                                <a href="<?php echo esc_url( $social_links['twitter'] ); ?>"><img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/x.svg" alt="icon"></a>
                        <?php }
                            if ( !empty( $social_links['instagram'] ) ) { ?>
                                <a href="<?php echo esc_url( $social_links['instagram'] ); ?>"><img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/insta.svg" alt="icon"></a>
                        <?php }
                            if ( !empty( $social_links['facebook'] ) ) { ?>
                                <a href="<?php echo esc_url( $social_links['facebook'] ); ?>"><img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/fb.svg" alt="icon"></a>
                        <?php }
                            if ( !empty( $social_links['youtube'] ) ) { ?>
                                <a href="<?php echo esc_url( $social_links['youtube'] ); ?>"><img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/yt.svg" alt="icon"></a>
                        <?php }
                            if ( !empty( $social_links['linkedin'] ) ) { ?>
                                <a href="<?php echo esc_url( $social_links['linkedin'] ); ?>"><img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/linkedin.svg" alt="icon"></a>
                            <?php } ?>
                    </div>

                    <p style="color: <?php echo esc_attr( $text_color ); ?>;"><?php echo esc_html__( 'Stay tuned for updates.', 'youbehero' ); ?></p>
                </div>
                <hr>
                <!-- Footer -->
                <div class="youbehero-tk-footer" style="color: <?php echo esc_attr( $text_color ); ?>;">
                    <!-- Learn More button -->
                    <a id="learn-more-btn" class="learn-more-btn"><?php echo esc_html__( 'Learn More', 'youbehero' ); ?></a>
                    <a class="youbehero-tk-footer-logo" href="youbehero.com"><img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/logo-dark.svg" alt="icon"></a>
                </div>
            </div>
            <!-- Modal -->
            <div id="youbehero-modal" class="youbehero-modal">
                <div class="youbehero-modal-content">
                    <div class="youbehero-modal-header">
                        <span class="youbehero-logo"><img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/logo-dark.svg" alt="icon"></span>
                        <span class="youbehero-close">&times;</span>
                    </div>

                    <div class="modal-body bg-gray-200">
                        <h5 class="youbehero-modal-title">
                            <?php echo esc_html__( 'See how your donation helps!', 'youbehero' ); ?>
                        </h5>
                        <p class="youbehero-modal-text-muted"><?php echo esc_html__( 'Sustainability, viability and transparency.', 'youbehero' ); ?></p>
                        <ul class="youbehero-vertical-dots">
                            <li>
                                <strong><?php echo esc_html__( 'Make a donation', 'youbehero' ); ?></strong>
                                <p>
                                    <?php echo esc_html__( 'Easily support a nonprofit of your choice at checkout.', 'youbehero' ); ?>
                                </p>
                            </li>
                            <li>
                                <strong><?php echo esc_html__( 'You are informed immediately', 'youbehero' ); ?> </strong>
                                <p>
                                    <?php echo esc_html__( 'In the confirmation email you will see details about your donation.', 'youbehero' ); ?>
                                </p>
                            </li>
                            <li>
                                <strong><?php echo esc_html__( 'Your donation is delivered securely.', 'youbehero' ); ?></strong>
                                <p>
                                    <?php echo esc_html__( 'With complete transparency, it supports the goals of the organization of your choice.', 'youbehero' ); ?>
                                </p>
                            </li>
                            <li>
                                <strong><?php echo esc_html__( 'You are supporting an important project.', 'youbehero' ); ?></strong>
                                <p>
                                    <?php echo esc_html__( 'Your every contribution has a meaningful impact.', 'youbehero' ); ?>
                                </p>
                            </li>
                        </ul>
                        <p class="font-weight-semibold mt-4 mb-2"><?php echo esc_html__( 'Through the YouBeHero platform', 'youbehero' ); ?></p>
                        <div class="col-12 bg-white rounded p-3">
                            <ul class="youbehero-second-list">
                                <li class="mb-2 smaller-1">
                                    <img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/long-arrow.svg" alt="icon"> <p><?php echo esc_html__( 'Track the progress of the donation', 'youbehero' ); ?></p>
                                </li>
                                <li class="mb-2 smaller-1">
                                    <img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/long-arrow.svg" alt="icon">
                                   <p> <?php echo esc_html__( 'You get in touch with the organization you support.', 'youbehero' ); ?></p>
                                </li>
                                <li class="smaller-1">
                                    <img src="<?php echo esc_url( YBHD_PLUGIN_URL ); ?>public/img/long-arrow.svg" alt="icon"> <p><?php echo esc_html__( 'You see the change you create.', 'youbehero' ); ?></p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <button class="youbehero-close-btn"><?php echo esc_html__( 'Closure', 'youbeehero' )?></button>
                </div>
            </div>
        </section>

<?php
    }
}