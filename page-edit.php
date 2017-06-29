<?php
/*
Template Name: Page Edit/Eliminate
*/
?>

<?php get_header(); ?>
    <div class="grid_12">
      <?php yoast_breadcrumb(__('Home', 'wpct'), '/','<div class="breadcrumb">','</div>'); ?>
    </div>
    <div class="clear"></div>
    <div class="grid_12 adform form" id="content_main">

<?php if (cG("pwd") && is_numeric(cG("post"))) : ?>

	<?php if (cG("pwd")==get_post_meta(cG("post"), "password", true) && cG("action")=="confirm") :
				// post information
				$data = array
				(
					'ID' => cG("post"),
					'post_status' => "publish"
				);
				// update post
				wp_update_post($data);
	?>							
    <div class="intro">
      <p><?php _e('Your ad has been confirmed, thank you', "wpct"); ?></p>
    </div>    												

	<?php elseif (cG("pwd")==get_post_meta(cG("post"), "password", true) && cG("action")=="delete") :
				// delete post
				wp_delete_post(cG("post"));
	?>							
    <div class="intro">
      <p><?php _e('Your ad has been deleted', "wpct"); ?></p>
    </div>    												

	<?php elseif (cG("pwd")==get_post_meta(cG("post"), "password", true) && cG("action")=="edit") :
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
				if(isSpam(cP("name"),cP("email"),cP("description"))) {//check if is spam!
					$error = true;
					$error_text .= __('Ups!Spam? if you are not spam contact us.', "wpct")."<br />";
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
		 				'ID' => cG("post"),
        				'post_title' => cP("title"),
            			'post_content' => cPR("description"),
            			'tags_input' => cP("tags")
        			);
					// update post
					wp_update_post($data);
					// add custom fields
					if ($price!="") update_post_meta(cG("post"), 'price', cP("price"));
					if (cP(place)!="") update_post_meta(cG("post"), 'place', cP("place"));
					if (cP(contact_name)!="") update_post_meta(cG("post"), 'contact_name', cP("contact_name"));
					if (cP(email)!="") update_post_meta(cG("post"), 'email', cP("email"));
					if (cP(phone)!="") update_post_meta(cG("post"), 'phone', cP("phone"));

					if (regions()) {
						if (cP(region)!="") {
							update_post_meta(cG("post"), 'region', cP("region"));
							update_post_meta(cG("post"), '_region_slug', friendly_url(cP("region")));
						}
					}
				
					// images upload
					if (get_option('wpClassifieds_max_img_num','4')>0&&$image_upload){
						images_to_delete(get_post_meta(cG("post"), 'images', true)); // first delete images
						$upload_array = wp_upload_dir();
						$img_upload_dir = trailingslashit($upload_array['basedir']).get_option('wpClassifieds_img_upload_dir','wpclassifieds')."/".date("Y")."/".date("m")."/".date("d");
						if (!file_exists($img_upload_dir)) mkdir($img_upload_dir, 0777, true);
						for ($i=1;$i<=get_option('wpClassifieds_max_img_num','4');$i++){
							$img_upload_file = trailingslashit($img_upload_dir).cG("post")."-".$i.strrchr($_FILES["pic$i"]['name'],'.');
							if (move_uploaded_file($_FILES["pic$i"]['tmp_name'],$img_upload_file)){
								$post_images .= get_option('wpClassifieds_img_upload_dir','wpclassifieds')."/".date("Y")."/".date("m")."/".date("d")."/".cG("post")."-".$i.strrchr($_FILES["pic$i"]['name'],'.').",";
							}
						}
						if (get_post_meta(cG("post"), 'images', true)) update_post_meta(cG("post"), 'images', $post_images);
						else add_post_meta(cG("post"), 'images', $post_images, true);;
					}
		
					$error_text2 = __('Updated Ad', "wpct");
					$submitted_ad = true;
				}
			}//if post
		
			if (!$submitted_ad) :
		  	$post_info = get_post(cG("post"));
			?>
            
          	  <h1><?php the_title(); ?></h1>
              <?php if ($error_text) { echo "<div class=\"error-msg\">$error_text</div>"; }?>
              <form action="" method="post" enctype="multipart/form-data">
                <fieldset>
                  <div class="field">
                    <label for="title"><?php _e('Title', "wpct");?></label>
                    <input id="title" name="title" type="text" value="<?php echo $post_info->post_title;?>" class="ico_title" />
                  </div>
                  <div class="field">
                    <label for="price"><?php _e('Price', "wpct");?> <?php echo get_option('wpClassifieds_currency','$'); ?><small><?php _e('Optional', "wpct");?> - <?php _e('Only numbers', "wpct");?></small></label>
                    <input id="price" name="price" type="text" value="<?php echo get_post_meta($post_info->ID, "price", true); ?>" class="ico_price" />
                  </div>
                  <div class="field">
                    <label for="description"><?php _e('Detailed description', "wpct");?></label>
                    <textarea id="description" name="description" cols="10" rows="5"><?php echo $post_info->post_content;?></textarea>
                  </div>
                  <?php if ( regions() ) : ?>
                    <div class="field">
                    <label for="region"><?php _e('Region', "wpct");?></label>
                    <select id="region" name="region">
                      <option value='-1'>Select Region</option>
              		  <option selected="selected" value='<?php echo get_post_meta($post_info->ID, "region", true); ?>'><?php echo get_post_meta($post_info->ID, "region", true); ?></option>
              		  <?php the_regions("select"); ?>
                    </select>
                  </div>
                  <?php endif; ?>
                  <div class="field">
                    <label for="place"><?php _e('Location', "wpct");?><small><?php _e('Optional', "wpct");?></small></label>
                    <input id="place" name="place" type="text" value="<?php echo get_post_meta($post_info->ID, "place", true); ?>" class="ico_globe"/>
                  </div>
                  <div class="field">
                    <label for="contact_name"><?php _e('Your name', "wpct");?></label>
                    <input id="contact_name" name="contact_name" type="text" value="<?php echo get_post_meta($post_info->ID, "contact_name", true); ?>" class="ico_person" />
                  </div>
                  <div class="field">
                    <label for="email"><?php _e('Email', "wpct");?><small><?php _e('(will not be published)', "wpct");?></small></label>
                    <input id="email" name="email" type="text" value="<?php echo get_post_meta($post_info->ID, "email", true); ?>" class="ico_mail" />
                  </div>
                  <div class="field">
                    <label for="phone"><?php _e('Your contact phone number (published)', "wpct");?><small><?php _e('Optional', "wpct");?></small></label>
                    <input id="phone" name="phone" type="text" value="<?php echo get_post_meta($post_info->ID, "phone", true); ?>"  class="ico_mobile" />
                  </div>
                  <div class="field">
                    <label for="tags"><?php _e('Tags (comma seperated)', "wpct");?><small><?php _e('Optional', "wpct");?></small></label>
                    <input id="tags" name="tags" type="text" value="<?php $posttags = get_the_tags($post_info->ID); if ($posttags) { foreach($posttags as $tag) { $tags .= $tag->name . ','; } echo substr($tags,0,-1); } ?>" class="ico_tag" />
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
                  <input name="Submit" value="<?php _e('Update', "wpct");?>" type="submit" class="submit" />
                </div>
              </form>
			<?php endif; ?>
	<?php else : ?>
    <div class="intro">
      <p><?php _e('Nothing found', "wpct"); ?></p>
    </div>
<?php endif; ?>
<?php elseif (cP("recover")==1) :
		$error = false;
		$resp = recaptcha_check_answer (get_option('wpClassifieds_private_key'),$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
		if(!$resp->is_valid) {
			$error = true;
			$error_text2 .= __('The captcha is wrong!', "wpct")."<br />";//wrong captcha
		}
		if(!isEmail(cP("emailR"))) {
			$error = true;
			$error_text2 .= __('Not valid email address', "wpct")."<br />";//wrong email address
		}
		if (!$error){
			query_posts('showposts=-1&meta_key=email&meta_value='.cP("emailR"));
			if (have_posts()) {
				while (have_posts()) : the_post(); 
					//generate the email to send
					if (get_option('permalink_structure') != '' ) {
					$linkEliminate=get_permalink(get_option('wpClassifieds_edit_page_id'))."?post=".get_the_ID()."&pwd=".get_post_meta(get_the_ID(), "password", true)."&action=delete";
					$linkEdit=get_permalink(get_option('wpClassifieds_edit_page_id'))."?post=".get_the_ID()."&pwd=".get_post_meta(get_the_ID(), "password", true)."&action=edit";
					}
					else {
					$linkEliminate=get_permalink(get_option('wpClassifieds_edit_page_id'))."&post=".get_the_ID()."&pwd=".get_post_meta(get_the_ID(), "password", true)."&action=delete";
					$linkEdit=get_permalink(get_option('wpClassifieds_edit_page_id'))."&post=".get_the_ID()."&pwd=".get_post_meta(get_the_ID(), "password", true)."&action=edit";
					}
													
				    $body= get_option('wpClassifieds_mail_remember');
				    $body= str_replace(array("{SITE_NAME}", "{TITLE_OF_AD}", "{EDIT_LINK}", "{ELIMINATE_LINK}"), array(get_bloginfo('name'), get_the_title(), $linkEdit, $linkEliminate), $body);

				    $subject="[".get_bloginfo('name')."] ".__('Manage your Ad', "wpct");
				    $headers = 'From: no-reply '.get_bloginfo('name').' <'.get_the_author_meta('user_email',1).'>' . "\r\n\\";
				    wp_mail(get_post_meta(get_the_ID(), "email", true),$subject,$body,$headers);
					
				endwhile;
					$error_text2 = __('Message sent, thank you.', "wpct");
			}
			else {
				$error_text2 = __('There are no ads with this email.', "wpct");
			}
			wp_reset_query();
		}
	?>
<?php else : ?>
	  <div id="contactform" class="adform form">
          <div class="intro">
            <p><?php _e('To recover the email with links to edit and delete your ads, enter your information below.', "wpct");?></p>
          </div>
          <form action="" method="post">
            <fieldset>
              <div class="field">
                <label for="category"><?php _e('Email', "wpct");?></label>
                <input type="text" name="emailR" id="emailR" class="ico_mail" />
                <input type="hidden" name="recover" value="1" />
              </div>
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
              <input name="Submit" value="<?php _e('Recover', "wpct");?>" type="submit" class="submit" />
            </div>
          </form>
      </div>
<?php endif; ?>
<?php if ($error_text2) { echo "<div class=\"error-msg\">$error_text2</div>"; } ?>
    
	</div>
<?php get_footer(); ?>