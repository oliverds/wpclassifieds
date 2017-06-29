<?php get_header(); ?>
    <div class="grid_12">
      <?php yoast_breadcrumb(__('Home', 'wpct'), '/','<div class="breadcrumb">','</div>'); ?>
    </div>
    <div class="clear"></div>
    <div class="grid_8" id="content_main">
      <div id="listings">
        <?php if (is_category()) : ?>
        <h1><?php single_cat_title(_e('Results for ', "wpct")); ?> <?php if ( regions() && get_query_var('region')!="" ) : ?> <?php _e('in', "wpct"); ?> <?php echo slug_to_region(get_query_var('region'));?><?php endif; ?></h1>
        <?php endif; ?>
        <?php
        	if( get_query_var('region')!='' && regions() )	{					
				query_posts($query_string.'&meta_key=region&meta_value='.slug_to_region(get_query_var('region')));
			}
	  	?>
	  	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>          
        <div class="post">
          <?php
				$pictures = get_post_meta($post->ID, 'images', true);
		  		if ($pictures) :
                    $pictures = explode(",", $pictures);
                    $picture = "uploads/".$pictures[0];
		  ?>
          <img src="<?php bloginfo('template_directory'); ?>/includes/timthumb.php?src=<?php echo $picture; ?>&amp;w=<?php echo get_option('wpClassifieds_lthumb_size_w','110') ?>&amp;h=<?php echo get_option('wpClassifieds_lthumb_size_h','80') ?>&amp;zc=1" alt="<?php the_title(); ?>" class="post-img" />
          <?php endif; ?>
          <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
          <div class="post-detail">
            <p>
              <?php if(get_post_meta(get_the_ID(), "price", true)) : ?>
              <span class="post-price"><?php echo '$'.get_post_meta(get_the_ID(), "price", true); ?></span> — 
			  <?php endif; ?>
              <span class="post-cat"><?php the_category(', ') ?></span> — 
              <?php if(get_post_meta(get_the_ID(), "region", true) && regions()) : ?>
              <span class="post-place"><a href="<?php echo get_category_region_link(the_category_ad_ID(),get_post_meta(get_the_ID(), "region", true)); ?>"><?php echo get_post_meta(get_the_ID(), "region", true); ?></a></span> — 
              <?php elseif(get_post_meta(get_the_ID(), "place", true)) : ?>
              <span class="post-place"><?php echo get_post_meta(get_the_ID(), "place", true); ?></span> — 
			  <?php endif; ?>
			  <span class="post-date"><?php echo sprintf(__('%s ago','wpct'),human_time_diff(get_the_time('U'), current_time('timestamp'))); ?></span>
            </p>
          </div>
          <p class="post-desc"><?php echo truncate(strip_tags(get_the_excerpt()),175,'...'); ?></p>
          <div class="clear"></div>
		</div>
        <?php endwhile; ?>
        <div class="pagination">
	  	  <?php include_once('includes/wp-pagenavi.php'); if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
		<?php endif; ?>
	  </div>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>