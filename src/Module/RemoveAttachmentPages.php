<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
 * Module: remove-attachment-pages
 *
 * 301 redirects attachment pages to post parent (if any), otherwise 302 redirects to home page.
 *
 * @example jetfuel('remove-attachment-pages');
 *
 * @package WordPress
 * @subpackage WPJetFuel
 * @since 1.1.1
 */
class RemoveAttachmentPages extends Instance {

  public function run() {
    $this->setup()->hook();
  }

  protected function setup() {
    $this->setDefaultConfig([]);
    return $this;
  }

  protected function hook() {
    add_action('template_redirect', [$this, 'RemoveAttachmentPages']);
  }

  public function RemoveAttachmentPages() {
    global $post;
    $post_parent = $post->post_parent;
    if (is_attachment() && isset($post_parent) && is_numeric($post_parent) && ($post_parent !== 0)) {
      $parent_post_in_trash = get_post_status($post_parent) === 'trash' ? true : false;
      if ($parent_post_in_trash) {
        // Prevent endless redirection loop in old WP releases and redirecting to trashed posts if anattachment page is visited when parent post is in trash
        // wp_die( 'Page not found.', '404 - Page not found', 404 );
        header("HTTP/1.0 404 Not Found");
        $wp_query->set_404(); //This will inform WordPress you have a 404 - not absolutely necessary here, for reference
        require '404.php';
        exit;
      }
      wp_safe_redirect(get_permalink($post_parent), 301); // Redirect to post/page from where attachment was uploaded
      exit;
    } elseif (is_attachment() && isset($post_parent) && is_numeric($post_parent) && ($post_parent < 1 )) {
      wp_safe_redirect(get_home_url(), 302); // Redirect to home for attachments not associated with a post/page
      exit;
    }
  }
}
