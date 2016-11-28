<?php
/**
 * Admin Favicon
 *
 * @category admin/favicon
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 */

namespace WPJetFuel\Admin\favicon;

/**
 *  Add admin favicon upload
 */
function admin_favicon( $wp_customize ) {
	// Setup custom Image Control class
	class Admin_Favicon_Image_Control extends \WP_Customize_Image_Control {
		public function __construct( $manager, $id, $args ) {
			parent::__construct( $manager, $id, $args );
			$this->remove_tab('uploaded');
			$this->extensions[] = 'ico';
		}
	}

	// add a setting for the favicon
	$wp_customize->add_setting( 'admin_favicon', array(
			'capability' => 'edit_theme_options',
			'type'       => 'option'
		)
	);
	// Add a control to upload the logo
	$wp_customize->add_control(
		new Admin_Favicon_Image_Control(
			$wp_customize,
			'admin_favicon',
			array(
				'label'       => __( 'Admin Favicon', 'wp-jet-fuel' ),
				'description' => __( 'Favicons must be square, .ico format. 48x48 grayscale image suggested.', 'wp-jet-fuel' ),
				'section'     => 'title_tagline',
				'settings'    => 'admin_favicon',
				'priority'    => 99
			)
		)
	);
}
add_action( 'customize_register', __NAMESPACE__ . '\\admin_favicon', 10, 1 );

/**
 *  Add admin favicon to admin pages
 */
function use_admin_favicon($meta_tags) {
  $favicon_url = get_option( 'admin_favicon', '' );
  echo '<pre>favicon url: ' . print_r($favicon_url) . '</pre>';
  $meta_tags = array('<link rel="shortcut icon" href="' . esc_url($favicon_url) . '" />');
  return $meta_tags;
}
add_filter ( 'site_icon_meta_tags', __NAMESPACE__ . '\\use_admin_favicon' );
