<?php if (get_dynamic_sidebar('sidebar-left')  != ''): ?> 
	<div class="<?php flex_col('sidebar'); ?>" id="sidebar-left">
		<?php do_action('before_sidebar'); ?> 
		<?php dynamic_sidebar('sidebar-left'); ?> 
	</div>
<?php endif; ?> 