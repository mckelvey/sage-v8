<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Config;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Config\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Enqueue Styles
 */
function enqueue_scripts() {
  // nothing yet...
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );


/**
 * Default media gallery image options
 */
function theme_setup() {
    // Set default values for the upload media box
  update_option('image_default_align', 'none' );
  update_option('image_default_link_type', 'none' );
  update_option('image_default_size', 'large' );
}
add_action('after_setup_theme', __NAMESPACE__ . '\\theme_setup');


/**
 * Remove width and height attribute on editor-added images
 */
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
add_filter( 'post_thumbnail_html', __NAMESPACE__ . '\\remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', __NAMESPACE__ . '\\remove_thumbnail_dimensions', 10 );