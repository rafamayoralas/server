<?php
$jw_swf_name = ($jw_license) ? "licensed" : "non-commercial";

$disableurlhashing = kConf::get('disable_url_hashing');
if ( !$allow_reports )
{
  $first_login = true;
}
if ( kConf::get('kmc_display_server_tab') )
{
	$support_url = '#support';
	$_SESSION['api_v3_login'] = true;
}
else
{
	$support_url = '/index.php/kmc/support?type=' . md5($payingPartner) . '&pid=' . $partner_id . '&email=' . $email;
}
?>
<?php
	$defaultUiconfsArray = array();
	foreach($content_uiconfs_previewembed_list as $uiconf)
	{
		$uiconf_array = array();
		$uiconf_array["id"] = $uiconf->getId();
		$uiconf_array["name"] = $uiconf->getName();
		$uiconf_array["width"] = $uiconf->getWidth();
		$uiconf_array["height"] = $uiconf->getHeight();
		$uiconf_array["swf_version"] = "v" . $uiconf->getswfUrlVersion();

		$defaultUiconfsArray[] = $uiconf_array;
	}
	$partnerUiconfsArray = array();
	foreach($content_pne_partners_playlist as $uiconf)
	{
		$uiconf_array = array();
		$uiconf_array["id"] = $uiconf->getId();
		$uiconf_array["name"] = $uiconf->getName();
		$uiconf_array["width"] = $uiconf->getWidth();
		$uiconf_array["height"] = $uiconf->getHeight();
		$uiconf_array["swf_version"] = "v" . $uiconf->getswfUrlVersion();

		$partnerUiconfsArray[] = $uiconf_array;
	}
	$fullPlaylistPreviewEmbedList = array_merge($defaultUiconfsArray, $silverLightPlaylistUiConfs, $partnerUiconfsArray, $jw_uiconf_playlist);
	$ui_confs_playlist = json_encode($fullPlaylistPreviewEmbedList);

	$defaultUiconfsArray = array();
	foreach($content_uiconfs_previewembed as $uiconf)
	{
		$uiconf_array = array();
		$uiconf_array["id"] = $uiconf->getId();
		$uiconf_array["name"] = $uiconf->getName();
		$uiconf_array["width"] = $uiconf->getWidth();
		$uiconf_array["height"] = $uiconf->getHeight();
		$uiconf_array["swf_version"] = "v" . $uiconf->getswfUrlVersion();
	
		$defaultUiconfsArray[] = $uiconf_array;
	}
	$partnerUiconfsArray = array();
	foreach($content_pne_partners_player as $uiconf)
	{
		$uiconf_array = array();
		$uiconf_array["id"] = $uiconf->getId();
		$uiconf_array["name"] = $uiconf->getName();
		$uiconf_array["width"] = $uiconf->getWidth();
		$uiconf_array["height"] = $uiconf->getHeight();
		$uiconf_array["swf_version"] = "v" . $uiconf->getswfUrlVersion();

		$partnerUiconfsArray[] = $uiconf_array;
	}
	if(is_array($kdp508_players) && count($kdp508_players))
	{
		$fullPlayerPreviewEmbedList = array_merge($defaultUiconfsArray, $kdp508_players, $silverLightPlayerUiConfs, $partnerUiconfsArray, $jw_uiconfs_array);
	}
	else
	{
		$fullPlayerPreviewEmbedList = array_merge($defaultUiconfsArray, $silverLightPlayerUiConfs, $partnerUiconfsArray, $jw_uiconfs_array);
	}
	$ui_confs_player = json_encode($fullPlayerPreviewEmbedList);
?>

<script type="text/javascript"> // move to kmc_js.php and include ?
	var kmc = {
		vars : {
		  /* --- new vars KMC4 */
			kmc_version		: "<?php echo $kmc_swf_version; ?>",
			kmc_general_uiconf	: "<?php echo $kmc_general->getId(); ?>", 
			kmc_permissions_uiconf	: "<?php echo $kmc_permissions->getId(); ?>", 
		  /* END new vars KMC4 */
		
			service_url		: "<?php echo $service_url; ?>",
			host			: "<?php echo $host; ?>",
			cdn_host		: "<?php echo $cdn_host; ?>",
			rtmp_host		: "<?php echo $rtmp_host; ?>",
			flash_dir		: "<?php echo $flash_dir ?>",
			createmix_url	: "<?php echo url_for('kmc/createmix'); ?>",
			getuiconfs_url	: "<?php echo url_for('kmc/getuiconfs'); ?>",
			terms_of_use	: "<?php echo kConf::get('terms_of_use_uri'); ?>",
			jw_swf			: "<?php echo $jw_swf_name; ?>.swf",
			ks				: "<?php echo $ks; ?>",
			partner_id		: "<?php echo $partner_id; ?>",
			subp_id			: "<?php echo $subp_id; ?>",
			user_id			: "<?php echo $uid; ?>",
			screen_name		: "<?php echo $screen_name; ?>",
			email			: "<?php echo $email; ?>",
			first_login		: <?php echo ($first_login) ? "true" : "false"; ?>,
			paying_partner	: "<?php echo $payingPartner; ?>",
			whitelabel		: <?php echo $templatePartnerId; ?>,
			show_usage		: <?php echo (kConf::get("kmc_account_show_usage"))? "true" : "false"; ?>,
			kse_uiconf		: "<?php echo $simple_editor->getId(); ?>", // add "id"
			kae_uiconf		: "<?php echo $advanced_editor->getId(); ?>", // add "id"
			kcw_uiconf		: "<?php echo $content_uiconfs_upload->getId(); ?>", // add "id"
			default_kdp		: {
					height		: "<?php echo $content_uiconfs_flavorpreview->getHeight(); ?>",
					width		: "<?php echo $content_uiconfs_flavorpreview->getWidth(); ?>",
					uiconf_id	: "<?php echo $content_uiconfs_flavorpreview->getId(); ?>",
					swf_version	: "<?php echo $content_uiconfs_flavorpreview->getswfUrlVersion(); ?>"
			},
			//appstudio_uiconfid	: "<?php //echo $appstudio_uiconfs_templates->getId(); ?>",
			//reports_drilldown	: "<?php //echo $reports_uiconfs_drilldown->getId(); ?>",
			//enable_live			: "<?php echo $enable_live_streaming; ?>",
			next_state			: { module : "dashboard", subtab : "default" },
			disableurlhashing	: "<?php echo $disableurlhashing; ?>",
			players_list		: <?php echo $ui_confs_player; ?>,
			playlists_list		: <?php echo $ui_confs_playlist; ?>,
			enable_custom_data	: "<?php echo $kmc_enable_custom_data; ?>",
			//metadata_view_uiconf	: "<?php //echo $content_uiconfs_metadataview->getId(); ?>",
			//content_drilldown_uiconf : "<?php //echo $content_uiconfs_drilldown->getId(); ?>",
			//content_moderate_uiconf	 : "<?php //echo $content_uiconfs_moderation->getId(); ?>",
			google_analytics_account : "<?php echo kConf::get("ga_account"); ?>",
			appstudio_templatesXmlUrl: <?php echo ($appstudio_templatesXmlUrl ? '"'.$appstudio_templatesXmlUrl.'"' : "false"); ?>,
			//enableAds		 : <?php echo $enable_vast ?>,
			appStudioExampleEntry : "<?php echo $appStudioExampleEntry ?>", 
			appStudioExamplePlayList0	 : "<?php echo $appStudioExamplePlayList0 ?>",
			appStudioExamplePlayList1	 : "<?php echo $appStudioExamplePlayList1 ?>"
		}
	}
</script>

	<div id="kmcHeader"	<?php if($templatePartnerId) echo 'class="whiteLabel"'; ?>>
	 <div id="logo"></div>
     <ul id="hTabs">
     	<li id="loading"><img src="/lib/images/kmc/loader.gif" alt="Loading" /> Loading...</li>
<?php /* Old HTML Tabs
      <li><a id="dashboard" href="<?php echo $service_url; ?>/index.php/kmc/kmc2#dashboard|''"><span>Dashboard</span></a></li>
      <li><a id="content" href="<?php echo $service_url; ?>/index.php/kmc/kmc2#content|Manage"><span>Content</span></a></li>
     <?php if ( kConf::get ( "kmc_display_customize_tab" ) ) { ?>
	  <li><a id="studio" href="<?php echo $service_url; ?>/index.php/kmc/kmc2#appstudio|''"><span>Studio</span></a></li>
	 <?php } ?>
	 <?php if ( kConf::get ( "kmc_display_account_tab" ) ) { ?>
      <li><a id="account" href="<?php echo $service_url; ?>/index.php/kmc/kmc2#settings|Account Settings"><span>Settings</span></a></li>
	 <?php } ?>
	 <?php if ( kConf::get ( "kmc_display_server_tab" ) ) { ?>
      <li><a id="server" href="<?php echo $service_url; ?>/api_v3/system/batchwatch.php" target="_server"><span>Server</span></a></li>
	 <?php } ?>
	 <?php if ( kConf::get ( "kmc_display_developer_tab" ) ) { ?>
      <li><a id="developer" href="<?php echo $service_url; ?>/api_v3/testme/index.php"><span>Developer</span></a></li>
	 <?php } ?>
	 <?php if ($allow_reports) { ?>
	 <li><a id="analytics" href="<?php echo $service_url; ?>/index.php/kmc/kmc2#reports|Bandwidth Usage Reports"><span>Analytics</span></a></li>
	 <li><a id="admin" href="http://kaldev.kaltura.com/index.php/kmc/kmc2#admin|usersTab"><span>Administration</span></a></li>
	 <?php } ?>
<!--	 <li><a id="Advertising" href="#"><span>Advertising</span></a></li>-->
*/ ?>
	 </ul>
<?php //echo '<pre>'; print_r($allowedPartners); exit(); ?>
     <div id="user_links">
      <span>Hi <?php echo $screen_name ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="Logout" href="#logout">Logout</a></span><br />
	      <?php if (!$templatePartnerId) { ?>
	      <?php if(count($allowedPartners) > 0) { ?>
			<select id="change_partners" style="margin: -8px 10px 0 0; background: #000; color: #fff;">
			<?php foreach($allowedPartners as $p){ ?>
	      		<option value="<?php echo $p['id']?>"<?php if($p['id'] == $partner_id) { 
	      			echo ' selected="selected"'; } ?>><?php echo $p['name']; ?></option>
	      	<?php } ?>
	      	</select>
	      <?php /*
	      <span id="change_partner"><?php echo $screen_name ?> V      
	      <div id="partners_list">
	      	<ul>
	      		<?php foreach($allowedPartners as $p){ ?>
	      		<li<?php if($p['id'] == $partner_id) { echo ' style="font-weight: bold"'; } ?>>
	      		<a href="/index.php/kmc/extloginbyks/ks/<?php echo $ks; ?>/partner_id/<?php echo $partner_id; ?>"><?php echo $p['name']; ?></a></li>
	      		<?php } ?>
	      	</ul>
	      </div>
	      </span> &nbsp;&nbsp;|&nbsp;&nbsp;
	      */ ?> 	      	               
	      <?php  } ?>   
      <a id="Quickstart Guide" href="<?php echo $service_url ?>/content/docs/pdf/KMC3_Quick_Start_Guide.pdf" target="_blank">Quickstart Guide</a> &nbsp; | &nbsp;
	  <a id="Support" href="<?php echo $support_url; ?>" target="_blank">Support</a> <!-- @todo: !!! -->
      <?php } ?>
	 </div>
	</div><!-- kmcHeader -->

	<div id="main">
		<div id="flash_wrap" class="flash_wrap">
			<div id="kcms"></div>
		</div><!-- flash_wrap -->
        <div id="server_wrap">
         <iframe frameborder="0" id="server_frame" height="100%" width="100%"></iframe>
        </div> <!-- server_wrap -->
	</div><!-- main -->
<script type="text/javascript" src="/lib/js/kmc4.js"></script>
