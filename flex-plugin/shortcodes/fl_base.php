<?php

/**
 * Base shortcode for all Shortcodes
 */

class FlShortcode extends WPBakeryShortCode {

    protected function loadTemplate($atts, $content = null) {
        $output = '';
        $fl_template = isset($atts['fl_template']) ? $atts['fl_template'] : $this->shortcode.'.php';
        $files = $this->findShortcodeTemplates();
        if ($fl_template && isset($files[$fl_template])) {
            $this->setTemplate($files[$fl_template]->uri);
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
            trigger_error(sprintf(__('Template file is missing for `%s` shortcode. Make sure you have `%s` file in your theme folder.', 'js_composer'), $this->shortcode, 'wp-content/themes/your_theme/vc_templates/' . $this->shortcode . '.php'));
        }
        return apply_filters('vc_shortcode_content_filter_after', $output, $this->shortcode);
    }

    /**
     * 
     * @return Array(): array of all avaiable templates
     */
    protected function findShortcodeTemplates() {
        $theme_dir = get_template_directory() . '/vc_templates';
        $reg = "/^({$this->shortcode}\.php|{$this->shortcode}--.*\.php)/";
        $files = flFileScanDirectory($theme_dir, $reg);
        $files = array_merge(flFileScanDirectory(FL_TEMPLATES, $reg), $files);
        return $files;
    }

}