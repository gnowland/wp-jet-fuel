<?php

namespace Gnowland\JetFuel\Module;

use Gnowland\JetFuel\Instance;

/**
* Module: customize-editor
*
* Customizations for the TinyMCE visual editor
*
* @example jetfuel('customize-editor', $options(string|array));
*
* @link https://developer.wordpress.org/reference/hooks/mce_buttons_2/
* @link https://developer.wordpress.org/reference/hooks/tiny_mce_before_init/
* @link https://developer.wordpress.org/reference/hooks/admin_head/
*
* @package WordPress
* @subpackage WPJetFuel
* @since 0.2.0
*/
class CustomizeEditor extends Instance {
    protected $options;

    public function run() {
        $this->setup()->hook();
    }

    protected function setup() {
        $this->options = [];
        $this->setDefaultConfig('all');
        return $this;
    }

    protected function hook() {
        // Move help icon to end of array
        add_filter('mce_buttons_2', [$this, 'moveHelp']);
        // Show style formats dropdown
        add_filter('mce_buttons', [$this, 'showStyleFormats']);
        // Remove H1
        add_filter('tiny_mce_before_init', [$this, 'removeH1']);
        // Add formats to the style select
        add_filter('tiny_mce_before_init', [$this, 'customizeStyleFormats']);
        // Inject <style> into TinyMCE <iframe> <head> to fix infinite-height bug
        add_action('admin_head', [$this, 'preventInfiniteResize'], 99);
    }

    public function moveHelp($buttons) {
        if(($key = array_search('wp_help', $buttons)) !== false) {
            unset($buttons[$key]);
            $buttons[] = 'wp_help';
        }
        return $buttons;
    }

    public function showStyleFormats($buttons) {
        // Remove Format Select
        if(($key = array_search('formatselect', $buttons)) !== false) {
            unset($buttons[$key]);
        }
        // Add Style Select
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }

    public function removeH1($settings) {
        $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre;';
        return $settings;
    }

    public function customizeStyleFormats($settings) {
        $style_formats = array(
            array(
                'title' => __('Headings', 'jetfuel'),
                'items' => array(
                    // Default
                    // [ 'title'  => __('Heading 1', 'jetfuel'),
                    //   'format' => 'h1' ],
                    [ 'title'  => __('Heading 2', 'jetfuel'),
                      'format' => 'h2' ],
                    [ 'title'  => __('Heading 3', 'jetfuel'),
                      'format' => 'h3' ],
                    [ 'title'  => __('Heading 4', 'jetfuel'),
                      'format' => 'h4' ],
                    [ 'title'  => __('Heading 5', 'jetfuel'),
                      'format' => 'h5' ],
                    [ 'title'  => __('Heading 6', 'jetfuel'),
                      'format' => 'h6' ]
                ),
            ),
            array(
                'title' => __('Inline', 'jetfuel'),
                'items' => array(
                    // Default
                    [ 'title'  => __('Bold', 'jetfuel'),
                      'icon'   => 'bold',
                      'format' => 'bold' ],
                    [ 'title'  => __('Italic', 'jetfuel'),
                      'icon'   => 'italic',
                      'format' => 'italic' ],
                    [ 'title'  => __('Underline', 'jetfuel'),
                      'icon'   => 'underline',
                      'format' => 'underline'],
                    [ 'title'  => __('Strikethrough', 'jetfuel'),
                      'icon'   => 'strikethrough',
                      'format' => 'strikethrough'],
                    [ 'title'  => __('Superscript', 'jetfuel'),
                      'icon'   => 'superscript',
                      'format' => 'superscript'],
                    [ 'title'  => __('Subscript', 'jetfuel'),
                      'icon'   => 'subscript',
                      'format' => 'subscript'],
                    [ 'title'  => __('Code', 'jetfuel'),
                      'icon'   => 'code',
                      'format' => 'code'],

                    // Custom
                    [ 'title'   => __('Button', 'jetfuel'),
                      'icon'    => 'backcolor',
                      'inline'  => 'a',
                      'classes' => 'button primary',
                      'wrapper' => false ],
                    [ 'title'   => __('Small', 'jetfuel'),
                      'icon'    => 'count',
                      'block'   => 'small',
                      'wrapper' => true ]
                )
            ),
            array(
                'title' => __('Blocks', 'jetfuel'),
                'items' => array(
                    // Default
                    [ 'title'  => __('Paragraph', 'jetfuel'),
                      'format' => 'p' ],
                    [ 'title'  => __('Blockquote', 'jetfuel'),
                      'format' => 'blockquote'],
                    [ 'title'  => __('Div', 'jetfuel'),
                      'format' => 'div'],
                    [ 'title'  => __('Pre', 'jetfuel'),
                      'format' => 'pre'],

                    // Custom
                    [ 'title' => __('Aside', 'jetfuel'),
                      'block' => 'aside',
                      'wrapper' => true
                    ]
                )
            ),
            array(
                'title' => __('Alignment', 'jetfuel'),
                'items' => array(
                    [ 'title' => __('Left', 'jetfuel'),
                      'icon' => 'alignleft',
                      'format' => 'alignleft' ],
                    [ 'title' => __('Center', 'jetfuel'),
                      'icon' => 'aligncenter',
                      'format' => 'aligncenter' ],
                    [ 'title' => __('Right', 'jetfuel'),
                      'icon' => 'alignright',
                      'format' => 'alignright' ],
                    [ 'title' => __('Justify', 'jetfuel'),
                      'icon' => 'alignjustify',
                      'format' => 'alignjustify' ]
                )
            )
        );

        // Insert the array, JSON ENCODED, into 'style_formats'
        $settings['style_formats_merge'] = false; // Merge with existing style formats
        $settings['style_formats'] = json_encode( $style_formats );

        return $settings;
    }

    public function preventInfiniteResize() {
      // Append classes to TinyMCE <iframe> body to target article styles
      ?>
      <script>
        var theFrame;
        window.onload = function() {
          theFrame = document.getElementsByTagName("iframe")[0];
          if (!theFrame) {
            window.setTimeout(function(){
              theFrame = document.getElementsByTagName("iframe")[0]
            }, 1000);
          } else {
            if (theFrame.id !== "content_ifr"){ return; }
            var theFrameDocument = theFrame.contentDocument || theFrame.contentWindow.document;

            // Add <style> to <head>
            var frmhead = theFrameDocument.head;
            frmhead.innerHTML += '<style>html,body{height:auto!important;}</style>';

            // Add class to <body>
            var frmbody = theFrameDocument.body;
            frmbody.className += " entry-content";
          }
        };
      </script>
      <?php
    }

}
