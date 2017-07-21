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
					<?php _e( "ADD TICKET", events); ?>
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
				<?php _e("ADD TICKET", events); ?>
			</div>
			<div id="content">
				<form id="uxFrmAddTicket" class="events-container-form" method="post" action="">
					<div class="message green" id="successMessageTicket" style="display:none;margin-left:10px;">
						<span>
							<strong>
								<?php _e( "Success! Ticket has been saved.", events ); ?>
							</strong>
						</span>
					</div>
					<div class="message red" id="errorMessageSelectEvent" style="display:none;margin-left:10px;">
						<span>
							<strong>
								<?php _e( "Error! Please Choose a Event.", events ); ?>
							</strong>
						</span>
					</div>
					<div class="message red" id="errorMessageMaximum" style="display:none;margin-left:10px;">
						<span>
							<strong>
								<?php _e( "Error! Minimum Tickets are greater than Maximum Ticket.", events ); ?>
							</strong>
						</span>
					</div>
					<div class="body" id="addTicketData">
						<div class="row">
						<label>
							<?php _e("Select Event :", events);?>
						</label>
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
						<div class = "right">
							<select name="uxEventDDL" id="uxEventDDL" onchange="showCheck();" style="width:100%">
								<option value="0">
									<?php _e("Choose Event", events); ?>
								</option>
								<?php
									for($flag=0; $flag<count($select); $flag++)
									{
								?>
										<option value="<?php echo $select[$flag]->EventId; ?>">
											<?php echo $select[$flag]->EventName; ?>
										</option>
								<?php
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
								<input type="text" name="uxTicketName" id="uxTicketName">
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e("Description :", events); ?>
							</label>
							<div class="right">
								<?php wp_editor("", $id = 'uxTicketDesc', $prev_id = 'title', $media_buttons = true, $tab_index = 1);?>
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
								<input type="text" name="uxTicketPrice" id="uxTicketPrice">
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e("Available Tickets :" ,events)?>
							</label>
							<div class="right">
								<input type="text" name="uxTicketAvail" id="uxTicketAvail">
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e("Minimum :" ,events)?>
							</label>
							<div class="right">
								<input type="text" name="uxTicketReqmin" id="uxTicketReqmin">
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e("Maximum :" ,events)?>
							</label>
							<div class="right">
								<input type="text" name="uxTicketReqmax" id="uxTicketReqmax">
							</div>
						</div>
						<div class="row" style="border-bottom:none !important">
							<label>
							</label>
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
	oTable = jQuery('#ticket-data-table').dataTable
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
		jQuery(document).ready(function()
		{
			jQuery('#uxTicketStart').datepicker
			({
				dateFormat : 'yy-mm-dd',
				yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
				changeMonth: true,
				changeYear: true,
				onClose: function( selectedDate ) 
				{
					jQuery( "#uxTicketEnd" ).datepicker( "option", "minDate", selectedDate );
					var label = jQuery('label[for="uxTicketStart"]');
					label.text('Success!').addClass('valid');
				}
			});
		});
		jQuery(document).ready(function()
		{
			jQuery('#uxTicketEnd').datepicker
			({
				dateFormat : 'yy-mm-dd',
				yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
				changeMonth: true,
				changeYear: true,
				onClose: function( selectedDate ) 
				{
					jQuery( "#uxTicketStart" ).datepicker( "option", "maxDate", selectedDate );
					var label = jQuery('label[for="uxTicketEnd"]');
					label.text('Success!').addClass('valid');
				}
			});
		});
		jQuery("#uxFrmAddTicket").validate
		({
			rules:
			{
				uxTicketName:
				{
					required: true,
				},
				uxTicketPrice:
				{
					required: true,
					number: true
				},
				uxTicketAvail: 
				{
					required: true,
					digits: true
				},
				uxTicketReqmin: 
				{
					required: true,
					digits: true
				},	
				uxTicketReqmax:
				{
					required: true,
					digits: true
				}
			},
			submitHandler: function(form)
			{
				var uxEventId = jQuery("#uxEventDDL").val();
				var uxTicketAvail = jQuery("#uxTicketAvail").val();
				var uxTicketReqmin = jQuery("#uxTicketReqmin").val();
				var uxTicketReqmax = jQuery("#uxTicketReqmax").val();
				
				if(parseInt(uxTicketAvail) < parseInt(uxTicketReqmin))
				{
					bootbox.alert("<?php _e("Error! You have entered minimum tickets are greater than Available tickets", events ); ?>");
				}
				else if( parseInt(uxTicketAvail) < parseInt(uxTicketReqmax ))
				{
					bootbox.alert("<?php _e("Error! You have entered maximum tickets are greater than Available tickets", events ); ?>");
				}
				else if(uxEventId == 0)
				{
					bootbox.alert("<?php _e("Error! Please Choose a Event.", events ); ?>");
				}
				else if(parseInt(uxTicketReqmin) > parseInt(uxTicketReqmax))
				{
					bootbox.alert("<?php _e("Error! Minimum Tickets are greater than Maximum Ticket.", events ); ?>");
				}
				else
				{
					if (jQuery("#wp-uxTicketDesc-wrap").hasClass("tmce-active"))
					{
						var uxTicketDesc  = encodeURIComponent(tinyMCE.get('uxTicketDesc').getContent());
					}
					else
					{
						var uxTicketDesc  = encodeURIComponent(jQuery('#uxTicketDesc').val());
					}
					jQuery.post(ajaxurl, jQuery('#uxFrmAddTicket').serialize() + "&uxTicketDesc="+uxTicketDesc+"&param=insertTicket&action=ticketsLibrary", function(data)
					{
					
						jQuery("#successMessageTicket").css("display","block");
						jQuery('#errorMessageSelectEvent').css("display","none");
						jQuery('#errorMessageMaximum').css("display","none");
						jQuery.colorbox.resize();
						setTimeout(function()
						{
							jQuery("#successMessageTicket").css("display","none");
							jQuery('#errorMessageSelectEvent').css("display","none");
							jQuery('#errorMessageMaximum').css("display","none");
							jQuery.colorbox.resize();
							var checkPage = "<?php echo $_REQUEST['page']; ?>";
							window.location.href = "admin.php?page=tickets";
						}, 2000);
					});
				}
			}
		});
		jQuery('#uxTicketPrice').on('keypress', function(evt) 
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
		});
		jQuery('#uxTicketAvail').on('keypress', function(evt) 
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
		});
		jQuery('#uxTicketReqmin').on('keypress', function(evt) 
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
		});
		jQuery('#uxTicketReqmax').on('keypress', function(evt) 
		{
			var charCode = (evt.which) ? evt.which : event.keyCode;
			return !(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57));
		});
</script>