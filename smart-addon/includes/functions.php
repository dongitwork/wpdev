<?php

global $sa_html_id;

if (empty($sa_html_id)) {
    $sa_html_id = array();
}

if(!function_exists('sa_parse_multi_attribute')) {
    function sa_parse_multi_attribute( $value, $default = array() ) {
        $result = $default;
        $params_pairs = explode( '|', $value );
        if ( ! empty( $params_pairs ) ) {
            foreach ( $params_pairs as $pair ) {
                $param = preg_split( '/\:/', $pair );
                if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
                    $result[ $param[0] ] = rawurldecode( $param[1] );
                }
            }
        }
        return $result;
    }
}

if(!function_exists('sa_build_link')) {
    function sa_build_link( $value ) {
        return sa_parse_multi_attribute( $value, array( 'url' => '', 'title' => '', 'target' => '' ) );
    }
}

if (!function_exists('ColumnWidthToSpan')) {
    function ColumnWidthToSpan( $screen = 'vc_col-lg-', $width ) {
        preg_match( '/(\d+)\/(\d+)/', $width, $matches );
        if ( ! empty( $matches ) ) {
            $part_x = (int) $matches[1];
            $part_y = (int) $matches[2];
            if ( $part_x > 0 && $part_y > 0 ) {
                $value = ceil( $part_x / $part_y * 12 );
                if ( $value > 0 && $value <= 12 ) {
                    $width = $screen . $value;
                }
            }
        }
        return $width;
    }
}

if (!function_exists('GetCategoriesByPostID')) {
    function GetCategoriesByPostID($post_ID = null,$taxo = 'category'){
        $term_cats = array();
        $categories = get_the_terms($post_ID,$taxo);
        if($categories){
            foreach($categories as $category){
                $term_cats[] = get_term( $category, $taxo );
            }
        }
        return $term_cats;
    }
}

/**
 * Generator unique html id
 * @param type $id : string
 * @return mixed|string|type
 */
if (!function_exists('getHtmlID')) {
    function getHtmlID($id) {
        global $sa_html_id;
        $id = str_replace(array('_'), '-', $id);
        if (isset($sa_html_id[$id])) {
            $count = count($sa_html_id[$id]);
            $sa_html_id[$id][$count] = 1;
            $count++;
            return $id . '-' . $count;
        } else {
            $sa_html_id[$id] = array(1);
            return $id;
        }
    }
}

if (!function_exists('SmartAddonFileScanDirectory')) {
    function SmartAddonFileScanDirectory($dir, $mask, $options = array(), $depth = 0) {
        $options += array(
            'nomask' => '/(\.\.?|CSV)$/',
            'callback' => 0,
            'recurse' => TRUE,
            'key' => 'uri',
            'min_depth' => 0,
        );

        $options['key'] = in_array($options['key'], array('uri', 'filename', 'name')) ? $options['key'] : 'uri';
        $files = array();
        if (is_dir($dir) && $handle = opendir($dir)) {
            while (FALSE !== ($filename = readdir($handle))) {
                if (!preg_match($options['nomask'], $filename) && $filename[0] != '.') {
                    $uri = "$dir/$filename";
                    if (is_dir($uri) && $options['recurse']) {
                        $files = array_merge(SmartAddonFileScanDirectory($uri, $mask, $options, $depth + 1), $files);
                    } elseif ($depth >= $options['min_depth'] && preg_match($mask, $filename)) {
                        $file = new stdClass();
                        $file->uri = $uri;
                        $file->filename = $filename;
                        $file->name = pathinfo($filename, PATHINFO_FILENAME);
                        $files[$filename] = $file;
                    }
                }
            }
            closedir($handle);
        }
        return $files;
    }
}

// $shortcode = 'sagird';
// $theme_dir = get_template_directory() . '/sa_template';
// $reg = "/^({$shortcode}\.php|{$shortcode}--.*\.php)/";
// $files = SmartAddonFileScanDirectory(USAEV_TEMPLATES, $reg);
// $files = array_merge(SmartAddonFileScanDirectory($theme_dir, $reg), $files);
// foreach ($files as $key => $file) {
//    $template_data = get_file_data( $file->uri , array( 'Template Name' => 'Template Name' ) );
// print_r($template_data['Template Name'] );die();
// }
