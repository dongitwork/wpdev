<?php
/*
 * Var Options array
 * @author DongNam Solutions
 * @package dns-themes
*/
$argsp = array('post_type' => 'page',
    'post_status' => 'publish',
    'posts_per_page'=>-1);
$pl_query = new WP_Query( $argsp );
$options_pages = array('' => 'Chọn page');
if ( $pl_query->have_posts() ){
    while ( $pl_query->have_posts() ){
        $pl_query->the_post();
        $options_pages[get_the_ID()] = get_the_title();
    }
    wp_reset_postdata();                        
}

/* General Settings */
$this->sections[] = array(
    'title'  => esc_html__( 'General Settings', 'dns-themes' ),
    'id'     => 'general-settings',
    'desc'   => esc_html__( 'All info on site', 'dns-themes' ),
    'icon'   => 'el el-cogs',
    'fields' => array(
        array(
            'id'       => 'site_title',
            'type'     => 'text',
            'title'    => esc_html( 'Site title', 'dns-themes' ),
            'desc'     => esc_html( '', 'dns-themes' ),
        ),
        array(
            'id'       => 'site_phone',
            'type'     => 'text',
            'title'    => esc_html( 'Phone', 'dns-themes' ),
            'desc'     => esc_html( '', 'dns-themes' ),
        ),
        array(
            'id'       => 'site_email',
            'type'     => 'text',
            'title'    => esc_html( 'Email Address', 'dns-themes' ),
            'desc'     => esc_html( '', 'dns-themes' ),
        ),
        array(
            'id'       => 'site_address',
            'type'     => 'ace_editor',
            'mode'     => 'html',
            'theme'    => 'chrome',
            'title'    => esc_html( 'Address', 'dns-themes' ),
            'desc'     => esc_html( '', 'dns-themes' ),
        ),
        array(
            'id'       => 'frm_tuvan',
            'type'     => 'text',
            'title'    => esc_html( 'Form Tư vấn', 'dns-themes' ),
            'desc'     => esc_html( '', 'dns-themes' ),
        ),
        array(
            'id'       => 'frm_dathang',
            'type'     => 'text',
            'title'    => esc_html( 'From Đặt hàng', 'dns-themes' ),
            'desc'     => esc_html( '', 'dns-themes' ),
        ),
        array(
            'id'       => 'back_to_top',
            'type'     => 'switch',
            'title'    => esc_html__( 'Back To Top', 'dns-themes' ),
            'subtitle' => esc_html__( 'Control button back to top.', 'dns-themes' ),
            'default'  => false,
        ),
        array(
            'id'       => 'page_doitra',
            'type'     => 'select',
            'title'    => esc_html__( 'Page đổi trả', 'dns-themes' ),
            'subtitle' => esc_html__( 'Chọn page đổi trả', 'dns-themes' ),
            'options'  => $options_pages,
            'default'  => '',
        ),
        array(
            'id'       => 'page_help',
            'type'     => 'text',
            'title'    => esc_html__( 'Link Hướng dẫn', 'dns-themes' ),
            'subtitle' => esc_html__( 'Nhập id bài viết hướng dẫ mua hàng', 'dns-themes' ),
            'default'  => '1394',
        ),
        // array(
        //     'id'       => 'site_loading',
        //     'type'     => 'switch',
        //     'title'    => esc_html__( 'Site Loading', 'dns-themes' ),
        //     'subtitle' => esc_html__( 'Control animation before site load complete.', 'dns-themes' ),
        //     'default'  => false,
        // ),

    )
);

/* All Typography */
// $this->sections[] = array(
//     'title'            => esc_html__( 'Typography', 'dns-themes' ),
//     'id'               => 'typography',
//     'icon'             => 'el el-fontsize',
//     'fields'           => array(
//         array(
//             'id'       => 'body_font',
//             'type'     => 'typography',
//             'title'    => esc_html__( 'Body Font', 'dns-themes' ),
//             'subtitle' => esc_html__( 'These settings control the typography body.', 'dns-themes' ),
//             'subsets'   => false,
//             'letter-spacing'   => true,
//             'text-align'   => false,
//             'default'  => array(
//                 'color'       => '#686876',
//                 'font-size'   => '16px',
//                 'font-family' => 'Lato',
//                 'font-weight' => '400',
//                 'line-height' => '24px',
//                 'letter-spacing' => '0'
//             ),
//             'output'    => array('body')
//         ),
//         // array(
//         //     'id'       => 'h1_font',
//         //     'type'     => 'typography',
//         //     'title'    => esc_html__( 'H1 Typography', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'These settings control the typography H1.', 'dns-themes' ),
//         //     'subsets'   => false,
//         //     'letter-spacing'   => true,
//         //     'text-align'   => false,
//         //     'default'  => array(
//         //         'color'       => '#171721',
//         //         'font-size'   => '36px',
//         //         'font-family' => 'Lato',
//         //         'font-weight' => '700',
//         //         'line-height' => '42px',
//         //         'letter-spacing' => '0'
//         //     ),
//         //     'output'    => array('h1, .h1')
//         // ),
//         // array(
//         //     'id'       => 'h1_space',
//         //     'type'     => 'spacing',
//         //     'units'    => array( 'em', 'px', '%' ),
//         //     'mode'     => 'margin',
//         //     'right'    => false,
//         //     'left'     => false,
//         //     'title'    => esc_html__( 'H1 Space', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'Control the top/bottom margin the H1.', 'dns-themes' ),
//         //     'default'  => array(
//         //         'margin-top'    => '0',
//         //         'margin-bottom' => '15px'
//         //     ),
//         //     'output'    => array('h1')
//         // ),
//         // array(
//         //     'id'       => 'h2_font',
//         //     'type'     => 'typography',
//         //     'title'    => esc_html__( 'H2 Typography', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'These settings control the typography H2.', 'dns-themes' ),
//         //     'subsets'   => false,
//         //     'letter-spacing'   => true,
//         //     'text-align'   => false,
//         //     'default'  => array(
//         //         'color'       => '#171721',
//         //         'font-size'   => '30px',
//         //         'font-family' => 'Lato',
//         //         'font-weight' => '700',
//         //         'line-height' => '36px',
//         //         'letter-spacing' => '0'
//         //     ),
//         //     'output'    => array('h2, .h2')
//         // ),
//         // array(
//         //     'id'       => 'h2_space',
//         //     'type'     => 'spacing',
//         //     'units'    => array( 'em', 'px', '%' ),
//         //     'mode'     => 'margin',
//         //     'right'    => false,
//         //     'left'     => false,
//         //     'title'    => esc_html__( 'H2 Space', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'Control the top/bottom margin the H2.', 'dns-themes' ),
//         //     'default'  => array(
//         //         'margin-top'    => '0',
//         //         'margin-bottom' => '15px'
//         //     ),
//         //     'output'    => array('h2')
//         // ),
//         // array(
//         //     'id'       => 'h3_font',
//         //     'type'     => 'typography',
//         //     'title'    => esc_html__( 'H3 Typography', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'These settings control the typography H3.', 'dns-themes' ),
//         //     'subsets'   => false,
//         //     'letter-spacing'   => true,
//         //     'text-align'   => false,
//         //     'default'  => array(
//         //         'color'       => '#171721',
//         //         'font-size'   => '24px',
//         //         'font-family' => 'Lato',
//         //         'font-weight' => '700',
//         //         'line-height' => '30px',
//         //         'letter-spacing' => '0'
//         //     ),
//         //     'output'    => array('h3, .h3')
//         // ),
//         // array(
//         //     'id'       => 'h3_space',
//         //     'type'     => 'spacing',
//         //     'units'    => array( 'em', 'px', '%' ),
//         //     'mode'     => 'margin',
//         //     'right'    => false,
//         //     'left'     => false,
//         //     'title'    => esc_html__( 'H3 Space', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'Control the top/bottom margin the H3.', 'dns-themes' ),
//         //     'default'  => array(
//         //         'margin-top'    => '0',
//         //         'margin-bottom' => '15px'
//         //     ),
//         //     'output'    => array('h3')
//         // ),
//         // array(
//         //     'id'       => 'h4_font',
//         //     'type'     => 'typography',
//         //     'title'    => esc_html__( 'H4 Typography', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'These settings control the typography H4.', 'dns-themes' ),
//         //     'subsets'   => false,
//         //     'letter-spacing'   => true,
//         //     'text-align'   => false,
//         //     'default'  => array(
//         //         'color'       => '#171721',
//         //         'font-size'   => '18px',
//         //         'font-family' => 'Lato',
//         //         'font-weight' => '700',
//         //         'line-height' => '24px',
//         //         'letter-spacing' => '0'
//         //     ),
//         //     'output'    => array('h4, .h4')
//         // ),
//         // array(
//         //     'id'       => 'h4_space',
//         //     'type'     => 'spacing',
//         //     'units'    => array( 'em', 'px', '%' ),
//         //     'mode'     => 'margin',
//         //     'right'    => false,
//         //     'left'     => false,
//         //     'title'    => esc_html__( 'H4 Space', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'Control the top/bottom margin the H4.', 'dns-themes' ),
//         //     'default'  => array(
//         //         'margin-top'    => '0',
//         //         'margin-bottom' => '15px'
//         //     ),
//         //     'output'    => array('h4')
//         // ),
//         // array(
//         //     'id'       => 'h5_font',
//         //     'type'     => 'typography',
//         //     'title'    => esc_html__( 'H5 Typography', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'These settings control the typography H5.', 'dns-themes' ),
//         //     'subsets'   => false,
//         //     'letter-spacing'   => true,
//         //     'text-align'   => false,
//         //     'default'  => array(
//         //         'color'       => '#171721',
//         //         'font-size'   => '14px',
//         //         'font-family' => 'Lato',
//         //         'font-weight' => '700',
//         //         'line-height' => '16px',
//         //         'letter-spacing' => '0'
//         //     ),
//         //     'output'    => array('h5, .h5')
//         // ),
//         // array(
//         //     'id'       => 'h5_space',
//         //     'type'     => 'spacing',
//         //     'units'    => array( 'em', 'px', '%' ),
//         //     'mode'     => 'margin',
//         //     'right'    => false,
//         //     'left'     => false,
//         //     'title'    => esc_html__( 'H5 Space', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'Control the top/bottom margin the H5.', 'dns-themes' ),
//         //     'default'  => array(
//         //         'margin-top'    => '0',
//         //         'margin-bottom' => '15px'
//         //     ),
//         //     'output'    => array('h5')
//         // ),
//         // array(
//         //     'id'       => 'h6_font',
//         //     'type'     => 'typography',
//         //     'title'    => esc_html__( 'H6 Typography', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'These settings control the typography H6.', 'dns-themes' ),
//         //     'subsets'   => false,
//         //     'letter-spacing'   => true,
//         //     'text-align'   => false,
//         //     'default'  => array(
//         //         'color'       => '#171721',
//         //         'font-size'   => '12px',
//         //         'font-family' => 'Lato',
//         //         'font-weight' => '700',
//         //         'line-height' => '14px',
//         //         'letter-spacing' => '0'
//         //     ),
//         //     'output'    => array('h6, .h6')
//         // ),
//         // array(
//         //     'id'       => 'h6_space',
//         //     'type'     => 'spacing',
//         //     'units'    => array( 'em', 'px', '%' ),
//         //     'mode'     => 'margin',
//         //     'right'    => false,
//         //     'left'     => false,
//         //     'title'    => esc_html__( 'H6 Space', 'dns-themes' ),
//         //     'subtitle' => esc_html__( 'Control the top/bottom margin the H1.', 'dns-themes' ),
//         //     'default'  => array(
//         //         'margin-top'    => '0',
//         //         'margin-bottom' => '15px'
//         //     ),
//         //     'output'    => array('h6')
//         // ),
        
//     )
// ) ;

/*Font Icons*/
// $this->sections[] = array(
//     'title'            => esc_html__( 'Font Icons', 'dns-themes' ),
//     'id'               => 'fonticons',
//     'icon'             => 'el el-info-circle',
//     'subsection'       => true,
//     'fields'           => array(
//         array(
//             'id'       => 'font_awesome',
//             'type'     => 'switch',
//             'title'    => esc_html__( 'Font Awesome', 'dns-themes' ),
//             'subtitle' => esc_html__( 'Use font awesome.', 'dns-themes' ),
//             'default'  => true,
//         ),
//         array(
//             'id'       => 'font_pe_icon_7_stroke',
//             'type'     => 'switch',
//             'title'    => esc_html__( 'Font Pe Icon 7 Stroke', 'dns-themes' ),
//             'subtitle' => esc_html__( 'Use font pe icon 7 stroke.', 'dns-themes' ),
//             'default'  => false,
//         ),
//         array(
//             'id'       => 'flaticon',
//             'type'     => 'switch',
//             'title'    => esc_html__( 'Font Flaticon', 'dns-themes' ),
//             'subtitle' => esc_html__( 'Use font flaticon.', 'dns-themes' ),
//             'default'  => false,
//         ),
//     )
// );

/* Header */
$this->sections[] = array(
    'title'  => __( 'Header', 'dns-themes' ),
    'desc'   => __( 'All setings for header on this theme.', 'dns-themes' ),
    'icon'   => 'el el-hand-right',
    'fields' => array(
        array(
            'id'       => 'logo-on',
            'type'     => 'switch',
            'title'    => __( 'Enable Image Logo', 'dns-themes' ),
            'compiler' => 'bool',
            'desc'     => __( 'Do you want to enable image logo?', 'dns-themes' ),
            'on'       => __('Enabled', 'dns-themes'),
            'off'      => __('Disabled', 'dns-themes'),
            'default'  => true,
        ),
        array(
            'id'    => 'logo-image',
            'type'  => 'media',
            'required' => array( 'logo-on', '=', true ),
            'title' => __('Logo Image', 'dns-themes'),
            'desc'  => __('Image that you want to use as logo.', 'dns-themes'),
            'default'  => array('url' => THEME_URL_ASSETS.'/images/logo.png')
        ),
        array(
            'id'       => 'favicon',
            'type'     => 'media',
            'url'      => false,
            'title'    => esc_html( 'Favicon', 'dns-themes' ),
            'compiler' => 'true',
            'default'  => array('url' => THEME_URL_ASSETS.'/images/favicon.png')
        ),
        array(
            'id'       => 'header_top',
            'type'     => 'switch',
            'title'    => __( 'Show Header Top', 'dns-themes' ),
            'compiler' => 'bool',
            'desc'     => __( 'Do you want to show header top?', 'dns-themes' ),
            'on'       => __('Show', 'dns-themes'),
            'off'      => __('Hidden', 'dns-themes'),
            'default'  => 0,
        ),
        
        // TOP BAR COLORS
        array(
            'id'        => 'topbar_colors_start',
            'type'      => 'section',
            'required' => array( 'header_top', '=', '1' ),
            'title'     => esc_html__('Top Bar Setting', 'dns-themes'),
            'indent'    => true,
        ),
            array(
                'id'       => 'header_top_content',
                'type' => 'ace_editor',
                'required' => array( 'header_top', '=', '1' ),
                'title' => __('Header Top Content', 'dns-themes'),
                'subtitle'     => __( 'Paste your content here.', 'dns-themes' ),
                'mode'     => 'html',
                'theme'    => 'chrome',
            ),
            array(
                'id'        => 'topbar_bg_color',
                'type'      => 'color',
                'required' => array( 'header_top', '=', '1' ),
                'title'     => esc_html__('Top Bar Background Color', 'dns-themes'),
                'subtitle'  => esc_html__('Will replace top bar background color', 'dns-themes'),
                'default'   => '#c4c4c4',
                'output'    => array( 
                    'background-color' => '.pl_header_top', 
                ),
            ),
            array(
                'id'        => 'topbar_txt_color',
                'type'      => 'color',
                'required' => array( 'header_top', '=', '1' ),
                'title'     => esc_html__('Header Top Text Color', 'dns-themes'),
                'subtitle'  => esc_html__('Will replace top bar text color', 'dns-themes'),
                'default'   => '#fff',
                'output'    => array( 
                    'color' => '.pl_header_top, .pl_header_top p, .pl_header_top a, .pl_header_top p i', 
                    
                ),
            ),
            array(
                'id'             => 'topbar_spacing',
                'type'           => 'spacing', 
                'mode'           => 'padding',  
                'all'            => false,
                'required' => array( 'header_top', '=', '1' ),
                'units'          => array('px','em', '%'),
                'units_extended' => 'true',  
                'output'         => array('padding' => '.pl_header_top'),
                'title'          => esc_html__( 'Header Top Padding', 'dns-themes' ),
                'subtitle'       => esc_html__( 'Allow youto choose the spacing.', 'dns-themes' ),
                'desc'           => esc_html__( 'You can enable or disable any piece. Top, Right, Bottom, Left', 'dns-themes' ),
                'default'            => array(
                    'margin-top'     => '15', 
                    'margin-right'   => '0', 
                    'margin-bottom'  => '15', 
                    'margin-left'    => '0',
                    'units'          => 'px', 
                )
            ),
        array(
            'id'        => 'topbar_colors_end',
            'type'      => 'section',
            'indent'    => false,
        ), 
    )
);

/* Content */
$this->sections[] = array(
    'title'  => esc_html__( 'Content', 'dns-themes' ),
    'id'     => 'conten-settings',
    'desc'   => esc_html__( 'Club Hours, Error, No Post ', 'dns-themes' ),
    'icon'   => 'el el-cogs',
    'fields' => array(
        array(
            'id'       => '404_content',
            'type'     => 'ace_editor',
            'title'    => __('Error 404', 'dns-themes'),
            'subtitle' => __( 'Paste your content here.', 'dns-themes' ),
            'mode'     => 'html',
            'theme'    => 'chrome',
            'default'  => 'Error 404 <br> Page not found!',
        ),
        array(
            'id'       => 'no_content',
            'type'     => 'ace_editor',
            'title'    => __('Content None', 'dns-themes'),
            'subtitle' => __( 'Paste your content here.', 'dns-themes' ),
            'mode'     => 'html',
            'theme'    => 'chrome',
            'default'  => 'No post shows!',
        ),
        array(
            'id'       => 'after_pcat',
            'type'     => 'ace_editor',
            'title'    => __('Content After Product Cat', 'dns-themes'),
            'subtitle' => __( 'Paste your content here.', 'dns-themes' ),
            'mode'     => 'html',
            'theme'    => 'chrome',
            'default'  => '',
        ),
        array(
            'id'       => 'after_ncat',
            'type'     => 'ace_editor',
            'title'    => __('Content After News Cat', 'dns-themes'),
            'subtitle' => __( 'Paste your content here.', 'dns-themes' ),
            'mode'     => 'html',
            'theme'    => 'chrome',
            'default'  => '',
        ),
    )
);

/* Footer */
$this->sections[] = array(
    'title'  => __( 'Footer', 'dns-themes' ),
    'desc'   => __( 'All setings for footer on this theme.', 'dns-themes' ),
    'icon'   => 'el el-hand-right',
    'fields' => array(
        array(
            'id'       => 'wg-col',
            'type'     => 'select',
            'title'    => __('Widgets columns', ''), 
            'desc'     => __('The number of columns displayed in footer.', ''),
            'options'  => array(
                '1' => '1 Column',
                '2' => '2 Columns',
                '3' => '3 Columns',
                '4' => '4 Columns'
            ),
            'default'  => '4',
        ),
        array(
            'id'       => 'logo_footer_on',
            'type'     => 'switch',
            'title'    => __( 'Enable Logo Footer', 'dns-themes' ),
            'compiler' => 'bool',
            'desc'     => __( 'Do you want to enable image logo?', 'dns-themes' ),
            'on'       => __('Enabled', 'dns-themes'),
            'off'      => __('Disabled', 'dns-themes'),
            'default'  => false,
        ),
            array(
                'id'    => 'logo_footer',
                'type'  => 'media',
                'required' => array( 'logo_footer_on', '=', true ),
                'title' => __('Logo Footer', 'dns-themes'),
                'desc'  => __('Image that you want to use as logo.', 'dns-themes'),
                'default'  => array('url' => THEME_URL_ASSETS.'/images/logo.png')
            ),  
        array(
            'id'       => 'shows_fbottom',
            'type'     => 'switch',
            'title'    => __( 'Show Footer Bottom', 'dns-themes' ),
            'default'  => 1,
            'on'       => 'Show',
            'off'      => 'Hide',
        ),
            array(
                    'id'       => 'fbottom_content',
                    'type' => 'ace_editor',
                    'required' => array( 'shows_fbottom', '=', '1' ),
                    'title' => __('Footer Bottom Content', 'dns-themes'),
                    'subtitle'     => __( 'Paste your content here.', 'dns-themes' ),
                    'mode'     => 'html',
                    'theme'    => 'chrome',
                ),
            array(
                    'id'        => 'fbottom_bg_color',
                    'type'      => 'color',
                    'required' => array( 'shows_fbottom', '=', '1' ),
                    'title'     => esc_html__('Footer Bottom Background Color', 'dns-themes'),
                    'subtitle'  => esc_html__('Will replace footer bottom background color', 'dns-themes'),
                    'default'   => '#333333',
                    'output'    => array( 
                        'background-color' => '#footer-bottom', 
                    ),
                ),
            array(
                'id'        => 'fbottom_txt_color',
                'type'      => 'color',
                'required' => array( 'shows_fbottom', '=', '1' ),
                'title'     => esc_html__('Footer Bottom Text Color', 'dns-themes'),
                'subtitle'  => esc_html__('Will replace Footer Bottom text color', 'dns-themes'),
                'default'   => '#fff',
                'output'    => array( 
                    'color' => '#footer-bottom,#footer-bottom p,#footer-bottom a', 
                ),
            ),
        array(
            'id'       => 'show_copyright',
            'type'     => 'switch',
            'title'    => esc_html( 'Show Copyright', 'dns-themes' ),
            'subtitle' => esc_html( 'Show / Hide Copyright bar', 'dns-themes' ),
            'default'  => 1,
            'on'       => 'Show',
            'off'      => 'Hide',
        ),
        // Copyright
            array(
                'id'       => 'copyright_text',
                'type'     => 'ace_editor',
                'mode'     => 'html',
                'theme'    => 'chrome',
                'required' => array( 'show_copyright', '=', '1' ),
                'title'    => esc_html( 'Copyright Text', 'dns-themes' ),
                'default'     => esc_html( '&copy; '.date("Y").' Copyright '.get_bloginfo('name').'. All rights reserved.', 'dns-themes' ),
            ),
            array(
                    'id'             => 'copyright_spacing',
                    'type'           => 'spacing', 
                    'mode'           => 'padding', 
                    'all'            => false,
                    'units'          => array('px','%','em'),
                    'units_extended' => 'true',     
                    'display_units'=> 'true',   
                    'required' => array( 'show_copyright', '=', '1' ),
                    'output'    => array('padding' => '#copyright'),
                    'title'          => esc_html__( 'Copyright Padding', 'dns-themes' ),
                    'subtitle'       => esc_html__( 'Allow youto choose the spacing.', 'dns-themes' ),
                    'desc'           => esc_html__( 'You can enable or disable any piece. Top, Right, Bottom, Left', 'dns-themes' ),
                    'default'            => array(
                        'margin-top'     => '15', 
                        'margin-right'   => '0', 
                        'margin-bottom'  => '15', 
                        'margin-left'    => '0',
                        'units'          => 'px', 
                    )
            ),
            array(
                'id'        => 'copyright_bg_color',
                'type'      => 'color',
                'required' => array( 'show_copyright', '=', '1' ),
                'title'     => esc_html__('Copyright Background Color', 'dns-themes'),
                'subtitle'  => esc_html__('Will replace copyright background color', 'dns-themes'),
                'default'   => '#333333',
                'output'    => array( 
                    'background-color' => '#copyright', 
                ),
            ),
            array(
                'id'        => 'copyright_txt_color',
                'type'      => 'color',
                'required' => array( 'show_copyright', '=', '1' ),
                'title'     => esc_html__('Copyright Text Color', 'dns-themes'),
                'subtitle'  => esc_html__('Will replace copyright text color', 'dns-themes'),
                'default'   => '#fff',
                'output'    => array( 
                    'color' => '#copyright,#copyright p,#copyright a', 
                ),
            ),
    )
);

/* Social Media */
$this->sections[] = array(
    'title'  => __( 'Social Media', 'dns-themes' ),
    'desc'   => __( 'All setings for Social Link.', 'dns-themes' ),
    'icon'   => 'el el-podcast',
    'fields' => array(
        array(
            'id'       => 'ss_face',
            'type'     => 'text',
            'title'    => esc_html( 'Facebook', 'dns-themes' ),
            'desc'     => esc_html( 'Enter facebook profile link', 'dns-themes' ),
        ),
        array(
            'id'       => 'ss_twitter',
            'type'     => 'text',
            'title'    => esc_html( 'Twitter', 'dns-themes' ),
            'desc'     => esc_html( 'Enter twitter profile link', 'dns-themes' ),
        ),
        array(
            'id'       => 'ss_ldin',
            'type'     => 'text',
            'title'    => esc_html( 'Linkedin', 'dns-themes' ),
            'desc'     => esc_html( 'Enter linkedin profile link', 'dns-themes' ),
        ),
        array(
            'id'       => 'ss_gplus',
            'type'     => 'text',
            'title'    => esc_html( 'Google Plus', 'dns-themes' ),
            'desc'     => esc_html( 'Enter google plus profile link', 'dns-themes' ),
        ),
        array(
            'id'       => 'ss_ytube',
            'type'     => 'text',
            'title'    => esc_html( 'Youtube', 'dns-themes' ),
            'desc'     => esc_html( 'Enter Youtube profile link', 'dns-themes' ),
        ),
        array(
            'id'       => 'ss_ingram',
            'type'     => 'text',
            'title'    => esc_html( 'Instagram', 'dns-themes' ),
            'desc'     => esc_html( 'Enter instagram profile link', 'dns-themes' ),
        )
    )
);

/* Custom Code */
$this->sections[] = array(
    'title'  => __( 'Custom Code', 'dns-themes' ),
    'desc'   => __( 'All custom head, Footer, css & js on this theme.','dns-themes' ),
    'icon'   => 'el el-cogs',
    'fields' => array(
        array(
            'id'=>'ctcss',
            'type' => 'ace_editor',
            'title' => __('CSS Code', 'dns-themes'),
            'subtitle'     => __( 'Paste your CSS code here.', 'dns-themes' ),
            'mode'     => 'css',
            'theme'    => 'chrome',
        ),
        array(
            'id'=>'ctjs',
            'type' => 'ace_editor',
            'title' => __('JS Code', 'dns-themes'),
            'subtitle'     => __( 'Paste your JS code here.', 'dns-themes' ),
            'mode'     => 'js',
            'theme'    => 'chrome',
        ),
        array(
            'id'       => 'head_code',
            'title' => __('Header Code', 'dns-themes'),
            'subtitle'     => __( 'Paste your header content here.', 'dns-themes' ),
            'type' => 'ace_editor',
            'mode'     => 'html',
            'theme'    => 'chrome',
        ),
        array(
            'id'       => 'footer_code',
            'type' => 'ace_editor',
            'title' => __('Footer Code', 'dns-themes'),
            'subtitle'     => __( 'Paste your footer content here.', 'dns-themes' ),
            'mode'     => 'html',
            'theme'    => 'chrome',
        ),
        array(
            'id'       => 'face_fx_id',
            'type'     => 'text',
            'title'    => esc_html( 'Facebook pixel ID', 'dns-themes' ),
            'desc'     => esc_html( ' ', 'dns-themes' ),
        ),
    )
);

