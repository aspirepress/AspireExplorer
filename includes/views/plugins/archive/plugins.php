<?php
$target_page_slug = $args['target_page_slug'] ?? '';
$plugins_result   = $args['plugins_result'] ?? [];
$current_page     = $args['current_page'] ?? 1;
$total_pages      = $args['total_pages'] ?? 1;
?>
<main class="archive-plugin-card">
	<div class="plugin-results-count">
		<p id="plugin-results-count-text" aria-hidden="true">
			<?php
			$plugin_count = count( $plugins_result );
			printf(
				/* translators: %s: number of plugins found */
				esc_html( _n( '%s Plugin Found.', '%s Plugins Found.', $plugin_count, 'aspireexplorer' ) ),
				esc_html( $plugin_count )
			);
			?>
		</p>
		<span class="screen-reader-text" aria-live="polite" aria-atomic="true" id="plugin-results-count-sr">
			<?php
			printf(
				esc_html(
					/* translators: %s: number of plugins in the results list */
					_n(
						'%s plugin found in the results list below.',
						'%s plugins found in the results list below.',
						$plugin_count,
						'aspireexplorer'
					)
				),
				esc_html( $plugin_count )
			);
			?>
		</span>
	</div>
	<div class="plugin-results">
		<?php
		foreach ( $plugins_result as $plugin_result ) {
			$plugin_info = new \AspireExplorer\Model\PluginInfo( $plugin_result );
			\AspireExplorer\Controller\Utilities::include_file(
				'plugins/archive/plugin.php',
				[
					'target_page_slug' => $target_page_slug,
					'plugin_info'      => $plugin_info,
				]
			);
		}
		?>
	</div>
	<div class="pagination-wrapper">
		<?php
		if ( 1 < $total_pages ) {
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
		}
		?>
	</div>
</main>
