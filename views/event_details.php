<?php
	global $wpdb;
	$url = plugins_url('', __FILE__);
	$EventId = $event_id;
	?>
<input type="hidden" id="uxHdnEventId" name="uxHdnEventId" value="<?php echo $EventId; ?>" />
<div id="dynamic_event_detail">
</div>

<script type="text/javascript">
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	
	function backToConfirm()
	{
			jQuery("#uxCustomerGrid").css("display","block");
			jQuery("#uxConfirmGrid").css("display","none");
			jQuery("#uxCustomerLink").css("display","block");
			jQuery("#uxConfirmLink").css("display","none");
	}

	function bindNoOfTickes()
	{
		var ticketId = jQuery("#uxTicketType").val();
		var eventId = jQuery("#uxHdnEventId").val();
		if(ticketId == 0)
		{
			jQuery("#uxDivNoOfTickets").css("display","none");
			jQuery("#uxDivTicketPrice").css("display","none");
		}
		else
		{
			jQuery("#uxDivNoOfTickets").css("display","block");		
			jQuery.post(ajaxurl, "ticketId=" + ticketId + "&eventId=" + eventId +"&param=getMaxAndMinTicket&action=monthlycalendarLibrary", function(data) 
			{
				
				if(data == 0)
				{
					jQuery("#uxDivNoOfTickets").css("display","none");
					jQuery("#uxDivTicketPrice").css("display","none");
					jQuery("#uxDivSubmitTicket").css("display","none");
					bootbox.alert("<?php _e("No more booking possible on this event.",events);?>");
					
				}
				else
				{
					jQuery("#uxDivNoOfTickets").css("display","block");
					jQuery("#uxDivSubmitTicket").css("display","block");
					jQuery("#uxNoOfTicket").html(data);
				}
							
			});
			
		}
	}
	
	function calculatePrice()
	{
		var ticketId = jQuery("#uxTicketType").val();
		var noOfTickets = jQuery("#uxNoOfTicket").val();
		jQuery("#uxDivTicketPrice").css("display","block");
		jQuery.post(ajaxurl, "ticketId=" + ticketId + "&noOfTickets=" + noOfTickets + "&param=getSingleTicketPrice&action=monthlycalendarLibrary", function(data) 
		{
				
				jQuery("#uxTicketPrice").html(data);
		});
		
	}
		
	function checkExistingCustomerBooking()
	{
		var uxEmail = jQuery('#uxEmail').val();
		jQuery.post(ajaxurl, "uxEmailAddress="+uxEmail+ "&param=getExistingCustomer&action=monthlycalendarLibrary", function(data) 
		{
			if(jQuery.trim(data) != "newCustomer")
			{
				
				var dataa = data.trim();
				jQuery("#scriptExistingCustomer").html(dataa);
			}
			else
			{
				jQuery('#uxEmail').val(jQuery('#uxEmail').val());
			}	
		});
	}
	
	
	function backToCalendar()
	{
		var actual_link = '<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>';
		var arrayOfLinks = actual_link.split("&");
		var backLink = arrayOfLinks[0];
		jQuery("#uxLnkbackToCalendar").attr("href",backLink);
	}
	function backToEvents()
	{
		jQuery("#uxDivSingleEvent").css("display","block");
		jQuery("#uxDivCustomer").css("display","none");
		jQuery("#uxDivbackToCalendar").css("display","none");
		jQuery("#uxCustomerLink").css("display","none");
	}
	function checkDropDown()
		{
			
			var ticketId = jQuery("#uxTicketType").val();
			var noOfTickets = jQuery("#uxNoOfTicket").val();
			if(ticketId == 0)
			{
				
				bootbox.alert("<?php _e("Please choose ticket type", events); ?>");
			}
			else
			{	
				if(noOfTickets == 0)
				{
					
					bootbox.alert("<?php _e("Please choose Number of tickets", events); ?>");
				}
				else
				{
					jQuery("#uxDivbackToCalendar").css("display","none");
					jQuery("#uxDivSingleEvent").css("display","none");
					jQuery("#uxDivCustomer").css("display","block");
					jQuery("#uxCustomerLink").css("display","block");
				}		
				
			}
		}
	jQuery(document).ready(function(){
		
		var eventID = jQuery("#uxHdnEventId").val();
		jQuery.post(ajaxurl, "eventId=" + eventID + "&param=showSingleEvent&action=monthlycalendarLibrary", function(data) 
		{
			jQuery("#dynamic_event_detail").html(data);
			jQuery("#uxDivbackToCalendar").css("display","none");
			
		});	
	})
		
</script>
