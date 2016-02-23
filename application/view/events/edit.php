<style>
.loginWrong {
	color: #E81D02;
}

.member-form-inputs .row::before {
	background: #fff none repeat scroll 0 0;
}

.member-form-inputs .row::before {
	margin: 0 15px 10px;
}
</style>
<div class="page-title">

	<div class="title-env">
		<h1 class="title">Event Update</h1>
		<p class="description">Interface for View/Update Event.</p>
	</div>

	<div class="breadcrumb-env">

		<ol class="breadcrumb bc-1">
			<li><a href="/events/index"><i class="fa-home"></i>Events</a></li>

			<li class="active"><strong>Event Update</strong></li>
		</ol>

	</div>

</div>

<div class="panel panel-headerless">
	<div class="panel-body">
		<div class="member-form-inputs">
			<div class="row" style="margin-top: 5px;">
				<div class="col-sm-4">
					<label class="control-label"><strong>Category:</strong> <?php echo $event->category;?></label>
				</div>
				<div class="col-sm-4">
					<label class="control-label"><strong>Subject:</strong> <?php echo $event->subject;?></label>
				</div>
				<div class="col-sm-4">
					<label class="control-label"><strong>Season:</strong> <?php echo $event->season_name;?></label>
				</div>
			</div>
			<div class="row" style="margin-top: 5px;">
				<div class="col-sm-4" style="border: 0px;">
					<label class="control-label"><strong>Month:</strong> <?php echo $event->month;?></label>
				</div>
				<div class="col-sm-4">
					<label class="control-label"><strong>State:</strong> <?php echo $event->state_name;?></label>
				</div>
				<div class="col-sm-4" style="border: 0px;">
					<label class="control-label"><strong>Region:</strong> <?php echo $event->region_name;?></label>
				</div>
			</div>
			<div class="row" style="margin-top: 5px;">

				<div class="col-sm-4">
					<label class="control-label"><strong>Description:</strong> <?php echo $event->description;?></label>
				</div>
				<div class="col-sm-4" style="border: 0px;">
					<label class="control-label"><strong>Date From:</strong> <?php echo $event->from_date;?></label>
				</div>
				<div class="col-sm-4">
					<label class="control-label"><strong>Date Till:</strong> <?php echo $event->to_date;?></label>
				</div>
			</div>

			<div class="row" style="margin-top: 5px;">

				<div class="col-sm-4">
					<label class="control-label"><strong>Address:</strong> <?php echo $event->address;?></label>
				</div>
				<div class="col-sm-4">
					<label class="control-label"><strong>Comments:</strong> <?php echo $event->comments;?></label>
				</div>
			</div>
			<div class="row" style="margin-top: 5px;">

				<div class="col-sm-4">
					<label class="control-label"><strong>Photos:</strong></label>
				</div>
					
					<?php
					foreach ( $photos as $photo ) {
						?><div class="col-sm-3">
					<img src="<?php echo  URL_UPLOADS.$photo['file_name']?>"
						style="width: 200px; height: 100px;padding-top:20px;">
				</div><?php }?>
				

			</div>
		</div>
	</div>
</div>
<form method="post" action="/events/addComment" name="commentsForm"
	id="commentsForm" class="validate" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-12">

			<div class="xe-widget xe-conversations">
				<div class="xe-bg-icon">
					<i class="linecons-comment"></i>
				</div>
				<div class="xe-header">
					<div class="xe-icon">
						<i class="linecons-comment"></i>
					</div>
					<div class="xe-label">
						<h3>
							Comments History <small>Track Record</small>
						</h3>
					</div>
				</div>
				<div class="xe-body">

					<ul class="list-unstyled">                            
								<?php foreach ($comments as $history){?>
								<li>
							<div class="xe-comment-entry">
								<a href="#" class="xe-user-img"> <i class="linecons-comment"></i>
								</a>

								<div class="xe-comment" style="width: 50%;">
									<i><?php
									$dt = new \DateTime ( $history->updated_date );
									echo $dt->format ( 'd-M-Y  H:i:s' );
									?></i>
									<p><?php echo $history['comments']; ?></p>
								</div>

								<div class="xe-comment" style="width: 50%; text-align: right;">


								</div>

							</div>
						</li>
								<?php } ?>
							</ul>

				</div>

			</div>

		</div>
	</div>
	<div class="panel panel-headerless">
		<div class="col-md-2 col-sm-4 pull-right-sm">
			<input type="button" class="btn btn-block btn-secondary"
				name="submitNew" value="Add Comment" onClick="addComment();">
		</div>
		<div class="panel-body">
			<div class="member-form-inputs">
				<div class="row" style="margin-top: 5px;">

					<div class="col-sm-4">
						<label class="control-label"><strong>Write Comment:</strong></label>
					</div>
					<div class="col-sm-4">
						<textarea type="text" class="form-control" name="comments"
							id="comments" value="" placeholder="Enter the Comment here"></textarea>
					</div>

				</div>
			</div>
		</div>
	</div>


</form>
<script type="text/javascript">
				jQuery(document).ready(function($)
				{
			    var productId = $("#product_category_id").val();
					if(productId == '38'){
	                	  $("#product_subcategory_id").attr("disabled",true);
	                	  $("#product_name").attr("disabled",true);
	                      }else{
	                    	  $("#product_subcategory_id").attr("disabled",false);
	                    	  $("#product_name").attr("disabled",false);
	                      }
				  $("#product_category_id").change(function(){
                  var str = '';
                  var strp='';
                  var selectedId = $("#product_category_id").val();
                  if(selectedId == '38'){
                	  $("#product_subcategory_id").attr("disabled",true);
                	  $("#product_name").attr("disabled",true);
                      }else{
                    	  $("#product_subcategory_id").attr("disabled",false);
                    	  $("#product_name").attr("disabled",false);
                      }
                  $.ajax({
                  	type: "POST",
                    dataType: "json",
                    url: "/customers/getSubCategories", //Relative or absolute path to response.php file
                    data: {"refKey":selectedId},
                    success: function(data) {                                                       
                      $.each(data,function(key,obj){                                                           
                      str +='<option value="'+obj.product_category_id+'">'+obj.product_category_name+'</option>';                                                        
                    });
                    $("#product_subcategory_id").html(str);
                     }
                    }); 
                 });
				 
				 $("#product_subcategory_id").change(function(){
                  var str = '';
				  str +='<option value="" selected>Select the Product</option>';
                  var selectedId = $("#product_subcategory_id").val();
                  $.ajax({
                  	type: "POST",
                    dataType: "json",
                    url: "/customers/getCategoryProducts", //Relative or absolute path to response.php file
                    data: {"refKey":selectedId},
                    success: function(data) {                                                       
                      $.each(data,function(key,obj){                                                           
                      str +='<option value="'+obj.product_id+'">'+obj.product_name+'</option>';                                                        
                    });
                    $("#product_name").html(str);
                     }
                    }); 
                 });
				 var selectedLeadId = $("#lead_status").val();
					
					if(selectedLeadId == 'closed'){
	                	  $("#pricerow").css("display","block");
	                      }else{
	                    	  $("#pricerow").css("display","none");
	                      }
				 $("#lead_status").change(function(){
					  var selectedLeadId = $("#lead_status").val();
                 if(selectedLeadId == 'closed'){
                	 $("#pricerow").css("display","block");
                 }else{
               	  $("#pricerow").css("display","none");
                 }
                });
				 											
			});	
				function addComment(){
					
					 var comment = {'comment':$("#comments").val(),
							         'refKey':<?php echo $_REQUEST['refKey']?>};
					
					$.ajax({
						url:"<?php echo URL; ?>events/addComment",
						data: comment,
					    type: 'POST',
						success: function (data) {
						if(data){
					    window.setTimeout(function(){location.reload()},500)
						}
						}
					});
				}									
			</script>
