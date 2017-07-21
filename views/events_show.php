<?php
	global $wpdb;
	$url = plugins_url('', __FILE__);
	
	?>
<div id="dynamic_event_detail">
</div>
<div id="uxCalndarMainDiv">
	<div class="section">
		<div class="box" style="margin-top: 5px;">
			<div class="content">
				<table width="100%" class="table" style="text-align: center;">
					<thead>
						<tr>
							<th style="width:22%;"><?php _e('EVENT NAME', events);?></th>
							<th style="width:10%;"><?php _e('Venue', events);?></th>
							<th style="width:16%;"><?php _e('Address', events);?></th>
							<th style="width:18%;"><?php _e('Date', events);?></th>
							<th style="width:15%;"><?php _e('Time', events);?></th>
							<th style="width:15%;"></th>
						</tr>
					</thead>
					<?php
						global $wpdb;
						$Event = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"SELECT eventTable.*, CountryTable.CountryName FROM " . addEventTable() . " as eventTable inner join " . all_country_listTable() . " as CountryTable on eventTable.EventLocCountry = CountryTable.CountryId",""
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
						$timeformat=$wpdb->get_var
						(
							$wpdb->prepare
							(
								"SELECT SettingsValue FROM " .settingTable() . " WHERE SettingsKey = %s",
								"default_Time_Format"
							)
						);
						for($flag=0; $flag< count($Event); $flag++)
						{
					?>
						<tr>
							<td><?php echo $Event[$flag]->EventName; ?></td>
							<td><?php echo $Event[$flag]->EventLocName; ?></td>
							<td><?php echo $Event[$flag]->EventLocAddress; ?></td>							
							<?php
							if($Event[$flag]->EventFullDay == 1)
							{
								if($dateformat == 0)
								{
								?>
									<td><?php echo date('M d, Y', strtotime($Event[$flag]->EventFrom)); ?> - <?php echo date('M d, Y', strtotime($Event[$flag]->EventTo));  ?></td>
								<?php
								}
								if($dateformat == 1)
								{
								?>
									<td><?php echo date('Y/m/d', strtotime($Event[$flag]->EventFrom)); ?> - <?php echo date('Y/m/d', strtotime($Event[$flag]->EventTo)); ?></td>
								<?php
								}
								if($dateformat == 2)
								{
								?>
									<td><?php echo date('m/d/Y', strtotime($Event[$flag]->EventFrom)); ?> - <?php echo date('m/d/Y', strtotime($Event[$flag]->EventTo));  ?></td>
								<?php
								}
								if($dateformat == 3)
								{
								?>
									<td><?php echo date('d/m/Y', strtotime($Event[$flag]->EventFrom)); ?> - <?php echo date('d/m/Y', strtotime($Event[$flag]->EventTo)); ?></td>
								<?php
								}
							}
							else
							{
								if($dateformat == 0)
								{
								?>
									<td><?php echo date('M d, Y', strtotime($Event[$flag]->EventFrom)); ?></td>
								<?php
								}
								if($dateformat == 1)
								{
								?>
									<td><?php echo date('Y/m/d', strtotime($Event[$flag]->EventFrom)); ?></td>
								<?php
								}
								if($dateformat == 2)
								{
								?>
									<td ><?php echo date('m/d/Y', strtotime($Event[$flag]->EventFrom)); ?> </td>
								<?php
								}
								if($dateformat == 3)
								{
								?>
									<td><?php echo date('d/m/Y', strtotime($Event[$flag]->EventFrom)); ?></td>
								<?php
								}
							}
							$getHours = floor($Event[$flag]->EventSTotalTime / 60) ;
							$getMins = $Event[$flag]->EventSTotalTime % 60 ;
							$ShourFormat = $getHours . ":" . $getMins;
							$getEHours = floor($Event[$flag]->EventETotalTime / 60) ;
							$getEMins = $Event[$flag]->EventETotalTime % 60 ;
							$EhourFormat = $getEHours . ":" . $getEMins;
							if($timeformat == 0)
							{
								$Stime_in_12_hour_format  = DATE("g:i a", STRTOTIME($ShourFormat));
								$Etime_in_12_hour_format  = DATE("g:i a", STRTOTIME($EhourFormat));
							}
							else
							{
								$Stime_in_12_hour_format  = DATE("H:i", STRTOTIME($ShourFormat));
								$Etime_in_12_hour_format  = DATE("H:i", STRTOTIME($EhourFormat));
							}
							if($Event[$flag]->EventFullDay == 0)
							{
							?>
							<td><?php echo $Stime_in_12_hour_format . " - " . $Etime_in_12_hour_format;?></td> 
							<?php
							}
							else
							{
							?>
								<td>-</td>
							<?php
							}
							?>
							<td>
								<a id='uxLnkSubmitEvent' onclick="getEventId(<?php echo $Event[$flag]->EventId; ?>);" class="events-container-button green" style="margin-top: 10px;width: 110px;">
									<span><?php _e('View Detail', events); ?></span>
								</a>
							</td>
						</tr>
						<?php
						}
					?>
				</table>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	td
	{
		border: 1px solid #ccc;
		padding-left:10px;
		font-family: sans-serif;
		font-size: 12px;
	}
</style>
<script type="text/javascript">
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	oTable = jQuery('#event-data-table1').dataTable
	({
		"bJQueryUI": false,
		"bAutoWidth": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
		"oLanguage": 
		{
			"sLengthMenu": "_MENU_"
		},
		"aaSorting": [[ 5, "asc" ]],
		"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 4] },{ "bSortable": false, "aTargets": [ 5 ] }]
	});
	function backToConfirm()
	{
			jQuery("#uxCustomerGrid").css("display","block");
			jQuery("#uxConfirmGrid").css("display","none");
			jQuery("#uxCustomerLink").css("display","block");
			jQuery("#uxConfirmLink").css("display","none");
	}
	
	
	
	function bindNoOfTickes()
	{
		var ticketId = jQuery("#uxTicketType").val();
		var eventId = jQuery("#uxHdnEventId").val();
		if(ticketId == 0)
		{
			jQuery("#uxDivNoOfTickets").css("display","none");
			jQuery("#uxDivTicketPrice").css("display","none");
		}
		else
		{
			jQuery("#uxDivNoOfTickets").css("display","block");		
			jQuery.post(ajaxurl, "ticketId=" + ticketId + "&eventId=" + eventId +"&param=getMaxAndMinTicket&action=monthlycalendarLibrary", function(data) 
			{
				
				if(data == 0)
				{
					bootbox.alert("<?php _e("No more booking possible on this event.",events);?>");
					jQuery("#uxDivNoOfTickets").css("display","none");
					jQuery("#uxDivTicketPrice").css("display","none");
					jQuery("#uxDivSubmitTicket").css("display","none");
				}
				else
				{
					jQuery("#uxDivNoOfTickets").css("display","block");
					jQuery("#uxDivSubmitTicket").css("display","block");
					jQuery("#uxNoOfTicket").html(data);
				}
							
			});
			
		}
	}
	
	function calculatePrice()
	{
		var ticketId = jQuery("#uxTicketType").val();
		var noOfTickets = jQuery("#uxNoOfTicket").val();
		jQuery("#uxDivTicketPrice").css("display","block");
		jQuery.post(ajaxurl, "ticketId=" + ticketId + "&noOfTickets=" + noOfTickets + "&param=getSingleTicketPrice&action=monthlycalendarLibrary", function(data) 
		{
				
				jQuery("#uxTicketPrice").html(data);
		});
		
	}
		
	function checkExistingCustomerBooking()
	{
		var uxEmail = jQuery('#uxEmail').val();
		jQuery.post(ajaxurl, "uxEmailAddress="+uxEmail+ "&param=getExistingCustomer&action=monthlycalendarLibrary", function(data) 
		{
			if(jQuery.trim(data) != "newCustomer")
			{
				
				var dataa = data.trim();
				jQuery("#scriptExistingCustomer").html(dataa);
			}
			else
			{
				jQuery('#uxEmail').val(jQuery('#uxEmail').val());
			}	
		});
	}
	
	
	function backToCalendar()
	{
		var actual_link = '<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>';
		var arrayOfLinks = actual_link.split("&");
		var backLink = arrayOfLinks[0];
		jQuery("#uxLnkbackToCalendar").attr("href",backLink);
	}
	function backToEvents()
	{
		jQuery("#uxDivSingleEvent").css("display","block");
		jQuery("#uxDivCustomer").css("display","none");
		jQuery("#uxDivbackToCalendar").css("display","block");
		jQuery("#uxCustomerLink").css("display","none");
	}
	function checkDropDown()
		{
			
			var ticketId = jQuery("#uxTicketType").val();
			var noOfTickets = jQuery("#uxNoOfTicket").val();
			if(ticketId == 0)
			{
				
				bootbox.alert("<?php _e("Please choose ticket type", events); ?>");
			}
			else
			{	
				if(noOfTickets == 0)
				{
					
					bootbox.alert("<?php _e("Please choose Number of tickets", events); ?>");
				}
				else
				{
					jQuery("#uxDivbackToCalendar").css("display","none");
					jQuery("#uxDivSingleEvent").css("display","none");
					jQuery("#uxDivCustomer").css("display","block");
					jQuery("#uxCustomerLink").css("display","block");
				}		
				
			}
		}
	function getEventId(id)
	{
		jQuery.post(ajaxurl, "eventId=" + id + "&param=showSingleEvent&action=monthlycalendarLibrary", function(data) 
		{
			jQuery("#uxCalndarMainDiv").css("display","none");
			jQuery("#dynamic_event_detail").html(data);
		});	
		
	}
</script>
