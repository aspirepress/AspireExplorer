<?php
namespace AspireExplorer\Model;

/**
 * Class ThemeInfo
 *
 * Represents detailed metadata of a WordPress theme retrieved via the Themes API.
 * Provides explicit getters and setters for safe and structured access.
 * Also provides typed access to theme fields with validation.
 */
class ThemeInfo extends AssetInfo {
	/**
	 * Screenshot image URL.
	 *
	 * @var string
	 */
	private $screenshot_url;

	/**
	 * Theme preview URL.
	 *
	 * @var string
	 */
	private $preview_url;

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

	public function __construct( $data = [] ) {
		parent::__construct( $data );
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * Get the screenshot image URL.
	 *
	 * @return string|null Screenshot URL or null.
	 */
	public function get_screenshot_url() {
		return filter_var( $this->screenshot_url, FILTER_VALIDATE_URL ) ? $this->screenshot_url : null;
	}

	/**
	 * Get the theme preview URL.
	 *
	 * @return string|null Preview URL or null.
	 */
	public function get_preview_url() {
		return filter_var( $this->preview_url, FILTER_VALIDATE_URL ) ? $this->preview_url : null;
	}

	/**
	 * Get the repository url.
	 *
	 * @return string|null Repository URL or null.
	 */
	public function get_repository_url() {
		return filter_var( $this->repository_url, FILTER_VALIDATE_URL ) ? $this->repository_url : null;
	}

	/**
	 * Get the commercial support url.
	 *
	 * @return string|null Commercial support URL or null.
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
}
