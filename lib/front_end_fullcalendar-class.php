<?php
	global $wpdb;
	$url1 = plugins_url('', __FILE__);
	if(isset($_REQUEST['param']))
	{
		if($_REQUEST['param'] == 'calendar')
		{
			$allBookings = $wpdb->get_results
			(
				$wpdb->prepare
				(
				
					"SELECT * from ".addEventTable(),""
					)
			);
			$dynamicCalendar = "<script>jQuery('#calendar').fullCalendar( 'destroy' );jQuery('#calendar').fullCalendar
			({
				disableDragging: true,
				header: 
				{
					left: 'prev,next',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: false,
				events: [";
				for($start = 0; $start<count($allBookings);$start++)
				{
					$countryName =  $wpdb->get_var
					(
						$wpdb->prepare
						(
						
							"SELECT CountryName from ".all_country_listTable()." where CountryId = %d",
							$allBookings[$start]->EventLocCountry
						)
					);
					$startDate = date("Y-m-d", strtotime($allBookings[$start]->EventFrom ));
					$newDate = date("Y-m-d", strtotime($allBookings[$start]->EventTo ));
					$bdate = (explode("-",$startDate));	
					$bEnddate = (explode("-",$newDate));	
					$getHours = floor(($allBookings[$start]->EventSTotalTime)/60);
					$getEndHours = floor(($allBookings[$start]->EventETotalTime))/60;
					if($getHours%60!=0)
					{
						$getMins = ($allBookings[$start]->EventSTotalTime) % 60;
					}
					else
					{
						$getMins = 0;
					}
					if($getEndHours%60!=0)
					{
						$getEndMins = ($allBookings[$start]->EventETotalTime) % 60;
					}
					else
					{
						$getEndMins = 0;
					}
					if($allBookings[$start]->EventFullDay == 1)
					{
						if($start == count($allBookings) -1)
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->EventName.'"'.",
							color: ".'"'.$allBookings[$start]->EventColorCode.'"'.",
							EventId: ".'"'.$allBookings[$start]->EventId.'"'.",
							EventLocation: ".'"'.$allBookings[$start]->EventLocAddress.'"'.",
							EventCountry: ".'"'.$countryName.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
							end: new Date($bEnddate[0], $bEnddate[1] - 1, $bEnddate[2]),
							url:'#editBooking',
							allDay: true
							}";
						}
						else
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->EventName.'"'.",
							color: ".'"'.$allBookings[$start]->EventColorCode.'"'.",
							EventId: ".'"'.$allBookings[$start]->EventId.'"'.",
							EventLocation: ".'"'.$allBookings[$start]->EventLocAddress.'"'.",
							EventCountry: ".'"'.$countryName.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2]),
							end: new Date($bEnddate[0], $bEnddate[1] - 1, $bEnddate[2]),
							url:'#editBooking',
							allDay: true
							},";
						}	
					}
					else
					{
						if($start == count($allBookings) -1)
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->EventName.'"'.",
							color: ".'"'.$allBookings[$start]->EventColorCode.'"'.",
							EventId: ".'"'.$allBookings[$start]->EventId.'"'.",
							EventLocation: ".'"'.$allBookings[$start]->EventLocAddress.'"'.",
							EventCountry: ".'"'.$countryName.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
							end: new Date($bEnddate[0], $bEnddate[1] - 1, $bEnddate[2], $getEndHours, $getEndMins),
							url:'#editBooking',
							allDay: false
							}";	
						}
						else
						{
							$dynamicCalendar .= "{
							title: ".'"'.$allBookings[$start]->EventName.'"'.",
							color: ".'"'.$allBookings[$start]->EventColorCode.'"'.",
							EventId: ".'"'.$allBookings[$start]->EventId.'"'.",
							EventLocation: ".'"'.$allBookings[$start]->EventLocAddress.'"'.",
							EventCountry: ".'"'.$countryName.'"'.",
							start: new Date($bdate[0], $bdate[1] - 1, $bdate[2], $getHours, $getMins),
							end: new Date($bEnddate[0], $bEnddate[1] - 1, $bEnddate[2], $getEndHours, $getEndMins),
							url:'#editBooking',
							allDay: false
						},";
					}	
				}
			}
			$dynamicCalendar .= "]});jQuery('.popover-test').popover({
			placement: 'left'
			});";
			echo $dynamicCalendar .= "</script>";
			die();
		}
		else if($_REQUEST['param'] == 'getTicketPrice')
		{
			$ticketId= intval($_REQUEST['ticketId']);
			$noOfTickets= intval($_REQUEST['noOfTickets']);
			
			$ticket = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".addTicketTable()." where TicketId = %d",
					$ticketId
				)
			);
						
			$totalPrice = ($ticket->TicketPrice) * $noOfTickets;
			echo $totalPrice;
			die();
		}
		else if($_REQUEST['param'] == 'getTicketPriceAndName')
		{
			$ticketId= intval($_REQUEST['ticketId']);
			$noOfTickets= intval($_REQUEST['noOfTickets']);
			
			$ticket = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".addTicketTable()." where TicketId = %d",
					$ticketId
				)
			);
			$currencyIcon = $wpdb->get_var
			(
				$wpdb->prepare
				(	
					'SELECT CurrencySymbol FROM ' . all_currency_listTable() . ' where CurrencyUsed = %d',
					"1"
				)
			);
			
			$totalPrice = ($ticket->TicketPrice) * $noOfTickets;
			$ticketName = $ticket->TicketName;
			echo $ticketName . "/" . $currencyIcon . " " . $totalPrice;
			die();
		}
		else if($_REQUEST['param'] == 'addCustomerBooking')
		{
			$eventId = intval($_REQUEST['eventId']);
			$ticketId = intval($_REQUEST['ticketId']);
				
				$uxEmail = esc_attr($_REQUEST['uxEmail']);
				$uxFirstName = esc_attr($_REQUEST['uxFirstName']);
				$uxLastName = esc_attr($_REQUEST['uxLastName']);
				$uxMobile = esc_attr($_REQUEST['uxMobile']);
				$uxAddress = esc_attr($_REQUEST['uxAddress']);
				$uxCity = esc_attr($_REQUEST['uxCity']);
				$uxPostCode = esc_attr($_REQUEST['uxPostCode']);
				$uxLocationCountry = intval($_REQUEST['uxLocationCountry']);
				$uxComment = esc_attr($_REQUEST['uxComment']);
				
				$wpdb->query
				(
					$wpdb->prepare
					(
						"INSERT INTO " .addCustomersTable(). "(CustomerFirstName, CustomerLastName, CustomerEmail, CustomerMobile, CustomerAddress, CustomerCity, CustomerZipCode, CustomerCountry, CustomerComments) 
						VALUES (%s, %s , %s , %s , %s ,%s , %s , %d , %s)",
						$uxFirstName,
						$uxLastName,
						$uxEmail,
						$uxMobile,
						$uxAddress,
						$uxCity,
						$uxPostCode,
						$uxLocationCountry,
						$uxComment
						
					)
				);
				echo $customerId = $wpdb->insert_id;
			
			die();		
		}
		else if($_REQUEST['param'] == 'addBooking')
		{
			$eventId = intval($_REQUEST['eventId']);
			$customerId = intval($_REQUEST['customerId']);
			$ticketId = intval($_REQUEST['ticketId']);
			$noOfTickets = intval($_REQUEST['noOfTickets']);
			$uxStartDate =  esc_attr($_REQUEST['startDate']);
			$uxStartTime = esc_attr($_REQUEST['startTime']);
			$uxEndDate = esc_attr($_REQUEST['endDate']);
			$eventFullDay=$wpdb->get_var
			(
				$wpdb->prepare
				(
						"SELECT EventFullDay from " . addEventTable() . " WHERE EventId = %d",
						$eventId
				)
			);
			$auto_approve = $wpdb -> get_var
			(
				$wpdb->prepare
				(
					'SELECT SettingsValue FROM ' . settingTable() . ' where SettingsKey  = %s',
					"auto_approve_status"
				)
			);	
			$event_booking_status = $wpdb -> get_var
			(
				$wpdb->prepare
				(
					'SELECT SettingsValue FROM ' . settingTable() . ' where SettingsKey  = %s',
					"event_booking_status"
				)
			);	
			if($event_booking_status == 1 && $auto_approve == 1)
			{
				$status = "Approved";
			}
			else 
			{
				$status = "Pending Approval";
			}
			if($eventFullDay == 0)
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"INSERT INTO " .addBookingTable(). "(EventId, CustomerId, TicketId, noOfTickets, BookingStartDate, BookingSTotalTime, BookingStatus, DateofBooking) 
						VALUES (%d, %d, %d, %d, '%s', %s, %s, CURDATE())",
						$eventId,
						$customerId,
						$ticketId,
						$noOfTickets,
						$uxStartDate,
						$uxStartTime,
						$status
					)
				);
				echo $bookingId = $wpdb->insert_id;
				include_once EBM_BK_PLUGIN_DIR.'/views/mailmanagement.php';
				if($auto_approve == 1)
				{
					MailManagement($bookingId,"approved");
				}
				else
				{
					MailManagement($bookingId,"approval_pending");
					MailManagement($bookingId,"admin");
				}
			}
			else
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"INSERT INTO " .addBookingTable(). "(EventId, CustomerId, TicketId, noOfTickets, BookingStartDate, BookingSTotalTime, BookingStatus, DateofBooking) 
						VALUES (%d, %d, %d, %d, '%s', %s, %s, CURDATE())",
						$eventId,
						$customerId,
						$ticketId,
						$noOfTickets,
						$uxStartDate,
						"0",
						$status
					)
				);
				echo $bookingId = $wpdb->insert_id;
				include_once EBM_BK_PLUGIN_DIR.'/views/mailmanagement.php';
				if($auto_approve == 1)
				{
					MailManagement($bookingId,"approved");
				}
				else
				{
					MailManagement($bookingId,"approval_pending");
					MailManagement($bookingId,"admin");
				}
			}
			die();
		}
		else if($_REQUEST['param'] == 'getMaxAndMinTicket')
		{
			$ticketId = intval($_REQUEST['ticketId']);
			$eventId = intval($_REQUEST['eventId']);
			$minAdnMaxTicket=$wpdb->get_row
			(
				$wpdb->prepare
				(
						"SELECT * from " . addTicketTable() . " WHERE TicketId = %d",
						$ticketId
				)
			);
			
			$getNoOfTickets = $wpdb->get_var
			(
				$wpdb->prepare
				(
						"SELECT sum(noOfTickets) as TotalTickets from " . addBookingTable() . " WHERE TicketId = %d and EventId = %d",
						$ticketId,
						$eventId
				)
			);
			
			$ticketsRemaining = ($minAdnMaxTicket->TicketAvail) - $getNoOfTickets;
			if($ticketsRemaining < 1)
			{
				echo "0";
			}		
			else if($ticketsRemaining < $minAdnMaxTicket->TicketMaxReq)
			{
				?>
				<option value="0"><?php _e("Choose Number of Tickets",events); ?></option>
				<?php
				for($flag=1; $flag<=$ticketsRemaining; $flag++)
				{
					?>
					<option value="<?php echo $flag; ?>"><?php echo $flag; ?></option>
					<?php
				}
			}
			else
			{
				?>
				<option value="0"><?php _e("Choose Number of Tickets", events);?></option>
				<?php
				for($flag=$minAdnMaxTicket->TicketMinReq; $flag<=$minAdnMaxTicket->TicketMaxReq; $flag++)
				{
					?>
					<option value="<?php echo $flag; ?>"><?php echo $flag; ?></option>
					<?php
				}
			}
			
			die();	
		}
		else if($_REQUEST['param'] == 'getSingleTicketPrice')
		{
			$ticketId = intval($_REQUEST['ticketId']);
			$noOfTickets= intval($_REQUEST['noOfTickets']);
			$ticketPrice = $wpdb->get_var
			(
				$wpdb->prepare
				(
						"SELECT TicketPrice from " . addTicketTable() . " WHERE TicketId = %d",
						$ticketId
				)
			);
			$currencyIcon = $wpdb->get_var
			(
				$wpdb->prepare
				(	
					'SELECT CurrencySymbol FROM ' . all_currency_listTable() . ' where CurrencyUsed = %d',
					"1"
				)
			);
			$total_price = $ticketPrice * $noOfTickets;
			echo $currencyIcon . " " . $total_price;
			die();	
			
			
		}
		
		else if($_REQUEST['param'] == "getExistingCustomer")
		{
			$uxEmailAddress = esc_attr($_REQUEST['uxEmailAddress']);
			$customerId = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT CustomerId FROM ' . addCustomersTable(). ' where CustomerEmail = %s',
					$uxEmailAddress
				)
			);
			if($customerId == 0)
			{
				echo $returnEmployeeEmailCountCheck = "newCustomer";
			}
			else
			{
								
					$customer = $wpdb->get_row
					(
						$wpdb->prepare
						(
							"SELECT * FROM ". addCustomersTable() ." where CustomerId = %d",
							$customerId
						)
					);
					
					?>
					<script type="text/javascript">
					
								jQuery('#uxFirstName').val("<?php echo $customer->CustomerFirstName; ?>");				
								jQuery('#uxLastName').val("<?php echo $customer->CustomerLastName; ?>");				
								jQuery('#uxMobile').val("<?php echo $customer->CustomerMobile; ?>");					
								jQuery('#uxAddress').val("<?php echo $customer->CustomerAddress; ?>");				
								jQuery('#uxCity').val("<?php echo $customer->CustomerCity; ?>");	
								jQuery('#uxPostCode').val("<?php echo $customer->CustomerZipCode; ?>");				
								jQuery('#uxLocationCountry').val("<?php echo $customer->CustomerCountry; ?>");
								jQuery('#uxComment').val("<?php echo $customer->CustomerComments; ?>");
							
					</script>
					<?php
					
				}
			die();
		}
		else if($_REQUEST['param'] == "UpdateCustomerBooking")
		{
			$eventId = intval($_REQUEST['eventId']);
			$ticketId = intval($_REQUEST['ticketId']);			
			
				$uxEmail = esc_attr($_REQUEST['uxEmail']);
				
				$customerId = $wpdb->get_var
				(
					$wpdb->prepare
					(
						'SELECT CustomerId FROM ' . addCustomersTable(). ' where CustomerEmail = %s',
						$uxEmail
					)
				);
				
				$uxFirstName = esc_attr($_REQUEST['uxFirstName']);
				$uxLastName = esc_attr($_REQUEST['uxLastName']);
				$uxMobile = esc_attr($_REQUEST['uxMobile']);
				$uxAddress = esc_attr($_REQUEST['uxAddress']);
				$uxCity = esc_attr($_REQUEST['uxCity']);
				$uxPostCode = esc_attr($_REQUEST['uxPostCode']);
				$uxLocationCountry = intval($_REQUEST['uxLocationCountry']);
				$uxComment = esc_attr($_REQUEST['uxComment']);
				
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE " .addCustomersTable(). " SET CustomerFirstName = %s, CustomerLastName = %s, CustomerMobile = %s, CustomerAddress = %s, CustomerCity = %s, CustomerZipCode = %s, CustomerCountry = %d, CustomerComments = %s WHERE CustomerId = %d",
						$uxFirstName,
						$uxLastName,
						$uxMobile,
						$uxAddress,
						$uxCity,
						$uxPostCode,
						$uxLocationCountry,
						$uxComment,
						$customerId
					)
				);
				echo $customerId;
			die();
		}
		else if($_REQUEST['param'] == "getCountryName")
		{
			$countryId = intval($_REQUEST['countryId']);
			$countryName = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT CountryName FROM ' . all_country_listTable(). ' where CountryId = %d',
					$countryId
				)
			);
			echo $countryName;
			die();
		}
		else if($_REQUEST['param'] == "showSingleEvent")
		{
			$EventId = intval($_REQUEST['eventId']);		
			global $wpdb;
			$setevent = $wpdb->get_row
			(
				$wpdb->prepare
				(
					"SELECT * FROM ".addEventTable()." where EventId = %d",
					$EventId
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
			$dateformat=$wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT SettingsValue FROM " .settingTable() . " WHERE SettingsKey = %s",
					"default_Date_Format"
				)
			);
			?>
			<input type="hidden" id="uxHdnEventId" name="uxHdnEventId" value="<?php echo $EventId; ?>" />
			<input type="hidden" id="uxHdnEndDate" name="uxHdnEndDate" value="<?php echo $setevent->EventTo; ?>" />
			<input type="hidden" id="uxHdnStartDate" name="uxHdnStartDate" value="<?php echo $setevent->EventFrom; ?>" />
			<input type="hidden" id="uxHdnStartTime" name="uxHdnStartTime" value="<?php echo $setevent->EventSTotalTime; ?>" />
			<input type="hidden" id="uxHdnEventName" name="uxHdnEventName" value="<?php echo $setevent->EventName; ?>" />
			<input type="hidden" id="uxHdnEventVenue" name="uxHdnEventVenue" value="<?php echo $setevent->EventLocName; ?>" />
			<input type="hidden" id="uxHdnEventAddress" name="uxHdnEventAddress" value="<?php echo $setevent->EventLocAddress; ?>" />
			<input type="hidden" id="uxHdnEventFullDay" name="uxHdnEventFullDay" value="<?php echo $setevent->EventFullDay; ?>" />

			<div id ="uxDivbackToCalendar">
				<a id ="uxLnkbackToCalendar" onclick="backToCalendar()" class="events-container-button green" style="margin-top: 1%;">
				<span><?php _e('Back', events); ?></span>
				</a>
			</div>
	<div id="uxDivSingleEvent" >
		<form method="post" action="" id="uxsetevent" name="uxsetevent">
			<div class="body">
				<?php
				
				$setevent = $wpdb->get_row
				(
					$wpdb->prepare
					(
						"SELECT * FROM ".addEventTable()." where EventId = %d",
						$EventId
					)
				);
				
				$bookingEvent = $wpdb->get_var
				(
					$wpdb->prepare
					(
						"SELECT SettingsValue from " . settingTable() . " WHERE SettingsKey = %s",
						"event_booking_status"
					)
				);
				$country=$wpdb->get_var
				(
					$wpdb->prepare
					(
						"SELECT CountryName from " . all_country_listTable() . " WHERE CountryId = %d",
						$setevent->EventLocCountry
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
				$dateformat=$wpdb->get_var
				(
					$wpdb->prepare
					(
						"SELECT SettingsValue FROM " .settingTable() . " WHERE SettingsKey = %s",
						"default_Date_Format"
					)
				);
				?>
				
				<h2><?php echo $setevent->EventName; ?></h2>
				
				<div class="eventDesc">
						<span><?php echo $setevent->EventDescription; ?></span>
					
				</div>
				<div class="eventMainDiv">
					<div class="eventLeftDiv">
						<div id="uxDivMapEdit">
								
							<?php
									$myaddress = urlencode($setevent->EventLocAddress . "," . $country);
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
											<iframe id="uxLocationFrame1" width="380px" height="300px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $myaddress;?> &amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo urlencode($formattedaddress);?>&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
											<?php
										}
									}
									
								?>	
						</div>
					</div>
					<div class="eventRightDiv">
						<div class="row">
							<label><?php _e( "Date :", events ); ?></label>
							<div class = "contentDiv">
								<?php
									if($setevent->EventFullDay == 1)
									{
										if($dateformat == 0)
										{
										?>
											<span><?php echo date('M d, Y', strtotime($setevent->EventFrom)); ?> - <?php echo date('M d, Y', strtotime($setevent->EventTo));  ?></span>
										<?php
										}
										if($dateformat == 1)
										{
										?>
											<span><?php echo date('Y/m/d', strtotime($setevent->EventFrom)); ?> - <?php echo date('Y/m/d', strtotime($setevent->EventTo)); ?></span>
										<?php
										}
										if($dateformat == 2)
										{
										?>
											<span><?php echo date('m/d/Y', strtotime($setevent->EventFrom)); ?> - <?php echo date('m/d/Y', strtotime($setevent->EventTo));  ?></span>
										<?php
										}
										if($dateformat == 3)
										{
										?>
											<span><?php echo date('d/m/Y', strtotime($setevent->EventFrom)); ?> - <?php echo date('d/m/Y', strtotime($setevent->EventTo)); ?></span>
										<?php
										}
									}
									else
									{
										if($dateformat == 0)
										{
										?>
											<span><?php echo date('M d, Y', strtotime($setevent->EventFrom)); ?></span>
										<?php
										}
										if($dateformat == 1)
										{
										?>
											<span><?php echo date('Y/m/d', strtotime($setevent->EventFrom)); ?></span>
										<?php
										}
										if($dateformat == 2)
										{
										?>
											<span><?php echo date('m/d/Y', strtotime($setevent->EventFrom)); ?> </span>
										<?php
										}
											if($dateformat == 3)
										{
										?>
											<span><?php echo date('d/m/Y', strtotime($setevent->EventFrom)); ?></span>
										<?php
										}
									}
								?>
							</div>
						</div>
						<?php
									if($setevent->EventFullDay == 0)
									{
									?>
										<div class="row">
							
										<label><?php _e( "Time Slot :", events ); ?></label>
										<div class = "contentDiv">
											<?php
												$getHours = floor($setevent->EventSTotalTime / 60) ;
												$getMins = $setevent->EventSTotalTime % 60 ;
												$ShourFormat = $getHours . ":" . $getMins;
												$getEHours = floor($setevent->EventETotalTime / 60) ;
												$getEMins = $setevent->EventETotalTime % 60 ;
												$EhourFormat = $getEHours . ":" . $getEMins;
												if($timeformat == 0)
												{
													$Stime_in_12_hour_format  = DATE("h:i a", STRTOTIME($ShourFormat));
													$Etime_in_12_hour_format  = DATE("h:i a", STRTOTIME($EhourFormat));
												}
												else
												{
													$Stime_in_12_hour_format  = DATE("H:i", STRTOTIME($ShourFormat));
													$Etime_in_12_hour_format  = DATE("G:i", STRTOTIME($EhourFormat));
												}
												if($setevent->EventFullDay == 0)
												{
												?>
													<?php echo $Stime_in_12_hour_format . " - " . $Etime_in_12_hour_format;?>
													<input type="hidden" name="uxHdnTime" id="uxHdnTime"  value="<?php echo $Stime_in_12_hour_format . " - " . $Etime_in_12_hour_format;?>"/>
												<?php
												}
												else 
												{
												?>
													<span>-</span>
												<?php
												}
											?>
										</div>
									</div>
									<?php
									}
									
								?>
						
						<div class="row">
							<label><?php _e( "Venue :", events ); ?></label>
							<div class="contentDiv">
								<span><?php echo $setevent->EventLocName	; ?></span>
							</div>
						</div>
						<div class="row">
							<label><?php _e( "Address :", events ); ?></label>
							<div class = "contentDiv">
								<span><?php echo $setevent->EventLocAddress; ?></span>
							</div>
						</div>
						<div class="row">
							<label><?php _e( "City :", events ); ?></label>
							<div class = "contentDiv">
								<span><?php echo $setevent->EventLocCity; ?></span>
							</div>
						</div>
						<?php
						if($bookingEvent == 1)
						{
						?>
							<div class="row">
								<label>
									<?php _e( "Ticket Type :", events ); ?>
								</label>
								<div class="contentDiv">
								<?php
								global $wpdb;
								$tickets=$wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT * FROM " .addTicketTable() . " WHERE EventId = %d",
										$EventId
									)
								);
								?>
									<select name="uxTicketType" id="uxTicketType" style="width: 230px;" onchange="bindNoOfTickes()">
										<option value="0"><?php _e( "Choose Ticket", events ); ?></option>
										<?php
										for($flag=0; $flag<count($tickets); $flag++)
										{
										?>
											<option value="<?php echo $tickets[$flag]->TicketId; ?>"><?php echo $tickets[$flag]->TicketName; ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
								<div id="uxDivNoOfTickets" class="row" style="display: none">
									<label>
										<?php _e( "Number of Tickets :", events ); ?>
									</label>
									<div class="contentDiv">
										<select name="uxNoOfTicket" id="uxNoOfTicket" style="width: 230px;" onchange="calculatePrice()">
										</select>
									</div>
								</div>
								<div id="uxDivTicketPrice" class="row" style="display: none">
									<label>
										<?php _e( "Price :", events ); ?>
									</label>
									<div class="contentDiv">
										<span id="uxTicketPrice"></span>
									</div>
								</div>
						<div class="row" style="border-bottom:none !important">
							<label>
							</label>
							<div class="contentDiv" id="uxDivSubmitTicket">
								<a id="uxLnkSubmitTicket" onclick="checkDropDown()" class="events-container-button green" style="margin-top: 1%;width: 105px;">
								<span><?php _e('Book now', events); ?></span>
								</a>
							</div>
						</div>
						
					</div>
				</div>
				
		<?php
		}
		?>
			</div>
		</form>
	</div>
			
			<div id="uxDivCustomer" style="display: none">
		
		<div id="uxCustomerLink" >
		<a onclick="backToEvents()" id="uxLnkBackToEvent" class="events-container-button green" style="margin-top: 10px;">
			<span><?php _e('Back to Event', events); ?></span>
		</a>
		</div>
		<div id="uxConfirmLink" style="display: none">
		<a onclick="backToConfirm()" class="events-container-button green" style="margin-top: 10px;width: 160px;">
			<span><?php _e('Back to Customer', events); ?></span>
		</a>
		</div>
		<form id="uxaddCustomerForm" class="events-container-form" method="post" action="">
		<div class="message green" id="successMessageBookings" style="display:none;margin-left:10px;">
			<span>
				<strong>
					<?php _e( "Success! Booking has been saved.", events ); ?>
				</strong>
			</span>
		</div>

		<div id="uxCustomerGrid" class="body" style="display: block;">
			
			<div id="scriptExistingCustomer" style="display: none"></div>
			<div class="row">
				<label>
					<?php _e("E-mail Address :", events);?>
				</label>
				<div class = "right">
					<input type="text" name="uxEmail" id="uxEmail" onblur="checkExistingCustomerBooking();" />
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("First Name :", events);?>
				</label>
				<div class = "right">
					<input type="text" name="uxFirstName" id="uxFirstName"/>
				</div>
			</div>	
			<div class="row">
				<label>
					<?php _e("Last Name :", events);?>
				</label>
				<div class = "right">
					<input type="text" name="uxLastName" id="uxLastName"/>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Mobile :", events);?>
				</label>
				<div class = "right">
					<input type="text" name="uxMobile" id="uxMobile"/>
				</div>
			</div>					
			<div class="row">
				<label>
					<?php _e("Address :", events);?>
				</label>
				<div class = "right">
					<textarea name="uxAddress" id="uxAddress"></textarea> 
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("City :", events);?>
				</label>
				<div class = "right">
					<input type="text" name="uxCity" id="uxCity"/>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Post Code :", events);?>
				</label>
				<div class = "right">
					<input type="text" name="uxPostCode" id="uxPostCode"/>
				</div>
			</div>	
			<div class="row">
				<label>
					<?php _e("Country :", events);?>
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
							<select name="uxLocationCountry" id="uxLocationCountry" style="width:100%">
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
			<div class="row">
				<label>
					<?php _e("Comments :", events);?>
				</label>
				<div class = "right">
					<textarea id="uxComment" name="uxComment" style="height:119px"></textarea>
				</div>
			</div>
			<div class="row" style="border-bottom:none !important">
				<label></label>
				<div class="right">					
					<button type="submit" class="events-container-button green">
						<span>
							<?php _e( "Save & Submit", events); ?>
						</span>
					</button>
					
				</div>
			</div>
		</div>
		
		<div id="uxConfirmGrid" class="body" style="display: none;">
			
			<div class="row">
				<label>
					<?php _e("Event :", events);?>
				</label>
				<div class = "right">
					<span id="uxEventName"></span>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Venue :", events);?>
				</label>
				<div class = "right">
					<span id="uxEventVenue"></span>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Address :", events);?>
				</label>
				<div class = "right">
					<span id="uxEventAddress"></span>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Date :", events);?>
				</label>
				<div class = "right">
					<span id="uxEventDate"></span>
				</div>
			</div>
			<?php
				if($setevent->EventFullDay == 0)
				{
			?>
				<div class="row">
				<label>
					<?php _e("Time :", events);?>
				</label>
				<div class = "right">
					<span id="uxEventTime"></span>
				</div>
			</div>
			<?php
				}
			?>
			<div class="row">
				<label>
					<?php _e("Ticket Name :", events);?>
				</label>
				<div class = "right">
					<span id="uxTicketName"></span>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Number of tickets :", events);?>
				</label>
				<div class = "right">
					<span id="uxNoOfTicketName"></span>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Price :", events);?>
				</label>
				<div class = "right">
					<span id="uxTicketPriceConfirm"></span>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("E-mail Address :", events);?>
				</label>
				<div class = "right">
					<span id="uxEmailConfirm"></span>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("First Name :", events);?>
				</label>
				<div class = "right">
					<span id="uxFirstNameConfirm"></span>
				</div>
			</div>	
			<div class="row">
				<label>
					<?php _e("Last Name :", events);?>
				</label>
				<div class = "right">
					<span id="uxLastNameConfirm"></span>		
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Mobile :", events);?>
				</label>
				<div class = "right">
					<span id="uxMobileConfirm"> </span>	
				</div>
			</div>					
			<div class="row">
				<label>
					<?php _e("Address :", events);?>
				</label>
				<div class = "right">
					<span id="uxAddressConfirm"> </span>	
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("City :", events);?>
				</label>
				<div class = "right">
					<span id="uxCityConfirm"> </span>	
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Post Code :", events);?>
				</label>
				<div class = "right">
					<span id="uxPostCodeConfirm"> </span>
				</div>
			</div>	
			<div class="row">
				<label>
					<?php _e("Country :", events);?>
				</label>
				<div class = "right">
					
						<?php
							global $wpdb;
							
							$payapalEnable= $wpdb->get_var
							(
								$wpdb->prepare
								(
									'SELECT SettingsValue  FROM ' . settingTable() .' where SettingsKey = %s',
									"paypal-enabled"
								)
							);
							
							$currencyIcon = $wpdb->get_var
							(
								$wpdb->prepare
								(	
									'SELECT CurrencyCode FROM ' . all_currency_listTable() . ' where CurrencyUsed = %d',
									"1"
								)
							);
							$paypalURL = $wpdb->get_var
							(
								$wpdb->prepare
								(
									'SELECT SettingsValue  FROM ' . settingTable() . ' where SettingsKey = %s',
									"paypal-Test-Url"
								)
							);
							
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
							<span id="uxCountryConfirm"> </span>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Comments :", events);?>
				</label>
				<div class = "right">
					<span id="uxCommentConfirm"> </span>
					
				</div>
			</div>
			<div class="row" style="border-bottom:none !important">
				<label></label>
				<div class="right">
						<a onclick="submitData()" class="events-container-button green" style="margin-top: 1%;">
							<span><?php _e('Submit', events); ?></span>
						</a>
					
				</div>
			</div>
		</div>
		
	</form>
</div>
<script type="text/javascript">
	
	
	jQuery("#uxaddCustomerForm").validate
	({
		rules:
		{
			uxEmail:
			{
				required: true,
				email: true
			},
			uxFirstName:
			{
				required: true
			},
			uxLastName:
			{
				required: true
			},
			uxMobile:
			{
				number: true
			},
		},	
		submitHandler: function(form) 
		{	
			jQuery("#uxCustomerGrid").css("display","none");
			jQuery("#uxConfirmGrid").css("display","block");
			jQuery("#uxCustomerLink").css("display","none");
			jQuery("#uxConfirmLink").css("display","block");
			
			var uxHdnEventId = jQuery("#uxHdnEventId").val();
			var ticketId = jQuery("#uxTicketType").val();
			var noOfTickets = jQuery("#uxNoOfTicket").val();
			var startDate = jQuery("#uxHdnStartDate").val();
			var endDate = jQuery("#uxHdnEndDate").val();
			var startTime = jQuery("#uxHdnStartTime").val();
			var eventName = jQuery("#uxHdnEventName").val();
			var fulDay =jQuery("#uxHdnEventFullDay").val(); 
			jQuery("#uxEventName").html(eventName + "&nbsp;");
			jQuery("#uxEventVenue").html(jQuery("#uxHdnEventVenue").val() + "&nbsp;");
			jQuery("#uxEventAddress").html(jQuery("#uxHdnEventAddress").val() + "&nbsp;");
			var time = jQuery("#uxHdnTime").val();
			if(fulDay == 0)
			{
				jQuery("#uxEventDate").html(startDate + "&nbsp;");
				jQuery("#uxEventTime").html(time + "&nbsp;");
			
			}
			else
			{
				jQuery("#uxEventDate").html(startDate + "  -  " + endDate + "&nbsp;");
			}
			jQuery.post(ajaxurl, "ticketId=" + ticketId + "&noOfTickets=" + noOfTickets + "&param=getTicketPriceAndName&action=monthlycalendarLibrary", function(data) 
			{
				var datta = data.split("/");
				jQuery("#uxTicketName").html( datta[0] + "&nbsp;");
				jQuery("#uxNoOfTicketName").html( noOfTickets + "&nbsp;");
				jQuery("#uxTicketPriceConfirm").html( datta[1] + "&nbsp;");
			});
			
			jQuery("#uxEmailConfirm").html(jQuery("#uxEmail").val()+"&nbsp;");
			jQuery("#uxFirstNameConfirm").html(jQuery("#uxFirstName").val()+"&nbsp;");
			jQuery("#uxLastNameConfirm").html(jQuery("#uxLastName").val()+"&nbsp;");
			jQuery("#uxMobileConfirm").html(jQuery("#uxMobile").val()+"&nbsp;");
			jQuery("#uxAddressConfirm").html(jQuery("#uxAddress").val()+"&nbsp;");
			jQuery("#uxCityConfirm").html(jQuery("#uxCity").val()+"&nbsp;");
			jQuery("#uxPostCodeConfirm").html(jQuery("#uxPostCode").val()+"&nbsp;");
			jQuery("#uxCountryConfirm").html(jQuery("#uxLocationCountry").val()+"&nbsp;");
			var countryId = jQuery("#uxLocationCountry").val();
			jQuery.post(ajaxurl, "countryId=" + countryId + "&param=getCountryName&action=monthlycalendarLibrary", function(data) 
			{
				jQuery("#uxCountryConfirm").html(data + "&nbsp;");
			});
			
			jQuery("#uxCommentConfirm").html(jQuery("#uxComment").val() + "&nbsp;");
			
		}
	});
	
	function submitData()
		{
			var uxEmail = jQuery('#uxEmail').val();
			var eventId = jQuery("#uxHdnEventId").val();
			var ticketId = jQuery("#uxTicketType").val();
			
			jQuery.post(ajaxurl, "uxEmailAddress="+uxEmail+ "&param=getExistingCustomer&action=monthlycalendarLibrary", function(data) 
			{
				if(jQuery.trim(data) != "newCustomer")
				{
					jQuery.post(ajaxurl, jQuery("#uxaddCustomerForm").serialize() + "&eventId=" + eventId + "&ticketId=" + ticketId + "&uxEmail=" + uxEmail + "&param=UpdateCustomerBooking&action=monthlycalendarLibrary", function(data) 
					{
						var customerId = jQuery.trim(data);
						addBooking(eventId,customerId);
										
					});	
					
				}
				else
				{
					jQuery.post(ajaxurl, jQuery("#uxaddCustomerForm").serialize() + "&eventId=" + eventId + "&ticketId=" + ticketId + "&param=addCustomerBooking&action=monthlycalendarLibrary", function(data) 
					{
						var customerId = jQuery.trim(data);
						addBooking(eventId,customerId);
										
					});	
				}	
			});
		}
		
		function addBooking(eventId,customerId)
		{
			var paypalCheck = "<?php echo $payapalEnable; ?>";	
			var startDate = jQuery("#uxHdnStartDate").val();
			var startTime = jQuery("#uxHdnStartTime").val();
			var endDate = jQuery("#uxHdnEndDate").val();
			var ticketId = jQuery("#uxTicketType").val();
			var noOfTickets = jQuery("#uxNoOfTicket").val();
			jQuery.post(ajaxurl, jQuery("#uxsetevent").serialize() + "&ticketId=" + ticketId + "&noOfTickets=" + noOfTickets  + "&eventId=" + eventId + "&customerId=" + customerId + "&startDate=" + startDate + "&startTime=" + startTime +"&endDate=" + endDate + "&param=addBooking&action=monthlycalendarLibrary", function(data) 
			{
					window.location.reload();
			});
		}
		
		
	</script>
			<?php
			die();
		}
		
		
	}
?>

