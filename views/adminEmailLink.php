<?php
	include_once(dirname(dirname(dirname(dirname(dirname( __FILE__ ))))) . '/wp-config.php' );
	include_once 'mailmanagement.php';
	$bookingId = $_GET['id'];
	global $wpdb;
	$bookingDetail = $wpdb->get_row
	(
	 	$wpdb->prepare
	 	(
			"SELECT CONCAT(".addCustomersTable().".CustomerFirstName ,'  ',". addCustomersTable().".CustomerLastName) as CustomerName,".addCustomersTable().".CustomerEmail,".addCustomersTable().".CustomerMobile,
			". addEventTable(). ".EventName,". addEventTable(). ".EventId,". addEventTable(). ".EventTo,".addEventTable().".EventFullDay,".addEventTable().".EventColorCode,".addEventTable().".EventSTotalTime, ".addEventTable().".EventETotalTime,
		   ".addBookingTable().".BookingStartDate ,". addBookingTable().".BookingSTotalTime,". addBookingTable().".BookingId, ". addBookingTable().".PaymentStatus, ". addBookingTable().".TransactionId, 
		   ". addBookingTable().".PaymentDate,". addBookingTable().".BookingStatus FROM ".addBookingTable()." 
		   LEFT OUTER JOIN " .addCustomersTable()." ON ".addBookingTable().".CustomerId= ".addCustomersTable().".CustomerId ". " 
		   LEFT OUTER JOIN " .addEventTable()." ON ".addBookingTable().".EventId=".addEventTable().".EventId where ".addBookingTable().".BookingId =  %d",
		   $bookingId
		)
	);
	$dateFormat = $wpdb->get_var
	(
		$wpdb->prepare
		(
			'SELECT SettingsValue FROM ' . settingTable() . ' where SettingsKey = %s',
			"default_Date_Format"
		)
	);
	if($dateFormat == 0)
	{
	
		$date =  date("M d, Y", strtotime($bookingDetail->BookingStartDate));
	
	}
	else if($dateFormat == 1)
	{
	
		$date =   date("Y/m/d", strtotime($bookingDetail->BookingStartDate));
	
	}	
	else if($dateFormat == 2)
	{
	
		$date =  date("m/d/Y", strtotime($bookingDetail->BookingStartDate));
	
	}	
	else if($dateFormat == 3)
	{
		$date =  date("d/m/Y", strtotime($bookingDetail->BookingStartDate));
	}
	$getHours = floor(($bookingDetail->BookingSTotalTime)/60);
	$getMins = ($bookingDetail->BookingSTotalTime) % 60;
	$hourFormat = $getHours . ":" . "00";
	$timeFormats = $wpdb->get_var
	(
		$wpdb->prepare
		(
			"SELECT SettingsValue FROM ".settingTable()." WHERE SettingsKey = %s",
			'default_Time_Format'
		)
	);
	if($timeFormats == 0)
	{
		$time  = DATE("g:i a", STRTOTIME($hourFormat));
	}
	else 
	{
		$time  = DATE("H:i", STRTOTIME($hourFormat));
	}
if($_REQUEST['action'] == "ApprovedLink")
{
	
	echo "<p style=\"color: green; font-style: italic; clear: both;\">Booking has been Confirmed successfully.
	<br /><br />
	Booking Details:
	<br />
	<br />
	Customer Name: ".$bookingDetail->CustomerName."
	<br />
	Customer Email: ".$bookingDetail->CustomerEmail."
	<br />
	Customer Mobile Number: ".$bookingDetail->CustomerMobile."
	<br />
	Booking Date: ".$date."
	<br />
	Booking Time: ".$time."
	<br />
	Booking Event Name: ".$bookingDetail->EventName."
	
	</p>";
	 $wpdb->query
	 (
		$wpdb->prepare
		(
			"UPDATE ".addBookingTable()." SET BookingStatus = %s WHERE BookingId = %d",
			"Approved",
			$bookingId
		)
	 );
	MailManagement($bookingId,"approved");
}

else if($_REQUEST['action'] == "DisapproveLink")
{
	echo "<p style=\"color: red; font-style: italic; clear: both;\">Booking has been Dissapproved successfully.
	<br /><br />
	Booking Details:
	<br />
	<br />
	Customer Name: ".$bookingDetail->CustomerName."
	<br />
	Customer Email: ".$bookingDetail->CustomerEmail."
	<br />
	Customer Mobile Number: ".$bookingDetail->CustomerMobile."
	<br />
	Booking Date: ".$date."
	<br />
	Booking Time: ".$time."
	<br />
	Booking Event Name: ".$bookingDetail->EventName."
	</p>";
	$wpdb->query
	(
		$wpdb->prepare
		(
			"UPDATE ".addBookingTable()." SET BookingStatus = %s WHERE BookingId = %d",
			"Disapproved",
			$bookingId
		)
	);
	MailManagement($bookingId,"disapproved");
}
?>