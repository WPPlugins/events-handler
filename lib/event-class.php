
<?php
global $wpdb;
if (!current_user_can('edit_posts') && ! current_user_can('edit_pages') )
{
	return;
}
else
{
	if(isset($_REQUEST['param']))
	{
		if($_REQUEST['param'] == "insertEvent")
		{
			$eventColor = esc_attr($_REQUEST['uxEventColor']);
			$uxEventName= esc_attr($_REQUEST['uxEventName']);
			$uxDescription= html_entity_decode($_REQUEST['EventDesc']);
			$uxLocationName= esc_attr($_REQUEST['uxLocationName']);
			$uxLocationAddress= esc_attr($_REQUEST['uxLocationAddress']);
			$uxLocationCity= esc_attr($_REQUEST['uxLocationCity']);
			$uxLocationCountry= intval($_REQUEST['uxLocationCountry']);
			$uxFrom= esc_attr($_REQUEST['uxDateFrom']);
			$uxTo;
			$uxEventStartHour= intval($_REQUEST['uxEventStartHour']);
			$uxEventStartMin= intval($_REQUEST['uxEventStartMin']);
			$uxEventStartTime= esc_attr($_REQUEST['uxEventStartTime']);
			$uxEventEndHour= intval($_REQUEST['uxEventEndHour']);
			$uxEventEndMin= intval($_REQUEST['uxEventEndMin']);
			$uxEventEndTime= esc_attr($_REQUEST['uxEventEndTime']);
			$latitude = doubleval($_REQUEST["uxHiddenLatitude"]);
			$longitude = doubleval($_REQUEST["uxHiddenLongitude"]);
	
			if($uxEventStartTime == "PM")
			{
				if($uxEventStartHour <= 11)
				{
					$uxEventStartHours = $uxEventStartHour + 12;
				}
				else if($uxEventStartHour == 12)
				{
					$uxEventStartHours = 12;
				}
			}
			else if($uxEventStartTime == "AM")
			{
				if($uxEventStartHour == 12)
				{
					$uxEventStartHours = 0;
				}
				else 
				{
					$uxEventStartHours = $uxEventStartHour;
				}
			}
			else 
			{
				$uxEventStartHours = $uxEventStartHour;
			}
			if($uxEventEndTime == "PM")
			{
				if($uxEventEndHour <= 11)
				{
					$uxEventEndHours = $uxEventEndHour + 12;
				}
				else if($uxEventEndHour == 12)
				{
					$uxEventEndHours = 12;
				}
			}
			else if($uxEventEndTime == "AM")
			{
				if($uxEventEndHour == 12)
				{
					$uxEventEndHours = 0;
				}
				else 
				{
					$uxEventEndHours = $uxEventEndHour;
				}
			}
			else 
			{
				$uxEventEndHours = $uxEventEndHour;
			}
			$uxStartHours = ($uxEventStartHours * 60) + $uxEventStartMin;
			$uxEndHours = ($uxEventEndHours * 60) + $uxEventEndMin;
			
			if(isset($_REQUEST['uxEventFullDay']))
			{
				$uxEventFullDay = 1;
				$uxTo= esc_attr($_REQUEST['uxDateTo']);
				$uxStartHours=0;
				$uxEndHours=0;
			}
			else 
			{
				$uxEventFullDay = 0;
				$uxTo= esc_attr($_REQUEST['uxDateFrom']);
			}
			
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO " .addEventTable(). "(EventColorCode, EventName , EventDescription , EventLocName , EventLocAddress ,EventLocCity , EventLocCountry, EventFrom , EventTo , EventSTotalTime , EventETotalTime , EventFullDay) 
					VALUES (%s, %s , %s , %s , %s ,%s , %d , '%s' , '%s' , %d ,%f , %f)",
					$eventColor,
					$uxEventName,
					$uxDescription,
					$uxLocationName,
					$uxLocationAddress,
					$uxLocationCity,
					$uxLocationCountry,
					$uxFrom,
					$uxTo,
					$uxStartHours,
					$uxEndHours,
					$uxEventFullDay
				)
			);
			$EventLastId=$wpdb->insert_id;
			$wpdb->query
			(
				$wpdb->prepare
				(
					"INSERT INTO " .locationTable(). "(EventId, locationName , locationAddress , locationCity , locationCountry, locationLatitude, locationLongitude)
					VALUES( %d, %s , %s , %s , %d, %f, %f)",
					$EventLastId,
					$uxLocationName,
					$uxLocationAddress,
					$uxLocationCity,
					$uxLocationCountry,
					$latitude,
					$longitude
				)
			);	
			die();
		}
		
		else if($_REQUEST["param"] == "onEditLoad")
		{
			$address = esc_attr($_REQUEST["address"]);
			$country = intval($_REQUEST["country"]);
			
			global $wpdb;
						$country=$wpdb->get_row
						(
							$wpdb->prepare
							(
								"SELECT * from " . all_country_listTable() . " WHERE CountryId = %d",
								$country
							)
						);
						
						
						
						?>
						<div id="uxDivMapEdit">
							
							<?php
								$myaddress = urlencode($address . "," . $country->CountryName);
								//here is the google api url
								$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
								//get the content from the api using file_get_contents
								$getmap = file_get_contents($url);
								//the result is in json format. To decode it use json_decode
								$googlemap = json_decode($getmap);
								//get the latitute, longitude from the json result by doing a for loop
								$flag = 0;
								foreach($googlemap->results as $res){
									if($flag == 0)
									{
										$address = $res->geometry;
										$latlng = $address->location;
										$formattedaddress = $res->formatted_address;
										$flag++;
									
										?>
										<!-- Print the Latitude and Longitude -->
										<input type="hidden" name="uxHiddenMessage1" id="uxHiddenMessage1" value="1">
										<input type="text" style="visibility: hidden" name="uxHiddenEditLatitude" id="uxHiddenEditLatitude" value="<?php echo $latlng->lat ?>">
										<input type="text" style="visibility: hidden" name="uxHiddenEditLongitude" id="uxHiddenEditLongitude" value="<?php echo $latlng->lng; ?>">
										<iframe id="uxLocationFrame1" width="780px" height="450px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $myaddress;?> &amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo urlencode($formattedaddress);?>&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
										<?php
									}
								}
								
							?>
						</div>
						<div>
							<script type="text/javascript">
								var hiddenMessageId = jQuery("#uxHiddenMessage1").val();
								if(hiddenMessageId != "1")
								{
									
									jQuery("#uxLblMessageEdit").text("Location Not Found");
								}
								
							</script>
							<div style="margin-left: 39%;">
								<label id="uxLblMessageEdit"></label>
							</div>
						</div>
				
						<?php	
						
					die();
			
		}
		else if($_REQUEST["param"] == "deleteEvents")
			{
				$EventId = intval($_REQUEST["EventId"]);
				$BookingEvent = $wpdb->get_var
				(
					$wpdb->prepare
					(
						"Select count(*) from " .addBookingTable(). " WHERE EventId = %d",
						$EventId	
					)
				);
				if($BookingEvent == 0)
				{
					$ticket = $wpdb->get_var
					(
						$wpdb->prepare
						(
							"Select count(*) from " .addTicketTable(). " WHERE EventId = %d",
							$EventId	
						)
					);
					if($ticket == 0)
					{
						echo 1;
						$wpdb->query
						(
							$wpdb->prepare
							(
								"DELETE FROM " .addEventTable(). " WHERE EventId = %d",
								$EventId
							)
						);
					}
					else
					{
						echo 2;
					}
				}					
				else {
						echo 0;
				}
				die();
			}
			else if($_REQUEST['param'] == "updateEvent")
			{
				$uxEventid = intval($_REQUEST['EventId']);
				$uxEditEventColorCode = esc_attr($_REQUEST['uxEditEventColorCode']);
				$uxEditEventName=esc_attr($_REQUEST['uxEditEventName']);
				$uxEditDesc=html_entity_decode($_REQUEST['EventDesc']);
				$uxEditLocationName=esc_attr($_REQUEST['uxEditLocationName']);
				$uxEditLocationAddress=esc_attr($_REQUEST['uxEditLocationAddress']);
				$uxEditLocationCity=esc_attr($_REQUEST['uxEditLocationCity']);
				$uxEditLocationCountry=intval($_REQUEST['uxEditLocationCountry']);
				$uxEditFrom=esc_attr($_REQUEST['uxEditFromDate']);
				$uxEditTo=esc_attr($_REQUEST['uxEditToDate']);
				$uxEditEventSHour=intval($_REQUEST['uxEditEventSHour']);
				$uxEditEventSMin=intval($_REQUEST['uxEditEventSMin']);
				$uxEditEventSTime=esc_attr($_REQUEST['uxEditEventSTime']);
				$uxEditEventEndHour=intval($_REQUEST['uxEditEventEndHour']);
				$uxEditEventEndMin=intval($_REQUEST['uxEditEventEndMin']);
				$uxEditEventEndTime=esc_attr($_REQUEST['uxEditEventEndTime']);
				
				$eventLatitude;
				$eventLongitude;
				$latitude = doubleval($_REQUEST["uxHiddenEditLatitudeOnChange"]);
				$longitude = doubleval($_REQUEST["uxHiddenEditLongitudeOnChange"]);
				
				if($latitude == 0)
				{
					$eventLatitude = doubleval($_REQUEST["uxHiddenEditLatitude"]);
				}
				else {
					$eventLatitude = $latitude;
				}
				
				if($longitude == 0)
				{
					$eventLongitude = doubleval($_REQUEST["uxHiddenEditLongitude"]);
				}
				else {
					$eventLongitude = $longitude;
				}
				
				if($uxEditEventSTime == "PM")
				{
					if($uxEditEventSHour <= 11)
					{
						$uxEditEventSHours = $uxEditEventSHour + 12;
					}
					else if($uxEditEventSHour == 12)
					{
						$uxEditEventSHours = 12;
					}
				}
				else if($uxEditEventSTime == "AM")
				{
					if($uxEditEventSHour == 12)
					{
						$uxEditEventSHours = 0;
					}
					else 
					{
						$uxEditEventSHours = $uxEditEventSHour;
					}
				}
				else 
				{
					$uxEditEventSHours = $uxEditEventSHour;
				}
				if($uxEditEventEndTime == "PM")
				{
					if($uxEditEventEndHour <= 11)
					{
						$uxEditEventEndHours = $uxEditEventEndHour + 12;
					}
					else if($uxEditEventEndHour == 12)
					{
						$uxEditEventEndHours = 12;
					}
				}
				else if($uxEditEventEndTime == "AM")
				{
					if($uxEditEventEndHour == 12)
					{
						$uxEditEventEndHours = 0;
					}
					else 
					{
						$uxEditEventEndHours = $uxEditEventEndHour;
					}
				}
				else 
				{
					$uxEditEventEndHours = $uxEditEventEndHour;
				}
					$uxEditStartHours = ($uxEditEventSHours * 60) + $uxEditEventSMin;
					$uxEditEndHours = ($uxEditEventEndHours * 60) + $uxEditEventEndMin;
					$uxEditEventFullDay = intval($_REQUEST["uxEditEventFullDay"]);
					if(isset($_REQUEST['uxEditEventFullDay']))
					{
						$uxEditFullday = intval($_REQUEST['uxEditEventFullDay']);
					}
					else
					{
						$uxEditFullday = "0";
					}
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE " .addEventTable()." SET EventColorCode = %s, EventName = %s,EventDescription = %s,EventLocName = %s,EventLocAddress = %s, EventLocCity = %s, EventLocCountry = %d, EventFrom = '%s', EventTo = '%s', EventSTotalTime = %d, EventETotalTime = %d, EventFullDay = %d WHERE EventId = %d",
						$uxEditEventColorCode,
						$uxEditEventName,
						$uxEditDesc,
						$uxEditLocationName,
						$uxEditLocationAddress,
						$uxEditLocationCity,
						$uxEditLocationCountry,
						$uxEditFrom,
						$uxEditTo,
						$uxEditStartHours,
						$uxEditEndHours,
						$uxEditFullday,
						$uxEventid
					)
				);
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE " .locationTable()." SET locationName = %s,locationAddress = %s,locationCity = %s, locationCountry = %d, locationLatitude =%f, locationLongitude = %f WHERE EventId = %d",
						$uxEditLocationName,
						$uxEditLocationAddress,
						$uxEditLocationCity,
						$uxEditLocationCountry,
						$eventLatitude,
						$eventLongitude,
						$uxEventid
					)
				);
			die();
			}
			
			else if($_REQUEST["param"] == "blurFunction")
			{
								
				
				$newLocationAddress = esc_attr($_REQUEST["newLocationAddress"]);
				$newLocationCountryId = intval($_REQUEST["newLocationCountry"]);
				
						global $wpdb;
						$country=$wpdb->get_row
						(
							$wpdb->prepare
							(
								"SELECT * from " . all_country_listTable() . " WHERE CountryId = %d",
								$newLocationCountryId
							)
						);
						
						
						
						?>
						<div id="uxDivMap">
							
							<?php
								$myaddress = urlencode($newLocationAddress . "," . $country->CountryName);
								//here is the google api url
								$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
								//get the content from the api using file_get_contents
								$getmap = file_get_contents($url);
								//the result is in json format. To decode it use json_decode
								$googlemap = json_decode($getmap);
								//get the latitute, longitude from the json result by doing a for loop
								$flag = 0;
								foreach($googlemap->results as $res){
									if($flag == 0)
									{
										$address = $res->geometry;
										$latlng = $address->location;
										$formattedaddress = $res->formatted_address;
										$flag++;
									
										?>
																			
										<!-- Print the Latitude and Longitude -->
										<input type="hidden" name="uxHiddenMessage" id="uxHiddenMessage" value="1">
										<input type="text" style="visibility: hidden" name="uxHiddenLatitude" id="uxHiddenLatitude" value="<?php echo $latlng->lat ?>">
										<input type="text" style="visibility: hidden" name="uxHiddenLongitude" id="uxHiddenLongitude" value="<?php echo $latlng->lng; ?>">
										<iframe id="uxLocationFrame" width="780px" height="450px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $myaddress;?> &amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo urlencode($formattedaddress);?>&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
										<?php
									}
								}
								
							?>
						</div>
						<div>
							<script type="text/javascript">
								var hiddenMessageId = jQuery("#uxHiddenMessage").val();
								if(hiddenMessageId != "1")
								{
									
									jQuery("#uxLblMessage").text("Location Not Found");
								}
								
							</script>
							<div style="margin-left: 39%;">
								<label id="uxLblMessage"></label>
							</div>
						</div>
				
						<?php	
						
					die();
			}

			else if($_REQUEST["param"] == "editblurFunction")
			{
				?>
				
				<script type="text/javascript">
				
					jQuery("#uxDivMapEdit").css("display", "none");
								
				</script>
			
				<?php
				
				$newLocationAddress = esc_attr($_REQUEST["newLocationAddress"]);
				$newLocationCountryId = intval($_REQUEST["newLocationCountry"]);
				
						global $wpdb;
						$country=$wpdb->get_row
						(
							$wpdb->prepare
							(
								"SELECT * from " . all_country_listTable() . " WHERE CountryId = %d",
								$newLocationCountryId
							)
						);
						
						
						
						?>
						<div id="uxDivMap2">
							<script type="text/javascript">
							
								jQuery("#uxHiddenEditLatitude").val(0);
								jQuery("#uxHiddenEditLongitude").val(0);
							
							</script>
							<?php
								$myaddress = urlencode($newLocationAddress . "," . $country->CountryName);
								//here is the google api url
								$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
								//get the content from the api using file_get_contents
								$getmap = file_get_contents($url);
								//the result is in json format. To decode it use json_decode
								$googlemap = json_decode($getmap);
								//get the latitute, longitude from the json result by doing a for loop
								$flag = 0;
								foreach($googlemap->results as $res){
									if($flag == 0)
									{
										$address = $res->geometry;
										$latlng = $address->location;
										$formattedaddress = $res->formatted_address;
										$flag++;
									
										?>
										
										<br />
										<!-- Print the Latitude and Longitude -->
										<input type="hidden" name="uxHiddenMessage2" id="uxHiddenMessage2" value="1">
										<input type="text" style="visibility: hidden" name="uxHiddenEditLatitudeOnChange" id="uxHiddenEditLatitudeOnChange" value="<?php echo $latlng->lat ?>">
										<input type="text" style="visibility: hidden" name="uxHiddenEditLongitudeOnChange" id="uxHiddenEditLongitudeOnChange" value="<?php echo $latlng->lng; ?>">
										<iframe id="uxLocationFrame2" width="780px" height="450px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $myaddress;?> &amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo urlencode($formattedaddress);?>&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
										<?php
									}
								}
								
							?>
						</div>
						<div>
							<script type="text/javascript">
								var hiddenMessageId = jQuery("#uxHiddenMessage2").val();
								if(hiddenMessageId != "1")
								{
								jQuery("#uxLblMessage2").text('<?php _e("Location Not Found.", events ); ?>');
								}
								
								
							</script>
							<div style="margin-left: 39%;">
								<label id="uxLblMessage2"></label>
							</div>
						</div>
				
						<?php	
						
					die();
			}

		}
	}	
?>