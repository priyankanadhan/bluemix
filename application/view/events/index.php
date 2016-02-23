<div class="page-title">

	<div class="title-env">
		<h1 class="title">Event List</h1>
		<p class="description">Event Management page.</p>

	</div>

	<div class="breadcrumb-env">

		<ol class="breadcrumb bc-1">
			<li><a href="#"><i class="fa-home"></i>Events</a></li>

		</ol>
		<a href="/events/add" class="btn btn-blue btn-lg">Add Event</a>

	</div>

</div>
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="row" style="padding-bottom: 2%">
			<!-- Default panel -->
			<div class="col-sm-2">
				<label class="control-label">What?</label>
			</div>
			<div class="col-sm-3">

				<select class="form-control" data-validate="required"
					name="category" id="category">
					<option value="" selected>Select the Category</option>
                                        <?php foreach($categories as $category){?>
                                            <option
						value="<?php echo $category['id'];?>"><?php echo $category['category'];?></option>
                                        <?php }?>
									</select>

			</div>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="subject" id="subject"
					value="" data-validate="required"
					data-message-required="Subject is required."
					placeholder="Enter the Subject Name" />
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<label class="control-label">When?</label>
			</div>
			<div class="col-sm-3">
				<select class="form-control" data-validate="required"
					name="season_id" id="season_id">
					<option value="" selected>Select the Season</option>
                                        <?php foreach($seasons as $season){?>
                                            <option
						value="<?php echo $season['id'];?>"><?php echo $season['season_name'];?></option>
                                        <?php }?>
									</select>

			</div>
			<div class="col-sm-3">
				<select class="form-control" data-validate="required" name="month"
					id="month">
					<option value="" selected>Select the Month</option>
                                        <?php foreach($months as $month){?>
                                            <option
						value="<?php echo $month['id'];?>"><?php echo $month['month'];?></option>
                                        <?php }?>
									</select>

			</div>
		</div>
		</br>
		<div class="row">
			<!-- Default panel -->
			<div class="col-sm-2">
				<label class="control-label">Where?</label>
			</div>
			<div class="col-sm-3">
				<select class="form-control" data-validate="required"
					name="state_id" id="state_id">
					<option value="" selected>Select the State</option>
                                        <?php foreach($states as $state){?>
                                            <option
						value="<?php echo $state['id'];?>"><?php echo $state['state_name'];?></option>
                                        <?php }?>
									</select>

			</div>
			<div class="col-sm-3">
				<select class="form-control" data-validate="required"
					name="region_id" id="region_id">
					<option value="" selected>Select the Region</option>
                                        <?php foreach($resions as $resion){?>
                                            <option
						value="<?php echo $resion['id'];?>"><?php echo $resion['region_name'];?></option>
                                        <?php }?>
									</select>

			</div>
			<div class="col-sm-2">
				<input type="button" value="FILTER" name="submit" id="submit"
					class="btn btn-blue btn-sm" onclick="eventSelect();">
			</div>
		</div>
	</div>

</div>
<div class="row">

	<div class="col-md-12">

		<!-- Basic Setup -->
		<div class="panel panel-default">

			<div class="panel-body">

				<script type="text/javascript">
				 function eventSelect()
					{
			     	var category=jQuery('#category').val();
			     	var subject=jQuery('#subject').val();
			     	var season=jQuery('#season_id').val();
			     	var month=jQuery('#month').val();
			     	var state=jQuery('#state_id').val();
			     	var region=jQuery('#region_id').val();
			     	//$("#customerListGrid").show();
						$("#catalogsListGrid").dataTable({
							   "destroy":true,
			               "processing": true,
			               "serverSide": true,                              
			               "ajax": "/events/getAllEvents?category="+category+"&subject="+subject+"&season="+season+"&month="+month+"&state="+state+"&region="+region,
			               ///"ajax": "/students/index?schoolId=" +schoolId,
			                 "aLengthMenu": [
								[20, 25, 50, 100, -1], [20, 25, 50, 100, "All"]
			                 ],
			                 "columns": [
                                      {"data":"subject"},
											{"data":"category"},
											{"data":"region_name"},
                                      {"data":"login"},                                            
                                      {
                                          "targets": 0,
                                          "data": "id",
                                          "render": function ( data, type, full, meta ) {
                                          	var str = '<span class="action-links"><a href="#" onclick="showAjaxModal('+data+');"><i class="linecons-eye"></i></a>&nbsp;&nbsp;';
                                                            str +='<a href="/events/edit?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
                                                       return str;
                                                      }
                                      } 
                                    ]
						
						});
								
				}				
					jQuery(document).ready(function($)
					{
						$("#catalogsListGrid").dataTable({
                              "processing": true,
                              "serverSide": true,                              
                              "ajax": "/events/getAllEvents",
                                "aLengthMenu": [
								[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                                ],
                               "columns": [
                                            {"data":"subject"},
											{"data":"category"},
											{"data":"region_name"},
                                            {"data":"login"},                                            
                                            {
                                                "targets": 0,
                                                "data": "id",
                                                "render": function ( data, type, full, meta ) {
                                                	var str = '<span class="action-links"><a href="#" onclick="showAjaxModal('+data+');"><i class="linecons-eye"></i></a>&nbsp;&nbsp;';
                                                                  str +='<a href="/events/edit?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
                                                             return str;
                                                            }
                                            } 
                                          ]
						});
					});
					</script>

				<table id="catalogsListGrid"
					class="table table-striped table-bordered" cellspacing="0"
					width="100%">
					<thead>
						<tr>
							<th>Subject</th>
							<th>Category</th>
							<th>Location</th>
							<th>Event Posted By</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tfoot>
						<th>Subject</th>
						<th>Category</th>
						<th>Location</th>
						<th>Event Posted By</th>
						<th>Actions</th>
					</tfoot>

					<tbody>

					</tbody>
				</table>

			</div>
		</div>

	</div>

</div>
<script type="text/javascript">
			function showAjaxModal(refKey)
			{
				jQuery('#modal-7').modal('show', {backdrop: 'static'});
				
				setTimeout(function()
				{
					jQuery.ajax({
						url: "/events/getEventById?refKey="+refKey,
                        dataType: "json",
						success: function(response,address,studentMapping,year)
						{
							jQuery('#modal-7 .modal-title').html("Event");
            				jQuery('#modal-7 .ajax-content-fathersname').html(response.category);
            				jQuery('#modal-7 .ajax-content-mothersname').html(response.subject);
           			        jQuery('#modal-7 .ajax-content-bloodgroup').html(response.season_name);
            			  	jQuery('#modal-7 .ajax-content-gender').html(response.month);
            				jQuery('#modal-7 .ajax-content-date_of_birth').html(response.state_name);
            				jQuery('#modal-7 .ajax-content-admin_no').html(response.region_name);
            				jQuery('#modal-7 .ajax-content-house').html(response.description);   				
						    jQuery('#modal-7 .ajax-content-address1').html(response.address);
							jQuery('#modal-7 .ajax-content-contact1').html(response.comments);
							jQuery('#modal-7 .ajax-content-contact2').html(response.from_date);
							jQuery('#modal-7 .ajax-content-contact3').html(response.to_date);
                            
						},
                        
					});
				}, 800); // just an example
			}
			</script>
<!-- Modal 7 (Ajax Modal)-->
<div class="modal fade" id="modal-7">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title">Loading...</h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-4" style="text-align: center;">
						<span class="product-content-image"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>Category:</b> <span
								class="pull-right ajax-content-fathersname">Loading...</span></li>
						</ul>
					</div>

					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>Subject:</b> <span
								class="pull-right ajax-content-mothersname">Loading...</span></li>
						</ul>

					</div>
					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>Season Name:</b> <span
								class="pull-right ajax-content-bloodgroup">Loading...</span></li>
						</ul>

					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>Month:</b> <span class="pull-right ajax-content-gender">Loading...</span>
							</li>
						</ul>
					</div>

					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>State:</b> <span
								class="pull-right ajax-content-date_of_birth">Loading...</span>
							</li>
						</ul>

					</div>
					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>Region:</b> <span class="pull-right ajax-content-admin_no">Loading...</span></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>Descrition:</b> <span
								class="pull-right ajax-content-house">Loading...</span></li>
						</ul>

					</div>
					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>Address:</b> <span
								class="pull-right ajax-content-address1">Loading...</span></li>
						</ul>


					</div>
				</div>
				<div class="row">

					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>Comments:</b> <span
								class="pull-right ajax-content-contact1">Loading...</span></li>
						</ul>


					</div>
					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>From Date:</b> <span
								class="pull-right ajax-content-contact2">Loading...</span></li>
						</ul>

					</div>
					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>To Date:</b> <span
								class="pull-right ajax-content-contact3">Loading...</span></li>
						</ul>

					</div>
					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><u><a href="#">Check Whether</a></u><span
								class=""></span></li>
						</ul>

					</div>
				</div>

			</div>

			<div class="modal-footer">
				<!--button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-info">Save changes</button-->
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
				jQuery(document).ready(function($)
				{
					var z = 0;
					var fileArray = new Array();
					var selected = [];
					var value='';
		   	$('.fileTable tr.tableRow').each(function () {
		        var tabledata = new Object;

		        tabledata.id = $(this).find('td:eq(0)').text();
				
			   
		        if ($(this).find("[id^=check]").is(':checked')) {
		        	tabledata.checkbox = '1';
		        	} else {
		        	tabledata.checkbox = '0';
		        	}
		        
		        tabledata.name= $(this).find('td:eq(3)').text();               

		        fileArray[z] = tabledata.id;
		        z++;
		    });
			    var productId = $("#product_category_id").val();
				  $("#state_id").change(function(){
					  var str='';
					  str +='<option value="" selected>Select the Region</option>';
	                  var selectedId = $("#state_id").val();
                  
                  $.ajax({
                  	type: "POST",
                    dataType: "json",
                    url: "/events/getAllRegionByStateId", //Relative or absolute path to response.php file
                    data: {"refKey":selectedId},
                    success: function(data) {                                                       
                      $.each(data,function(key,obj){                                                           
                      str +='<option value="'+obj.id+'">'+obj.region_name+'</option>';                                                        
                    });
                    $("#region_id").html(str);
                     }
                    }); 
                 });
				 
				 $("#season_id").change(function(){
                  var str = '';
				  str +='<option value="" selected>Select the Month</option>';
                  var selectedId = $("#season_id").val();
                  $.ajax({
                  	type: "POST",
                    dataType: "json",
                    url: "/events/getAllMonthsBySeasonId", //Relative or absolute path to response.php file
                    data: {"refKey":selectedId},
                    success: function(data) {                                                       
                      $.each(data,function(key,obj){                                                           
                      str +='<option value="'+obj.id+'">'+obj.month+'</option>';                                                        
                    });
                    $("#month").html(str);
                     }
                    }); 
                 });
				 
				 											
			});	

								
			</script>



