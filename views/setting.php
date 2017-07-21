<?php
global $wpdb;
?>
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
					<?php _e( "SETTINGS", events); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<div class="box">
			<div class="title">
				<?php _e("Settings", events); ?>
				<span class="hide">
				</span>
			</div>
			<div class="content">
			<form method="post" action="" class="events-container-form" id="uxFormSettings">
				<div class="message green" id="successMessageSetting" style="display:none;margin-left:10px;">
				<span>
					<strong>
						<?php _e( "Your setting has been updated successfully.", events ); ?>
					</strong>
				</span>
			</div>
				<div class="body">
					<div class="row">
						<label>
							<?php _e("Admin Email :", events);?>
						</label>
						<?php
							$admin_email = $wpdb -> get_var
							(
								$wpdb->prepare
								(
										'SELECT SettingsValue FROM ' . settingTable() . ' where SettingsKey  = %s',
												"admin_email"
								)
							);
							?>
						<div class = "right">
							
								<input type="text" name="ux_admin_email" id="ux_admin_email" style="width: 55%" value="<?php echo $admin_email;?>" />
							</div>
					</div>
					<div class="row">
						<label>
							<?php _e("Default Currency :", events);?>
						</label>
						<div class = "right">
						<?php
							$currency =$wpdb->get_results
							(
								$wpdb->prepare
								(
									"SELECT * From ".all_currency_listTable()." order by CurrencyName ASC",''
								)
							);	
							$currency_sel =$wpdb->get_var
							(
								$wpdb->prepare
								(
									"SELECT CurrencyName FROM ".all_currency_listTable(). " where CurrencyUsed = %d",
									"1"
								)
							);
							?>
							<select name="uxcurrency" class="style required" id="uxcurrency" style="width: 55%">
							<?php
							for ($flag = 0; $flag < count($currency); $flag++)
							{
								if ($currency[$flag]->CurrencyName == $currency_sel)
								{
								?>
									<option value="<?php echo $currency[$flag]->CurrencyName;?>" selected='selected'>
										<?php echo "(" . $currency[$flag]->CurrencySymbol . ")  ";echo $currency[$flag]->CurrencyName;?>
									</option>
									<?php
								}
								else
								{
									?>
									<option value="<?php echo $currency[$flag]->CurrencyName;?>">
										<?php echo "(" . $currency[$flag]->CurrencySymbol . ")  ";echo $currency[$flag]->CurrencyName; ?>
									</option>
									<?php
								}
							}
							?>
							</select>
						</div>
					</div>
					<div class="row">
						<label>
						<?php _e("Default Country :", events);
							$Country=$wpdb->get_results
							(
								$wpdb->prepare
								(
									"SELECT * FROM ". all_country_listTable()." order by CountryName ASC " ,""
								)
							);
							$SelectCountry=$wpdb->get_var
							(
								$wpdb->prepare
								(
									"SELECT CountryId FROM ". all_country_listTable(). " WHERE CountryUsed = %d",
									1
								)
							);
						?>
						</label>
						<div class = "right">
							<select name="uxCountry" class="style required" id="uxCountry" style="width: 55%">
							<?php
							for($flag=0; $flag < count($Country); $flag++)
							{
								if($SelectCountry == $Country[$flag]->CountryId)
								{
							?>
									<option value="<?php echo $Country[$flag]->CountryId;?>" selected="selected">
										<?php echo $Country[$flag]->CountryName;?>
									</option>
									<?php
								}
								else
								{
									?>
									<option value="<?php echo $Country[$flag]->CountryId;?>">
										<?php echo $Country[$flag]->CountryName;?>
									</option>
									<?php
								}
							}
									?>
							</select>
						</div>
					</div>
					<div class="row">
					<?php
						$timeFormat = $wpdb -> get_var
						(
							$wpdb->prepare
							(	
								"SELECT SettingsValue  FROM " . settingTable() . " where SettingsKey = %s",
								"default_Time_Format"
							)
						);
						?>
						<label>
							<?php _e( " Default Time Format :", events ); ?>
						</label>
						<div class="right">
							<select name="uxTimeFormat" class="style required" id="uxTimeFormat" style="width: 55%">
								<?php
									if($timeFormat == 0)
									{
								?>	
										<option value="0" selected="selected">
						 					<?php _e( "12 Hours", events ); ?>
										</option>
										<option value="1">
											<?php _e( "24 Hours", events ); ?>
										</option>
										<?php
									}
									else
									{
										?>
										<option value="0">
											<?php _e( "12 Hours", events ); ?>
										</option>
										<option value="1" selected="selected">
											<?php _e( "24 Hours", events ); ?>
										</option>
										<?php
									}
										?>
							</select>
						</div>
					</div>
					<div class="row">
						<?php
							$dateFormat = $wpdb->get_var
							(
								$wpdb->prepare
								(
									"SELECT SettingsValue  FROM " .settingTable() . " where SettingsKey = %s",
									"default_Date_Format"
								)
							);
						?>
						<label>
							<?php _e( "Default Date Format :", events ); ?>
						</label>
						<div class="right">
							<select name="uxDateFormat" class="style required" id="uxDateFormat" style="width: 55%">
								<?php
									$date = date('j');
									$monthName = date('F');
									$monthNumeric = date('m');
									$year = date('Y');
									if($dateFormat == 0)
									{
								?>	
										<option value="0" selected="selected">
										<?php echo  $monthName ." ".$date.",  ".$year; ?>
										</option>
										<option value="1">
										<?php echo  $year ."/".$monthNumeric."/".$date; ?>
										</option>
										<option value="2">
											<?php echo  $monthNumeric ."/".$date."/".$year; ?>
										</option>
										<option value="3">
											<?php echo $date ."/".$monthNumeric."/".$year;  ?>
										</option>
										<?php
									}
									else if($dateFormat == 1)
									{
										?>
										<option value="0">
											<?php echo $monthName ." ".$date.",  ".$year; ?>
										</option>
										<option value="1" selected="selected">
											<?php echo $year ."/".$monthNumeric."/".$date; ?>
										</option>
										<option value="2">
											<?php echo $monthNumeric ."/".$date."/".$year; ?>
										</option>
										<option value="3">
											<?php echo $date ."/".$monthNumeric."/".$year;  ?>
										</option>
										<?php
									}
									else if($dateFormat == 2)
									{
										?>
										<option value="0">
											<?php echo  $monthName ." ".$date.",  ".$year; ?>
										</option>
										<option value="1" >
											<?php echo  $year ."/".$monthNumeric."/".$date; ?>
										</option>
										<option value="2" selected="selected">
											<?php echo  $monthNumeric ."/".$date."/".$year; ?>
										</option>
										<option value="3">
											<?php echo $date ."/".$monthNumeric."/".$year;  ?>
										</option>
										<?php
									}
									else
									{
										?>
										<option value="0">
											<?php echo  $monthName." ".$date.",  ".$year;?>
										</option>
										<option value="1" >
											<?php echo  $year."/".$monthNumeric."/".$date;?>
										</option>
										<option value="2">
											<?php echo  $monthNumeric."/".$date."/".$year;?>
										</option>
										<option value="3" selected="selected">
											<?php echo $date ."/".$monthNumeric."/".$year;?>
										</option>
										<?php
									}
									?>
							</select> 	
						</div>
					</div>
					<div class="row">
						<?php
							$defautTimeZone = $wpdb->get_var
							(
								$wpdb->prepare
								(	
									"SELECT SettingsValue  FROM " .settingTable() . " where SettingsKey = %s",
									"default_Time_Zone"
								)
							);
						?>
						<label>
							<?php _e( "Default Time Zone :", events ); ?>
						</label>
						<div class="right">
						<select name="uxDefaultTimeZone" id="uxDefaultTimeZone" style="width: 55%">
							<option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
							<option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
							<option value="-10.0">(GMT -10:00) Hawaii</option>
							<option value="-9.0">(GMT -9:00) Alaska</option>
							<option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
							<option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
							<option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
							<option value="-5.0">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
							<option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
							<option value="-3.5">(GMT -3:30) Newfoundland</option>
							<option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
							<option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
							<option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
							<option value="0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
							<option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
							<option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
							<option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
							<option value="3.5">(GMT +3:30) Tehran</option>
							<option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
							<option value="4.5">(GMT +4:30) Kabul</option>
							<option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
							<option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
							<option value="5.75">(GMT +5:45) Kathmandu</option>
							<option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
							<option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
							<option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
							<option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
							<option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
							<option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
							<option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
							<option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
						</select>
						<script>
							jQuery('#uxDefaultTimeZone').val("<?php echo $defautTimeZone; ?>");
						</script>
						</div>
					</div>
					<div class="row">
						<label style="top:10px;">
							<?php _e("Events Booking:", events);?>
						</label>
						<?php
						$EventStatus = $wpdb -> get_var
						(
							$wpdb->prepare
							(
								'SELECT SettingsValue FROM ' . settingTable() . ' where SettingsKey  = %s',
								"event_booking_status"
							)
						);
						?>
						<div class="right">
						<?php
						if($EventStatus == 1)
						{
						?>
							<input type="radio" id="uxEventEnable" name="uxEvent" class="style" value="1" onclick="enable_auto_approve();" checked="checked">&nbsp;&nbsp;<?php _e( "Enabled", events );?>
							<input type="radio" id="uxEventDisable" name="uxEvent" class="style" value="0" onclick="disable_auto_approve();" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", events );?>
						<?php
						}
						else 
						{
						?>
							<input type="radio" id="uxEventEnable" name="uxEvent" class="style"  value="1" onclick="enable_auto_approve();">&nbsp;&nbsp;<?php _e( "Enabled", events );?>
							<input type="radio" id="uxEventDisable" name="uxEvent"  class="style" value="0" onclick="disable_auto_approve();" checked="checked" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", events );?>
						<?php
						}
						?>
						</div>
					</div>
					<div class="row" id="uxautoapprove" style="display: block;">
						<label style="top:10px;">
							<?php _e("Auto Approve :", events);?>
						</label>
						<?php
						$AutoApprove = $wpdb -> get_var
						(
							$wpdb->prepare
							(
								'SELECT SettingsValue FROM ' . settingTable() . ' where SettingsKey  = %s',
								"auto_approve_status"
							)
						);
						?>
						<div class="right">
						<?php
						if($AutoApprove == 1)
						{
						?>
							<input type="radio" id="uxAutoEnable" name="uxAuto" class="style" value="1" checked="checked">&nbsp;&nbsp;<?php _e( "Enabled", events );?>
							<input type="radio" id="uxAutoDisable" name="uxAuto" class="style" value="0" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", events );?>
						<?php
						}
						else 
						{
						?>
							<input type="radio" id="uxAutoEnable" name="uxAuto" class="style"  value="1">&nbsp;&nbsp;<?php _e( "Enabled", events );?>
							<input type="radio" id="uxAutoDisable" name="uxAuto"  class="style" value="0" checked="checked" style="margin-left:10px;">&nbsp;&nbsp;<?php _e( "Disabled", events );?>
						<?php
						}
						?>
						</div>
					</div>

					<div class="row"style="border-bottom:none!important">
						<label></label>
							<div class="right">
								<button type="submit"class="events-container-button green">
									<span>
										<?php _e( "Submit & Save Changes", events);?>
									</span>
								</button>
								<button type="button"class="events-container-button green" onclick="DeleteAllBookings();">
									<span>
										<?php _e( "Delete All Bookings", events);?>
									</span>
								</button>
								<button type="button"class="events-container-button green" onclick="RestoreFactorySettings();">
									<span>
										<?php _e( "Restore Factory Settings", events);?>
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
jQuery("#Settings").addClass("current");
	jQuery("#uxFormSettings").validate
	({
		rules:
		{
			ux_admin_email:
			{
			required: true,
			email:true
			},
			uxMerchantEmailAddress: 
			{
			required: true,
			email:true
			},
			uxThankyouPageUrl: "required",
			uxPaymentImageUrl: "required",
			uxPaymentCancellationMessage: "required"
		},
		submitHandler: function(form)
		{
			
			var marchant_email = jQuery('#uxMerchantEmailAddress').val();
			jQuery.post(ajaxurl, jQuery(form).serialize() + "&uxMerchantEmailAddress="+marchant_email+"&param=updateSetting&action=settingLibrary", function(data)
			{
				
			jQuery.colorbox.resize();
			jQuery("#successMessageSetting").css("display","block");
			setTimeout(function() 
			{
				jQuery("#successMessageSetting").css("display","none");
				var checkPage = "<?php echo $_REQUEST['page']; ?>";
				window.location.href = "admin.php?page="+checkPage;
			}, 2000);
		});
		}
	});
	jQuery(document).ready(function(){
		enablePaypalText();
		disablePaypalText();
		enable_auto_approve();
		disable_auto_approve();
	});
	function enablePaypalText()
	{
		var PaypalEnable = jQuery('input:radio[name=uxPayPal]:checked').val();
		if(PaypalEnable == 1)
		{
			jQuery('#paypalUrl').attr('style','');
			jQuery('#paypalMerchantEmail').attr('style','');
			jQuery('#paypalThankYou').attr('style','');
			jQuery('#paypalIPN').attr('style','');
			jQuery('#paypalCancellation').attr('style','');
			jQuery.colorbox.resize();
		}
	}
	function disablePaypalText()
	{
		var PaypalEnable = jQuery('input:radio[name=uxPayPal]:checked').val();
		if(PaypalEnable == 0)
		{
			jQuery('#paypalUrl').css('display','none');
			jQuery('#paypalMerchantEmail').css('display','none');
			jQuery('#paypalThankYou').css('display','none');
			jQuery('#paypalIPN').css('display','none');
			jQuery('#paypalCancellation').css('display','none');
			jQuery.colorbox.resize();
		}
	}
	function enable_auto_approve()
	{
		var eventEnable = jQuery('input:radio[name=uxEvent]:checked').val();
		if(eventEnable == 1)
		{
			jQuery('#uxautoapprove').css('display','block');
		}
	}
	function disable_auto_approve()
	{
		var eventEnable = jQuery('input:radio[name=uxEvent]:checked').val();
		if(eventEnable == 0)
		{
			jQuery('#uxautoapprove').css('display','none');
		}
	}
	function RestoreFactorySettings()
	{
			bootbox.confirm("<?php _e("Are you sure you want to Restore Factory Settings ?", events ); ?>", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.post(ajaxurl, "&param=RestoreFactory&action=settingLibrary", function(data)
					{
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					});
					
				}
			});
	}
	function DeleteAllBookings()
		{
			bootbox.confirm("<?php _e("Are you sure you want to Delete All Bookings?", events ); ?>", function(confirmed) 
			{
				console.log("Confirmed: "+confirmed);
				if(confirmed == true)
				{
					jQuery.post(ajaxurl, "&param=DeleteAllBooking&action=settingLibrary", function(data)
					{
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					});
				}
			});  
	}
</script>