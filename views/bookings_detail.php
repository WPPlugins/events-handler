<div id="right">
	<div id="breadcrumbs">
		<ul>
			<li class="first"></li>
			<li>
				<a href="#">
					<?php _e( "EVENTS HANDLER", events ); ?>
				</a>
			</li>
			<li class="last">
				<a href="admin.php?page=customers">
					<?php _e( "CUSTOMERS", events); ?>
				</a>
			</li>
			<li class="last">
				<a href="#">
					<?php _e( "BOOKINGS DETAILS", events); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<a href="admin.php?page=customers" class="events-container-button green" style="margin-top: 5px;">
			<span style="height: 100%;"><?php _e('Back to Customers', events); ?></span>
    	</a>
		<?php
			global $wpdb;
			$show=$wpdb->get_results
			(
				$wpdb->prepare
				(
					"SELECT * FROM " .addEventTable(),""
				)
			);
		?>
		<div class="box">	
			<div class="title">
				<?php _e('BOOKINGS DETAILS', events); ?>
			</div>	
			<div class="content">
				<div id="uxDivMainTable">
					<table style="width:100%;" class="table table-striped" id="booking-data-table" style="margin-top:10px;">
						<thead>
							<tr>
								<th style="width:15%"><?php _e('Event Name', events);?></th>
								<th style="width:15%"><?php _e('Date', events);?></th>
								<th style="width:15%"><?php _e('Time', events);?></th>
								<th style="width:15%"><?php _e('Ticket Type', events);?></th>
								<th style="width:15%"><?php _e('Total Price', events);?></th>
								<th style="width:15%"><?php _e('Status', events);?></th>
								<th style="width:6%"></th>
							</tr>
						</thead>
						<?php
						global $wpdb;
						$bookingdetail = $_REQUEST['bid'];
						$Booking = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"SELECT ".addCustomersTable().".CustomerFirstName,".addBookingTable().".BookingId,
								".addCustomersTable().".CustomerMobile,". addEventTable(). ".EventName,".addTicketTable().".TicketName	 ,".addTicketTable().".TicketPrice,
								".addEventTable().".EventSTotalTime, ".addBookingTable().".BookingStartDate , ".addBookingTable().".BookingSTotalTime , ".addEventTable().".EventFullDay,
								".addBookingTable().".noOfTickets ,
								". addBookingTable().".BookingId,". addBookingTable().".BookingStatus FROM ".addBookingTable()." 
								LEFT OUTER JOIN " .addCustomersTable()." ON ".addBookingTable().".CustomerId= ".addCustomersTable().".CustomerId ". " 
								LEFT OUTER JOIN " .addTicketTable()." ON ".addBookingTable().".TicketId = ".addTicketTable().".TicketId "."  
								LEFT OUTER JOIN " .addEventTable()." ON ".addBookingTable().".EventId=".addEventTable().".EventId
								WHERE ".addCustomersTable().".CustomerId = %d ORDER BY ".addBookingTable().".BookingSTotalTime ASC",
								$bookingdetail
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
								<?php
								if($Booking[$flag]->EventFullDay == 1)
								{	
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
										<td><?php echo date('d/m/Y', strtotime($Booking[$flag]->BookingStartDate)); ?></td>
									<?php
									}
								}
								else
								{
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
								}
								?>
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
										
									}
									else 
									{
										$BookingShr = floor(($Booking[$flag]->BookingSTotalTime)/60);
										$BookingSmn = ($Booking[$flag]->BookingSTotalTime) % 60;
										$hourFormatStart = $BookingShr . ":" . $BookingSmn;
										$BookingShr1  = date("H:i", strtotime($hourFormatStart));
										
									}
									?>
									<td><?php echo $BookingShr1; ?></td>
									<?php
								}
								?>
								<td>
									<?php echo $Booking[$flag]->TicketName; ?>
								</td>
								<td>
									<?php
										$currency = $wpdb->get_var
										(
											$wpdb->prepare	
											(
												"SELECT CurrencySymbol FROM ".all_currency_listTable()." where CurrencyUsed = %d",
												"1"
											)
										);
									?>
									<?php
									$total_price=$Booking[$flag]->noOfTickets * $Booking[$flag]->TicketPrice
									?>
									<?php echo ($currency) .$total_price ; ?>
								</td>
								<td>
									<?php echo $Booking[$flag]->BookingStatus; ?>
								</td>
								<td>
									<a href="#" id="delete" class="icon-trash hovertip" data-original-title="<?php _e("Delete Booking?", events ); ?>" data-placement="top" onclick="deleteBooking(<?php echo $Booking[$flag]->BookingId ?>)"></a>
								</td>
							</tr>
							<?php
						}
							?>
					</table>
				</div>
				<div id="uxDivForEvent"></div>
				<div id="uxDivToCheck"></div>
			</div>
		</div>
	</div>
</div>
<div id="footer">
	<div class="split">
		<?php _e( "&copy; 2013 Events-Handler", events ); ?>
	</div>
	<div class="split right">
		<?php _e( "Powered by ", events ); ?>
		<a href="#" >
			<?php _e( "Events-Handler!", events ); ?>
		</a>
	</div>
</div>
</div>
</div>
<script type="text/javascript">
jQuery("#Clients").addClass("current");
oTable = jQuery('#booking-data-table').dataTable
({
	"bJQueryUI": false,
	"bAutoWidth": true,
	"sPaginationType": "full_numbers",
	"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
	"oLanguage": 
	{
		"sLengthMenu": "_MENU_"
	},
	"aaSorting": [[ 1, "asc" ]],
	"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 4 ] }]
});
function deleteBooking(BookingId)
{
	bootbox.confirm("<?php _e("Are you sure you want to delete this Booking?", events ); ?>", function(confirmed)
	{
		console.log("Confirmed: "+confirmed);
		if(confirmed == true)
		{
			jQuery.post(ajaxurl, "BookingId="+BookingId+"&param=deletebooking&action=bookLibrary", function(data)
			{
				window.location.reload(2000);
			});
		}
	});
}	
</script>