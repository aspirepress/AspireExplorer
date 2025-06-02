<?php
namespace AspireExplorer\Model;

/**
 * Class PluginInfo
 *
 * Represents detailed metadata of a WordPress plugin retrieved via the Plugin API.
 * Provides explicit getters and setters for safe and structured access.
 * Also Provides typed access to plugin fields with validation.
 */
class PluginInfo {

	/**
	 * The plugin's display name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Unique identifier (slug) used on WordPress.org.
	 *
	 * @var string
	 */
	private $slug;

	/**
	 * Current version number of the plugin.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Author's name or HTML-formatted string.
	 *
	 * @var string
	 */
	private $author;

	/**
	 * Author's WordPress.org profile URL.
	 *
	 * @var string
	 */
	private $author_profile;

	/**
	 * Minimum WordPress version required for the plugin.
	 *
	 * @var string
	 */
	private $requires;

	/**
	 * Maximum WordPress version the plugin has been tested with.
	 *
	 * @var string
	 */
	private $tested;

	/**
	 * Minimum PHP version required for the plugin.
	 *
	 * @var string
	 */
	private $requires_php;

	/**
	 * Array of required plugin slugs (if applicable).
	 *
	 * @var array
	 */
	private $requires_plugins;

	/**
	 * Overall plugin rating in percentage (0–100).
	 *
	 * @var int
	 */
	private $rating;

	/**
	 * Distribution of ratings by stars (1–5 => count).
	 *
	 * @var array
	 */
	private $ratings;

	/**
	 * Total number of ratings submitted by users.
	 *
	 * @var int
	 */
	private $num_ratings;

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
	 * Estimated number of active plugin installations.
	 *
	 * @var int
	 */
	private $active_installs;

	/**
	 * Total number of downloads from WordPress.org.
	 *
	 * @var int
	 */
	private $downloaded;

	/**
	 * Datetime of the plugin's last update (ISO 8601).
	 *
	 * @var string
	 */
	private $last_updated;

	/**
	 * Date the plugin was added to WordPress.org (YYYY-MM-DD).
	 *
	 * @var string
	 */
	private $added;

	/**
	 * Plugin homepage URL.
	 *
	 * @var string
	 */
	private $homepage;

	/**
	 * Short description shown in search and listing results.
	 *
	 * @var string
	 */
	private $short_description;

	/**
	 * Full plugin description (may include HTML).
	 *
	 * @var string
	 */
	private $description;

	/**
	 * Direct download URL for the plugin ZIP file.
	 *
	 * @var string
	 */
	private $download_link;

	/**
	 * Associative array of sections (slug => content).
	 *
	 * @var array
	 */
	private $sections;

	/**
	 * Associative array of tags (slug => label).
	 *
	 * @var array
	 */
	private $tags;

	/**
	 * Associative array of versions (version => url).
	 *
	 * @var array
	 */
	private $versions;

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
	 * Banners image URLs (keys may include 'low', 'high').
	 *
	 * @var array
	 */
	private $banners;

	/**
	 * Icon URLs (keys may include '1x', '2x', 'svg').
	 *
	 * @var array
	 */
	private $icons;

	/**
	 * PluginInfo constructor.
	 *
	 * @param array $data Optional array of plugin fields to auto-populate.
	 */
	public function __construct( $data = [] ) {
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * Magic getter for properties.
	 *
	 * @param string $name Property name.
	 * @return mixed|null
	 */
	public function __get( $name ) {
		if ( property_exists( $this, $name ) ) {
			return $this->$name;
		}
		return null;
	}

	/**
	 * Magic setter for properties.
	 *
	 * @param string $name Property name.
	 * @param mixed $value Value to set.
	 */
	public function __set( $name, $value ) {
		if ( property_exists( $this, $name ) ) {
			$this->$name = $value;
		}
	}

	/**
	 * Check if a property is set.
	 *
	 * @param string $name Property name.
	 * @return bool
	 */
	public function __isset( $name ) {
		return property_exists( $this, $name ) && isset( $this->$name );
	}

	/**
	 * Unset a property (resets to null).
	 *
	 * @param string $name Property name.
	 */
	public function __unset( $name ) {
		if ( property_exists( $this, $name ) ) {
			$this->$name = null;
		}
	}

	// ------------------ GETTERS ------------------

	/**
	 * Get the plugin name.
	 *
	 * @return string|null Plugin display name or null if invalid.
	 */
	public function get_name() {
		return is_string( $this->name ) && trim( $this->name ) !== '' ? trim( $this->name ) : null;
	}

	/**
	 * Get the plugin slug.
	 *
	 * @return string|null Plugin slug or null if invalid.
	 */
	public function get_slug() {
		return is_string( $this->slug ) && trim( $this->slug ) !== '' ? trim( $this->slug ) : null;
	}

	/**
	 * Get the plugin version.
	 *
	 * @return string|null Plugin version or null.
	 */
	public function get_version() {
		return is_string( $this->version ) ? trim( $this->version ) : null;
	}

	/**
	 * Get the author's plain name without any HTML or markup.
	 *
	 * @return string|null Cleaned author name or null.
	 */
	public function get_author() {
		if ( is_string( $this->author ) ) {
			$clean = wp_strip_all_tags( $this->author );
			return trim( $clean ) !== '' ? $clean : null;
		}
		return null;
	}

	/**
	 * Get the author's WordPress.org profile URL.
	 *
	 * @return string|null Author profile URL or null.
	 */
	public function get_author_profile() {
		return filter_var( $this->author_profile, FILTER_VALIDATE_URL ) ? $this->author_profile : null;
	}

	/**
	 * Get the minimum WordPress version required.
	 *
	 * @return string|null Required WP version or null.
	 */
	public function get_requires() {
		return is_string( $this->requires ) ? trim( $this->requires ) : null;
	}

	/**
	 * Get the maximum tested WordPress version.
	 *
	 * @return string|null Tested version or null.
	 */
	public function get_tested() {
		return is_string( $this->tested ) ? trim( $this->tested ) : null;
	}

	/**
	 * Get the minimum PHP version required.
	 *
	 * @return string|null Required PHP version or null.
	 */
	public function get_requires_php() {
		return is_string( $this->requires_php ) ? trim( $this->requires_php ) : null;
	}

	/**
	 * Get the array of required plugin slugs.
	 *
	 * @return array List of plugin slugs or empty array.
	 */
	public function get_requires_plugins() {
		return is_array( $this->requires_plugins ) ? $this->requires_plugins : [];
	}

	/**
	 * Get the plugin rating percentage.
	 *
	 * @return int|null Rating from 0 to 100.
	 */
	public function get_rating() {
		return is_numeric( $this->rating ) ? (int) $this->rating : null;
	}

	/**
	 * Get all ratings or a specific star level.
	 *
	 * @param int|null $stars Optional: 1–5 star level.
	 * @return array|int|null All ratings or one count.
	 */
	public function get_ratings( $stars = null ) {
		if ( ! is_array( $this->ratings ) ) {
			return null === $stars ? [] : null;
		}
		return null === $stars ? $this->ratings : ( $this->ratings[ $stars ] ?? null );
	}

	/**
	 * Get total number of user ratings.
	 *
	 * @return int|null Total ratings count.
	 */
	public function get_num_ratings() {
		return is_numeric( $this->num_ratings ) ? (int) $this->num_ratings : null;
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
	 * Get estimated active installations.
	 *
	 * @param bool $humanize Optional. If true, returns value in K/M/B format. Default false.
	 * @return int|string|null Active install count or formatted string.
	 */
	public function get_active_installs( $humanize = true ) {
		if ( ! is_numeric( $this->active_installs ) ) {
			return null;
		}
		$count = (int) $this->active_installs;
		if ( ! $humanize ) {
			return $count;
		}
		if ( 1000000000 <= $count ) {
			return round( $count / 1000000000, 1 ) . 'B';
		} elseif ( 1000000 <= $count ) {
			return round( $count / 1000000, 1 ) . 'M';
		} elseif ( 1000 <= $count ) {
			return round( $count / 1000 ) . 'K';
		} elseif ( 100 <= $count ) {
			return round( $count / 100 ) * 100;
		}
		return $count;
	}

	/**
	 * Get total plugin downloads.
	 *
	 * @return int|null Download count.
	 */
	public function get_downloaded() {
		return is_numeric( $this->downloaded ) ? (int) $this->downloaded : null;
	}

	/**
	 * Get the last update timestamp.
	 *
	 * @param string|null $format Optional. Format string or null for human readable.
	 * @return string|null Formatted date or null.
	 */
	public function get_last_updated( $format = null ) {
		if ( ! is_string( $this->last_updated ) || '' === trim( $this->last_updated ) ) {
			return null;
		}
		return $this->format_date_value( $this->last_updated, $format );
	}

	/**
	 * Get the date the plugin was added.
	 *
	 * @param string|null $format Optional. Format string or null for human readable.
	 * @return string|null Formatted date or null.
	 */
	public function get_added( $format = null ) {
		if ( ! is_string( $this->added ) || '' === trim( $this->added ) ) {
			return null;
		}
		return $this->format_date_value( $this->added, $format );
	}

	/**
	 * Get the plugin homepage URL.
	 *
	 * @return string|null Homepage URL or null.
	 */
	public function get_homepage() {
		return filter_var( $this->homepage, FILTER_VALIDATE_URL ) ? $this->homepage : null;
	}

	/**
	 * Get the plugin short description.
	 *
	 * @return string|null Short description or null.
	 */
	public function get_short_description() {
		return ! empty( $this->short_description ) ? trim( $this->short_description ) : null;
	}

	/**
	 * Get the full plugin description.
	 *
	 * @return string|null Full description or null.
	 */
	public function get_description() {
		return ! empty( $this->description ) ? trim( $this->description ) : null;
	}

	/**
	 * Get the direct download link.
	 *
	 * @return string|null URL to plugin ZIP or null.
	 */
	public function get_download_link() {
		return filter_var( $this->download_link, FILTER_VALIDATE_URL ) ? $this->download_link : null;
	}

	/**
	 * Get all plugin sections or a specific one.
	 *
	 * @param string|null $key Optional tag key.
	 * @return array|string|null sections list or one label.
	 */
	public function get_sections( $key = null ) {
		if ( ! is_array( $this->sections ) ) {
			return null === $key ? [] : null;
		}
		return null === $key ? $this->sections : ( $this->sections[ $key ] ?? null );
	}

	/**
	 * Get all plugin tags or a specific one.
	 *
	 * @param string|null $key Optional tag key.
	 * @return array|string|null Tag list or one label.
	 */
	public function get_tags( $key = null ) {
		if ( ! is_array( $this->tags ) ) {
			return null === $key ? [] : null;
		}
		return null === $key ? $this->tags : ( $this->tags[ $key ] ?? null );
	}

	/**
	 * Get all plugin versions or a specific one.
	 *
	 * @param string|null $key Optional version key.
	 * @return array|string|null Version list or one Version URL.
	 */
	public function get_versions( $key = null ) {
		if ( ! is_array( $this->versions ) ) {
			return null === $key ? [] : null;
		}
		return null === $key ? $this->versions : ( $this->versions[ $key ] ?? null );
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
		return filter_var( $this->repository_url, FILTER_VALIDATE_URL ) ?? null;
	}

	/**
	 * Get the commercial support url.
	 *
	 * @return string|null repository url or null.
	 */
	public function commercial_support_url() {
		return filter_var( $this->commercial_support_url, FILTER_VALIDATE_URL ) ?? null;
	}

	/**
	 * Get the donation link.
	 *
	 * @return string|null Donation URL or null.
	 */
	public function get_donate_link() {
		return filter_var( $this->donate_link, FILTER_VALIDATE_URL ) ?? null;
	}

	/**
	 * Get the preview link.
	 *
	 * @return string|null preview link or null.
	 */
	public function get_preview_link() {
		return filter_var( $this->preview_link, FILTER_VALIDATE_URL ) ?? null;
	}

	/**
	 * Get all banners or a specific size.
	 *
	 * @param string|null $size Optional: 'svg', '2x', '1x'
	 * @return array|string|null All banners or specific.
	 */
	public function get_banners( $size = null ) {
		if ( ! is_array( $this->banners ) ) {
			return null === $size ? [] : null;
		}
		return null === $size ? $this->banners : ( $this->banners[ $size ] ?? null );
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


	// ------------------ SETTERS ------------------

	/**
		 * Set the plugin name.
		 *
		 * @param string $val Plugin name.
		 */
	public function set_name( $val ) {
		if ( is_string( $val ) ) {
			$this->name = trim( $val );
		}
	}

	/**
	 * Set the plugin slug.
	 *
	 * @param string $val Slug.
	 */
	public function set_slug( $val ) {
		if ( is_string( $val ) ) {
			$this->slug = trim( $val );
		}
	}

	/**
	 * Set the plugin version.
	 *
	 * @param string $val Version.
	 */
	public function set_version( $val ) {
		if ( is_string( $val ) ) {
			$this->version = trim( $val );
		}
	}

	/**
	 * Set the plugin author string.
	 *
	 * @param string $val Author name or HTML.
	 */
	public function set_author( $val ) {
		if ( is_string( $val ) ) {
			$this->author = trim( $val );
		}
	}

	/**
	 * Set the author's profile URL.
	 *
	 * @param string $val URL to author profile.
	 */
	public function set_author_profile( $val ) {
		if ( filter_var( $val, FILTER_VALIDATE_URL ) ) {
			$this->author_profile = $val;
		}
	}

	/**
	 * Set the minimum WordPress version required.
	 *
	 * @param string $val WordPress version.
	 */
	public function set_requires( $val ) {
		if ( is_string( $val ) ) {
			$this->requires = trim( $val );
		}
	}

	/**
	 * Set the maximum WordPress version tested.
	 *
	 * @param string $val Tested version.
	 */
	public function set_tested( $val ) {
		if ( is_string( $val ) ) {
			$this->tested = trim( $val );
		}
	}

	/**
	 * Set the required PHP version.
	 *
	 * @param string $val PHP version.
	 */
	public function set_requires_php( $val ) {
		if ( is_string( $val ) ) {
			$this->requires_php = trim( $val );
		}
	}

	/**
	 * Set the array of required plugin slugs.
	 *
	 * @param array $val Required plugins.
	 */
	public function set_requires_plugins( $val ) {
		if ( is_array( $val ) ) {
			$this->requires_plugins = $val;
		}
	}

	/**
	 * Set the overall plugin rating percentage.
	 *
	 * @param int $val Rating (0–100).
	 */
	public function set_rating( $val ) {
		if ( is_numeric( $val ) ) {
			$this->rating = (int) $val;
		}
	}

	/**
	 * Set the distribution of ratings.
	 *
	 * @param array $val Array of 1–5 star ratings.
	 */
	public function set_ratings( $val ) {
		if ( is_array( $val ) ) {
			$this->ratings = $val;
		}
	}

	/**
	 * Set the number of ratings received.
	 *
	 * @param int $val Total ratings.
	 */
	public function set_num_ratings( $val ) {
		if ( is_numeric( $val ) ) {
			$this->num_ratings = (int) $val;
		}
	}

	/**
	 * Set the number of unresolved support threads.
	 *
	 * @param int $val Open threads.
	 */
	public function set_support_threads( $val ) {
		if ( is_numeric( $val ) ) {
			$this->support_threads = (int) $val;
		}
	}

	/**
	 * Set the number of resolved support threads.
	 *
	 * @param int $val Resolved threads.
	 */
	public function set_support_threads_resolved( $val ) {
		if ( is_numeric( $val ) ) {
			$this->support_threads_resolved = (int) $val;
		}
	}

	/**
	 * Set the number of active installations.
	 *
	 * @param int $val Active installs.
	 */
	public function set_active_installs( $val ) {
		if ( is_numeric( $val ) ) {
			$this->active_installs = (int) $val;
		}
	}

	/**
	 * Set the number of downloads.
	 *
	 * @param int $val Download count.
	 */
	public function set_downloaded( $val ) {
		if ( is_numeric( $val ) ) {
			$this->downloaded = (int) $val;
		}
	}

	/**
	 * Set the last updated date.
	 *
	 * @param string $val ISO datetime string.
	 */
	public function set_last_updated( $val ) {
		if ( is_string( $val ) ) {
			$this->last_updated = trim( $val );
		}
	}

	/**
	 * Set the date the plugin was added.
	 *
	 * @param string $val ISO date string.
	 */
	public function set_added( $val ) {
		if ( is_string( $val ) ) {
			$this->added = trim( $val );
		}
	}

	/**
	 * Set the plugin homepage URL.
	 *
	 * @param string $val Homepage URL.
	 */
	public function set_homepage( $val ) {
		if ( filter_var( $val, FILTER_VALIDATE_URL ) ) {
			$this->homepage = $val;
		}
	}

	/**
	 * Set the plugin's short description.
	 *
	 * @param string $val Summary.
	 */
	public function set_short_description( $val ) {
		if ( is_string( $val ) ) {
			$this->short_description = trim( $val );
		}
	}

	/**
	 * Set the plugin's full description.
	 *
	 * @param string $val Full description.
	 */
	public function set_description( $val ) {
		if ( is_string( $val ) ) {
			$this->description = trim( $val );
		}
	}

	/**
	 * Set the plugin's download link.
	 *
	 * @param string $val Download URL.
	 */
	public function set_download_link( $val ) {
		if ( filter_var( $val, FILTER_VALIDATE_URL ) ) {
			$this->download_link = $val;
		}
	}

	/**
	 * Set the plugin's tag array.
	 *
	 * @param array $val Tags as key => label.
	 */
	public function set_tags( $val ) {
		if ( is_array( $val ) ) {
			$this->tags = $val;
		}
	}

	/**
	 * Set the plugin's donation link.
	 *
	 * @param string $val Donate URL.
	 */
	public function set_donate_link( $val ) {
		if ( filter_var( $val, FILTER_VALIDATE_URL ) ) {
			$this->donate_link = $val;
		}
	}

	/**
	 * Set the plugin icon array.
	 *
	 * @param array $val Icons (1x, 2x, svg).
	 */
	public function set_icons( $val ) {
		if ( is_array( $val ) ) {
			$this->icons = $val;
		}
	}

	/*Helper Functions*/

	/**
	 * Format a date value as human readable or with a custom format.
	 *
	 * @param string      $date_str Date string.
	 * @param string|null $format   Format string or null for human readable.
	 * @return string|null
	 */
	private function format_date_value( $date_str, $format = null ) {
		$date = strtotime( $date_str );
		if ( ! $date ) {
			return null;
		}
		if ( ! empty( $format ) ) {
			return gmdate( $format, $date );
		}
		$now  = time();
		$diff = $now - $date;
		if ( 0 > $diff ) {
			return gmdate( 'd-m-Y', $date );
		}
		$days = floor( $diff / 86400 );
		if ( 1 > $days ) {
			return 'Today';
		} elseif ( 1 === $days ) {
			return 'Yesterday';
		} elseif ( 7 > $days ) {
			return $days . ' days ago';
		} elseif ( 30 > $days ) {
			$weeks = floor( $days / 7 );
			return $weeks . ' week' . ( 1 < $weeks ? 's' : '' ) . ' ago';
		} elseif ( 365 > $days ) {
			$months = floor( $days / 30 );
			return $months . ' month' . ( 1 < $months ? 's' : '' ) . ' ago';
		} else {
			return gmdate( 'd-m-Y', $date );
		}
	}
}
