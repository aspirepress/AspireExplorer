<?php
$target_page_slug = $args['target_page_slug'] ?? '';
$plugins_result   = $args['plugins_result'] ?? [];
$current_page     = $args['current_page'] ?? 1;
$total_pages      = $args['total_pages'] ?? 1;
?>
<main class="archive-plugin-card">
	<ul class="plugin-results">
		<?php
		foreach ( $plugins_result as $plugin_result ) {
			$plugin_info = new \AspireExplorer\Model\PluginInfo( $plugin_result );
			\AspireExplorer\Controller\Utilities::include_file(
				'archive/plugin.php',
				[
					'target_page_slug' => $target_page_slug,
					'plugin_info'      => $plugin_info,
				]
			);
		}
		?>
	</ul>
	<div class="pagination-wrapper">
		<?php
		$big = 999999999;
		echo wp_kses_post(
			paginate_links(
				[
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => $current_page,
					'total'     => $total_pages,
					'prev_next' => false,
					'type'      => 'list',
				]
			)
		);
		?>
	</div>
</main>
