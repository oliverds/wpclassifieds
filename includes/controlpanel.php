<?php
/*Start of wpClassifieds Options*/
 
$themename = "wpClassifieds";
$shortname = "wpClassifieds";
$options = array (
 
array( "name" => "Custom Pages Details",
	"type" => "title"),
 
array( "type" => "open"),

array( "name" => "Page Publish",
	"desc" => "First you must create a new page in Wordpress, you can name it what you wish, but before publish it, assign it the template 'Page Publish' under Attributes options then select here the page recently created.",
	"id" => $shortname."_publish_page_id",
	"type" => "page_select",
	"std" => ""),
 
array( "name" => "Page Edit/Eliminate",
	"desc" => "First you must create a new page in Wordpress, you can name it what you wish, but before publish it, assign it the template 'Page Edit/Eliminate' under Attributes options then select here the page recently created.",
	"id" => $shortname."_edit_page_id",
	"type" => "page_select",
	"std" => ""),

array( "name" => "Page Contact",
	"desc" => "First you must create a new page in Wordpress, you can name it what you wish, but before publish it, assign it the template 'Page Contact' under Attributes options then select here the page recently created.",
	"id" => $shortname."_contact_page_id",
	"type" => "page_select",
	"std" => ""),

array( "type" => "close"),

array( "name" => "General Configuration",
	"type" => "title"),
 
array( "type" => "open"),

array( "name" => "Exclude Pages from Top Navigation",
	"desc" => "Comma separated list of page ID's that will be excluded from the top navigation (e.g 3,4,11).",
	"id" => $shortname."_exlude_pages",
	"type" => "text",
	"std" => ""),

array( "name" => "Custom CSS File",
	"desc" => "Put a custom CSS file name in here (e.g. my_theme.css) relative to wpclassified theme directory.",
	"id" => $shortname."_custom_css",
	"type" => "text",
	"std" => ""),

array( "name" => "Currency",
	"desc" => "Currency character used.",
	"id" => $shortname."_currency",
	"type" => "text",
	"std" => "$"),
 
array( "name" => "Region base",
	"desc" => "The Region base is the prefix used in permalinks URLs for regions.",
	"id" => $shortname."_base_region",
	"type" => "text",
	"std" => "region"),

array( "name" => "Regions",
	"desc" => "List of accepted regions separated by <strong>;</strong> e.g. <strong>Arizona;California;Colorado;Florida;Georgia</strong> . Leave empty to disable this feature.",
	"id" => $shortname."_regions",
	"type" => "text",
	"std" => ""),

array( "name" => "Purge Ads",
	"desc" => "Number of days until ads are purged and eliminated from the site. Leave empty to disable this feature.",
	"id" => $shortname."_purge_ads",
	"type" => "text",
	"std" => ""),

array( "name" => "Blog Category",
	"desc" => "Select which category you want displayed in your blog page. If you're not using a blog page select 'None'.",
	"id" => $shortname."_blog_cat",
	"type" => "select_category",
	"std" => ""),

array( "name" => "Post an Ad Message",
	"desc" => "This message will appear in the form page.",
	"id" => $shortname."_post_message",
	"type" => "textarea",
	"std" => ""),

array( "name" => "Adsense Code",
	"desc" => "Paste in your Google AdSense (or other) code in here. This will show up at the top of each classified ad.",
	"id" => $shortname."_ad_code",
	"type" => "textarea",
	"std" => ""),

array( "name" => "Tracking Code",
	"desc" => "Paste your Google Analytics (or other) tracking code in here.",
	"id" => $shortname."_track_code",
	"type" => "textarea",
	"std" => ""),

array( "type" => "close"),

array( "name" => "Images Configuration",
	"type" => "title"),
 
array( "type" => "open"),

array( "name" => "Images Upload Directory",
	"desc" => "Directory were will be stored the images.",
	"id" => $shortname."_img_upload_dir",
	"type" => "text",
	"std" => "wpclassifieds"),
 
array( "name" => "Max. Images",
	"desc" => "Number of images can be uploaded per ad.",
	"id" => $shortname."_max_img_num",
	"type" => "text",
	"std" => "4"),

array( "name" => "Images Types",
	"desc" => "Types of images that we allow to upload.",
	"id" => $shortname."_img_types",
	"type" => "text",
	"std" => "gif,jpeg,png"),

array( "name" => "Max Image Size",
	"desc" => "Size of images that we allow to upload on bytes. Default approx. 1 Mb.",
	"id" => $shortname."_max_img_size",
	"type" => "text",
	"std" => "1000000"),

array( "name" => "Listings Thumbnails",
	"desc" => "Thumbnail dimensions (Width x Height) in listings.",
	"id" => $shortname."_lthumb_size_w",
	"id2" => $shortname."_lthumb_size_h",
	"type" => "dimensions",
	"std" => "110",
	"std2" => "80"),

array( "name" => "Ad Page Thumbnails",
	"desc" => "Thumbnail dimensions (Width x Height) in ad page.",
	"id" => $shortname."_athumb_size_w",
	"id2" => $shortname."_athumb_size_h",
	"type" => "dimensions",
	"std" => "110",
	"std2" => "80"),

array( "type" => "close"),

array( "name" => "reCaptcha & Akismet",
	"type" => "title"),
 
array( "type" => "open"),

array( "name" => "ReCaptch Public Key",
	"desc" => "Please go to http://recaptcha.net/ to get one.",
	"id" => $shortname."_public_key",
	"type" => "text",
	"std" => ""),
 
array( "name" => "ReCaptch Private Key",
	"desc" => "Please go to http://recaptcha.net/ to get one.",
	"id" => $shortname."_private_key",
	"type" => "text",
	"std" => ""),

array( "name" => "Akismet Api Key",
	"desc" => "Please go to http://akismet.com/ to get one. Leave empty to disable this feature.",
	"id" => $shortname."_akismet",
	"type" => "text",
	"std" => ""),

array( "type" => "close"),

array( "name" => "Carousel Configuration",
	"type" => "title"),
 
array( "type" => "open"),

array( "name" => "Carrousel Title",
	"desc" => "Title used to name the frontpage carrousel.",
	"id" => $shortname."_title_carrousel",
	"type" => "text",
	"std" => "Featured Ads"),

array( "name" => "Carrousel Num. Ads",
	"desc" => "Number of ads displayed in the carrousel.",
	"id" => $shortname."_num_carrousel",
	"type" => "text",
	"std" => "15"),

array( "name" => "Carrousel Order Ads by",
	"desc" => "",
	"id" => $shortname."_order_carrousel",
	"type" => "select",
	"std" => "random",
	"options" => array("date", "random")),

array( "name" => "Exclude Categories from Carrousel",
	"desc" => "Comma separated list of Category ID's prefixed with a minus '-' (e.g -3,-4,-11) that will be excluded from the carrousel.",
	"id" => $shortname."_exlude_carrousel",
	"type" => "text",
	"std" => ""),
 
array( "type" => "close"),

array( "name" => "Emails Configuration",
	"type" => "title"),
 
array( "type" => "open"),

array( "name" => "Confirmation Email",
	"desc" => "Confirmation email sent after posting an ad. You can use the following tags: {SITE_NAME}, {TITLE_OF_AD}, {CONFIRM_LINK}, {EDIT_LINK}, {ELIMINATE_LINK}.",
	"id" => $shortname."_mail_confirm",
	"type" => "textarea",
	"std" => "You have posted an ad to {SITE_NAME}.

Your ad \"{TITLE_OF_AD}\" needs a confirmation to be published on the site.

To confirm and publish your ad please click the following link (or copy and paste it into your browser)
{CONFIRM_LINK}

To edit your ad please click the following link:
{EDIT_LINK}

To delete your ad please click the following link:
{ELIMINATE_LINK}

{SITE_NAME}"),

array( "name" => "Remember Links Email",
	"desc" => "Email sent to remember links to edit or eliminate an ad. You can use the following tags: {SITE_NAME}, {TITLE_OF_AD}, {EDIT_LINK}, {ELIMINATE_LINK}.",
	"id" => $shortname."_mail_remember",
	"type" => "textarea",
 	"std" => "You have posted an ad to {SITE_NAME}.

Title of your ad: \"{TITLE_OF_AD}\"

To edit your ad please click the following link:
{EDIT_LINK}

To eliminate your ad please click the following link:
{ELIMINATE_LINK}

{SITE_NAME}"),

array( "type" => "close")

);
?>
<?php
function mytheme_add_admin() {
 
global $themename, $shortname, $options;
 
if ( $_GET['page'] == basename(__FILE__) ) {
 
if ( 'save' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
 
foreach ($options as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
 
// regenerate the rewrite rules
global $wp_rewrite;
$wp_rewrite->flush_rules();
//
 
header("Location: themes.php?page=controlpanel.php&saved=true");
die;
 
} else if( 'reset' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
delete_option( $value['id'] ); }
 
header("Location: themes.php?page=controlpanel.php&reset=true");
die;
 
}
}
 
add_theme_page($themename." Config", "".$themename." Config", 'edit_themes', basename(__FILE__), 'mytheme_admin');
 
}
 
function mytheme_admin() {
 
global $themename, $shortname, $options;
 
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
 
?>
<div class="wrap">
<h2><?php echo $themename; ?> Settings</h2>
 
<form method="post">
 
<?php foreach ($options as $value) {
switch ( $value['type'] ) {
 
case "open":
?>
<table width="100%" border="0" style="background-color:#F9F9F9; padding:10px; border:1px solid #DFDFDF">
 
<?php break;
 
case "close":
?>
 
</table><br />
 
<?php break;
 
case "title":
?>
<table width="100%" border="0" style="background-color:#DFDFDF; padding:0px 10px;"><tr>
<td colspan="2"><h3 style="font-family:Georgia, serif; letter-spacing: 1px;"><?php echo $value['name']; ?></h3></td>
</tr>
</table>
 
<?php break;
 
case 'text':
?>
 
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" /></td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;

case 'dimensions':
?>
 
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><input style="width:50px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" /> X <input style="width:50px;" name="<?php echo $value['id2']; ?>" id="<?php echo $value['id2']; ?>" type="text" value="<?php if ( get_option( $value['id2'] ) != "") { echo get_option( $value['id2'] ); } else { echo $value['std2']; } ?>" /></td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;
 
case 'textarea':
?>
 
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?></textarea></td>
 
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;
 
case 'select':
?>
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;

case 'select_category':
?>
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><?php wp_dropdown_categories(array('selected' => get_option( $value['id'] ), 'name' => $value['id'], 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => 'None', 'hide_empty' => '0' )); ?></td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;

case 'page_select':
?>
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php $pages = get_pages(); foreach ($pages as $pagg) { ?><option<?php if ( get_option( $value['id'] ) == $pagg->ID) { echo ' selected="selected"'; } elseif ($pagg->ID == $value['std']) { echo ' selected="selected"'; } ?> value="<?php echo $pagg->ID; ?>"><?php echo $pagg->post_title; ?></option><?php } ?></select></td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;

case "checkbox":
?>
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
</td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php break;
 
}
}
?>
 
<p class="submit">
<input name="save" type="submit" value="Save changes" />
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
 
<?php
}
?>