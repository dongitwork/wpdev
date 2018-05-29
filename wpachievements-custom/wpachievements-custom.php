<?php
/**
 * Plugin Name: WPAchievements Custom
 * Description: Achievements Custom Plugin for WordPress
 * Version: 2.0
 * Author: EastVN 
 * Author URI: eastvn.info 
 */

add_filter( 'heartbeat_received','wpac_respond_to_browser',10, 3 );
function wpac_respond_to_browser( $response, $data, $screen_id ) {
	
	if ( isset( $data['wpachievements-check'] ) ) {
		$uid = $data['wpachievements-check'];
    	$cumeta = get_user_meta( $uid,'wpachievements_got_new_ach', true );
    	if ( is_array( $cumeta) && ! empty( $cumeta ) ){
    		$ach_gained = get_user_meta( $uid,'achievements_gained',true);
			update_user_meta( $uid, 'ach_show_badge', $ach_gained);
    	}
    }

   	if (is_user_logged_in()) {
		$uid =  get_current_user_id();
		$ach_gained = get_user_meta( $uid,'achievements_gained',true);
		$ach_show_badge = get_user_meta( $uid,'ach_show_badge',true);
		update_user_meta( $uid, 'ach_show_badge', $ach_gained);

		if ( is_array($ach_show_badge) && ! empty( $ach_show_badge ) ){
			
			$ach_pids = array_diff($ach_gained, $ach_show_badge);

			if (!empty($ach_pids)) {
				$args = array('post_type' => 'wpachievements',
			               'post_status' => 'publish',
			               'post__in' => $ach_pids,
			            );

				$ach_query = new WP_Query( $args );
				
				if ($ach_query->have_posts()) {

					$ach_meta = get_user_meta($uid,'wpachievements_got_new_ach',true);
					
					while ($ach_query->have_posts()) {
						$ach_query->the_post();
						$ach_img = get_post_meta( get_the_ID(), '_achievement_image', true );
						if ( is_array($ach_meta) && !empty( $ach_meta ) ){
							foreach ($ach_meta as  $val) {
								if ($val['title'] != get_the_title() 
									&& $val['image'] != $ach_im) {
									$ach_meta[] = array( 
										'title' => get_the_title(), 
										'text'  => get_the_content(), 
										'image' =>$ach_img
									);
								}
							}
						}else{
							$ach_meta[] = array( 
									'title' => get_the_title(), 
									'text'  => get_the_content(), 
									'image' =>$ach_img
								);
						}
						
						array_unique($ach_meta);
						update_user_meta( $uid, 'wpachievements_got_new_ach', $ach_meta );
					}
					wp_reset_postdata();
				}
			}
		}
	}
}