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
            <img data-guid="'. $shortcode_attributes['guid'] .'" class="his-youtube-thumb" src="http://img.youtube.com/vi/'. $shortcode_attributes['guid'] .'/hqdefault.jpg" alt="" />
            <div class="his-youtube-play">
                <svg class="html5-big-play-button html5-center-overlay html5-scalable-icon" data-guid="'.$shortcode_attributes['guid'].'"><path fill="#380308" d="M89.2,34.4c-0.064,2.649-0.265,5.434-0.6,8.35c-0.467,3.733-1.05,6.867-1.75,9.4c-1.4,5.133-4.4,8.184-9,9.149c-3.533,0.733-7.6,1.217-12.2,1.45c-4.033,0.233-9.867,0.35-17.5,0.35H40.1c-10.567,0-20.133-0.6-28.7-1.8c-4.467-0.667-7.467-3.716-9-9.149c-0.7-2.533-1.267-5.667-1.7-9.4c-0.361-2.916-0.578-5.699-0.65-8.35c0.122,2.316,0.338,4.733,0.65,7.25c0.433,3.732,1,6.866,1.7,9.399c1.533,5.435,4.533,8.483,9,9.15c8.567,1.2,18.133,1.8,28.7,1.8h8.05c7.633,0,13.467-0.117,17.5-0.35c4.6-0.233,8.667-0.718,12.2-1.45c4.6-0.967,7.6-4.018,9-9.15c0.7-2.533,1.283-5.667,1.75-9.399C88.89,39.134,89.089,36.717,89.2,34.4z"></path><path class="html5-overlay-button-background" d="M86.85,10.9c0.7,2.532,1.283,5.684,1.75,9.449c0.433,3.733,0.65,7.268,0.65,10.601V31c0,3.333-0.217,6.883-0.65,10.65c-0.467,3.732-1.05,6.866-1.75,9.399c-1.4,5.133-4.4,8.185-9,9.15c-3.533,0.732-7.6,1.216-12.2,1.45C61.617,61.883,55.783,62,48.15,62H40.1c-10.567,0-20.133-0.6-28.7-1.8c-4.467-0.667-7.467-3.717-9-9.15c-0.7-2.533-1.267-5.667-1.7-9.399C0.233,37.883,0,34.333,0,31v-0.05c0-3.333,0.233-6.867,0.7-10.601c0.433-3.767,1-6.917,1.7-9.449c1.4-5.134,4.4-8.184,9-9.15c3.5-0.7,7.567-1.183,12.2-1.45C27.533,0.1,33.367,0,41.1,0h8.05c10.8,0,20.367,0.583,28.7,1.75C82.317,2.417,85.317,5.467,86.85,10.9z"></path><g viewBox="-15.025 -15.151 30.05 30.303" transform="matrix(1 0 0 -1 47.375 29.75)"><path fill="#FCFCFC" d="M10.275,4c3.167-1.866,4.75-3.199,4.75-4c0-0.8-1.583-2.149-4.75-4.05 c-1.367-0.8-4.517-2.482-9.45-5.05c-4.5-2.333-7.233-3.733-8.2-4.2c-2.533-1.232-4.066-1.85-4.6-1.85 c-1.233-0.033-2.083,0.399-2.55,1.3c-0.333,0.667-0.5,1.75-0.5,3.25v21.2c0,1.5,0.167,2.583,0.5,3.25 c0.467,0.899,1.317,1.333,2.55,1.3c0.534,0,2.067-0.617,4.6-1.85c0.967-0.468,3.7-1.867,8.2-4.2C5.758,6.533,8.908,4.833,10.275,4 z"></path></g><defs><linearGradient id="html5-big-play-button-red" gradientUnits="userSpaceOnUse" x1="44.625" y1="0" x2="44.625" y2="62"><stop offset="0" style="stop-color:#CD332D"></stop><stop offset="0.8549" style="stop-color:#6E0610"></stop></linearGradient><linearGradient id="html5-big-play-button-black" gradientUnits="userSpaceOnUse" x1="44.625" y1="0" x2="44.625" y2="62"><stop offset="0" style="stop-color:#3E3D3D"></stop><stop offset="0.7451" style="stop-color:#131313"></stop></linearGradient></defs></svg>
            </div>
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
