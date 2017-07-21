<?php
/*Plugin Name: Events Handler
 Plugin URI: http://wordpress.org/extend/plugins/events-handler/
 Description: Events Handler is a highly configurable product which allows you to have multiple organized events.
 Author: wp-chd-developer
 Version: 1.4
 Author URI: http://wordpress.org/extend/plugins/events-handler/
 */

 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//   D e f i n e     CONSTANTS              //////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if (!defined('EBM_DEBUG_MODE'))		define('EBM_DEBUG_MODE',  false );
	if (!defined('EBM_BK_FILE'))		define('EBM_BK_FILE',  __FILE__ );
	if (!defined('EBM_CONTENT_DIR'))      define('EBM_CONTENT_DIR', ABSPATH . 'wp-content');
	if (!defined('EBM_CONTENT_URL'))      define('EBM_CONTENT_URL', site_url() . '/wp-content');
	if (!defined('EBM_PLUGIN_DIR'))       define('EBM_PLUGIN_DIR', EBM_CONTENT_DIR . '/plugins');
	if (!defined('EBM_PLUGIN_URL'))       define('EBM_PLUGIN_URL', EBM_CONTENT_URL . '/plugins');
	if (!defined('EBM_BK_PLUGIN_FILENAME'))  define('EBM_BK_PLUGIN_FILENAME',  basename( __FILE__ ) );
	if (!defined('EBM_BK_PLUGIN_DIRNAME'))   define('EBM_BK_PLUGIN_DIRNAME',  plugin_basename(dirname(__FILE__)) );
	if (!defined('EBM_BK_PLUGIN_DIR')) define('EBM_BK_PLUGIN_DIR', EBM_PLUGIN_DIR.'/'.EBM_BK_PLUGIN_DIRNAME );
	if (!defined('EBM_BK_PLUGIN_URL')) define('EBM_BK_PLUGIN_URL', site_url().'/wp-content/plugins/'.EBM_BK_PLUGIN_DIRNAME );
	if (!defined('events')) define('events', 'events_handler');

if(file_exists(EBM_BK_PLUGIN_DIR. '/lib/event-handler-class.php'))           // C L A S S    B o o k i n g
{
	 require_once(EBM_BK_PLUGIN_DIR. '/lib/event-handler-class.php');
}
function plugin_install_script()
{
	include_once EBM_BK_PLUGIN_DIR .'/install-script.php';	
}
function plugin_delete_script()
{
	include_once EBM_BK_PLUGIN_DIR .'/uninstall-script.php';
}
function plugin_load_textdomain() 
{
	 if( function_exists( 'load_plugin_textdomain' ) )
	 {
	  load_plugin_textdomain(events, false, EBM_BK_PLUGIN_DIRNAME .'/languages');
	 }
}
add_action('plugins_loaded', 'plugin_load_textdomain');
register_activation_hook(__FILE__,'plugin_install_script');
register_uninstall_hook(__FILE__,'plugin_delete_script');
?>