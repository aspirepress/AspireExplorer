<?php
/**
 * Class Themes
 *
 * The Workflow Controller for the Themes Section.
 */

namespace AspireExplorer\Controller;

class Themes extends \AspireExplorer\Model\Singleton {
	/**
	 * The page slug where the themes archive page should appear.
	 */
	private $target_page_slug;

	/**
	 * Constructor.
	 */
	protected function init() {
		$this->target_page_slug = 'themes';
		add_filter( 'init', [ $this, 'init_permalinks' ] );
		add_action( 'template_redirect', [ $this, 'template_redirect' ] );
		add_filter( 'query_vars', [ $this, 'query_vars' ] );
		add_filter( 'the_content', [ $this, 'the_content' ] );
	}

	/**
	 * Add rewrite rule
	 */
	public function init_permalinks() {
		add_rewrite_rule( '^themes/([^/]+)?$', 'index.php?theme_slug=$matches[1]', 'top' );
	}

	/**
	 * Register query var
	 */
	public function query_vars( $vars ) {
		$vars[] = 'theme_slug';
		return $vars;
	}

	/**
	 * Handle template redirection
	 */
	public function template_redirect() {
		$theme_slug = get_query_var( 'theme_slug' );
		if ( $theme_slug ) {
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
					$GLOBALS['theme_slug'] = $theme_slug;
					include get_page_template();
					exit;
				}
			}
		}
	}

	/**
	 * Filter the_content for themes page.
	 */
	public function the_content( $content ) {
		if ( ! is_page( $this->target_page_slug ) ) {
			return $content;
		}

		if ( ! function_exists( 'themes_api' ) ) {
			include_once ABSPATH . 'wp-admin/includes/theme.php';
		}

		if ( isset( $GLOBALS['theme_slug'] ) ) {
			return $this->single_the_content( $GLOBALS['theme_slug'] );
		} else {
			$search_keyword = isset( $_GET['keyword'] ) ? sanitize_text_field( $_GET['keyword'] ) : '';
			return $this->archive_the_content( $search_keyword );
		}
	}

	/**
	 * The Archive / Theme Search page.
	 *
	 * @return string The content to be displayed.
	 */
	private function archive_the_content( $search_keyword ) {
		ob_start();

		Utilities::include_file(
			'themes/themes-search-form.php',
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

		$api_response = \themes_api(
			'query_themes',
			$search_args
		);

		if ( is_wp_error( $api_response ) ) {
			echo wp_kses_post( wpautop( 'Error fetching themes. Please try again later.' ) );
			return ob_get_clean();
		}

		if ( empty( $api_response->themes ) ) {
			echo wp_kses_post( wpautop( 'No themes found for your search.' ) );
			return ob_get_clean();
		}

		//echo '<pre>'; print_r($api_response->themes[0]); echo '</pre>';
		//$theme_info = new \AspireExplorer\Model\ThemeInfo( $api_response->themes[0] );
		//echo '<pre>'; print_r($theme_info); echo '</pre>';
		Utilities::include_file(
			'themes/archive/themes.php',
			[
				'target_page_slug' => $this->target_page_slug,
				'themes_result'    => $api_response->themes,
				'current_page'     => $search_args['page'],
				'total_pages'      => ceil( $api_response->info['results'] / $search_args['per_page'] ),
			]
		);

		return ob_get_clean();
	}

	/**
	 * The individual theme page.
	 *
	 * @return string The content to be displayed.
	 */
	private function single_the_content( $theme_slug ) {

		$api_response = \themes_api(
			'theme_information',
			[
				'slug'   => $theme_slug,
				'fields' => 'all',
			]
		);

		if ( is_wp_error( $api_response ) ) {
			return wp_kses_post( wpautop( 'Error fetching theme information. Please try again later.' ) );
		}

		ob_start();
		//echo '<pre>'; print_r($api_response); echo '</pre>';
		$theme_info = new \AspireExplorer\Model\ThemeInfo( $api_response );
		//echo '<pre>'; print_r($theme_info); echo '</pre>';
		Utilities::include_file(
			'themes/single/theme.php',
			[
				'theme_info' => $theme_info,
			]
		);

		return ob_get_clean();
	}
}
