<?php
if(!current_user_can('edit_posts') && ! current_user_can('edit_pages'))
{
	return;
}
else
{
	$url = plugins_url('', __FILE__);
	if(isset($_REQUEST['param']))
	{
		if($_REQUEST['param'] == 'getBookings')
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
							url:'#',
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
							url:'#',
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
							url:'#',
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
							url:'#',
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
	}
}