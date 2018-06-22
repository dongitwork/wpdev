<?php
// [mz_share pid='']
add_shortcode('mz_share', 'mz_share_inc');
function mz_share_inc($atts,$content = '')
{
	extract(shortcode_atts( array(
        'pid' => get_the_ID()
    ), $atts));
    return get_share($pid);
}