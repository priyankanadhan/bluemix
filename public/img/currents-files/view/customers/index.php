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
		<h1 class="title">Customer List</h1>
		<p class="description">Customer Management page.</p>

	</div>

	<div class="breadcrumb-env">


		<a href="/customers/add" class="btn btn-blue btn-lg">Add Customer</a>

	</div>

</div>



<?php if($_SESSION ['role'] == "1"){?>



<div class="row">
	<div class="col-md-12" style="padding: 0 4%;margin-bottom:-2%;">

		<!-- Default panel -->
		<div class="panel panel-default">
			<div class="col-sm-1">
				<label class="control-label" for="select_region">Select</label>
			</div>
			<div class="col-md-3">
				<select name="region" id="region" onchange="regionSelect()"
					class="form-control">
					<option value="">--Region--</option>
								<?php
	foreach ( $regions as $region ) {
		?>
									<option value="<?php echo $region['store_region_id'];?>">
									<?php echo $region['store_region_name'];?><?php } ?></option>
				</select>
			</div>
			<div class="col-sm-1">
				<label class="control-label" for="select_store">Select</label>
			</div>
			<div class="col-md-3">

				<select name="store" id="store" onchange="storeSelect()"
					class="form-control">
					<option value="">--Store--</option>
				</select>

			</div>
			<div class="col-sm-1">
				<label class="control-label" for="select_employee">Select</label>
			</div>
			<div class="col-md-3">
				<select name="employee" id="employee" onchange="employeeSelect()"
					class="form-control">
					<option value="">--Employee--</option>
				</select>

			</div>
		</div>

	</div>
	<br> <br>


	<div class="panel-body">
		<script type="text/javascript">
                    var pathToImageCategories = "<?php echo URL; ?>";
                   $(document).ready(function($)
        					{
                	//$("#customerListGrid").hide();

                	});
                   function regionSelect(){
                	   var RegionId=jQuery('#region').val();
                	   regionRefSelect(RegionId);
                	   regionStoreSelect(RegionId);
                		
                   }
                   function regionStoreSelect(data){
                      // alert(data);
                      var output='';
                      var employeeOt='';
                      var employeeOut='';
           		jQuery.ajax({
           		type : "POST",
           		url :"<?php echo URL; ?>/customers/getStoreByRegionId/?region_id=" +data,
           		data: data,
           		//dataype:"json",
           		success:function(response){
           			var JSONObject = JSON.parse(response);
           			//alert(JSONObject.length);
           			employeeOut +='<option value="">--Employee--</option>';
           			employeeOt +='<option value="">--Store--</option>';
           			for(i=0;i<=JSONObject.length;i++){
           			output +='<option value="'+JSONObject[i]['store_id']+'">'+JSONObject[i]['store_name']+'</option>';
					oriOt=employeeOt+output;
           			//alert(JSONObject[0]['class']);
           		  jQuery('#store').html(oriOt); 
           		jQuery('#employee').html(employeeOut); 
           			}
           		}
           		});
           		}
                    function regionRefSelect(data)
					{
                    	var emploeeId=jQuery('#employee').val();
                    	//var RegionId=jQuery('#region').val();
                    	//$("#customerListGrid").show();
						$("#customerListGrid").dataTable({
							   "destroy":true,
                              "processing": true,
                              "serverSide": true,   
                              "ajax": "/customers/getAllCustomerLeads/?region_id="+data,
                              ///"ajax": "/students/index?schoolId=" +schoolId,
                                "aLengthMenu": [
								[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                                ],
                               "columns":[
											{"data":"employee_name"},
											{"data":"employees_id"},
							   				{"data":"last_updated_date"},
                                            {"data":"firstname"},											
											{"data":"phone"},	
											{"data":"product_category_name"},										
											{"data":"next_followup"},
											{"data":"store_region_name"},
											{"data":"store_name"},
											{"data":"lead_status"},
                                            {
                                                "targets": 0,
                                                "data": "customer_id",
                                                "render": function ( data, type, full, meta ) {
                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
                                                             return str;
                                                            }
                                            },
											
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
               		function storeSelect(){
               		 var StoreId=jQuery('#store').val();
               			storeRefSelect(StoreId);
               			employeeValueSelect(StoreId);
                   	}
                   	function employeeValueSelect(data){
                   		var output='';
                   		var employeeOt='';
                   		jQuery.ajax({
                   		type : "POST",
                   		url :"<?php echo URL; ?>/customers/getEmployeesByStoreId/?store_id=" +data,
                   		data: data,
                   		//dataype:"json",
                   		success:function(response){
                   			var JSONObject = JSON.parse(response);
                   			//alert(JSONObject.length);
                   			employeeOt +='<option value="">--Employee--</option>';
                   			for(i=0;i<=JSONObject.length;i++){
                   			output +='<option value="'+JSONObject[i]['employee_id']+'">'+JSONObject[i]['employee_name']+'</option>';
                   			oriOt=employeeOt+output;
                   			//alert(JSONObject[0]['class']);
                   		   jQuery('#employee').html(oriOt); 
                   			}
                   		//window.setTimeout(function(){location.reload()},1000)
                   		//document.location.reload(true);
                   		}
                   		//jQuery('#importmsg').html("cannot "); 
                   		});
                       	}
                    function storeRefSelect(data)
					{
    					var regionId=jQuery('#region').val();
                    	//$("#customerListGrid").show();
						$("#customerListGrid").dataTable({
							   "destroy":true,
                              "processing": true,
                              "serverSide": true,                              
                              "ajax": "/customers/getAllCustomerLeads/?store_id="+data+"&region_id="+regionId,
                              ///"ajax": "/students/index?schoolId=" +schoolId,
                                "aLengthMenu": [
								[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                                ],
                               "columns":[
											{"data":"employee_name"},
											{"data":"employees_id"},
							   				{"data":"last_updated_date"},
                                            {"data":"firstname"},											
											{"data":"phone"},	
											{"data":"product_category_name"},										
											{"data":"next_followup"},
											{"data":"store_region_name"},
											{"data":"store_name"},
											{"data":"lead_status"},
                                            {
                                                "targets": 0,
                                                "data": "customer_id",
                                                "render": function ( data, type, full, meta ) {
                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
                                                             return str;
                                                            }
                                            } 
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
                    function employeeSelect()
					{
                    	var value=jQuery('#employee').val();
                    	var RegionId=jQuery('#region').val();
                    	var StoreId=jQuery('#store').val();
                    	//$("#customerListGrid").show();
						$("#customerListGrid").dataTable({
							   "destroy":true,
                              "processing": true,
                              "serverSide": true,                              
                              "ajax": "/customers/getAllCustomerLeads/?employeeId=" +value+"&region_id="+RegionId+"&store_id="+StoreId,
                              ///"ajax": "/students/index?schoolId=" +schoolId,
                                "aLengthMenu": [
								[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                                ],
                               "columns":[
											{"data":"employee_name"},
											{"data":"employees_id"},
							   				{"data":"last_updated_date"},
                                            {"data":"firstname"},											
											{"data":"phone"},	
											{"data":"product_category_name"},										
											{"data":"next_followup"},
											{"data":"store_region_name"},
											{"data":"store_name"},
											{"data":"lead_status"},
                                            {
                                                "targets": 0,
                                                "data": "customer_id",
                                                "render": function ( data, type, full, meta ) {
                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
                                                             return str;
                                                            }
                                            } 
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
                              "ajax": "/customers/getAllCustomerLeads",
                                "aLengthMenu": [
								[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                                ],
                               "columns": [
											{"data":"employee_name"},
											{"data":"employees_id"},
							   				{"data":"last_updated_date"},
                                            {"data":"firstname"},											
											{"data":"phone"},	
											{"data":"product_category_name"},										
											{"data":"next_followup"},
											{"data":"store_region_name"},
											{"data":"store_name"},
											{"data":"lead_status"},
                                            {
                                                "targets": 0,
                                                "data": "customer_id",
                                                "render": function ( data, type, full, meta ) {
                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
                                                             return str;
                                                            }
                                            } 
                                          ]
						});
					});
					</script>

								<table id="customerListGrid"
									class="table table-striped table-bordered" cellspacing="0"
									width="100%">
									<thead>
										<tr>
											<th>Employee Name</th>
											<th>Emp Id</th>
											<th>Created Date</th>
											<th>Customer Name</th>
											<th>Phone</th>
											<th>Sub Category</th>
											<th>Followup Date</th>
											<th>Region Name</th>
											<th>Store Name</th>
											<th>Lead Status</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Employee Name</th>
											<th>Emp Id</th>
											<th>Created Date</th>
											<th>Customer Name</th>
											<th>Phone</th>
											<th>Sub Category</th>
											<th>Followup Date</th>
											<th>Region Name</th>
											<th>Store Name</th>
											<th>Lead Status</th>
											<th>Actions</th>
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
<div class="row">
					<div class="col-sm-1" style="float: left; margin-left: 66.5%;">
						<label class="control-label" for="username">Select Employee</label>
					</div>
					<div class="col-md-3" style="float: right;">
						<select name="employee" id="employee" onchange="employeeSelect()"
							class="form-control">
							<option value="">--Search--</option>
								<?php
	foreach ( $employees as $employee ) {
		
		?>
									<option value="<?php echo $employee['employees_id'];?>">
									<?php echo $employee['employee_name'];?><?php } ?></option>
						</select>
					</div>
				</div>
				<br> <br>
				<div class="panel-body">
					<script type="text/javascript">
                    var pathToImageCategories = "<?php echo URL; ?>";
                   $(document).ready(function($)
        					{
                	//$("#customerListGrid").hide();

                	});
                    function employeeSelect()
					{
                    	var value=jQuery('#employee').val();
                    	
                    	//$("#customerListGrid").show();
						$("#customerListGrid").dataTable({
							   "destroy":true,
                              "processing": true,
                              "serverSide": true,                              
                              "ajax": "/customers/getAllCustomerLeads/?employeeId=" +value,
                              ///"ajax": "/students/index?schoolId=" +schoolId,
                                "aLengthMenu": [
								[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
                                ],
                               "columns":[
											{"data":"employee_name"},
											{"data":"employees_id"},
							   				{"data":"last_updated_date"},
                                            {"data":"firstname"},											
											{"data":"phone"},	
											{"data":"product_category_name"},										
											{"data":"next_followup"},
											{"data":"lead_status"},
                                            {
                                                "targets": 0,
                                                "data": "customer_id",
                                                "render": function ( data, type, full, meta ) {
                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
                                                             return str;
                                                            }
                                            } 
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
                              "ajax": "/customers/getAllCustomerLeads",
                                "aLengthMenu": [
								[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]
                                ],
                               "columns": [
											{"data":"employee_name"},
											{"data":"employees_id"},
							   				{"data":"last_updated_date"},
                                            {"data":"firstname"},											
											{"data":"phone"},	
											{"data":"product_category_name"},										
											{"data":"next_followup"},
											{"data":"lead_status"},
                                            {
                                                "targets": 0,
                                                "data": "customer_id",
                                                "render": function ( data, type, full, meta ) {
                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
                                                             return str;
                                                            }
                                            } 
                                          ]
						});
					});
					</script>

									<table id="customerListGrid"
										class="table table-striped table-bordered" cellspacing="0"
										width="100%">
										<thead>
											<tr>
												<th>Employee Name</th>
												<th>Emp Id</th>
												<th>Created Date</th>
												<th>Customer Name</th>
												<th>Phone</th>
												<th>Category</th>
												<th>Followup Date</th>
												<th>Lead Status</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Employee Name</th>
												<th>Emp Id</th>
												<th>Created Date</th>
												<th>Customer Name</th>
												<th>Phone</th>
												<th>Category</th>
												<th>Followup Date</th>
												<th>Lead Status</th>
												<th>Actions</th>
											</tr>
										</tfoot>

										<tbody>

										</tbody>
									</table>

								</div>
							</div>

						</div>

					</div>


<?php }elseif($_SESSION ['role'] == "3"){?>

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
                              "ajax": "/customers/getAllCustomerLeads",
                                "aLengthMenu": [
								[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]
                                ],
                               "columns": [
							   				{"data":"last_updated_date"},
                                            {"data":"firstname"},											
											{"data":"phone"},	
											{"data":"product_category_name"},										
											{"data":"next_followup"},
                                            {
                                                "targets": 0,
                                                "data": "customer_id",
                                                "render": function ( data, type, full, meta ) {
                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
                                                             return str;
                                                            }
                                            } 
                                          ]
						});
					});
					</script>

									<table id="customerListGrid"
										class="table table-striped table-bordered" cellspacing="0"
										width="100%">
										<thead>
											<tr>
												<th>Created Date</th>
												<th>CustomerName</th>
												<th>Phone</th>
												<th>Category</th>
												<th>Followup Date</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tfoot>
											<tr>

												<th>Created Date</th>
												<th>CustomerName</th>
												<th>Phone</th>
												<th>Category</th>
												<th>Followup Date</th>
												<th>Actions</th>
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



	<div class="row">
						<div class="col-md-12" style="padding: 0 4%;margin-bottom:-2%;">

							<!-- Default panel -->
							<div class="panel panel-default">
								<div class="col-sm-1">
									<label class="control-label" for="select_region">Select</label>
								</div>
								<div class="col-md-3">
									<select name="store" id="store" onchange="storeSelect()"
										class="form-control">
										<option value="">--Stores--</option>
										<?php
									foreach ( $stores as $store ) {
										?>
										<option value="<?php echo $store['store_id'];?>">
										<?php echo $store['store_name'];?><?php } ?></option>
									</select>
								</div>
								<div class="col-sm-1">
									<label class="control-label" for="select_store">Select</label>
								</div>
								<div class="col-md-3">

									<select name="employee" id="employee"
										onchange="employeeSelect()" class="form-control">
										<option value="">--Employee--</option>
									</select>

								</div>
							</div>

						</div>
						<br> <br>


						<div class="panel-body">
							<script type="text/javascript">
	                    var pathToImageCategories = "<?php echo URL; ?>";
	                   $(document).ready(function($)
	        					{
	                	//$("#customerListGrid").hide();
	
	                	});
	                   function regionSelect(){
	                	   var RegionId=jQuery('#region').val();
	                	   regionRefSelect(RegionId);
	                	   regionStoreSelect(RegionId);
	                		
	                   }
	                   function regionStoreSelect(data){
	                      // alert(data);
	                      var output='';
	                      var employeeOt='';
	                      var employeeOut='';
	           		jQuery.ajax({
	           		type : "POST",
	           		url :"<?php echo URL; ?>/customers/getStoreByRegionId/?region_id=" +data,
	           		data: data,
	           		//dataype:"json",
	           		success:function(response){
	           			var JSONObject = JSON.parse(response);
	           			//alert(JSONObject.length);
	           			employeeOut +='<option value="">--Employee--</option>';
	           			employeeOt +='<option value="">--Store--</option>';
	           			for(i=0;i<=JSONObject.length;i++){
	           			output +='<option value="'+JSONObject[i]['store_id']+'">'+JSONObject[i]['store_name']+'</option>';
						oriOt=employeeOt+output;
	           			//alert(JSONObject[0]['class']);
	           		  jQuery('#store').html(oriOt); 
	           		jQuery('#employee').html(employeeOut); 
	           			}
	           		}
	           		});
	           		}
	                    function regionRefSelect(data)
						{
	                    	var emploeeId=jQuery('#employee').val();
	                    	//var RegionId=jQuery('#region').val();
	                    	//$("#customerListGrid").show();
							$("#customerListGrid").dataTable({
								   "destroy":true,
	                              "processing": true,
	                              "serverSide": true,   
	                              "ajax": "/customers/getAllCustomerLeads/?region_id="+data,
	                              ///"ajax": "/students/index?schoolId=" +schoolId,
	                                "aLengthMenu": [
									[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
	                                ],
	                               "columns":[
												{"data":"employee_name"},
												{"data":"employees_id"},
								   				{"data":"last_updated_date"},
	                                            {"data":"firstname"},											
												{"data":"phone"},	
												{"data":"product_category_name"},										
												{"data":"next_followup"},
												{"data":"store_region_name"},
												{"data":"store_name"},
												{"data":"lead_status"},
	                                            {
	                                                "targets": 0,
	                                                "data": "customer_id",
	                                                "render": function ( data, type, full, meta ) {
	                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
	                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
	                                                             return str;
	                                                            }
	                                            },
												
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
	               		function storeSelect(){
	               		 var StoreId=jQuery('#store').val();
	               			storeRefSelect(StoreId);
	               			employeeValueSelect(StoreId);
	                   	}
	                   	function employeeValueSelect(data){
	                   		var output='';
	                   		var employeeOt='';
	                   		jQuery.ajax({
	                   		type : "POST",
	                   		url :"<?php echo URL; ?>/customers/getEmployeesByStoreId/?store_id=" +data,
	                   		data: data,
	                   		//dataype:"json",
	                   		success:function(response){
	                   			var JSONObject = JSON.parse(response);
	                   			//alert(JSONObject.length);
	                   			employeeOt +='<option value="">--Employee--</option>';
	                   			for(i=0;i<=JSONObject.length;i++){
	                   			output +='<option value="'+JSONObject[i]['employee_id']+'">'+JSONObject[i]['employee_name']+'</option>';
	                   			oriOt=employeeOt+output;
	                   			//alert(JSONObject[0]['class']);
	                   		   jQuery('#employee').html(oriOt); 
	                   			}
	                   		//window.setTimeout(function(){location.reload()},1000)
	                   		//document.location.reload(true);
	                   		}
	                   		//jQuery('#importmsg').html("cannot "); 
	                   		});
	                       	}
	                    function storeRefSelect(data)
						{
	                    	var RegionId=<?php echo $_SESSION['store_region'];?>;
	                    	//$("#customerListGrid").show();
							$("#customerListGrid").dataTable({
								   "destroy":true,
	                              "processing": true,
	                              "serverSide": true,                              
	                              "ajax": "/customers/getAllCustomerLeads/?store_id="+data+"&region_id="+RegionId,
	                              ///"ajax": "/students/index?schoolId=" +schoolId,
	                                "aLengthMenu": [
									[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
	                                ],
	                               "columns":[
												{"data":"employee_name"},
												{"data":"employees_id"},
								   				{"data":"last_updated_date"},
	                                            {"data":"firstname"},											
												{"data":"phone"},	
												{"data":"product_category_name"},										
												{"data":"next_followup"},
												{"data":"store_region_name"},
												{"data":"store_name"},
												{"data":"lead_status"},
	                                            {
	                                                "targets": 0,
	                                                "data": "customer_id",
	                                                "render": function ( data, type, full, meta ) {
	                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
	                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
	                                                             return str;
	                                                            }
	                                            } 
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
	                    function employeeSelect()
						{
	                    	var value=jQuery('#employee').val();
	                    	var RegionId=<?php echo $_SESSION['store_region'];?>;
	                    	var StoreId=jQuery('#store').val();
	                    	//$("#customerListGrid").show();
							$("#customerListGrid").dataTable({
								   "destroy":true,
	                              "processing": true,
	                              "serverSide": true,                              
	                              "ajax": "/customers/getAllCustomerLeads/?employeeId=" +value+"&region_id="+RegionId+"&store_id="+StoreId,
	                              ///"ajax": "/students/index?schoolId=" +schoolId,
	                                "aLengthMenu": [
									[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
	                                ],
	                               "columns":[
												{"data":"employee_name"},
												{"data":"employees_id"},
								   				{"data":"last_updated_date"},
	                                            {"data":"firstname"},											
												{"data":"phone"},	
												{"data":"product_category_name"},										
												{"data":"next_followup"},
												{"data":"store_region_name"},
												{"data":"store_name"},
												{"data":"lead_status"},
	                                            {
	                                                "targets": 0,
	                                                "data": "customer_id",
	                                                "render": function ( data, type, full, meta ) {
	                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
	                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
	                                                             return str;
	                                                            }
	                                            } 
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
							var RegionId=<?php echo $_SESSION['store_region'];?>;
							$("#customerListGrid").dataTable({
	                              "processing": true,
	                              "serverSide": true,                              
	                              "ajax": "/customers/getAllCustomerLeads/?region_id=" +RegionId,
	                                "aLengthMenu": [
									[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]
	                                ],
	                               "columns": [
												{"data":"employee_name"},
												{"data":"employees_id"},
								   				{"data":"last_updated_date"},
	                                            {"data":"firstname"},											
												{"data":"phone"},	
												{"data":"product_category_name"},										
												{"data":"next_followup"},
												{"data":"store_region_name"},
												{"data":"store_name"},
												{"data":"lead_status"},
	                                            {
	                                                "targets": 0,
	                                                "data": "customer_id",
	                                                "render": function ( data, type, full, meta ) {
	                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
	                                                                  str +='<a href="/customers/history?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
	                                                             return str;
	                                                            }
	                                            } 
	                                          ]
							});
						});
						</script>

													<table id="customerListGrid"
														class="table table-striped table-bordered" cellspacing="0"
														width="100%">
														<thead>
															<tr>
																<th>Employee Name</th>
																<th>Emp Id</th>
																<th>Created Date</th>
																<th>Customer Name</th>
																<th>Phone</th>
																<th>Category</th>
																<th>Followup Date</th>
																<th>Region Name</th>
																<th>Store Name</th>
																<th>Lead Status</th>
																<th>Actions</th>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<th>Employee Name</th>
																<th>Emp Id</th>
																<th>Created Date</th>
																<th>Customer Name</th>
																<th>Phone</th>
																<th>Category</th>
																<th>Followup Date</th>
																<th>Region Name</th>
																<th>Store Name</th>
																<th>Lead Status</th>
																<th>Actions</th>
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
																<li><b>Name:</b> <span
																	class="pull-right ajax-content-name">Loading...</span>
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
																<li><b>Dial:</b> <span
																	class="pull-right ajax-content-dial">Loading...</span>
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
																<li><b>Crown:</b> <span
																	class="pull-right ajax-content-crown">Loading...</span>
																</li>
															</ul>

														</div>
													</div>
													<div class="row">
														<div class="col-md-4">
															<ul class="list-unstyled line-height-default">
																<li><b>Hands:</b> <span
																	class="pull-right ajax-content-hands">Loading...</span>
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