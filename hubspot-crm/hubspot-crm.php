<?php 
/*
Plugin Name: HubSpot CRM API
Description: Send HubSpot CRM API include Ninja Form
Version: 1.0
Plugin URI: https://dongnamsolutions.com/
Author URI: http://eastvn.info
Author: Eastvn
*/

if ( ! defined( 'ABSPATH' ) ) exit;
include 'includes/DNS_User_Tracking.php';

/*
* Add new action to form
*/
add_filter( 'ninja_forms_register_actions', 'register_actions',200,3 );
function register_actions($actions)
{
	
	include 'includes/Actions/SendAPI.php';
    $actions[ 'ninja_api' ] = new NF_Action_NinjaAPI();
    return $actions;
}

add_action( 'init', 'process_plugin' );

function process_plugin() {
    if( isset( $_GET['utm_campaign'] ) ) {
        if(!session_id()) {
	        session_start();
	    }
	    $_SESSION['gmt_data'] = $_GET;
    }
}