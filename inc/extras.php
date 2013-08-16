<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package headintobootstrap
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function headintobootstrap_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'headintobootstrap_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function headintobootstrap_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'headintobootstrap_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function headintobootstrap_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'headintobootstrap_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function headintobootstrap_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'headintobootstrap' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'headintobootstrap_wp_title', 10, 2 );

/*
	shortcode for youtube iframe lazy-loading
	example usage [youtube-lazy guid="youtube-id"]
*/
function register_shortcodes(){
   add_shortcode('youtube-lazy', 'youtube_lazy_function');
}
add_action( 'init', 'register_shortcodes');


function youtube_lazy_function($atts){
	wp_enqueue_script( 'his-youtube-lazy',  get_template_directory_uri() . '/js/his-youtube-lazy.js', array('jquery'), '1', true);

	$shortcode_attributes = shortcode_atts(array('width' => 624, 'height' => 351, 'guid' => ''), $atts);

   $return_string = '
		<div class="his-youtube-video">
            <img data-guid="'. $shortcode_attributes['guid'] .'" class="his-youtube-thumb" src="/assets/grey.gif" data-original="http://img.youtube.com/vi/'. $shortcode_attributes['guid'] .'/hqdefault.jpg" alt="" />
            <div class="play-image" data-guid="'. $shortcode_attributes['guid'] .'"></div>
        </div>';

   return $return_string;
}

/*
  stratus work
*/
function stratus_setup() {
    wp_enqueue_script( 'stratus' ,'http://stratus.sc/stratus.js', array('jquery'), '1', true);
}
add_action('wp_footer', 'stratus_setup');

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
    return 'class="btn btn-primary"';
}

add_filter('next_post_link', 'post_next_link_attributes');
add_filter('previous_post_link', 'post_prev_link_attributes');

function post_prev_link_attributes($output) {
    $injection = 'class="btn-default btn"';
    return str_replace('<a href=', '<a '.$injection.' href=', $output);
}

function post_next_link_attributes($output) {
    $injection = 'class="btn-default btn pull-right"';
    return str_replace('<a href=', '<a '.$injection.' href=', $output);
}
/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag and change ''s to "'s on rel_canonical()
 */
function roots_head_cleanup() {
  // Originally from http://wpengineer.com/1438/wordpress-header/
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'index_rel_link');


  global $wp_widget_factory;
  remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

  add_filter('use_default_gallery_style', '__return_null');

  if (!class_exists('WPSEO_Frontend')) {
    remove_action('wp_head', 'rel_canonical');
    add_action('wp_head', 'roots_rel_canonical');
  }
}

function roots_rel_canonical() {
  global $wp_the_query;

  if (!is_singular()) {
    return;
  }

  if (!$id = $wp_the_query->get_queried_object_id()) {
    return;
  }

  $link = get_permalink($id);
  echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}

add_action('init', 'roots_head_cleanup');

/**
 * Remove the WordPress version from RSS feeds
 */
add_filter('the_generator', '__return_false');
/**
 * URL rewriting
 *
 * Rewrites do not happen for multisite installations or child themes
 *
 * Rewrite:
 *   /wp-content/themes/themename/assets/css/ to /assets/css/
 *   /wp-content/themes/themename/assets/js/  to /assets/js/
 *   /wp-content/themes/themename/assets/img/ to /assets/img/
 *   /wp-content/plugins/                     to /plugins/
 *
 * If you aren't using Apache, alternate configuration settings can be found in the docs.
 *
 * @link https://github.com/retlehs/roots/blob/master/doc/rewrites.md
 */
function roots_add_rewrites($content) {
  global $wp_rewrite;
  $roots_new_non_wp_rules = array(
    'assets/css/(.*)'      => THEME_PATH . '/assets/css/$1',
    'assets/js/(.*)'       => THEME_PATH . '/assets/js/$1',
    'assets/img/(.*)'      => THEME_PATH . '/assets/img/$1',
    'plugins/(.*)'         => RELATIVE_PLUGIN_PATH . '/$1'
  );
  $wp_rewrite->non_wp_rules = array_merge($wp_rewrite->non_wp_rules, $roots_new_non_wp_rules);
  return $content;
}

if (current_theme_supports('rewrites')) {
    add_action('generate_rewrite_rules', 'roots_add_rewrites');
  }

if (!is_admin() && current_theme_supports('rewrites')) {
	$tags = array(
	  'plugins_url',
	  'bloginfo',
	  'stylesheet_directory_uri',
	  'template_directory_uri',
	  'script_loader_src',
	  'style_loader_src'
	);

	add_filters($tags, 'roots_clean_urls');
}
