<?php

/**
 * @var AspireExplorer\Model\PluginInfo plugin_info.
 */
$plugin_info = $args['plugin_info'] ?? [];

$banner_url = $plugin_info->get_banners( 'high' );
if ( empty( $banner_url ) ) {
	$banner_url = AE_DIR_URL . 'assets/images/default-banner.png';
}

$sections    = $plugin_info->get_sections();
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
	$description = $plugin_info->get_description();
}
?>
<main class="single-plugin-card">
	<banner class="entry-banner">
		<img class="plugin-banner" src="<?php echo esc_url( $banner_url ); ?>" alt="Plugin Banner">
	</banner>
	<header class="entry-header">
		<div class="entry-title">
			<h3 class="plugin-title"><?php echo esc_html( $plugin_info->get_name() ); ?></h3>
			<p class="plugin-author">by <?php echo esc_html( $plugin_info->get_author() ); ?></p>
			<p class="plugin-version">Version: <?php echo esc_html( $plugin_info->get_version() ); ?></p>
		</div>
		<div class="entry-download">
			<a href="<?php echo esc_url( $plugin_info->get_download_link() ); ?>" class="button button-primary" target="_blank" rel="noopener noreferrer">Download</a>
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
						$pos_a = array_search( $a, $priority_order );
						$pos_b = array_search( $b, $priority_order );

						$pos_a = $pos_a === false ? PHP_INT_MAX : $pos_a;
						$pos_b = $pos_b === false ? PHP_INT_MAX : $pos_b;

						return $pos_a - $pos_b;
					}
				);

				foreach ( $sections as $section => $content ) {
					echo '<div class="accordion-item" id="accordion-item-' . esc_attr( $section ) . '">';
						echo '<input type="radio" name="accordions" id="section-' . esc_attr( $section ) . '" ' . checked( $section, array_key_first( $sections ), false ) . '>';
						echo '<label for="section-' . esc_attr( $section ) . '">' . esc_html( ucfirst( $section ) ) . '</label>';
						echo '<div class="accordion-content" id="accordion-content-' . esc_attr( $section ) . '">' . wp_kses_post( $content ) . '</div>';
					echo '</div>';
				}
			}
			?>
		</article>
		<sidebar>
			<ul>
				<?php
				$meta_data = [
					'version'         => $plugin_info->get_version(),
					'business_model'  => $plugin_info->get_business_model(),
					'active_installs' => $plugin_info->get_active_installs(),
					'last_updated'    => $plugin_info->get_last_updated(),
					'requires'        => $plugin_info->get_requires(),
					'tested'          => $plugin_info->get_tested(),
				];
				foreach ( $meta_data as $key => $value ) {
					if ( empty( $value ) ) {
						continue;
					}
					if ( is_array( $value ) ) {
						$value = implode( ', ', $value );
					}
					echo '<li class="plugin-meta-item"><strong>' . esc_html( ucfirst( str_replace( '_', ' ', $key ) ) ) . ':</strong> ' . esc_html( $value ) . '</li>';
				}
				?>
			</ul>
			<div class="plugin-ratings">
				<?php
				$total   = 0;
				$sum     = 0;
				$ratings = $plugin_info->get_ratings();
				foreach ( $ratings as $star => $num ) {
					$total += (int) $num;
					$sum   += (int) $num * (int) $star;
				}
				$average = $total > 0 ? round( $sum / $total, 1 ) : 0;
				?>
				<div class="plugin-rating-summary">
					<strong><?php echo esc_html( $average ); ?> out of 5 stars.</strong>
				</div>
				<ul class="plugin-ratings-list">
					<?php
					for ( $i = 5; $i >= 1; $i-- ) {
						$count = isset( $ratings[ $i ] ) ? (int) $ratings[ $i ] : 0;
						echo '<li class="plugin-rating-row">';
						for ( $j = 1; $j <= 5; $j++ ) {
							echo '<span class="dashicons dashicons-star' . ( $j <= $i ? '-filled' : '-empty' ) . '"></span>';
						}
						echo '<span class="plugin-rating-bar"><span class="plugin-rating-bar-inner" style="width:' . ( $total > 0 ? esc_attr( round( ( $count / $total ) * 100 ) ) : 0 ) . '%"></span></span>';
						echo '<span class="plugin-rating-absolute">' . esc_html( $count ) . ' ratings</span>';
						echo '</li>';
					}
					?>
				</ul>
			</div>
		</sidebar>
	</div>
</main>
