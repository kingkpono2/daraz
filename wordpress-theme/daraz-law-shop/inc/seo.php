<?php
/**
 * Lightweight, standards-based SEO fallback for a real WooCommerce store.
 *
 * WordPress owns titles, canonical links on singular pages, robots and XML
 * sitemaps. WooCommerce owns Product and commerce structured data. If a
 * dedicated SEO plugin is active, this theme does not duplicate its meta tags
 * or schema. Everything here reflects visible, database-backed content.
 *
 * @package Daraz_Law_Shop
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Popular SEO plugins take precedence; the theme only provides fallbacks. */
function daraz_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' )
		|| defined( 'RANK_MATH_VERSION' )
		|| defined( 'AIOSEO_VERSION' )
		|| defined( 'SEOPRESS_VERSION' )
		|| defined( 'THE_SEO_FRAMEWORK_VERSION' )
		|| defined( 'SLIM_SEO_VERSION' )
		|| class_exists( 'AIOSEO\Plugin\AIOSEO' );
}

/** Let editors customize search and social preview text without code edits. */
function daraz_seo_customizer( $customizer ) {
	$customizer->add_section( 'daraz_search_appearance', array(
		'title'       => __( 'Daraz Search Appearance', 'daraz-law-shop' ),
		'priority'    => 37,
		'description' => __( 'Used only when a dedicated SEO plugin is not managing the site. Titles and descriptions should match the real products and page content.', 'daraz-law-shop' ),
	) );
	$customizer->add_setting( 'daraz_seo_home_title', array(
		'default'           => 'Barrister Gowns, Wigs, Legalwear & Law Books | Daraz Law Shop',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$customizer->add_control( 'daraz_seo_home_title', array(
		'label'   => __( 'Homepage search title', 'daraz-law-shop' ),
		'section' => 'daraz_search_appearance',
		'type'    => 'text',
	) );
	$customizer->add_setting( 'daraz_seo_home_description', array(
		'default'           => 'Shop barrister gowns, wigs, court bands, law books and legal accessories at Daraz Law Shop Nigeria. Explore available products and get expert sizing help.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$customizer->add_control( 'daraz_seo_home_description', array(
		'label'       => __( 'Homepage meta description', 'daraz-law-shop' ),
		'section'     => 'daraz_search_appearance',
		'type'        => 'textarea',
		'description' => __( 'Write a natural, accurate summary of about 140–160 characters; avoid keyword stuffing.', 'daraz-law-shop' ),
	) );
	$customizer->add_setting( 'daraz_seo_social_image', array( 'sanitize_callback' => 'esc_url_raw' ) );
	$customizer->add_control( new WP_Customize_Image_Control( $customizer, 'daraz_seo_social_image', array(
		'label'       => __( 'Default social sharing image', 'daraz-law-shop' ),
		'section'     => 'daraz_search_appearance',
		'description' => __( 'Use an approved, well-cropped image around 1200 × 630 pixels.', 'daraz-law-shop' ),
	) ) );
}
add_action( 'customize_register', 'daraz_seo_customizer' );

/** Generate concise metadata from an actual product, term, excerpt or page. */
function daraz_seo_summary( $value, $limit = 160 ) {
	$text = wp_strip_all_tags( strip_shortcodes( (string) $value ), true );
	$text = preg_replace( '/\s+/u', ' ', html_entity_decode( $text, ENT_QUOTES, get_bloginfo( 'charset' ) ) );
	return trim( wp_html_excerpt( trim( (string) $text ), $limit, '…' ) );
}

function daraz_seo_description() {
	if ( is_front_page() ) {
		return daraz_seo_summary( get_theme_mod( 'daraz_seo_home_description', 'Shop barrister gowns, wigs, court bands, law books and legal accessories at Daraz Law Shop Nigeria. Explore available products and get expert sizing help.' ) );
	}
	if ( is_singular( 'product' ) && function_exists( 'wc_get_product' ) ) {
		$product = wc_get_product( get_queried_object_id() );
		if ( $product ) {
			$description = $product->get_short_description() ?: $product->get_description();
			if ( $description ) {
				return daraz_seo_summary( $description );
			}
			return daraz_seo_summary(
				sprintf( /* translators: 1: product name 2: store name */
					__( 'Explore %1$s at %2$s. Check product details, sizing options, availability and pricing.', 'daraz-law-shop' ),
					$product->get_name(),
					get_bloginfo( 'name' )
				)
			);
		}
	}
	if ( is_singular() ) {
		$id = get_queried_object_id();
		$excerpt = get_post_field( 'post_excerpt', $id );
		$content = $excerpt ?: get_post_field( 'post_content', $id );
		if ( $content ) {
			return daraz_seo_summary( $content );
		}
		return daraz_seo_summary(
			sprintf( /* translators: 1: page name 2: store name */
				__( '%1$s — information and professional legalwear from %2$s.', 'daraz-law-shop' ),
				get_the_title( $id ),
				get_bloginfo( 'name' )
			)
		);
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$description = term_description( $term->term_id, $term->taxonomy );
			if ( $description ) {
				return daraz_seo_summary( $description );
			}
			return daraz_seo_summary(
				sprintf( /* translators: 1: category name 2: store name */
					__( 'Browse %1$s at %2$s. Discover available styles, product information and options.', 'daraz-law-shop' ),
					$term->name,
					get_bloginfo( 'name' )
				)
			);
		}
	}
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		return daraz_seo_summary( __( 'Shop barrister gowns, wigs, court bands and professional legalwear at Daraz Law Shop. Browse the collection and find the right fit.', 'daraz-law-shop' ) );
	}
	if ( is_home() ) {
		return daraz_seo_summary( sprintf( __( 'Read legalwear guidance, news and updates from %s.', 'daraz-law-shop' ), get_bloginfo( 'name' ) ) );
	}
	if ( is_post_type_archive() ) {
		return daraz_seo_summary( sprintf( __( 'Explore the collection and latest updates from %s.', 'daraz-law-shop' ), get_bloginfo( 'name' ) ) );
	}
	return '';
}

/**
 * Respect WordPress core rel_canonical on singular pages. Use each archive
 * page's own permanent pagination URL instead of canonicalizing page 2 to 1.
 */
function daraz_seo_url() {
	if ( is_404() || is_search() || is_preview() || is_feed() ) {
		return '';
	}
	if ( is_singular() ) {
		return get_permalink( get_queried_object_id() );
	}
	if ( is_front_page() && ! is_paged() ) {
		return home_url( '/' );
	}
	if ( function_exists( 'is_shop' ) && is_shop() && ! is_paged() ) {
		return wc_get_page_permalink( 'shop' );
	}
	if ( is_home() || is_archive() || is_paged() ) {
		return get_pagenum_link( max( 1, (int) get_query_var( 'paged' ) ) );
	}
	return '';
}

/** Homepage title uses WordPress's title-tag support, not a second <title>. */
function daraz_seo_home_document_title( $title ) {
	if ( ! daraz_seo_plugin_active() && is_front_page() && ! is_paged() && ! $title ) {
		return sanitize_text_field( get_theme_mod( 'daraz_seo_home_title', 'Barrister Gowns, Wigs, Legalwear & Law Books | Daraz Law Shop' ) );
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'daraz_seo_home_document_title', 5 );

/** Prevent indexing checkout, account, cart and infinite filter URLs. */
function daraz_seo_robots( $robots ) {
	$private_page = false;
	if ( function_exists( 'is_cart' ) ) {
		$private_page = is_cart() || is_checkout() || is_account_page();
	}
	if ( function_exists( 'is_order_received_page' ) ) {
		$private_page = $private_page || is_order_received_page();
	}
	if ( is_page( 'track-order' ) ) {
		$private_page = true;
	}
	$faceted = false;
	if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		foreach ( array_keys( $_GET ) as $parameter ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading URL parameters, not saving input.
			if ( preg_match( '/^(filter_.+|query_type_.+|min_price|max_price|orderby|rating_filter)$/', sanitize_key( $parameter ) ) ) {
				$faceted = true;
				break;
			}
		}
	}
	if ( $private_page || $faceted ) {
		unset( $robots['index'] );
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	return $robots;
}
add_filter( 'wp_robots', 'daraz_seo_robots', 20 );

/** Page-relevant image for social sharing, not a generic unrelated preview. */
function daraz_seo_image() {
	if ( is_singular() && has_post_thumbnail( get_queried_object_id() ) ) {
		return get_the_post_thumbnail_url( get_queried_object_id(), 'full' );
	}
	if ( is_tax( 'product_cat' ) ) {
		$term = get_queried_object();
		$attachment_id = ( $term instanceof WP_Term ) ? absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) ) : 0;
		if ( $attachment_id ) {
			return wp_get_attachment_image_url( $attachment_id, 'full' );
		}
	}
	if ( is_front_page() ) {
		$hero = get_theme_mod( 'daraz_hero_image', '' );
		if ( $hero ) {
			return esc_url_raw( $hero );
		}
	}
	$default = get_theme_mod( 'daraz_seo_social_image', '' );
	if ( $default ) {
		return esc_url_raw( $default );
	}
	$image_path = file_exists( get_theme_file_path( '/assets/images/editorial-home.webp' ) ) ? '/assets/images/editorial-home.webp' : '/assets/images/editorial-home.png';
	return get_theme_file_uri( $image_path );
}

function daraz_seo_meta() {
	if ( daraz_seo_plugin_active() || is_404() || is_search() || is_feed() || is_preview() ) {
		return;
	}
	if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
		return;
	}
	if ( is_page( 'track-order' ) ) {
		return;
	}
	$url = daraz_seo_url();
	if ( ! $url ) {
		return;
	}
	$description = daraz_seo_description();
	$title       = wp_get_document_title();
	$image       = daraz_seo_image();
	$type        = is_singular( 'post' ) ? 'article' : 'website';

	if ( $description ) {
		printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $description ) );
	}
	/* WordPress rel_canonical already handles singular pages (including products). */
	if ( ! is_singular() ) {
		printf( "<link rel=\"canonical\" href=\"%s\">\n", esc_url( $url ) );
	}
	printf( "<meta property=\"og:type\" content=\"%s\">\n", esc_attr( $type ) );
	printf( "<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( "<meta property=\"og:locale\" content=\"%s\">\n", esc_attr( get_locale() ) );
	printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( $title ) );
	if ( $description ) {
		printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $description ) );
	}
	printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( $url ) );
	if ( $image ) {
		printf( "<meta property=\"og:image\" content=\"%s\">\n", esc_url( $image ) );
	}
	echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
	printf( "<meta name=\"twitter:title\" content=\"%s\">\n", esc_attr( $title ) );
	if ( $description ) {
		printf( "<meta name=\"twitter:description\" content=\"%s\">\n", esc_attr( $description ) );
	}
	if ( $image ) {
		printf( "<meta name=\"twitter:image\" content=\"%s\">\n", esc_url( $image ) );
	}
	if ( is_singular( 'post' ) ) {
		printf( "<meta property=\"article:published_time\" content=\"%s\">\n", esc_attr( get_post_time( DATE_W3C, true, get_queried_object_id() ) ) );
		printf( "<meta property=\"article:modified_time\" content=\"%s\">\n", esc_attr( get_post_modified_time( DATE_W3C, true, get_queried_object_id() ) ) );
	}
}
add_action( 'wp_head', 'daraz_seo_meta', 8 );

/** Real breadcrumb hierarchy reused in both visible navigation and schema. */
function daraz_seo_breadcrumb_items() {
	if ( is_front_page() || is_404() || is_search() || is_singular( 'product' ) ) {
		return array();
	}
	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		return array(); // WooCommerce already renders its own breadcrumbs.
	}
	$items = array( array( 'name' => __( 'Home', 'daraz-law-shop' ), 'url' => home_url( '/' ) ) );
	if ( is_singular() ) {
		$id = get_queried_object_id();
		if ( is_singular( 'post' ) ) {
			$posts_page = (int) get_option( 'page_for_posts' );
			if ( $posts_page ) {
				$items[] = array( 'name' => get_the_title( $posts_page ), 'url' => get_permalink( $posts_page ) );
			}
			$categories = get_the_category( $id );
			if ( $categories && ! is_wp_error( $categories ) ) {
				$category = $categories[0];
				$items[] = array( 'name' => $category->name, 'url' => get_category_link( $category->term_id ) );
			}
		} elseif ( is_page() ) {
			foreach ( array_reverse( get_post_ancestors( $id ) ) as $parent ) {
				$items[] = array( 'name' => get_the_title( $parent ), 'url' => get_permalink( $parent ) );
			}
		}
		$items[] = array( 'name' => get_the_title( $id ), 'url' => get_permalink( $id ) );
	} elseif ( is_home() ) {
		$posts_page = (int) get_option( 'page_for_posts' );
		$items[] = array( 'name' => $posts_page ? get_the_title( $posts_page ) : __( 'Journal', 'daraz-law-shop' ), 'url' => $posts_page ? get_permalink( $posts_page ) : get_pagenum_link( 1 ) );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$permalink = get_term_link( $term );
			if ( ! is_wp_error( $permalink ) ) {
				$items[] = array( 'name' => $term->name, 'url' => $permalink );
			}
		}
	}
	return $items;
}

function daraz_seo_breadcrumbs() {
	$items = daraz_seo_breadcrumb_items();
	if ( count( $items ) < 2 ) {
		return;
	}
	echo '<nav class="daraz-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'daraz-law-shop' ) . '"><ol>';
	$last = count( $items ) - 1;
	foreach ( $items as $index => $item ) {
		echo '<li>';
		if ( $index === $last ) {
			echo '<span aria-current="page">' . esc_html( $item['name'] ) . '</span>';
		} else {
			echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['name'] ) . '</a>';
		}
		echo '</li>';
	}
	echo '</ol></nav>';
}

/**
 * Do not invent product offers or review ratings. WooCommerce generates its
 * own Product + BreadcrumbList rich results data on commerce pages.
 */
function daraz_seo_schema() {
	if ( daraz_seo_plugin_active() || is_404() || is_search() || is_feed() || is_preview() ) {
		return;
	}
	if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
		return;
	}
	if ( is_page( 'track-order' ) ) {
		return;
	}
	$site_url = home_url( '/' );
	$org_id   = $site_url . '#organization';
	$graph    = array();
	if ( is_front_page() ) {
		$organization = array(
			'@type' => 'OnlineStore',
			'@id'   => $org_id,
			'name'  => get_bloginfo( 'name' ),
			'url'   => $site_url,
		);
		$logo_id = absint( get_theme_mod( 'custom_logo' ) );
		if ( $logo_id ) {
			$logo = wp_get_attachment_image_url( $logo_id, 'full' );
			if ( $logo ) {
				$organization['logo'] = $logo;
			}
		}
		$email = sanitize_email( get_theme_mod( 'daraz_email', 'info@darazlawshop.com' ) );
		$phone = get_theme_mod( 'daraz_phone', '+2348033910334' );
		if ( $email ) {
			$organization['email'] = $email;
		}
		if ( $phone ) {
			$organization['telephone'] = sanitize_text_field( $phone );
		}
		$profiles = array_filter( array(
			esc_url_raw( get_theme_mod( 'daraz_instagram', '' ) ),
			esc_url_raw( get_theme_mod( 'daraz_facebook', '' ) ),
		) );
		if ( $profiles ) {
			$organization['sameAs'] = array_values( $profiles );
		}
		$graph[] = $organization;
		$graph[] = array(
			'@type' => 'WebSite',
			'@id'   => $site_url . '#website',
			'name'  => get_bloginfo( 'name' ),
			'url'   => $site_url,
			'inLanguage' => get_bloginfo( 'language' ),
			'publisher' => array(
				'@type' => 'Organization',
				'@id'   => $org_id,
				'name'  => get_bloginfo( 'name' ),
				'url'   => $site_url,
			),
		);
	}
	if ( is_singular( 'post' ) ) {
		$id = get_queried_object_id();
		$post_schema = array(
			'@type' => 'BlogPosting',
			'@id'   => get_permalink( $id ) . '#article',
			'headline' => get_the_title( $id ),
			'mainEntityOfPage' => get_permalink( $id ),
			'datePublished' => get_the_date( DATE_W3C, $id ),
			'dateModified' => get_the_modified_date( DATE_W3C, $id ),
			'author' => array(
				'@type' => 'Person',
				'name' => get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $id ) ),
			),
			'publisher' => array( '@id' => $org_id ),
		);
		if ( has_post_thumbnail( $id ) ) {
			$post_schema['image'] = get_the_post_thumbnail_url( $id, 'full' );
		}
		$description = daraz_seo_description();
		if ( $description ) {
			$post_schema['description'] = $description;
		}
		$graph[] = $post_schema;
	}
	$crumbs = daraz_seo_breadcrumb_items();
	if ( count( $crumbs ) > 1 ) {
		$list = array();
		foreach ( $crumbs as $index => $crumb ) {
			$list[] = array(
				'@type' => 'ListItem',
				'position' => $index + 1,
				'name' => $crumb['name'],
				'item' => $crumb['url'],
			);
		}
		$graph[] = array( '@type' => 'BreadcrumbList', '@id' => daraz_seo_url() . '#breadcrumb', 'itemListElement' => $list );
	}
	if ( ! $graph ) {
		return;
	}
	echo '<script type="application/ld+json">' . "\n";
	// JSON_HEX_* protects this inline script against HTML injection.
	echo wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo "\n</script>\n";
}
add_action( 'wp_head', 'daraz_seo_schema', 24 );
