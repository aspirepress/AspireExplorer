<?php
/**
 * AspireExplorer Theme Card (Single View)
 *
 * Displays a single theme's details, sections, meta, and ratings in an accessible, translatable, and visually polished layout.
 *
 * @package AspireExplorer
 */
$theme_info = $args['theme_info'] ?? null;
if ( ! $theme_info ) {
	return;
}

$theme_screenshot = $theme_info->get_screenshot_url();
if ( empty( $theme_screenshot ) ) {
	$theme_screenshot = AE_DIR_URL . 'assets/images/default-banner.svg';
}

$sections    = $theme_info->get_sections();
$description = '';
if ( isset( $sections['description'] ) ) {
	$description = $sections['description'];
} elseif ( isset( $sections['changelog'] ) ) {
	$description = $sections['changelog'];
} elseif ( isset( $sections['installation'] ) ) {
	$description = $sections['installation'];
} elseif ( isset( $sections['faq'] ) ) {
	$description = $sections['faq'];
} else {
	$description = $theme_info->get_description();
}
?>
<main class="single-theme-card">
	<banner class="entry-banner">
		<img class="theme-banner" src="<?php echo esc_url( $theme_screenshot ); ?>" alt="Theme Banner">
	</banner>
	<header class="entry-header">
		<div class="entry-title">
			<h3 class="theme-title"><?php echo esc_html( $theme_info->get_name() ); ?></h3>
			<p class="theme-author">by <?php echo esc_html( $theme_info->get_author( 'display_name' ) ); ?></p>
			<p class="theme-version">Version: <?php echo esc_html( $theme_info->get_version() ); ?></p>
		</div>
		<div class="entry-preview">
			<?php
			$theme_slug  = $theme_info->get_slug();
			$preview_url = '';
			if ( $theme_slug ) {
				$theme_zip_url = $theme_info->get_download_link();
				$blueprint_url = AE_DIR_URL . 'includes/views/playground/blueprint.php?theme=' . $theme_zip_url;
				$cache_buster  = time();
				$preview_url   = 'https://playground.wordpress.net/?blueprint-url=' . rawurlencode( $blueprint_url ) . '&random=' . $cache_buster;
			}
			?>
			<a href="<?php echo esc_url( $preview_url ); ?>" class="button button-primary" target="_blank" rel="noopener noreferrer">
				<span class="dashicons dashicons-visibility"></span> <?php esc_html_e( 'Preview', 'aspireexplorer' ); ?>
			</a>
		</div>
		<div class="entry-download">
			<a href="<?php echo esc_url( $theme_info->get_download_link() ); ?>" class="button button-primary" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-download"></span> <?php esc_html_e( 'Download', 'aspireexplorer' ); ?></a>
		</div>
	</header>
	<div class="entry-main">
		<article>
			<?php
			if ( is_array( $sections ) && count( $sections ) > 0 ) {
				$priority_order = [
					'description',
					'installation',
					'screenshots',
					'faq',
					'support',
					'reviews',
					'changelog',
					'other_notes',
				];
				uksort(
					$sections,
					function ( $a, $b ) use ( $priority_order ) {
						$pos_a = array_search( $a, $priority_order, true );
						$pos_b = array_search( $b, $priority_order, true );
						$pos_a = ( false === $pos_a ) ? PHP_INT_MAX : $pos_a;
						$pos_b = ( false === $pos_b ) ? PHP_INT_MAX : $pos_b;
						return $pos_a - $pos_b;
					}
				);
				foreach ( $sections as $section => $content ) {
					echo '<div class="accordion-item" id="accordion-item-' . esc_attr( $section ) . '">';
					echo '<input type="radio" name="accordions" id="section-' . esc_attr( $section ) . '" ' . checked( $section, array_key_first( $sections ), false ) . '>';
					echo '<label for="section-' . esc_attr( $section ) . '" aria-label="' . esc_attr( sprintf( __( '%s section', 'aspireexplorer' ), ucfirst( $section ) ) ) . '">' . esc_html( ucfirst( $section ) ) . '</label>';
					echo '<div class="accordion-content" id="accordion-content-' . esc_attr( $section ) . '" aria-labelledby="section-' . esc_attr( $section ) . '">' . wp_kses_post( $content ) . '</div>';
					echo '</div>';
				}
			}
			?>
		</article>
		<sidebar>
			<ul>
				<?php
				$meta_data = [
					'Version'         => $theme_info->get_version(),
					'Active Installs' => $theme_info->get_active_installs(),
					'Last Updated'    => $theme_info->get_last_updated(),
					'Requires WP'     => $theme_info->get_requires(),
					'Tested'          => $theme_info->get_tested(),
					'Requires PHP'    => $theme_info->get_requires_php(),
				];
				foreach ( $meta_data as $key => $value ) {
					if ( empty( $value ) ) {
						continue;
					}
					if ( is_array( $value ) ) {
						$value = implode( ', ', $value );
					}
					$label = esc_html( $key );
					echo '<li class="theme-meta-item"><strong><span class="screen-reader-text">' . sprintf( esc_html__( '%s:', 'aspireexplorer' ), $label ) . '</span>' . $label . ':</strong> ' . esc_html( $value ) . '</li>';
				}
				?>
			</ul>
			<div class="ratings">
				<?php
				$total   = 0;
				$sum     = 0;
				$ratings = $theme_info->get_ratings();
				foreach ( $ratings as $star => $num ) {
					$total += (int) $num;
					$sum   += (int) $num * (int) $star;
				}
				$average = $total > 0 ? round( $sum / $total, 1 ) : 0;
				?>
				<div class="rating-summary">
					<strong><span class="screen-reader-text"><?php echo esc_html__( 'Average rating:', 'aspireexplorer' ); ?></span><?php echo esc_html( $average ); ?> <?php echo esc_html__( 'out of 5 stars.', 'aspireexplorer' ); ?></strong>
				</div>
				<ul class="ratings-list">
					<?php
					for ( $i = 5; $i >= 1; $i-- ) {
						$count = isset( $ratings[ $i ] ) ? (int) $ratings[ $i ] : 0;
						echo '<li class="rating-row">';
						for ( $j = 1; $j <= 5; $j++ ) {
							echo '<span class="dashicons dashicons-star' . ( $j <= $i ? '-filled' : '-empty' ) . '" aria-hidden="true"></span>';
						}
						echo '<span class="rating-bar"><span class="rating-bar-inner" style="width:' . ( $total > 0 ? esc_attr( round( ( $count / $total ) * 100 ) ) : 0 ) . '%"></span></span>';
						echo '<span class="rating-absolute"><span class="screen-reader-text">' . esc_html__( 'Number of ratings:', 'aspireexplorer' ) . ' </span>' . esc_html( $count ) . ' ' . esc_html__( 'ratings', 'aspireexplorer' ) . '</span>';
						echo '</li>';
					}
					?>
				</ul>
			</div>
		</sidebar>
	</div>
</main>
