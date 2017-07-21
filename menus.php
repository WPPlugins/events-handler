<div id="top">
	<h1 id="logo"></h1>
	<div id="menu">
		<ul class="sf-js-enabled">
			<li id="Events">
				<a href="admin.php?page=eventshandler">
					<?php _e( "Events", events ); ?>
				</a>
			</li> 
			<li id="Bookings">
				<a href="admin.php?page=bookings" >
					<?php _e( "Bookings", events ); ?>
				</a>
			</li> 
			<li id="Bookings_fullcalendar">
				<a href="admin.php?page=calendar" >
					<?php _e( "Calendar", events ); ?>
				</a>
			</li>
			<li id="Tickets">
				<a href="admin.php?page=tickets">
					<?php _e( "Tickets", events ); ?>
				</a>
			</li>
			<li id="Clients">
				<a href="admin.php?page=customers">
					<?php _e( "Customers", events ); ?>
				</a>
			</li>
			<li id="Shortcodes">
				<a href="admin.php?page=shortcode">
					<?php _e( "Shortcodes", events ); ?>
				</a>
			</li>
			<li id="Settings">
				<a href="admin.php?page=settings">
					<?php _e( "Settings", events ); ?>
				</a>
			</li>
			<li id="APIkey">
				<a href="admin.php?page=apikey">
					<?php _e( "API KEY", events ); ?>
				</a>
			</li>
		</ul>
	</div>
</div>
<div id="left">
	<div class="box statics">
		<div class="content">
			<ul>
				<li>
					<h2><?php _e( "Overview Stats", events ); ?></h2>
				</li>
				<li>
					<?php _e( "Total Events", events ); ?>
					<div class="info red">
						<span id="uxEventsCount"></span>
					</div>
				</li>
				<li>
					<?php _e( "Total Bookings", events ); ?>
					<div class="info blue">
						<span id="uxBookingsCount"></span>
					</div>
				</li>
				<li>
					<?php _e( "Total Tickets", events ); ?>
					<div class="info black">
						<span id="uxTicketsCount"></span>
					</div>
				</li>
				<li>
					<?php _e( "Total Customers", events ); ?>
					<div class="info green">
						<span id="uxCustomersCount"></span>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="box statics">
		<div class="content">
			<ul>
				<li>
					<h2><?php _e( "Default Settings", events ); ?></h2>
				</li>
				<li ></li>
				<div id="defaultSettingsArea" style="margin-top: -14px;" >	
				</div>
			</ul>
		</div>
	</div>	
</div>
<script type="text/javascript">

	jQuery.post(ajaxurl,"&param=getEventCount&action=menuLibrary", function(data)
	{
		jQuery("#uxEventsCount").html(data);
		//jQuery("#uxDashboardServiceCount").html(data);
	});
	jQuery.post(ajaxurl, "&param=getBookingCount&action=menuLibrary", function(data)
	{
		
		jQuery("#uxBookingsCount").html(data);
		//jQuery("#uxDashboardCustomersCount").html(data);
	});
	jQuery.post(ajaxurl, "&param=getTicketCount&action=menuLibrary", function(data)
	{
		jQuery("#uxTicketsCount").html(data);
		//jQuery("#uxDashboardBookingsCount").html(data);
	});
	jQuery.post(ajaxurl, "&param=getCustomerCount&action=menuLibrary", function(data)
	{
		jQuery("#uxCustomersCount").html(data);
		//jQuery("#uxDashboardCustomersCount").html(data);
	});
	jQuery.post(ajaxurl, "&param=defaultSettingsArea&action=menuLibrary", function(data)
	{
		jQuery("#defaultSettingsArea").html(data);
	});

</script>
