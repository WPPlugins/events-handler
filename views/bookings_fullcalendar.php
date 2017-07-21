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
					<?php _e( "EVENTS BOOKINGS", events ); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<div class="box">
			<div class="title">
				<?php _e("Events Calendar", events); ?>
				<span class="hide"></span>
			</div>
			<div class="content">
				<div id="calendar"></div>
				<div id="dynamicCalendar"></div>
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
	jQuery("#Bookings_fullcalendar").attr("class","current");
		//===== Calendar =====//
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	jQuery(document).ready(function()
	{
		showEvents();
	});
	function showEvents()
	{
		
		jQuery.post(ajaxurl,jQuery('#uxbookingsForm').serialize()+ "param=getBookings&action=fullCalLibrary", function(data)
		{
			
			jQuery('#dynamicCalendar').html(data);
		});
	}
</script>