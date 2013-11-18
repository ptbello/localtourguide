localtourguide.io
======

This repo is the working code that goes with the presentation I gave at [WP Day 2013 in Bologna](http://www.wpday.it/):
**[WordPress per Startup](http://www.slideshare.net/pierobellomo/wp-per-startup/)**

It's case study in the use of WordPress as a fast and realible tool to build Minimum Viable Products
*
*
*
**\_strap** is a starter theme for WordPress.
It has the goal of integrating Twitter's **bootstrap** (https://github.com/twitter/bootstrap) into Automattic's **\_s** (https://github.com/Automattic/_s) with the [smallest possible changeset](https://github.com/ptbello/_strap/compare/master).

Like its big brother \_s, \_strap is not intended as Parent theme, rather as starting point to build a custom theme from scratch.
This means you will have to [replace](https://github.com/Automattic/_s#getting-started) all internal references to \_s with your new theme's name. No worries, you don't have to do it by hand: \_strap includes an automatic process \- just follow the instructions below.

Test Drive
------------
1. Download, unzip and merg withe the /wp-content directory of your WordPress Install
2. Install the following plugins:
    * [Advanced Custom Fields](http://wordpress.org/plugins/advanced-custom-fields/)
    * [Posts 2 Posts](http://wordpress.org/plugins/posts-to-posts/)    
3. Activate the Local Tour Guide theme
4. Create a Menu and assign it the "Primary Menu" theme location
5. Via Tools > Import > WordPress, (install the importer if you haven't and) import /wp-content/themes/ltg/inc/advanced-custom-field-export.xml
6. Via Settings > Permalink, change to somethong sensible like "Post Name"
7. You're all set. Create a few "Tour" post types and see them appear in the home page  

Questions
------------
Questions? Open an issue. 