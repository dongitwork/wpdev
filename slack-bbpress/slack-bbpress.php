<?php
/**
 * Plugin Name: Slack for bbPress
 * Description: This plugin allows you to send notifications to Slack channels whenever someone add new bbPress topic or responds
 * Version: 2.0
 * Author: EastVN 
 * Author URI: eastvn.info 
 */

function wp_slack_for_bbpress( $events ) {
	
	// When add new topic
	$events['bbpress_submit'] = array(
		'action' => 'transition_post_status',
		'description' => __( 'When Add new forum topic or responds', 'slack-bbpress' ),
		// Message to deliver to channel. Returns false will prevent
		// notification delivery.
		'message'     => function( $new_status, $old_status, $post ) {

			$notified_post_types = apply_filters( 'slack_event_transition_post_status_post_types', array(
						'topic',
					) );

			if ( ! in_array( $post->post_type, $notified_post_types ) ) {
				return false;
			}

			if ( 'publish' !== $old_status && 'publish' === $new_status ) {
				$excerpt = has_excerpt( $post->ID ) ?
					apply_filters( 'get_the_excerpt', $post->post_excerpt )
					:
					wp_trim_words( strip_shortcodes( $post->post_content ), 55, '&hellip;' );

				return sprintf(
					/* Translators: 
						1) URL, 
						2) Post title 
						3) Post author. 
					*/
					__( 'New Topic published: *<%1$s|%2$s>* by *%3$s*', 'slack-bbpress' ) . "\n" .
					'> %4$s',
					get_permalink( $post->ID ),
					html_entity_decode( get_the_title( $post->ID ), ENT_QUOTES, get_bloginfo( 'charset' ) ),
					get_the_author_meta( 'display_name', $post->post_author ),
					html_entity_decode( $excerpt, ENT_QUOTES, get_bloginfo( 'charset' ) )
				);
			}
		}, // End function message
	);// All done


	// When there is a new responds Topic
	$events['bbpress_comment'] = array(
		'action' => 'transition_post_status',
		'description' => __( 'When there is a new responds Topic ', 'slack-bbpress' ),
		'default'     => false,
		'priority'    => 9999,

		// Message to deliver to channel. Returns false will prevent
		// notification delivery.
		'message'     => function($new_status, $old_status, $post ) {
			$notified_post_types = apply_filters( 'slack_event_wp_insert_comment_post_types', array(
				'topic',
			) );

			if ( ! in_array( get_post_type( $post_id ), $notified_post_types ) ) {
				return false;
			}

			$post_title     = get_the_title( $post_id );

			// 
			if ( 'reply' != $post->post_type ) {
				return false;
			}

			$excerpt = has_excerpt( $post->ID ) ?
					apply_filters( 'get_the_excerpt', $post->post_excerpt )
					:
					wp_trim_words( strip_shortcodes( $post->post_content ), 55, '&hellip;' );
			// Check trigger		
			if ('publish' !== $old_status && 'publish' === $new_status) {
				return sprintf(
					/* Translators: 
						1) Responds URL, 
						2) Responds author, 
						3) Post URL, 
						4) Post title,  
						5) Responds excerpt. 
					*/
					__( '<%1$s|New responds> by *%2$s* on Topic *<%3$s|%4$s>*', 'slack-bbpress' ) . "\n" .'>%5$s',
					get_permalink( $post_id ).'#post-'.$post->ID,
					get_the_author_meta( 'display_name', $post->post_author ),
					get_permalink( $post_id ),
					html_entity_decode( $post_title, ENT_QUOTES, get_bloginfo( 'charset' ) ),
					preg_replace( "/\n/", "\n>", $excerpt )
				);
			}
		},
	);

	return $events;
}

add_filter( 'slack_get_events', 'wp_slack_for_bbpress' );
