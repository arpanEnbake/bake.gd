<div class="container_12" id="footer">
    <div class="grid_12">
		<span class="validator"><a href="http://validator.w3.org/check?uri=<?php echo current_url(); ?>"><img src="resource/app/img/valid-xhtml10.png" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a></span>
        <?php echo sprintf(lang('website_page_rendered_in_x_seconds'), $this->benchmark->elapsed_time()); ?>
    </div>
    <div class="clear"></div>
</div>