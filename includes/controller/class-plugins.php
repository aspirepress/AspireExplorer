<?php
/**
 * Class Plugins
 *
 * The Workflow Controller for the Plugins Section.
 */

namespace AspireExplorer\Controller;

class Plugins extends \AspireExplorer\Model\Singleton {
	/**
	 * The page slug where the plugins archive page should appear.
	 */
	private $target_page_slug;

	/**
	 * Constructor.
	 */
	protected function init() {
		$this->target_page_slug = 'plugins';
		add_filter( 'init', [ $this, 'init_permalinks' ] );
		add_action( 'template_redirect', [ $this, 'template_redirect' ] );
		add_filter( 'query_vars', [ $this, 'query_vars' ] );
		add_filter( 'the_content', [ $this, 'the_content' ] );
	}

	/**
	 * Add rewrite rule
	 */
	public function init_permalinks() {
		add_rewrite_rule( '^plugins/([^/]+)?$', 'index.php?plugin_slug=$matches[1]', 'top' );
	}

	/**
	 * Register query var
	 */
	public function query_vars( $vars ) {
		$vars[] = 'plugin_slug';
		return $vars;
	}

		/**
	 * Handle template redirection
	 */
	public function template_redirect() {
		$plugin_slug = get_query_var( 'plugin_slug' );
		if ( $plugin_slug ) {
			$page = get_page_by_path( $this->target_page_slug );
			if ( $page ) {
				$page_query = new \WP_Query(
					[
						'page_id'   => $page->ID,
						'post_type' => 'page',
					]
				);

				if ( $page_query->have_posts() ) {
					global $wp_query, $post;
					$wp_query = $page_query;
					$post     = $page_query->post;
					setup_postdata( $post );
					$GLOBALS['plugin_slug'] = $plugin_slug;
					include get_page_template();
					exit;
				}
			}
		}
	}


	/**
	 *
	 */
	public function the_content( $content ) {
		if ( ! is_page( $this->target_page_slug ) ) {
			return $content;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}

		if ( isset( $GLOBALS['plugin_slug'] ) ) {
			return $this->single_the_content( $GLOBALS['plugin_slug'] );
		} else {
			$search_keyword = isset( $_GET['keyword'] ) ? sanitize_text_field( $_GET['keyword'] ) : '';
			return $this->archive_the_content( $search_keyword );
		}
	}

	/**
	 * The Archive / Plugin Search page.
	 *
	 * @return string The content to be displayed.
	 */
	private function archive_the_content( $search_keyword ) {
		ob_start();

		Utilities::include_file(
			'plugins-search-form.php',
			[
				'target_page_slug' => $this->target_page_slug,
				'search_keyword'   => $search_keyword,
			]
		);

		$search_args = [
			'page'     => max( 1, get_query_var( 'paged' ) ),
			'per_page' => 10,
		];

		if ( '' !== $search_keyword ) {
			$search_args['search'] = $search_keyword;
		} else {
			$search_args['browse'] = 'popular';
		}

		$api_response = plugins_api(
			'query_plugins',
			$search_args
		);

		if ( is_wp_error( $api_response ) ) {
			echo wp_kses_post( wpautop( 'Error fetching plugins. Please try again later.' ) );
			return ob_get_clean();
		}

		if ( empty( $api_response->plugins ) ) {
			echo wp_kses_post( wpautop( 'No plugins found for your search.' ) );
			return ob_get_clean();
		}

		Utilities::include_file(
			'archive/plugins.php',
			[
				'target_page_slug' => $this->target_page_slug,
				'plugins_result'   => $api_response->plugins,
				'current_page'     => $search_args['page'],
				'total_pages'      => ceil( $api_response->info['results'] / $search_args['per_page'] ),
			]
		);

		return ob_get_clean();
	}

	/**
	 * The indivigual plugin page.
	 *
	 * @return string The content to be displayed.
	 */
	private function single_the_content( $plugin_slug ) {

		$api_response = plugins_api(
			'plugin_information',
			[
				'slug'   => $plugin_slug,
				'fields' => 'all',
			]
		);

		if ( is_wp_error( $api_response ) ) {
			return wp_kses_post( wpautop( 'Error fetching plugin information. Please try again later.' ) );
		}

		ob_start();

		//echo '<pre>'; print_r($api_response); echo '</pre>';
		$plugin_info = new \AspireExplorer\Model\PluginInfo( $api_response );
		//echo '<pre>'; print_r($plugin_info); echo '</pre>';
		Utilities::include_file(
			'single/plugin.php',
			[
				'plugin_info' => $plugin_info,
			]
		);

		return ob_get_clean();
	}
}
