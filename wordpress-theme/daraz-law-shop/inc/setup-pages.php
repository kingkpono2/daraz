<?php
/**
 * Optional, non-destructive onboarding for WordPress pages.
 * Creates only missing pages on explicit administrator action.
 *
 * @package Daraz_Law_Shop
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function daraz_register_setup_page() {
	add_theme_page(
		__( 'Daraz Shop Setup', 'daraz-law-shop' ),
		__( 'Daraz Setup', 'daraz-law-shop' ),
		'manage_options',
		'daraz-setup',
		'daraz_render_setup_page'
	);
}
add_action( 'admin_menu', 'daraz_register_setup_page' );

function daraz_render_setup_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$pages = daraz_starter_pages();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Daraz Law Shop setup', 'daraz-law-shop' ); ?></h1>
		<p><?php esc_html_e( 'Create missing starter pages without deleting or changing existing ones. Existing WooCommerce commerce pages are managed by WooCommerce.', 'daraz-law-shop' ); ?></p>
		<?php if ( isset( $_GET['daraz_created'] ) ) : ?>
			<div class="notice notice-success"><p><?php printf( esc_html__( '%d starter pages created.', 'daraz-law-shop' ), absint( $_GET['daraz_created'] ) ); ?></p></div>
		<?php endif; ?>
		<table class="widefat striped" style="max-width:850px"><thead><tr><th><?php esc_html_e( 'Page', 'daraz-law-shop' ); ?></th><th><?php esc_html_e( 'Status', 'daraz-law-shop' ); ?></th></tr></thead><tbody>
		<?php foreach ( $pages as $slug => $item ) :
			$existing = get_page_by_path( $slug, OBJECT, 'page' ); ?>
			<tr><td><?php echo esc_html( $item['title'] ); ?></td><td><?php echo esc_html( $existing ? ucfirst( $existing->post_status ) : __( 'Not created', 'daraz-law-shop' ) ); ?></td></tr>
		<?php endforeach; ?></tbody></table>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="daraz_create_pages">
			<?php wp_nonce_field( 'daraz_create_pages' ); ?>
			<?php submit_button( __( 'Create missing pages', 'daraz-law-shop' ) ); ?>
		</form>
		<p><?php esc_html_e( 'Privacy Policy and Terms & Conditions are created as drafts until you supply approved legal text. Review delivery and returns information before launch.', 'daraz-law-shop' ); ?></p>
		<p><?php esc_html_e( 'Next: install/configure WooCommerce; assign header/footer menus in Appearance → Menus; edit hero and contact settings in Appearance → Customize.', 'daraz-law-shop' ); ?></p>
	</div>
	<?php
}

function daraz_starter_pages() {
	return array(
		'home'                 => array( 'title' => __( 'Home', 'daraz-law-shop' ), 'status' => 'publish' ),
		'journal'              => array( 'title' => __( 'Journal', 'daraz-law-shop' ), 'status' => 'publish' ),
		'about'                => array( 'title' => __( 'About', 'daraz-law-shop' ), 'status' => 'publish' ),
		'contact'              => array( 'title' => __( 'Contact', 'daraz-law-shop' ), 'status' => 'publish' ),
		'faq'                  => array( 'title' => __( 'Frequently Asked Questions', 'daraz-law-shop' ), 'status' => 'publish' ),
		'size-guide'           => array( 'title' => __( 'Size Guide', 'daraz-law-shop' ), 'status' => 'publish' ),
		'delivery-returns'     => array( 'title' => __( 'Delivery & Returns', 'daraz-law-shop' ), 'status' => 'publish' ),
		'track-order'          => array( 'title' => __( 'Track Order', 'daraz-law-shop' ), 'status' => 'publish' ),
		'privacy-policy'       => array( 'title' => __( 'Privacy Policy', 'daraz-law-shop' ), 'status' => 'draft' ),
		'terms-and-conditions' => array( 'title' => __( 'Terms & Conditions', 'daraz-law-shop' ), 'status' => 'draft' ),
	);
}

function daraz_create_pages_handler() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to do this.', 'daraz-law-shop' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'daraz_create_pages' );
	$created = 0;
	$inserted = array();
	foreach ( daraz_starter_pages() as $slug => $item ) {
		if ( get_page_by_path( $slug, OBJECT, 'page' ) ) {
			continue;
		}
		$id = wp_insert_post( array(
			'post_title'   => $item['title'],
			'post_name'    => $slug,
			'post_type'    => 'page',
			'post_status'  => $item['status'],
			'post_content' => '',
		), true );
		if ( ! is_wp_error( $id ) && $id ) {
			$created++;
			$inserted[ $slug ] = (int) $id;
		}
	}
	if ( empty( get_option( 'page_on_front' ) ) ) {
		$home = isset( $inserted['home'] ) ? $inserted['home'] : get_page_by_path( 'home', OBJECT, 'page' );
		$home_id = is_object( $home ) ? $home->ID : $home;
		if ( $home_id ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', (int) $home_id );
		}
	}
	if ( empty( get_option( 'page_for_posts' ) ) ) {
		$journal = isset( $inserted['journal'] ) ? $inserted['journal'] : get_page_by_path( 'journal', OBJECT, 'page' );
		$journal_id = is_object( $journal ) ? $journal->ID : $journal;
		if ( $journal_id ) {
			update_option( 'page_for_posts', (int) $journal_id );
		}
	}
	wp_safe_redirect( add_query_arg( array( 'page' => 'daraz-setup', 'daraz_created' => $created ), admin_url( 'themes.php' ) ) );
	exit;
}
add_action( 'admin_post_daraz_create_pages', 'daraz_create_pages_handler' );
