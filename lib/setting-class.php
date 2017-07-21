<?php
global $wpdb;
if (!current_user_can('edit_posts') && ! current_user_can('edit_pages') )
{
	return;
}
else
{
	if(isset($_REQUEST["param"]))
	{
		if($_REQUEST["param"] == "updateSetting")
		{
			$uxcurrency = esc_attr($_REQUEST["uxcurrency"]);
			$uxCountry = esc_attr($_REQUEST["uxCountry"]);
			$uxTimeFormat = esc_attr($_REQUEST["uxTimeFormat"]);
			$uxDateFormat = esc_attr($_REQUEST["uxDateFormat"]);
			$default_Time_Zone = esc_attr($_REQUEST["uxDefaultTimeZone"]);
			$PaypalEnableCheck = intval($_REQUEST['uxPayPal']);
			$PaypalUrlCheck = esc_attr($_REQUEST['uxPayPalurl']);
			$uxMerchantEmailAddress = esc_attr($_REQUEST['uxMerchantEmailAddress']);
			$uxThankyouPageUrl = esc_attr($_REQUEST['uxThankyouPageUrl']);
			$uxIPNUrl = esc_attr($_REQUEST['uxIPNUrl']);
			$uxPaymentCancellationUrl = esc_attr($_REQUEST['uxCancellationUrl']);
			$uxEvent = intval($_REQUEST['uxEvent']);
			$uxAuto = intval($_REQUEST['uxAuto']);
			$ux_admin_email= esc_attr($_REQUEST['ux_admin_email']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".all_currency_listTable()." SET CurrencyUsed = %d  WHERE CurrencyName = %s",
					1,
					$uxcurrency
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".all_currency_listTable()." SET CurrencyUsed = %d  WHERE CurrencyName != %s",
					0,
					$uxcurrency
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".all_country_listTable()." SET CountryUsed = %d where CountryId = %d",
					1,
					$uxCountry
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".all_country_listTable()." SET CountryUsed = %d where CountryId != %d",
					0,
					$uxCountry
				)
			);	
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable(). " SET SettingsValue = %d  WHERE SettingsKey = %s",
					$uxTimeFormat,
					"default_Time_Format"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable(). " SET SettingsValue = %d  WHERE SettingsKey = %s",
					$uxDateFormat,
					"default_Date_Format"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable()." SET SettingsValue = %s  WHERE SettingsKey = %s",
					$default_Time_Zone,
					"default_Time_Zone"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable()." SET SettingsValue = %s WHERE SettingsKey = %s",
					$PaypalEnableCheck,
					"paypal-enabled"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable()." SET SettingsValue = %s WHERE SettingsKey = %s",
					$uxMerchantEmailAddress,
					"paypal-merchant-email-address"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable()." SET SettingsValue = %s WHERE SettingsKey = %s",
					$uxThankyouPageUrl,
					"paypal-thankyou-page-url"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable()." SET SettingsValue = %s WHERE SettingsKey = %s",
					$uxIPNUrl,
					"paypal-ipn-url"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable()." SET SettingsValue = %s WHERE SettingsKey = %s",
					$uxPaymentCancellationUrl,
					"paypal-payment-cancellation-Url"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable()." SET SettingsValue = %s WHERE SettingsKey = %s",
					$PaypalUrlCheck,
					"paypal-Test-Url"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable()." SET SettingsValue = %s WHERE SettingsKey = %s",
					$uxEvent,
					"event_booking_status"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable()." SET SettingsValue = %s WHERE SettingsKey = %s",
					$uxAuto,
					"auto_approve_status"
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE ".settingTable()." SET SettingsValue = %s WHERE SettingsKey = %s",
					$ux_admin_email,
					"admin_email"
				)
			);
			
			die();
		}
		else if($_REQUEST['param'] == "RestoreFactory")
		{
			include_once EBM_BK_PLUGIN_DIR . '/EventsHandler.php';
			plugin_delete_script();
			plugin_install_script();
			die();
		}
		else if($_REQUEST['param'] == "DeleteAllBooking")
		{
			$wpdb->query
			(
				$wpdb->prepare
				(
					"TRUNCATE Table ".addBookingTable(),""
				)
			);
			
			die();
		}
	}
}
?>