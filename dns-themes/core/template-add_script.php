<?php
function dns_add_header_code(){
  if (get_toption('ctcss') != '') {
    print '<style type="text/css"> '.get_toption('ctcss').'</style>';
  }
   if (get_toption('head_code') != '') {
    print get_toption('head_code');
  }
  
}

function dns_add_footer_code(){
	if (get_toption('footer_code') != '') {
    print get_toption('footer_code');
  }
  if (get_toption('ctjs') != '') {
    print '<script type="text/javascript">'.get_toption('ctjs').'</script>';
  }
}

add_action('wp_head', 'dns_site_add_header');
add_action('wp_footer', 'dns_site_add_footer');
function dns_site_add_header(){
    dns_add_header_code();
}

function dns_site_add_footer(){
    dns_add_footer_code();
}