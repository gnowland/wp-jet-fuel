# WordPress Jet Fuel #
[![GitHub release](https://img.shields.io/github/release/gnowland/wp-jet-fuel.svg?style=flat-square)](https://github.com/gnowland/wp-jet-fuel/releases)
[![Packagist](https://img.shields.io/packagist/v/gnowland/wp-jet-fuel.svg?style=flat-square)](https://packagist.org/packages/gnowland/wp-jet-fuel)
[![npm](https://img.shields.io/npm/v/wp-jet-fuel.svg?style=flat-square)](https://www.npmjs.com/package/wp-jet-fuel)

Propel your WordPress installation into the stratosphere with this multi-function plugin. The combined result of *too many* years making one-off WordPress customizations and filtering hooks... I truly hope it brings inner peace and enlightenment to your world. ~(˘▾˘~)

## Complementary Plugins ##

The following plugins are particularly complementary; in fact a notable number of 0.1.0 actions were dropped in 0.2.0 in favor of using the methods from these fantastic plugins instead!

* Admin cleanup &amp; modifications:<br>[soberwp/intervention](https://github.com/soberwp/intervention)
* Custom post types &amp; taxonomies:<br>[soberwp/models](https://github.com/soberwp/models)

## How To Use ##

* Install Plugin (see below)
* Add `jetfuel('module-name', ['arbitrary', 'options']);` to functions.php (or ideally a file required by functions.php)
    * (More in-depth descriptions of modules to come)

## Installation ##

### Composer ###

    $ composer require gnowland/wp-jet-fuel

Activate with [wp-cli](http://wp-cli.org/)

    $ wp plugin activate wp-jet-fuel

### Git ###

* `git clone` into your sites plugin folder
* Activate via WordPress or wp-cli (see above)

### Manual ###

* Download the [zip file](https://github.com/gnowland/wp-jet-fuel/archive/master.zip)
* Unzip to your sites plugin folder
* Activate via WordPress or wp-cli (see above)

## Updates ##

Includes support for [github-updater](https://github.com/afragen/github-updater) to keep track of updates through the WordPress admin.

## Changelog ##

See [Releases](https://github.com/gnowland/wp-jet-fuel/releases).

## Contribution ##

Heck yea! Baby, we're better together.

* Refactor some gnarly code? Submit a PR.
* Write a feature addition? Submit a PR.
* Problems/requests? Make an Issue and I'll look into it ASAP.

There's no draconian PR standard, if I can't figure out something in your PR we can work it out together.

### Build ###

    $ phing

## Attribution ##

Don't be a stranger!

Contact **Gifford Nowland** <*hi(at symbol)giffordnowland.com*>

```ascii

                                                   ,:
                                                 ,' |
                                                /   :
                                             --'   /
                                             \/ />/
                                             / /_\
                                          __/   /
                                          )'-. /
                                          ./  :\
                                           /.' '
                                         '/'
                                         +
                                        '
                                      `.
                                  .-"-
                                 (    |
                              . .-'  '.
                             ( (.   )8:
                         .'    / (_  )
                          _. :(.   )8P  `
                      .  (  `-' (  `.   .
                       .  :  (   .a8a)
                      /_`( "a `a. )"'
                  (  (/  .  ' )=='
                 (   (    )  .8"   +
                   (`'8a.( _(   (
                ..-. `8P    ) `  )  +
              -'   (      -ab:  )
            '    _  `    (8P"Ya
          _(    (    )b  -`.  ) +
         ( 8)  ( _.aP" _a   \( \   *
       +  )/    (8P   (88    )  )
          (a:f   "     `"       `


```

## Rationale ##

At its core, this plugin merely facilitates the addition of extended functionality to a WordPress website: Custom Post Types, Meta Fields, Widgets, Taxonomies, Shortcodes, Admin Modifications, etc.

*Why a functionality plugin, you ask?* Think of it this way: instead of tying site architecture and management code to a particular Theme (via `functions.php`), a much more sustainable method is to use what's commonly refered to as a "functionality plugin". This seperates *form* (frontend layout) from *function* (administration), allowing you to retain functionality modifications across theme installations!

Here's what some intellegent people say on the subject:
> "We recommend that you always put custom post types in a plugin rather than a theme. This ensures that the user’s content is portable whenever they change their website’s design." &mdash; _[Wordpress.org Plugin Handbook](https://developer.wordpress.org/plugins/custom-post-types-and-taxonomies/registering-custom-post-types/)_

> See also: _[Why Custom Post Types Belong in Plugins](http://justintadlock.com/archives/2013/09/14/why-custom-post-types-belong-in-plugins)_ and _[How to Create Your Own WordPress Functionality Plugin](http://wpcandy.com/teaches/how-to-create-a-functionality-plugin)_ for more supporting evidence behind adding additional site functionality via a plugin instead of a theme's `functions.php` file.
