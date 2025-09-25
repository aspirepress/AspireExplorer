<?php

/**
 * @var AspireExplorer\Model\PluginInfo plugin_info.
 */
$plugin_info = $args['plugin_info'] ?? [];

$banner_url = $plugin_info->get_banners( 'high' );
if ( empty( $banner_url ) ) {
	$banner_url = AE_DIR_URL . 'assets/images/default-banner.svg';
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

$fair_data = $plugin_info->get_fair_data();
if ( $plugin_info->is_fair_plugin() ) {
	$plugin_did = esc_attr( $fair_data['id'] );
}
?>
<main class="single-plugin-card">
	<banner class="entry-banner">
		<img class="plugin-banner" src="<?php echo esc_url( $banner_url ); ?>" alt="Plugin Banner">
	</banner>
	<header class="entry-header">
		<div class="entry-title">
			<h2 class="plugin-title"><?php echo esc_html( $plugin_info->get_name() ); ?></h2>
			<p class="plugin-author">by <?php echo esc_html( $plugin_info->get_author( 'display_name' ) ); ?></p>
			<?php
			if ( $plugin_info->is_fair_plugin() ) {
				echo '<p class="plugin-fair">' . esc_html__( 'This plugin is available via FAIR repository.', 'aspireexplorer' ) . '</p>';
			}
			?>
		</div>
		<div class="entry-download">
			<a href="<?php echo esc_url( $plugin_info->get_download_link() ); ?>" class="button button-primary" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-download"></span> Download</a>
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

				$is_first = true;
				foreach ( $sections as $section => $content ) {
					echo '<details class="section-item" id="section-item-' . esc_attr( $section ) . '" ' . esc_attr( ( $is_first ) ? 'open' : '' ) . '>';
					echo '<summary role="button" aria-expanded="' . esc_attr( ( $is_first ) ? 'true' : 'false' ) . '">' . esc_html( ucfirst( $section ) ) . '</summary>';
					echo '<div class="details-content" id="details-content-' . esc_attr( $section ) . '">' . wp_kses_post( $content ) . '</div>';
					echo '</details>';
					if ( $is_first ) {
						$is_first = false;
					}
				}
			}
			?>
		</article>
		<sidebar>
			<ul>
				<?php
				if ( $plugin_info->is_fair_plugin() ) {
					echo '<li class="plugin-meta-item fair-plugin"><strong><span class="screen-reader-text">' . esc_html__( 'Plugin DID:', 'aspireexplorer' ) . '</span>Plugin DID:</strong> <code>' . esc_html( $plugin_did ) . '</code></li>';
				}
				?>
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
					$label = esc_html( ucfirst( str_replace( '_', ' ', $key ) ) );
					echo '<li class="plugin-meta-item"><strong><span class="screen-reader-text">' . sprintf( esc_html__( '%s:', 'aspireexplorer' ), $label ) . '</span>' . $label . ':</strong> ' . esc_html( $value ) . '</li>';
				}
				?>
			</ul>
			<div class="ratings">
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
