<?php
$target_page_slug = $args['target_page_slug'] ?? '';
$search_keyword   = $args['search_keyword'] ?? '';
?>
<form method="get" action="<?php echo esc_url( get_bloginfo( 'url' ) . '/' . $target_page_slug ); ?>" class="theme-search-form" role="search" aria-label="<?php esc_attr_e( 'Theme search form', 'aspireexplorer' ); ?>">
	<label for="theme-search-keyword" class="screen-reader-text"><?php esc_html_e( 'Search WordPress Themes', 'aspireexplorer' ); ?></label>
	<input type="text" id="theme-search-keyword" name="keyword" placeholder="<?php esc_attr_e( 'Search WordPress Themes', 'aspireexplorer' ); ?>" value="<?php echo esc_attr( $search_keyword ); ?>" aria-label="<?php esc_attr_e( 'Search WordPress Themes', 'aspireexplorer' ); ?>" />
	<button type="submit" class="search-btn" aria-label="<?php esc_attr_e( 'Submit theme search', 'aspireexplorer' ); ?>">
		<span class="dashicons dashicons-search" aria-hidden="true"></span>
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'aspireexplorer' ); ?></span>
	</button>
</form>
