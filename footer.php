    <div class="clear"></div>
  </div>
  <div class="grid_12" id="footer">
    <ul class="pages">
      <?php wp_list_pages('title_li=&depth=1&sort_column=menu_order'); ?>
    </ul>
    <!-- PLEASE BE RESPECTFUL AND DO NOT REMOVE THIS -->
    <p>wpClassifieds Theme - hosted by <a href="http://www.open-classifieds.com/">Open Classifieds</a></p>
    <!-- END -->
  </div>
  <div class="clear"></div>
</div>
<?php wp_footer(); ?>
<?php if ( get_option('wpClassifieds_track_code') != "" ) { echo stripslashes(get_option('wpClassifieds_track_code')); } ?>
<?php wpct_purge(); ?>
</body>
</html>