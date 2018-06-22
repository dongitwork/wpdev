<?php

// What's News
function whatnew_function( $atts ) {
	$args = array( 'post_type' => 'post','posts_per_page' => 10 ,'post_status' => 'publish');
	$query_post = new WP_Query( $args );
	$output = '';
	if ($query_post->have_posts()) {
		$output .= '<div class="what_new_wp">
						<div class="what_new_carouasel">';
		while ($query_post->have_posts()) {
			$query_post->the_post();
			$cats = get_the_category(get_the_ID());
			if (isset($cats[0]->cat_name) && $cats[0]->cat_name == 'Event') {
				$output .= '<div class="whatnew_iterm event_iterm">
							<div class="event_bg" style="background-image: url(\''.get_the_post_thumbnail_url( get_the_ID(), 'full' ).'\')">
								<div class="wn_cat">
									'.$cats[0]->cat_name.'
								</div>
							</div>
							<div class="wn_title_wp">
								<h3 class="wn_title">'.get_the_title().'</h3>
								<div class="location">'.get_field('location').'</div>
							</div>
							<div class="wn_except">
								'.wp_trim_words( get_the_content(), 12, '.' ).'
							</div>
							<div class="wn_more_wp"><a href="'.get_the_permalink().'" class="wn_more">Read more</a></div>
							<div class="wn_meta">
								<span class="wn_author">By '.get_the_author().'</span>
								<span class="wn_date">'.get_the_date('m.d.Y',get_the_ID()).'</span>
							</div>
						</div>';
			}else{
				$output .= '<div class="whatnew_iterm">
							<div class="wn_title_wp">
								<h3 class="wn_title">'.get_the_title().'</h3>
								<div class="wn_cat">
									'.$cats[0]->cat_name.'
								</div>
							</div>
							<div class="wn_except">
								'.wp_trim_words( get_the_content(), 35, '.' ).'
							</div>
							<div class="wn_more_wp"><a href="'.get_the_permalink().'" class="wn_more">Read more</a></div>
							<div class="wn_meta">
								<span class="wn_author">By '.get_the_author().'</span>
								<span class="wn_date">'.get_the_date('m.d.Y',get_the_ID()).'</span>
							</div>
						</div>';	
			}
			
		}
		$output .= '</div></div>';
		wp_reset_query();
	}
	return $output;
}
add_shortcode( 'whatnew', 'whatnew_function' );

// Our Team [team tid=""]
function our_team_function( $atts ) {
	$output = '';
	$array =  shortcode_atts( array(
        'tid' => '',
    ), $atts );

    if (is_numeric($array['tid']) && get_post_type($array['tid']) == 'team_member') {
    	$team = get_post($array['tid']);
    	$image = (has_post_thumbnail($team->ID))?'<div class="rkt_team_image">
						            <div class="rkt_team_image_inner">
						                '.get_the_post_thumbnail($team->ID, 'full', array('class'=>'center-block') ).'
						            </div>
						        </div>':'';

		$terms = get_the_terms( $team->ID, 'team_cat' );   
		$skill_links = array();                   
		if ( $terms && ! is_wp_error( $terms ) ){
		    foreach ( $terms as $term ) {
		        $skill_links[] = '<li>'.$term->name.'</li>';
		    }
		}
		if (!empty($skill_links)) {
			$skill = sprintf('<div class="rkt_team_skill"><ul>%s</ul></div>',implode('', $skill_links));
		}
    	$output = sprintf('<div class="rkt_team">
						    <div class="rkt_team_inner text-center">
						       	%s
						        <div class="rkt_team_name">%s</div>
						        <div class="rkt_team_jobs">%s</div>
						        <div class="rkt_team_address"><span class="fa fa-map-marker"></span> %s</div>
						        %s
						        <div class="rkt_team_content">%s</div>
						        <div class="rkt_team_social">
						            <ul class="team_social">
						                <li>
						                    <a href="%s"><span class="fa fa-facebook"></span></a>
						                </li>
						                <li>
						                    <a href="%s"><span class="fa fa-linkedin"></span></a>
						                </li>
						                <li>
						                    <a href="%s"><span class="fa fa-twitter"></span></a>
						                </li>
						            </ul>
						        </div>
						        <div class="rkt_team_btn">
						            <a href="%s" class="rkt-btn btn-color">Contact</a>
						            <a href="" class="rkt-btn btn-border">Share</a>
						        </div>
						    </div>
						</div>',
						$image,
						$team->post_title,
						get_field('jobs',$team->ID),
						get_field('address',$team->ID),
						$skill,
						$team->post_content,
						get_field('facebook_url',$team->ID),
						get_field('linkedin_profile_url',$team->ID),
						get_field('twitter_url',$team->ID),
						get_field('contact',$team->ID)
					);
    }

	return $output;
}
add_shortcode( 'team', 'our_team_function' );

// Icon Class [icon_text icon="" text=""]
function icon_text_function( $atts ) {
	$output = '';
	$array =  shortcode_atts( array(
        'icon' => '',
        'text' => '',
    ), $atts );
	return sprintf('<span class="rkt_icon_text">
					  <i class="%s"> </i> %s
					</span>',$array['icon'],$array['text']);
}
add_shortcode( 'icon_text', 'icon_text_function' );