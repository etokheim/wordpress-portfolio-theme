<?php
/**
 * Tokheim grafisk functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Tokheim_grafisk
 */


/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
# Text here
# Text here
	## Text here
--------------------------------------------------------------*/


if ( ! function_exists( 't_fisk_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function t_fisk_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Tokheim grafisk, use a find and replace
	 * to change 't_fisk' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 't_fisk', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title-tagle.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	// From DOCS: add_image_size( string $name, int $width, int $height, bool|array $crop = false )
	update_option("thumbnail_size_w", 150);
	update_option("thumbnail_size_h", 150);
	update_option("thumbnail_crop", false);

	update_option("medium_size_w", 500);
	update_option("medium_size_h", 500);
	update_option("medium_crop", 1);

	update_option("large_size_w", 1000);
	update_option("large_size_h", 1000);
	update_option("large_crop", false);

	add_image_size( 'extra_small_screens_portrait', 1920, 1080, true );
	// add_image_size( 'small_screens_landscape', 1920, 1080, true );
	add_image_size( 'medium_screens_landscape', 1920, 1080, true );
	add_image_size( 'large_screens_landscape', 3840, 2160, true );
	
	add_image_size( 'logo', 600, 200, false );
	add_image_size( 'other_projects', 520, 310, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 't_fisk' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'gallery',
		'link',
		'image',
		'quote',
		'status',
		'video',
		'audio',
		'chat',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 't_fisk_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Support for custom logo
	add_theme_support( 'custom-logo' );

	// adds support for custom excerpts to pages
	function t_fisk_add_excerpts_to_pages() {
	     add_post_type_support( 'page', 'excerpt' );
	}
	add_action( 'init', 't_fisk_add_excerpts_to_pages' );
}
endif;
add_action( 'after_setup_theme', 't_fisk_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function t_fisk_content_width() {
	$GLOBALS['content_width'] = apply_filters( 't_fisk_content_width', 640 );
}
add_action( 'after_setup_theme', 't_fisk_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function t_fisk_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 't_fisk' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 't_fisk' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 't_fisk_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function t_fisk_scripts() {
	// Loading style.css
	wp_enqueue_style( 't_fisk-style', get_stylesheet_uri() );

	wp_enqueue_script( 't_fisk-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 't_fisk-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 't_fisk_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';




/*--------------------------------------------------------------
# t-fisk custom stuff :3
--------------------------------------------------------------*/
// Custom logo
function add_custom_logo() {
	
	add_theme_support( 'custom-logo', array(
		'height'      => 50,
		'width'       => 150,
		'flex-height' => true,
	) );
}
add_action( 'after_setup_theme', 'add_custom_logo' );






// Custom styling in the editor. Like paragraph styling if you want - or a button
// check out http://www.wpbeginner.com/wp-tutorials/how-to-add-custom-styles-to-wordpress-visual-editor/

// function wpb_mce_buttons_2($buttons) {
// 	array_unshift($buttons, 'styleselect');
// 	return $buttons;
// }
// add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

// /*
// * Callback function to filter the MCE settings
// */

// function my_mce_before_init_insert_formats( $init_array ) {  

// // Define the style_formats array

// 	$style_formats = array(  
// 		// Each array child is a format with it's own settings
// 		array(  
// 			'title' => 'Content Block',  
// 			'block' => 'span',  
// 			'classes' => 'content-block',
// 			'wrapper' => true,
			
// 		),  
// 		array(  
// 			'title' => 'Blue Button',  
// 			'block' => 'span',  
// 			'classes' => 'blue-button',
// 			'wrapper' => true,
// 		),
// 		array(  
// 			'title' => 'Red Button',  
// 			'block' => 'span',  
// 			'classes' => 'red-button',
// 			'wrapper' => true,
// 		),
// 	);  
// 	// Insert the array, JSON ENCODED, into 'style_formats'
// 	$init_array['style_formats'] = json_encode( $style_formats );  
	
// 	return $init_array;  
  
// } 
// // Attach callback to 'tiny_mce_before_init' 
// add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 














/*--------------------------------------------------------------
----------------------------------------------------------------
----------------------------------------------------------------
----------------------------------------------------------------

# PLUG-IN TIME

----------------------------------------------------------------
----------------------------------------------------------------
----------------------------------------------------------------
--------------------------------------------------------------*/






/*--------------------------------------------------------------
# Multiple Post Thumbnails
--------------------------------------------------------------*/
if (class_exists('MultiPostThumbnails')) {
	new MultiPostThumbnails([
		'label' => 'Employer\'s logo',
		'id' => 'employers-logo',
		'post_type' => 'post'
	] );
}


/*--------------------------------------------------------------
# Plugin Manager
--------------------------------------------------------------*/
/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/plug-ins/TGM-Plugin-Activation-2.6.1/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 't_fisk_RequiredPluginsManager_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function t_fisk_RequiredPluginsManager_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = [

		// This is an example of how to include a plugin bundled with a theme.
		// array(
		// 	'name'               => 'TGM Example Plugin', // The plugin name.
		// 	'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
		// 	'source'             => get_template_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
		// 	'required'           => true, // If false, the plugin is only 'recommended' instead of required.
		// 	'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
		// 	'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		// 	'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		// 	'external_url'       => '', // If set, overrides default API URL and points to an external URL.
		// 	'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		// ),

		// This is an example of how to include a plugin from an arbitrary external source in your theme.
		// array(
		// 	'name'         => 'TGM New Media Plugin', // The plugin name.
		// 	'slug'         => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
		// 	'source'       => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
		// 	'required'     => true, // If false, the plugin is only 'recommended' instead of required.
		// 	'external_url' => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
		// ),

		// This is an example of how to include a plugin from a GitHub repository in your theme.
		// This presumes that the plugin code is based in the root of the GitHub repository
		// and not in a subdirectory ('/src') of the repository.
		// array(
		// 	'name'      => 'Adminbar Link Comments to Pending',
		// 	'slug'      => 'adminbar-link-comments-to-pending',
		// 	'source'    => 'https://github.com/jrfnl/WP-adminbar-comments-to-pending/archive/master.zip',
		// ),

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		// array(
		// 	'name'      => 'BuddyPress',
		// 	'slug'      => 'buddypress',
		// 	'required'  => false,
		// ),

		// This is an example of the use of 'is_callable' functionality. A user could - for instance -
		// have WPSEO installed *or* WPSEO Premium. The slug would in that last case be different, i.e.
		// 'wordpress-seo-premium'.
		// By setting 'is_callable' to either a function from that plugin or a class method
		// `array( 'class', 'method' )` similar to how you hook in to actions and filters, TGMPA can still
		// recognize the plugin as being installed.
		array(
			'name'        => 'WordPress SEO by Yoast',
			'slug'        => 'wordpress-seo',
			'is_callable' => 'wpseo_init',
		),

		[
			"name"			=> "Multiple Post Thumbnails",
			"slug"			=> "multiple-post-thumbnails",
			"required"		=> true,
		],
		
		[
			"name"			=> "Dynamic Featured Image",
			"slug"			=> "dynamic-featured-image",
			"required"		=> true,
		],

	];

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => '1', // Når du legg til noko nytt, oppdater ID (+1). Då må mottakarane avslå meldinga ein gong til for at den ikkje skal synast.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 't_fisk' ),
			'menu_title'                      => __( 'Install Plugins', 't_fisk' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 't_fisk' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 't_fisk' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 't_fisk' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				't_fisk'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				't_fisk'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				't_fisk'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				't_fisk'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				't_fisk'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				't_fisk'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				't_fisk'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				't_fisk'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				't_fisk'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 't_fisk' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 't_fisk' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 't_fisk' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 't_fisk' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 't_fisk' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 't_fisk' ),
			'dismiss'                         => __( 'Dismiss this notice', 't_fisk' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 't_fisk' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 't_fisk' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}
