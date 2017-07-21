<?php

	$EventId = $_REQUEST["eid"];
		$Event=$wpdb->get_row
		(
			$wpdb->prepare
			(
				"SELECT * from " . addEventTable(). " WHERE EventId = %d",
				$EventId
			)
		);

?>
<input type="hidden" name="uxHidnEventId" id="uxHidnEventId" value="<?php echo $EventId; ?>" />
<input type="hidden" name="uxHidnStartDate" id="uxHidnStartDate" value="<?php echo $Event->EventFrom; ?>" />
<input type="hidden" name="uxHidnEndDate" id="uxHidnEndDate" value="<?php echo $Event->EventTo; ?>" />

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
			<li class="last">
				<a href="#">
					<?php _e( "EDIT EVENT", events); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<a href="admin.php?page=eventshandler" class="events-container-button green" style="margin-top: 10px;">
			<span style="height: 100%;"><?php _e('Back to Events', events); ?></span>
		</a>
		<div class="box">
			<div class="title">
				<?php _e('Edit Event', events); ?>
			</div>
			<div class="content">
			<form  method="post" action="" class="events-container-form" id="uxFormEditEvent">
				<div class="message green" id="successMessageEventsUpdate" style="display:none;margin-left:10px;">
					<span>
						<strong>
							<?php _e( "Success! Event has been saved.", events ); ?>
						</strong>
					</span>
				</div>
				<div id="EditEventsData"></div>
				<div class="body">
					<div class="row">
						<label>
							<?php _e("Event Color Code :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxEditEventColorCode" id="uxEditEventColorCode" value="<?php echo $Event->EventColorCode?>">
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e("Event Name :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxEditEventName" id="uxEditEventName" value="<?php echo $Event->EventName?>">
						</div>
					</div>
					<div class="row">		
						<label>
							<?php _e("Event Description :", events);?>
						</label>
						<div class = "right">
							<?php wp_editor(stripslashes($Event->EventDescription), $id = 'uxEditDesc', $prev_id = 'title', $media_buttons = true, $tab_index = 1);?>
						</div>
					</div>
					<div class="row">
						<label style="top:10px"><?php _e("Full Day :", events);?></label>
						<div class="right">
							<?php
							if($Event->EventFullDay == 1)
							{
								?>
								<input type="checkbox" checked="checked" name="uxEditEventFullDay" id="uxEditEventFullDay" value="1" onclick="EditFullday()"/>
								<?php
							}
							else {
								?>
								<input type="checkbox" name="uxEditEventFullDay" id="uxEditEventFullDay" value="1" onclick="EditFullday()"/>
								<?php
							}
							?>
						</div>
					</div>	
					<div class="row" id="divFullDayEditFrmEvent" style="display: block;">	
						
							<label id="uxLblEventFrom" style="display: none">
								<?php _e("Event From :", events);?>
							</label>
							
							<label id="uxLblEventDate" style="display: none">
								<?php _e("Event Date :", events);?>
							</label>
							
						<div class = "right">
							<input type="text" name="uxEditFromDate" id="uxEditFromDate" value="<?php echo $Event->EventFrom?>">
						</div>
					</div>
					<div class="row" id="divFullDayEditToEvent" style="display: none;">	
						<label>
							<?php _e("Event To :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxEditToDate" id="uxEditToDate" value="<?php echo $Event->EventTo?>">
						</div>
					</div>	
					<div class="row" id="uxFullDayEditSEvent" style="display: block;">
						<label>
							<?php _e("Start Time :", events);?>
						</label>
						<div class = "right">
							<?php
								$EventSTime =  $Event->EventSTotalTime;
								$Shr = floor(($EventSTime)/60);
								$Smn = ($EventSTime) % 60;
								$hourFormatS = $Shr . ":" . "00";
								$Shr1  = DATE("h", STRTOTIME($hourFormatS));
								$SAm = DATE("A", STRTOTIME($hourFormatS));
								$EventETime = $Event->EventETotalTime;
								$Ehr = floor(($EventETime)/60);
								$Emn = ($EventETime) % 60;
								$hourFormatE = $Ehr . ":" . "00";
								$Ehr1  = DATE("h", STRTOTIME($hourFormatE));
								$EAm = DATE("A", STRTOTIME($hourFormatE));
							?>
							<select name="uxEditEventSHour" id="uxEditEventSHour">
								<?php
									for($StHr=0; $StHr <= 12; $StHr++)
									{
										if($StHr < 10)
										{
											if($Shr1 == $StHr)
											{
												echo "<option selected='selected' value=0" .$StHr.">0".$StHr."</option>";
											}
											else {
												echo "<option value=0" .$StHr.">0".$StHr."</option>";	
											}
											
										}
										else
										{
											if($Shr1 == $StHr)
											{
												echo"<option selected='selected' value=" .$StHr.">".$StHr."</option>";
											}
											else {
												echo"<option value=" .$StHr.">".$StHr."</option>";
											}
											
										}
									}
								?>
							</select>
							<select name="uxEditEventSMin" id="uxEditEventSMin">
								<?php
									for($StMin=0; $StMin <= 55; $StMin += 5)
									{
										if($StMin < 10)
										{
											if($Smn == $StMin)
											{
												echo "<option selected='selected' value=0" .$StMin.">0".$StMin."</option>";
											}
											else {
												echo "<option value=0" .$StMin.">0".$StMin."</option>";
											}
										}
										else
										{
											if($Smn == $StMin)
											{
												echo"<option selected='selected' value=" .$StMin.">".$StMin."</option>";
											}
											else {
												echo"<option value=" .$StMin.">".$StMin."</option>";
											}
											
										}
									}
								?>
							</select>
							<select name="uxEditEventSTime" id="uxEditEventSTime">
								<?php
									if($SAm == "AM")
									{	
										?>
											<option selected="selected" value="<?php _e("AM", events);?>">
											<?php _e("AM", events);?>
											</option>
										<?php
									}
									else {
										?>
											<option value="<?php _e("AM", events);?>">
											<?php _e("AM", events);?>
											</option>
										<?php
									}
									
									if($SAm == "PM")
									{
										?>
											<option selected="selected" value="<?php _e("PM", events);?>">
											<?php _e("PM", events);?>
											</option>
										<?php
									}
									else {
										?>
											<option value="<?php _e("PM", events);?>">
											<?php _e("PM", events);?>
											</option>
										<?php
									}	
								?>
							</select>
						</div>
					</div>
					<div class="row" id="uxFullDayEditEndEvent" style="display: block;">
						<label>
							<?php _e("End Time :", events);?>
						</label>&nbsp;
						<div class = "right">
							<select name="uxEditEventEndHour" id="uxEditEventEndHour">
								<?php
									for($EndHr=0; $EndHr <= 12; $EndHr++)
										{
											if($EndHr < 10)
											{
												if($Ehr1 == $EndHr)
												{
													echo "<option selected='selected' value=0" .$EndHr.">0".$EndHr."</option>";
												}
												else {
													echo "<option value=0" .$EndHr.">0".$EndHr."</option>";
												}
											}
											else
											{
												if($Ehr1 == $EndHr)
												{
													echo"<option selected='selected' value=" .$EndHr.">".$EndHr."</option>";
												}
												else {
													echo"<option value=" .$EndHr.">".$EndHr."</option>";
												}
											}
										}
								?>
							</select>
							<select name="uxEditEventEndMin" id="uxEditEventEndMin">
								<?php
									for($EndMin=0; $EndMin <= 55; $EndMin += 5)
										{
											if($EndMin < 10)
											{
												if($Emn == $EndMin)
												{
													echo "<option selected='selected' value=0" .$EndMin.">0".$EndMin."</option>";
												}
												else {
													echo "<option value=0" .$EndMin.">0".$EndMin."</option>";
												}
											}
											else
											{
												if($Emn == $EndMin)
												{
													echo"<option selected='selected' value=" .$EndMin.">".$EndMin."</option>";
												}
												else {
													echo"<option value=" .$EndMin.">".$EndMin."</option>";
												}
											}
										}
								?>
							</select>
							<select name="uxEditEventEndTime" id="uxEditEventEndTime">
								<?php
									if($EAm == "AM")
									{	
										?>
											<option selected="selected" value="<?php _e("AM", events);?>">
											<?php _e("AM", events);?>
											</option>
										<?php
									}
									else {
										?>
											<option value="<?php _e("AM", events);?>">
											<?php _e("AM", events);?>
											</option>
										<?php
									}
									
									if($EAm == "PM")
									{
										?>
											<option selected="selected" value="<?php _e("PM", events);?>">
											<?php _e("PM", events);?>
											</option>
										<?php
									}
									else {
										?>
											<option value="<?php _e("PM", events);?>">
											<?php _e("PM", events);?>
											</option>
										<?php
									}	
								?>
								
								
							</select>
						</div>
					</div>
					<div class="row">		
						<label>
							<?php _e("Venue Name :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxEditLocationName" id="uxEditLocationName" value="<?php echo $Event->EventLocName?>">
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e("Venue Address :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxEditLocationAddress" id="uxEditLocationAddress" onkeyup="ChangeLocation()" value="<?php echo $Event->EventLocAddress?>">
						</div>
					</div>	
					<div class="row">	
						<label>
							<?php _e("Venue City :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxEditLocationCity" id="uxEditLocationCity" value="<?php echo $Event->EventLocCity?>">
						</div>
					</div>
					<div class="row">	
						<label>
							<?php _e("Venue Country :", events);?>
						</label>
						<div class = "right">
							<?php
								global $wpdb;
								$show=$wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT * FROM " .all_country_listTable(),""
									)
								);
							?>
							
								<select name="uxEditLocationCountry" id="uxEditLocationCountry" onchange="ChangeLocation()">
								<?php
									$chk="";
									for($flag=0; $flag<count($show); $flag++)
									{
										if($show[$flag]->CountryId == $Event->EventLocCountry)
										{
											?>
												<option selected="selected" value="<?php echo $show[$flag]->CountryId; ?>" $chk><?php echo $show[$flag]->CountryName; ?></option>
											<?php
										}
										else {
											?>
												<option value="<?php echo $show[$flag]->CountryId; ?>" $chk><?php echo $show[$flag]->CountryName; ?></option>
											<?php
										}
									}
									?>
								</select>
							
						</div>
					</div>
					<div style="margin-left: 12px;">
						<div id="showMap"></div>
					</div>
					<div class="row" style="border-bottom:none !important;">
						<div class="right">
							<button type="submit" class="events-container-button green">
								<span>
									<?php _e( "Update Event", events); ?>
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
	jQuery("#Events").addClass("current");
	
	jQuery(document).ready(function()
	{
		EditFullday();
		var address = "<?php echo $Event->EventLocAddress; ?>";
		var country = "<?php echo $Event->EventLocCountry; ?>";
		jQuery.post(ajaxurl, "address=" + address + "&country=" + country +"&param=onEditLoad&action=eventsLibrary", function(data) 
		{
			jQuery("#showMap").html(data);
		});
		
		// jquery code for color
		jQuery('#uxEditEventColorCode').ColorPicker
			({		
				onSubmit: function(hsb, hex, rgb, el) 
				{
					jQuery(el).val( '#' + hex);
					jQuery(el).ColorPickerHide();
				},
				onBeforeShow: function() 
				{
					jQuery(this).ColorPickerSetColor(this.value);
				}
			}).bind('onblur', function()
			{
				jQuery(this).ColorPickerSetColor(this.value);
			});

	});
	
	
	
	jQuery("#uxFormEditEvent").validate
	({
		rules:
		{
			uxEditEventName: "required",
			uxEditLocationName:
			{
				required: true
			},
			uxEditLocationAddress:
			{
				required: true
			},
			uxEditLocationCountry:
			{
				required: true
			},
			uxEditFromDate:
			{
				required: true
			},
			uxEditToDate:
			{
				required: true
			}
		},	
		submitHandler: function(form) 
		{
			
			var uxEditEventSHour=jQuery("#uxEditEventSHour").val();
			var uxEditEventSMin=jQuery("#uxEditEventSMin").val();
			var uxEditEventSTime=jQuery("#uxEditEventSTime").val();
			var uxEditEventEndHour=jQuery("#uxEditEventEndHour").val();
			var uxEditEventEndMin=jQuery("#uxEditEventEndMin").val();
			var uxEditEventEndTime=jQuery("#uxEditEventEndTime").val();
			var uxEditEventFullDay=jQuery("#uxEditEventFullDay").prop("checked");
			var startDate = jQuery("#uxEditFromDate").val();
			var endDate = jQuery("#uxEditToDate").val();
			if(uxEditEventSTime == "PM")
				{
					if(uxEditEventSHour <= 11)
					{
						uxEditEventSHours = parseInt(uxEditEventSHour) + 12;
					}
					else if(uxEditEventSHour == 12)
					{
						uxEditEventSHours = 12;
					}
				}
				else if(uxEditEventSTime == "AM")
				{
					if(uxEditEventSHour == 12)
					{
						uxEditEventSHours = 0;
					}
					else 
					{
						uxEditEventSHours = uxEditEventSHour;
					}
				}
				else 
				{
					uxEditEventSHours = uxEditEventSHour;
				}
				if(uxEditEventEndTime == "PM")
				{
					if(uxEditEventEndHour <= 11)
					{
						uxEditEventEndHours = parseInt(uxEditEventEndHour) + 12;
					}
					else if(uxEditEventEndHour == 12)
					{
						uxEditEventEndHours = 12;
					}
				}
				else if(uxEditEventEndTime == "AM")
				{
					if(uxEditEventEndHour == 12)
					{
						uxEditEventEndHours = 0;
					}
					else 
					{
						uxEditEventEndHours = uxEditEventEndHour;
					}
				}
				else 
				{
					uxEditEventEndHours = uxEditEventEndHour;
				}
				uxESHours = (uxEditEventSHours * 60) + parseInt(uxEditEventSMin);
				uxEEHours = (uxEditEventEndHours * 60) + parseInt(uxEditEventEndMin);
				var eventId = jQuery("#uxHidnEventId").val();
				if (jQuery("#wp-uxEditDesc-wrap").hasClass("tmce-active"))
				{
					var eventDesc = encodeURIComponent(tinyMCE.get('uxEditDesc').getContent());
				}
				else
				{
					var eventDesc = encodeURIComponent(jQuery('#uxEditDesc').val());
				}
				if(uxEditEventFullDay == true)
				{
					var fromDate = Date.parse(startDate);
					var fromDate1 = new Date(fromDate);
					var toDate = Date.parse(endDate);
					var toDate1 = new Date(toDate);
					if(fromDate1 > toDate1)
					{
						bootbox.alert("<?php _e("Start Date must be greater than or equal to end date.", events ); ?>");
					}
					else
					{
						jQuery.post(ajaxurl, jQuery(form).serialize() + "&EventId=" + eventId + "&EventDesc=" + eventDesc +"&param=updateEvent&action=eventsLibrary", function(data) 
						{
							jQuery("#successMessageEventsUpdate").css("display","block");
							setTimeout(function() 
							{
								jQuery("#successMessageEventsUpdate").css("display","none");
								window.location.href = "admin.php?page=eventshandler";
							}, 2000);
						});
					}
				}
				else
				{	
					if(uxESHours >= uxEEHours)
					{
						bootbox.alert("<?php _e("Please Enter Valid Time.", events ); ?>");
					}
					else
					{
						
						jQuery.post(ajaxurl, jQuery(form).serialize() + "&EventId=" + eventId + "&EventDesc=" + eventDesc +"&param=updateEvent&action=eventsLibrary", function(data) 
						{
							jQuery.colorbox.resize();
							jQuery("#successMessageEventsUpdate").css("display","block");
							setTimeout(function() 
							{
								jQuery("#successMessageEventsUpdate").css("display","none");
								window.location.href = "admin.php?page=eventshandler";
							}, 2000);
						});
					}
				}
			}
		});
	
	function EditFullday()
	{		
		var uxEditEventFullDay = jQuery("#uxEditEventFullDay").prop("checked");
		if(uxEditEventFullDay == true)
		{
			
			jQuery("#uxFullDayEditSEvent").css('display','none');
			jQuery("#uxFullDayEditEndEvent").css('display','none');
			jQuery("#divFullDayEditFrmEvent").css('display','block');
			jQuery("#divFullDayEditToEvent").css('display','block');
			jQuery("#uxLblEventFrom").css('display','block');
			jQuery("#uxLblEventDate").css('display','none');
			
			var fullDayDb =" <?php echo $Event->EventFullDay; ?>";
			if(fullDayDb == 1)
			{
				var endDate = jQuery("#uxHidnEndDate").val();
				jQuery('#uxEditFromDate').datepicker("destroy");
				jQuery('#uxEditFromDate').datepicker({
					dateFormat : 'yy-mm-dd',
					yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
					changeMonth: true,
					changeYear: true,
					maxDate : endDate,
					onClose: function( selectedDate ) 
						{
							jQuery("#uxHidnStartDate").val(selectedDate)
							jQuery( "#uxEditToDate" ).datepicker( "option", "minDate", selectedDate );
							var label = jQuery('label[for="uxEditFromDate"]');
							label.text('Success!').addClass('valid');
						}
					});
			
				
				var startDate = jQuery("#uxHidnStartDate").val();
				jQuery('#uxEditToDate').datepicker("destroy");
				jQuery('#uxEditToDate').datepicker({
					dateFormat : 'yy-mm-dd',
					yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
					changeMonth: true,
					changeYear: true,
					minDate : startDate,
					onClose: function( selectedDate ) 
						{
							jQuery("#uxHidnEndDate").val(selectedDate)
							jQuery( "#uxEditFromDate" ).datepicker( "option", "maxDate", selectedDate );
							var label = jQuery('label[for="uxEditToDate"]');
							label.text('Success!').addClass('valid');
						}
					});
			}
			else
			{
				jQuery('#uxEditFromDate').datepicker("destroy");
				jQuery('#uxEditFromDate').datepicker({
					dateFormat : 'yy-mm-dd',
					yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
					changeMonth: true,
					changeYear: true,
					onSelect: function( selectedDate ) 
						{
							jQuery( "#uxEditToDate" ).datepicker( "option", "minDate", selectedDate );
							var label = jQuery('label[for="uxEditFromDate"]');
							label.text('Success!').addClass('valid');
						}
					});
				jQuery('#uxEditToDate').datepicker("destroy");
				jQuery('#uxEditToDate').datepicker({
					dateFormat : 'yy-mm-dd',
					yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
					changeMonth: true,
					changeYear: true,
					onClose: function( selectedDate ) 
						{
							jQuery( "#uxEditFromDate" ).datepicker( "option", "maxDate", selectedDate );
							var label = jQuery('label[for="uxEditToDate"]');
							label.text('Success!').addClass('valid');
						}
					});
				
			}
		
		}
		else
		{
			jQuery("#uxFullDayEditSEvent").css('display','block');
			jQuery("#uxFullDayEditEndEvent").css('display','block');
			jQuery("#divFullDayEditFrmEvent").css('display','block');
			jQuery("#divFullDayEditToEvent").css('display','none');
			jQuery("#uxLblEventDate").css('display','block');
			jQuery("#uxLblEventFrom").css('display','none');

			var endDate = jQuery("#uxHidnEndDate").val();
			jQuery('#uxEditFromDate').datepicker("destroy");
			jQuery('#uxEditFromDate').datepicker({
				dateFormat : 'yy-mm-dd',
				yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
				changeMonth: true,
				changeYear: true
				});
		
			
			var startDate = jQuery("#uxHidnStartDate").val();
			jQuery('#uxEditToDate').datepicker("destroy");
			jQuery('#uxEditToDate').datepicker({
				dateFormat : 'yy-mm-dd',
				yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
				changeMonth: true,
				changeYear: true
				
				});
			
		}
	}
	
	function ChangeLocation()
		{
	
			var newLocationAddress = jQuery("#uxEditLocationAddress").val();			
			var newLocationCountry = jQuery("#uxEditLocationCountry").val();
				
			jQuery.post(ajaxurl, "newLocationAddress="+newLocationAddress+"&newLocationCountry="+newLocationCountry+"&param=editblurFunction&action=eventsLibrary", function(data) 
			{
				jQuery("#showMap").html(data);
			});
		}
</script>