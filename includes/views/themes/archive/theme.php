<?php
/**
 * AspireExplorer Theme Card (Archive View)
 *
 * Displays a single theme card for the archive grid. Accessible, translatable, and visually polished.
 *
 * @package AspireExplorer
 */

/**
 * @var AspireExplorer\Model\ThemeInfo theme_info.
 */
$theme_info       = $args['theme_info'] ?? null;
$target_page_slug = $args['target_page_slug'] ?? '';
if ( ! $theme_info ) {
	return;
}
$theme_url        = home_url( '/' . $target_page_slug . '/' . $theme_info->get_slug() );
$theme_screenshot = $theme_info->get_screenshot_url();
if ( empty( $theme_screenshot ) ) {
	$theme_screenshot = AE_DIR_URL . 'assets/images/default-banner.svg';
}
?>
<li class="theme-card" aria-label="<?php echo esc_attr( $theme_info->get_name() ); ?> <?php esc_attr_e( 'theme card', 'aspireexplorer' ); ?>">
	<div class="theme-banner">
		<a href="<?php echo esc_url( $theme_url ); ?>"
			aria-label="<?php echo esc_attr( $theme_info->get_name() ); ?> <?php esc_attr_e( 'theme details', 'aspireexplorer' ); ?>"
			title="<?php echo esc_attr( $theme_info->get_name() ); ?>">
			<img src="<?php echo esc_url( $theme_info->get_screenshot_url() ); ?>"
				alt="<?php echo esc_attr( $theme_info->get_name() ); ?> <?php esc_attr_e( 'theme screenshot', 'aspireexplorer' ); ?>"
				loading="lazy" />
		</a>
	</div>
	<header class="entry-header">
		<div class="entry-title">
			<h3 class="theme-title">
				<a href="<?php echo esc_url( $theme_url ); ?>"
					aria-label="<?php echo esc_attr( $theme_info->get_name() ); ?> <?php esc_attr_e( 'theme details', 'aspireexplorer' ); ?>"
					title="<?php echo esc_attr( $theme_info->get_name() ); ?>">
					<?php echo esc_html( $theme_info->get_name() ); ?>
				</a>
			</h3>
			<p class="theme-author">
				<span class="screen-reader-text"><?php esc_html_e( 'Author:', 'aspireexplorer' ); ?> </span>
				<?php esc_html_e( 'by', 'aspireexplorer' ); ?>
				<span aria-label="<?php esc_attr_e( 'Author', 'aspireexplorer' ); ?>: <?php echo esc_attr( $theme_info->get_author( 'display_name' ) ); ?>">
					<?php echo esc_html( $theme_info->get_author( 'display_name' ) ); ?>
				</span>
			</p>
			<p class="theme-version">
				<span class="screen-reader-text"><?php esc_html_e( 'Version:', 'aspireexplorer' ); ?> </span>
				<span aria-label="<?php esc_attr_e( 'Version', 'aspireexplorer' ); ?>: <?php echo esc_attr( $theme_info->get_version() ); ?>">
					<?php echo esc_html( $theme_info->get_version() ); ?>
				</span>
			</p>
		</div>
	</header>
	<div class="entry-excerpt">
		<p aria-label="<?php esc_attr_e( 'Short description', 'aspireexplorer' ); ?>">
			<?php echo esc_html( wp_trim_words( $theme_info->get_description(), 30 ) ); ?>
		</p>
	</div>
	<footer>
		<div class="active-installs"></div>
		<p class="entry-preview">
			<?php
			$theme_slug  = $theme_info->get_slug();
			$preview_url = '';
			if ( $theme_slug ) {
				$theme_zip_url = $theme_info->get_download_link();
				$blueprint_url = AE_DIR_URL . 'includes/views/playground/blueprint.php?theme=' . $theme_zip_url;
				$cache_buster  = time();
				$preview_url   = 'https://playground.wordpress.net/?blueprint-url=' . rawurlencode( $blueprint_url ) . '&random=' . $cache_buster;
			}
			?>
			<a href="<?php echo esc_url( $preview_url ); ?>" class="button button-primary" target="_blank" rel="noopener noreferrer">
				<span class="dashicons dashicons-visibility"></span> <?php esc_html_e( 'Preview', 'aspireexplorer' ); ?>
			</a>
		</p>
		<p class="entry-download">
			<a href="<?php echo esc_url( $theme_info->get_download_link() ); ?>"
				class="button button-primary"
				target="_blank"
				rel="noopener noreferrer"
				aria-label="<?php esc_attr_e( 'Download', 'aspireexplorer' ); ?> <?php echo esc_attr( $theme_info->get_name() ); ?> <?php esc_attr_e( 'theme', 'aspireexplorer' ); ?>">
				<span class="dashicons dashicons-download" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Download', 'aspireexplorer' ); ?></span>
				<?php esc_html_e( 'Download', 'aspireexplorer' ); ?>
			</a>
		</p>
		<div class="entry-tags">
			<ul class="theme-tags">
				<?php
				foreach ( $theme_info->get_tags() as $theme_tag ) {
					echo '<li class="theme-tag"><span class="screen-reader-text">' . esc_html__( 'Tag:', 'aspireexplorer' ) . ' </span><span aria-label="' . esc_attr__( 'Tag', 'aspireexplorer' ) . ': ' . esc_attr( $theme_tag ) . '">' . esc_html( $theme_tag ) . '</span></li>';
				}
				?>
			</ul>
		</div>
	</footer>
</li>
