<?php
function MailManagement($bookingId,$action)
{
	global $wpdb;
	$url = EBM_BK_PLUGIN_URL.'/views'; 
	$bookingDetail = $wpdb->get_row
	(
		$wpdb->prepare
		(
			"SELECT CONCAT(".addCustomersTable().".CustomerFirstName ,'  ',". addCustomersTable().".CustomerLastName) as CustomerName,".addCustomersTable().".CustomerEmail,"
			.addCustomersTable().".CustomerMobile,"	.addCustomersTable().".CustomerAddress," .addCustomersTable().".CustomerCity," .addCustomersTable().".CustomerZipCode,"
			.addCustomersTable().".CustomerCountry," .addCustomersTable().".CustomerComments,"
			. addEventTable(). ".EventName,". addEventTable(). ".EventId,". addEventTable(). ".EventTo,". addEventTable(). ".EventFrom,".addEventTable().".EventFullDay,"
			.addEventTable().".EventColorCode,".addEventTable().".EventSTotalTime, ".addEventTable().".EventETotalTime, ".addEventTable().".EventLocName,
			".addEventTable().".EventLocAddress,  ".addEventTable().".EventLocCity, ".addEventTable().".EventLocCountry,
			".addBookingTable().".BookingStartDate ,". addBookingTable().".BookingSTotalTime,". addBookingTable().".BookingId, ".
			addBookingTable().".PaymentStatus, ". addBookingTable().".TransactionId,  ". addBookingTable().".noOfTickets, ". addTicketTable().".TicketPrice ,  "
			. addBookingTable().".PaymentDate,". addBookingTable().".BookingStatus FROM ".addBookingTable()." 
			LEFT OUTER JOIN " .addCustomersTable()." ON ".addBookingTable().".CustomerId= ".addCustomersTable().".CustomerId ". " 
			LEFT OUTER JOIN " .addTicketTable()." ON ".addBookingTable().".TicketId= ".addTicketTable().".TicketId ". " 
			LEFT OUTER JOIN " .addEventTable()." ON ".addBookingTable().".EventId=".addEventTable().".EventId where ".addBookingTable().".BookingId =  %d",
			$bookingId
		)
	);
	$admin_email = $wpdb->get_var
	(
		$wpdb->prepare
		(
			'SELECT SettingsValue FROM ' . settingTable() . ' where SettingsKey = %s',
			"admin_email"
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
	$country_name = $wpdb->get_var
	(
		$wpdb->prepare
		(
			'SELECT CountryName FROM ' . all_country_listTable() . ' where CountryId = %d',
			$bookingDetail->CustomerCountry
		)
	);
	$country_name_event = $wpdb->get_var
	(
		$wpdb->prepare
		(
			'SELECT CountryName FROM ' . all_country_listTable() . ' where CountryId = %d',
			$bookingDetail->EventLocCountry
		)
	);
	$payenable= $wpdb->get_var
	(
		$wpdb->prepare
		(
			'SELECT SettingsValue FROM ' . settingTable() .' where SettingsKey = %s',
			"paypal-enabled"
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
		$start_date =  date("M d, Y", strtotime($bookingDetail-> EventFrom ));
		$end_date = date("M d, Y", strtotime($bookingDetail->EventTo));
		$date = $start_date . " - " . $end_date;
	}
	else if($dateFormat == 1)
	{
		$start_dat =  date("Y/m/d", strtotime($bookingDetail->EventFrom));
		$end_date = date("Y/m/d", strtotime($bookingDetail->EventTo));
		$date = $start_date . " - " . $end_date;
	}
	else if($dateFormat == 2)
	{
		$start_date =  date("m/d/Y", strtotime($bookingDetail->EventFrom));
		$end_date = date("m/d/Y", strtotime($bookingDetail->EventTo));
		$date = $start_date . " - " . $end_date;
	}
	else if($dateFormat == 3)
	{
		$start_date =  date("d/m/Y", strtotime($bookingDetail->EventFrom));
		$end_date = date("d/m/Y", strtotime($bookingDetail->EventTo));
		$date = $start_date . " - " . $end_date;
	}
	
	$timeFormats = $wpdb->get_var
	(
			$wpdb->prepare
			(
				"SELECT SettingsValue FROM ".settingTable()." WHERE SettingsKey = %s",
				'default_Time_Format'
			)
		);
		if($bookingDetail->EventFullDay == 0)
		{
			$getHours = floor(($bookingDetail->EventSTotalTime)/60);
			$getMins = ($bookingDetail->EventSTotalTime) % 60;
			$start_hourFormat = $getHours . ":" . $getMins;
			
			$getEHours = floor(($bookingDetail->EventETotalTime)/60);
			$getEMins = ($bookingDetail->EventETotalTime) % 60;
			$end_hourFormat = $getEHours . ":" . $getEMins;
			if($timeFormats == 0)
			{
				$start_time  = DATE("g:i a", STRTOTIME($start_hourFormat));
				$end_time  = DATE("g:i a", STRTOTIME($end_hourFormat));
				$time = $start_time . " - " . $end_time;
				$label_blank = "Event Time :";
			}
			else 
			{
				$start_time  = DATE("H:i", STRTOTIME($start_hourFormat));
				$end_time  = DATE("H:i", STRTOTIME($end_hourFormat));
				$time = $start_time . " - " . $end_time;
				$label_blank = "Event Time :";
				
			}
		}
		else
		{
			$time =  "";
			$label_blank = "";
			
		}

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
		
	$ticket_total_cost = $bookingDetail->noOfTickets * $bookingDetail->TicketPrice;
	$title=get_bloginfo('name');
	$to = $bookingDetail->CustomerEmail;
	$space = "";
	$payment = "**************************************************************************************<br>
<strong>Payment Details</strong><br>
**************************************************************************************";
	if($action == "approved")
	{
		$emailContent = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailContent FROM  ' . templatesTable() . ' WHERE EmailType = %s',
				"booking-confirmation"
			)
		);
		$emailSubject = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailSubject FROM  ' . templatesTable() . ' WHERE EmailType = %s',
				"booking-confirmation"
			)
		);
		if($payenable == 1)
		{
			
			$message_1 = str_replace("[event_name]", $bookingDetail->EventName, stripcslashes($emailContent));
			$message_2 = str_replace("[event_date]", $date, $message_1);
			$message_3 = str_replace("[event_time]", $time, $message_2);
			$message_4 = str_replace("[event_venue]", $bookingDetail->EventLocName, $message_3);
			$message_5 = str_replace("[event_address]", $bookingDetail->EventLocAddress, $message_4);
			$message_6 = str_replace("[event_city]",$bookingDetail->EventLocCity, $message_5);
			$message_7 = str_replace("[event_country]",$country_name_event, $message_6);
			$message_8 = str_replace("[customer_name]",$bookingDetail->CustomerName, $message_7);
			$message_9 = str_replace("[customer_email_address]",$bookingDetail->CustomerEmail, $message_8);
			$message_10 = str_replace("[customer_mobile]", $bookingDetail->CustomerMobile, $message_9);
			$message_11 = str_replace("[customer_address]", $bookingDetail->CustomerAddress, $message_10);
			$message_12 = str_replace("[customer_city]",$bookingDetail->CustomerCity, $message_11);
			$message_13 = str_replace("[customer_postcode]",$bookingDetail->CustomerZipCode, $message_12);
			$message_14 = str_replace("[customer_country]",$country_name, $message_13);
			$message_15 = str_replace("[customer_comments]",$bookingDetail->CustomerComments, $message_14);
			$message_16 = str_replace("[event_tickets_number]",$bookingDetail->noOfTickets, $message_15);
			$message_17 = str_replace("[event_tickets_price]",$bookingDetail->TicketPrice, $message_16);
			$message_18 = str_replace("[event_tickets_cost]",$ticket_total_cost , $message_17);
			$message_19 = str_replace("[Transaction Id:]",$bookingDetail->TransactionId, $message_18);
			$message_20 = str_replace("[Payment Date:]",$bookingDetail->PaymentDate, $message_19);
			$message_21 = str_replace("[Payment Status:]",$bookingDetail->PaymentStatus, $message_20);
			$message_22 = str_replace("[transaction_id]","Transaction Id :", $message_21);
			$message_23 = str_replace("[payment_status]","Payment Status :", $message_22);
			$message_24 = str_replace("[payment_date]","Payment Date :", $message_23);
			$message_25 = str_replace("[payment_string]",$payment, $message_24);
			$message_26 = str_replace("[Event Time:]",$label_blank, $message_25);
			$message = str_replace("[company_name]",$title, $message_26);
			
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			wp_mail($to,$emailSubject,$message,$headers);
		}
		else
		{
			$message_1 = str_replace("[event_name]", $bookingDetail->EventName, stripcslashes($emailContent));
			$message_2 = str_replace("[event_date]", $date, $message_1);
			$message_3 = str_replace("[event_time]", $time, $message_2);
			$message_4 = str_replace("[event_venue]", $bookingDetail->EventLocName, $message_3);
			$message_5 = str_replace("[event_address]", $bookingDetail->EventLocAddress, $message_4);
			$message_6 = str_replace("[event_city]",$bookingDetail->EventLocCity, $message_5);
			$message_7 = str_replace("[event_country]",$country_name_event, $message_6);
			$message_8 = str_replace("[customer_name]",$bookingDetail->CustomerName, $message_7);
			$message_9 = str_replace("[customer_email_address]",$bookingDetail->CustomerEmail, $message_8);
			$message_10 = str_replace("[customer_mobile]", $bookingDetail->CustomerMobile, $message_9);
			$message_11 = str_replace("[customer_address]", $bookingDetail->CustomerAddress, $message_10);
			$message_12 = str_replace("[customer_city]",$bookingDetail->CustomerCity, $message_11);
			$message_13 = str_replace("[customer_postcode]",$bookingDetail->CustomerZipCode, $message_12);
			$message_14 = str_replace("[customer_country]",$country_name, $message_13);
			$message_15 = str_replace("[customer_comments]",$bookingDetail->CustomerComments, $message_14);
			$message_16 = str_replace("[event_tickets_number]",$bookingDetail->noOfTickets, $message_15);
			$message_17 = str_replace("[event_tickets_price]",$bookingDetail->TicketPrice, $message_16);
			$message_18 = str_replace("[event_tickets_cost]",$ticket_total_cost , $message_17);
			$message_19 = str_replace("[Transaction Id:]",$space, $message_18);
			$message_20 = str_replace("[Payment Status:]",$space, $message_19);
			$message_21 = str_replace("[Payment Date:]",$space, $message_20);
			$message_22 = str_replace("[transaction_id]",$space, $message_21);
			$message_23 = str_replace("[payment_status]",$space, $message_22);
			$message_24 = str_replace("[payment_date]",$space, $message_23);
			$message_25 = str_replace("[payment_string]",$space, $message_24);
			$message_26 = str_replace("[Event Time:]",$label_blank, $message_25);
			$message = str_replace("[company_name]",$title, $message_26);
			
			$headers =  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			
			wp_mail($to,$emailSubject,$message,$headers);
		}
	}
/***********************************************************************************************************************************************************/
	else if($action == "disapproved")
	{
		$emailContent = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailContent FROM  ' . templatesTable() . ' WHERE EmailType = %s ',
				"booking-disapproved"
			)
		);
		$emailSubject = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailSubject FROM  ' . templatesTable() . ' WHERE EmailType = %s' ,
				"booking-disapproved"
			)
		);
		if($payenable == 1)
		{
			$message_1 = str_replace("[event_name]", $bookingDetail->EventName, stripcslashes($emailContent));
			$message_2 = str_replace("[event_date]", $date, $message_1);
			$message_3 = str_replace("[event_time]", $time, $message_2);
			$message_4 = str_replace("[event_venue]", $bookingDetail->EventLocName, $message_3);
			$message_5 = str_replace("[event_address]", $bookingDetail->EventLocAddress, $message_4);
			$message_6 = str_replace("[event_city]",$bookingDetail->EventLocCity, $message_5);
			$message_7 = str_replace("[event_country]",$country_name_event, $message_6);
			$message_8 = str_replace("[customer_name]",$bookingDetail->CustomerName, $message_7);
			$message_9 = str_replace("[customer_email_address]",$bookingDetail->CustomerEmail, $message_8);
			$message_10 = str_replace("[customer_mobile]", $bookingDetail->CustomerMobile, $message_9);
			$message_11 = str_replace("[customer_address]", $bookingDetail->CustomerAddress, $message_10);
			$message_12 = str_replace("[customer_city]",$bookingDetail->CustomerCity, $message_11);
			$message_13 = str_replace("[customer_postcode]",$bookingDetail->CustomerZipCode, $message_12);
			$message_14 = str_replace("[customer_country]",$country_name, $message_13);
			$message_15 = str_replace("[customer_comments]",$bookingDetail->CustomerComments, $message_14);
			$message_16 = str_replace("[event_tickets_number]",$bookingDetail->noOfTickets, $message_15);
			$message_17 = str_replace("[event_tickets_price]",$bookingDetail->TicketPrice, $message_16);
			$message_18 = str_replace("[event_tickets_cost]",$ticket_total_cost , $message_17);
			$message_19 = str_replace("[Transaction Id:]",$bookingDetail->TransactionId, $message_18);
			$message_20 = str_replace("[Payment Date:]",$bookingDetail->PaymentDate, $message_19);
			$message_21 = str_replace("[Payment Status:]",$bookingDetail->PaymentStatus, $message_20);
			$message_22 = str_replace("[transaction_id]","Transaction Id :", $message_21);
			$message_23 = str_replace("[payment_status]","Payment Status :", $message_22);
			$message_24 = str_replace("[payment_date]","Payment Date :", $message_23);
			$message_25 = str_replace("[payment_string]",$payment, $message_24);
			$message_26 = str_replace("[Event Time:]",$label_blank, $message_25);
			$message = str_replace("[company_name]",$title, $message_26);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			wp_mail($to,$emailSubject, $message, $headers);
		}
		else
		{
			$message_1 = str_replace("[event_name]", $bookingDetail->EventName, stripcslashes($emailContent));
			$message_2 = str_replace("[event_date]", $date, $message_1);
			$message_3 = str_replace("[event_time]", $time, $message_2);
			$message_4 = str_replace("[event_venue]", $bookingDetail->EventLocName, $message_3);
			$message_5 = str_replace("[event_address]", $bookingDetail->EventLocAddress, $message_4);
			$message_6 = str_replace("[event_city]",$bookingDetail->EventLocCity, $message_5);
			$message_7 = str_replace("[event_country]",$country_name_event, $message_6);
			$message_8 = str_replace("[customer_name]",$bookingDetail->CustomerName, $message_7);
			$message_9 = str_replace("[customer_email_address]",$bookingDetail->CustomerEmail, $message_8);
			$message_10 = str_replace("[customer_mobile]", $bookingDetail->CustomerMobile, $message_9);
			$message_11 = str_replace("[customer_address]", $bookingDetail->CustomerAddress, $message_10);
			$message_12 = str_replace("[customer_city]",$bookingDetail->CustomerCity, $message_11);
			$message_13 = str_replace("[customer_postcode]",$bookingDetail->CustomerZipCode, $message_12);
			$message_14 = str_replace("[customer_country]",$country_name, $message_13);
			$message_15 = str_replace("[customer_comments]",$bookingDetail->CustomerComments, $message_14);
			$message_16 = str_replace("[event_tickets_number]",$bookingDetail->noOfTickets, $message_15);
			$message_17 = str_replace("[event_tickets_price]",$bookingDetail->TicketPrice, $message_16);
			$message_18 = str_replace("[event_tickets_cost]",$ticket_total_cost , $message_17);
			$message_19 = str_replace("[Transaction Id:]",$space, $message_18);
			$message_20 = str_replace("[Payment Status:]",$space, $message_19);
			$message_21 = str_replace("[Payment Date:]",$space, $message_20);
			$message_22 = str_replace("[transaction_id]",$space, $message_21);
			$message_23 = str_replace("[payment_status]",$space, $message_22);
			$message_24 = str_replace("[payment_date]",$space, $message_23);
			$message_25 = str_replace("[payment_string]",$space, $message_24);
			$message_26 = str_replace("[Event Time:]",$label_blank, $message_25);
			$message = str_replace("[company_name]",$title, $message_26);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			
			wp_mail($to,$emailSubject, $message, $headers);
		}
	}
/***********************************************************************************************************************************************************/
	else if($action == "approval_pending")
	{
		$emailContent = $wpdb->get_var
		(
			$wpdb->prepare
			(
			'SELECT EmailContent FROM  ' . templatesTable() . ' WHERE EmailType = %s',
			"booking-pending-confirmation"
			)
		);
		$emailSubject = $wpdb->get_var
		(
			$wpdb->prepare
			(
			'SELECT EmailSubject FROM  ' . templatesTable() . ' WHERE EmailType = %s ' , 
			"booking-pending-confirmation"
			)
		);
		if($payenable == 1)
		{
			$message_1 = str_replace("[event_name]", $bookingDetail->EventName, stripcslashes($emailContent));
			$message_2 = str_replace("[event_date]", $date, $message_1);
			$message_3 = str_replace("[event_time]", $time, $message_2);
			$message_4 = str_replace("[event_venue]", $bookingDetail->EventLocName, $message_3);
			$message_5 = str_replace("[event_address]", $bookingDetail->EventLocAddress, $message_4);
			$message_6 = str_replace("[event_city]",$bookingDetail->EventLocCity, $message_5);
			$message_7 = str_replace("[event_country]",$country_name_event, $message_6);
			$message_8 = str_replace("[customer_name]",$bookingDetail->CustomerName, $message_7);
			$message_9 = str_replace("[customer_email_address]",$bookingDetail->CustomerEmail, $message_8);
			$message_10 = str_replace("[customer_mobile]", $bookingDetail->CustomerMobile, $message_9);
			$message_11 = str_replace("[customer_address]", $bookingDetail->CustomerAddress, $message_10);
			$message_12 = str_replace("[customer_city]",$bookingDetail->CustomerCity, $message_11);
			$message_13 = str_replace("[customer_postcode]",$bookingDetail->CustomerZipCode, $message_12);
			$message_14 = str_replace("[customer_country]",$country_name, $message_13);
			$message_15 = str_replace("[customer_comments]",$bookingDetail->CustomerComments, $message_14);
			$message_16 = str_replace("[event_tickets_number]",$bookingDetail->noOfTickets, $message_15);
			$message_17 = str_replace("[event_tickets_price]",$bookingDetail->TicketPrice, $message_16);
			$message_18 = str_replace("[event_tickets_cost]",$ticket_total_cost , $message_17);
			$message_19 = str_replace("[Transaction Id:]",$bookingDetail->TransactionId, $message_18);
			$message_20 = str_replace("[Payment Date:]",$bookingDetail->PaymentDate, $message_19);
			$message_21 = str_replace("[Payment Status:]",$bookingDetail->PaymentStatus, $message_20);
			$message_22 = str_replace("[transaction_id]","Transaction Id :", $message_21);
			$message_23 = str_replace("[payment_status]","Payment Status :", $message_22);
			$message_24 = str_replace("[payment_date]","Payment Date :", $message_23);
			$message_25 = str_replace("[payment_string]",$payment, $message_24);
			$message_26 = str_replace("[Event Time:]",$label_blank, $message_25);
			$message = str_replace("[company_name]",$title, $message_26);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			wp_mail($to,$emailSubject,$message,$headers);
		}
		else
		{
			$message_1 = str_replace("[event_name]", $bookingDetail->EventName, stripcslashes($emailContent));
			$message_2 = str_replace("[event_date]", $date, $message_1);
			$message_3 = str_replace("[event_time]", $time, $message_2);
			$message_4 = str_replace("[event_venue]", $bookingDetail->EventLocName, $message_3);
			$message_5 = str_replace("[event_address]", $bookingDetail->EventLocAddress, $message_4);
			$message_6 = str_replace("[event_city]",$bookingDetail->EventLocCity, $message_5);
			$message_7 = str_replace("[event_country]",$country_name_event, $message_6);
			$message_8 = str_replace("[customer_name]",$bookingDetail->CustomerName, $message_7);
			$message_9 = str_replace("[customer_email_address]",$bookingDetail->CustomerEmail, $message_8);
			$message_10 = str_replace("[customer_mobile]", $bookingDetail->CustomerMobile, $message_9);
			$message_11 = str_replace("[customer_address]", $bookingDetail->CustomerAddress, $message_10);
			$message_12 = str_replace("[customer_city]",$bookingDetail->CustomerCity, $message_11);
			$message_13 = str_replace("[customer_postcode]",$bookingDetail->CustomerZipCode, $message_12);
			$message_14 = str_replace("[customer_country]",$country_name, $message_13);
			$message_15 = str_replace("[customer_comments]",$bookingDetail->CustomerComments, $message_14);
			$message_16 = str_replace("[event_tickets_number]",$bookingDetail->noOfTickets, $message_15);
			$message_17 = str_replace("[event_tickets_price]",$bookingDetail->TicketPrice, $message_16);
			$message_18 = str_replace("[event_tickets_cost]",$ticket_total_cost , $message_17);
			$message_19 = str_replace("[Transaction Id:]",$space, $message_18);
			$message_20 = str_replace("[Payment Status:]",$space, $message_19);
			$message_21 = str_replace("[Payment Date:]",$space, $message_20);
			$message_22 = str_replace("[transaction_id]",$space, $message_21);
			$message_23 = str_replace("[payment_status]",$space, $message_22);
			$message_24 = str_replace("[payment_date]",$space, $message_23);
			$message_25 = str_replace("[payment_string]",$space, $message_24);
			$message_26 = str_replace("[Event Time:]",$label_blank, $message_25);
			$message = str_replace("[company_name]",$title, $message_26);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			
			wp_mail($to,$emailSubject,$message,$headers);
		}
	}
/***********************************************************************************************************************************************************/
	else if($action == "admin")
	{
		$emailContent = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailContent FROM  ' . templatesTable() . ' WHERE EmailType = %s ' ,
				"admin-control"
			)
		);
		$emailSubject = $wpdb->get_var
		(
			$wpdb->prepare
			(
				'SELECT EmailSubject FROM  ' . templatesTable() . ' WHERE EmailType = %s',
				"admin-control"
			)
		);
		if($payenable == 1)
		{
			$message_1 = str_replace("[event_name]", $bookingDetail->EventName, stripcslashes($emailContent));
			$message_2 = str_replace("[event_date]", $date, $message_1);
			$message_3 = str_replace("[event_time]", $time, $message_2);
			$message_4 = str_replace("[event_venue]", $bookingDetail->EventLocName, $message_3);
			$message_5 = str_replace("[event_address]", $bookingDetail->EventLocAddress, $message_4);
			$message_6 = str_replace("[event_city]",$bookingDetail->EventLocCity, $message_5);
			$message_7 = str_replace("[event_country]",$country_name_event, $message_6);
			$message_8 = str_replace("[customer_name]",$bookingDetail->CustomerName, $message_7);
			$message_9 = str_replace("[customer_email_address]",$bookingDetail->CustomerEmail, $message_8);
			$message_10 = str_replace("[customer_mobile]", $bookingDetail->CustomerMobile, $message_9);
			$message_11 = str_replace("[customer_address]", $bookingDetail->CustomerAddress, $message_10);
			$message_12 = str_replace("[customer_city]",$bookingDetail->CustomerCity, $message_11);
			$message_13 = str_replace("[customer_postcode]",$bookingDetail->CustomerZipCode, $message_12);
			$message_14 = str_replace("[customer_country]",$country_name, $message_13);
			$message_15 = str_replace("[customer_comments]",$bookingDetail->CustomerComments, $message_14);
			$message_16 = str_replace("[event_tickets_number]",$bookingDetail->noOfTickets, $message_15);
			$message_17 = str_replace("[event_tickets_price]",$bookingDetail->TicketPrice, $message_16);
			$message_18 = str_replace("[event_tickets_cost]",$ticket_total_cost , $message_17);
			$message_19 = str_replace("[Transaction Id:]",$bookingDetail->TransactionId, $message_18);
			$message_20 = str_replace("[Payment Date:]",$bookingDetail->PaymentDate, $message_19);
			$message_21 = str_replace("[Payment Status:]",$bookingDetail->PaymentStatus, $message_20);
			$message_22 = str_replace("[transaction_id]","Transaction Id :", $message_21);
			$message_23 = str_replace("[payment_status]","Payment Status :", $message_22);
			$message_24 = str_replace("[payment_date]","Payment Date :", $message_23);
			$approve = "<a href=\"$url/adminEmailLink.php?action=ApprovedLink&id=".$bookingId."\">approve</a>";
			$disapprove = "<a href=\"$url/adminEmailLink.php?action=DisapproveLink&id=".$bookingId."\">disapprove</a>";
			$message_25 = str_replace("[approve]", $approve, $message_24);
			$message_26 = str_replace("[payment_string]",$payment, $message_25);
			$message_27 = str_replace("[deny]", $disapprove, $message_26);
			$message_28 = str_replace("[Event Time:]",$label_blank, $message_27);
			$message = str_replace("[company_name]",$title, $message_28);
			
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			wp_mail($admin_email,$emailSubject,$message,$headers);
		}
		else
		{
			$message_1 = str_replace("[event_name]", $bookingDetail->EventName, stripcslashes($emailContent));
			$message_2 = str_replace("[event_date]", $date, $message_1);
			$message_3 = str_replace("[event_time]", $time, $message_2);
			$message_4 = str_replace("[event_venue]", $bookingDetail->EventLocName, $message_3);
			$message_5 = str_replace("[event_address]", $bookingDetail->EventLocAddress, $message_4);
			$message_6 = str_replace("[event_city]",$bookingDetail->EventLocCity, $message_5);
			$message_7 = str_replace("[event_country]",$country_name_event, $message_6);
			$message_8 = str_replace("[customer_name]",$bookingDetail->CustomerName, $message_7);
			$message_9 = str_replace("[customer_email_address]",$bookingDetail->CustomerEmail, $message_8);
			$message_10 = str_replace("[customer_mobile]", $bookingDetail->CustomerMobile, $message_9);
			$message_11 = str_replace("[customer_address]", $bookingDetail->CustomerAddress, $message_10);
			$message_12 = str_replace("[customer_city]",$bookingDetail->CustomerCity, $message_11);
			$message_13 = str_replace("[customer_postcode]",$bookingDetail->CustomerZipCode, $message_12);
			$message_14 = str_replace("[customer_country]",$country_name, $message_13);
			$message_15 = str_replace("[customer_comments]",$bookingDetail->CustomerComments, $message_14);
			$message_16 = str_replace("[event_tickets_number]",$bookingDetail->noOfTickets, $message_15);
			$message_17 = str_replace("[event_tickets_price]",$bookingDetail->TicketPrice, $message_16);
			$message_18 = str_replace("[event_tickets_cost]",$ticket_total_cost , $message_17);
			$message_19 = str_replace("[Transaction Id:]",$space, $message_18);
			$message_20 = str_replace("[Payment Status:]",$space, $message_19);
			$message_21 = str_replace("[Payment Date:]",$space, $message_20);
			$message_22 = str_replace("[transaction_id]",$space, $message_21);
			$message_23 = str_replace("[payment_status]",$space, $message_22);
			$message_24 = str_replace("[payment_date]",$space, $message_23);
			$approve = "<a href=\"$url/adminEmailLink.php?action=ApprovedLink&id=".$bookingId."\">approve</a>";
			$disapprove = "<a href=\"$url/adminEmailLink.php?action=DisapproveLink&id=".$bookingId."\">disapprove</a>";
			$message_25 = str_replace("[approve]", $approve, $message_24);
			$message_26 = str_replace("[deny]", $disapprove, $message_25);
			$message_27 = str_replace("[payment_string]",$space, $message_26);
			$message_28 = str_replace("[Event Time:]",$label_blank, $message_27);
			$message = str_replace("[company_name]",$title, $message_28);
			$headers=  "From: " .$title. " <". $admin_email . ">" ."\n" .
			"Content-Type: text/html; charset=\"" .
			get_option('blog_charset') . "\n";
			
			wp_mail($admin_email,$emailSubject,$message,$headers);
		}
	}
/***********************************************************************************************************************************************************/
	
}
?>