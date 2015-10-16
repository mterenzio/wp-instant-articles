<?php
/*
Plugin Name: WP Instant Articles
Plugin URI:  http://www.github.com/mterenzio/wp-instant-articles
Description: Creates Instant Articles Feed
Version:     1.0.0
Author:      Matt Terenzio
Author URI:  http://www.github.com/mterenzio
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


add_action('init', 'instantArticles');
function instantArticles(){
	add_feed('instant-articles', 'getInstantArticlesTemplate');
}


function getInstantArticlesTemplate(){
    if ( !file_exists(get_stylesheet_directory() . '/instant-articles-feed.php')) {
      load_template( __DIR__ . '/instant-articles-template.php');
    } else {
      load_template( get_stylesheet_directory() . '/instant-articles-feed.php' );
    }
}


?>
