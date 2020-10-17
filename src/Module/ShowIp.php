<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: show-ip
 *
 * Shows the server's IP address in the Admin Toolbar
 *
 * @example jetfuel('show-ip', $param(string));
 * @param   string $param A `$_SERVER` key. Some useful ones include: SERVER_ADDR, 'HTTP_X_FORWARDED_FOR'
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_bar_menu/
 * @link https://www.php.net/manual/en/reserved.variables.server.php
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 2.4.0
 */
class ShowIp extends Instance {

  public function run() {
    $this->setup()->hook();
  }

  protected function setup() {
    $this->setDefaultConfig('SERVER_ADDR');
    return $this;
  }

  protected function hook() {
    // Add IP address to the admin footer
    add_action( 'update_footer', [$this, 'addIpFooter'], 20 );
  }

  public function addIpFooter($content){
    $param = $this->escArray($this->config);
    $content .= '&emsp; IP: <abbr title="' . $param . '">' . $_SERVER[$param] . '</abbr>';
    return $content;
  }

}
