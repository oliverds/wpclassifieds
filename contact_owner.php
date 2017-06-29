      <h3><?php _e('Contact Ad Owner', "wpct");?></h3>
	  <?php
      	if (cP("contact")==1){
      		$error = false;
			$resp = recaptcha_check_answer (get_option('wpClassifieds_private_key'),$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
			if(!$resp->is_valid) {
				$error = true;
				$error_text .= "<p>".__('The captcha is wrong!', "wpct")."</p>";//wrong email address
			}
            if(!isEmail(cP("email"))) {
            	$error = true;
                $error_text .= "<p>".__('Not valid email address', "wpct")."</p>";//wrong email address
            }
            if(isSpam(cP("name"),cP("email"),cP("description"))) {//check if is spam!
                $error = true;
                $error_text .= "<p>".__('Ups!Spam? if you are not spam contact us.', "wpct")."</p>";
            }
            if(cP("contact_name") == "" || cP("email") == "" || cP("msg") == "") {
                $error = true;
                $error_text .= "<p>".__('Please complete the mandatory fields.', "wpct")."</p>";
            }
            if (!$error){
                //generate the email to send to the client that is contacted
                $subject="[".get_bloginfo('name')."] ".__('Re:', "wpct")." ".get_the_title();
                $body=cP("contact_name")." (".cP("email").") ".__('contacted you for the Ad', "wpct")."\n".get_permalink()." \n \n".cP("msg")." \n \n";
                                            
                $headers = 'From: '.cP("contact_name").' <'.cP("email").'>' . "\r\n\\";
                wp_mail(get_post_meta(get_the_ID(), "email", true),$subject,$body,$headers);
                                                            
                $error_text = "<p>".__('Message sent, thank you.', "wpct")."</p>";
            }
      	}//if post
	  ?>          
	  <?php if ($error_text) { echo "<div class=\"error-msg\">$error_text</div>"; }?>

      <div id="contactform" class="contactform form">
      	<form action="" method="post">
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
            <input type="submit" class="submit" value="<?php _e('Contact', "wpct");?>" />
            <input type="hidden" name="contact" value="1" />
          </p>
        </form>
      </div>