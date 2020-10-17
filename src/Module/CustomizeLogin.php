<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: customize-login
 *
 * Adds section to Customizer to customize login page
 *
 * @example jetfuel('customize-login', $config(array["css-style" => "value"])); 
 * @param   array $config(array['spacer-example'])
 *
 * @link https://developer.wordpress.org/reference/hooks/customize_register/
 * @link https://developer.wordpress.org/reference/hooks/login_head/
 * @link https://developer.wordpress.org/reference/hooks/login_headertext/
 * @link https://developer.wordpress.org/reference/hooks/login_headerurl/
 * @link https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
 * @link https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
 * @link https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control
 * @link https://developer.wordpress.org/reference/functions/get_option/
 * @link https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 * @version 2.3.0
 */
class CustomizeLogin extends Instance {
  public function run() {
      $this->setup()->hook();
  }

  protected function setup() {
      $this->setDefaultConfig([
        "width" => "100%",
        "background-size" => "cover",
      ]);
      return $this;
  }

  protected function hook() {
    // add customizer panel to choose login logo
    add_action( 'customize_register', [$this, 'customizeLogin'], 1000, 1 );
    // change login page logo to the one set in the customizer
    add_action( 'login_head', [$this, 'loginImage'] );
    // change the alt text on the logo to show your site name
    add_filter( 'login_headertext', function() { return get_option('blogname'); } );
    // change the logo link from wordpress.org to your site
    add_filter( 'login_headerurl', function() { return home_url(); } );
  }

  public function customizeLogin($wp_customize) {

    // Add customizer section
    $wp_customize->add_section( 'login_page', [
      'title'       => __( 'Login Page', 'jetfuel' ),
      'priority'    => 30,
      'description' => __( 'Customize the login page', 'jetfuel' ),
    ]);

    // Register customizer setting
    $wp_customize->add_setting( 'jetfuel_login_logo', [
      'type'  => 'option',
      'capability' => 'manage_options',
      'default' => get_option( 'jetfuel_login_logo', '' ),
      'sanitize_callback' => 'absint'
    ]);

    // Add image uploader
    $wp_customize->add_control( new \WP_Customize_Media_Control(
      $wp_customize,
      'login_logo_file',
      array(
        'label'       =>  __( 'Logo', 'jetfuel' ),
        'description' =>  __( 'Upload a logo to display on the login page', 'jetfuel' ),
        'section'     =>  'login_page',
        'settings'    =>  'jetfuel_login_logo'
      )
    ));
  }

  public function loginImage() {
    $login_styles = $this->config;

    if( !empty( $logo_id = get_option('jetfuel_login_logo') ) ) {
      $logo_array = wp_get_attachment_image_src($logo_id, [640,9999]);
      if( !empty($logo_array) && is_array($logo_array) ) {
        $logo_url = $logo_array[0];
        if( !empty($logo_array[2]) && !empty($logo_array[1]) ) {
          $image_ratio = 100 * ( $logo_array[2] / $logo_array[1] ) . '%';
        } else {
          $image_ratio = 'auto';
        }

        echo '<style>
          .login h1 {';
        if (is_array($login_styles) && !empty($login_styles)) {
          if (!array_key_exists('padding-bottom', $login_styles)) {
            echo 'padding-bottom: ' . floatval($image_ratio) . '%;';
          }
          
          foreach ($login_styles as $style => $value) {
            echo $style . ': ' . $value . ';';
          }
        }

        echo '
          }
          .login h1 a {
            background-image: url( ' . esc_url($logo_url) . ' ) !important;
            padding: 0;
            margin: 0;
            background-size: inherit;
            width: 100%;
            display: block;
            position: absolute;
            bottom: 0;
          }
          .interim-login h1 a {
            margin-bottom: 0;
          }
        </style>';
        }
    }
  }
}
