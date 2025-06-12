<?php
$target_page_slug = $args['target_page_slug'] ?? '';
$search_keyword   = $args['search_keyword'] ?? '';
?>
<form method="get" action="<?php echo esc_url( get_bloginfo( 'url' ) . '/' . $target_page_slug ); ?>" class="plugin-search-form" role="search" aria-label="<?php esc_attr_e( 'Plugin search form', 'aspireexplorer' ); ?>">
	<label for="plugin-search-keyword" class="screen-reader-text"><?php esc_html_e( 'Search WordPress Plugins', 'aspireexplorer' ); ?></label>
	<input type="text" id="plugin-search-keyword" name="keyword" placeholder="<?php esc_attr_e( 'Search WordPress Plugins', 'aspireexplorer' ); ?>" value="<?php echo esc_attr( $search_keyword ); ?>" aria-label="<?php esc_attr_e( 'Search WordPress Plugins', 'aspireexplorer' ); ?>" />
	<button type="submit" class="search-btn" aria-label="<?php esc_attr_e( 'Submit plugin search', 'aspireexplorer' ); ?>">
		<span class="dashicons dashicons-search" aria-hidden="true"></span>
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'aspireexplorer' ); ?></span>
	</button>
</form>
