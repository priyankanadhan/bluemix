<div class="page-title">			
	<div class="title-env">
		<h1 class="title">Edit Product</h1>
		<p class="description">Interface for adding Edit Product.</p>
	</div>			
	<div class="breadcrumb-env">			
		<ol class="breadcrumb bc-1" >
			<li><a href="/catalogs/index"><i class="fa-home"></i>All Products</a>
			</li>								
			<li class="active"><strong>Edit Product</strong>
			</li>
		</ol>
	</div>
</div>            
            <form method="post" name="product" id="product" class="validate" enctype="multipart/form-data">
				<div class="panel panel-headerless">
					<div class="panel-body">
			
						<div class="member-form-add-header">
							<div class="row">
                                <?php if($message){?>
                                <div class="col-md-2 col-sm-4 pull-left-sm">
                                    <p class="description"><?php echo $message;?></p>											
								</div>
                                <?php }?>
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
									<label class="control-label">Product Name</label>
								</div>
								<div class="col-sm-3">                                     
									<input type="text" class="form-control" name="product_name" id="product_name" value="<?php echo $products->product_name;?>" data-validate="required" data-message-required="Product Name is required." placeholder="Enter the Product Name" />			
								</div>
                             </div>
                             <div class="row">
								<div class="col-sm-3">
									<label class="control-label">Product Model</label>
								</div>
								<div class="col-sm-3">                                     
									<input type="text" class="form-control" name="product_model" id="product_model" value="<?php echo $products->product_model;?>" data-validate="required" data-message-required="Product Model is required." placeholder="Enter the Product Model" />			
								</div>
                             </div>
                             <div class="row">
								<div class="col-sm-3">
									<label class="control-label">Product Specification</label>
								</div>
								<div class="col-sm-3">  
                                	<textarea  name="product_specification" id="product_specification" class="form-control" placeholder="Enter the Product Specification"><?php echo $products->product_specification;?></textarea>                               
								</div>
                             </div>
                             <div class="row">
								<div class="col-sm-3">
									<label class="control-label">Select Category</label>
								</div>
								<div class="col-sm-3">                                     
									<select class="form-control" data-validate="required" name = "product_category_id" id="product_category_id">
										<option value="" selected>Select the Category</option>
                                        <?php foreach($categories as $category){?>
                                            <option value="<?php echo $category['product_category_id'];?>" <?php if($category['product_category_id'] == $catalog->product_category_id){echo "selected";} ?>><?php echo $category['product_category_name'];?></option>
                                        <?php }?>
									</select>			
								</div>
                             </div>
                              <div class="row">  
                                <div class="col-sm-3">
									<label class="control-label">Status</label>
								</div>
								<div class="col-sm-3">
                                   <input type="radio" name="active_status" value="1" <?php if($categories->active_status == 1){echo "checked";} ?> class="cbr cbr-info form-control "><label class="control-label">Enable</label>&nbsp;									
									<input type="radio" name="active_status" value="0" <?php if($categories->active_status == 0){echo "checked";} ?> class="cbr cbr-info form-control "><label class="control-label">Disable</label>					
			
								</div>
							</div>                        
			
					</div>
				</div>
			</form>