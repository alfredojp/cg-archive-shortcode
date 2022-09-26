<?php
/**
 * Initializes the plugin
 *
 * @package      CG\Capgemini_Archive_Shortcode
 * @author       Capgemini GIT
 * @copyright    Capgemini GIT
 * @license      GPL-2.0-or-later
 */

namespace CG\Capgemini_Archive_Shortcode;

// Required libraries and files
require_once WP_PLUGIN_DIR . '/fieldmanager/fieldmanager.php';
require_once plugin_dir_path( __FILE__ ) . '/src/config/const.php';
require_once plugin_dir_path( __FILE__ ) . '/src/ArchiveShortcode.php';
require_once plugin_dir_path( __FILE__ ) . '/src/ArchiveShortcodeSettings.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory/core/ArchiveShortcodeFactory.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory-templates/core/ArchiveShortcodeTemplate.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory/RniShortcodeFactory.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory-templates/RniShortcodeTemplate.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory/PrShortcodeFactory.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory-templates/PrShortcodeTemplate.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory/EventShortcodeFactory.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory-templates/EventShortcodeTemplate.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory/AnalystShortcodeFactory.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory-templates/AnalystShortcodeTemplate.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory/ClientStoryShortcodeFactory.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory-templates/ClientStoryShortcodeTemplate.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory/BlogShortcodeFactory.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory-templates/BlogShortcodeTemplate.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory/TestimonialShortcodeFactory.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory-templates/TestimonialShortcodeTemplate.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory/LocationShortcodeFactory.php';
require_once plugin_dir_path( __FILE__ ) . '/src/factory-templates/LocationShortcodeTemplate.php';

run();

function run() {
	$settings = new ArchiveShortcodeSettings();
	add_action( 'init', [ $settings, 'register_settings_page' ] );

	add_action( 'init', [ $settings, 'register_shortcodes' ]);

	add_action( 'plugins_loaded', function() {
		load_plugin_textdomain( 'cg-archive-shortcode', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	} );
}
