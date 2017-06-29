<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>
    <div class="grid_12">
      <?php yoast_breadcrumb(__('Home', 'wpct'), '/','<div class="breadcrumb">','</div>'); ?>
    </div>
    <div class="clear"></div>
    <div class="grid_12" id="content_main">
      <div class="single_area">
	  	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>    
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
        <?php endwhile; endif; ?>
      </div>
	</div>
<?php get_footer(); ?>