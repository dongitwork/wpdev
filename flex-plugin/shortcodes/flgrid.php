<?php
// 
vc_map(
	array(
		"name" => __("Flex Post List", 'flex-theme'),
	    "base" => "flgrid",
	    "class" => "vc-fl-grid",
	    "category" => __("Flex Shortcodes", 'flex-theme'),
	    "params" => array(
	    	array(
	            "type" => "loop",
	            "heading" => __("Source",'flex-theme'),
	            "param_name" => "source",
	            'settings' => array(
	                'size' => array('hidden' => false, 'value' => 10),
	                'order_by' => array('value' => 'date')
	            ),
	            "group" => __("Source Settings", 'flex-theme'),
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Columns XS Devices",'flex-theme'),
	            "param_name" => "col_xs",
	            "edit_field_class" => "vc_col-sm-3 vc_column",
	            "value" => array(1,2,3,4,5,6),
	            "std" => 1,
	            "group" => __("Grid Settings", 'flex-theme')
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Columns SM Devices",'flex-theme'),
	            "param_name" => "col_sm",
	            "edit_field_class" => "vc_col-sm-3 vc_column",
	            "value" => array(1,2,3,4,5,6),
	            "std" => 2,
	            "group" => __("Grid Settings", 'flex-theme')
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Columns MD Devices",'flex-theme'),
	            "param_name" => "col_md",
	            "edit_field_class" => "vc_col-sm-3 vc_column",
	            "value" => array(1,2,3,4,5,6),
	            "std" => 3,
	            "group" => __("Grid Settings", 'flex-theme')
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Columns LG Devices",'flex-theme'),
	            "param_name" => "col_lg",
	            "edit_field_class" => "vc_col-sm-3 vc_column",
	            "value" => array(1,2,3,4,5,6),
	            "std" => 4,
	            "group" => __("Grid Settings", 'flex-theme')
	        ),
            array(
	            "type" => "textfield",
	            "heading" => __("Limit Word",'flex-theme'),
	            "param_name" => "numshows",
	            "value" => "15",
	            "description" => __("Limit word in content",'flex-theme'),
	            "group" => __("Template", 'flex-theme')
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Extra Class",'flex-theme'),
	            "param_name" => "class",
	            "value" => "",
	            "description" => __("",'flex-theme'),
	            "group" => __("Template", 'flex-theme')
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Extra Id",'flex-theme'),
	            "param_name" => "html_id",
	            "value" => "",
	            "description" => __("",'flex-theme'),
	            "group" => __("Template", 'flex-theme')
	        ),
	        array(
	            "type" => "fl_template",
	            "param_name" => "fl_template",
	            "shortcode" => "flgrid",
	            "admin_label" => true,
	            "heading" => __("Shortcode Template",'flex-theme'),
	            "group" => __("Template", 'flex-theme'),
	        )
	    )
	)
);
class WPBakeryShortCode_flgrid extends FlShortcode{
	protected function content($atts, $content = null){
		wp_enqueue_script('fl-grid-pagination',FL_JS.'flgrid.pagination.js',array('jquery'),'1.0.0',true);
        $html_id = getHtmlID('flgrid');
        $source = $atts['source'];
        list($args, $wp_query) = vc_build_loop_query($source);
        $paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

	    if($paged > 1){
	    	$args['paged'] = $paged;
	    	$wp_query = new WP_Query($args);
	    }
        $atts['cat'] = isset($args['cat'])?$args['cat']:'';
        /* get posts */
        $atts['posts'] = $wp_query;
        $grid = shortcode_atts(array(
            'col_lg' => 4,
            'col_md' => 3,
            'col_sm' => 2,
            'col_xs' => 1,
	        'fl_template' => 'flgrid.php',
        ), $atts);
        $col_lg = $grid['col_lg'] == 5 ? '' : 12 / $grid['col_lg'];
        $col_md = $grid['col_md'] == 5 ? '' : 12 / $grid['col_md'];
        $col_sm = $grid['col_sm'] == 5 ? '' : 12 / $grid['col_sm'];
        $col_xs = $grid['col_xs'] == 5 ? '' : 12 / $grid['col_xs'];
        $atts['item_class'] = "col-full-xs col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-xs-{$col_xs}";
        $atts['grid_class'] = "fl-grid";
        $class = isset($atts['class'])?$atts['class']:'';
        $class = ($atts['numshows'] != '')?$atts['numshows']:'15';
        $atts['template'] = 'template-'.str_replace('.php','',$atts['fl_template']). ' '. $class;
        $atts['html_id'] = ($atts['html_id'] != '')?$atts['html_id'] : $html_id;
		return parent::content($atts, $content);
	}
}
