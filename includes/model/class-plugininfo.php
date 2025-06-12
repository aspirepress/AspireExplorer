<?php
namespace AspireExplorer\Model;

/**
 * Class PluginInfo
 *
 * Represents detailed metadata of a WordPress plugin retrieved via the Plugin API.
 * Provides explicit getters and setters for safe and structured access.
 * Also Provides typed access to plugin fields with validation.
 */
class PluginInfo extends AssetInfo {
	/**
	 * Array of required plugin slugs (if applicable).
	 *
	 * @var array
	 */
	private $requires_plugins;

	/**
	 * Number of unresolved support threads on WordPress.org.
	 *
	 * @var int
	 */
	private $support_threads;

	/**
	 * Number of resolved support threads on WordPress.org.
	 *
	 * @var int
	 */
	private $support_threads_resolved;

	/**
	 * Optional business model (if provided).
	 *
	 * @var string|null
	 */
	private $business_model;

	/**
	 * Optional repository url (if provided).
	 *
	 * @var string|null
	 */
	private $repository_url;

	/**
	 * Optional commercial support url (if provided).
	 *
	 * @var string|null
	 */
	private $commercial_support_url;

	/**
	 * Optional donation link (if provided).
	 *
	 * @var string|null
	 */
	private $donate_link;

	/**
	 * Icon URLs (keys may include '1x', '2x', 'svg').
	 *
	 * @var array
	 */
	private $icons;

	public function __construct( $data = [] ) {
		parent::__construct( $data );
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
	}

	// ------------------ GETTERS ------------------

	/**
	 * Get the array of required plugin slugs.
	 *
	 * @return array List of plugin slugs or empty array.
	 */
	public function get_requires_plugins() {
		return is_array( $this->requires_plugins ) ? $this->requires_plugins : [];
	}

	/**
	 * Get number of open support threads.
	 *
	 * @return int|null Open thread count.
	 */
	public function get_support_threads() {
		return is_numeric( $this->support_threads ) ? (int) $this->support_threads : null;
	}

	/**
	 * Get number of resolved support threads.
	 *
	 * @return int|null Resolved thread count.
	 */
	public function get_support_threads_resolved() {
		return is_numeric( $this->support_threads_resolved ) ? (int) $this->support_threads_resolved : null;
	}

	/**
	 * Get the business model.
	 *
	 * @return string|null business model or null.
	 */
	public function get_business_model() {
		return is_string( $this->business_model ) ? trim( $this->business_model ) : null;
	}

	/**
	 * Get the repository url.
	 *
	 * @return string|null repository url or null.
	 */
	public function get_repository_url() {
		return filter_var( $this->repository_url, FILTER_VALIDATE_URL ) ? $this->repository_url : null;
	}

	/**
	 * Get the commercial support url.
	 *
	 * @return string|null repository url or null.
	 */
	public function get_commercial_support_url() {
		return filter_var( $this->commercial_support_url, FILTER_VALIDATE_URL ) ? $this->commercial_support_url : null;
	}

	/**
	 * Get the donation link.
	 *
	 * @return string|null Donation URL or null.
	 */
	public function get_donate_link() {
		return filter_var( $this->donate_link, FILTER_VALIDATE_URL ) ? $this->donate_link : null;
	}

	/**
	 * Get all icons or a specific size.
	 *
	 * @param string|null $size Optional: 'svg', '2x', '1x'
	 * @return array|string|null All icons or specific.
	 */
	public function get_icons( $size = null ) {
		if ( ! is_array( $this->icons ) ) {
			return null === $size ? [] : null;
		}
		return null === $size ? $this->icons : ( $this->icons[ $size ] ?? null );
	}

	/**
	 * Get the best available icon URL by priority (svg > 2x > 1x).
	 *
	 * @return string|null The best icon URL or null.
	 */
	public function get_best_icon() {
		foreach ( [ 'svg', '2x', '1x' ] as $size ) {
			$icon = $this->get_icons( $size );
			if ( $icon && filter_var( $icon, FILTER_VALIDATE_URL ) ) {
				return $icon;
			}
		}
		return null;
	}
}
