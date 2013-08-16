<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package headintobootstrap
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link href='http://fonts.googleapis.com/css?family=Bitter:400,700|Source+Sans+Pro:300,400&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Wrap all page content here -->
<div id="wrap" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header container" role="banner">
		<div class="page-header">
          <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        </div>
	</header><!-- #masthead -->

	<div id="main" class="site-main container">
