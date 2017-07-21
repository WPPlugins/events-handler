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
					<?php _e( "CUSTOMERS", events); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="section">
		<div class="box">
			<div class="title">
				<?php _e("CUSTOMERS", events); ?>
				<span class="hide">
				</span>
			</div>
			<div class="content">
				<table style="width:100%;" class="table table-striped" id="data-table-customers">
					<thead>
						<tr>
							<th style="width:15%"><?php _e( "First Name", events ); ?></th>
							<th style="width:13%"><?php _e( "Last Name", events ); ?></th>
							<th style="width:18%"><?php _e( "Email Address", events ); ?></th>
							<th style="width:15%"><?php _e( "Mobile", events ); ?></th>
							<th style="width:10%"><?php _e( "City", events ); ?></th>
							<th style="width:15%"><?php _e( "Country", events ); ?></th>
							<th style="width:20%"></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$customers = $wpdb->get_results
							(
								$wpdb->prepare
								(
									"SELECT * FROM ".addcustomersTable()." LEFT OUTER JOIN ".all_country_listTable()." on ".addcustomersTable().".CustomerCountry = ".all_country_listTable().".CountryId","" 
								)
							);
							$payapalEnable= $wpdb->get_var
							(
								$wpdb->prepare
								(
									'SELECT SettingsValue  FROM ' . settingTable() .' where SettingsKey = %s',
									"paypal-enabled"
								)
							);
							for($flag=0; $flag < count($customers); $flag++)
							{
							?>
							<tr>
								<td><?php echo $customers[$flag] -> CustomerFirstName;?></td>
								<td><?php echo $customers[$flag] -> CustomerLastName;?></td>
								<td><?php echo $customers[$flag] -> CustomerEmail;?></td>
								<td><?php echo $customers[$flag] -> CustomerMobile;?></td>
								<td><?php echo $customers[$flag] -> CustomerCity;?></td>
								<td><?php echo $customers[$flag] -> CountryName;?></td>
								<td>
									
									<a class="icon-calendar hovertip inline cboxElement"  data-original-title="<?php _e("Bookings Details?", events ); ?>" data-placement="top" href="admin.php?page=bookingdetails&bid=<?php echo $customers[$flag]->CustomerId;?>" ></a>&nbsp;&nbsp;
									<a class="icon-trash hovertip"  data-toggle="modal" data-original-title="<?php _e("Delete Client", events ); ?>" data-placement="top"   onclick="deleteCustomer(<?php echo $customers[$flag]->CustomerId;?>)"></a>	
								</td>
							</tr>
							<?php
							}
							?>	 
					</tbody>
				</table>
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
	jQuery("#Clients").addClass("current");
	oTable = jQuery('#data-table-customers').dataTable
	({
		"bJQueryUI": false,
		"bAutoWidth": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
		"oLanguage": 
		{
			"sLengthMenu": "_MENU_"
		},
		"aaSorting": [[ 0, "asc" ]],
    	"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 6 ] }]
	});
	function deleteCustomer(CustomerId) 
	{
		bootbox.confirm("<?php _e( "Are you sure you want to delete this Customer?", events ); ?>", function(confirmed)
		{
			console.log("Confirmed: "+confirmed);
			if(confirmed == true)
			{
				jQuery.post(ajaxurl, "CustomerId="+CustomerId+"&param=DeleteCustomer&action=clientLibrary", function(data)
				{
					var countBooking = jQuery.trim(data);
					if(countBooking == "bookingExist")
					{
						bootbox.alert("<?php _e("You cannot delete this Customer until all Bookings are deleted.", events ); ?>");
					}
					else
					{
						var checkPage = "<?php echo $_REQUEST['page']; ?>";
						window.location.href = "admin.php?page="+checkPage;
					}
				});
			}
		});
	}
</script>
