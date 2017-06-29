<?php
/*
Single Post Template: Blog Post
*/
?>

<?php get_header(); ?>
    <div class="grid_8" id="content_main">
      <div class="single_area">
	  	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="post">
          <h1><?php the_title(); ?></h1>
          <div class="postdetails">
            <p><span class="ico_date"><?php the_time('F j, Y'); ?></span> <?php _e("by", 'wpct'); ?> <?php the_author(); ?> &middot; <span class="ico_comment"><a rel="nofollow" href="<?php the_permalink(); ?>#respond"><?php comments_number(__('Leave a Comment', 'wpct'), __('1 Comment', 'wpct'), __('% Comments', 'wpct')); ?></a></span>&nbsp;<?php edit_post_link(__('(Edit)', 'wpct'), '', ''); ?><br />
            </p>
          </div>
          <?php the_content();?>
          <div class="clear"></div>
        </div>
        <?php comments_template(); ?>
        <?php endwhile; endif; ?>
        <p><?php posts_nav_link(); ?></p>
      </div>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>