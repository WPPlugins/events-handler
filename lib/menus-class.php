<?php
if (!current_user_can("edit_posts") && ! current_user_can("edit_pages"))
{
	return;
}
else 
{
	$url = plugins_url('', __FILE__);
	if(isset($_REQUEST['param']))
	{
		if($_REQUEST['param'] == "getEventCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(EventId) FROM ' . addEventTable(),''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['param'] == "getBookingCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(BookingId) FROM ' . addBookingTable() ,''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['param'] == "getTicketCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(TicketId) FROM ' . addTicketTable(),''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['param'] == "getCustomerCount")
		{
			$count = $wpdb->get_var
			(
				$wpdb->prepare
				(
					'SELECT count(CustomerId) FROM ' . addCustomersTable(),''
				)
			);
			echo $count;
			die();
		}
		else if($_REQUEST['param'] == 'defaultSettingsArea')
		{
			$currency = $wpdb -> get_var
			(
				$wpdb->prepare
				(
					"SELECT CurrencySymbol FROM ".all_currency_listTable(). " where CurrencyUsed  = %d",
					1
				)
			);
			?>
			<li>
				<?php _e( "Default Currency", events ); ?>
				<div class="info black">
					<span><?php echo $currency?></span>
				</div>
			</li>
			<?php
			$dateFormat = $wpdb->get_var
			(
				$wpdb->prepare
				(	
					'SELECT SettingsValue FROM ' . settingTable() . ' where SettingsKey = %s',
					"default_Date_Format"
				)
			);
			?>
			<li>
				<?php _e( "Date Format", events ); ?>
				<?php
				$date = date('j'); 
				$monthName = date('F');
				$monthNumeric = date('m');
				$year = date('Y');
				if($dateFormat == 0)
				{
					?>	
					<div class="info blue">
						<span><?php echo  $monthName ." ".$date.",  ".$year; ?></span>
					</div>
					<?php
				}
				else if($dateFormat == 1)
				{
				?>
					<div class="info blue">
						<span><?php echo  $year ."/".$monthNumeric."/".$date; ?></span>
					</div>
				<?php
				}
				else if($dateFormat == 2)
				{
				?>
					<div class="info blue">
						<span><?php echo  $monthNumeric ."/".$date."/".$year; ?></span>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="info blue">
						<span><?php echo $date ."/".$monthNumeric."/".$year;  ?></span>
					</div>
				<?php
				}
			?>	
			</li>
			<?php
			$timeFormat = $wpdb -> get_var
			(
				$wpdb->prepare
				(
					'SELECT SettingsValue   FROM ' . settingTable() . ' where SettingsKey = %s',
					"default_Time_Format"
				)
			);
			?>
			<li>
				<?php _e( "Time Format", events ); ?>
				<?php
				if($timeFormat == 0)
				{
				?>	
					<div class="info red">
						<span><?php _e( "12 Hours", events ); ?></span>
					</div>
				<?php
				}
				else
				{
				?>
					<div class="info red">
						<span><?php _e( "24 Hours", events ); ?></span>
					</div>
				<?php
				}
				?>
			</li>
			<?php
				$timeZone = $wpdb -> get_var
				(
					$wpdb->prepare
					(
						'SELECT SettingsValue   FROM ' . settingTable() . ' where SettingsKey = %s',
						"default_Time_Zone"
					)
				);
			?>
			<li>
				<?php _e( "Time Zone", events ); ?>
				<div class="info black">
					<span><?php echo $timeZone?></span>
				</div>
			</li>
			
			<?php
				$auto_approve = $wpdb -> get_var
				(
					$wpdb->prepare
					(
						'SELECT SettingsValue   FROM ' . settingTable() . ' where SettingsKey = %s',
						"auto_approve_status"
					)
				);
			?>
			<li>
				<?php _e( "Auto Approve", events ); ?>
				
					<?php
					if($auto_approve == 1)
					{
					?>
						<div class="info green">
						<span><?php _e("On", events);?></span>	
						</div>
					<?php
					}
					else 
					{
					?>
						<div class="info red">
						<span><?php _e("Off", events);?></span>	
						</div>
					<?php
					}
					?>
			</li>
			<?php
				$country = $wpdb -> get_var
				(
					$wpdb->prepare
					(
						'SELECT CountryName   FROM ' . all_country_listTable() . ' where CountryUsed = %d',
						"1"
					)
				);
			?>
			<li style="height: 9px;">
				<label></label>
				<div class="info blue">
					<span><?php echo $country?></span>
				</div>
			</li>
			<?php
			die();
		}
		?>
		<?php	
	}	
}
?>