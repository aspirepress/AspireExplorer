<?php
namespace AspireExplorer\Model;

/**
 * Class Helper
 *
 * Static shared helper functions.
 */
class Helper {

	/**
	 * Format a date value as human readable or with a custom format.
	 *
	 * @param string      $date_str Date string.
	 * @param string|null $format   Format string or null for human readable.
	 * @return string|null
	 */
	public static function format_date_value( $date_str, $format = null ) {
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
