<?php
//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CREATING MENUS
//---------------------------------------------------------------------------------------------------------------//
function MenusForEventsHandler()
{
	global $wpdb;
	$license = $wpdb->get_var
	(
		$wpdb->prepare
		(	
			'SELECT SettingsValue FROM ' . settingTable() . ' where SettingsKey = %s',
			"events_handler_api"
		)
	);
	if($license == "")
	{
		$menu = add_menu_page('Events Handler', __('Events Handler', events), 'administrator', 'eventshandler','',EBM_BK_PLUGIN_URL . '/events-16.png');
		$submenu1 = add_submenu_page('Events Handler', 'Events Handler', __('Events Handler', events), 'administrator', 'eventshandler', 'eventshandler');
		$submenu2 = add_submenu_page('eventshandler', 'Bookings', __('Bookings', events), 'administrator', 'bookings', 'bookings');
		$submenu7 = add_submenu_page('eventshandler', 'Calendar', __('Calendar', events), 'administrator', 'calendar', 'calendar');
		$submenu4 = add_submenu_page( 'eventshandler', 'Tickets', __('Tickets', events), 'administrator', 'tickets', 'tickets');
		$submenu9 = add_submenu_page( 'eventshandler', 'Customers', __('Customers', events), 'administrator', 'customers', 'customers');
		$submenu15 = add_submenu_page( 'eventshandler', 'Short Codes', __('Short Codes', events), 'administrator', 'shortcode', 'shortcode');
		$submenu5 = add_submenu_page( 'eventshandler', 'Settings', __('Settings', events), 'administrator', 'settings', 'settings');
		$submenu6 = add_submenu_page( '', '', '', 'administrator', 'booking', 'booking');
		$submenu8 = add_submenu_page( '', '', '', 'administrator', 'add_event', 'add_event');
		$submenu10 = add_submenu_page( '', '', '', 'administrator', 'add_ticket', 'add_ticket');
		$submenu11 = add_submenu_page( '', '','', 'administrator', 'editticket', 'editticket');
		$submenu12 = add_submenu_page( '', '', '', 'administrator', 'edit_event', 'edit_event');
		$submenu16 = add_submenu_page( '', '', '', 'administrator', 'bookingdetails', 'bookingdetails');
		$submenu17 = add_submenu_page( 'eventshandler', 'API Key', __('API Key', events), 'administrator', 'apikey', 'apikey');
	}
	else 
	{
		
		$menu = add_menu_page('Events Handler', __('Events Handler', events), 'administrator', 'eventshandler','',EBM_BK_PLUGIN_URL . '/events-16.png');
		$submenu1 = add_submenu_page('Events Handler', 'Events Handler', __('Events Handler', events), 'administrator', 'eventshandler', 'eventshandler');
		$submenu2 = add_submenu_page('eventshandler', 'Bookings', __('Bookings', events), 'administrator', 'bookings', 'bookings');
		$submenu7 = add_submenu_page('eventshandler', 'Calendar', __('Calendar', events), 'administrator', 'calendar', 'calendar');
		$submenu4 = add_submenu_page( 'eventshandler', 'Tickets', __('Tickets', events), 'administrator', 'tickets', 'tickets');
		$submenu9 = add_submenu_page( 'eventshandler', 'Customers', __('Customers', events), 'administrator', 'customers', 'customers');
		$submenu15 = add_submenu_page( 'eventshandler', 'Short Codes', __('Short Codes', events), 'administrator', 'shortcode', 'shortcode');
		$submenu5 = add_submenu_page( 'eventshandler', 'Settings', __('Settings', events), 'administrator', 'settings', 'settings');
		$submenu6 = add_submenu_page( '', '', '', 'administrator', 'booking', 'booking');
		$submenu8 = add_submenu_page( '', '', '', 'administrator', 'add_event', 'add_event');
		$submenu10 = add_submenu_page( '', '', '', 'administrator', 'add_ticket', 'add_ticket');
		$submenu11 = add_submenu_page( '', '','', 'administrator', 'editticket', 'editticket');
		$submenu12 = add_submenu_page( '', '', '', 'administrator', 'edit_event', 'edit_event');
		$submenu16 = add_submenu_page( '', '', '', 'administrator', 'bookingdetails', 'bookingdetails');
	}
}
//--------------------------------------------------------------------------------------------------------------//
//CODE FOR CALLING JAVASCRIPT FUNCTIONS
//--------------------------------------------------------------------------------------------------------------//
function events_handler_js_scripts()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap.min.js', EBM_BK_PLUGIN_URL .'/js/bootstrap.min.js');
	wp_enqueue_script('bootstrap-bootbox.min.js', EBM_BK_PLUGIN_URL .'/js/bootstrap-bootbox.min.js');
	wp_enqueue_script('jquery.fullcalendar.min.js', EBM_BK_PLUGIN_URL .'/js/jquery.fullcalendar.min.js');
	wp_enqueue_script('colorbox.js', EBM_BK_PLUGIN_URL .'/js/jquery.colorbox-min.js');
	wp_enqueue_script('jquery.datatables.js', EBM_BK_PLUGIN_URL .'/js/jquery.datatables.js');
	wp_enqueue_script('colorpicker.js', EBM_BK_PLUGIN_URL .'/js/colorpicker.js');
	wp_enqueue_script('validate.js', EBM_BK_PLUGIN_URL .'/js/jquery.validate.min.js');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-core');
}
//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CALLING STYLE SHEETS
//--------------------------------------------------------------------------------------------------------------//
function events_handler_css_scripts()
{
	wp_enqueue_style('bootstrap.css', EBM_BK_PLUGIN_URL .'/css/bootstrap.css');
	wp_enqueue_style('datatables.css', EBM_BK_PLUGIN_URL .'/css/datatables.css');
	wp_enqueue_style('menu.css', EBM_BK_PLUGIN_URL .'/css/menu.css');
	wp_enqueue_style('style.css', EBM_BK_PLUGIN_URL .'/css/style.css');
	wp_enqueue_style('plugins.css', EBM_BK_PLUGIN_URL . '/css/plugins.css');
	wp_enqueue_style('colorbox.css', EBM_BK_PLUGIN_URL .'/css/colorbox.css');
	wp_enqueue_style('forms.css', EBM_BK_PLUGIN_URL .'/css/forms.css');
	wp_enqueue_style('colorpicker.css', EBM_BK_PLUGIN_URL .'/css/colorpicker.css');
	wp_enqueue_style('jquery-style', EBM_BK_PLUGIN_URL .'/css/jquery-ui.css');
}
//--------------------------------------------------------------------------------------------------------------//
// FUNCTIONS FOR REPLACING TABLE NAMES
//--------------------------------------------------------------------------------------------------------------//
function  addEventTable()
{
	global $wpdb;
	return $wpdb->prefix . 'eh_add_event';
}
function addTicketTable()
{
	global $wpdb;
	return $wpdb->prefix . 'eh_add_tickets';
}
function addBookingTable()
{
	global $wpdb;
	return $wpdb->prefix . 'eh_add_booking';
}
function locationTable()
{
	global $wpdb;
	return $wpdb->prefix. 'eh_location';
}
function all_country_listTable()
{
	global $wpdb;
	return $wpdb->prefix. 'eh_countries';
}
function settingTable()
{
	global $wpdb;
	return $wpdb->prefix. 'eh_settings';
}
function all_currency_listTable()
{
	global $wpdb;
	return $wpdb->prefix. 'eh_currency';
}
function addCustomersTable()
{
	global $wpdb;
	return $wpdb->prefix. 'eh_add_customers';
}
function addMultipleBookingsTable()
{
	global $wpdb;
	return $wpdb->prefix. 'eh_multiple_bookings';
}
function templatesTable()
{
	global $wpdb;
	return $wpdb->prefix. 'eh_templates';
}
//--------------------------------------------------------------------------------------------------------------//
// FUNCTIONS TO BE CALLED ON RESPECTIVE MENUS
//--------------------------------------------------------------------------------------------------------------//
function eventshandler()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/events.php';
	
}
function bookings()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/booking.php';
	
}

function tickets()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/ticket.php';
}
function settings()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/setting.php';
}
function calendar()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/bookings_fullcalendar.php';
}
function booking()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/addBooking.php';
}
function add_event()
{
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/add_event.php';
	
}
function customers()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/clients.php';
	
}
function add_ticket()
{
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/addticket.php';
	
}
function editticket()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/editticket.php';
	
}
function edit_event()
{
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/editEvent.php';
}

function shortcode()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/shortcode.php';
	
}

function bookingdetails()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	checkApiKey();
	include_once EBM_BK_PLUGIN_DIR .'/views/bookings_detail.php';
	
}
function apikey()
{
	
	include_once EBM_BK_PLUGIN_DIR .'/header.php';
	include_once EBM_BK_PLUGIN_DIR .'/menus.php';
	include_once EBM_BK_PLUGIN_DIR .'/views/api_key.php';
	
}


//--------------------------------------------------------------------------------------------------------------//
// REGISTER AJAX BASED FUNCTIONS TO BE CALLED ON ACTION TYPE AS PER WORDPRESS GUIDELINES
//--------------------------------------------------------------------------------------------------------------//

if(isset($_REQUEST['action']))
{
	
	switch($_REQUEST['action'])
	{
		// To be Called on Service Related Executions
		case "ticketsLibrary":
		add_action( 'admin_init', 'ticketsLibrary');
		function ticketsLibrary()
		{
			global $wpdb;
			include_once EBM_BK_PLUGIN_DIR . '/lib/ticket-class.php';
		}
		break;
		case "bookLibrary":
	
		add_action( 'admin_init', 'bookLibrary');
		
		function bookLibrary()
		{
			
			global $wpdb;
			include_once EBM_BK_PLUGIN_DIR . '/lib/booking-class.php';
		}
		break;
		case "eventsLibrary":
		add_action( 'admin_init', 'eventsLibrary');
		function eventsLibrary()
		{
			
			global $wpdb;
			include_once EBM_BK_PLUGIN_DIR . '/lib/event-class.php';
		}
		break;
		case "settingLibrary":
		add_action( 'admin_init', 'settingLibrary');
		function settingLibrary()
		{
			global $wpdb;
			include_once EBM_BK_PLUGIN_DIR . '/lib/setting-class.php';
		}
		break;
		
		case "menuLibrary":
		add_action( 'admin_init', 'menuLibrary');
		function menuLibrary()
		{
			global $wpdb;
			include_once EBM_BK_PLUGIN_DIR . '/lib/menus-class.php';
		}
		break;
		case "fullCalLibrary":
		add_action( 'admin_init', 'fullCalLibrary');
		function fullCalLibrary()
		{
			global $wpdb;
			include_once EBM_BK_PLUGIN_DIR . '/lib/bookings_fullcalendar-class.php';
		}
		break;
		case "clientLibrary":
		add_action( 'admin_init', 'clientLibrary');
		function clientLibrary()
		{
			global $wpdb;
			include_once EBM_BK_PLUGIN_DIR . '/lib/clients-class.php';
		}
		break;
		case "monthlycalendarLibrary":
		add_action( 'admin_init', 'monthlycalendarLibrary');
		function monthlycalendarLibrary()
		{
			global $wpdb;
			include_once EBM_BK_PLUGIN_DIR . '/lib/front_end_fullcalendar-class.php';
		}
		break;
		case "apikeyLibrary":
		add_action( 'admin_init', 'apikeyLibrary');
		function apikeyLibrary()
		{
			global $wpdb;
			include_once EBM_BK_PLUGIN_DIR . '/lib/api_key-class.php';
		}
		break;
		
		// To be Called on Exceptions Related Executions 
	}
}
//--------------------------------------------------------------------------------------------------------------//
// SHORTCODE
//--------------------------------------------------------------------------------------------------------------//

global $wpdb;
$count_bookings = $wpdb->get_var
(
	$wpdb->prepare
	(
		"SELECT count(BookingId) FROM " . addBookingTable(),""
	)
);
if($count_bookings < 5)
{
	function event_handler_shortcode() 
	{
		return extract_ShortCodes();
	}
	function extract_ShortCodes() 
	{
		?>
		<div style="display:block">
			<div id="show_allevents">
				<div class="body">
					<?php include_once EBM_BK_PLUGIN_DIR.'/views/front_end_fullcalendar.php' ?>
				</div> 
			</div>	
		</div>
		
		<?php
	}
}
if($count_bookings < 5)
{
	function event_handler_shortcode1() 
	{
		return extract_ShortCodes1();
	}
	function extract_ShortCodes1() 
	{
		?>
		<div style="display:block">
			<div id="show_allevents">
				<div class="body">
					<?php include_once EBM_BK_PLUGIN_DIR.'/views/events_show.php' ?>
				</div> 
			</div>	
		</div>
		
		<?php
	}
}
if($count_bookings < 5)
{
	function event_handler_shortcode2($atts) 
	{
		extract(shortcode_atts(array(
		"event_id" => '',
		), $atts));
		return extract_ShortCodes2($event_id);
	}
	function extract_ShortCodes2($event_id) 
	{
		
	?>
		<div style="display:block">
			<div id="show_allevents">
				<div class="body">
					<?php include_once  EBM_BK_PLUGIN_DIR.'/views/event_details.php'; ?>
				</div> 
			</div> 
		</div>
	<?php
	}
}
//--------------------------------------------------------------------------------------------------------------//
// GLOBAL HOOOKS
//--------------------------------------------------------------------------------------------------------------//
add_action('admin_menu','MenusForEventsHandler');
add_action('init','events_handler_js_scripts');
add_action('init','events_handler_css_scripts');
add_shortcode('events_handler_full_calendar', 'event_handler_shortcode' );
add_shortcode('events_handler_table_display', 'event_handler_shortcode1' );
add_shortcode('events_handler', 'event_handler_shortcode2' );

function checkApiKey()
{
	global $wpdb;
	$license = $wpdb->get_var
	(
		$wpdb->prepare
		(	
			'SELECT SettingsValue FROM ' . settingTable() . ' where SettingsKey = %s',
			"events_handler_api"
		)
	);
	if($license == "")
	{
		?>
		<script type="text/javascript">
			window.location.href = "admin.php?page=apikey";
		</script>
		<?php
	}
	else 
	{
		?>
		<script type="text/javascript">
			jQuery("#APIkey").attr("style","display:none");
		</script>
		<?php
	}
}
?>