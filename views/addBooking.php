<div id="right">
	<div id="breadcrumbs">
		<ul>
			<li class="first"></li>
			<li>
				<a href="#">
					<?php _e( "EVENT HANDLER", events ); ?>
				</a>
			</li>
			<li class="last">
				<a href="admin.php?page=bookings">
					<?php _e( "BOOKINGS", events); ?>
				</a>
			</li>
			<li class="last">
				<a href="#">
					<?php _e( "ADD BOOKINGS", events); ?>
				</a>
			</li>
		</ul>
	</div>
	<form id="uxaddBookingForm" class="events-container-form" method="post" action="">
		<div class="message green" id="successMessageBookings" style="display:none;margin-left:10px;">
			<span>
				<strong>
					<?php _e( "Success! Booking has been saved.", events ); ?>
				</strong>
			</span>
		</div>
		<div class="message red" id="errorBookingTime" style="display:none;margin-left:10px;">
			<span>
				<strong>
					<?php _e( "Error! Please enter valid booking time.", events ); ?>
				</strong>
			</span>
		</div>
		<div class="message red" id="errorSelectEvent" style="display:none;margin-left:10px;">
			<span>
				<strong>
					<?php _e( "Error! Please choose event.", events ); ?>
				</strong>
			</span>
		</div>
		<div class="body">
			
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
					<?php _e("E-mail.Id :", events);?>
				</label>
				<div class = "right">
					<input type="text" name="uxEmail" id="uxEmail"/>
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
					<input type="text" name="uxAddress" id="uxAddress"/>
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
					<input type="text" name="uxBookingName" id="uxBookingName"/>
				</div>
			</div>
			<div class="row">
				<label>
					<?php _e("Comments :", events);?>
				</label>
				<div class = "right">
					<textarea id="uxComment" name="uxComment"n style="height:119px"></textarea>
				</div>
			</div>
			<div class="row" style="border-bottom:none !important">
				<label></label>
				<div class="right">
					<button type="submit" class="events-container-button orange">
						<span>
							<?php _e( "Submit & Save", events); ?>
						</span>
					</button>
					<a href="admin.php?page=bookings" class="events-container-button orange" style="margin-top: 10px;">
						<span><?php _e('Cancel Bookings', events); ?></span>
					</a>
				</div>
			</div>
		</div>
	</form>
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