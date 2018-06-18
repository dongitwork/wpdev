<?php
/*
 * Class name DNS_Options
 * @author DongNam Solutions
 * @package dns-themes
*/
if ( ! class_exists( 'DNS_Options' ) ) {
    class DNS_Options {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            if ( ! class_exists( 'ReduxFramework' ) ) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            }
        }

        public function initSettings() {

            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();
            // Create the sections and fields
            $this->setSections();
            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }
            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }
        /*
         * All function sections options theme setting
         * @author DongNam Solutions
         * @package dns-themes
        */
        public function setSections() {
            require_once 'function.options.php';
        }

        public function setHelpTabs() {
            $this->args['help_tabs'][] = array(
                'id'      => 'redux-help-tab-1',
                'title'   => __( 'Theme Information 1', 'dns-themes' ),
                'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'dns-themes' )
            );
            $this->args['help_tabs'][] = array(
                'id'      => 'redux-help-tab-2',
                'title'   => __( 'Theme Information 2', 'dns-themes' ),
                'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'dns-themes' )
            );
            $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'dns-themes' );
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args = array(
                'opt_name'           => 'dns_options',
                'display_name'       => '<div style="text-align: left;">
                                            <img src="'.THEME_URL_ASSETS.'/images/logo.png" style="width: 150px;">
                                            <br> DongNam Solutions Themes Setting
                                        </div>',
                'display_version'    => ' Ver:'.$theme->get( 'Version' ),
                'menu_type'          => 'submenu',
                'allow_sub_menu'     => false,
                'menu_title'         => __( 'Themes Settings', 'dns-themes' ),
                'page_title'         => __( 'Themes Settings', 'dns-themes' ),
                'google_api_key'     => '',
                'google_update_weekly' => false,
                'async_typography'   => true,
                'admin_bar'          => true,
                'admin_bar_icon'     => 'dashicons-portfolio',
                'global_variable'    => '',
                'dev_mode'           => false,
                'customizer'         => true,
                'page_priority'      => null,
                'page_parent'        => 'themes.php',
                'page_permissions'   => 'manage_options',
                'menu_icon'          => 'dashicons-portfolio',
                'last_tab'           => '',
                'page_icon'          => 'icon-themes',
                'page_slug'          => 'dns_options',
                'save_defaults'      => true,
                'default_show'       => false,
                'default_mark'       => '',
                'show_import_export' => true,
                'show_options_object'=> false,
                'transient_time'     => 60 * MINUTE_IN_SECONDS,
                'output'             => true,
                'output_tag'         => true,
                'database'           => '',
                'system_info'        => false,

                // HINTS
                'hints'              => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'   => 'light',
                        'shadow'  => true,
                        'rounded' => false,
                        'style'   => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'mouseover',
                        ),
                        'hide' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            // $this->args['share_icons'][] = array(
            //     'url'   => '',
            //     'title' => 'Visit us on GitHub',
            //     'icon'  => 'el el-github'
            //     //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            // );
            $this->args['share_icons'][] = array(
                'url'   => 'https://fb.com/dongnamsolutions',
                'title' => 'Like us on Facebook',
                'icon'  => 'el el-facebook'
            );
            // $this->args['share_icons'][] = array(
            //     'url'   => '',
            //     'title' => 'Follow us on Twitter',
            //     'icon'  => 'el el-twitter'
            // );
            // $this->args['share_icons'][] = array(
            //     'url'   => '',
            //     'title' => 'Find us on LinkedIn',
            //     'icon'  => 'el el-linkedin'
            // );

            // Panel Intro text -> before the form
            if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                if ( ! empty( $this->args['global_variable'] ) ) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace( '-', '_', $this->args['opt_name'] );
                }
                $this->args['intro_text'] = sprintf( __( 'Welcome to our setting panel.','dns-themes' ), $v );
            } else {
                $this->args['intro_text'] = __('', 'dns-themes' );
            }
            // Add content after the form.
            $this->args['footer_text'] = __('Thank you have using we service. All setting in panel develop by <a href="https://dongnamsolutions.com" target="_blank">DongNam Solutions</a>', 'dns-themes' );
        }

    }

    global $reduxConfig;
    $reduxConfig = new DNS_Options();
}
