<?php
/*
Template Name: Page Contact
*/
?>

<?php get_header(); ?>
    <div class="grid_12">
      <?php yoast_breadcrumb(__('Home', 'wpct'), '/','<div class="breadcrumb">','</div>'); ?>
    </div>
    <div class="clear"></div>
    <div class="grid_8" id="content_main">
      <div class="single_area">
	  	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>    
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>

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
			if(isSpam(cP("name"),cP("email"),cP("description"))) {//check if is spam!
				$error = true;
				$error_text .= __('Ups!Spam? if you are not spam contact us.', "wpct")."<br />";
			}
			if(cP("contact_name") == "" || cP("email") == "" || cP("subject") == "" || cP("msg") == "") {
				$error = true;
				$error_text .= __('Please complete the mandatory fields.', "wpct")."<br />";
			}
			if (!$error){
				//generate the email to send
				$subject="[".get_bloginfo('name')."] ".cP("subject");
				$body=cP("contact_name")." (".cP("email").") ". " \n \n".cP("msg");
									
				$headers = 'From: '.cP("contact_name").' <'.cP("email").'>' . "\r\n\\";
				wp_mail(get_the_author_meta('user_email',1),$subject,$body,$headers);
													
				$error_text = __('Message sent, thank you.', "wpct");
				$submitted_ad = true;
			}
		}
		?>
		<?php if ($error_text) { echo "<div class=\"error-msg\">$error_text</div>"; }?>
		<?php if (!$submitted_ad) : ?>
        <div id="contactform" class="contactform form">
		  <form action="" method="post" enctype="multipart/form-data">
    	    <p>
      	      <label for="contact_name"><small><?php _e('Your name', "wpct");?>*</small></label>
      		  <br />
      		  <input type="text" name="contact_name" id="contact_name" class="ico_person" value="" />
    	    </p>
    	    <p>
      		  <label for="email"><small><?php _e('Email', "wpct");?>*</small></label>
      		  <br />
      		  <input type="text" name="email" id="email" class="ico_mail" value="" />
            </p>
            <p>
              <label for="email"><small><?php _e('Subject', "wpct");?>*</small></label>
              <br />
              <input type="text" name="subject" id="subject" class="ico_text" value="<?php echo cP("subject");?><?php echo cG("subject");?>" />
            </p>
            <p>
              <label for="msg"><small><?php _e('Message', "wpct");?>*</small></label>
              <br />
              <textarea name="msg" id="msg" rows="10"></textarea>
            </p>
            <p>
              <script type="text/javascript">
              var RecaptchaOptions = {
              theme : 'clean',
              };
              </script>
              <?php echo recaptcha_get_html(get_option('wpClassifieds_public_key')); ?>
            </p>
            <p style="margin-top:15px;">
              <input type="submit" value="<?php _e('Contact', "wpct");?>" class="submit" />
            </p>
		  </form>
        </div>
	  	<?php endif; ?>
        
	  	<?php endwhile; endif; ?>
      </div>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>