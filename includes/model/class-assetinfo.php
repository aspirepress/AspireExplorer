<?php
namespace AspireExplorer\Model;

/**
 * Class AssetInfo
 *
 * Base class for shared asset (plugin/theme) properties and methods.
 */
class AssetInfo {
	/**
	 * The asset's display name.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Unique identifier (slug) used on WordPress.org.
	 *
	 * @var string
	 */
	protected $slug;

	/**
	 * Current version number.
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Author's name or HTML-formatted string.
	 *
	 * @var string
	 */
	protected $author;

	/**
	 * Author's WordPress.org profile URL.
	 *
	 * @var string
	 */
	protected $author_profile;

	/**
	 * Minimum WordPress version required.
	 *
	 * @var string
	 */
	protected $requires;

	/**
	 * Maximum WordPress version tested with.
	 *
	 * @var string
	 */
	protected $tested;

	/**
	 * Minimum PHP version required.
	 *
	 * @var string
	 */
	protected $requires_php;

	/**
	 * Overall rating in percentage (0–100).
	 *
	 * @var int
	 */
	protected $rating;

	/**
	 * Distribution of ratings by stars (1–5 => count).
	 *
	 * @var array
	 */
	protected $ratings;

	/**
	 * Total number of ratings submitted by users.
	 *
	 * @var int
	 */
	protected $num_ratings;

	/**
	 * Estimated number of active installations.
	 *
	 * @var int
	 */
	protected $active_installs;

	/**
	 * Datetime of the last update (ISO 8601).
	 *
	 * @var string
	 */
	protected $last_updated;

	/**
	 * Date the asset was added to WordPress.org (YYYY-MM-DD).
	 *
	 * @var string
	 */
	protected $added;

	/**
	 * Homepage URL.
	 *
	 * @var string
	 */
	protected $homepage;

	/**
	 * Short description shown in search and listing results.
	 *
	 * @var string
	 */
	protected $short_description;

	/**
	 * Full description (may include HTML).
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Direct download URL for the ZIP file.
	 *
	 * @var string
	 */
	protected $download_link;

	/**
	 * Associative array of sections (slug => content).
	 *
	 * @var array
	 */
	protected $sections;

	/**
	 * Associative array of tags (slug => label).
	 *
	 * @var array
	 */
	protected $tags;

	/**
	 * Associative array of versions (version => url).
	 *
	 * @var array
	 */
	protected $versions;

	/**
	 * Banners image URLs (keys may include 'low', 'high').
	 *
	 * @var array
	 */
	protected $banners;

	/**
	 * Asset origin (source or API origin).
	 *
	 * @var string|null
	 */
	protected $ac_origin;

	/**
	 * Asset creation date (ISO 8601 or Y-m-d format).
	 *
	 * @var string|null
	 */
	protected $ac_created;

	/**
	 * AssetInfo constructor.
	 *
	 * @param array $data Optional array of asset fields to auto-populate.
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
			$reflection = new \ReflectionProperty( $this, $name );
			if ( $reflection->isPublic() || $reflection->isProtected() ) {
				return $this->$name;
			}
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
			$reflection = new \ReflectionProperty( $this, $name );
			if ( $reflection->isPublic() || $reflection->isProtected() ) {
				$this->$name = $value;
			}
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
	 * Get the asset name.
	 *
	 * @return string|null Asset display name or null if invalid.
	 */
	public function get_name() {
		return is_string( $this->name ) && trim( $this->name ) !== '' ? trim( $this->name ) : null;
	}

	/**
	 * Get the asset slug.
	 *
	 * @return string|null Asset slug or null if invalid.
	 */
	public function get_slug() {
		return is_string( $this->slug ) && trim( $this->slug ) !== '' ? trim( $this->slug ) : null;
	}

	/**
	 * Get the asset version.
	 *
	 * @return string|null Asset version or null.
	 */
	public function get_version() {
		return is_string( $this->version ) ? trim( $this->version ) : null;
	}

	/**
	 * Get the author's plain name without any HTML or markup.
	 *
	 * @param string $parameter Specific parameter to retrieve from author array (e.g., 'display_name').
	 *                          If null, returns the plain text author name.
	 * @return string|array|null Cleaned author array, author name or null.
	 */
	public function get_author( $parameter = null ) {
		if ( null !== $parameter && ! is_string( $parameter ) ) {
			return null;
		}

		if ( is_array( $this->author ) ) {
			if ( null === $parameter ) {
				$cleaned_author = [];
				foreach ( $this->author as $key => $value ) {
					if ( is_string( $value ) && '' !== trim( $value ) ) {
						$cleaned_author[ $key ] = trim( wp_strip_all_tags( $value ) );
					}
				}
				return ! empty( $cleaned_author ) ? $cleaned_author : null;
			}

			if ( null !== $parameter && isset( $this->author[ $parameter ] ) ) {
				$clean = wp_strip_all_tags( $this->author[ $parameter ] );
				return trim( $clean ) !== '' ? $clean : null;
			}
		}

		if ( is_string( $this->author ) && '' !== trim( $this->author ) ) {
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
	 * Get the asset rating percentage.
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
	 * Get estimated active installations.
	 *
	 * @param bool $humanize Optional. If true, returns value in K/M/B format. Default true.
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
	 * Get the last update timestamp.
	 *
	 * @param string|null $format Optional. Format string or null for human readable.
	 * @return string|null Formatted date or null.
	 */
	public function get_last_updated( $format = null ) {
		if ( ! is_string( $this->last_updated ) || '' === trim( $this->last_updated ) ) {
			return null;
		}
		return Helper::format_date_value( $this->last_updated, $format );
	}

	/**
	 * Get the date the asset was added.
	 *
	 * @param string|null $format Optional. Format string or null for human readable.
	 * @return string|null Formatted date or null.
	 */
	public function get_added( $format = null ) {
		if ( ! is_string( $this->added ) || '' === trim( $this->added ) ) {
			return null;
		}
		return Helper::format_date_value( $this->added, $format );
	}

	/**
	 * Get the asset homepage URL.
	 *
	 * @return string|null Homepage URL or null.
	 */
	public function get_homepage() {
		return filter_var( $this->homepage, FILTER_VALIDATE_URL ) ? $this->homepage : null;
	}

	/**
	 * Get the asset short description.
	 *
	 * @return string|null Short description or null.
	 */
	public function get_short_description() {
		return ! empty( $this->short_description ) ? trim( $this->short_description ) : null;
	}

	/**
	 * Get the full asset description.
	 *
	 * @return string|null Full description or null.
	 */
	public function get_description() {
		return ! empty( $this->description ) ? trim( $this->description ) : null;
	}

	/**
	 * Get the direct download link.
	 *
	 * @return string|null URL to asset ZIP or null.
	 */
	public function get_download_link() {
		return filter_var( $this->download_link, FILTER_VALIDATE_URL ) ? $this->download_link : null;
	}

	/**
	 * Get all asset sections or a specific one.
	 *
	 * @param string|null $key Optional tag key.
	 * @return array|string|null Sections list or one label.
	 */
	public function get_sections( $key = null ) {
		if ( ! is_array( $this->sections ) ) {
			return null === $key ? [] : null;
		}
		return null === $key ? $this->sections : ( $this->sections[ $key ] ?? null );
	}

	/**
	 * Get all asset tags or a specific one.
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
	 * Get all asset versions or a specific one.
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
	 * Get the asset origin (source or API origin).
	 *
	 * @return string|null Asset origin or null.
	 */
	public function get_ac_origin() {
		return is_string( $this->ac_origin ) && trim( $this->ac_origin ) !== '' ? trim( $this->ac_origin ) : null;
	}

	/**
	 * Get the asset creation date.
	 *
	 * @param string|null $format Optional. Format string or null for raw value.
	 * @return string|null Formatted date or null.
	 */
	public function get_ac_created( $format = null ) {
		if ( ! is_string( $this->ac_created ) || '' === trim( $this->ac_created ) ) {
			return null;
		}
		if ( empty( $format ) ) {
			return $this->ac_created;
		}
		$date = strtotime( $this->ac_created );
		if ( ! $date ) {
			return $this->ac_created;
		}
		return gmdate( $format, $date );
	}
}
