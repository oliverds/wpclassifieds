<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!', 'wpct'));
		
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'wpct'); ?></p>
	<?php
		return;
	}
	$oddcomment = 'alt';
?>

<!-- You can start editing here. -->
<div class="comments">
<?php if ($comments) : ?>
	<h3 id="comments"><?php comments_number(__('No Comments', 'wpct'), __('One Comment', 'wpct'), __('% Comments', 'wpct') );?> <?php _e('to', 'wpct'); ?> &#8220;<?php the_title(); ?>&#8221;</h3>

	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>

		<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
			<cite><?php comment_author_link() ?></cite> <?php _e('Says', 'wpct'); ?>:
			<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.', 'wpct'); ?></em>
			<?php endif; ?>
			<br />

			<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F jS, Y') ?> <?php _e('at', 'wpct'); ?> <?php comment_time() ?></a> <?php edit_comment_link('e','',''); ?></small>

			<?php comment_text() ?>

		</li>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<h3 style="cursor:pointer;" onclick="openClose('adcomment');" id="respond"><?php _e('Leave a Comment', 'wpct'); ?></h3>

<div style="display:none;" id="adcomment" class="commentform form">
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be', 'wpct'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in', 'wpct'); ?></a> <?php _e('to post a comment.', 'wpct'); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as', 'wpct'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Logout', 'wpct'); ?> &raquo;</a></p>

<?php else : ?>

<p><label for="author"><small><?php _e('Name', 'wpct'); ?></small> <?php if ($req) _e('(required)', 'wpct'); ?></label><br />
<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" class="ico_person" />
</p>

<p><label for="email"><small><?php _e('Email', 'wpct'); ?></small> <?php _e('(will not be published)', 'wpct'); ?> <?php if ($req) echo "(required)"; ?></label><br />
<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" class="ico_mail" />
</p>

<p><label for="url"><small><?php _e('Website', 'wpct'); ?></small></label><br />
<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" class="ico_home" />
</p>

<?php endif; ?>

<p><textarea name="comment" id="comment" rows="10"></textarea></p>

<p><input name="submit" type="submit" id="submit" class="submit" value="<?php _e('Submit Comment', 'wpct'); ?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>
</div>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
</div>
