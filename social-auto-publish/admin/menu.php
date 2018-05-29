<?php
if( !defined('ABSPATH') ){ exit();}
add_action('admin_menu', 'sap_add_menu');

function sap_add_menu()
{
	add_menu_page(' Auto Publish - Manage settings', 'Twitter Auto Publish', 'manage_options', 'sap-auto-publish-settings', 'sap_dashboard_seting');
}


function sap_dashboard_seting()
{
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);	
	require( dirname( __FILE__ ) . '/settings.php' );
}





