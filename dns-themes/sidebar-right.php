<?php
 if (get_dynamic_sidebar('sidebar-right') != ''): ?> 
	<div class="<?php flex_col('sidebar'); ?>" id="sidebar-right">
		<?php do_action('before_sidebar'); ?> 
		<?php dynamic_sidebar('sidebar-right'); ?> 
	</div>
<?php endif; ?> 