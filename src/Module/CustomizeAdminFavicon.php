<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: customize-admin-favicon
 *
 * Adds section to Customizer to customize admin-favicon
 *
 * @example jetfuel('customize-admin-favicon');
 *
 * @link https://developer.wordpress.org/reference/hooks/customize_register/
 * @link https://developer.wordpress.org/reference/hooks/site_icon_meta_tags/
 * @link https://developer.wordpress.org/reference/hooks/upload_mimes/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class CustomizeAdminFavicon extends Instance {
  public function run() {
      $this->setup()->hook();
  }

  protected function setup() {
      $this->setDefaultConfig('');
      return $this;
  }

  protected function hook() {
    // add customizer setting to choose a favicon
    add_action( 'customize_register', [$this, 'customizeAdminFavicon']);
    // add favicon to admin pages
    if (is_admin()) {
      add_filter ('site_icon_meta_tags', [$this, 'useAdminFavicon']);
    }
    if (is_admin() && current_user_can('manage_options')) {
      add_filter('upload_mimes', [$this, 'allowIcoUpload']);
    }
  }

  public function customizeAdminFavicon($wp_customize) {

    // Register customizer setting
    $wp_customize->add_setting( 'jetfuel_admin_favicon', array(
      'capability' => 'manage_options',
      'type'       => 'option',
      'default'    => get_option( 'jetfuel_admin_favicon', '' ),
      'transport'  => 'postMessage', // Previewed with JS in the Customizer controls window.
     ) );

    // Add image uploader
    $wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, 'admin_favicon', array(
      'label'       => __( 'Admin Favicon', 'jetfuel' ),
      'description' => sprintf(
        /* translators: %s: site icon size in pixels */
        __( 'The Admin Favicon is used as a browser icon for the admin panel. Icons <strong>MUST BE .ico</strong> format, square, pre-cropped to %s pixels wide and tall, and of a different style than your public Site Icon (may I suggest <em>grayscale</em> or <em>inverted</em>?)', 'jetfuel' ),
        '<strong>48</strong>'
      ),
      'section'     => 'title_tagline',
      'settings'    => 'jetfuel_admin_favicon',
      'priority'    => 70,
      'height'      => 48,
      'width'       => 48,
      'mime_type'   => 'image/x-icon'
    ) ) );
  }

  public function useAdminFavicon($meta_tags) {
    $favicon_url = get_option( 'jetfuel_admin_favicon', '' );
    $meta_tags = array('<link rel="shortcut icon" href="' . esc_url($favicon_url) . '" />');
    return $meta_tags;
  }

  public function allowIcoUpload($mime_types){
    $mime_types['ico'] = 'image/x-icon';
    return $mime_types;
  }
}
