<?php


add_shortcode('sa_subscribe', 'sa_subscribe' );
function sa_subscribe($atts)
{
	global $wp;
    $url =  home_url();
	return '<div class="sa-subscribe">
				<div class="sa-sbc-inner">
					<div class="row_fl">
						<div class="col-xs-12 col-md-6">
							<div class="sas-subtitle">Subscribe to Our</div>
							<h2 class="sas-title">Newsletter</h2>
						</div>
						<div class="col-xs-12 col-md-6">
							<form class="form_subscribe es_widget_form" data-es_form_id="es_widget_form">
								<input type="email" id="es_txt_email" class="es_textbox_class" name="es_txt_email" placeholder="Your Email..." onkeypress="if(event.keyCode==13) es_submit_page(event,\''.$url.'\')">
								<input name="es_txt_button" id="es_txt_button" class="es_textbox_button es_submit_button" type="button" value="Subscribe" onclick="return es_submit_page(event,\''.$url.'\')">

								<div class="es_msg" id="es_widget_msg">
								<span id="es_msg"></span>
								</div>
								<input id="es_txt_name" name="es_txt_name" value="" type="hidden">
								<input id="es_txt_group" name="es_txt_group" value="Public" type="hidden">
							</form>
						</div>
					</div>
				</div>
			</div>';
}