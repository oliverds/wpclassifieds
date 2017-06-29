<?php get_header(); ?>
    <div class="grid_12">
      <?php yoast_breadcrumb(__('Home', 'wpct'), '/','<div class="breadcrumb">','</div>'); ?>
    </div>
    <div class="clear"></div>
    <div class="grid_8" id="content_main">
	  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>    
      <div class="single_area">
        <h1><?php the_title(); ?></h1>
        <?php if (get_option("wpClassifieds_ad_code") != "") : ?>
        <p>
          <?php echo stripslashes(get_option('wpClassifieds_ad_code')); ?>
        </p>
        <?php endif; ?>
        <p>
          <strong><?php _e('Publish date', "wpct");?>:</strong> <?php the_time('F j, Y g:i a'); ?>
          <?php if(get_post_meta(get_the_ID(), "contact_name", true)) : ?>
           | <strong><?php _e('Contact Name', "wpct");?>:</strong> <?php echo get_post_meta(get_the_ID(), "contact_name", true); ?>
          <?php endif; ?>
          <?php if(get_post_meta(get_the_ID(), "price", true)) : ?>
           | <strong><?php _e('Price', "wpct");?>:</strong> <?php echo get_post_meta(get_the_ID(), "price", true); ?>
          <?php endif; ?>
          <?php if(get_post_meta(get_the_ID(), "region", true)) : ?>
           | <strong><?php _e('Region', "wpct");?>:</strong> <?php echo get_post_meta(get_the_ID(), "region", true); ?>
          <?php endif; ?>
          <?php if(get_post_meta(get_the_ID(), "place", true)) : ?>
           | <strong><?php _e('Location', "wpct");?>:</strong> <?php echo get_post_meta(get_the_ID(), "place", true); ?>
          <?php endif; ?>
          <?php if(get_post_meta(get_the_ID(), "phone", true)) : ?>
           | <strong><?php _e('Phone', "wpct");?>:</strong> <?php echo get_post_meta(get_the_ID(), "phone", true); ?>
          <?php endif; ?>
          <?php if(get_the_tag_list()) : ?>
           | <strong><?php _e('Tags', "wpct");?>:</strong> <?php echo get_the_tag_list('',', ',''); ?>
          <?php endif; ?>
        </p>
        <?php
			$pictures = get_post_meta($post->ID, 'images', true);
		  	if ($pictures) :
		?>
        <div id="pictures">
          <?php
		  	$pictures = explode(",", $pictures);
			$upload_array = wp_upload_dir();
			foreach($pictures as $picture) :
				if ($picture != "") :
			?>
            <a rel="facebox" href="<?php echo trailingslashit($upload_array['baseurl']).$picture ?>"><img src="<?php echo get_bloginfo('template_directory')?>/includes/timthumb.php?src=uploads/<?php echo $picture ?>&amp;w=<?php echo get_option('wpClassifieds_athumb_size_w','110') ?>&amp;h=<?php echo get_option('wpClassifieds_athumb_size_h','80') ?>&amp;zc=1" alt="<?php the_title() ?>" title="<?php the_title()  ?>" /></a>
            <?php
				endif;
			endforeach;
		  ?>
          <div class="clear"></div>
		</div>
        <?php endif; ?>
        <?php the_content(); ?>
        <p>
          <strong><?php _e('Share', "wpct");?>:</strong>
          <a rel="nofollow" target="_blank" href="http://www.twitter.com/home?status=<?php echo get_the_title()." ".get_permalink();?>" title="Twitter <?php _e('Share', "wpct");?> <?php the_title(); ?>">Twitter</a> | 
          <a rel="nofollow" target="_blank" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>" title="Facebook <?php _e('Share', "wpct");?> <?php the_title(); ?>">Facebook</a> | 
          <a rel="nofollow" href="mailto:?body=<?php the_permalink(); ?>&amp;subject=<?php the_title(); ?>" title="Email <?php _e('Share', "wpct");?> <?php the_title(); ?>">Email</a>
        </p>
        <p>
          <?php if (function_exists('wpfp_link')) { wpfp_link(); echo " | "; } ?> 
          <a rel="nofollow" href="<?php echo get_permalink(get_option('wpClassifieds_contact_page_id')); ?>?subject=<?php _e('Report bad use or Spam', "wpct");?> (<?php the_ID(); ?>) <?php the_title(); ?>"><?php _e('Report bad use or Spam', "wpct");?></a>
        </p>
      </div>
      <?php include(TEMPLATEPATH."/contact_owner.php");?>
      <?php comments_template(); ?>
      <?php endwhile; endif; ?>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>