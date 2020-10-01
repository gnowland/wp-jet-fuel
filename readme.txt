=== WP Jet Fuel ===
Contributors: gnowland
Donate link: http://buymeacoff.ee/gnowland
Tags: functionality, page, menu, image, shortcode, favicon, excerpt, login, archive, attachment, comment, taxonomies, terms, tags, must-have, multi-function
Stable tag: 1.0.1
Requires PHP: 5.3.0
Requires at least: 4.0
Tested up to: 5.5.1
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Propel your WordPress installation into the stratosphere with this multi-function plugin.

== Description ==

Canonize useful WordPress customizations and filtering hooks. I truly hope it brings inner peace and enlightenment to your world. ~(˘▾˘~)

## Complementary Plugins

The following plugins are particularly complementary; in fact a notable number of 0.1.0 actions were dropped in 0.2.0 in favor of using the methods from these fantastic plugins instead!

* Admin cleanup &amp; modifications: <a href="https://github.com/soberwp/intervention">soberwp/intervention</a>
* Custom post types &amp; taxonomies: <a href="https://github.com/soberwp/models">soberwp/models</a>

## Rationale

At its core, this plugin merely facilitates the addition of extended functionality to a WordPress website: Custom Post Types, Meta Fields, Widgets, Taxonomies, Shortcodes, Admin Modifications, etc.

*Why a functionality plugin, you ask?* Think of it this way: instead of tying site architecture and management code to a particular Theme (via <pre>functions.php</pre>), a much more sustainable method is to use what's commonly refered to as a "functionality plugin". This seperates *form* (frontend layout) from *function* (administration), allowing you to retain functionality modifications across theme installations!

Here's what some intelligent people say on the subject:
<blockquote>"We recommend that you always put custom post types in a plugin rather than a theme. This ensures that the user's content is portable whenever they change their website's design." &mdash; <a href="https://developer.wordpress.org/plugins/custom-post-types-and-taxonomies/registering-custom-post-types/">Wordpress.org Plugin Handbook</a></blockquote>

<blockquote>See also: <a href="http://justintadlock.com/archives/2013/09/14/why-custom-post-types-belong-in-plugins">Why Custom Post Types Belong in Plugins</a> and <a href="http://wpcandy.com/teaches/how-to-create-a-functionality-plugin">How to Create Your Own WordPress Functionality Plugin</a> for more supporting evidence behind adding additional site functionality via a plugin instead of a theme's <pre>functions.php</pre> file.</blockquote>


== Changelog ==

See <a href="https://github.com/gnowland/wp-jet-fuel/releases">Releases</a>.

== Installation ==

1. Install Plugin (see below)
2. Add <pre>jetfuel('module-name', ['arbitrary', 'options']);</pre> to <pre>functions.php</pre> (or ideally a file required by <pre>functions.php</pre>)
    
@TODO: Add in-depth descriptions of individual modules. Until then, take a peek in <a href="https://github.com/gnowland/wp-jet-fuel/tree/master/src/Module">the <pre>src/Module</pre> folder</a>) for available functions.

## Installation ##

### Composer ###

```shell
composer require gnowland/wp-jet-fuel
```

Activate with <a href="http://wp-cli.org/">wp-cli</a>

```shell
wp plugin activate wp-jet-fuel
```

### Git ###

* `git clone` into your sites plugin folder
* Activate via WordPress or wp-cli (see above)

### Manual ###

* Download the <a href="https://github.com/gnowland/wp-jet-fuel/archive/master.zip">zip file</a>
* Unzip to your sites plugin folder
* Activate via WordPress or wp-cli (see above)

## Updates ##

Includes support for <a href="https://github.com/afragen/github-updater">github-updater</a> to keep track of updates through the WordPress admin.
