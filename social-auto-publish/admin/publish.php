<?php 
if( !defined('ABSPATH') ){ exit();}

add_action('transition_post_status','aps_auto_publish', 10, 3 );
function aps_auto_publish($new_status, $old_status, $post)
{
	$postid =$post->ID;
	$aps_post = get_post_meta($postid,"aps_post",true);
	
	$aps_twpermission = get_option('aps_twpost_permission');

	if($aps_twpermission == 1 && $aps_post != 1)
	{
		if(($new_status != $old_status) && $new_status=='publish')
		{
			aps_auto_publish_process($postid);
		}
	}

}


function aps_auto_publish_process($postid)
{
	/******** Twitter *******/
	$tappid=get_option('aps_twconsumer_id');
	$tappsecret=get_option('aps_twconsumer_secret');
	$twid=get_option('aps_tw_id');
	$taccess_token=get_option('aps_tw_current_twappln_token');
	$taccess_token_secret=get_option('aps_twaccestok_secret');
	/******** END Twitter *******/

	$char_limit = get_option('aps_tw_char_limit');
	$post_types = get_option('aps_tw_include_types');

	$postpp = get_post($postid);
	$posttype = $postpp->post_type;
	global $wpdb;
	$carr=explode(',', $post_types);
	if(!in_array($posttype, $carr)){
		return;
	}
	$substring = get_the_title($postid);
	//$substring .= ' - '.get_the_excerpt($postid);
	$substring .= ' - '.get_the_permalink($postid);

	$twobj = new APSTwitterOAuth(array( 'consumer_key' => $tappid, 'consumer_secret' => $tappsecret, 'user_token' => $taccess_token, 'user_secret' => $taccess_token_secret,'curl_ssl_verifypeer'   => false));

	$tw_publish_status = '';

	if(has_post_thumbnail( $post_ID )){
		$url = 'https://upload.twitter.com/1.1/media/upload.json';
		$params=array('media_data' =>base64_encode(file_get_contents(get_the_post_thumbnail_url($post_ID, 'full' ))));
		$code = $twobj->request('POST', $url, $params, true,true);
		if ($code == 200)
		{
			$response = json_decode($twobj->response['response']);
			 $media_ids_str = $response->media_id_string;
			$resultfrtw = $twobj->request('POST', $twobj->url('1.1/statuses/update'), array( 'media_ids' => $media_ids_str, 'status' => $substring));			
		}
	}
	else{
		$resultfrtw = $twobj->request('POST', $twobj->url('1.1/statuses/update'), array('status' =>$substring));
	}

	if($resultfrtw == 200){
		update_post_meta( $postid, 'aps_post', 1 );
	}
}