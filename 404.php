<?php get_header(); ?>
    <div class="grid_12" id="content_main">
      <div class="single_area">
		<h1><?php _e("Not Found, Error 404", 'wpct'); ?></h1>
        <p><?php _e("The page you are looking for no longer exists. Perhaps you can return back to the site's", 'wpct'); ?> <a href="<?php bloginfo('siteurl');?>"><?php _e("homepage", 'wpct'); ?></a> <?php _e("and see if you can find what you are looking for.", 'wpct'); ?></p>
      </div>
    </div>
<?php get_footer(); ?>