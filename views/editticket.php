<?php
	$Ticketid = $_REQUEST["tid"];
	$Ticket=$wpdb->get_row
	(
		$wpdb->prepare
		(
			"SELECT * from " . addTicketTable(). " WHERE TicketId = %d",
			$Ticketid
		)
	);
?>
<input type="hidden" name="uxHideenTicketId" id="uxHideenTicketId" value="<?php echo $Ticketid; ?>" />
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
				<a href="admin.php?page=tickets">
					<?php _e( "TICKETS", events); ?>
				</a>
			</li>
			<li class="last">
				<a href="#">
					<?php _e( "EDIT TICKET", events); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<a href="admin.php?page=tickets" class="events-container-button green" style="margin-top: 5px;">
			<span style="height: 100%;"><?php _e('Back to Tickets', events); ?></span>
    	</a>
		<div class="box">
			<div class="title">
				<?php _e("EDIT TICKET", events); ?>
			</div>
			<div id="content">
				<form id="uxFrmEditTicket" class="events-container-form" method="post" action="">
					<div class="message green" id="successEditMessageTicket" style="display:none;margin-left:10px;">
						<span>
							<strong>
								<?php _e( "Success! Ticket has been updated.", events ); ?>
							</strong>
						</span>
					</div>
					<div class="message red" id="errorEditMessageMaximum" style="display:none;margin-left:10px;">
						<span>
							<strong>
								<?php _e( "Error! Minimum Tickets are greater than Maximum Ticket.", events ); ?>
							</strong>
						</span>
					</div>
					<div class="body" id="editTicketData">
						<div class="row">
							<label>
								<?php _e("Select Event :", events);?>
							</label>
							<div class = "right">
							<?php
								global $wpdb;
								$select=$wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT * FROM " .addEventTable(),""
									)
								);
							?>
							<select name="uxEditEventDDL" id="uxEditEventDDL" style="width:100%">
							<?php
							$chk="";
							for($flag=0; $flag<count($select); $flag++)
								{
									if($select[$flag]->EventId == $Ticket->EventId)
									{
										?>
										<option selected="selected" value="<?php echo $select[$flag]->EventId; ?>" $chk><?php echo $select[$flag]->EventName; ?></option>
										<?php
									}
									else
									{
										?>
										<option value="<?php echo $select[$flag]->EventId; ?>" $chk><?php echo $select[$flag]->EventName; ?></option>
										<?php
									}
								}
							?>
							</select>
						</div>
						</div>
						<div class="row">
							<label >
								<?php _e("Ticket Name :" ,events)?>
							</label>
							<div class="right">
								<input type="text" name="uxeditTicketName" id="uxeditTicketName" value="<?php echo $Ticket->TicketName?>">
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e("Description :", events); ?>
							</label>
							<div class="right">
							<?php
								$content = stripslashes($Ticket->TicketDesc)
							?>
							<?php wp_editor($content, $id = 'uxeditTicketDesc', $prev_id = 'title', $media_buttons = true, $tab_index = 1);?>
							</div>
						</div>
						<div class="row">
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
							<label>
								<?php _e("Price (".$currency.") :" ,events)?>
							</label>
							<div class="right">
								<input type="text" name="uxeditTicketPrice" id="uxeditTicketPrice" value="<?php echo $Ticket->TicketPrice?>">
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e("Available Tickets :" ,events)?>
							</label>
							<div class="right">
								<input type="text" name="uxeditTicketAvail" id="uxeditTicketAvail" value="<?php echo $Ticket->TicketAvail?>">
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e("Minimum :" ,events)?>
							</label>
							<div class="right">
								<input type="text" name="uxeditTicketReqmin" id="uxeditTicketReqmin" value="<?php echo $Ticket->TicketMinReq?>">
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e("Maximum :" ,events)?>
							</label>
							<div class="right">
								<input type="text" name="uxeditTicketReqmax" id="uxeditTicketReqmax" value="<?php echo $Ticket->TicketMaxReq?>">
							</div>
						</div>
						<div class="row" style="border-bottom:none !important">
							<div class="right">
								<button type="submit" class="events-container-button green">
									<span>
										<?php _e( "Submit & Save Changes", events ); ?>
									</span>
								</button>
								
							</div>
						</div>
					</div>
				</form>
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
	jQuery(document).ready(function()
	{
		jQuery('#uxeditTicketStart').datepicker
		({
			dateFormat : 'yy-mm-dd',
			yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
			changeMonth: true,
			changeYear: true,
			onClose: function( selectedDate )
			{
				jQuery( "#uxeditTicketEnd" ).datepicker( "option", "minDate", selectedDate );
				var label = jQuery('label[for="uxeditTicketStart"]');
				label.text('Success!').addClass('valid');
			}
		});
	});
	jQuery(document).ready(function()
	{
		jQuery('#uxeditTicketEnd').datepicker
		({
			dateFormat : 'yy-mm-dd',
			yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
			changeMonth: true,
			changeYear: true,
			onClose: function( selectedDate )
			{
				jQuery( "#uxeditTicketStart" ).datepicker( "option", "maxDate", selectedDate );
				var label = jQuery('label[for="uxeditTicketEnd"]');
				label.text('Success!').addClass('valid');
			}
		});
	});
	jQuery("#uxFrmEditTicket").validate
	({
		rules:
		{
			uxeditTicketName:
			{
				required: true,
			},
			uxeditTicketPrice:
			{
				required: true,
				number: true
			},
			uxeditTicketAvail:
			{
				required: true,
				digits: true
			},
			uxeditTicketStart:
			{
				required : true,
			},
			uxeditTicketEnd:
			{
				required: true,
			},
			uxeditTicketReqmin:
			{
				required: true,
				digits: true
			},
			uxeditTicketReqmax:
			{
				required: true,
				digits: true
			}
		},
		submitHandler: function(form)
		{
			var uxeditTicketAvail = parseInt(jQuery("#uxeditTicketAvail").val());
			var uxeditTicketReqmin = parseInt(jQuery("#uxeditTicketReqmin").val());
			var uxeditTicketReqmax = parseInt(jQuery("#uxeditTicketReqmax").val());
			var ticketid = jQuery("#uxHideenTicketId").val();
			if(parseInt(uxeditTicketAvail) < parseInt(uxeditTicketReqmin))
			{
				bootbox.alert("<?php _e("Error! You have entered minimum tickets are greater than Available tickets", events ); ?>");
			}
			else if(parseInt(uxeditTicketAvail) < parseInt(uxeditTicketReqmax))
			{
				bootbox.alert("<?php _e("Error! You have entered maximum tickets are greater than Available tickets", events ); ?>");
			}
			else if(parseInt(uxeditTicketReqmin) > parseInt(uxeditTicketReqmax))
			{
				bootbox.alert("<?php _e("Error! Minimum Tickets are greater than Maximum Ticket.", events ); ?>");
			}			
			else
			{
				if (jQuery("#wp-uxeditTicketDesc-wrap").hasClass("tmce-active"))
				{
					var uxeditTicketDesc = encodeURIComponent(tinyMCE.get('uxeditTicketDesc').getContent());
				}
				else
				{
					var uxeditTicketDesc = encodeURIComponent(jQuery('#uxeditTicketDesc').val());
				}
				
				jQuery.post(ajaxurl, jQuery(form).serialize() + "&ticketid=" + ticketid + "&uxeditTicketDesc=" + uxeditTicketDesc +"&param=updateTicket&action=ticketsLibrary", function(data)
				{
					
					jQuery("#successEditMessageTicket").css("display","block");
					jQuery('#errorEditMessageMaximum').css("display","none");
					setTimeout(function()
					{
						jQuery("#successEditMessageTicket").css("display","none");
						jQuery('#errorEditMessageMaximum').css("display","none");
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page=tickets";
					}, 2000);
				});
			}
		}
		
	});
	jQuery('#uxeditTicketPrice').on('keypress', function(evt) 
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
		});
		jQuery('#uxeditTicketAvail').on('keypress', function(evt) 
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
		});
		jQuery('#uxeditTicketReqmin').on('keypress', function(evt) 
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
		});
		jQuery('#uxeditTicketReqmax').on('keypress', function(evt) 
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
		});
</script>
