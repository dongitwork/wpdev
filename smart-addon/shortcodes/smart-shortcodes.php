<?php

/**
 * Base shortcode for all Shortcodes
 */
class Smart_Addon_Shortcode extends WPBakeryShortCode {
    protected function loadTemplate($atts, $content = null) {
        $output = '';
        $sa_template = isset($atts['sa_template']) ? $atts['sa_template'] : $this->shortcode.'.php';
        $files = $this->findShortcodeTemplates();

        if ($sa_template && isset($files[$sa_template])) {
            $this->setTemplate($files[$sa_template]->uri);
        } else {
            $this->findShortcodeTemplate();
        }

        if (!is_null($content))
            $content = apply_filters('vc_shortcode_content_filter', $content, $this->shortcode);
        if ($this->html_template) {
            ob_start();
            include( $this->html_template );
            $output = ob_get_contents();
            ob_end_clean();
        } else {
            trigger_error(sprintf(__('Template file is missing for `%s` shortcode. Make sure you have `%s` file in your theme folder.', 'smart-addon'), $this->shortcode, 'wp-content/themes/your_theme/sa_template/' . $this->shortcode . '.php'));
        }
        return apply_filters('vc_shortcode_content_filter_after', $output, $this->shortcode);
    }

    /**
     * 
     * @return Array(): array of all avaiable templates
     */
    protected function findShortcodeTemplates() {
        $theme_dir = get_template_directory() . '/sa_template';
        $reg = "/^({$this->shortcode}\.php|{$this->shortcode}--.*\.php)/";
        $files = SmartAddonFileScanDirectory(USAEV_TEMPLATES, $reg);
        $files = array_merge(SmartAddonFileScanDirectory($theme_dir, $reg), $files);
        return $files;
    }
}

/* Create new types for WPBakery  */
require_once USAEV_SHORTCODES . 'types/sa_template_img.php';
require_once USAEV_SHORTCODES . 'types/sa_template.php';

/* Create new Smart Add-On */
require_once USAEV_SHORTCODES . '/core/sa_vc_gird.php';
require_once USAEV_SHORTCODES . '/core/sa_vc_carousel.php';


