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
$theme_url        = home_url( '/' . $target_page_slug . '/' . $theme_info->get_slug() . '/' );
$theme_screenshot = $theme_info->get_screenshot_url();
if ( empty( $theme_screenshot ) ) {
	$theme_screenshot = AE_DIR_URL . 'assets/images/default-banner.svg';
}
?>
<li class="theme-card">
	<div class="theme-banner">
		<a href="<?php echo esc_url( $theme_url ); ?>">
			<img src="<?php echo esc_url( $theme_screenshot ); ?>"
				alt="<?php echo esc_attr( $theme_info->get_name() ); ?> <?php esc_attr_e( 'theme screenshot', 'aspireexplorer' ); ?>"
				loading="lazy" />
		</a>
	</div>
	<header class="entry-header">
		<div class="entry-title">
			<h2 class="theme-title">
				<a href="<?php echo esc_url( $theme_url ); ?>">
					<?php echo esc_html( $theme_info->get_name() ); ?>
				</a>
			</h2>
			<p class="theme-author">
				<span class="screen-reader-text"><?php esc_html_e( 'Author:', 'aspireexplorer' ); ?> </span>
				<?php esc_html_e( 'by', 'aspireexplorer' ); ?>
				<span>
					<?php echo esc_html( $theme_info->get_author( 'display_name' ) ); ?>
				</span>
			</p>
			<p class="theme-version">
				<span><?php esc_html_e( 'version', 'aspireexplorer' ); ?></span> <?php echo esc_html( $theme_info->get_version() ); ?>
			</p>
		</div>
	</header>
	<div class="entry-excerpt">
		<p>
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
				$preview_url   = AspireExplorer\Controller\Playground::get_playground_url( [ 'theme' => $theme_zip_url ] );
			}
			?>
			<a href="<?php echo esc_url( $preview_url ); ?>" class="button button-primary" target="_blank" rel="noopener noreferrer">
				<span class="dashicons dashicons-visibility"></span> <?php esc_html_e( 'Preview', 'aspireexplorer' ); ?>
			</a>
		</p>
		<p class="entry-download">
			<a href="<?php echo esc_url( $theme_info->get_download_link() ); ?>"
				class="button button-primary"
				download
				rel="noopener noreferrer">
				<span class="dashicons dashicons-download" aria-hidden="true"></span>
				<?php esc_html_e( 'Download', 'aspireexplorer' ); ?>
			</a>
		</p>
		<div class="entry-tags">
			<ul class="theme-tags">
				<?php
				$tags = $theme_info->get_tags();
				$tags = array_slice( $tags, 0, 5 );
				foreach ( $tags as $theme_tag ) {
					echo '<li class="theme-tag"><span class="screen-reader-text">' . esc_html__( 'Tag:', 'aspireexplorer' ) . ' </span><span>' . esc_html( $theme_tag ) . '</span></li>';
				}
				?>
			</ul>
		</div>
	</footer>
</li>
