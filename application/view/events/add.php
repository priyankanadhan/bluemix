<div class="page-title">

	<div class="title-env">
		<h1 class="title">Add Event</h1>
		<p class="description">Interface for adding new Event.</p>
	</div>

	<div class="breadcrumb-env">

		<ol class="breadcrumb bc-1">
			<li><a href="/events/index"><i class="fa-home"></i>All Events</a></li>

			<li class="active"><strong>Add Event</strong></li>
		</ol>

	</div>

</div>

<form method="post" name="product" id="product" class="validate"
	enctype="multipart/form-data">
	<div class="panel panel-headerless">
		<div class="panel-body">

			<div class="member-form-add-header">
				<div class="row">
                                <?php if($message){?>
                                <div
						class="col-md-2 col-sm-4 pull-left-sm">
						<p class="description"><?php echo $message;?></p>
					</div>
                                <?php }?>
								<div class="col-md-2 col-sm-4 pull-right-sm">

						<div class="action-buttons">
							<input type="submit" class="btn btn-block btn-secondary"
								name="submit" value="Submit">
							<button type="reset" class="btn btn-block btn-gray">Reset to
								Default</button>
						</div>

					</div>

				</div>
			</div>
			<div class="member-form-inputs">
				<div class="row">
					<div class="col-sm-3">
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
						<input type="text" class="form-control" name="subject"
							id="subject" value="" data-validate="required"
							data-message-required="Subject is required."
							placeholder="Enter the Subject Name" />
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
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
				<div class="row">
					<div class="col-sm-3">
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
				</div>

				<div class="row">
					<div class="col-sm-2">
						<label class="control-label">Description</label>
					</div>
					<div class="col-sm-3">
						<textarea type="text" class="form-control" name="description"
							id="description" value=""
							placeholder="Enter the Description Name"></textarea>

					</div>
					<div class="col-sm-1">
						<label class="control-label" for="select_region">Date From</label>
					</div>
					<div class="col-sm-2">
						<div class="input-group">
							<input type="text" class="datepicker form-control"
								data-format="dd-mm-yyyy" name="from" id="from" value="" required>
						</div>
					</div>
					<div class="col-sm-1">
						<label class="control-label" for="select_store">Date Till</label>
					</div>
					<div class="col-sm-2">
						<div class="input-group">
							<input type="text" class="datepicker form-control"
								data-format="dd-mm-yyyy" name="to" id="to" value="" required>
						</div>
					</div>

				</div>
				<div class="row">
					<div class="col-sm-2">
						<label class="control-label">Address</label>
					</div>
					<div class="col-sm-3">
						<textarea type="text" class="form-control" name="address"
							id="address" value="" data-validate="required"
							data-message-required="Address is required."
							placeholder="Enter the Address"></textarea>

					</div>
					<div class="col-sm-2">
						<label class="control-label">Comments</label>
					</div>
					<div class="col-sm-3">
						<textarea type="text" class="form-control" name="comments"
							id="comments" value="" data-validate="required"
							data-message-required="Comments is required."
							placeholder="Enter the comments"></textarea>

					</div>
				</div>

				<script type="text/javascript">
						jQuery(document).ready(function($)
						{
								var i = 1,
								$example_dropzone_filetable = $("#example-dropzone-filetable"),
								example_dropzone = $("#advancedDropzone").dropzone({
								url: 'FileUpload',
								
								// Events
								
								addedfile: function(file)
								{
									var flag=false;
									if(i == 1)
									{
										$example_dropzone_filetable.find('tbody').html('');
									}
									if(!flag){
										
									var size = parseInt(file.size/1024, 10);
									size = size < 1024 ? (size + " KB") : (parseInt(size/1024, 10) + " MB");
									var uploadType="file_upload";
									var checkBox='<input type="checkbox" name="check" id="check" value="0">';
									
									var $entry = $('<tr class="tableRow">\
													<td class="textId" style="display:none;"></td>\
													<td class="text-center" style="display:none;">'+(i++)+'</td>\
													<td class="uploadType" name="uploadType" id="uploadType" style="display:none;">'+uploadType+'</td>\
													<td>'+checkBox+'</td>\
													<td>'+file.name+'</td>\
													<td><div class="progress progress-striped"><div class="progress-bar progress-bar-warning"></div></div></td>\
													<td>'+size+'</td>\
													<td>Uploading...</td>\
												</tr>');
									
									$example_dropzone_filetable.find('tbody').append($entry);
									file.fileEntryTd = $entry;
									file.textId = $entry.find('.textId');
									file.uploadType = $entry.find('.uploadType');
									file.progressBar = $entry.find('.progress-bar');
			
									}
								},
								
								uploadprogress: function(file, progress, bytesSent)
								{
									file.progressBar.width(progress + '%');
								},
								
								success: function(file,response)
								{
									
									if(response == "1"){
										alert("unable to upload file");
										return;
										}else{
										
									file.textId.html(response);
									file.fileEntryTd.find('td:last').html('<span class="text-success">Uploaded</span>');
									file.progressBar.removeClass('progress-bar-warning').addClass('progress-bar-success');
									$("#fileRow").load(location.href + " #fileRow");
									//window.setTimeout(function(){location.reload()},500)
									}
									},
								
								error: function(file)
								{
									file.fileEntryTd.find('td:last').html('<span class="text-danger">Failed</span>');
									file.progressBar.removeClass('progress-bar-warning').addClass('progress-bar-red');
									alert("unable to upload file");
									}
							});
							$("#advancedDropzone").css({
								minHeight: 200
							});
						});
					</script>

				<br />
				<div class="row" id="fileRow">
					<div class="col-sm-3 text-center">

						<div id="advancedDropzone" class="droppable-area">Drop Files Here</div>

					</div>
					<div class="col-sm-9">
						<table class="table table-bordered table-striped fileTable"
							id="example-dropzone-filetable">
							<thead>
								<tr>
									<th width="1%" class="text-center">#</th>
									<th width="1%" class="dsds" style="display: none;">#</th>
									<th width="1%" class="text-center">Select</th>
									<th width="50%">Name</th>
									<th width="20%">Upload Progress</th>
									<th>Size</th>
									<th>Status</th>
								</tr>
									<?php if(!empty($tableValues)){?>
									<?php
										
										$i = 1;
										$idArray = array ();
										foreach ( $tableValues as $data ) {
											$idArray [] = $data ['id'];
											?>
										<tr class="tableRow">
									<td class="textId" style="display: none;"><?php echo $data['id'];?></td>
									<td class="text-center"><?php echo $i;?></td>
									<td><input type="checkbox" id="check" value="0" name="check"></td>
									<td><?php echo $data['file_name']?></td>
									<td><div class="progress progress-striped">
											<div class="progress-bar progress-bar-success"></div>
										</div></td>
									<td><?php echo $data['size']?></td>
									<td><span class="text-success">Uploaded</span></td>
								</tr>'
												<?php $i++;}?>
									<?php }?>
								</thead>

							<tbody>
								<?php if($count){?>
									<tr>
									<td colspan="5">Files list will appear here</td>
								</tr>
									<?php }?>
								</tbody>

						</table>
						<input type="button" value="DELETE" name="delete" id="delete"
							class="btn btn-blue btn-sm" onclick="deleteFile();">
					</div>
				</div>

				<script>
function deleteFile(){
	if(confirm("Are Sure Want to delete")){
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

        fileArray[z] = tabledata;
        z++;
    });

$.ajax({
	url:"<?php echo URL; ?>events/deleteFile",
	data: JSON.stringify(fileArray),
    type: 'POST',
	success: function (data) {
	if(data){
		$("#fileRow").load(location.href + " #fileRow");
    /// window.setTimeout(function(){location.reload()},500)
	}
	}
});
	}
}
</script>

			</div>
		</div>

</form>

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



