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
<li class="plugin-card" aria-label="<?php echo esc_attr( $plugin_info->get_name() ); ?> <?php esc_attr_e( 'plugin card', 'aspireexplorer' ); ?>">
	<header class="entry-header">
		<div class="entry-thumbnail">
			<img class="plugin-icon" src="<?php echo esc_url( $plugin_icon ); ?>" alt="<?php echo esc_attr( $plugin_info->get_name() ); ?> <?php esc_attr_e( 'icon', 'aspireexplorer' ); ?>">
		</div>
		<div class="entry-title">
			<h3 class="plugin-title">
				<a href="<?php echo esc_url( $plugin_url ); ?>"
					aria-label="<?php echo esc_attr( $plugin_info->get_name() ); ?> <?php esc_attr_e( 'plugin details', 'aspireexplorer' ); ?>"
					title="<?php echo esc_attr( $plugin_info->get_name() ); ?>">
					<?php echo esc_html( $plugin_info->get_name() ); ?>
				</a>
			</h3>
			<p class="plugin-author">
				<span class="screen-reader-text"><?php esc_html_e( 'Author:', 'aspireexplorer' ); ?> </span>
				<?php esc_html_e( 'by', 'aspireexplorer' ); ?>
				<span aria-label="<?php esc_attr_e( 'Author', 'aspireexplorer' ); ?>: <?php echo esc_attr( $plugin_info->get_author() ); ?>">
					<?php echo esc_html( $plugin_info->get_author() ); ?>
				</span>
			</p>
			<p class="plugin-version">
				<span class="screen-reader-text"><?php esc_html_e( 'Version:', 'aspireexplorer' ); ?> </span>
				<span aria-label="<?php esc_attr_e( 'Version', 'aspireexplorer' ); ?>: <?php echo esc_attr( $plugin_info->get_version() ); ?>">
					<?php echo esc_html( $plugin_info->get_version() ); ?>
				</span>
			</p>
		</div>
	</header>
	<div class="entry-excerpt">
		<p aria-label="<?php esc_attr_e( 'Short description', 'aspireexplorer' ); ?>">
			<?php echo esc_html( wp_trim_words( $plugin_info->get_short_description(), 30 ) ); ?>
		</p>
	</div>
	<footer>
		<p class="active-installs">
			<?php
			$active_installs = $plugin_info->get_active_installs();
			if ( is_null( $active_installs ) ) {
				?>
				<span class="screen-reader-text"><?php esc_html_e( 'Installation Count not Available:', 'aspireexplorer' ); ?> </span>
				<span aria-label="<?php esc_attr_e( 'Installation Count not Available', 'aspireexplorer' ); ?>">
					<?php esc_html_e( 'Installation Count not Available', 'aspireexplorer' ); ?>
				</span>
				<?php
			} else {
				?>
				<span class="screen-reader-text"><?php esc_html_e( 'Active installations:', 'aspireexplorer' ); ?> </span>
				<span aria-label="<?php esc_attr_e( 'Active installations', 'aspireexplorer' ); ?>: <?php echo esc_attr( $plugin_info->get_active_installs() ); ?>">
					<?php echo esc_html( $plugin_info->get_active_installs() ); ?> <?php esc_html_e( 'Active installations', 'aspireexplorer' ); ?>
				</span>
				<?php
			}
			?>
		</p>
		<p class="entry-download">
			<a href="<?php echo esc_url( $plugin_info->get_download_link() ); ?>"
				class="button button-primary"
				target="_blank"
				rel="noopener noreferrer"
				aria-label="<?php esc_attr_e( 'Download', 'aspireexplorer' ); ?> <?php echo esc_attr( $plugin_info->get_name() ); ?> <?php esc_attr_e( 'plugin', 'aspireexplorer' ); ?>">
				<span class="dashicons dashicons-download" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Download', 'aspireexplorer' ); ?></span>
				<?php esc_html_e( 'Download', 'aspireexplorer' ); ?>
			</a>
		</p>
		<div class="entry-tags">
			<ul class="plugin-tags">
				<?php
				foreach ( $plugin_info->get_tags() as $plugin_tag ) {
					echo '<li class="plugin-tag"><span class="screen-reader-text">' . esc_html__( 'Tag:', 'aspireexplorer' ) . ' </span><span aria-label="' . esc_attr__( 'Tag', 'aspireexplorer' ) . ': ' . esc_attr( $plugin_tag ) . '">' . esc_html( $plugin_tag ) . '</span></li>';
				}
				?>
			</ul>
		</div>
	</footer>
</li>
