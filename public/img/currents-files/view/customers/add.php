<style>
        .loginWrong{
            color:#E81D02;
        }
    </style>
<div class="page-title">
			
				<div class="title-env">
					<h1 class="title">Add Customer</h1>
					<p class="description">Interface for adding new Customer.</p>
				</div>			
				<div class="breadcrumb-env">			
					<ol class="breadcrumb bc-1">
						<li>
							<a href="/customers/index"><i class="fa-home"></i>All Customer</a>
						</li>								
						<li class="active">			
							<strong>Add Customer</strong>
						</li>
					</ol>						
				</div>				
			</div>            
            <form method="post" name="product" id="product" class="validate" enctype="multipart/form-data">
				<div class="panel panel-headerless">
					<div class="panel-body">
			
						<div class="member-form-add-header">
							<div class="row">
                                <?php if($_SESSION['message']){?>
                                <div class="col-md-2 col-sm-4 pull-left-sm">
                                    <p class="description"><?php echo $_SESSION['message'];?></p>											
								</div>
                                <?php unset($_SESSION['message']);}?>
								<div class="col-md-2 col-sm-4 pull-right-sm">
			
									<div class="action-buttons">
                                        <input type="submit" class="btn btn-block btn-secondary" name="submit" value="Submit">										
										<button type="reset" class="btn btn-block btn-gray">Reset to Default</button>
									</div>
			
								</div>
								
							</div>
						</div>                            
						<div class="member-form-inputs">
                        <div class="row">
							<div class="col-sm-3">
								<label class="control-label">Name</label>
							</div>
							<div class="col-sm-3">                                     
								<input type="text" class="form-control" name="firstname" id="firstname" value="" data-validate="required" data-message-required="First Name is required." placeholder="Enter the First Name" />			
							</div>
                        </div>                         
                         <div class="row">
							<div class="col-sm-3">
								<label class="control-label">Email Address</label>
							</div>
							<div class="col-sm-3">                                     
								<input type="text" class="form-control" data-validate="email" name="email" id="email" value="" data-validate="required" data-message-required="Email Address is required." placeholder="Enter the Email Address" />			
							</div>
                        </div>
                         <div class="row">
							<div class="col-sm-3">
								<label class="control-label">Phone</label>
							</div>
							<div class="col-sm-3">                                     
								<input type="text" class="form-control" name="phone" id="phone" value="" data-validate="required" data-message-required="Phone is required." placeholder="Enter the Phone" />			
							</div>
                        </div>
                        <div class="row">
							<div class="col-sm-3">
								<label class="control-label">Category</label>
							</div>
							<div class="col-sm-3">                                     
								<select class="form-control" data-validate="required" name="product_category_id" id="product_category_id">
									<option value="" selected>Select Category</option>
                                        <?php foreach($mcategories as $mcategory){?>
                                            <option value="<?php echo $mcategory['product_category_id'];?>" ><?php echo $mcategory['product_category_name'];?></option>
                                        <?php }?>
								</select>			
							</div>
                         </div>
                        <div class="row">
							<div class="col-sm-3">
								<label class="control-label">Sub Category</label>
							</div>
							<div class="col-sm-3">                                     
								<select class="form-control" name ="product_subcategory_id" id="product_subcategory_id">
									<option value="" selected>Select Sub Category</option>
                                        <?php foreach($categories as $category){?>
                                            <option value="<?php echo $category['product_category_id'];?>" ><?php echo $category['product_category_name'];?></option>
                                        <?php }?>
								</select>			
							</div>
                         </div>   
                         <div class="row">
								<div class="col-sm-3">
									<label class="control-label">Product Description</label>
								</div>
								<div class="col-sm-3">  
                                	<select class="form-control" name ="product_id" id="product_id">
									<option value="" selected>Select Product Description</option>
                                        <?php foreach($categories as $category){?>
                                            <option value="<?php echo $category['product_category_id'];?>" ><?php echo $category['product_category_name'];?></option>
                                        <?php }?>
								</select>                               
								</div>
                          </div>                              
                         	<div class="row">
								<div class="col-sm-3">
									<label class="control-label">Comments</label>
								</div>
								<div class="col-sm-3">  
                                	<textarea  name="comments" id="comments" class="form-control" placeholder="Enter the Comments"></textarea>                               
								</div>
                             </div>
					</div>          
                    <div class="member-form-add-header">
							<div class="row">                                
								<div class="pull-right-sm">			
									<div class="action-buttons">
                                        <input type="submit" class="btn btn-block btn-secondary" name="submit" value="Submit">										
									</div>
								</div>
							</div>
					</div>
				</div>
			</form>
            <script type="text/javascript">
				jQuery(document).ready(function($)
				{
				  $("#product_category_id").change(function(){
                  var str = '';
				  str +='<option value="" selected>Select the Category</option>';
                  var selectedId = $("#product_category_id").val();
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
                    $("#product_id").html(str);
                     }
                    }); 
                 });
				 											
			});										
			</script>