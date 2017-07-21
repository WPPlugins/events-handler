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
					<?php _e( "SHORTCODE", events); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<div class="box">
			<div class="title">
				<?php _e("Shortcodes", events); ?>
			</div>
			<div class="content">
			<form method="post" action="" class="events-container-form" id="uxFormSettings">
				<div class="body">
					<div class="row">
						<label>
							<?php _e("Events with Full Calendar :", events);?>
						</label>
						<div class = "right">
						<textarea id="uxshordcode1" name="uxshordcode1">[events_handler_full_calendar][/events_handler_full_calendar]</textarea>
						</div>
					</div>
					<div class="row">
						<label>
						<?php _e("Events in List View :", events);?>
						</label>
						<div class = "right">
							<textarea id="uxshordcode2" name="uxshordcode2">[events_handler_table_display][/events_handler_table_display]</textarea>
						</div>
					</div>
					<div class="row">
						<label>
						<?php _e("Single Event Display :", events);?>
						</label>
						<div class = "right">
							<textarea id="uxshordcode2" name="uxshordcode2">[events_handler event_id=your_event_id][/events_handler]</textarea>
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
<script type="text/javascript">jQuery("#Shortcodes").addClass("current");</script>