<?php
/*
* Add new template sa_template_img
* Read all template on custom for shortcode
* @author: EastVn
* @version: 2.0
* @since 2018
*/
vc_add_shortcode_param('sa_template_img', 'sa_shortcode_template_img');

function sa_shortcode_template_img($settings, $value) {
    $shortcode = $settings['shortcode'];
    $theme_dir = get_template_directory() . '/sa_templates';
    $reg = "/^({$shortcode}\.php|{$shortcode}--.*\.php)/";
    $files = SmartAddonFileScanDirectory($theme_dir, $reg);
    $files = array_merge(SmartAddonFileScanDirectory(USAEV_TEMPLATES, $reg), $files);
    $output = "";
    $output .= "<select style=\"display:none;\" id=\"".$shortcode."-select-param\" name=\"" . esc_attr($settings['param_name']) . "\" class=\"wpb_vc_param_value\">";
    foreach ($files as $key => $file) {
        if ($key == esc_attr($value)) {
            $output .= "<option value=\"{$key}\" selected>{$key}</option>";
        } else {
            $output .= "<option value=\"{$key}\">{$key}</option>";
        }
    }
    $output .= "</select>";
    $output .= "<div id=\"".$shortcode."-sa-img-select\">";
    foreach ($files as $key => $file) {
        $img = get_template_directory_uri().'/vc_params/'.$shortcode.'/'.basename($key,'.php').'.jpg';
        if ($key == esc_attr($value)) {
            $output .= "<img src=\"".$img."\" data-value=\"".$key."\" class=\"sa-img-select selected\" />";
        } else {
            $output .= "<img src=\"".$img."\" data-value=\"".$key."\" class=\"sa-img-select\" />";
        }
    }
    $output .= "</div>";
    $script = '
    <script type="text/javascript">
        jQuery(\'button.vc_panel-btn-save[data-save=true]\').click(function(){
            jQuery(\'.sa_custom_param.vc_dependent-hidden\').remove();
        });
        jQuery(document).ready(function($){
            $("#'.$shortcode.'-sa-img-select").find("img.sa-img-select").click(function(){
                var $this = $(this);
                $("#'.$shortcode.'-sa-img-select").find("img.sa-img-select").removeClass("selected");
                $this.addClass("selected");console.log($(":hidden#'.$shortcode.'-select-param"));
                $(":hidden#'.$shortcode.'-select-param").val($this.data("value")).change();
            });
        });
    </script>';
    return $output.$script;
}