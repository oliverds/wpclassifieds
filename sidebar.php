    <div class="grid_4" id="sidebar">
      <ul id="sidebar_widgets">
        <li id="sidebar_search" class="widget widget_recent_entries">
          <div class="whitebox">
            <h4><?php _e('Search Classified Ads', "wpct"); ?></h4>
            <form method="get" action="#">
              <input type="text" name="s" class="input" onblur="this.value=(this.value=='') ? '<?php _e('Search...', "wpct"); ?>' : this.value;" onfocus="this.value=(this.value=='<?php _e('Search...', "wpct"); ?>') ? '' : this.value;" value="<?php _e('Search...', "wpct"); ?>" />
              <?php wp_dropdown_categories('show_option_all='.__('All categories', "wpct").'&class=select&hide_empty=0&hierarchical=1&exclude='.get_option('wpClassifieds_blog_cat')); ?>
              <input type="submit" name="submit" class="button" value="<?php _e('Search', "wpct"); ?>" />
            </form>
          </div>
        </li>
        <?php if ( is_category() and !is_category(get_option('wpClassifieds_blog_cat')) ) : $this_category = get_category($cat); ?>
        <li class="widget">
          <div class="whitebox">
            <h4><?php _e('Subcategories', "wpct"); ?></h4>
            <ul>
              <?php if ( wpct_has_children($this_category->cat_ID) ) : ?>
              <?php echo wp_list_categories_region('exclude='.get_option('wpClassifieds_blog_cat').'&echo=0&hide_empty=0&title_li=&depth=1&child_of='.$this_category->cat_ID); ?>
              <?php else : $parent = $this_category->category_parent; ?>
              <?php echo wp_list_categories_region('exclude='.get_option('wpClassifieds_blog_cat').'&echo=0&hide_empty=0&title_li=&depth=1&child_of=' . $parent); ?>
              <?php endif; ?>
            </ul>
        	<div class="clear"></div>
          </div>
        </li>
        <?php endif; ?>
        <?php if ( (is_category() or is_home()) && regions() ) : ?>
        <li class="widget">
          <div class="whitebox">
            <h4><?php _e('Regions', "wpct"); ?></h4>
            <?php the_regions("list","2","columns"); ?>
        	<div class="clear"></div>
          </div>
        </li>
        <?php endif; ?>
        <?php if (is_single()) : ?>
        <li class="widget">
          <div class="whitebox">
            <h4><?php _e('Similar Ads', "wpct"); ?></h4>
            <ul>
              <?php $category = get_the_category($post->ID); query_posts('showposts=5&cat='.$category[0]->cat_ID);?>
              <?php while (have_posts()) : the_post(); ?>
              <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','wpct'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></li>
              <?php endwhile; wp_reset_query();?>
            </ul>
          </div>
        </li>
        <?php endif; ?>
        <?php if (!is_single()) : ?>
        <li class="widget">
          <div class="whitebox">
            <h4><?php _e('Most New', "wpct"); ?></h4>
          	<ul>
              <?php query_posts('showposts=5&cat=-'.get_option('wpClassifieds_blog_cat')); ?>
              <?php while (have_posts()) : the_post(); ?>
              <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','wpct'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; wp_reset_query();?>
          </ul>
          </div>
        </li>
        <?php endif; ?>
        <li class="widget">
          <div class="whitebox">
            <h4><?php _e('Most Popular', "wpct"); ?></h4>
            <ul>
              <?php query_posts('showposts=5&orderby=comment_count&order=ASC&cat=-'.get_option('wpClassifieds_blog_cat')); ?>
              <?php while (have_posts()) : the_post(); ?>
              <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to','wpct'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></li>
              <?php endwhile; wp_reset_query();?>
            </ul>
          </div>
        </li>
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("sidebar")) : ?>
	    <?php endif; ?>
      </ul>
    </div>