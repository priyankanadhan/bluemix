<div class="page-title">

	<div class="title-env">
		<h1 class="title">Event List</h1>
		<p class="description">Event Management page.</p>

	</div>

	<div class="breadcrumb-env">

		<ol class="breadcrumb bc-1">
			<li><a href="#"><i class="fa-home"></i>Events</a></li>

		</ol>
		<a href="/events/add" class="btn btn-blue btn-lg">Add</a>

	</div>

</div>

<div class="row">

	<div class="col-md-12">

		<!-- Basic Setup -->
		<div class="panel panel-default">

			<div class="panel-body">

				<script type="text/javascript">
                    
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
							<li><b>Region:</b> <span
								class="pull-right ajax-content-admin_no">Loading...</span></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<ul class="list-unstyled line-height-default">
							<li><b>Descrition:</b> <span class="pull-right ajax-content-house">Loading...</span>
							</li>
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
				</div>

			</div>

			<div class="modal-footer">
				<!--button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-info">Save changes</button-->
			</div>
		</div>
	</div>
</div>