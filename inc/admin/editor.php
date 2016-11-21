<?php
/**
 * TinyMCE editor functions
 *
 * @category admin/editor
 * @package  WPJetFuel
 * @author   Gifford Nowland
 *
 * Documentation:
 * @link     https://codex.wordpress.org/TinyMCE_Custom_Styles
 * @link     https://www.tinymce.com/docs/configure/content-formatting/#formats
 *
 */

namespace WPJetFuel\Admin\Editor;

/**
 * Add buttons to TinyMCE's second-row $buttons array
 */
function insert_style_selectbox( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	$buttons[] = 'superscript';
	$buttons[] = 'subscript';

	// Move help icon to end of array
	if(($key = array_search('wp_help', $buttons)) !== false) {
	    unset($buttons[$key]);
	    $buttons[] = 'wp_help';
	}

	return $buttons;
}
add_filter('mce_buttons_2', __NAMESPACE__ . '\\insert_style_selectbox');


/**
 * Add formats to the style formats selectbox as an array of arrays
 */
function add_style_formats( $settings ) {
	$style_formats = array(

		array(
			'title' => 'Aside',
			'block' => 'aside',
			'wrapper' => true
		),
		array(
			'title' => 'Blockquote',
			'block' => 'blockquote',
			'wrapper' => true
		),
		array(
			'title' => 'Button',
			'selector' => 'a',
			'inline' => 'a',
			'classes' => 'button primary',
			'wrapper' => false
		),
		array(
			'title' => 'Small',
			'block' => 'small',
			'wrapper' => true
		),

	);

	// Insert the array, JSON ENCODED, into 'style_formats'
	$settings['style_formats'] = json_encode( $style_formats );

	// Remove H1 from style selector
	$settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre;';

	return $settings;

}
add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\\add_style_formats' );


/**
 * Inject <style> into TinyMCE <iframe> <head> to fix infinite-height bug
 * Append classes to TinyMCE <iframe> body to target article styles
 */
function tinymce_iframe_injections() {
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
add_action('admin_head', __NAMESPACE__ . '\\tinymce_iframe_injections', 99, 1);
