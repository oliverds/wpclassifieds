<?php
////////////////////////////////////////////////////////////
//Template Functions
////////////////////////////////////////////////////////////

require_once(TEMPLATEPATH.'/includes/controlpanel.php');
require_once(TEMPLATEPATH.'/includes/recaptchalib.php');
require_once(TEMPLATEPATH.'/includes/post_templates.php');
require_once(TEMPLATEPATH.'/includes/Akismet.class.php');
require_once(TEMPLATEPATH.'/includes/yoast_breadcrumbs.php');


////////////////////////////////////////////////////////////
function truncate($string, $length = 80, $etc = '...', $break_words = false, $middle = false) {
    if ($length == 0)
        echo '';

    if (strlen($string) > $length) {
        $length -= min($length, strlen($etc));
        if (!$break_words && !$middle) {
            $string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $length+1));
        }
        if (!$middle) {
            echo mb_substr($string, 0, $length) . $etc;
        } else {
            echo mb_substr($string, 0, $length/2) . $etc . mb_substr($string, -$length/2);
        }
    } else {
        echo $string;
    }
}

////////////////////////////////////////////////////////////
function clean($var){//request string cleaner
	if(get_magic_quotes_gpc()) $var = stripslashes($var); //clean
	$var = mysql_real_escape_string($var); //clean
	return strip_tags($var, ALLOWED_HTML_TAGS);//returning clean var
}

////////////////////////////////////////////////////////////
function cG($name){//clean Get, to prevent mysql injection Get method
	if(get_magic_quotes_gpc()) $_GET[$name]=stripslashes($_GET[$name]); 
	$name=mysql_real_escape_string($_GET[$name]);
	return $name;
}

////////////////////////////////////////////////////////////
function cP($name){//clean post, to prevent mysql injection Post method and remove html
	if(get_magic_quotes_gpc()) $_POST[$name]=stripslashes($_POST[$name]); 
	$name=mysql_real_escape_string(strip_tags($_POST[$name]));
	return $name;
}

////////////////////////////////////////////////////////////
function cPR($name){//clean post, to prevent mysql injection Post method, but don't remove the htmltags
	$name=strip_tags($_POST[$name]);
	return $name;
}

////////////////////////////////////////////////////////////
function isEmail($email){//check that the email is correct
	$pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/";
	if(preg_match($pattern, $email) > 0) return true;
	else return false;
}

////////////////////////////////////////////////////////////
function generatePassword ($length = 8){
	  // start with a blank password
	  $password = "";
	  // define possible characters
	  $possible = "0123456789abcdefghijklmnopqrstuvwxyz"; 
	  // set up a counter
	  $i = 0; 
	  // add random characters to $password until $length is reached
	  while ($i < $length) { 
		// pick a random character from the possible ones
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);	
		// we don't want this character if it's already in the password
		if (!strstr($password, $char)) { 
		  $password .= $char;
		  $i++;
		}
	  }
	  // done!
	  return $password;
}

////////////////////////////////////////////////////////////
function getIp(){//obtain the ip
		// if getenv results in something, proxy detected
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip=getenv('HTTP_X_FORWARDED_FOR');
		}
		else {// otherwise no proxy detected
			$ip=getenv('REMOTE_ADDR');
		}
		
		return $ip;
}

////////////////////////////////////////////////////////////
function isSpam($name,$email,$comment){//return if something is spam or not using akismet
	if (get_option('wpClassifieds_akismet')!=""){
		$akismet = new Akismet(get_option('siteurl') ,get_option('wpClassifieds_akismet'));//change this! or use defines with that name!
		$akismet->setCommentAuthor($name);
		$akismet->setCommentAuthorEmail($email);
		$akismet->setCommentContent($comment);
		return $akismet->isCommentSpam();
	}
	else return false;//we return is not spam since we don't have the api :(
}

////////////////////////////////////////////////////////////
function friendly_url($url) {

	// everything to lower and no spaces begin or end
	$url = strtolower(trim($url));
	
	//replace accent characters
	$url=replace_accents($url);
	
	// decode html
	//$url = html_entity_decode($url,ENT_QUOTES,CHARSET);
	
	// adding - for spaces and union characters
	$find = array(' ', '&', '\r\n', '\n', '+',',');
	$url = str_replace ($find, '-', $url);
	
	//delete and replace rest of special chars
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
	
	//return the friendly url
	return $url; 
}

////////////////////////////////////////////////////////////
function replace_accents($var){ //replace for accents catalan spanish and more
    //acccents 
    $var = ereg_replace("(À|Á|Â|Ã|Ä|Å|à|á|â|ã|ä|å)","a",$var); 
    $var = ereg_replace("(È|É|Ê|Ë|è|é|ê|ë)","e",$var); 
    $var = ereg_replace("(Ì|Í|Î|Ï|ì|í|î|ï)","i",$var); 
    $var = ereg_replace("(Ò|Ó|Ô|Õ|Ö|Ø|ò|ó|ô|õ|ö|ø)","o",$var); 
    $var = ereg_replace("(Ù|Ú|Û|Ü|ù|ú|û|ü)","u",$var); 
    //ntilde 
    $var = ereg_replace("(Ñ|ñ)","n",$var); 
    //cedilla
    $var = ereg_replace("(Ç|ç)","c",$var); 
    $var = ereg_replace("ÿ","y",$var); 
    return $var; 
}

////////////////////////////////////////////////////////////
function regions(){
	$regions = get_option('wpClassifieds_regions');
	if ($regions!='') return explode(";", get_option('wpClassifieds_regions'));
	else return false;
}

////////////////////////////////////////////////////////////
function slug_to_region($var){
	if ($var) {
		foreach (regions() as $region) {
				if (sanitize_title($var)==sanitize_title($region)) return $region;
		}
	}
}

////////////////////////////////////////////////////////////
function the_regions($mode='list',$columns='1',$class='') {	
    if ($mode == "list") {
		$i = 1;
		$q = count(regions());
		$z = ceil($q/$columns)+1;
		$string = '<div class="'.$class.'">';
		$string.= '<ul>';
		if (is_category()) {
			$category_link = get_category_link (get_query_var('cat'));
			foreach (regions() as $region) {
				if (($i % $z == 0) && $i != $q) $string.= '</ul></div><div class="'.$class.'"><ul>';
				if (get_option('permalink_structure') != '') {
					if (get_option('category_base')) $cat_base = get_option('category_base'); else $cat_base = "category";
					$cat_link = str_replace(get_option('home').'/'.$cat_base.'/',get_option('home').'/'.get_option('wpClassifieds_base_region','region').'/'.sanitize_title($region).'/',$category_link);
				}
				else {
					$cat_link = str_replace(get_option('home').'/?cat=',get_option('home').'/?region='.sanitize_title($region).'&cat=',$category_link);
				}
				$string.= '<li><a href="'.$cat_link.'">'.$region.'</a></li>';
				$i++;
			}
		}
		else {
			foreach (regions() as $region) {
				if (($i % $z == 0) && $i != $q) $string.= '</ul></div><div class="'.$class.'"><ul>';
				if (get_option('permalink_structure') != '') {
					$cat_url = get_option('home').'/'.get_option('wpClassifieds_base_region','region').'/'.sanitize_title($region).'/';
				}
				else {
					$cat_url = '?region='.sanitize_title($region);
				}
				$string.= '<li><a href="'.$cat_url.'">'.$region.'</a></li>';
				$i++;
			}
		}		
		$string.= '</ul>';
		$string.= '</div>';
	}

    elseif ($mode == "select") {
        foreach (regions() as $region) {
			$string.= '<option value="'.$region.'">'.$region.'</option>';
		}
	}
	
    echo $string;
}

////////////////////////////////////////////////////////////
function get_category_region_link($id='',$region='') {
	if ($region=='') $region = get_query_var('region');
	$cat_link = get_category_link($id);
	if ($region!='') {
		if (get_option('permalink_structure') != '') {
			if (get_option('category_base')) $cat_base = get_option('category_base'); else $cat_base = "category";
			$cat_link = str_replace(get_option('home').'/'.$cat_base.'/',get_option('home').'/'.get_option('wpClassifieds_base_region','region').'/'.sanitize_title($region).'/',$cat_link);
		}
		else {
			$cat_link = str_replace(get_option('home').'/?cat=',get_option('home').'/?region='.sanitize_title($region).'&cat=',$cat_link);
		}
	}
	$string = $cat_link;
    return $string;
}

////////////////////////////////////////////////////////////
function wp_list_categories_region($args='',$region='') {
	if ($region=='') $region = get_query_var('region');
	$wp_list_categories = wp_list_categories($args); 
	$wp_list_categories = preg_replace('/title=\"(.*?)\"/','',$wp_list_categories);
	if ($region!='') {
		if (get_option('permalink_structure') != '') {
			if (get_option('category_base')) $cat_base = get_option('category_base'); else $cat_base = "category";
			$wp_list_categories = str_replace(get_option('home').'/'.$cat_base.'/',get_option('home').'/'.get_option('wpClassifieds_base_region','region').'/'.sanitize_title($region).'/',$wp_list_categories);
		}
		else {
			$wp_list_categories = str_replace(get_option('home').'/?cat=',get_option('home').'/?region='.sanitize_title($region).'&cat=',$wp_list_categories);
		}
	}
	$string = $wp_list_categories;
    return $string;
}

////////////////////////////////////////////////////////////
function the_category_ad_ID(){
	$category = get_the_category(); 
	return $category[0]->cat_ID;
}

////////////////////////////////////////////////////////////
function file_delete($file) {
	$ofile = fopen($file, 'w');
	fclose($ofile);
	unlink($file);
}

////////////////////////////////////////////////////////////
function images_to_delete ($images) {
  $matches = explode(",", $images);
	foreach($matches as $var) {
		if ($var != "") {
			$upload_array = wp_upload_dir();
			$thumb_var = str_replace(get_option('home'), "", $var);
			file_delete(trailingslashit($upload_array['basedir']).$var); 
		}
	}
}

////////////////////////////////////////////////////////////
function the_breadcrumb() {
	$pid = $post->ID;
	$trail = '<li><a href="'.get_bloginfo('url').'/">Home</a></li>';
	
	if (is_category()) :
		$pdata = get_cat_id( single_cat_title("",false) );
		$data = explode('|',get_category_parents($pdata,true,'|'));
		array_pop($data);
		$last_item = end($data);
		if ($data) :
			foreach($data as $crumb) :
				if ($crumb == $last_item) :
					$crumb = strip_tags($crumb);
					$trail .= '<li class="selected">'.$crumb.'</li>';
				else :
					$trail .= '<li>'.$crumb.'</li>';
				endif;
			endforeach;
			unset ($crumb);
		endif;
		
	elseif (is_single()) :
		$pdata = get_the_category();
		$pdata = get_cat_ID($pdata[0]->cat_name);
		$data = explode('|',get_category_parents($pdata,true,'|'));
		array_pop($data);
		$last_item = end($data);
		if ($data) :
			foreach($data as $crumb) :
				$trail .= '<li>'.$crumb.'</li>';
			endforeach;
			unset ($crumb);
		endif;
		$trail .= '<li>'.get_the_title().'</li>';
	
	endif;
	
	echo $trail;
}

if (function_exists('register_sidebar'))
    register_sidebar(array(
		'name' => 'sidebar', 
        'before_widget' => '<div id="%1$s" class="box %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="h">',
        'after_title' => ' <em>&raquo;</em></div>',
    ));

////////////////////////////////////////////////////////////
function wpct_purge()
{
	if (get_option("wpClassifieds_purge_ads") != "")
	{
		global $wpdb;
		
		$date = date('Y-m-d H:i:s', strtotime("-".get_option("wpClassifieds_purge_ads")." days"));
				
		$result = $wpdb->get_results("
									SELECT wposts.* 
									FROM $wpdb->posts wposts 
									WHERE wposts.post_type = 'post' 
									AND wposts.post_date < '$date' 
									AND wposts.post_status = 'publish' 
									AND NOT EXISTS (SELECT * FROM $wpdb->postmeta wpostmeta WHERE wpostmeta.meta_key =  '_wp_post_template'  AND wposts.ID = wpostmeta.post_id )
									");
		foreach ($result as $post) {
			wp_update_post($post->ID);
		}
	}
}

////////////////////////////////////////////////////////////
function wpct_neighbors_ads($showposts = 5)
{
	global $wpdb;
	global $post;
	
    $request = "SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'publish' ";
	$request .= "AND post_type='post' ";
	$request .= "AND ID < $post->ID ORDER BY ID DESC LIMIT $showposts";
	
	$result = $wpdb->get_results($request);
	foreach ($result as $post) {
		setup_postdata($post);
		$postid = $post->ID;
		$title = $post->post_title;

		echo '<li><a href="'. get_permalink($postid) .'">'. $title .'</a></li>';

	} 
}

////////////////////////////////////////////////////////////
function wpct_has_children($catid) {
	if ( strstr(wp_list_categories('exclude='.get_option('wpClassifieds_blog_cat').'&echo=0&hide_empty=0&title_li=&depth=1&child_of='.$catid),'<li>'.__( "No categories" ).'</li>') ) {
		return false;
	}
	else {
		return true;	
	}
}

////////////////////////////////////////////////////////////
function wpct_h1_title() {
	echo '<h1 id="toph1">';
	if (is_home ()) {
		echo get_bloginfo('description');
		if (get_query_var('region')) {
			echo " - ".slug_to_region(get_query_var('region'));
		}
	}
	elseif (is_category()) {
		echo single_cat_title("", false);
		if (get_query_var('region')) {
			echo " - ".slug_to_region(get_query_var('region'));
		}
	}
	elseif (is_single()) echo truncate(wp_title('',false)." ".strip_tags(get_the_excerpt()),75,'');
	elseif (is_search()) echo $s." ".get_bloginfo('description');
	echo '</h1>';
}

////////////////////////////////////////////////////////////
function createRewriteRules() {
	global $wp_rewrite;
 
	// add rewrite tokens
	$keytag = '%region%';
	$wp_rewrite->add_rewrite_tag($keytag, '(.+?)', 'region=');
 
	$keywords_structure = $wp_rewrite->root .get_option('wpClassifieds_base_region','region')."/$keytag/%category%";
	$keywords_rewrite = $wp_rewrite->generate_rewrite_rules($keywords_structure);
 
	$wp_rewrite->rules = $keywords_rewrite + $wp_rewrite->rules;
	return $wp_rewrite->rules;
}
function query_vars($public_query_vars) {
	
	$public_query_vars[] = "region";
	return $public_query_vars;
}


add_filter('query_vars', 'query_vars');
add_action('admin_menu', 'mytheme_add_admin');
add_action('generate_rewrite_rules', 'createRewriteRules');

// Remove WP Generator for security reasons
remove_action('wp_head', 'wp_generator');

////////////////////////////////////////////////////////////
load_theme_textdomain('wpct', TEMPLATEPATH.'/languages' );
$locale = get_locale();
$locale_file = TEMPLATEPATH."/languages/$locale.php";
if (is_readable($locale_file))	require_once($locale_file);

?>
