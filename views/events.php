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
				<a href="admin.php?page=eventshandler">
					<?php _e( "EVENTS", events); ?>
				</a>
			</li>		
		</ul>
	</div>
	<div class="section">
		<?php
		$count_event = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT count(EventId) FROM " .addEventTable(),""
			)
		);
		if($count_event < 3)
		{
		?>
			<a href="admin.php?page=add_event" class="events-container-button green" style="margin-top: 10px;">
				<span><?php _e('Add New Event', events); ?></span>
			</a>
		<?php
		}
		?>
		<div class="message green" id="successMessageDeleteEvent" style="display:none;margin-left:10px;">
			<span>
				<strong>
					<?php _e( "Success! Event has been deleted.", events ); ?>
				</strong>
			</span>
		</div>
		<div class="message red" id="timeErrorMessage" style="display:none;margin-left:10px;">
			<span>
				<strong>
					<?php _e( "Error! Please Enter the Valid Time.", events ); ?>
				</strong>
			</span>
		</div>
		<div id="uxDivDeleteMessage">
			<div class="message red" id="messageNotDeleteEvent" style="display:none;">
				<span>
					<strong>
						<?php _e( "Bookings associated this event. It can't be deleted.", events ); ?>
					</strong>
				</span>
			</div>
		</div>
		<div class="box">
			<div class="title">
				<?php _e('Events', events); ?>
			</div>
			<div class="content">
				<table width="100%" class="table table-striped" id="event-data-table">
					<thead>
						<tr>
							<th style="width:12%;"><?php _e('Name', events);?></th>
							<th style="width:15%;"><?php _e('Venue', events);?></th>
							<th style="width:16%;"><?php _e('Address', events);?></th>
							<th style="width:8%;"><?php _e('Full Day', events);?></th>
							<th style="width:18%;"><?php _e('Date', events);?></th>
							<th style="width:15%;"><?php _e('Time', events);?></th>
							<th style="width:7%;"></th>
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
								?>
								<td><?php echo _e("Yes",events); ?></td>
								<?php
								}
								else
								{
								?>
								<td><?php echo _e("No",events); ?></td>
								<?php
								}
							?>
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
								<td><?php echo date('m/d/Y', strtotime($Event[$flag]->EventFrom)); ?> </td>
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
								<a href="admin.php?page=edit_event&eid=<?php echo $Event[$flag]->EventId ?>" class="icon-edit hovertip" data-original-title="<?php _e("Edit Event?", events ); ?>" data-placement="top" ></a>
								<a href="#" id="delete" class="icon-trash hovertip" data-original-title="<?php _e("Delete Event?", events ); ?>" data-placement="top" onclick="eventDelete(<?php echo $Event[$flag]->EventId ?>)"></a>
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
<div id="footer">
 	<div class="split">
 	 	<?php _e( "&copy; 2013 Events Handler. All Rights Reserved.", events ); ?>
 	</div>
	 <div class="split right">
  		<?php _e( "Powered by ", events ); ?>
  		 <a href="#" >
   		 <?php _e( "Events Handler!", events ); ?>
  		 </a>
 	</div>
</div>
</div>
</div>
<input type="text" name="uxHdnEventId" id="uxHdnEventId" value="0" style="visibility: hidden"/>

<script type="text/javascript">
jQuery("#Events").addClass("current");
oTable = jQuery('#event-data-table').dataTable
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
		"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 5] },{ "bSortable": false, "aTargets": [ 6 ] }]
	});
	function eventDelete(EventId)
	{	
		bootbox.confirm("<?php _e("Are you sure you want to delete this Event?", events ); ?>", function(confirmed)
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.post(ajaxurl, "EventId="+EventId+"&param=deleteEvents&action=eventsLibrary", function(data)
				{
					if(data == 0)
					{
						bootbox.alert("<?php echo _e("Bookings associated with this event. You cannot delete it",events);?>");
					}
					else
					{
						jQuery("#uxDivDeleteMessage").html(data);
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}
				});
			}
		});
	}
	
</script>