<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: unlock-widget-text
 *
 * Prevent WordPress from re-ordering terms checklist
 *
 * @example jetfuel('unlock-widget-text', $config(array|string));
 * @param   array|string $config  'all'
 *
 * @link https://developer.wordpress.org/reference/hooks/widget_text/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class UnlockWidgetText extends Instance {
  protected $options;

  public function run() {
    $this->setup()->hook();
  }

  protected function setup() {
    $this->options = ['php' => 'widgetTextSupportPhp', 'shortcodes' => 'doShortcode'];
    $this->setDefaultConfig('all');
    return $this;
  }

  protected function hook() {
    if (in_array('all', $this->config)) {
      foreach ($this->options as $option => $value) {
        add_filter('widget_text', [$this, $value]);
      }
    } else {
      foreach ($this->options as $option => $value) {
        add_filter('widget_text', [$this, $value]);
      }
    }
  }

  // Allow PHP in 'Text' Widget
  public function widgetTextSupportPhp($text) {
    ob_start();
      eval( '?>' . $text );
      $text = ob_get_contents();
    ob_end_clean();

    return $text;
  }

  // Execute shortcodes in "Text" Widget
  public function doShortcode() {
    add_filter('widget_text', 'do_shortcode');
  }
}
