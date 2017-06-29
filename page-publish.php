<?php
/*
Template Name: Page Publish
*/
?>

<?php get_header(); ?>
    <div class="grid_12">
      <?php yoast_breadcrumb(__('Home', 'wpct'), '/','<div class="breadcrumb">','</div>'); ?>
    </div>
    <div class="clear"></div>
    <div class="grid_12 adform form" id="content_main">

      <?php
      if ($_POST){
		  $error = false;
		  $resp = recaptcha_check_answer (get_option('wpClassifieds_private_key'),$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
		  if(!$resp->is_valid) {
			  $error = true;
			  $error_text .= __('The captcha is wrong!', "wpct")."<br />";//wrong email address
      	  }
      	  if(!isEmail(cP("email"))) {
		  	  $error = true;
		  	  $error_text .= __('Not valid email address', "wpct")."<br />";//wrong email address
      	  }
	  	  if(isSpam(cP("name"),cP("email"),cPR("description"))) {//check if is spam!
		  	  $error = true;
		  	  $error_text .= __('Ups!Spam? if you are not spam contact us.', "wpct")."<br />";
	  	  }
	  	  if (cP("category") == "-1") {
		  	  $error = true;
		  	  $error_text .= __('Please select a category', "wpct")."<br />";
	  	  }
	  	  else {
		  	  global $wpdb;
		  	  $category_ids = $wpdb->get_col("SELECT `term_id` FROM $wpdb->term_taxonomy WHERE taxonomy='category'");
		  	  if (!in_array(cP("category"), $category_ids)) {
			  	  $error = true;
			  	  $error_text .= __('The category selected does not exist','wpct') . "<br />";
		  	  }
	  	  }
	  	  if(cP("title") == "" || cP("description") == "") {
		  	  $error = true;
		  	  $error_text .= __('Please complete the mandatory fields.', "wpct")."<br />";
	  	  }
	  	  if ( regions() ) {
		  	  if (cP("region") == "-1") {
			  	  $error = true;
			  	  $error_text .= __('Please select a region', "wpct")."<br />";
		  	  }
		  	  else {
			  	  if (!in_array(cP("region"), regions()) && cP("region") != "-1") {
				  	  $error = true;
				  	  $error_text .= __('The region selected does not exist','wpct') . "<br />";
			  	  }
		  	  }
	  	  }
	  	  //image check 
	  	  if (get_option('wpClassifieds_max_img_num','4')>0){	
		  	  $image_check=true;
		  	  $image_upload=false;//nothing to upload
		  	  $types=split(",",get_option('wpClassifieds_img_types','gif,jpeg,png'));//creating array with the allowed types
		  	  for ($i=1;$i<=get_option('wpClassifieds_max_img_num','4')&&$image_check;$i++){
			  	  $file_size = $_FILES["pic$i"]['size'];
			  	  $file_type = $_FILES["pic$i"]['type'];
			  	  if ($file_size > get_option('wpClassifieds_max_img_size','1000000')) {//control the size
				  	  $image_check=false;//is to big then false
				  	  $error = true;
				  	  $error_text .=__('Picture', "wpct")." $i ".__('Upload pictures max file size', "wpct")." ".(get_option('wpClassifieds_max_img_size','1000000')/1000000)."Mb<br />";				
			  	  }
			  	  elseif ($file_type!=""){//the size is right checking type
				  	  $image_check=false;//not allowed
				  	  foreach ($types as $ac_type){//to find allowed types
					  	  if (strpos($file_type, $ac_type)) $image_check=true;//allowed one
				  	  }
			  	  }//end else
			  	  if (!$image_check) {
				  	  $error = true;
				  	  $error_text .=__('Picture', "wpct")." $i no ".__('format', "wpct")." ".get_option('wpClassifieds_img_types','gif,jpeg,png')."<br />";
			  	  }
			  	  if (file_exists($_FILES["pic$i"]['tmp_name'])) $image_upload=true;//there's someting to upload
		  	  }//end for			
	  	  }//end if img
	  	  //end image check
	  	  if (!$error){
		  	  if (is_numeric(cP("price"))) $price=cP("price");
		  	  else unset($price);
		  	  // post information
          	  $data = array
          	  (
        	  	  'post_title' => cP("title"),
              	  'post_content' => cPR("description"),
              	  'post_status' => "draft",
			  	  'post_category'	=> array(cP("category")),
			  	  'tags_input'	=> cP("tags")
          	  );
		  	  // insert post
		  	  $published_id = wp_insert_post($data);
		  	  $post_password = generatePassword();
		  	  // add custom fields
		  	  if ($price!="") add_post_meta($published_id, 'price', cP("price"), true);
		  	  if (cP(place)!="") add_post_meta($published_id, 'place', cP("place"), true);
		  	  if (cP(contact_name)!="") add_post_meta($published_id, 'contact_name', cP("contact_name"), true);
		  	  if (cP(email)!="") add_post_meta($published_id, 'email', cP("email"), true);
		  	  if (cP(phone)!="") add_post_meta($published_id, 'phone', cP("phone"), true);
		
		  	  if (regions()) {
			  	  if (cP(region)!="") {
				  	  add_post_meta($published_id, 'region', cP("region"), true);
				  	  add_post_meta($published_id, '_region_slug', friendly_url(cP("region")), true);
			  	  }
		  	  }
						
		  	  add_post_meta($published_id, 'password', $post_password, true);
		  	  add_post_meta($published_id, 'ip', getIp(), true);
		
		  	  // images upload
		  	  if (get_option('wpClassifieds_max_img_num','4')>0&&$image_upload){
			  	  $upload_array = wp_upload_dir();
			  	  $img_upload_dir = trailingslashit($upload_array['basedir']).get_option('wpClassifieds_img_upload_dir','wpclassifieds')."/".date("Y")."/".date("m")."/".date("d");
			  	  if (!file_exists($img_upload_dir)) mkdir($img_upload_dir, 0777, true);
			  	  for ($i=1;$i<=get_option('wpClassifieds_max_img_num','4');$i++){
				  	  $img_upload_file = trailingslashit($img_upload_dir).$published_id."-".$i.strrchr($_FILES["pic$i"]['name'],'.');
				  	  if (move_uploaded_file($_FILES["pic$i"]['tmp_name'],$img_upload_file)){
					  	  $post_images .= get_option('wpClassifieds_img_upload_dir','wpclassifieds')."/".date("Y")."/".date("m")."/".date("d")."/".$published_id."-".$i.strrchr($_FILES["pic$i"]['name'],'.').",";
				  	  }
			   	  }
			  	  add_post_meta($published_id, 'images', $post_images, true);
		  	  }
		
		  	  //EMAIL notify
		  	  if (get_option('permalink_structure') != '' ) {
		  	  	  $linkConfirm=get_permalink(get_option('wpClassifieds_edit_page_id'))."?post=$published_id&pwd=$post_password&action=confirm";
		  	  	  $linkEliminate=get_permalink(get_option('wpClassifieds_edit_page_id'))."?post=$published_id&pwd=$post_password&action=delete";
		  	  	  $linkEdit=get_permalink(get_option('wpClassifieds_edit_page_id'))."?post=$published_id&pwd=$post_password&action=edit";
		  	  }
		  	  else {
		  	  	  $linkConfirm=get_permalink(get_option('wpClassifieds_edit_page_id'))."&post=$published_id&pwd=$post_password&action=confirm";
		  	  	  $linkEliminate=get_permalink(get_option('wpClassifieds_edit_page_id'))."&post=$published_id&pwd=$post_password&action=delete";
		  	  	  $linkEdit=get_permalink(get_option('wpClassifieds_edit_page_id'))."&post=$published_id&pwd=$post_password&action=edit";
		  	  }

		  	  $body= get_option('wpClassifieds_mail_confirm');
		  	  $body= str_replace(array("{SITE_NAME}", "{TITLE_OF_AD}", "{CONFIRM_LINK}", "{EDIT_LINK}", "{ELIMINATE_LINK}"), array(get_bloginfo('name'), cP("title"), $linkConfirm, $linkEdit, $linkEliminate), $body);

              $subject="[".get_bloginfo('name')."] ".__('Ad Confirmation', "wpct");
		  	  $headers = 'From: no-reply '.get_bloginfo('name').' <'.get_the_author_meta('user_email',1).'>' . "\r\n\\";
		  	  wp_mail(cP(email),$subject,$body,$headers);
												
		  	  $error_text = __('Thank you! Check your email inbox to confirm your ad', "wpct");
		  	  $submitted_ad = true;
	  	  }
      }//if post
      ?>
  	  <?php if (!$submitted_ad) : ?>
      <h1><?php the_title(); ?></h1>
      <?php if (get_option("wpClassifieds_post_message") != "") : ?>
      <div class="intro">
        <?php echo get_option('wpClassifieds_post_message'); ?>
      </div>
      <?php endif; ?>
  	  <?php if ($error_text) { echo "<div class=\"error-msg\">$error_text</div>"; }?>
  	  <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
          <div class="field">
            <label for="category"><?php _e('Category', "wpct");?></label>
            <?php wp_dropdown_categories('show_option_none='.__('Select category', "wpct").'&hide_empty=0&hierarchical=1&name=category&exclude='.get_option('wpClassifieds_blog_cat')); ?>
          </div>
          <div class="field">
            <label for="title"><?php _e('Title', "wpct");?></label>
            <input id="title" name="title" type="text" value="<?php echo cP("title");?>" class="ico_title" />
          </div>
          <div class="field">
            <label for="price"><?php _e('Price', "wpct");?> <?php echo get_option('wpClassifieds_currency','$'); ?><small><?php _e('Optional', "wpct");?> - <?php _e('Only numbers', "wpct");?></small></label>
            <input id="price" name="price" type="text" value="<?php echo cP("price");?>" class="ico_price" />
          </div>
          <div class="field">
            <label for="description"><?php _e('Detailed description', "wpct");?></label>
            <textarea id="description" name="description" cols="10" rows="5"><?php echo cPR("description");?></textarea>
          </div>
          <?php if ( regions() ) : ?>
            <div class="field">
            <label for="region"><?php _e('Region', "wpct");?></label>
            <select id="region" name="region">
              <option value='-1'><?php _e('Select Region', "wpct");?></option>
            <?php the_regions("select"); ?>
            </select>
          </div>
          <?php endif; ?>
          <div class="field">
            <label for="place"><?php _e('Location', "wpct");?><small><?php _e('Optional', "wpct");?></small></label>
            <input id="place" name="place" type="text" value="<?php echo cP("place");?>" class="ico_globe"/>
          </div>
          <div class="field">
            <label for="contact_name"><?php _e('Your name', "wpct");?></label>
            <input id="contact_name" name="contact_name" type="text" value="<?php echo cP("contact_name");?>" class="ico_person" />
          </div>
          <div class="field">
            <label for="email"><?php _e('Email', "wpct");?><small><?php _e('(will not be published)', "wpct");?></small></label>
            <input id="email" name="email" type="text" value="<?php echo cP("email");?>" class="ico_mail" />
          </div>
          <div class="field">
            <label for="phone"><?php _e('Your contact phone number (published)', "wpct");?><small><?php _e('Optional', "wpct");?></small></label>
            <input id="phone" name="phone" type="text" value="<?php echo cP("phone");?>"  class="ico_mobile" />
          </div>
          <div class="field">
            <label for="tags"><?php _e('Tags (comma seperated)', "wpct");?><small><?php _e('Optional', "wpct");?></small></label>
            <input id="tags" name="tags" type="text" value="<?php echo cP("tags");?>" class="ico_tag" />
          </div>
          <?php if (get_option('wpClassifieds_max_img_num','4')>0) : ?>
          <div class="field">
			<label><?php echo __('Upload pictures max file size', "wpct").": ".(get_option('wpClassifieds_max_img_size','1000000')/1000000)."Mb "?> <small><?php echo __('format', "wpct")." ".get_option('wpClassifieds_img_types','gif,jpeg,png'); ?></small></label><div class="clear"></div>
          </div>
	 	  <?php for ($i=1;$i<=get_option('wpClassifieds_max_img_num','4');$i++) : ?>
          <div class="pictures">
		    <label><?php _e('Picture', "wpct");?> <?php echo $i?></label>
            <input type="file" name="pic<?php echo $i?>" id="pic<?php echo $i?>" value="<?php echo $_POST["pic".$i];?>" />
          </div>
		  <?php endfor; ?>
          <?php endif; ?>
          <div class="field">
		    <label><?php _e('Type the two words', "wpct");?></label>
            <script type="text/javascript">
 			  var RecaptchaOptions = {
			  theme : 'clean',
			  };
		    </script>
            <?php echo recaptcha_get_html(get_option('wpClassifieds_public_key')); ?>
          </div>
        </fieldset>
        <div id="submit">
          <input name="Submit" value="<?php _e('Publish', "wpct");?>" type="submit" class="submit" />
        </div>
  	  </form>
  	  <?php endif; ?>
  	  <?php if ($error_text and $submitted_ad) :  ?>
	  
	  <h1><?php the_title(); ?></h1>
	  <div class="error-msg"><?php echo $error_text; ?></div>
	  
	  <?php endif; ?>
          
	</div>
<?php get_footer(); ?>