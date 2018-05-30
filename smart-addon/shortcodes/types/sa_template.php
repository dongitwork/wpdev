<?php
/*
* Add new template sa_template
* Read all template on custom for shortcode
* @author: EastVn
* @version: 2.0
* @since 2018
*/

vc_add_shortcode_param('sa_template', 'sa_shortcode_template');
function sa_shortcode_template($settings, $value) {
    $shortcode = $settings['shortcode'];
    $theme_dir = get_template_directory() . '/sa_template';
    $reg = "/^({$shortcode}\.php|{$shortcode}--.*\.php)/";
    $files = SmartAddonFileScanDirectory(USAEV_TEMPLATES, $reg);
    $files = array_merge(SmartAddonFileScanDirectory($theme_dir, $reg), $files);
    $output = "";
    $output .= "<select name=\"" . esc_attr($settings['param_name']) . "\" class=\"wpb_vc_param_value\">";
    foreach ($files as $key => $file) {
        $file_data = get_file_data($file->uri,array('Template Name'=>'Template Name'));
        $tpl_name = $file_data['Template Name'];
        if ($tpl_name != '') {
            if ($key == esc_attr($value)) {
                $output .= "<option value=\"{$key}\" selected>{$tpl_name}</option>";
            } else {
                $output .= "<option value=\"{$key}\">{$tpl_name}</option>";
            }
        }
        
    }
    $output .= "</select>";
    $script = <<<SCRIPT
    <script type="text/javascript">
        jQuery('button.vc_panel-btn-save[data-save=true]').click(function(){
            jQuery('.sa_custom_param.vc_dependent-hidden').remove();
        });
    </script>
SCRIPT;
    return $output.$script;
}