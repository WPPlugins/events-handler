<div id="right">
	<div id="breadcrumbs">
		<ul>
			<li class="first"></li>
			<li>
				<a href="#">
					<?php _e( "EVENTS HANDLER", events ); ?>
				</a>
			</li>
			<li>
				<a href="admin.php?page=eventshandler">
					<?php _e( "EVENTS", events); ?>
				</a>
			</li>
			<li class="last">
				<a href="#">
					<?php _e( "ADD NEW EVENT", events); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<a href="admin.php?page=eventshandler" class="events-container-button green" style="margin-top: 10px;">
			<span><?php _e('Back to Events', events); ?></span>
		</a>
	<div class="box">
		<div class="title">
			<?php _e('Add New Event', events); ?>
		</div>
		<div class="content">
			
			<form  method="post" action="" class="events-container-form" id="uxFormAddEvent">
				<div class="message green" id="successMessageEvents" style="display:none;margin-left:10px;">
					<span>
						<strong>
							<?php _e( "Success! Event has been saved.", events ); ?>
						</strong>
					</span>
				</div>
				<div class="body">
					<div class="row">
						<label>
							<?php _e("Event Color :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxEventColor" id="uxEventColor" value="#00ff00">
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e("Event Name :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxEventName" id="uxEventName">
						</div>
					</div>
					<div class="row">
						<label><?php _e("Description :", events); ?></label>
						<div class="right">
							<?php wp_editor("", $id = 'uxDescription', $prev_id = 'title', $media_buttons = true, $tab_index = 1);?>
						</div>
					</div>
					<div class="row">
						<label style="top:10px"><?php _e("Full Day :", events);?></label>
						<div class="right">
							<input type="checkbox" name="uxEventFullDay" id="uxEventFullDay" value="1" onclick="Fullday()"/>
						</div>
					</div>
					<div class="row" id="divFullDayFromEvent" style="display: block;">	
						<label id="uxLblAddEventFrom" style="display: none">
							<?php _e("Event From :", events);?>
						</label>
						<label id="uxLblAddEventDate">
							<?php _e("Event Date :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxDateFrom" id="uxDateFrom">
						</div>
					</div>
					<div class="row" id="divFullDayToEvent" style="display: none;">	
						<label>
							<?php _e("Event To :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxDateTo" id="uxDateTo">
						</div>
					</div>	
					<div class="row" id="uxFullDaySEvent" style="display: block;">
						<label>
							<?php _e("Start Time :", events);?>
						</label>
						<div class = "right">
							<select name="uxEventStartHour" id="uxEventStartHour">
								<?php
									for($StHr=0; $StHr <= 12; $StHr++)
									{
										if($StHr < 10)
										{
											echo "<option value=0" .$StHr.">0".$StHr."</option>";
										}
										else
										{
											echo"<option value=" .$StHr.">".$StHr."</option>";
										}
									}
								?>
							</select>
							<select name="uxEventStartMin" id="uxEventStartMin">
								<?php
									for($StMin=0; $StMin <= 55; $StMin += 5)
									{
										if($StMin < 10)
										{
											echo "<option value=0" .$StMin.">0".$StMin."</option>";
										}
										else
										{
											echo"<option value=" .$StMin.">".$StMin."</option>";
										}
									}
								?>
							</select>
							<select name="uxEventStartTime" id="uxEventStartTime">
								<option value="<?php _e("AM", events);?>">
										<?php _e("AM", events);?>
								</option>
								<option value="<?php _e("PM", events);?>">
										<?php _e("PM", events);?>
								</option>
							</select>
						</div>
					</div>
					<div class="row" id="uxFullDayEndEvent" style="display: block;">
						<label>
							<?php _e("End Time :", events);?>
						</label>
						<div class = "right">
							<select name="uxEventEndHour" id="uxEventEndHour">
								<?php
									for($EndHr=0; $EndHr <= 12; $EndHr++)
										{
											if($EndHr < 10)
											{
												echo "<option value=0" .$EndHr.">0".$EndHr."</option>";
											}
											else
											{
												echo"<option value=" .$EndHr.">".$EndHr."</option>";
											}
										}
								?>
							</select>
							<select name="uxEventEndMin" id="uxEventEndMin">
								<?php
									for($EndMin=0; $EndMin <= 55; $EndMin += 5)
										{
											if($EndMin < 10)
											{
												echo "<option value=0" .$EndMin.">0".$EndMin."</option>";
											}
											else
											{
												echo"<option value=" .$EndMin.">".$EndMin."</option>";
											}
										}
								?>
							</select>
							<select name="uxEventEndTime" id="uxEventEndTime">
								<option value="<?php echo "AM";?>">
										<?php echo "AM";?>
								</option>
								<option value="<?php echo "PM";?>">
										<?php echo "PM";?>
								</option>
							</select>
						</div>
					</div>
					<script>
						jQuery("#uxEventStartHour").val("09");
						jQuery("#uxEventStartMin").val("00");
						jQuery("#uxEventStartTime").val("AM");
						jQuery("#uxEventEndHour").val("05");
						jQuery("#uxEventEndMin").val("00");
						jQuery("#uxEventEndTime").val("PM");
					</script>
					<div class="row">		
						<label>
							<?php _e("Venue Name :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxLocationName" id="uxLocationName">
						</div>
					</div>
					<div class="row">
						<label>
							<?php _e("Venue Address :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxLocationAddress" id="uxLocationAddress" onkeyup="ChangeLocation()">
						</div>
					</div>	
					<div class="row">	
						<label>
							<?php _e("Venue City :", events);?>
						</label>
						<div class = "right">
							<input type="text" name="uxLocationCity" id="uxLocationCity">
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
							$country_sel = $wpdb -> get_var
							(
								$wpdb->prepare
								(
									"SELECT CountryId  FROM ".all_country_listTable(). " where CountryUsed = %d",
									"1"
								)
							);
							?>
							<select name="uxLocationCountry" id="uxLocationCountry" onchange="ChangeLocation()">
							<?php
								for($flag=0; $flag<count($show); $flag++)
								{
									if ($show[$flag]->CountryId == $country_sel)
									{
										?>
											<option value="<?php echo $show[$flag]->CountryId;?>" selected='selected'><?php echo $show[$flag]->CountryName;?></option>
										<?php 
									}
									else 
									{
										?>
											<option value="<?php echo $show[$flag]->CountryId; ?>"><?php echo $show[$flag]->CountryName; ?></option>
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
					<div class="row" style="border-bottom:none !important;" >
						<div class="right">
							<button type="submit" class="events-container-button green">
								<span>
									<?php _e( "Submit & Save", events); ?>
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
	jQuery(document).ready(function() {
		jQuery('#uxDateFrom').datepicker({
			dateFormat : 'yy-mm-dd',
			yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
			changeMonth: true,
			changeYear: true,
			minDate:new Date(),
			onClose: function( selectedDate ) 
			{
				jQuery( "#uxDateTo" ).datepicker( "option", "minDate", selectedDate );
				var label = jQuery('label[for="uxDateFrom"]');
				label.text('Success!').addClass('valid');
			}
		});
	});
	jQuery(document).ready(function() {
		jQuery('#uxDateTo').datepicker({
			dateFormat : 'yy-mm-dd',
			yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
			changeMonth: true,
			changeYear: true,
			minDate:new Date(),
			onClose: function( selectedDate ) 
			{
				jQuery( "#uxDateFrom" ).datepicker( "option", "maxDate", selectedDate );
				var label = jQuery('label[for="uxDateTo"]');
				label.text('Success!').addClass('valid');
			}
		});
	});
	
	
	jQuery(document).ready(function() {
			jQuery('#uxEventColor').ColorPicker
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
	
	
	jQuery("#uxFormAddEvent").validate
	({
		rules:
		{
			uxEventName: "required",
			uxLocationName:
			{
				required: true
			},
			uxLocationAddress:
			{
				required: true
			},
			uxLocationCountry:
			{
				required: true
			},
			uxDateFrom:
			{
				required: true
			},
			uxDateTo:
			{
				required: true
			}
		},	
		submitHandler: function(form) 
		{
			var uxEventStartHour=jQuery("#uxEventStartHour").val();
			var uxEventStartMin=jQuery("#uxEventStartMin").val();
			var uxEventStartTime=jQuery("#uxEventStartTime").val();
			var uxEventEndHour=jQuery("#uxEventEndHour").val();
			var uxEventEndMin=jQuery("#uxEventEndMin").val();
			var uxEventEndTime=jQuery("#uxEventEndTime").val();
			var uxEventFullDay=jQuery("#uxEventFullDay").prop("checked");
			var startDate = jQuery("#uxDateFrom").val();
			var endDate = jQuery("#uxDateTo").val();
			if(uxEventStartTime == "PM")
				{
					if(uxEventStartHour <= 11)
					{
						uxEventStartHours = parseInt(uxEventStartHour) + 12;
					}
					else if(uxEventStartHour == 12)
					{
						uxEventStartHours = 12;
					}
				}
				else if(uxEventStartTime == "AM")
				{
					if(uxEventStartHour == 12)
					{
						uxEventStartHours = 0;
					}
					else 
					{
						uxEventStartHours = uxEventStartHour;
					}
				}
				else 
				{
					uxEventStartHours = uxEventStartHour;
				}
				if(uxEventEndTime == "PM")
				{
					if(uxEventEndHour <= 11)
					{
						uxEventEndHours = parseInt(uxEventEndHour) + 12;
					}
					else if(uxEventEndHour == 12)
					{
						uxEventEndHours = 12;
					}
				}
				else if(uxEventEndTime == "AM")
				{
					if(uxEventEndHour == 12)
					{
						uxEventEndHours = 0;
					}
					else 
					{
						uxEventEndHours = uxEventEndHour;
					}
				}
				else 
				{
					uxEventEndHours = uxEventEndHour;
				}
				uxSHours = (uxEventStartHours * 60) + parseInt(uxEventStartMin);
				uxEHours = (uxEventEndHours * 60) + parseInt(uxEventEndMin);
				if (jQuery("#wp-uxDescription-wrap").hasClass("tmce-active"))
				{
					var eventDesc = encodeURIComponent(tinyMCE.get('uxDescription').getContent());
				}
				else
				{
					var eventDesc = encodeURIComponent(jQuery('#uxDescription').val());
				}
				
				if(uxEventFullDay == true)
				{
					var fromDate = Date.parse(startDate);
					var fromDate1 = new Date(fromDate);
					var toDate = Date.parse(endDate);
					var toDate1 = new Date(toDate);
					if(fromDate1 > toDate1)
					{
						bootbox.alert("<?php _e( "Start Date must be greater than or equal to end date.", events); ?>");
					}
					else
					{
						
						jQuery.post(ajaxurl, jQuery(form).serialize() + "&EventDesc=" + eventDesc + "&param=insertEvent&action=eventsLibrary", function(data) 
						{
							jQuery("#timeErrorMessage").css("display","none");
							jQuery("#successMessageEvents").css("display","block");
							setTimeout(function() 
							{
								jQuery("#successMessageEvents").css("display","none");
								window.location.href = "admin.php?page=eventshandler";
							}, 2000);
						});
					}
				}
				else
				{
					if(uxSHours >= uxEHours)
					{
						
						bootbox.alert("<?php _e( "Please Enter Valid Time", events); ?>");
					}
					else
					{
						jQuery.post(ajaxurl, jQuery(form).serialize() + "&EventDesc=" + eventDesc + "&param=insertEvent&action=eventsLibrary", function(data) 
						{
							jQuery("#timeErrorMessage").css("display","none");
							jQuery("#successMessageEvents").css("display","block");
							setTimeout(function() 
							{
								jQuery("#successMessageEvents").css("display","none");
								window.location.href = "admin.php?page=eventshandler";
							}, 2000);
						});
					}
				}
			}
		});
		
		
		function Fullday()
		{
			var uxFullDayEvent = jQuery("#uxEventFullDay").prop("checked");
			if(uxFullDayEvent == true)
			{
				jQuery("#uxFullDaySEvent").css('display','none');
				jQuery("#uxFullDayEndEvent").css('display','none');
				jQuery("#divFullDayFromEvent").css('display','block');
				jQuery("#divFullDayToEvent").css('display','block');
				jQuery("#uxLblAddEventFrom").css('display','block');
				jQuery("#uxLblAddEventDate").css('display','none');
				
				jQuery('#uxDateFrom').datepicker("destroy");
				jQuery('#uxDateFrom').datepicker({
					dateFormat : 'yy-mm-dd',
					yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
					changeMonth: true,
					changeYear: true,
					minDate:new Date(),
					onSelect: function( selectedDate ) 
						{
							jQuery( "#uxDateTo" ).datepicker( "option", "minDate", selectedDate );
							var label = jQuery('label[for="uxDateFrom"]');
							label.text('Success!').addClass('valid');
						}
					});
				jQuery('#uxDateTo').datepicker("destroy");
				jQuery('#uxDateTo').datepicker({
					dateFormat : 'yy-mm-dd',
					yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
					changeMonth: true,
					changeYear: true,
					minDate:new Date(),
					onClose: function( selectedDate ) 
						{
							jQuery( "#uxDateFrom" ).datepicker( "option", "maxDate", selectedDate );
							var label = jQuery('label[for="uxDateTo"]');
							label.text('Success!').addClass('valid');
						}
					});
			}
			else
			{
				jQuery("#uxFullDaySEvent").css('display','block');
				jQuery("#uxFullDayEndEvent").css('display','block');
				jQuery("#divFullDayFromEvent").css('display','block');
				jQuery("#divFullDayToEvent").css('display','none');
				jQuery("#uxLblAddEventFrom").css('display','none');
				jQuery("#uxLblAddEventDate").css('display','block');
				
				jQuery('#uxDateFrom').datepicker("destroy");
				jQuery('#uxDateFrom').datepicker({
					dateFormat : 'yy-mm-dd',
					yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
					changeMonth: true,
					changeYear: true,
					minDate:new Date()
					});
					
				
				jQuery('#uxDateTo').datepicker("destroy");
				jQuery('#uxDateTo').datepicker({
					dateFormat : 'yy-mm-dd',
					yearRange: new Date().getFullYear() + ":" + parseInt(parseInt(new Date().getFullYear()) + parseInt(20)),
					changeMonth: true,
					changeYear: true,
					minDate:new Date()
					
					});
			}
			
			
		}
		
		function ChangeLocation()
		{
			var newLocationAddress = jQuery("#uxLocationAddress").val();
			var newLocationCountry = jQuery("#uxLocationCountry").val();
			jQuery.post(ajaxurl, "newLocationAddress="+newLocationAddress+"&newLocationCountry="+newLocationCountry+"&param=blurFunction&action=eventsLibrary", function(data) 
			{
				jQuery("#showMap").html(data);
			});
		}
	</script>