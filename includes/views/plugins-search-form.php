<?php
$target_page_slug = $args['target_page_slug'] ?? '';
$search_keyword   = $args['search_keyword'] ?? '';
?>
<form method="get" action="<?php get_bloginfo( 'url' ); ?>/<?php echo esc_attr( $target_page_slug ); ?>" class="plugin-search-form" style="margin-bottom: 20px;">
	<input type="text" name="keyword" placeholder="Search WordPress Plugins" value="<?php echo esc_attr( $search_keyword ); ?>" />
	<button type="submit" class="search-btn"><span class="dashicons dashicons-search"></span> Search</button>
</form>
