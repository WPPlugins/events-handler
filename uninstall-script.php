<?php
	global $wpdb;
	$sql ="DROP TABLE " .addEventTable();
	$wpdb->query($sql);
	
	$sql ="DROP TABLE " .addBookingTable();
	$wpdb->query($sql);	
	
	$sql ="DROP TABLE " .locationTable();
	$wpdb->query($sql);
	
	$sql ="DROP TABLE " .addTicketTable();
	$wpdb->query($sql);
	
	$sql ="DROP TABLE " .all_country_listTable();
	$wpdb->query($sql);
	
	$sql ="DROP TABLE " .settingTable();
	$wpdb->query($sql);
	
	$sql ="DROP TABLE " .all_currency_listTable();
	$wpdb->query($sql);
	
	$sql ="DROP TABLE " .addMultipleBookingsTable();
	$wpdb->query($sql);
	
	$sql ="DROP TABLE " .addCustomersTable();
	$wpdb->query($sql);
	
	$sql ="DROP TABLE " .templatesTable();
	$wpdb->query($sql);
	
?>