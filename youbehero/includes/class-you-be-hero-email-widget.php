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

    /**
     * @return string
     */
    public function youbehero_email_head() {
        return '<!DOCTYPE html>
                    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
                    <head>
                        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                        <!--[if gte mso 15]>
                        <xml>
                        <o:OfficeDocumentSettings>
                        <o:AllowPNG/>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                        </o:OfficeDocumentSettings>
                        </xml>
                        <![endif]-->
                        <meta charset="UTF-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <title>Untitled</title>
                        <link rel="preconnect" href="https://fonts.googleapis.com/">
                        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
                        <style>
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
                            td, p, a{word-break:break-word;}
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
                        </style>
                    </head>';
    }

    /**
     * @param $youbehero_data
     * @param $selected_cause_info
     * @return string
     */
    public function youbehero_email_body( $youbehero_data, $selected_cause_info ) {

        $social_links = $selected_cause_info['social_links'];
        $org_logo = $selected_cause_info['image'] ?? esc_url( YBHD_PLUGIN_URL ) . 'public/img/humanity_fund.png';
        $text_color = $youbehero_data['widget_configurations']['confirmation_page']['confirmation_page']['text_color'] ?? "#000000";

        $ybh_icon = $twitter_icon = $instagram_icon = $facebook_icon = $youtube_icon = $linkedin_icon = '';
        if( !empty( $selected_cause_info['url'] ) ) {

            $ybh_icon = '<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;float:left" role="presentation">
                <tbody>
                    <tr>
                        <td style="padding-top:3px;padding-bottom:3px;padding-left:12px;padding-right:12px" valign="top" class="mceSocialFollowIcon" align="center" width="32">
                            <a href="'. esc_url( $selected_cause_info['url'] ).'" target="_blank" rel="noreferrer">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.498535" y="0.606262" width="15" height="15" rx="1.5" fill="'.$text_color.'"/>
                                    <rect x="0.498535" y="0.606262" width="15" height="15" rx="1.5" stroke="'.$text_color.'"/>
                                    <path d="M11.9983 4.10626H9.70627V6.34446H11.9983V4.10626Z" fill="white"/>
                                    <path d="M6.29055 4.10626H3.99854V6.34446H6.29055V4.10626Z" fill="white"/>
                                    <path d="M9.70652 7.45257V7.76282C9.70652 9.13677 8.97925 9.9567 7.98752 9.9567C6.86355 9.9567 6.29055 8.95948 6.29055 7.76282V7.45257H3.99854V7.91795C3.99854 10.6215 5.60736 12.1063 7.98752 12.1063C10.566 12.1063 11.9985 10.4442 11.9985 7.91795V7.45257H9.70652Z" fill="white"/>
                                </svg>
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
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.3951 0.106262H14.8101L9.53541 6.88319L15.7405 16.1063H10.8832L7.07594 10.514L2.72482 16.1063H0.306397L5.94711 8.85626L-0.00146484 0.106262H4.97906L8.41685 5.2178L12.3951 0.106262ZM11.5468 14.4832H12.8843L4.25045 1.64472H2.81376L11.5468 14.4832Z" fill="'. $text_color .'"/>
                                </svg>
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
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.6679 8.10626C10.6678 7.48944 10.4539 6.8917 10.0625 6.4149C9.67116 5.93809 9.12654 5.61172 8.52147 5.49137C7.9164 5.37103 7.28831 5.46417 6.74422 5.75492C6.20013 6.04567 5.7737 6.51604 5.53758 7.0859C5.30146 7.65576 5.27026 8.28984 5.4493 8.88012C5.62833 9.47039 6.00653 9.98035 6.51945 10.3231C7.03237 10.6658 7.64828 10.8202 8.26224 10.7598C8.87621 10.6994 9.45024 10.428 9.88654 9.99195C10.1343 9.75268 10.3311 9.46588 10.4654 9.14874C10.5997 8.8316 10.6685 8.49063 10.6679 8.14626L10.6672 8.10426L10.6679 8.10626ZM12.1079 8.10626C12.1047 9.05174 11.7739 9.9669 11.1718 10.696C10.5697 11.4251 9.73359 11.9231 8.80566 12.1052C7.87772 12.2873 6.91534 12.1423 6.0823 11.6948C5.24925 11.2474 4.59702 10.5251 4.23661 9.651C3.87619 8.77688 3.82986 7.80489 4.10549 6.90046C4.38113 5.99603 4.9617 5.21505 5.74841 4.69041C6.53511 4.16577 7.47934 3.92991 8.42039 4.02295C9.36145 4.116 10.2412 4.53221 10.9099 5.20075C11.2897 5.56912 11.5915 6.01009 11.7974 6.49743C12.0033 6.98478 12.1091 7.50855 12.1085 8.03761L12.1079 8.11026V8.10626ZM13.2325 3.83631V3.83764C13.2326 4.05971 13.1557 4.27493 13.0148 4.44664C12.874 4.61834 12.6779 4.7359 12.4601 4.77929C12.2423 4.82268 12.0161 4.78921 11.8202 4.68459C11.6243 4.57996 11.4708 4.41065 11.3857 4.20551C11.3007 4.00037 11.2894 3.77209 11.3538 3.55957C11.4182 3.34705 11.5543 3.16343 11.739 3.04001C11.9236 2.91659 12.1454 2.861 12.3664 2.88271C12.5874 2.90442 12.7941 3.0021 12.9512 3.15909C13.1219 3.32639 13.2279 3.55969 13.2279 3.81764V3.83697L13.2325 3.83631ZM8.00587 1.54336L7.2092 1.53802C6.72654 1.53447 6.36009 1.53447 6.10987 1.53802C5.85965 1.54158 5.52454 1.55202 5.10454 1.56935C4.71454 1.58268 4.34454 1.62134 3.98254 1.68267L4.0312 1.676C3.74787 1.72266 3.49654 1.78931 3.25587 1.87797L3.28454 1.86864C2.9446 2.00539 2.63546 2.20876 2.37533 2.46679C2.1152 2.72481 1.90934 3.03227 1.76987 3.37105L1.7632 3.38905C1.67772 3.62325 1.61434 3.86493 1.57387 4.11093L1.57054 4.13559C1.51172 4.4859 1.47631 4.83973 1.46454 5.19475L1.46387 5.20874C1.44654 5.62912 1.43609 5.96417 1.43254 6.21391C1.42898 6.46365 1.42898 6.83003 1.43254 7.31306C1.43609 7.79609 1.43787 8.0616 1.43787 8.10959C1.43787 8.15759 1.43609 8.4231 1.43254 8.90613C1.42898 9.38916 1.42898 9.75554 1.43254 10.0053C1.43609 10.255 1.44654 10.5901 1.46387 11.0104C1.4772 11.4004 1.51587 11.7703 1.5772 12.1323L1.57054 12.0836C1.6172 12.3669 1.68387 12.6182 1.77254 12.8588L1.7632 12.8301C1.89998 13.17 2.10339 13.4791 2.36145 13.7392C2.61952 13.9993 2.92703 14.2051 3.26587 14.3446L3.28387 14.3512C3.49587 14.4305 3.7472 14.4972 4.00587 14.5405L4.03054 14.5439C4.3432 14.5985 4.7132 14.6372 5.0892 14.6498L5.1032 14.6505C5.52365 14.6678 5.85876 14.6783 6.10854 14.6818C6.35831 14.6854 6.72476 14.6854 7.20787 14.6818L7.99987 14.6658L8.79654 14.6712C9.2792 14.6747 9.64565 14.6747 9.89587 14.6712C10.1461 14.6676 10.4812 14.6572 10.9012 14.6398C11.2912 14.6265 11.6612 14.5878 12.0232 14.5265L11.9745 14.5332C12.2579 14.4865 12.5092 14.4199 12.7499 14.3312L12.7212 14.3406C13.0611 14.2038 13.3703 14.0004 13.6304 13.7424C13.8905 13.4844 14.0964 13.1769 14.2359 12.8381L14.2425 12.8201C14.3219 12.6082 14.3885 12.3569 14.4319 12.0983L14.4352 12.0736C14.4899 11.761 14.5285 11.391 14.5412 11.0151L14.5419 11.0011C14.5592 10.5807 14.5696 10.2457 14.5732 9.99595C14.5768 9.74621 14.5768 9.37983 14.5732 8.8968C14.5696 8.41377 14.5679 8.14825 14.5679 8.10026C14.5679 8.05227 14.5696 7.78676 14.5732 7.30373C14.5768 6.8207 14.5768 6.45431 14.5732 6.20458C14.5696 5.95484 14.5592 5.61979 14.5419 5.19941C14.5285 4.80948 14.4899 4.43954 14.4285 4.0776L14.4352 4.12626C14.3927 3.86201 14.3251 3.60243 14.2332 3.35105L14.2425 3.37972C14.1058 3.03983 13.9024 2.73075 13.6443 2.47067C13.3862 2.21058 13.0787 2.00475 12.7399 1.8653L12.7219 1.85864C12.4876 1.77317 12.2459 1.7098 11.9999 1.66933L11.9752 1.666C11.6251 1.60723 11.2714 1.57182 10.9165 1.56002L10.9025 1.55935C10.4821 1.54202 10.147 1.53158 9.8972 1.52803C9.64742 1.52447 9.28098 1.52447 8.79787 1.52803L8.00587 1.54336ZM16.0012 8.10626C16.0012 9.69622 15.9834 10.7967 15.9479 11.4077C15.9794 12.0269 15.8804 12.6459 15.6574 13.2244C15.4344 13.8029 15.0923 14.3282 14.6532 14.766C14.2142 15.2039 13.6881 15.5447 13.1089 15.7663C12.5297 15.9878 11.9104 16.0853 11.2912 16.0523L11.3019 16.0529C10.6908 16.0885 9.59009 16.1063 7.99987 16.1063C6.40965 16.1063 5.30898 16.0885 4.69787 16.0529C4.07855 16.0844 3.45951 15.9855 2.88089 15.7625C2.30226 15.5395 1.77694 15.1975 1.33898 14.7585C0.901026 14.3196 0.560196 13.7935 0.338582 13.2144C0.116968 12.6354 0.0195138 12.0162 0.0525352 11.397L0.0518685 11.4077C0.0163129 10.7967 -0.00146484 9.69622 -0.00146484 8.10626C-0.00146484 6.5163 0.0163129 5.41582 0.0518685 4.80481C0.0203561 4.18559 0.119319 3.56666 0.342344 2.98813C0.565369 2.4096 0.907479 1.88437 1.34651 1.44649C1.78553 1.0086 2.31168 0.66783 2.89085 0.446252C3.47002 0.224675 4.08929 0.127237 4.70854 0.160253L4.69787 0.159587C5.30898 0.124037 6.40965 0.106262 7.99987 0.106262C9.59009 0.106262 10.6908 0.124037 11.3019 0.159587C11.9212 0.12808 12.5402 0.227026 13.1189 0.450014C13.6975 0.673001 14.2228 1.01505 14.6608 1.45401C15.0987 1.89296 15.4395 2.41902 15.6612 2.99809C15.8828 3.57717 15.9802 4.19634 15.9472 4.81548L15.9479 4.80481C15.9834 5.41538 16.0012 6.51586 16.0012 8.10626Z" fill="'.$text_color.'"/>
                                </svg>
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
                                <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.07133 16.1063V8.5986H0.0693359V5.89548H2.07133V3.58666C2.07133 1.77237 3.25392 0.106262 5.97885 0.106262C7.08213 0.106262 7.89795 0.211142 7.89795 0.211142L7.83367 2.7354C7.83367 2.7354 7.00166 2.72737 6.09373 2.72737C5.11108 2.72737 4.95364 3.17641 4.95364 3.9217V5.89548H7.91178L7.78307 8.5986H4.95364V16.1063H2.07133Z" fill="'.$text_color.'"/>
                                </svg>
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
                                <svg width="23" height="17" viewBox="0 0 23 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.6167 2.60972C21.3669 1.6243 20.6307 0.848221 19.6959 0.584846C18.0016 0.106262 11.2077 0.106262 11.2077 0.106262C11.2077 0.106262 4.41385 0.106262 2.71952 0.584846C1.78477 0.848262 1.04858 1.6243 0.798712 2.60972C0.344727 4.39585 0.344727 8.12243 0.344727 8.12243C0.344727 8.12243 0.344727 11.849 0.798712 13.6351C1.04858 14.6206 1.78477 15.3643 2.71952 15.6277C4.41385 16.1063 11.2077 16.1063 11.2077 16.1063C11.2077 16.1063 18.0016 16.1063 19.6959 15.6277C20.6307 15.3643 21.3669 14.6206 21.6167 13.6351C22.0707 11.849 22.0707 8.12243 22.0707 8.12243C22.0707 8.12243 22.0707 4.39585 21.6167 2.60972ZM8.98573 11.5059V4.73897L14.6641 8.12251L8.98573 11.5059Z" fill="'.$text_color.'"/>
                                </svg>
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
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 0C16.5304 0 17.0391 0.210714 17.4142 0.585786C17.7893 0.960859 18 1.46957 18 2V16C18 16.5304 17.7893 17.0391 17.4142 17.4142C17.0391 17.7893 16.5304 18 16 18H2C1.46957 18 0.960859 17.7893 0.585786 17.4142C0.210714 17.0391 0 16.5304 0 16V2C0 1.46957 0.210714 0.960859 0.585786 0.585786C0.960859 0.210714 1.46957 0 2 0H16ZM15.5 15.5V10.2C15.5 9.33539 15.1565 8.5062 14.5452 7.89483C13.9338 7.28346 13.1046 6.94 12.24 6.94C11.39 6.94 10.4 7.46 9.92 8.24V7.13H7.13V15.5H9.92V10.57C9.92 9.8 10.54 9.17 11.31 9.17C11.6813 9.17 12.0374 9.3175 12.2999 9.58005C12.5625 9.8426 12.71 10.1987 12.71 10.57V15.5H15.5ZM3.88 5.56C4.32556 5.56 4.75288 5.383 5.06794 5.06794C5.383 4.75288 5.56 4.32556 5.56 3.88C5.56 2.95 4.81 2.19 3.88 2.19C3.43178 2.19 3.00193 2.36805 2.68499 2.68499C2.36805 3.00193 2.19 3.43178 2.19 3.88C2.19 4.81 2.95 5.56 3.88 5.56ZM5.27 15.5V7.13H2.5V15.5H5.27Z" fill="'.$text_color.'"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>';

        }

        return '<!--<body>-->
                    <center>
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="background-color: rgb(244, 244, 244);">
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
                                                                                <td style="background-color:#ffffff" valign="top" class="mceWrapperInner">
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
                                                                                <td style="background-color:#ffffff" valign="top" class="mceWrapperInner">
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
                                                                                <td style="background-color:#ffffff" valign="top" class="mceWrapperInner">
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
                                                                                                                                                    <table width="100%" style="border:0;background-color:#3ecf8e;border-radius:0;border-collapse:separate">
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
                                                                                                                                <td style="background-color:#3ecf8e;padding-top:12px;padding-bottom:12px;padding-right:0;padding-left:0;border:0;border-radius:0" valign="top" class="mceLayoutContainer" id="b21">
                                                                                                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" data-block-id="21">
                                                                                                                                        <tbody>
                                                                                                                                            <tr class="mceRow">
                                                                                                                                                <td style="background-color:#3ecf8e;background-position:center;background-repeat:no-repeat;background-size:cover;padding-top:0px;padding-bottom:0px" valign="top">
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
                                                                                                                                                    <table width="100%" style="border:0;background-color:#3ecf8e;border-radius:0;border-collapse:separate">
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
                                                                                                                                                                                                                                                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="92" height="16" viewBox="0 0 92 16" fill="none">
                                                                                                                                                                                                                                                                                                                            <path d="M30.1395 3.08781H30.0569C29.3031 3.08781 28.692 3.69893 28.692 4.45278C28.692 5.20663 29.3031 5.81775 30.0569 5.81775H30.1395C30.8934 5.81775 31.5045 5.20663 31.5045 4.45278C31.5045 3.69893 30.8934 3.08781 30.1395 3.08781Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                            <path d="M23.1352 3.08785H23.0526C22.2987 3.08785 21.6876 3.69897 21.6876 4.45282C21.6876 5.20667 22.2987 5.81778 23.0526 5.81778H23.1352C23.8891 5.81778 24.5002 5.20667 24.5002 4.45282C24.5002 3.69897 23.8891 3.08785 23.1352 3.08785Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                            <path d="M28.692 7.16933V7.54775C28.692 9.22355 27.7995 10.2236 26.5825 10.2236C25.2033 10.2236 24.5002 9.00732 24.5002 7.54775V7.16933H21.6876V7.73696C21.6876 11.0345 23.6618 12.8454 26.5825 12.8454C29.7467 12.8454 31.5045 10.8183 31.5045 7.73696V7.16933H28.692Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                            <path d="M7.73891 3.08781L5.69774 8.62161L3.62973 3.08781H0.782837L4.2743 12.5007L2.9583 16H5.83202L10.6127 3.08781H7.73891Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                            <path d="M15.5276 3.08781C12.8122 3.08781 10.6127 5.28612 10.6127 8.00007C10.6127 10.714 12.8122 12.9123 15.5276 12.9123C18.243 12.9123 20.4425 10.714 20.4425 8.00007C20.4425 5.28612 18.243 3.08781 15.5276 3.08781ZM15.5276 10.2255C14.3057 10.2255 13.3281 9.22134 13.3281 8.0272C13.3281 6.83306 14.3328 5.82891 15.5276 5.82891C16.7224 5.82891 17.7271 6.83306 17.7271 8.0272C17.7271 9.22134 16.7495 10.2255 15.5276 10.2255Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                            <path d="M86.3023 3.08781C83.5869 3.08781 81.3874 5.28612 81.3874 8.00007C81.3874 10.714 83.5869 12.9123 86.3023 12.9123C89.0177 12.9123 91.2172 10.714 91.2172 8.00007C91.2172 5.28612 89.0177 3.08781 86.3023 3.08781ZM86.3023 10.2255C85.0803 10.2255 84.1028 9.22134 84.1028 8.0272C84.1028 6.83306 85.1075 5.82891 86.3023 5.82891C87.4971 5.82891 88.5018 6.83306 88.5018 8.0272C88.5018 9.22134 87.5242 10.2255 86.3023 10.2255Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                            <path d="M38.2721 3.06529C37.3752 3.06529 36.5054 3.30943 35.7987 3.74345V0H33.0808V12.9122H35.7987V12.234C36.5326 12.6681 37.3752 12.9122 38.2721 12.9122C40.99 12.9122 43.1915 10.715 43.1915 8.00231C43.1915 5.28966 40.99 3.06529 38.2721 3.06529ZM38.2721 10.1995C37.049 10.1995 36.0705 9.19587 36.0705 8.00231C36.0705 6.80874 37.0762 5.80507 38.2721 5.80507C39.4679 5.80507 40.4736 6.80874 40.4736 8.00231C40.4736 9.19587 39.4951 10.1995 38.2721 10.1995Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                            <path d="M63.5059 5.78076C63.4522 5.51063 63.3717 5.26751 63.2375 5.05141C63.1302 4.83531 62.9692 4.59219 62.7814 4.37609C62.6472 4.187 62.4594 4.05194 62.2715 3.91688C62.0837 3.78181 61.8691 3.67376 61.6544 3.59272C61.4397 3.51168 61.1982 3.45765 60.9836 3.40363C60.7421 3.37661 60.5274 3.3496 60.3127 3.3496C59.8297 3.3496 59.3736 3.43064 58.9443 3.61973C58.5149 3.80882 58.1929 4.10596 57.9783 4.51115L57.9514 4.64622V0H55.2682V12.8582H57.9514V7.75271C57.9514 7.64465 57.9514 7.48259 57.9783 7.2935C58.0051 7.0774 58.0588 6.8883 58.1393 6.69921C58.2198 6.51012 58.3808 6.32102 58.5954 6.18596C58.8101 6.02388 59.1053 5.96986 59.4809 5.96986C59.8298 5.96986 60.1249 6.0509 60.3396 6.21298C60.5542 6.37506 60.6884 6.56414 60.7689 6.78025C60.8494 6.99635 60.9031 7.21246 60.9299 7.42856C60.9567 7.64467 60.9567 7.80674 60.9567 7.91479V12.9122H63.6937V7.77973C63.6937 7.37453 63.6937 6.99635 63.6669 6.69921C63.6132 6.34804 63.5864 6.05089 63.5059 5.78076Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                            <path d="M79.0307 3.98095C78.8953 4.11627 78.7598 4.38692 78.7598 4.38692V3.08781H76.0511V12.9123H78.7598V7.28284C78.8411 6.30852 79.735 5.5507 80.8456 5.5507C81.0352 5.5507 81.2248 5.57776 81.3873 5.60483V3.11487C79.8975 3.11487 79.1662 3.81856 79.0307 3.98095Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                            <path d="M53.7544 8.81877H47.3246C47.5435 9.88308 48.4464 10.4562 49.5408 10.4562C50.4164 10.4562 51.1825 10.0741 51.8391 9.30999L53.4534 11.1111C52.66 12.1209 51.2098 12.9123 49.2398 12.9123C46.4217 12.9123 44.3149 10.9474 44.3149 8.00006C44.3149 5.13458 46.3396 3.08781 49.1304 3.08781C51.9212 3.08781 53.8638 5.1073 53.8638 7.91819C53.8091 8.19109 53.7818 8.62773 53.7544 8.81877ZM47.2972 7.0449L50.8541 7.0176C50.6626 6.08973 50.0333 5.51664 49.1304 5.51664C48.2275 5.51664 47.5161 6.06245 47.2972 7.0449Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                            <path d="M74.5374 8.81877H68.1076C68.3265 9.88308 69.2294 10.4562 70.3238 10.4562C71.1994 10.4562 71.9655 10.0741 72.6221 9.30999L74.2364 11.1111C73.443 12.1209 71.9928 12.9123 70.0228 12.9123C67.2047 12.9123 65.0979 10.9474 65.0979 8.00006C65.0979 5.13458 67.1226 3.08781 69.9134 3.08781C72.7042 3.08781 74.6468 5.1073 74.6468 7.91819C74.6195 8.19109 74.5921 8.62773 74.5374 8.81877ZM68.1076 7.0449L71.6645 7.0176C71.473 6.08973 70.8437 5.51664 69.9408 5.51664C69.0379 5.51664 68.2991 6.06245 68.1076 7.0449Z" fill="'.$text_color.'"/>
                                                                                                                                                                                                                                                                                                                        </svg>
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
                    </center>
                <!--</body>
        </html>-->';
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
        $email_body = $this->youbehero_email_body( $youbehero_data, $selected_cause_info );
//        $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
//        $subject = "YouBeHero Donation from $customer_name";
//        wp_mail( $email_address, $subject, $email_body, $this->headers );
        return $email_body;

    }

}