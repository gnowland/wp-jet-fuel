<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: show-ip
 *
 * Shows the server's IP address in the Admin Toolbar
 *
 * @example jetfuel('show-ip');
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_bar_menu/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 2.4.0
 */
class ShowIp extends Instance {

  public function run() {
    $this->setup()->hook();
  }

  protected function hook() {
    // Add IP address to the admin toolbar
    add_action('admin_bar_menu', [$this, 'add_toolbar_items'], 100);
  }

  public function add_toolbar_items($admin_bar){
    $ip_addr = $_SERVER['SERVER_ADDR'];

    $admin_bar->add_menu( [
      'id'    => 'ip-addr',
      'title' => $ip_addr,
      'href'  => '#',
      'meta'  => [
        'title' => $ip_addr
      ]
    ]);

  }

}
