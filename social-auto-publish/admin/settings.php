<?php
if( !defined('ABSPATH') ){ exit();}
global $current_user;
$auth_varble=0;
wp_get_current_user();
$imgpath= plugins_url()."/twitter-auto-publish/admin/images/";
$heimg=$imgpath."support.png";


if(isset($_GET['twap_notice']) && $_GET['twap_notice'] == 'hide')
{
	update_option('xyz_twap_dnt_shw_notice', "hide");
	?>
<style type='text/css'>
#tw_notice_td
{
display:none;
}
</style>
<div class="system_notice_area_style1" id="system_notice_area">
Thanks again for using the plugin. We will never show the message again.
 &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>

<?php
}



$tms1="";
$tms2="";
$tms3="";
$tms4="";
$tms5="";
$tms6="";

$terf=0;
if(isset($_POST['twit']))
{
	if (! isset( $_REQUEST['_wpnonce'] )|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'aps_tw_settings_form_nonce' ))
	{
		wp_nonce_ays( 'aps_tw_settings_form_nonce' );
		exit();
	}

	$tappid=sanitize_text_field($_POST['aps_twconsumer_id']);
	$tappsecret=sanitize_text_field($_POST['aps_twconsumer_secret']);
	$twid=sanitize_text_field($_POST['aps_tw_id']);
	$taccess_token=sanitize_text_field($_POST['aps_tw_current_twappln_token']);
	$taccess_token_secret=sanitize_text_field($_POST['aps_twaccestok_secret']);
	$tposting_permission=intval($_POST['aps_twpost_permission']);
	$post_types=$_POST['post_types'];


	$aps_tw_char_limit=$_POST['aps_tw_char_limit'];
	$aps_tw_char_limit=intval($aps_tw_char_limit);
	if ($aps_tw_char_limit<140)
		$aps_tw_char_limit=140;
	if($tappid=="" && $tposting_permission==1)
	{
		$terf=1;
		$tms1="Please fill api key.";

	}
	elseif($tappsecret=="" && $tposting_permission==1)
	{
		$tms2="Please fill api secret.";
		$terf=1;
	}
	elseif($twid=="" && $tposting_permission==1)
	{
		$tms3="Please fill twitter username.";
		$terf=1;
	}
	elseif($taccess_token=="" && $tposting_permission==1)
	{
		$tms4="Please fill twitter access token.";
		$terf=1;
	}
	elseif($taccess_token_secret=="" && $tposting_permission==1)
	{
		$tms5="Please fill twitter access token secret.";
		$terf=1;
	}
	else
	{
		$terf=0;
		update_option('aps_twconsumer_id',$tappid);
		update_option('aps_twconsumer_secret',$tappsecret);
		update_option('aps_tw_id',$twid);
		update_option('aps_tw_current_twappln_token',$taccess_token);
		update_option('aps_twaccestok_secret',$taccess_token_secret);
		update_option('aps_twpost_permission',$tposting_permission);
		update_option('aps_twpost_image_permission',$tposting_image_permission);
		update_option('aps_tw_char_limit', $aps_tw_char_limit);
		update_option('aps_tw_include_types',implode(',', $post_types));
	}
}

?>

<div style="width: 100%">
	<h2><img src="<?php echo SAP_URL; ?>/assets/images/twitter-logo.png" height="16px"> Twitter Settings
	</h2>
	<?php if ($terf == 0): ?>
		<div class="is-dismissible notice notice-success is-dismissible">
			<p>Update Done!</p>
		</div>
	<?php else: ?>
		<div class="notice notice-error below-h2 is-dismissible">
			<p>
				<?php 
					if ($tms1 !='') {
						print $tms1.'<br>';
					}
					if ($tms2 !='') {
						print $tms2.'<br>';
					}
					if ($tms3 !='') {
						print $tms3.'<br>';
					}
					if ($tms4 !='') {
						print $tms4.'<br>';
					}
					if ($tms5 !='') {
						print $tms5.'<br>';
					}
				?>
			</p>
		</div>
	<?php endif; ?>
<form method="post">
	<?php wp_nonce_field( 'aps_tw_settings_form_nonce' );?>
	<input type="hidden" value="config">
		<div style="font-weight: bold;padding: 3px;">All fields given below are mandatory</div> 
		<table class="widefat xyz_twap_widefat_table" style="width: 99%">
			<tr valign="top">
				<td width="50%">API key
				</td>
				<td><input id="aps_twconsumer_id"
					name="aps_twconsumer_id" type="text"
					value="<?php if($tms1=="") {echo esc_html(get_option('aps_twconsumer_id'));}?>" />
					<a href="http://help.xyzscripts.com/docs/social-media-auto-publish/faq/how-can-i-create-twitter-application/" target="_blank">How can I create a Twitter Application?</a>
				</td>
			</tr>

			<tr valign="top">
				<td>API secret
				</td>
				<td><input id="aps_twconsumer_secret"
					name="aps_twconsumer_secret" type="text"
					value="<?php if($tms2=="") { echo esc_html(get_option('aps_twconsumer_secret')); }?>" />
				</td>
			</tr>
			<tr valign="top">
				<td>Twitter username
				</td>
				<td><input id="aps_tw_id" class="al2tw_text"
					name="aps_tw_id" type="text"
					value="<?php if($tms3=="") {echo esc_html(get_option('aps_tw_id'));}?>" />
				</td>
			</tr>
			<tr valign="top">
				<td>Access token
				</td>
				<td><input id="aps_tw_current_twappln_token" class="al2tw_text"
					name="aps_tw_current_twappln_token" type="text"
					value="<?php if($tms4=="") {echo esc_html(get_option('aps_tw_current_twappln_token'));}?>" />
				</td>
			</tr>
			<tr valign="top">
				<td>Access	token secret
				</td>
				<td><input id="aps_twaccestok_secret" class="al2tw_text"
					name="aps_twaccestok_secret" type="text"
					value="<?php if($tms5=="") {echo esc_html(get_option('aps_twaccestok_secret'));}?>" />
				</td>
			</tr>

			
			<tr valign="top">
				<td>Twitter character limit</td>
			<td>
				<input id="aps_tw_char_limit"  name="aps_tw_char_limit" type="text" value="<?php echo esc_html(get_option('aps_tw_char_limit'));?>" style="width: 200px">
			</td></tr>
			
			<tr valign="top">
				<td>Enable auto publish	posts to my twitter account
				</td>
				<td><select id="aps_twpost_permission"
					name="aps_twpost_permission">
						<option value="0"
						<?php  if(get_option('aps_twpost_permission')==0) echo 'selected';?>>
							No</option>
						<option value="1"
						<?php  if(get_option('aps_twpost_permission')==1) echo 'selected';?>>Yes</option>
				</select>
				</td>
			</tr>

			
			<tr valign="top">

				<td  colspan="1">Select wordpress custom post types for auto publish</td>
				<td><?php 
				$aps_tw_include_types = get_option('aps_tw_include_types');
				$args=array(
						'public'   => true,
						'_builtin' => false
				);
				$output = 'names'; 
				$operator = 'and'; 
				$post_types=get_post_types($args,$output,$operator);
				$post_types['post'] = 'post';
				$post_types['page'] = 'page';
				$ar1=explode(",",$aps_tw_include_types);
				$cnt=count($post_types);
				foreach ($post_types  as $post_type ) {
					echo '<input type="checkbox" name="post_types[]" value="'.$post_type.'" ';
					if(in_array($post_type, $ar1))
					{
						echo 'checked="checked"/>';
					}
					else
						echo '/>';

					echo $post_type.'<br/>';
				}
				if($cnt==0)
					echo 'NA';
				?>
				</td>
			</tr>

			<tr>
				<td ></td>
				<td >
					<input type="submit" class="button button-primary button-large"
							name="twit" value="Save" />
				</td>
			</tr>
		</table>

</form>

</div>
