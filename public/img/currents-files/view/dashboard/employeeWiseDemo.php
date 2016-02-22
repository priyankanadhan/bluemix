<style>
@media screen and (min-width: 240px) and (max-width: 480px) {
	.panel .panel-body {
		width: 650px;
	}
}

@media only screen and (min-width: 480px) and (max-width: 767px) {
	.panel .panel-body {
		width: 650px;
	}
}
</style>
<div class="page-title">

	<div class="title-env">
		<h1 class="title">Employee Wise Demo Summary</h1>

	</div>


</div>



<?php if($_SESSION ['role'] == "1"){?>
<div class="col-md-12" style="padding: 0 3%; margin-bottom: -2%">
<div class="panel panel-default">
<div class="row" style="padding-bottom: 2%">
		<!-- Default panel -->
		
			<div class="col-sm-2">
				<label class="control-label" for="select_region">Date From</label>
			</div>
			<div class="col-sm-3">
				<div class="input-group">
					<input type="text" class="datepicker form-control"
						data-format="dd-mm-yyyy" name="from" id="from" value="" required>
				</div>
			</div>
			<div class="col-sm-2">
				<label class="control-label" for="select_store">Date Till</label>
			</div>
			<div class="col-sm-3">
				<div class="input-group">
					<input type="text" class="datepicker form-control"
						data-format="dd-mm-yyyy" name="to" id="to" value="" required>
				</div>
			</div></div>
			<div class="row">
		<!-- Default panel -->
			<div class="col-sm-2">
				<label class="control-label" for="select_store">Lead Type</label>
			</div>
			<div class="col-md-3">
				<select name="lead_type" id="lead_type" class="form-control">
					<option value="">--Select--</option>
					<option value="hot">Hot</option>
					<option value="cold">Cold</option>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="control-label" for="select_store">Lead Status</label>
			</div>
			<div class="col-md-3">
				<select name="lead_status" id="lead_status" class="form-control">
					<option value="open">Open</option>
					<option value="closed">Closed</option>
					<option value="dead">Dead</option>
				</select>
			</div>
			<div class="col-sm-2">
				<input type="button" value="FILTER" name="submit" id="submit"
					class="btn btn-blue btn-sm" onclick="dateToSelect();">
			</div>
</div></div>

		</div>


	<br> <br>
<div class="panel-body">
	<script type="text/javascript">
	var pathToImageCategories = "<?php echo URL; ?>";
    $(document).ready(function($)
				{
 	//$("#customerListGrid").hide();

 	});
    
     function dateFromSelect(data)
		{
     	var from=jQuery('#from').val();
     	//var RegionId=jQuery('#region').val();
     	//$("#customerListGrid").show();
			$("#customerListGrid").dataTable({
				   "destroy":true,
               "processing": true,
               "serverSide": true,   
               "ajax": "/dashboard/getAllEmployeeDemo?from="+from,
               ///"ajax": "/students/index?schoolId=" +schoolId,
                 "aLengthMenu": [
					[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                 ],
                "columns":[
											{"data":"store_name"},
											{"data":"employee_name"},
                                            {"data":"mac_product"},
                                            {"data":"mac_demo"},											
											{"data":"ipad_product"},
											{"data":"ipad_demo"},		
											{"data":"iphone_product"},	
											{"data":"iphone_demo"},	
											{"data":"ipod_product"},	
											{"data":"ipod_demo"}
								
                           ]
			
			});
					
	}
		</script>



<div class="panel-body">
<script type="text/javascript">
     var pathToImageCategories = "<?php echo URL; ?>";
    $(document).ready(function($)
				{
 	//$("#customerListGrid").hide();

 	});
		
     function dateToSelect()
		{
     	var from=jQuery('#from').val();
     	var to=jQuery('#to').val();
     	var lead_type=jQuery('#lead_type').val();
     	var lead_status=jQuery('#lead_status').val();
     	//$("#customerListGrid").show();
			$("#customerListGrid").dataTable({
				   "destroy":true,
               "processing": true,
               "serverSide": true,                              
               "ajax": "/dashboard/getAllEmployeeDemo?from="+from+"&to="+to+"&lead_type="+lead_type+"&lead_status="+lead_status,
               ///"ajax": "/students/index?schoolId=" +schoolId,
                 "aLengthMenu": [
					[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                 ],
                "columns":[
							{"data":"store_name"},
											{"data":"employee_name"},
                                            {"data":"mac_product"},
                                            {"data":"mac_demo"},											
											{"data":"ipad_product"},
											{"data":"ipad_demo"},		
											{"data":"iphone_product"},	
											{"data":"iphone_demo"},	
											{"data":"ipod_product"},	
											{"data":"ipod_demo"}
                           ]
			
			});
					
	}
		</script>

			<div class="row">

				<div class="col-md-12">

					<!-- Basic Setup -->
					<div class="panel panel-default">

						<div class="panel-body">

							<script type="text/javascript">
                    
					jQuery(document).ready(function($)
					{
						$("#customerListGrid").dataTable({
                              "processing": true,
                              "serverSide": true,                              
                              "ajax": "/dashboard/getAllEmployeeDemo",
                                "aLengthMenu": [
								[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                                ],
                               "columns": [
											{"data":"store_name"},
											{"data":"employee_name"},
                                            {"data":"mac_product"},
                                            {"data":"mac_demo"},											
											{"data":"ipad_product"},
											{"data":"ipad_demo"},		
											{"data":"iphone_product"},	
											{"data":"iphone_demo"},	
											{"data":"ipod_product"},	
											{"data":"ipod_demo"}											
											
                                          ]
						});
					});
					</script>

							<table id="customerListGrid"
								class="table table-striped table-bordered" cellspacing="0"
								width="100%">
								<thead>
										<tr>
											<th>Store</th>
											<th>Employee Name</th>
											<th>Mac Lead</th>
											<th>Mac Demo</th>
											<th>iPad Lead</th>
											<th>iPad Demo</th>
											<th>iPhone Lead</th>
											<th>iPhone Demo</th>
											<th>iPod Lead</th>
											<th>iPod Demo</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Store</th>
											<th>Employee Name</th>
											<th>Mac Lead</th>
											<th>Mac Demo</th>
											<th>iPad Lead</th>
											<th>iPad Demo</th>
											<th>iPhone Lead</th>
											<th>iPhone Demo</th>
											<th>iPod Lead</th>
											<th>iPod Demo</th>
										</tr>
									</tfoot>
								

								<tbody>

								</tbody>
							</table>

						</div>
					</div>

				</div>

			</div>

<?php }elseif($_SESSION ['role'] == "4"){?>
<div class="col-md-12" style="padding: 0 3%; margin-bottom: -2%">
<div class="panel panel-default">
<div class="row" style="padding-bottom: 2%">
		<!-- Default panel -->
		
			<div class="col-sm-2">
				<label class="control-label" for="select_region">Date From</label>
			</div>
			<div class="col-sm-3">
				<div class="input-group">
					<input type="text" class="datepicker form-control"
						data-format="dd-mm-yyyy" name="from" id="from" value="" required>
				</div>
			</div>
			<div class="col-sm-2">
				<label class="control-label" for="select_store">Date Till</label>
			</div>
			<div class="col-sm-3">
				<div class="input-group">
					<input type="text" class="datepicker form-control"
						data-format="dd-mm-yyyy" name="to" id="to" value="" required>
				</div>
			</div></div>
			<div class="row">
		<!-- Default panel -->
			<div class="col-sm-2">
				<label class="control-label" for="select_store">Lead Type</label>
			</div>
			<div class="col-md-3">
				<select name="lead_type" id="lead_type" class="form-control">
					<option value="">--Select--</option>
					<option value="hot">Hot</option>
					<option value="cold">Cold</option>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="control-label" for="select_store">Lead Status</label>
			</div>
			<div class="col-md-3">
				<select name="lead_status" id="lead_status" class="form-control">
					<option value="open">Open</option>
					<option value="closed">Closed</option>
					<option value="dead">Dead</option>
				</select>
			</div>
			<div class="col-sm-2">
				<input type="button" value="FILTER" name="submit" id="submit"
					class="btn btn-blue btn-sm" onclick="dateToSelect();">
			</div>
</div></div>

		</div>


	<br> <br>
<div class="panel-body">
	<script type="text/javascript">
	var pathToImageCategories = "<?php echo URL; ?>";
    $(document).ready(function($)
				{
 	//$("#customerListGrid").hide();

 	});
    
     function dateFromSelect(data)
		{
     	var from=jQuery('#from').val();
     	//var RegionId=jQuery('#region').val();
     	//$("#customerListGrid").show();
			$("#customerListGrid").dataTable({
				   "destroy":true,
               "processing": true,
               "serverSide": true,   
               "ajax": "/dashboard/getAllEmployeeDemo?from="+from,
               ///"ajax": "/students/index?schoolId=" +schoolId,
                 "aLengthMenu": [
					[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                 ],
                "columns":[
											{"data":"store_name"},
											{"data":"employee_name"},
                                            {"data":"mac_product"},
                                            {"data":"mac_demo"},											
											{"data":"ipad_product"},
											{"data":"ipad_demo"},		
											{"data":"iphone_product"},	
											{"data":"iphone_demo"},	
											{"data":"ipod_product"},	
											{"data":"ipod_demo"}
								
                           ]
			
			});
					
	}
		</script>



<div class="panel-body">
<script type="text/javascript">
     var pathToImageCategories = "<?php echo URL; ?>";
    $(document).ready(function($)
				{
 	//$("#customerListGrid").hide();

 	});
		
     function dateToSelect()
		{
     	var from=jQuery('#from').val();
     	var to=jQuery('#to').val();
     	var lead_type=jQuery('#lead_type').val();
     	var lead_status=jQuery('#lead_status').val();
     	//$("#customerListGrid").show();
			$("#customerListGrid").dataTable({
				   "destroy":true,
               "processing": true,
               "serverSide": true,                              
               "ajax": "/dashboard/getAllEmployeeDemo?from="+from+"&to="+to+"&lead_type="+lead_type+"&lead_status="+lead_status,
               ///"ajax": "/students/index?schoolId=" +schoolId,
                 "aLengthMenu": [
					[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                 ],
                "columns":[
							{"data":"store_name"},
											{"data":"employee_name"},
                                            {"data":"mac_product"},
                                            {"data":"mac_demo"},											
											{"data":"ipad_product"},
											{"data":"ipad_demo"},		
											{"data":"iphone_product"},	
											{"data":"iphone_demo"},	
											{"data":"ipod_product"},	
											{"data":"ipod_demo"}
                           ]
			
			});
					
	}
		</script>

			<div class="row">

				<div class="col-md-12">

					<!-- Basic Setup -->
					<div class="panel panel-default">

						<div class="panel-body">

							<script type="text/javascript">
                    
					jQuery(document).ready(function($)
					{
						$("#customerListGrid").dataTable({
                              "processing": true,
                              "serverSide": true,                              
                              "ajax": "/dashboard/getAllEmployeeDemo",
                                "aLengthMenu": [
								[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                                ],
                               "columns": [
											{"data":"store_name"},
											{"data":"employee_name"},
                                            {"data":"mac_product"},
                                            {"data":"mac_demo"},											
											{"data":"ipad_product"},
											{"data":"ipad_demo"},		
											{"data":"iphone_product"},	
											{"data":"iphone_demo"},	
											{"data":"ipod_product"},	
											{"data":"ipod_demo"}											
											
                                          ]
						});
					});
					</script>

							<table id="customerListGrid"
								class="table table-striped table-bordered" cellspacing="0"
								width="100%">
								<thead>
										<tr>
											<th>Store</th>
											<th>Employee Name</th>
											<th>Mac Lead</th>
											<th>Mac Demo</th>
											<th>iPad Lead</th>
											<th>iPad Demo</th>
											<th>iPhone Lead</th>
											<th>iPhone Demo</th>
											<th>iPod Lead</th>
											<th>iPod Demo</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Store</th>
											<th>Employee Name</th>
											<th>Mac Lead</th>
											<th>Mac Demo</th>
											<th>iPad Lead</th>
											<th>iPad Demo</th>
											<th>iPhone Lead</th>
											<th>iPhone Demo</th>
											<th>iPod Lead</th>
											<th>iPod Demo</th>
										</tr>
									</tfoot>
								

								<tbody>

								</tbody>
							</table>

						</div>
					</div>

				</div>

			</div>


<?php }elseif($_SESSION ['role'] == "2"){?>

<div class="col-md-12" style="padding: 0 3%; margin-bottom: -2%">
<div class="panel panel-default">
<div class="row" style="padding-bottom: 2%">
		<!-- Default panel -->
		
			<div class="col-sm-2">
				<label class="control-label" for="select_region">Date From</label>
			</div>
			<div class="col-sm-3">
				<div class="input-group">
					<input type="text" class="datepicker form-control"
						data-format="dd-mm-yyyy" name="from" id="from" value="" required>
				</div>
			</div>
			<div class="col-sm-2">
				<label class="control-label" for="select_store">Date Till</label>
			</div>
			<div class="col-sm-3">
				<div class="input-group">
					<input type="text" class="datepicker form-control"
						data-format="dd-mm-yyyy" name="to" id="to" value="" required>
				</div>
			</div></div>
			<div class="row">
		<!-- Default panel -->
			<div class="col-sm-2">
				<label class="control-label" for="select_store">Lead Type</label>
			</div>
			<div class="col-md-3">
				<select name="lead_type" id="lead_type" class="form-control">
					<option value="">--Select--</option>
					<option value="hot">Hot</option>
					<option value="cold">Cold</option>
				</select>
			</div>
			<div class="col-sm-2">
				<label class="control-label" for="select_store">Lead Status</label>
			</div>
			<div class="col-md-3">
				<select name="lead_status" id="lead_status" class="form-control">
					<option value="open">Open</option>
					<option value="closed">Closed</option>
					<option value="dead">Dead</option>
				</select>
			</div>
			<div class="col-sm-2">
				<input type="button" value="FILTER" name="submit" id="submit"
					class="btn btn-blue btn-sm" onclick="dateToSelect();">
			</div>
</div></div>

		</div>


	<br> <br>
<div class="panel-body">
	<script type="text/javascript">
	var pathToImageCategories = "<?php echo URL; ?>";
    $(document).ready(function($)
				{
 	//$("#customerListGrid").hide();

 	});
    
     function dateFromSelect(data)
		{
     	var from=jQuery('#from').val();
     	//var RegionId=jQuery('#region').val();
     	//$("#customerListGrid").show();
			$("#customerListGrid").dataTable({
				   "destroy":true,
               "processing": true,
               "serverSide": true,   
               "ajax": "/dashboard/getAllEmployeeDemo?from="+from,
               ///"ajax": "/students/index?schoolId=" +schoolId,
                 "aLengthMenu": [
					[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                 ],
                "columns":[
											{"data":"store_name"},
											{"data":"employee_name"},
                                            {"data":"mac_product"},
                                            {"data":"mac_demo"},											
											{"data":"ipad_product"},
											{"data":"ipad_demo"},		
											{"data":"iphone_product"},	
											{"data":"iphone_demo"},	
											{"data":"ipod_product"},	
											{"data":"ipod_demo"}
								
                           ]
			
			});
					
	}
		</script>



<div class="panel-body">
<script type="text/javascript">
     var pathToImageCategories = "<?php echo URL; ?>";
    $(document).ready(function($)
				{
 	//$("#customerListGrid").hide();

 	});
		
     function dateToSelect()
		{
     	var from=jQuery('#from').val();
     	var to=jQuery('#to').val();
     	var lead_type=jQuery('#lead_type').val();
     	var lead_status=jQuery('#lead_status').val();
     	//$("#customerListGrid").show();
			$("#customerListGrid").dataTable({
				   "destroy":true,
               "processing": true,
               "serverSide": true,                              
               "ajax": "/dashboard/getAllEmployeeDemo?from="+from+"&to="+to+"&lead_type="+lead_type+"&lead_status="+lead_status,
               ///"ajax": "/students/index?schoolId=" +schoolId,
                 "aLengthMenu": [
					[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                 ],
                "columns":[
							{"data":"store_name"},
											{"data":"employee_name"},
                                            {"data":"mac_product"},
                                            {"data":"mac_demo"},											
											{"data":"ipad_product"},
											{"data":"ipad_demo"},		
											{"data":"iphone_product"},	
											{"data":"iphone_demo"},	
											{"data":"ipod_product"},	
											{"data":"ipod_demo"}
                           ]
			
			});
					
	}
		</script>

			<div class="row">

				<div class="col-md-12">

					<!-- Basic Setup -->
					<div class="panel panel-default">

						<div class="panel-body">

							<script type="text/javascript">
                    
					jQuery(document).ready(function($)
					{
						$("#customerListGrid").dataTable({
                              "processing": true,
                              "serverSide": true,                              
                              "ajax": "/dashboard/getAllEmployeeDemo",
                                "aLengthMenu": [
								[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                                ],
                               "columns": [
											{"data":"store_name"},
											{"data":"employee_name"},
                                            {"data":"mac_product"},
                                            {"data":"mac_demo"},											
											{"data":"ipad_product"},
											{"data":"ipad_demo"},		
											{"data":"iphone_product"},	
											{"data":"iphone_demo"},	
											{"data":"ipod_product"},	
											{"data":"ipod_demo"}											
											
                                          ]
						});
					});
					</script>

							<table id="customerListGrid"
								class="table table-striped table-bordered" cellspacing="0"
								width="100%">
								<thead>
										<tr>
											<th>Store</th>
											<th>Employee Name</th>
											<th>Mac Lead</th>
											<th>Mac Demo</th>
											<th>iPad Lead</th>
											<th>iPad Demo</th>
											<th>iPhone Lead</th>
											<th>iPhone Demo</th>
											<th>iPod Lead</th>
											<th>iPod Demo</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Store</th>
											<th>Employee Name</th>
											<th>Mac Lead</th>
											<th>Mac Demo</th>
											<th>iPad Lead</th>
											<th>iPad Demo</th>
											<th>iPhone Lead</th>
											<th>iPhone Demo</th>
											<th>iPod Lead</th>
											<th>iPod Demo</th>
										</tr>
									</tfoot>
								

								<tbody>

								</tbody>
							</table>

						</div>
					</div>

				</div>

			</div>
<?php }?>


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
											<li><b>Name:</b> <span class="pull-right ajax-content-name">Loading...</span>
											</li>
										</ul>
									</div>

									<div class="col-md-4">
										<ul class="list-unstyled line-height-default">
											<li><b>Case Type:</b> <span
												class="pull-right ajax-content-casetype">Loading...</span></li>
										</ul>

									</div>
									<div class="col-md-4">
										<ul class="list-unstyled line-height-default">
											<li><b>Strap Type:</b> <span
												class="pull-right ajax-content-straptype">Loading...</span></li>
										</ul>

									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<ul class="list-unstyled line-height-default">
											<li><b>Dial:</b> <span class="pull-right ajax-content-dial">Loading...</span>
											</li>
										</ul>
									</div>

									<div class="col-md-4">
										<ul class="list-unstyled line-height-default">
											<li><b>Movement:</b> <span
												class="pull-right ajax-content-movement">Loading...</span></li>
										</ul>

									</div>
									<div class="col-md-4">
										<ul class="list-unstyled line-height-default">
											<li><b>Crown:</b> <span class="pull-right ajax-content-crown">Loading...</span>
											</li>
										</ul>

									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<ul class="list-unstyled line-height-default">
											<li><b>Hands:</b> <span class="pull-right ajax-content-hands">Loading...</span>
											</li>
										</ul>
									</div>

									<div class="col-md-4">
										<ul class="list-unstyled line-height-default">
											<li><b>Others</b>: <span
												class="pull-right ajax-content-others">Loading...</span></li>
										</ul>

									</div>
									<div class="col-md-4">
										<ul class="list-unstyled line-height-default">
											<li><b>Category:</b> <span
												class="pull-right ajax-content-productname">Loading...</span></li>
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