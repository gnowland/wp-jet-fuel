<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: add-shortcodes
 *
 * Adds helpful shortcodes
 *
 * @example jetfuel('add-shortcodes', $items(string|array));
 *
 * @link https://developer.wordpress.org/reference/functions/add_shortcode/
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 * @link https://developer.wordpress.org/reference/functions/get_home_url/
 * @link https://developer.wordpress.org/reference/functions/get_bloginfo/
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 0.2.0
 */
class AddShortcodes extends Instance {
    protected $shortcodes;

    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->shortcodes = ['year', 'search', 'home_url', 'site_name'];
        $this->setDefaultConfig('all');
        return $this;
    }

    protected function hook() {
        if (in_array('all', $this->config)) {
            foreach ($this->shortcodes as $shortcode) {
                add_shortcode($shortcode, [$this, $shortcode]);
            }
        } else {
            foreach ($this->config as $shortcode) {
                add_shortcode($shortcode, [$this, $shortcode]);
            }
        }
    }

    /**
     * [year] Shortcode
     *
     * Returns the Current Year as a string in four digits.
     *
     * @return   string              Current Year
     */
    public function year() {
        $date = getdate();
        return $date['year'];
    }

    /**
     * [search] Shortcode
     *
     * Returns an html object containing the site search form.
     *
     * @return   html                Site Search Form
     */
    public function search() {
        return get_search_form(false);
    }

    /**
     * [home-url] Shortcode
     *
     * Returns the 'home url' from settings -> general.
     *
     * @return   string                Home URL
     */
    public function home_url() {
        $url = get_home_url();
        return esc_url($url);
    }

    /**
     * [site-name] Shortcode
     *
     * Returns the site name from settings -> general.
     *
     * @return   string                Site Name
     */
    public function site_name() {
        $name = get_bloginfo('name');
        return esc_attr($name);
    }
}
