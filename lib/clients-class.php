<?php
if (!current_user_can('edit_posts') && ! current_user_can('edit_pages') )
{
	return;
}
else 
{
	$url = plugins_url('', __FILE__);
	if(isset($_REQUEST['param']) && isset($_REQUEST['action']))
	{
		if($_REQUEST['param'] == "DeleteCustomer")
		{
			$customerId = intval($_REQUEST['CustomerId']);
			$countBooking = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(BookingId) FROM ' . addBookingTable() . ' where CustomerId =%d', 
					$customerId
				)
			);
			if($countBooking != 0)
			{
				echo  "bookingExist";
			}
			else
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM ".addCustomersTable()." WHERE CustomerId = %d",
						$customerId
					)
				);
			}
			die();
		}
		else if($_REQUEST['param'] == "updatecustomers")
		{
			$CustomerId = intval($_REQUEST['customerHiddenId']);
			$uxEditFirstName=esc_attr($_REQUEST['uxEditFirstName']);
			$uxEditLastName=esc_attr($_REQUEST['uxEditLastName']);
			$uxEditEmailAddress=esc_attr($_REQUEST['uxEditEmailAddress']);
			$uxEditMobileNumber=esc_attr($_REQUEST['uxEditMobileNumber']);
			$uxEditAddress=esc_attr($_REQUEST['uxEditAddress']);
			$uxEditCity=esc_attr($_REQUEST['uxEditCity']);
			$uxEditPostalCode=esc_attr($_REQUEST['uxEditPostalCode']);
			$uxEditCountry=intval($_REQUEST['uxEditCountry']);
			$uxEditComments=esc_attr($_REQUEST['uxEditComments']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE " .addCustomersTable(). " SET CustomerFirstName= %s, CustomerLastName = %s, CustomerEmail = %s,
					CustomerMobile = %s, CustomerAddress=%s, CustomerCity=%s, CustomerZipCode=%s, 
					CustomerCountry=%d, CustomerComments=%s WHERE CustomerId = %d",
					$uxEditFirstName,
					$uxEditLastName,
					$uxEditEmailAddress,
					$uxEditMobileNumber,
					$uxEditAddress,
					$uxEditCity,
					$uxEditPostalCode,
					$uxEditCountry,
					$uxEditComments,
					$CustomerId
				)
			);
		die();
		}
	}
}
?>			