<?php

class YouBeHero_Email_Widget {

    /**
     * @var string[]
     */
    public array $headers;

    public function __construct() {
        $this->headers = array(
            'Content-Type: text/html; charset=UTF-8'
        );
    }

    public function youbehero_email_head() {
        ?>
        <style>
            .youbehero-thankyou-widget {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }
            .youbehero-tk-card {
                /*width: 508px;*/
                width: 100%;
                /*border-radius: 8px;*/
                gap: 20px;
                background: #fff;
                /*border-radius: 10px;*/
                padding: 30px;
                text-align: center;
                /*box-shadow: 0 4px 10px rgba(0,0,0,0.1);*/
            }
            
            .youbehero-tk-icon {
                width: 50px;
                margin-bottom: 15px;
            }
            
            .youbehero-tk-card h3 {
                font-size: 20px;
                font-weight: 600;
                margin: 10px 0;
            }
            .youbehero-tk-card .tk-p1 {
                font-family: Proxima Nova;
                font-weight: 400;
                font-size: 16px;
                leading-trim: NONE;
                line-height: 19px;
                text-align: center;
                color: #424242;
            }
            
            .youbehero-tk-org-box {
                background: #f3f3f3;
                border-radius: 8px;
                padding: 15px;
                margin: 15px 0;
                font-size: 14px;
                color: #333;
            }
            
            .youbehero-tk-social-icons {
                display: flex;
                justify-content: center;
                gap: 15px;
                margin-top: 10px;
            }
            
            .youbehero-tk-social-icons a {
                text-decoration: none;
                height: 20px;
                color: #000;
            }
            
            .youbehero-tk-social-icons a img {
                width: 20px;
                height: 20px;
            }
            
            .youbehero-tk-footer {
                font-size: 12px;
                color: #777;
                margin-top: 25px;
                justify-content: center;
                display: flex;
                align-items: center;   /* vertically center text + image */
                gap: 3px;              /* space between text and logo */
            }
            
            .youbehero-tk-footer p {
                margin: 0;             /* remove default p spacing */
            }
            
            .youbehero-tk-footer img, .youbehero-tk-footer svg {
                height: 12px;          /* adjust logo size */
            }
            
            .youbehero-thankyou-widget hr {
                border: 1px solid #F7F7F7;
            }
            
            .learn-more-btn {
                cursor: pointer;
                text-align: start;
                flex: 1;
                text-decoration: none;
            }
            
            .youbehero-tk-footer-logo {
                flex: 1;
                text-align: end;
            }
        </style>
        <?php
    }

    /**
     * @return string
     */
    public function youbehero_email_head1() {
        return '<style>
			img{-ms-interpolation-mode:bicubic;}
			table, td{mso-table-lspace:0pt;mso-table-rspace:0pt;}
			.mceStandardButton, .mceStandardButton td, .mceStandardButton td a{mso-hide:all!important;}
			p, a, li, td, blockquote{mso-line-height-rule:exactly;}
			p, a, li, td, body, table, blockquote{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;}
			.mcnPreviewText{display:none!important;}
			.bodyCell{margin:0 auto;padding:0;width:100%;}
			.ExternalClass, .ExternalClass p, .ExternalClass td, .ExternalClass div, .ExternalClass span, .ExternalClass font{line-height:100%;}
			.ReadMsgBody, .ExternalClass{width:100%;}
			a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}
			body{height:100%;margin:0;padding:0;width:100%;background:#ffffff;}
			p{margin:0;padding:0;}
			table{border-collapse:collapse;}
			h1, h2, h3, h4, h5, h6{display:block;margin:0;padding:0;}
			img, a img{border:0;height:auto;outline:none;text-decoration:none;}
			a[href^="tel"], a[href^="sms"]{color:inherit;cursor:default;text-decoration:none;}
			.mceColumn .mceButtonLink,
			.mceColumn-1 .mceButtonLink, 
			.mceColumn-2 .mceButtonLink, 
			.mceColumn-3 .mceButtonLink,
			.mceColumn-4 .mceButtonLink{min-width:30px;}
			div[contenteditable="true"]{outline:0;}
			.mceImageBorder{display:inline-block;}
			.mceImageBorder img{border:0!important;}
			body, #bodyTable{background-color:rgb(244, 244, 244);}
			.mceText, .mcnTextContent, .mceLabel{font-family:"Helvetica Neue", Helvetica, Arial, Verdana, sans-serif;}
			.mceText, .mcnTextContent, .mceLabel{color:rgb(0, 0, 0);}
			.mceText p, .mceText label, .mceText input{margin-bottom:0;}
			.mceSpacing-12 .mceInput + .mceErrorMessage{margin-top:-6px;}
			.mceSpacing-24 .mceInput + .mceErrorMessage{margin-top:-12px;}
			.mceInput{background-color:transparent;border:2px solid rgb(208, 208, 208);width:60%;color:rgb(77, 77, 77);display:block;}
			.mceInput[type="radio"], .mceInput[type="checkbox"]{width:auto!important;float:left;margin-right:12px;display:inline;}
			.mceLabel > .mceInput{margin-bottom:0;margin-top:2px;}
			.mceLabel{display:block;}
			.mceText p, .mcnTextContent p{color:rgb(0, 0, 0);font-family:"Helvetica Neue", Helvetica, Arial, Verdana, sans-serif;font-size:16px;font-weight:normal;line-height:1.5;mso-line-height-alt:150%;text-align:center;letter-spacing:0;direction:ltr;margin:0;}
			.mceText a, .mcnTextContent a{color:rgb(0, 0, 0);font-style:normal;font-weight:normal;text-decoration:underline;direction:ltr;}
			#d9 p, #d9 h1, #d9 h2, #d9 h3, #d9 h4, #d9 ul{text-align:center;}
			@media only screen and (max-width: 480px) {
			body, table, td, p, a, li, blockquote{-webkit-text-size-adjust:none!important;}
			body{width:100%!important;min-width:100%!important;}
			body.mobile-native{-webkit-user-select:none;user-select:none;transition:transform 0.2s ease-in;transform-origin:top center;}
			colgroup{display:none;}
			.mceLogo img, .mceImage img, .mceSocialFollowIcon img{height:auto!important;}
			.mceWidthContainer{max-width:660px!important;}
			.mceColumn, .mceColumn-2{display:block!important;width:100%!important;}
			.mceColumn-forceSpan{display:table-cell!important;width:auto!important;}
			.mceColumn-forceSpan .mceButton a{min-width:0!important;}
			.mceReverseStack{display:table;width:100%;}
			.mceColumn-1{display:table-footer-group;width:100%!important;}
			.mceColumn-3{display:table-header-group;width:100%!important;}
			.mceColumn-4{display:table-caption;width:100%!important;}
			.mceKeepColumns .mceButtonLink{min-width:0;}
			.mceBlockContainer, .mceSpacing-24{padding-right:16px!important;padding-left:16px!important;}
			.mceBlockContainerE2E{padding-right:0;padding-left:0;}
			.mceImage, .mceLogo{width:100%!important;height:auto!important;}
			.mceText img{max-width:100%!important;}
			.mceFooterSection .mceText, .mceFooterSection .mceText p{font-size:16px!important;line-height:140%!important;}
			.mceText p{font-size:16px!important;margin:0;line-height:1.5!important;mso-line-height-alt:150%;}
			.bodyCell{padding-left:16px!important;padding-right:16px!important;}
			.mceDividerContainer{width:100%!important;}
			#b5 .mceTextBlockContainer, #b20 .mceTextBlockContainer, #b22 .mceTextBlockContainer{padding:12px 24px!important;}
			#gutterContainerId-5, #gutterContainerId-9, #gutterContainerId-20, #gutterContainerId-22, #gutterContainerId-30{padding:0!important;}
			#b9 .mceTextBlockContainer{padding:12px 16px!important;}
			#b16{padding:12px 0!important;}
			#b16 table{margin-left:auto!important;margin-right:auto!important;float:none!important;}
			#b23 .mceDividerBlock{border-top-width:1px!important;}
			#b23{padding:20px 24px!important;}
			#b30 .mceTextBlockContainer{padding:0 24px 12px 12px!important;}
			#b31{padding:7px 12px 12px 0!important;}
			#b31 table{margin-left:auto!important;float:none!important;}
			}
			@media only screen and (max-width: 640px) {
			.mceClusterLayout td{padding:4px!important;}
			}
			</style>';
    }

    public function youbehero_email_body( $youbehero_data, $selected_cause_info ) {

//        $social_links = $selected_cause_info['social_links'];
//        $org_logo = $selected_cause_info['image'] ?? esc_url( YBHD_PLUGIN_URL ) . 'public/img/humanity_fund.png';
//        $background_color = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['background_color'] ?? "#ffffff";
//        $text_color = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['text_color'] ?? "#000000";
//        $plaisio_color = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['plaisio_color'] ?? "#cccccc";

        $social_links = $selected_cause_info['social_links'];
        $org_logo = $selected_cause_info['image'] ?? esc_url( YBHD_PLUGIN_URL ) . 'public/img/humanity_fund.png';
        $background_color = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['background_color'] ?? "#ffffff";
        $text_color = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['text_color'] ?? "#000000";
        $plaisio_color = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['plaisio_color'] ?? "#cccccc";
        $border = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['border'] ?? "";
        $border_color = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['border_color'] ?? "";
        $border_radius = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['border_radius'] ?? "";
        $widget_margin = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['margin'] ?? "";
        $widget_padding = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['padding'] ?? "";

        ?>
        <section class="youbehero-thankyou-widget">
            <div class="youbehero-tk-card" style="border: <?php echo esc_attr( $border. 'px solid' ); ?>; border-color: <?php echo esc_attr( $border_color ); ?>;  background: <?php echo esc_attr( $background_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>;">
            <!-- Top Icon -->
                <img class="youbehero-tk-icon" src="<?php echo esc_url( $org_logo ); ?>" alt="icon">

                <!-- Title -->
                <h3 style="text-align: center !important; color: <?php echo esc_attr( $text_color ); ?>;"><?php echo esc_html__( "Your donation has been recorded." , "youbehero");  ?></h3>
                <p class="tk-p1" style="color: <?php echo esc_attr( $text_color ); ?>;"><?php echo esc_html__( 'Thank you very much for your support and generosity.', 'youbehero' ); ?></p>

                <!-- Organization box -->
                <div class="youbehero-tk-org-box" style="background: <?php echo esc_attr( $plaisio_color ); ?>;">
                    <p style="color: <?php echo esc_attr( $text_color ); ?>;"><b><?php echo esc_html( $selected_cause_info['name'] ); ?></b></p>

                    <!-- Social Icons -->
                    <div class="youbehero-tk-social-icons">
                        <?php if( !empty( $selected_cause_info['url'] ) ) { ?>
                            <a href="<?php echo esc_url( $selected_cause_info['url'] ); ?>">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="YouBeHero icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/youbehero-filled-dark-40.png">
                            </a>
                        <?php }
                        if ( !empty( $social_links['twitter'] ) ) { ?>
                            <a href="<?php echo esc_url( $social_links['twitter'] ); ?>">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="X icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/twitter-filled-dark-40.png">
                            </a>
                        <?php }
                        if ( !empty( $social_links['instagram'] ) ) { ?>
                            <a href="<?php echo esc_url( $social_links['instagram'] ); ?>">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="Instagram icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/instagram-filled-dark-40.png">
                            </a>
                        <?php }
                        if ( !empty( $social_links['facebook'] ) ) { ?>
                            <a href="<?php echo esc_url( $social_links['facebook'] ); ?>">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="Facebook icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/facebook-filled-dark-40.png">
                            </a>
                        <?php }
                        if ( !empty( $social_links['youtube'] ) ) { ?>
                            <a href="<?php echo esc_url( $social_links['youtube'] ); ?>">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="YouTube icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/youtube-filled-dark-40.png">
                            </a>
                        <?php }
                        if ( !empty( $social_links['linkedin'] ) ) { ?>
                            <a href="<?php echo esc_url( $social_links['linkedin'] ); ?>">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="LinkedIn icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/linkedin-filled-dark-40.png">
                            </a>
                        <?php } ?>
                    </div>

                    <p style="margin:20px 0 0; color: <?php echo esc_attr( $text_color ); ?>;"><?php echo esc_html__( 'Stay tuned for updates.', 'youbehero' ); ?></p>
                </div>
                <hr>
                <!-- Footer -->
                <div class="youbehero-tk-footer" style="color: <?php echo esc_attr( $text_color ); ?>;">
                    <!-- Learn More button -->
                    <a id="learn-more-btn" class="learn-more-btn"><?php echo esc_html__( 'Learn More', 'youbehero' ); ?></a>
                    <a class="youbehero-tk-footer-logo" href="youbehero.com">
                        <img alt="" src="https://youbehero.com/img/wp-plugin-images/email_icons/d234e58a-0054-2807-de31-a7b021c8bb9e.png" width="89" height="auto" style="max-width:100%;height:auto;border-radius:0" class="imageDropZone mceImage">
                    </a>
                </div>
            </div>

        </section>
    <?php
    }

    /**
     * @param $youbehero_data
     * @param $selected_cause_info
     * @return string
     */
    public function youbehero_email_body1( $youbehero_data, $selected_cause_info ) {

        $social_links = $selected_cause_info['social_links'];
        $org_logo = $selected_cause_info['image'] ?? esc_url( YBHD_PLUGIN_URL ) . 'public/img/humanity_fund.png';
        $background_color = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['background_color'] ?? "#ffffff";
        $text_color = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['text_color'] ?? "#000000";
        $plaisio_color = $youbehero_data['widget_configurations']['confirmation_email']['confirmation_email']['plaisio_color'] ?? "#cccccc";

        $ybh_icon = $twitter_icon = $instagram_icon = $facebook_icon = $youtube_icon = $linkedin_icon = '';
        if( !empty( $selected_cause_info['url'] ) ) {

            $ybh_icon = '<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;float:left" role="presentation">
                <tbody>
                    <tr>
                        <td style="padding-top:3px;padding-bottom:3px;padding-left:12px;padding-right:12px" valign="top" class="mceSocialFollowIcon" align="center" width="32">
                            <a href="'. esc_url( $selected_cause_info['url'] ).'" target="_blank" rel="noreferrer">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="YouBeHero icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/youbehero-filled-dark-40.png">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>';

        }

        if ( !empty( $social_links['twitter'] ) ) {

            $twitter_icon = '<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;float:left" role="presentation">
                <tbody>
                    <tr>
                        <td style="padding-top:3px;padding-bottom:3px;padding-left:12px;padding-right:12px" valign="top" class="mceSocialFollowIcon" align="center" width="32">
                            <a href="'. esc_url( $social_links['twitter'] ).'" target="_blank" rel="noreferrer">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="X icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/twitter-filled-dark-40.png">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>';
        }

        if ( !empty( $social_links['instagram'] ) ) {

            $instagram_icon = '<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;float:left" role="presentation">
                <tbody>
                    <tr>
                        <td style="padding-top:3px;padding-bottom:3px;padding-left:12px;padding-right:12px" valign="top" class="mceSocialFollowIcon" align="center" width="32">
                            <a href="'. esc_url( $social_links['instagram'] ).'" target="_blank" rel="noreferrer">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="Instagram icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/instagram-filled-dark-40.png">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>';

        }

        if ( !empty( $social_links['facebook'] ) ) {

            $facebook_icon = '<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;float:left" role="presentation">
                <tbody>
                    <tr>
                        <td style="padding-top:3px;padding-bottom:3px;padding-left:12px;padding-right:12px" valign="top" class="mceSocialFollowIcon" align="center" width="32">
                            <a href="'. esc_url( $social_links['facebook'] ).'" target="_blank" rel="noreferrer">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="Facebook icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/facebook-filled-dark-40.png">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>';

        }

        if ( !empty( $social_links['youtube'] ) ) {

            $youtube_icon = '<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;float:left" role="presentation">
                <tbody>
                    <tr>
                        <td style="padding-top:3px;padding-bottom:3px;padding-left:12px;padding-right:12px" valign="top" class="mceSocialFollowIcon" align="center" width="32">
                            <a href="'. esc_url( $social_links['youtube'] ).'" target="_blank" rel="noreferrer">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="YouTube icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/youtube-filled-dark-40.png">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>';

        }

        if ( !empty( $social_links['linkedin'] ) ) {

            $linkedin_icon = '<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;float:left" role="presentation">
                <tbody>
                    <tr>
                        <td style="padding-top:3px;padding-bottom:3px;padding-left:12px;padding-right:12px" valign="top" class="mceSocialFollowIcon" align="center" width="32">
                            <a href="'. esc_url( $social_links['linkedin'] ).'" target="_blank" rel="noreferrer">
                                <img class="mceSocialFollowImage" width="32" height="32" alt="LinkedIn icon" src="https://youbehero.com/img/wp-plugin-images/email_icons/linkedin-filled-dark-40.png">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>';

        }

        return '<center>
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="background-color: '.$background_color.'">
                            <tbody>
                                <tr>
                                    <td class="bodyCell" align="center" valign="top">
                                        <table id="root" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody data-block-id="3" class="mceWrapper">
                                                <tr>
                                                    <td style="background-color:transparent" valign="top" align="center" class="mceSectionHeader">
                                                        <!--[if (gte mso 9)|(IE)]>
                                                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="660" style="width:660px;">
                                                            <tr>
                                                                <td>
                                                                    <![endif]-->
                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px" role="presentation">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="background-color:transparent" valign="top" class="mceWrapperInner">
                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" data-block-id="2">
                                                                                        <tbody>
                                                                                            <tr class="mceRow">
                                                                                                <td style="background-position:center;background-repeat:no-repeat;background-size:cover" valign="top">
                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td style="padding-top:0;padding-bottom:0" valign="top" class="mceColumn" id="mceColumnId--9" data-block-id="-9" colspan="12" width="100%">
                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td style="background-color:transparent;border:0;border-radius:0" valign="top" id="b18">
                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" data-block-id="18">
                                                                                                                                        <tbody>
                                                                                                                                            <tr>
                                                                                                                                                <td valign="top" class="mceSpacerBlock" height="40"></td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td style="background-color:transparent;padding-top:12px;padding-bottom:12px;padding-right:0;padding-left:0;border:0;border-radius:0" valign="top" class="mceImageBlockContainer" align="center" id="b16">
                                                                                                                                    <div>
                                                                                                                                        <!--[if !mso]><!-->
                                                                                                                                    </div>
                                                                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;margin:0;vertical-align:top;max-width:54px;width:100%;height:auto" role="presentation" data-testid="image-16">
                                                                                                                                        <tbody>
                                                                                                                                            <tr>
                                                                                                                                                <td style="border:0;border-radius:0;margin:0" valign="top">
                                                                                                                                                    <img alt="" src="'.esc_url( $org_logo ).'" width="54" height="auto" style="display:block;max-width:100%;height:auto;border-radius:0" class="imageDropZone mceImage" data-block-id="16">
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                    <div>
                                                                                                                                        <!--<![endif]-->
                                                                                                                                    </div>
                                                                                                                                    <div>
                                                                                                                                        <!--[if mso]>
                                                                                                                                        <span class="mceImageBorder" style="border:0;border-width:2px;vertical-align:top;margin:0">
                                                                                                                                            <img role="presentation" class="imageDropZone mceImage" src="https://mcusercontent.com/002f91629d56d1d3fdf44d440/images/33e806fe-7c60-31a5-6227-c0d3f77760c2.png" alt="" width="54" height="auto" style="display:block;max-width:54px;width:54px;height:auto"/>
                                                                                                                                        </span>
                                                                                                                                        <![endif]-->
                                                                                                                                    </div>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <!--[if (gte mso 9)|(IE)]>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <![endif]-->
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody data-block-id="7" class="mceWrapper">
                                                <tr>
                                                    <td style="background-color:transparent" valign="top" align="center" class="mceSectionBody">
                                                        <!--[if (gte mso 9)|(IE)]>
                                                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="660" style="width:660px;">
                                                            <tr>
                                                                <td>
                                                                    <![endif]-->
                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px" role="presentation">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="background-color:transparent" valign="top" class="mceWrapperInner">
                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" data-block-id="6">
                                                                                        <tbody>
                                                                                            <tr class="mceRow">
                                                                                                <td style="background-position:center;background-repeat:no-repeat;background-size:cover" valign="top">
                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td style="padding-top:0;padding-bottom:0" valign="top" class="mceColumn" id="mceColumnId--10" data-block-id="-10" colspan="12" width="100%">
                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0" valign="top" class="mceGutterContainer" id="gutterContainerId-5">
                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate" role="presentation">
                                                                                                                                        <tbody>
                                                                                                                                            <tr>
                                                                                                                                                <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;border:0;border-radius:0" valign="top" id="b5">
                                                                                                                                                    <table width="100%" style="border:0;background-color:transparent;border-radius:0;border-collapse:separate">
                                                                                                                                                        <tbody>
                                                                                                                                                            <tr>
                                                                                                                                                                <td style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px" class="mceTextBlockContainer">
                                                                                                                                                                    <div data-block-id="5" class="mceText" id="d5" style="width:100%">
                                                                                                                                                                        <p>
                                                                                                                                                                            <strong>
                                                                                                                                                                                <span style="color:#000000;">
                                                                                                                                                                                    <span style="font-size: 20px">
                                                                                                                                                                                        '. esc_html__( "Your donation has been recorded." , "youbehero") .'<br>
                                                                                                                                                                                    </span>
                                                                                                                                                                                </span>
                                                                                                                                                                            </strong>
                                                                                                                                                                        </p>
                                                                                                                                                                        <p class="last-child">
                                                                                                                                                                            <span style="color:#000000;">
                                                                                                                                                                                '. esc_html__( 'Thank you very much for your support and generosity.', 'youbehero' ) .'
                                                                                                                                                                            </span>
                                                                                                                                                                        </p>
                                                                                                                                                                    </div>
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                        </tbody>
                                                                                                                                                    </table>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <!--[if (gte mso 9)|(IE)]>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <![endif]-->
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody data-block-id="13" class="mceWrapper">
                                                <tr>
                                                    <td style="background-color:transparent" valign="top" align="center" class="mceSectionFooter">
                                                        <!--[if (gte mso 9)|(IE)]>
                                                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="660" style="width:660px;">
                                                            <tr>
                                                                <td>
                                                                    <![endif]-->
                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px" role="presentation">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="background-color:transparent" valign="top" class="mceWrapperInner">
                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" data-block-id="12">
                                                                                        <tbody>
                                                                                            <tr class="mceRow">
                                                                                                <td style="background-position:center;background-repeat:no-repeat;background-size:cover" valign="top">
                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td style="padding-top:0;padding-bottom:0" valign="top" class="mceColumn" id="mceColumnId--11" data-block-id="-11" colspan="12" width="100%">
                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td style="background-color:transparent;border:0;border-radius:0" valign="top" id="b19">
                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" data-block-id="19">
                                                                                                                                        <tbody>
                                                                                                                                            <tr>
                                                                                                                                                <td valign="top" class="mceSpacerBlock" height="23"></td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0" valign="top" class="mceGutterContainer" id="gutterContainerId-20">
                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate" role="presentation">
                                                                                                                                        <tbody>
                                                                                                                                            <tr>
                                                                                                                                                <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;border:0;border-radius:0" valign="top" id="b20">
                                                                                                                                                    <table width="100%" style="border:0;background-color:'.esc_attr( $plaisio_color ).';border-radius:0;border-collapse:separate">
                                                                                                                                                        <tbody>
                                                                                                                                                            <tr>
                                                                                                                                                                <td style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px" class="mceTextBlockContainer">
                                                                                                                                                                    <div data-block-id="20" class="mceText" id="d20" style="width:100%">
                                                                                                                                                                        <p class="last-child">
                                                                                                                                                                            <strong>
                                                                                                                                                                                <span style="color:#000000;">
                                                                                                                                                                                    '. esc_html( $selected_cause_info['name'] ) .'
                                                                                                                                                                                </span>
                                                                                                                                                                            </strong>
                                                                                                                                                                        </p>
                                                                                                                                                                    </div>
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                        </tbody>
                                                                                                                                                    </table>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td style="background-color'.esc_attr( $plaisio_color ).';padding-right:0;padding-left:0;border:0;border-radius:0" valign="top" class="mceLayoutContainer" id="b21">
                                                                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" data-block-id="21">
                                                                                                                                        <tbody>
                                                                                                                                            <tr class="mceRow">
                                                                                                                                                <td style="background-color:'.esc_attr( $plaisio_color ).';background-position:center;background-repeat:no-repeat;background-size:cover;padding-top:0px;padding-bottom:0px" valign="top">
                                                                                                                                                    <table border="0" cellpadding="0" cellspacing="24" width="100%" role="presentation">
                                                                                                                                                        <tbody>
                                                                                                                                                            <tr>
                                                                                                                                                                <td valign="top" class="mceColumn" id="mceColumnId--6" data-block-id="-6" colspan="12" width="100%">
                                                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                                                                        <tbody>
                                                                                                                                                                            <tr>
                                                                                                                                                                                <td style="border:0;border-radius:0" valign="top" class="mceSocialFollowBlockContainer" id="b-5">
                                                                                                                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" class="mceSocialFollowBlock" data-block-id="-5">
                                                                                                                                                                                        <tbody>
                                                                                                                                                                                            <tr>
                                                                                                                                                                                                <td valign="middle" align="center">
                                                                                                                                                                                                    <!--[if mso]>
                                                                                                                                                                                                    <table align="left" border="0" cellspacing= "0" cellpadding="0">
                                                                                                                                                                                                        <tr>
                                                                                                                                                                                                        <![endif]-->
                                                                                                                                                                                                        <!--[if mso]>
                                                                                                                                                                                                            <td align="center" valign="top">
                                                                                                                                                                                                                <![endif]-->
                                                                                                                                                                                                                '. $ybh_icon .'
                                                                                                                                                                                                                <!--[if mso]>
                                                                                                                                                                                                            </td>
                                                                                                                                                                                                            <![endif]-->
                                                                                                                                                                                                            <!--[if mso]>
                                                                                                                                                                                                            <td align="center" valign="top">
                                                                                                                                                                                                                <![endif]-->
                                                                                                                                                                                                                '. $twitter_icon .'
                                                                                                                                                                                                                <!--[if mso]>
                                                                                                                                                                                                            </td>
                                                                                                                                                                                                            <![endif]-->
                                                                                                                                                                                                            <!--[if mso]>
                                                                                                                                                                                                            <td align="center" valign="top">
                                                                                                                                                                                                                <![endif]-->
                                                                                                                                                                                                                '. $instagram_icon .'
                                                                                                                                                                                                                <!--[if mso]>
                                                                                                                                                                                                            </td>
                                                                                                                                                                                                            <![endif]-->
                                                                                                                                                                                                            <!--[if mso]>
                                                                                                                                                                                                            <td align="center" valign="top">
                                                                                                                                                                                                                <![endif]-->
                                                                                                                                                                                                                '. $facebook_icon .'
                                                                                                                                                                                                                <!--[if mso]>
                                                                                                                                                                                                            </td>
                                                                                                                                                                                                            <![endif]-->
                                                                                                                                                                                                            <!--[if mso]>
                                                                                                                                                                                                            <td align="center" valign="top">
                                                                                                                                                                                                                <![endif]-->
                                                                                                                                                                                                                '. $youtube_icon .'
                                                                                                                                                                                                                <!--[if mso]>
                                                                                                                                                                                                            </td>
                                                                                                                                                                                                            <![endif]-->
                                                                                                                                                                                                            <!--[if mso]>
                                                                                                                                                                                                            <td align="center" valign="top">
                                                                                                                                                                                                                <![endif]-->
                                                                                                                                                                                                                '. $linkedin_icon .'
                                                                                                                                                                                                                <!--[if mso]>
                                                                                                                                                                                                            </td>
                                                                                                                                                                                                            <![endif]-->
                                                                                                                                                                                                            <!--[if mso]>
                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                    </table>
                                                                                                                                                                                                    <![endif]-->
                                                                                                                                                                                                </td>
                                                                                                                                                                                            </tr>
                                                                                                                                                                                        </tbody>
                                                                                                                                                                                    </table>
                                                                                                                                                                                </td>
                                                                                                                                                                            </tr>
                                                                                                                                                                        </tbody>
                                                                                                                                                                    </table>
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                        </tbody>
                                                                                                                                                    </table>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0" valign="top" class="mceGutterContainer" id="gutterContainerId-22">
                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate" role="presentation">
                                                                                                                                        <tbody>
                                                                                                                                            <tr>
                                                                                                                                                <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;border:0;border-radius:0" valign="top" id="b22">
                                                                                                                                                    <table width="100%" style="border:0;background-color:'.esc_attr( $plaisio_color ).';border-radius:0;border-collapse:separate">
                                                                                                                                                        <tbody>
                                                                                                                                                            <tr>
                                                                                                                                                                <td style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px" class="mceTextBlockContainer">
                                                                                                                                                                    <div data-block-id="22" class="mceText" id="d22" style="width:100%">
                                                                                                                                                                        <p class="titleText smaller-2 mt-2 mb-0 last-child" style="text-align: center;">
                                                                                                                                                                            <span style="color:#000000;">
                                                                                                                                                                                <span style="font-size: 14px">
                                                                                                                                                                                    '. esc_html__( 'Stay tuned for updates.', 'youbehero' ) .'
                                                                                                                                                                                </span>
                                                                                                                                                                            </span>
                                                                                                                                                                        </p>
                                                                                                                                                                    </div>
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                        </tbody>
                                                                                                                                                    </table>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td style="background-color:transparent;padding-top:20px;padding-bottom:20px;padding-right:24px;padding-left:24px;border:0;border-radius:0" valign="top" class="mceDividerBlockContainer" id="b23">
                                                                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:transparent;width:100%" role="presentation" class="mceDividerContainer" data-block-id="23">
                                                                                                                                        <tbody>
                                                                                                                                            <tr>
                                                                                                                                                <td style="min-width:100%;border-top-width:1px;border-top-style:solid;border-top-color:#c2c2c2;line-height:0;font-size:0" valign="top" class="mceDividerBlock">
                                                                                                                                                    &nbsp;
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td valign="top" class="mceGutterContainer" id="gutterContainerId-24">
                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate" role="presentation">
                                                                                                                                        <tbody>
                                                                                                                                            <tr>
                                                                                                                                                <td style="padding-top:12px;padding-bottom:16px;padding-right:0;padding-left:0;border:0;border-radius:0" valign="top" class="mceLayoutContainer" id="b24">
                                                                                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" data-block-id="24" id="section_a11180dea1b46d1a09fb56490b5dd0c2" class="mceLayout">
                                                                                                                                                        <tbody>
                                                                                                                                                            <tr class="mceRow">
                                                                                                                                                                <td style="background-position:center;background-repeat:no-repeat;background-size:cover" valign="top">
                                                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                                                                        <tbody>
                                                                                                                                                                            <tr>
                                                                                                                                                                                <td valign="top" class="mceColumn" id="mceColumnId--12" data-block-id="-12" colspan="12" width="100%">
                                                                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                                                                                        <tbody>
                                                                                                                                                                                            <tr>
                                                                                                                                                                                                <td style="border:0;border-radius:0" valign="top" align="center" id="b-8">
                                                                                                                                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" data-block-id="-8">
                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                            <tr class="mceRow">
                                                                                                                                                                                                                <td style="background-position:center;background-repeat:no-repeat;background-size:cover" valign="top">
                                                                                                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                <td valign="top" class="mceColumn" id="mceColumnId--14" data-block-id="-14" colspan="12" width="100%">
                                                                                                                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                <td style="border:0;border-radius:0" valign="top" id="b29">
                                                                                                                                                                                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" data-block-id="29">
                                                                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                                                                            <tr class="mceRow">
                                                                                                                                                                                                                                                                <td style="background-position:center;background-repeat:no-repeat;background-size:cover;padding-top:0px;padding-bottom:0px" valign="top">
                                                                                                                                                                                                                                                                    <table border="0" cellpadding="0" cellspacing="24" width="100%" style="table-layout:fixed" role="presentation">
                                                                                                                                                                                                                                                                        <colgroup>
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                            <col span="1" width="8.333333333333332%">
                                                                                                                                                                                                                                                                        </colgroup>
                                                                                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                                                                                            <tr class="mceKeepColumns">
                                                                                                                                                                                                                                                                                <td style="padding-top:0;padding-bottom:0" valign="top" id="mceColumnId-26" data-block-id="26" colspan="6" width="50%">
                                                                                                                                                                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                                                                                                            <tr>    
                                                                                                                                                                                                                                                                                                <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0" valign="top" class="mceGutterContainer" id="gutterContainerId-30">
                                                                                                                                                                                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate" role="presentation">
                                                                                                                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                                                                                <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;border:0;border-radius:0" valign="top" id="b30">
                                                                                                                                                                                                                                                                                                                    <table width="100%" style="border:0;background-color:transparent;border-radius:0;border-collapse:separate">
                                                                                                                                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                                                                                                <td style="padding-left:12px;padding-right:24px;padding-top:0;padding-bottom:12px" class="mceTextBlockContainer">
                                                                                                                                                                                                                                                                                                                                    <div data-block-id="30" class="mceText" id="d30" style="width:100%">
                                                                                                                                                                                                                                                                                                                                        <p style="text-align: left;" class="last-child">
                                                                                                                                                                                                                                                                                                                                            <a href="https://youbehero.com/gr/signup-eshop" target="_blank">
                                                                                                                                                                                                                                                                                                                                                <span style="font-size: 14px">
                                                                                                                                                                                                                                                                                                                                                    '. esc_html__( 'Learn More', 'youbehero' ) .'
                                                                                                                                                                                                                                                                                                                                                </span>
                                                                                                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                                                                                                        </p>
                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                                                                                                                                    </table>
                                                                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                                                                                                                    </table>
                                                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                                                                                                    </table>
                                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                                                <td style="padding-top:0;padding-bottom:0" valign="top" id="mceColumnId-28" data-block-id="28" colspan="6" width="50%">
                                                                                                                                                                                                                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                                                                                                                                                                                                                                                                        <tbody>
                                                                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                                                                <td style="background-color:transparent;padding-top:7px;padding-bottom:12px;padding-right:12px;padding-left:0;border:0;border-radius:0" valign="top" class="mceImageBlockContainer" align="right" id="b31">
                                                                                                                                                                                                                                                                                                    <div>
                                                                                                                                                                                                                                                                                                        <!--[if !mso]><!-->
                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                    <a href="https://youbehero.com/" style="display:block" target="_blank" data-block-id="31">
                                                                                                                                                                                                                                                                                                        <table align="right" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate;margin:0;vertical-align:top;max-width:89px;width:100%;height:auto" role="presentation" data-testid="image-31">
                                                                                                                                                                                                                                                                                                            <tbody>
                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                                                    <td style="border:0;border-radius:0;margin:0" valign="top">
                                                                                                                                                                                                                                                                                                                        <img alt="" src="https://youbehero.com/img/wp-plugin-images/email_icons/d234e58a-0054-2807-de31-a7b021c8bb9e.png" width="89" height="auto" style="display:block;max-width:100%;height:auto;border-radius:0" class="imageDropZone mceImage">
                                                                                                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                                                                                                                            </tbody>
                                                                                                                                                                                                                                                                                                        </table>
                                                                                                                                                                                                                                                                                                    </a>
                                                                                                                                                                                                                                                                                                    <div>
                                                                                                                                                                                                                                                                                                        <!--<![endif]-->
                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                    <div>
                                                                                                                                                                                                                                                                                                        <!--[if mso]>
                                                                                                                                                                                                                                                                                                        <a href="https://youbehero.com/">
                                                                                                                                                                                                                                                                                                            <span class="mceImageBorder" style="border:0;border-width:2px;vertical-align:top;margin:0">
                                                                                                                                                                                                                                                                                                                <img role="presentation" class="imageDropZone mceImage" src="https://mcusercontent.com/002f91629d56d1d3fdf44d440/images/d234e58a-0054-2807-de31-a7b021c8bb9e.png" alt="" width="89" height="auto" style="display:block;max-width:89px;width:89px;height:auto"/>
                                                                                                                                                                                                                                                                                                            </span>
                                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                                        <![endif]-->
                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                                                                                                    </table>
                                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                                                                                    </table>
                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                                                                    </table>
                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                                                    </table>
                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                                    </table>
                                                                                                                                                                                                                </td>
                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                        </tbody>
                                                                                                                                                                                                    </table>
                                                                                                                                                                                                </td>
                                                                                                                                                                                            </tr>
                                                                                                                                                                                        </tbody>
                                                                                                                                                                                    </table>
                                                                                                                                                                                </td>
                                                                                                                                                                            </tr>
                                                                                                                                                                        </tbody>
                                                                                                                                                                    </table>
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                        </tbody>
                                                                                                                                                    </table>
                                                                                                                                                </td>
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <!--[if (gte mso 9)|(IE)]>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <![endif]-->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>';
    }

    /**
     * @param $order
     * @param $youbehero_data
     * @param $selected_cause_info
     * @return void
     */
    public function youbehero_send_email( $order, $youbehero_data, $selected_cause_info ) {

//        $email_address = $order->get_billing_email();
//        $email_body = $this->youbehero_email_head() . $this->youbehero_email_body( $youbehero_data, $selected_cause_info );
        $this->youbehero_email_head() . $this->youbehero_email_body( $youbehero_data, $selected_cause_info );
//        $email_body = $this->youbehero_email_body( $youbehero_data, $selected_cause_info );
//        $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
//        $subject = "YouBeHero Donation from $customer_name";
//        wp_mail( $email_address, $subject, $email_body, $this->headers );
//        return $email_body;

    }

}