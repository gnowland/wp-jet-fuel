<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: customize-login
 *
 * Adds section to Customizer to customize login page
 *
 * @example jetfuel('customize-login');
 *
 * @link https://developer.wordpress.org/reference/hooks/customize_register/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class CustomizeLogin extends Instance {
  public function run() {
      $this->setup()->hook();
  }

  protected function setup() {
      $this->setDefaultConfig('');
      return $this;
  }

  protected function hook() {
    add_action( 'customize_register', [$this, 'customizeLogin'], 1000, 1 );
  }

  public function customizeLogin($wp_customize) {

    // Add customizer section
    $wp_customize->add_section( 'login_logo_section', array(
      'title'       => __( 'Login Page', 'jetfuel' ),
      'priority'    => 30,
      'description' => __( 'Customize the login page', 'jetfuel' ),
    ));

    // Register customizer section
    $wp_customize->add_setting( new Custom_Setting_Image_Data(
      $wp_customize,
      'login_logo',
      array(
        'default' => get_theme_mod( 'login_logo', '' )
      )
    ));

    // Add image uploader
    $wp_customize->add_control( new \WP_Customize_Image_Control(
      $wp_customize,
      'login_logo_control',
      array(
        'label'       =>  __( 'Logo', 'jetfuel' ),
        'section'     =>  'login_logo_section',
        'settings'    =>  'login_logo',
        'description' =>  __( 'Upload a logo to display on the login page', 'jetfuel' )
      )
    ));
  }
}

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
