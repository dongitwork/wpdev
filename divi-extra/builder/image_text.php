<?php
class EVR_Builder_Module_Image_Text extends ET_Builder_Module {
		function init() {
	        $this->name = 'Image Text';
	        $this->slug = 'et_pb_image_text';
	        $this->fb_support      = true;
	        $this->whitelisted_fields = array(
				'img_title',
				'img_upload',
				'module_id',
				'module_class' );
	        $this->custom_css_options = array( );
	    }

	    function get_fields() {
	        $fields = array( 
	        	'img_title' => array(
	                'label'       => 'Title image',
	                'type'        => 'text',
	                'description' => '',
	            ),
		        'img_upload' => array(
	                'label'       => 'Image',
	                'type'        => 'upload',
	                'description' => '',
	            ),
	            'admin_label' => array(
	                'label'       => __( 'Admin Label', 'et_builder' ),
	                'type'        => 'text',
	                'description' => __( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
	            ),
	            'module_id' => array(
	                'label'           => __( 'CSS ID', 'et_builder' ),
	                'type'            => 'text',
	                'option_category' => 'configuration',
	                'description'     => __( 'Enter an optional CSS ID to be used for this module. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'et_builder' ),
	            ),
	            'module_class' => array(
	                'label'           => __( 'CSS Class', 'et_builder' ),
	                'type'            => 'text',
	                'option_category' => 'configuration',
	                'description'     => __( 'Enter optional CSS classes to be used for this module. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'et_builder' ),
	            ),
            );
	        return $fields;
	    }

	    function shortcode_callback($atts, $content = null, $function_name ) {
	    	$module_id         = $this->shortcode_atts['module_id'];
			$module_class      = $this->shortcode_atts['module_class'];
			$img_title         = $this->shortcode_atts['img_title'];
			$img_upload        = $this->shortcode_atts['img_upload'];

	        $module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

	        if ($img_upload !='') {
	        	$img_upload = '<img src="'.$img_upload.'" class="img-respnsive">';
	        }
	        $output = sprintf('<div id="'.$module_id.'" class="'.$module_class.'">
	        	'.$img_upload.'
	        	<h3>'.$img_title.'</h3>
	        </div>');

	        return $output;
	    }
	}
	new EVR_Builder_Module_Image_Text;