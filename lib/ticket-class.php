<?php
global $wpdb;
if (!current_user_can("edit_posts") && ! current_user_can('edit_pages') )
{
	return;
}
else
{
	if(isset($_REQUEST["param"]))
	{
		if($_REQUEST["param"] == "insertTicket")
		{
			$uxEventId = intval($_REQUEST["uxEventDDL"]);
			$uxTicketName = esc_attr($_REQUEST['uxTicketName']);
			$uxTicketDesc = html_entity_decode($_REQUEST['uxTicketDesc']);
			$uxTicketPrice = intval($_REQUEST['uxTicketPrice']);
			$uxTicketAvail = intval($_REQUEST['uxTicketAvail']);
			$uxTicketReqmin = intval($_REQUEST['uxTicketReqmin']);
			$uxTicketReqmax = intval($_REQUEST['uxTicketReqmax']);
			$wpdb->query
			(
				$wpdb->prepare
				(
						"INSERT INTO ". addTicketTable()."(EventId, TicketName, TicketDesc, TicketPrice, TicketAvail, TicketMinReq, TicketMaxReq)
						VALUES(%d, %s, %s, %d, %d, %d, %d)",
						$uxEventId,
						$uxTicketName,
						$uxTicketDesc,
						$uxTicketPrice,
						$uxTicketAvail,
						$uxTicketReqmin,
						$uxTicketReqmax
						
				)
			);
			die();
		}
		else if($_REQUEST["param"] == "deleteTicket")
			{
			$TicketId=intval($_REQUEST["TicketId"]);
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM ".addTicketTable(). " WHERE TicketId = %d",
						$TicketId
					)
				);
			die();
			}
			
		else if($_REQUEST["param"]== "updateTicket")
		{
			$hiddenTicketId= intval($_REQUEST["ticketid"]);
			$uxEditEventDDL = intval($_REQUEST["uxEditEventDDL"]);
			$uxEditTicketName = esc_attr($_REQUEST["uxeditTicketName"]);
			$uxEditTicketDesc = html_entity_decode($_REQUEST["uxeditTicketDesc"]);
			$uxEditTicketPrice = intval($_REQUEST["uxeditTicketPrice"]);
			$uxEditTicketAvail = intval($_REQUEST["uxeditTicketAvail"]);
			$uxEditTicketReqmin = intval($_REQUEST["uxeditTicketReqmin"]);
			$uxEditTicketReqmax = intval($_REQUEST["uxeditTicketReqmax"]);
			
			
			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE " .addTicketTable(). " SET EventId = %d, TicketName = %s, TicketDesc = '%s' , TicketPrice = %d, TicketAvail = %d, TicketMinreq = %d, TicketMaxReq = %d  WHERE TicketId = %d",
					$uxEditEventDDL,
					$uxEditTicketName,
					$uxEditTicketDesc,
					$uxEditTicketPrice,
					$uxEditTicketAvail,
					$uxEditTicketReqmin,
					$uxEditTicketReqmax,
					$hiddenTicketId
				)
			);
			die();
		}
	}
}
?>
