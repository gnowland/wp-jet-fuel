<?php
/**
 * Login Page Functions
 *
 * @category login
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 *                       --- IMPORTANT! ---
 * DO NOT wrap is_admin() as login page is not considered an admin page.
 *
 */

namespace WPJetFuel\Login;

function login_customizer( $wp_customize ) {
	class Custom_Setting_Image_Data extends \WP_Customize_Setting {
		// Overwrites the `update()` method so we can save some extra data.
		protected function update( $value ) {

			if ( $value ) {
				$post_id = attachment_url_to_postid( $value );

				if ( $post_id ) {
					$image = wp_get_attachment_image_src( $post_id, [640, 9999] );

					if ( $image ) {
						// Set up a custom array of data to save.
						$data = array(
							'url'    => esc_url_raw( $image[0] ),
							'width'  => absint( $image[1] ),
							'height' => absint( $image[2] ),
							'id'     => absint( $post_id )
						);

						set_theme_mod( "{$this->id_data[ 'base' ]}_data", $data );
					}
				}
			}

			// No media? Remove the data mod.
			if ( empty( $value ) || empty( $post_id ) || empty( $image ) )
				remove_theme_mod( "{$this->id_data[ 'base' ]}_data" );

			// Let's send this back up and let the parent class do its thing.
			return parent::update( $value );
		}
	}

	// Add customizer section
	$wp_customize->add_section( 'login_logo_section', array(
			'title'       => __( 'Login Page', 'wp-jet-fuel' ),
			'priority'    => 30,
			'description' => 'Customize the login page'
		)
	);

	// Register customizer section
	$wp_customize->add_setting( new Custom_Setting_Image_Data(
			$wp_customize,
			'login_logo',
			array(
				'default' => get_theme_mod( 'login_logo', '' )
			)
		)
	);

	// Add image uploader
	$wp_customize->add_control( new \WP_Customize_Image_Control(
			$wp_customize,
			'login_logo_control',
			array(
				'label'    => __( 'Logo', 'wp-jet-fuel' ),
				'section'  => 'login_logo_section',
				'settings' => 'login_logo',
				'description' => 'Upload a logo to display on the login page'
		)
	) );

}
add_action( 'customize_register', __NAMESPACE__ . '\\login_customizer', 1000, 1 );

function login_image() {
	$login_logo_data = get_theme_mod('login_logo_data');

	if( !empty($login_logo_data) ) {
		$login_logo_url = $login_logo_data['url'];
		$login_image_ratio = 100 * ( $login_logo_data['height'] / $login_logo_data['width'] );

		echo '<style>
			.login h1 a {
				background-image: url( ' . esc_url($login_logo_url) . ' ) !important;
				width: 100%;
				background-size: cover;
				height: 0;
				padding: 0;
				padding-bottom: ' . floatval($login_image_ratio) . '%;
			}
			.interim-login h1 a {
				margin-bottom: 0;
			}
		</style>';
	}
}
add_action( 'login_head', __NAMESPACE__ . '\\login_image' );

// changing the alt text on the logo to show your site name
function login_title() { return get_option('blogname'); }
add_filter('login_headertitle', __NAMESPACE__ . '\\login_title');

// changing the logo link from wordpress.org to your site
function login_url() {  return home_url(); }
add_filter('login_headerurl', __NAMESPACE__ . '\\login_url');
