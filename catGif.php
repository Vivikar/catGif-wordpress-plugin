<?php

/**
 * 
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://maiamaster.udg.edu/
 * @since             0.0.1
 * @package           CatGif
 *
 * @wordpress-plugin
 * Plugin Name:       CatGif Helper
 * Plugin URI:        https://maiamaster.udg.edu/
 * Description:       This is a simple plugin to send cute cat gifs.
 * Version:           0.0.1
 * Author:            Your Name or Your Company
 * Author URI:        https://github.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       catGif
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '0.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-catGif-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-catGif-activator.php';
	Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-catGif-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-catGif-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-catGif.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

 // Allowing users to embed iframe objects in wordpress
global $allowedtags;
$allowedtags["iframe"] = array(
   "src" => array(),
   "height" => array(),
   "width" => array(),
   "frameBorder" => array(),
   "class" => array(),
   
  );

// DISPLAY SEND GIF BUTTON

// TODO: Change func's logic to display "Send CatGif" button and link it to the gif
// class that makes requests to giphy and retrieves gif ids and then passes it to another 
// function below to display them
function add_send_cat_gif_button( $post_id ) {
    echo '<p class="comment-form-more-comments"><label for="more-comments">' . __( 'More Comments', 'your-theme-text-domain' ) . '</label> <textarea id="more-comments" name="more-comments" cols="45" rows="8" aria-required="true"></textarea></p>';
}
 
add_action( 'comment_form', 'add_send_cat_gif_button' );


// SEND GIF INSTEAD OF THE COMMENT
$GIF_ID = "ICOgUNjpvO0PC"; // BzyTuYCmvSORqs1ABM
$GIF_IFRAME_PATTERN = "<iframe src=\"https://giphy.com/embed/$GIF_ID\" width=\"480\" height=\"359\" frameBorder=\"0\" class=\"giphy-embed\" allowFullScreen></iframe>";

// TODO: Transmit gif ids from the classes/functions that do requests to this function
function send_gif_as_comment( $commentdata ) {
   // NEEDS TO ADRESS A GLOBAL VARIABLE TO SEE IT
   global $GIF_IFRAME_PATTERN;

   // TODO: Change if condition to button 'Send CatGif' pressed or smth
   if (str_contains($commentdata['comment_content'], "cat"))
   {
      $commentdata['comment_content'] = $GIF_IFRAME_PATTERN;
   }
   return $commentdata;
}
add_filter( 'preprocess_comment' , 'send_gif_as_comment' );

// DISABLE WORDPRESS FLOOD FILTER TO BE ABLE TO POST MORE COMMENTS MORE FREQUENTLY
// AND POST SAME COMMENTS
add_filter('comment_flood_filter', '__return_false');
add_filter('duplicate_comment_id', '__return_false');
