<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: change-post-url
 *
 * Append prefix to Posts permalink
 *
 * @example jetfuel('change-post-url', $param(string));
 * @param   string $param A string to append to the Posts URL
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_bar_menu/
 * @link https://www.php.net/manual/en/reserved.variables.server.php
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 2.5.0
 */
class ChangePostUrl extends Instance {

  public function run() {
    $this->setup()->hook();
  }

  protected function setup() {
    $this->setDefaultConfig(get_post_field( 'post_name', get_option( 'page_for_posts' )));
    return $this;
  }

  protected function hook() {
    // Add Rewrite Rules
    add_action('generate_rewrite_rules', [$this, 'addRewriteRules']);
    add_action('post_link', [$this, 'change_blog_links'], 1, 3); 
  }

  public function addRewriteRules($wp_rewrite){
    global $wp_rewrite;
    $param = $this->escArray($this->config);
    $new_rules = array(
      $param . '/(.+?)/?$' => 'index.php?post_type=post&name='. $wp_rewrite->preg_index(1),
    );

    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
  }

  public function change_blog_links($post_link, $id=0) {
    global $post_link;
    $post = get_post($id);
    $param = $this->escArray($this->config);

    if( is_object($post) && $post->post_type == 'post'){
      return home_url('/' . $param . '/'. $post->post_name.'/');
    }

    return $post_link;
  }

}
