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
				<a href="admin.php?page=tickets">
					<?php _e( "API KEY", events); ?>
				</a>
		</ul>
	</div>
	<div class="section">
		<div class="box">
			<div class="title"><span>API KEY</span>
			</div>
			<div id="content">
				<form id="uxFrmApikey" class="events-container-form" method="post" action="">
					<div class="message green" id="successMessageAPI" style="margin-left:10px;">
						<span>
							<strong>
								<?php _e( "<p>We Respect your Privacy. Your information is highly confidential to us and we don't sell it to third parties.</p><p> We need you to register your API Key with your Email Address & Name in order to make this plugin work smoothly.</p><p>Once you register your API, the plugin would work as expected.</p>", events ); ?>
							</strong>
						</span>
					</div>
					<div class="body" id="api_key">
						<div class="row">
							<label >
								<?php _e("Your Email :" ,events)?>
							</label>
							<div class="right">
								<input type="text" name="uxApiEmail" id="uxApiEmail">
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e("Your Name :" ,events)?>
							</label>
							<div class="right">
								<input type="text" name="uxApiName" id="uxApiName">
							</div>
						</div>
						
						<div class="row">
							<label>
								<?php _e("Api Key :" ,events)?>
							</label>
							<div class="right">
								<input type="text" readonly="readonly" "uxApiKey" id="uxApiKey" value="<?php
								function NewGuid() 
								{ 
									$s = strtoupper(md5(uniqid(rand(),true))); 
									$guidText = 
									substr($s,0,8) . '-' . 
									substr($s,8,4) . '-' . 
									substr($s,12,4). '-' . 
									substr($s,16,4). '-' . 
									substr($s,20); 
									return $guidText;
								}
								echo NewGuid();
								$key = NewGuid();
							?>">
							</div>
						</div>
						<div class="row">
							<label>
								<?php _e("" ,events)?>
							</label>
							<div class="right">
								<input type="checkbox" name="uxApiCheck" id="uxApiCheck" checked="checked">
								<span><?php _e("Yes, I may Purchase Pro Version Later." ,events); ?></span>
							</div>
						</div>
						<div class="row" style="border-bottom:none !important">
							<label>
							</label>
							<div class="right">
								<button type="submit" class="events-container-button green">
									<span>
										<?php _e( "Register your API Key to start using Events Handler", events ); ?>
									</span>
								</button>
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
<script type="text/javascript">
	
	jQuery("#APIkey").addClass("current");
	var pass_string = "http://eventshandler.com/wp-content/plugins/wp-events-handler-users/user_data.php";
	jQuery("#uxFrmApikey").validate
	({
		rules:
		{
			uxApiEmail:
			{
				required: true,
				email: true
			},
			uxApiName:
			{
				required: true,
			},
			uxApiKey: 
			{
				required: true,
			}
		},
		submitHandler: function(form)
		{
			
			var uxApiEmail = encodeURIComponent(jQuery("#uxApiEmail").val());
			var uxApiName = encodeURIComponent(jQuery("#uxApiName").val());
			var uxApiKey = encodeURIComponent(jQuery("#uxApiKey").val());
			var uxApiCheck = jQuery("#uxApiCheck").prop("checked");
			var site_url = "<?php echo site_url();?>";
			var culture = "<?php echo get_locale();?>"; 
			var st_url = encodeURIComponent(site_url);
			var cult = encodeURIComponent(culture);
			if(uxApiCheck == true)
			{
				var ux_chk_value = "1";
			}
			else
			{
				var ux_chk_value = "0";
			}
			
			if(uxApiEmail != "" || uxApiEmail != null )
			{
				jQuery.post(pass_string,  +"?"+"check=1&uxApiName="+uxApiName+"&uxApiKey="+uxApiKey+"&ux_chk_value="+ux_chk_value+"&st_url="+st_url+"&cult="+cult+"&uxEmail="+uxApiEmail, function(data)
				{
					jQuery.post(ajaxurl,  "uxApiKey="+uxApiKey+"&param=updateApi&action=apikeyLibrary", function(data)
					{
						window.location.href = "admin.php?page=eventshandler";
					});
					
					
				});
			}
		}
	});
</script>