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
				<a href="#">
					<?php _e( "TICKETS", events); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<?php
		$count_ticket = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"SELECT count(TicketId) FROM " . addTicketTable(),""
			)
		);
		if($count_ticket < 1)
		{
		?>
			<a href="admin.php?page=add_ticket"  class="events-container-button green" style="margin-top: 10px;">
				<span><?php _e('ADD NEW TICKET', events); ?></span>
			</a>
		<?php
		}
		?>
		<div class="box">
			<div class="title">
				<?php _e("Tickets", events); ?>
				<span class="hide">
				</span>
			</div>
			<div class="content">
				<table width="100%" class="table table-striped" id="ticket-data-table">
				<thead>
					<tr>
						<th style="width:15%;"><?php _e("Ticket Name", events);?></th>
						<th style="width:15%;"><?php _e("Event Name", events);?></th>
						<th style="width:15%;"><?php _e("Event Date", events);?></th>
						<th style="width:10%;"><?php _e("Price", events);?></th>
						<th style="width:12%;"><?php _e("Available", events);?></th>
						<th style="width:12%;"><?php _e("Min. Ticket", events);?></th>
						<th style="width:12%;"><?php _e("Max. Ticket", events);?></th>
						<th style="width:6%;"></th>
					</tr>
				</thead>
				<?php
				global $wpdb;
				$Ticket=$wpdb->get_results
				(
					$wpdb->prepare
					(
						"SELECT ".addEventTable().".EventName,
						".addEventTable().".EventFrom,".addTicketTable().".TicketName , ".addTicketTable().".TicketPrice , ".addTicketTable().".TicketAvail,".addTicketTable().".TicketMinReq,
						". addTicketTable().".TicketMaxReq,". addTicketTable().".TicketId FROM ".addTicketTable()." 
						 JOIN " .addEventTable()." ON ".addTicketTable().".EventId	= ".addEventTable().".EventId",""
					)
				);
				$dateformat=$wpdb->get_var
				(
					$wpdb->prepare
					(
						"SELECT SettingsValue FROM " .settingTable() . " WHERE SettingsKey = %s","default_Date_Format"
					)
				);
				for($flag=0; $flag< count($Ticket); $flag++)
					{
				?>
						<tr>
							<td><?php echo $Ticket[$flag]->TicketName ?></td>
							<td><?php echo $Ticket[$flag]->EventName ?></td>
							<?php
							if($dateformat == 0)
							{
							?>
								<td><?php echo date('M d, Y', strtotime($Ticket[$flag]->EventFrom)); ?> </td>
							<?php
							}
							else if($dateformat == 1)
							{
							?>
								<td><?php echo date('Y/m/d', strtotime($Ticket[$flag]->EventFrom)); ?> </td>
							<?php
							}
							else if($dateformat == 2)
							{
							?>
								<td><?php echo date('m/d/Y', strtotime($Ticket[$flag]->EventFrom)); ?> </td>
							<?php
							}
							else if($dateformat == 3)
							{
							?>
								<td><?php echo date('d/m/Y', strtotime($Ticket[$flag]->EventFrom)); ?> </td>
							<?php
							}
							$currency = $wpdb->get_var
							(
								$wpdb->prepare
								(
									"SELECT CurrencySymbol FROM ".all_currency_listTable()." where CurrencyUsed = %d",
									"1"
								)
							);
							?>
							<td><?php echo ("$currency ").$Ticket[$flag]->TicketPrice ?></td>
							<td><?php echo $Ticket[$flag]->TicketAvail ?></td> 
							<td><?php echo $Ticket[$flag]->TicketMinReq ?></td>
							<td><?php echo $Ticket[$flag]->TicketMaxReq ?></td>
							<td>
								<a href="admin.php?page=editticket&tid=<?php echo $Ticket[$flag]->TicketId; ?>" class=" icon-edit"></a>
								<a href="#" class="icon-remove" onclick="delticket(<?php echo $Ticket[$flag]->TicketId; ?>)"></a>
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
	jQuery("#Tickets").addClass("current");
	oTable = jQuery('#ticket-data-table').dataTable
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
    	"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 6 ] },{ "bSortable": false, "aTargets": [ 7 ] }]
	});
	jQuery.colorbox.resize();
	function delticket(TicketId)
	{
		bootbox.confirm("<?php _e("Are you sure you want to delete this Ticket?", events ); ?>", function(confirmed)
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.post(ajaxurl, "TicketId="+TicketId+"&param=deleteTicket&action=ticketsLibrary", function(data)
				{
					window.location.reload();
				});
			}
		});
	}
</script>
