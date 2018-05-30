<?php
// 
vc_map(
	array(
		"name"  => __("Smart Posts Grid", 'smart-addon'),
	    "base"  => "sa_vc_gird",
	    "class" => "sa-vc-grid",
	    "icon"  => "vc_icon-vc-masonry-media-grid",
	    "category" => __("Smart AddOn", 'smart-addon'),
	    "params" => array(
	    	array(
	            "type" => "loop",
	            "heading" => __("Source",'smart-addon'),
	            "param_name" => "source",
	            'settings' => array(
	                'size' => array('hidden' => false, 'value' => 10),
	                'order_by' => array('value' => 'date')
	            ),
	            "group" => __("Source Settings", 'smart-addon'),
	        ),

	        array(
	            "type" => "textfield",
	            "heading" => __("Limit Word",'smart-addon'),
	            "param_name" => "limitword",
	            "value" => "15",
	            "description" => __("Limit word in content",'smart-addon'),
	            "group" => __("Source Settings", 'smart-addon')
	        ),

	        array(
	            "type" => "dropdown",
	            "heading" => __("Columns XS Devices",'smart-addon'),
	            "param_name" => "col_xs",
	            "edit_field_class" => "vc_col-sm-3 vc_column",
	            "value" => array(1,2,3,4,5,6),
	            "std" => 1,
	            "group" => __("Grid Settings", 'smart-addon')
	        ),

	        array(
	            "type" => "dropdown",
	            "heading" => __("Columns SM Devices",'smart-addon'),
	            "param_name" => "col_sm",
	            "edit_field_class" => "vc_col-sm-3 vc_column",
	            "value" => array(1,2,3,4,5,6),
	            "std" => 2,
	            "group" => __("Grid Settings", 'smart-addon')
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Columns MD Devices",'smart-addon'),
	            "param_name" => "col_md",
	            "edit_field_class" => "vc_col-sm-3 vc_column",
	            "value" => array(1,2,3,4,5,6),
	            "std" => 3,
	            "group" => __("Grid Settings", 'smart-addon')
	        ),
	        array(
	            "type" => "dropdown",
	            "heading" => __("Columns LG Devices",'smart-addon'),
	            "param_name" => "col_lg",
	            "edit_field_class" => "vc_col-sm-3 vc_column",
	            "value" => array(1,2,3,4,5,6),
	            "std" => 4,
	            "group" => __("Grid Settings", 'smart-addon')
	        ),
            
	        array(
	            "type" => "textfield",
	            "heading" => __("Extra Class",'smart-addon'),
	            "param_name" => "class",
	            "value" => "",
	            "description" => __("",'smart-addon'),
	            "group" => __("Template", 'smart-addon')
	        ),
	        array(
	            "type" => "textfield",
	            "heading" => __("Extra Id",'smart-addon'),
	            "param_name" => "html_id",
	            "value" => "",
	            "description" => __("",'smart-addon'),
	            "group" => __("Template", 'smart-addon')
	        ),
	        array(
	            "type" => "sa_template",
	            "param_name" => "sa_template",
	            "shortcode" => "sa_vc_gird",
	            "heading" => __("Shortcode Template",'smart-addon'),
	            "group" => __("Template", 'smart-addon'),
	        )
	    )
	)
);
class WPBakeryShortCode_sa_vc_gird extends Smart_Addon_Shortcode{
	protected function content($atts, $content = null){
        $html_id = getHtmlID('sa_vc_gird');
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
	        'sa_template' => 'sa_vc_gird.php',
        ), $atts);
        $col_lg = $grid['col_lg'] == 5 ? '' : 12 / $grid['col_lg'];
        $col_md = $grid['col_md'] == 5 ? '' : 12 / $grid['col_md'];
        $col_sm = $grid['col_sm'] == 5 ? '' : 12 / $grid['col_sm'];
        $col_xs = $grid['col_xs'] == 5 ? '' : 12 / $grid['col_xs'];
        $atts['item_class'] = "col-full-xs col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-xs-{$col_xs}";
        $atts['grid_class'] = "sa_vc_gird";
        $class = isset($atts['class'])?$atts['class']:'';
        $atts['limitword'] = ($atts['limitword'] != '')?$atts['limitword']:'15';
        $atts['class'] = 'template-'.str_replace('.php','',$atts['sa_template']). ' '. $class;
        $atts['html_id'] = ($atts['html_id'] != '')?$atts['html_id'] : $html_id;
		return parent::content($atts, $content);
	}
}
