<?php
vc_add_shortcode_param('fl_template', 'fl_shortcode_template');

function fl_shortcode_template($settings, $value) {
    $shortcode = $settings['shortcode'];
    $theme_dir = get_template_directory() . '/vc_templates';
    $reg = "/^({$shortcode}\.php|{$shortcode}--.*\.php)/";
    $files = flFileScanDirectory($theme_dir, $reg);
    $files = array_merge(flFileScanDirectory(FL_TEMPLATES, $reg), $files);
    $output = "";
    $output .= "<select name=\"" . esc_attr($settings['param_name']) . "\" class=\"wpb_vc_param_value\">";
    foreach ($files as $key => $file) {
        if ($key == esc_attr($value)) {
            $output .= "<option value=\"{$key}\" selected>{$key}</option>";
        } else {
            $output .= "<option value=\"{$key}\">{$key}</option>";
        }
    }
    $output .= "</select>";
    $script = <<<SCRIPT
    <script type="text/javascript">
        jQuery('button.vc_panel-btn-save[data-save=true]').click(function(){
            jQuery('.fl_custom_param.vc_dependent-hidden').remove();
        });
    </script>
SCRIPT;
    return $output.$script;
}