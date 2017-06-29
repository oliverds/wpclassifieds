<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes('xhtml'); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' | '; } ?><?php bloginfo('name'); if(is_home()) { echo ' | '; bloginfo('description'); } echo " ".slug_to_region(get_query_var('region'));?></title>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />

<?php if( get_option('wpClassifieds_custom_css') != "" ) :?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/<?php echo get_option('wpClassifieds_custom_css') ?>" type="text/css" media="all" />
<?php endif; ?>

<?php wp_enqueue_script("jquery"); ?>

<?php wp_head(); ?>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jqueryslidemenu.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/droplinemenu.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jcarousellite_1.0.1.pack.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.alternate.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/common.js"></script>

<!--[if lte IE 7]>
<style type="text/css">
html div#top_dropdown{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->

</head>
<body>
<div class="container_12" id="wrap">
  <div class="grid_12" id="header">
    <div id="logo"><a href="<?php echo get_option('home'); ?>/"><img src="<?php bloginfo('template_url'); ?>/img/logo.gif" alt="<?php echo get_bloginfo('name'); ?>" width="275" height="55" /></a> <?php if ( regions() && get_query_var('region')!="" ) : ?><p><?php echo slug_to_region(get_query_var('region'));?></p><?php endif; ?>
      <div class="clear"></div>
    </div>
  </div>
  <div class="clear"></div>
  <div class="grid_12" id="top_dropdown">
    <ul>
      <li class="default_page_item"><a href="<?php echo get_option('home'); ?>"><?php _e("Home", 'wpct'); ?></a></li>
	  <?php wp_list_pages('title_li=&depth=4&sort_column=menu_order&exclude='.get_option('wpClassifieds_exlude_pages')); ?>
    </ul>
  </div>
  <div class="clear"></div>
  <div class="grid_12" id="top_cats">
    <ul>
      <?php echo wp_list_categories_region('echo=0&show_count=0&title_li=&depth=4&hide_empty=0&exclude='.get_option('wpClassifieds_blog_cat')); ?>
    </ul>
  </div>
  <div class="clear"></div>
  <div id="content">