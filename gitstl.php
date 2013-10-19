<?php
/*
Plugin Name: STL Viewer ShortCode
Plugin URI: https://github.com/skjain2/WP-STL-Shortcodes
Description: Adds shortcode to you to embed Github and SketchFab STL viewers into Wordpress posts and pages. Copy to your plugins directory and activate manually, for now.
Version: 0.1
Author: Shashi Jain
Author URI: https://github.com/skjain2/
License: GPL2
*/


add_shortcode("ghstl", "github_stl_handler");
add_shortcode("sketchfab", "sketchfab_stl_handler");

function github_stl_handler($atts) {
  //run function that actually does the work of the plugin
  $embed_gh_stl_output = github_stl_function($atts);
  //send back text to replace shortcode in post
  return $embed_gh_stl_output;
}

function github_stl_function($atts) {
   extract(shortcode_atts(array(
      'path' => "/",
      'width' => 400,
      'height' => 400,
   ), $atts));

   $output = '<script src="https://embed.github.com/view/3d' . sanitize_gh($path) . '?height='. $height . '&width='. $width . '"></script>';
   return $output;
}

function sanitize_gh($path) {
	//Path is of the form https://github.com/<username>/<folder>/blob/<branch>/<filename>
	//We need to strip the front of the URL and blob
	$output = "";
	try {
		//strip everything until the username
		$pos = strpos($path, '.com');
		$txt = substr($path, $pos+4);

		//remove "blob/"
		$output = preg_replace('/blob\//','', $txt);
	} catch (Exception $e) {
		echo 'Caught Exception';
	}
	return $output;
}

function sketchfab_stl_handler($atts) {
  //run function that actually does the work of the plugin
  $embed_sf_stl_output = sketchfab_stl_function($atts);
  //send back text to replace shortcode in post
  return $embed_sf_stl_output;
}

function sketchfab_stl_function($atts) {
   extract(shortcode_atts(array(
      'path' => "/",
      'width' => 400,
      'height' => 400,
   ), $atts));

   $output = '<iframe frameborder="0" height="' . $height . '" width="' . $width . '" allowFullScreen webkitallowfullscreen="true" mozallowfullscreen="true" src="' . sanitize_sf($path) . '?autostart=1&transparent=1&autospin=1&controls=1"></iframe>';
   return $output;
}

function sanitize_sf($path) {
	//Path is of the form https://github.com/<username>/<folder>/blob/<branch>/<filename>
	//We need to strip the front of the URL and blob
	$output = "";
	try {
		//replace "show/"
		$output = preg_replace('/show/','embed', $path);
	} catch (Exception $e) {
		echo 'Caught Exception';
	}
	return $output;
}

?>
