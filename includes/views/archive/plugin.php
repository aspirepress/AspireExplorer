<?php
/**
 * @var AspireExplorer\Model\PluginInfo plugin_info.
 */
$plugin_info = $args['plugin_info'] ?? [];

$target_page_slug = $args['target_page_slug'] ?? '';
$plugin_url       = home_url( '/' . $target_page_slug . '/' . $plugin_info->get_slug() );

$plugin_icon = $plugin_info->get_best_icon();
if ( empty( $plugin_icon ) ) {
	$plugin_icon = AE_DIR_URL . 'assets/images/default-icon.svg';
}
?>
<li class="plugin-card">
	<header class="entry-header">
		<div class="entry-thumbnail">
			<img class="plugin-icon" src="<?php echo esc_url( $plugin_icon ); ?>" alt="Plugin Icon">
		</div>
		<div class="entry-title">
			<h3 class="plugin-title"><a href="<?php echo esc_url( $plugin_url ); ?>"><?php echo esc_html( $plugin_info->get_name() ); ?></a></h3>
			<p class="plugin-author">by <?php echo esc_html( $plugin_info->get_author() ); ?></p>
			<p class="plugin-version">Version: <?php echo esc_html( $plugin_info->get_version() ); ?></p>
		</div>
	</header>
	<div class="entry-excerpt">
		<p><?php echo esc_html( wp_trim_words( $plugin_info->get_short_description(), 30 ) ); ?></p>
	</div>
	<footer>
		<p class="active-installs">
			<span><?php echo esc_html( $plugin_info->get_active_installs() ); ?> Active installations</span>
		</p>
		<p class="entry-download">
			<a href="<?php echo esc_url( $plugin_info->get_download_link() ); ?>" class="button button-primary" target="_blank" rel="noopener noreferrer">
				<span class="dashicons dashicons-download"></span> Download
			</a>
		</p>
		<div class="entry-tags">
			<ul class="plugin-tags">
				<?php
				foreach ( $plugin_info->get_tags() as $tag ) {
					echo '<li class="plugin-tag">' . esc_html( $tag ) . '</li>';
				}
				?>
			</ul>
		</div>
	</footer>
</li>
