<?php
global $wpdb;
if (!current_user_can("edit_posts") && !current_user_can("edit_pages") )
{
	return;
}
else
{
	if(isset($_REQUEST['param']))
	{
		global $wpdb;
		if($_REQUEST['param'] == "setCheckbox")
		{
			$uxShowCheck= intval($_REQUEST["EventId"]);
			$showevent = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"Select EventFullDay from " .addEventTable() . " where EventId = %d",
					$uxShowCheck
				)
			);
		?>
			<script type = "text/javascript">
			
				<?php
					if($showevent == 1)
					{
						//echo "checked";
					?>
						jQuery("#uxFullDay").attr("checked", "checked");
						jQuery("#divEndDate").css("display", "block");
						jQuery("#divStartTime").css("display", "none");
						jQuery("#divEndTime").css("display", "none");
						jQuery("#uxLblBookingStartDate").css("display", "block");
						jQuery("#uxLblBookingDate").css("display", "none");
						
					<?php
					}
					else 
					{					
					?>			
						jQuery("#uxFullDay").removeAttr("checked");
						jQuery("#divEndDate").css("display", "none");
						jQuery("#divStartTime").css("display", "block");
						jQuery("#divEndTime").css("display", "block");
						jQuery("#uxLblBookingStartDate").css("display", "none");
						jQuery("#uxLblBookingDate").css("display", "block");
						
					<?php
					}
				?>
			</script>
			<?php
			die();
		}
		if($_REQUEST["param"] == "showBooking")
		{
			$uxShowEvent= intval($_REQUEST["EventId"]);
		?>
			<table style="width:100%;" class="table table-striped" id="showbooking-data-table">
				<thead>
					<tr>
						<th style="width:12%"><?php _e('Event Name', events);?></th>
						<th style="width:12%"><?php _e('Customer Name', events);?></th>
						<th style="width:12%"><?php _e('Time', events);?></th>
						<th style="width:13%"><?php _e('Start Date', events);?></th>
						<th style="width:13%"><?php _e('End Date', events);?></th>
						<th style="width:20%"><?php _e('Status', events);?></th>
						<th style="width:15%"></th>
					</tr>
				</thead>
				<?php
					global $wpdb;
					$Booking = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"SELECT booking.*, event.EventName from " . addBookingTable() ." as booking inner join " 
								. addEventTable() . " as event on booking.EventId = event.EventId where event.EventId = %d",
								 $uxShowEvent
							)
						);
						$dateformat=$wpdb->get_var
						(
							$wpdb->prepare
							(
								"SELECT SettingsValue FROM " .settingTable() . " WHERE SettingsKey = %s",
								"default_Date_Format"
							)
						);
						$timeFormat=$wpdb->get_var
						(
							$wpdb->prepare
							(
								"SELECT SettingsValue FROM " .settingTable() . " WHERE SettingsKey = %s",
								"default_Time_Format"
							)
						);
						for($flag=0; $flag< count($Booking); $flag++)
						{
						?>
							<tr>
								<td><?php echo $Booking[$flag]->EventName; ?></td>
								<td><?php echo $Booking[$flag]->a; ?></td>
								
								<?php  
								if($Booking[$flag]->EventFullDay == 1)
								{
								?>
									<td><?php echo "-"; ?></td>
								<?php
								}
								else
								{
									if($timeFormat == 0)
									{	
										$BookingShr = floor(($Booking[$flag]->BookingSTotalTime)/60);
										$BookingSmn = ($Booking[$flag]->BookingSTotalTime) % 60;
										$hourFormatStart = $BookingShr . ":" . $BookingSmn;
										$BookingShr1  = date("h:i A", strtotime($hourFormatStart));
									
										$BookingETimeEhr = floor(($Booking[$flag]->BookingETotalTime)/60);
										$BookingETimeEmn = ($Booking[$flag]->BookingETotalTime) % 60;
										$hourFormatEnd = $BookingETimeEhr . ":" . $BookingETimeEmn;
										$BookingEhr1  = date("h:i A", strtotime($hourFormatEnd));
										
									}
									else
									{
										$BookingShr = floor(($Booking[$flag]->BookingSTotalTime)/60);
										$BookingSmn = ($Booking[$flag]->BookingSTotalTime) % 60;
										$hourFormatStart = $BookingShr . ":" . $BookingSmn;
										$BookingShr1  = date("H:i", strtotime($hourFormatStart));
									
										$BookingETimeEhr = floor(($Booking[$flag]->BookingETotalTime)/60);
										$BookingETimeEmn = ($Booking[$flag]->BookingETotalTime) % 60;
										$hourFormatEnd = $BookingETimeEhr . ":" . $BookingETimeEmn;
										$BookingEhr1  = date("H:i", strtotime($hourFormatEnd));
									}
								?>
									<td><?php echo $BookingShr1 . " - " .  $BookingEhr1; ?></td>
							<?php
								}
							?>
							<?php
								if($dateformat == 0)
								{
									?>
									<td><?php echo date('M d, Y', strtotime($Booking[$flag]->BookingStartDate)); ?> </td>
									<?php
								}
								else if($dateformat == 1)
								{
									?>
									<td><?php echo date('Y/m/d', strtotime($Booking[$flag]->BookingStartDate)); ?> </td>
									<?php
								}
								else if($dateformat == 2)
								{
									?>
									<td><?php echo date('m/d/Y', strtotime($Booking[$flag]->BookingStartDate)); ?> </td>
									<?php
								}
								else if($dateformat == 3)
								{
									?>
									<td><?php echo date('d/m/Y', strtotime($Booking[$flag]->BookingStartDate)); ?> </td>
									<?php
								}
								if($Booking[$flag]->EventFullDay == 1)
								{	
									if($dateformat == 0)
									{
										?>
										<td><?php echo date('M d, Y', strtotime($Booking[$flag]->BookingEndDate)); ?> </td>
										<?php
									}
									else if($dateformat == 1)
									{
										?>
										<td><?php echo date('Y/m/d', strtotime($Booking[$flag]->BookingEndDate)); ?> </td>
										<?php
									}
									else if($dateformat == 2)
									{
										?>
										<td><?php echo date('m/d/Y', strtotime($Booking[$flag]->BookingEndDate)); ?> </td>
										<?php
									}
									else if($dateformat == 3)
									{
										?>
										<td><?php echo date('d/m/Y', strtotime($Booking[$flag]->BookingEndDate)); ?> </td>
										<?php
									}
								}
								else
								{
								?>
									<td><?php echo  "-"; ?></td>
									<?php
								}
								?>
								<td>
									<?php echo $Booking[$flag]->BookingStatus; ?>
								</td>
								<td>
									<a href="#uxDivEditBooking" class="icon-edit hovertip inline"  onclick="editBooking(<?php echo $Booking[$flag]->BookingId ?>)"></a>
									<a href="#" class="icon-trash hovertip" id="delete" onclick="deleteBooking(<?php echo $Booking[$flag]->BookingId ?>)"></a>
								</td>
							</tr>
						<?php
						}
					?>
			</table>
			<script>oTable = jQuery('#showbooking-data-table').dataTable
			({
				"bJQueryUI": false,
				"bAutoWidth": true,
				"sPaginationType": "full_numbers",
				"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
				"oLanguage": 
				{
					"sLengthMenu": "_MENU_"
				}
			});
			</script>
			<?php
			die();		
		}
		
		else if($_REQUEST["param"] == "deletebooking")
		{
			$BookingId=intval($_REQUEST["BookingId"]);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE FROM ". addBookingTable() . " WHERE BookingId = %d",
					$BookingId 
				)
			);
			die();
		}
		else if($_REQUEST['param'] == "updatebooking")
		{
			$BookingId = intval($_REQUEST['bookingHideId']);
			$CustomerId = intval($_REQUEST['CustomerHideId']);
			$uxEditFirstName=esc_attr($_REQUEST['uxEditFirstName']);
			$uxEditLastName=esc_attr($_REQUEST['uxEditLastName']);
			$uxEditEmailAddress=esc_attr($_REQUEST['uxEditEmailAddress']);
			$uxEditMobileNumber=esc_attr($_REQUEST['uxEditMobileNumber']);
			$uxEditAddress=esc_attr($_REQUEST['uxEditAddress']);
			$uxEditCity=esc_attr($_REQUEST['uxEditCity']);
			$uxEditCountry=esc_attr($_REQUEST['uxEditCountry']);
			$uxBookingStatus=esc_attr($_REQUEST['uxBookingStatus']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE " .addCustomersTable(). " SET CustomerFirstName = %s, CustomerLastName = %s, CustomerEmail = %s,
					CustomerMobile = %s, CustomerAddress=%s, CustomerCity = %s, CustomerCountry=%s WHERE CustomerId = %d",
					$uxEditFirstName,
					$uxEditLastName,
					$uxEditEmailAddress,
					$uxEditMobileNumber,
					$uxEditAddress,
					$uxEditCity,
					$uxEditCountry,
					$CustomerId
				)
			);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE " .addBookingTable(). " SET BookingStatus = %s WHERE BookingId = %d",
					$uxBookingStatus,
					$BookingId
				)
			);
			include_once EBM_BK_PLUGIN_DIR.'/views/mailmanagement.php';
			MailManagement($BookingId,$uxBookingStatus);
			if($uxBookingStatus == "Pending Approval")
			{
				//MailManagement($BookingId,"approval_pending");
				MailManagement($BookingId,"admin");
			}
			else if($uxBookingStatus == "Approved")
			{
				MailManagement($BookingId,"approved");
			}
			else if($uxBookingStatus == "Disapproved")
			{
				MailManagement($BookingId,"disapproved");
			}
		die();
		}
	}
}
?>
