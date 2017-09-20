<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: enable-widget-text-code
 *
 * Prevent WordPress from re-ordering terms checklist
 *
 * @example jetfuel('enable-widget-text-code', $config(array|string));
 * @param   array|string $config  'all'
 *
 * @link https://developer.wordpress.org/reference/hooks/widget_text/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class EnableWidgetTextCode extends Instance {
  protected $options;

  public function run() {
    $this->setup()->hook();
  }

  protected function setup() {
    $this->options = ['php' => 'widgetTextSupportPhp', 'shortcodes' => 'do_shortcode'];
    $this->setDefaultConfig('all');
    return $this;
  }

  protected function hook() {
    if (in_array('all', $this->config)) {
      foreach ($this->options as $option => $value) {
        // Execute shortcodes in text widget
        if ($value === 'do_shortcode') {
          add_filter('widget_text', 'do_shortcode', 11);
        } else {
          add_filter('widget_text', [$this, $value]);
        }
      }
    } else {
      foreach ($this->options as $option => $value) {
        if ($value === 'do_shortcode') {
          add_filter('widget_text', 'do_shortcode', 11);
        } else {
          add_filter('widget_text', [$this, $value]);
        }
      }
    }
  }

  // Allow PHP in 'Text' Widget
  public function widgetTextSupportPhp($text) {
    if(strpos($text,"<"."?php")!==false){
      ob_start();
      eval("?".">".$text);
      $text = ob_get_contents();
      ob_end_clean();
    }
    return $text;
  }
}
