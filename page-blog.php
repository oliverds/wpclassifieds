<?php
/*
Template Name: Blog Page
*/
?>

<?php get_header(); ?>
    <div class="grid_12">
      <?php yoast_breadcrumb(__('Home', 'wpct'), '/','<div class="breadcrumb">','</div>'); ?>
    </div>
    <div class="clear"></div>
    <div class="grid_8" id="content_main">
      <div class="single_area">
	  	<?php $page = (get_query_var('paged')) ? get_query_var('paged') : 1; query_posts("cat=".get_option('wpClassifieds_blog_cat')."&paged=$page"); while ( have_posts() ) : the_post() ?>
        <div class="post">
          <h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
          <div class="postdetails">
            <p><span class="ico_date"><?php the_time('F j, Y'); ?></span> <?php _e("by", 'wpct'); ?> <?php the_author(); ?> &middot; <span class="ico_comment"><a rel="nofollow" href="<?php the_permalink(); ?>#respond"><?php comments_number(__('Leave a Comment', 'wpct'), __('1 Comment', 'wpct'), __('% Comments', 'wpct')); ?></a></span>&nbsp;<?php edit_post_link(__('(Edit)', 'wpct'), '', ''); ?><br />
            </p>
          </div>
          <?php the_content(__('[Read more]', 'wpct'));?>
          <div class="clear"></div>
        </div>
        <?php endwhile; ?>
        <p><?php posts_nav_link(); ?></p>
      </div>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>