<?php get_header(); ?>
    <div class="grid_12">
      <div class="pop_cats">
        <?php
			$categories = get_categories('hide_empty=0&number=5&orderby=count&order=desc&exclude='.get_option('wpClassifieds_blog_cat'));
        ?>
        <?php _e('Popular Categories', "wpct"); ?> / 
        <?php
      		foreach ($categories as $category) {
	    ?>
        <a href="<?php echo get_category_link($category->cat_ID) ?>"><?php echo $category->name; ?></a><span>,</span> 
        <?php 
	  		}
	  	?>
      </div>
    </div>
    <div class="clear"></div>
    <div class="grid_8" id="frontpage">
      <h4 class="carousel"><?php echo get_option('wpClassifieds_title_carrousel','Featured Ads') ?></h4>
      <div id="carousel">
        <div class="prev"><img src="<?php bloginfo('template_url'); ?>/img/prev.jpg" alt="prev" width="19" height="19" /></div>
        <div class="slider">
          <ul>
            <?php query_posts('showposts='.get_option('wpClassifieds_num_carrousel','15').'&cat=-'.get_option('wpClassifieds_blog_cat').','.get_option('wpClassifieds_exlude_carrousel').'&orderby='.get_option('wpClassifieds_order_carrousel','random')); ?>
            <?php while (have_posts()) : the_post(); ?>
            <li>
              <?php
					$pictures = get_post_meta($post->ID, 'images', true);
		  			if ($pictures) :
                    	$pictures = explode(",", $pictures);
                    	$picture = "uploads/".$pictures[0];
					else :
						$picture = "img/no-pic.gif";
					endif;
		  	  ?>
              <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','wpct'); ?> <?php the_title(); ?>"><img src="<?php bloginfo('template_directory'); ?>/includes/timthumb.php?src=<?php echo $picture; ?>&amp;w=110&amp;h=80&amp;zc=1" alt="<?php the_title(); ?>" /></a><br />
              <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','wpct'); ?> <?php the_title(); ?>"><?php echo truncate(get_the_title(), 30, "...", true); ?></a><br />
              <?php if(get_post_meta(get_the_ID(), "region", true) && regions()) : ?>
              <?php echo truncate(get_post_meta(get_the_ID(), "region", true), 15, "...", true); ?>
              <?php elseif(get_post_meta(get_the_ID(), "place", true)) : ?>
              <?php echo truncate(get_post_meta(get_the_ID(), "place", true), 15, "...", true); ?>
			  <?php endif; ?>
            </li>
            <?php endwhile; wp_reset_query();?>
          </ul>
        </div>
        <div class="next"><img src="<?php bloginfo('template_url'); ?>/img/next.jpg" alt="next" width="19" height="19" /></div>
        <div class="clear"></div>
      </div>
      <div id="frontpage_cats">
        <?php
        	$categories = get_categories('hide_empty=0&hierarchical=0&parent=0&exclude='.get_option('wpClassifieds_blog_cat'));
			$i = 0;
			$q = count($categories);
			$z = round($q/3);
			foreach ($categories as $key => $category){
				if ($i==0 or $i==$z) {
					echo '<div class="cats_col1 cats_colums">';
				}
				elseif ($i==($z*2)) {
					echo '<div class="cats_col2 cats_colums">';
				}
				echo '<ul><li class="cathead"><a href="'.get_category_region_link($category->cat_ID).'">'.$category->name.'</a></li>';
				echo wp_list_categories_region('echo=0&title_li=&orderby=name&show_count=0&use_desc_for_title=0&hide_empty=0&depth=1&child_of='.$category->cat_ID);
				echo '</ul>';
				if ($i==($z-1) or $i==(($z*2)-1) or $i==($q-1)) {
				echo '</div>';
				}
				$i++;
			}
		?>
	  </div>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>