<style>
.loginWrong{
 color:#E81D02;
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
					<h1 class="title">Customer's History</h1>
					<p class="description">Interface for View/Update Customer's History.</p>
				</div>
			
					<div class="breadcrumb-env">
			
								<ol class="breadcrumb bc-1" >
									<li>
							<a href="/customers/index"><i class="fa-home"></i>Customers</a>
						</li>
								
							<li class="active">
			
										<strong>Customer's History</strong>
								</li>
								</ol>
						
				</div>
				
			</div>
			<?php if($_SESSION['role'] != '1'){?>
            <div class="panel panel-headerless">
				<div class="panel-body">
                <div class="member-form-inputs">
                        <div class="row" style="margin-top: 5px;">
							<div class="col-sm-4">
								<label class="control-label"><strong>Name:</strong> <?php echo $customerdetailsbyid->firstname;?></label>
							</div>
							<div class="col-sm-4">                                     
								<label class="control-label"><strong>Phone:</strong> <?php echo $customerdetailsbyid->phone;?></label>		
							</div>
                            <div class="col-sm-4">                                     
								<label class="control-label"><strong>Email:</strong> <?php echo $customerdetailsbyid->email;?></label>		
							</div>
                        </div>
                        <div class="row" style="margin-top: 5px;">
							<div class="col-sm-4" style="border:0px;">
								<label class="control-label"><strong>Category:</strong> <?php echo $customerdetailsbyid->product_category_name;?></label>
							</div>
							<div class="col-sm-8">                                     
								<label class="control-label"><strong>Product Description:</strong> <?php echo $customerdetailsbyid->product_name;?></label>		
							</div>                           
                        </div>
                        <div class="row" style="margin-top: 5px;">
							<div class="col-sm-4" style="border:0px;">
								<label class="control-label"><strong>Sub Category:</strong> <?php echo $customerdetailsbyid->subcategoryname;?></label>
							</div>
							<div class="col-sm-8">                                     
								<label class="control-label"><strong>comments:</strong> <?php echo $customerdetailsbyid->comments;?></label>		
							</div>                           
                        </div>
                         <?php if($customerdetailsbyid->cust_demo){?>
                        <div class="row" style="margin-top: 5px;">
							<div class="col-sm-4" style="border:0px;">
								<label class="control-label"><strong>Demo:</strong> <?php echo $customerdetailsbyid->cust_demo;?></label>
							</div>
							<div class="col-sm-4">                                     
								<label class="control-label"><strong>Lead Type:</strong> <?php echo $customerdetailsbyid->lead_type;?></label>		
							</div>
                            <div class="col-sm-4">                                     
								<label class="control-label"><strong>Source:</strong> <?php echo $customerdetailsbyid->cust_source;?></label>		
							</div>
                        </div>
                        <?php }?>
                    </div>    
                </div>
            </div> 
            <?php }else{?> 
           <form method="post" name="product" id="product" class="validate" enctype="multipart/form-data" action="/customers/updateCustomerDetailsByAdmin"> 
            <div class="panel panel-headerless">
				<div class="panel-body">
                <div class="member-form-inputs">
                <input type="hidden" name="refKey" id="refKey" value="<?php echo $customersId;?>">
                        <div class="row" style="margin-top: 5px;">
							<div class="col-sm-1">
								<label class="control-label"><strong>Name:</strong></div>
								<div class="col-sm-2">
								<input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $customerdetailsbyid->firstname;?>"></label>
							</div>
							<div class="col-sm-1">                                     
								<label class="control-label"><strong>Phone:</strong> </div>
								<div class="col-sm-2">
								<input type="text" class="form-control" id="phone" name="phone" value="<?php echo $customerdetailsbyid->phone;?>">
								</label>		
							</div>
                            <div class="col-sm-1">                                     
								<label class="control-label"><strong>Email:</strong></div>
								<div class="col-sm-2">
								<input type="text" class="form-control" id="email" name="email" value="<?php echo $customerdetailsbyid->email;?>"></label>		
							</div>
                        </div>
                        <div class="row" style="margin-top: 5px;">
							<div class="col-sm-2" style="border:0px;">
								<label class="control-label"><strong>Category:</strong></div>
								<div class="col-sm-4">
								<select class="form-control"  data-validate="required" name ="product_category_id" id="product_category_id">
                                        <?php
                                        foreach ( $mcategories as $category ) {
                                        	$selected = '';
                                        	if ($customerdetailsbyid->product_category_id == $category['product_category_id'])
                                        		$selected = ' selected="selected"';
                                        	print ('<option value="' . $category['product_category_id'] . '"' . $selected . '>' . $category['product_category_name'] . '</option>' . "\n") ;
                                        		
                                        	?><?php
                                        	}
                                        	?>
								</select> 
							</div>
							<div class="col-sm-2">                                     
								<label class="control-label"><strong>Product Description:</strong></div>
								<div class="col-sm-4">
								<input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $customerdetailsbyid->product_name;?>"></label>		
							</div>                           
                        </div>
                        <div class="row" style="margin-top: 5px;">
							<div class="col-sm-2" style="border:0px;">
								<label class="control-label"><strong>Sub Category:</strong> </div>
								<div class="col-sm-4">
								<select class="form-control"  data-validate="required" name ="product_subcategory_id" id="product_subcategory_id">
                                        <?php
                                        foreach ( $subcategories as $subcategory ) {
                                        	$selected = '';
                                        	if ($customerdetailsbyid->subcategoryid == $subcategory['product_category_id'])
                                        		$selected = ' selected="selected"';
                                        	print ('<option value="' . $subcategory['product_category_id'] . '"' . $selected . '>' . $subcategory['product_category_name'] . '</option>' . "\n") ;
                                        		
                                        	?><?php
                                        	}
                                        	?>
								</select>
							</div>
							<div class="col-sm-2">                                     
								<label class="control-label"><strong>comments:</strong></div> 
								<div class="col-sm-4">
								<input type="text" class="form-control" id="comments" name="comments" value="<?php echo $customerdetailsbyid->comments;?>"></label>		
							</div>                           
                        </div>
                         <?php if($customerdetailsbyid->cust_demo){?>
                        <div class="row" style="margin-top: 5px;">
							<div class="col-sm-4" style="border:0px;">
								<label class="control-label"><strong>Demo:</strong> <?php echo $customerdetailsbyid->cust_demo;?></label>
							</div>
							<div class="col-sm-4">                                     
								<label class="control-label"><strong>Lead Type:</strong> <?php echo $customerdetailsbyid->lead_type;?></label>		
							</div>
                            <div class="col-sm-4">                                     
								<label class="control-label"><strong>Source:</strong> <?php echo $customerdetailsbyid->cust_source;?></label>		
							</div>
                        </div>
                        <?php }?>
                        <div class="member-form-add-header">
							<div class="row">                                
								<div class="col-md-2 col-sm-4 pull-right-sm">
			
									<div class="action-buttons">
                                        <input type="submit" class="btn btn-block btn-secondary" name="submitAdmin" value="Submit">
										<!--button type="submit" name="submit" value = "submit" class="btn btn-block btn-secondary">Save Changes</button-->
										<button type="reset" class="btn btn-block btn-gray">Reset to Default</button>
									</div>
			
								</div>
								
							</div>
						</div>
                    </div>    
                </div>
            </div>  
            </form>
            <?php }?>
            <form method="post" name="product" id="product" class="validate" enctype="multipart/form-data">
				<div class="panel panel-headerless">
					<div class="panel-body">
						<div class="member-form-add-header">
							<div class="row">
                                <?php if($message){?>
                                <div class="col-md-6 col-sm-6 pull-left-sm">
                                    <p class="description"><?php echo $message;?></p>											
								</div>
                                <?php }?>								
							</div>
						</div>		
						<div class="member-form-inputs">  
                        <?php if(!$customerdetailsbyid->cust_demo){?>
                          <div class="row">
								<div class="col-sm-2">
									<label class="control-label">Demo</label>
								</div>
								<div class="col-sm-3">  
                                	<select class="form-control"  data-validate="required" name ="cust_demo" id="cust_demo">
                                        <option value="No" >No</option>
                                        <option value="Yes" >Yes</option>
								</select>                               
								</div>
                                <div class="col-sm-2">
									<label class="control-label">Source</label>
								</div>
								<div class="col-sm-3">  
                                	<select class="form-control"  data-validate="required" name ="cust_source" id="cust_source">
                                        <option value="New Walkin" >New Walkin</option>
                                        <option value="Existing Customer" >Existing Customer</option>
                                        <option value="Inbound Call" >Inbound Call</option>
                                        <option value="Outbound Call" >Outbound Call</option>
                                        <option value="Advertisement" >Advertisement</option>
                                        <option value="Referral" >Referral</option>
                                        <option value="Others" >Others</option>
								</select>                               
								</div>
                             </div>
                            <div class="row">
								<div class="col-sm-2">
									<label class="control-label">Lead Type</label>
								</div>
								<div class="col-sm-3">  
                                	<select class="form-control"  data-validate="required" name ="lead_type" id="lead_type">
                                        <option value="hot" >Hot</option>
                                        <option value="cold" >Cold</option>
								</select>                               
								</div>
                             </div>
                            <?php } ?>     
						  <div class="row">
								<div class="col-sm-2">
									<label class="control-label" for="name">Followup Comments</label>
								</div>
								<div class="col-sm-6">									
                                    <textarea class="form-control" id="comments" name="comments" value=""  placeholder="Enter the details"></textarea>
								</div>
							</div>	                   
							<div class="row">
								<div class="col-sm-2">
									<label class="control-label" for="username">Next Followup Date</label>
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control datepicker"  name="followdate" id="followdate" value=""  data-message-required="Followup update" placeholder="Followup Date" />
								</div>                                
							</div>			
							
                            <div class="row">
								<div class="col-sm-2">
									<label class="control-label" for="name">Lead Status</label>
								</div>
								<div class="col-sm-4">									
									<select class="form-control" data-validate="required" name ="lead_status" id="lead_status" data-message-required="Strap type is required.">
										<option value="open" selected>Open</option>
										<option value="closed" >Closed</option>
										<option value="dead" >Dead</option>
									</select>
								</div>                               
							</div>     
                          							
						</div>
						<div class="member-form-add-header">
							<div class="row">                                
								<div class="col-md-2 col-sm-4 pull-right-sm">
			
									<div class="action-buttons">
                                        <input type="submit" class="btn btn-block btn-secondary" name="submit" value="Submit">
										<!--button type="submit" name="submit" value = "submit" class="btn btn-block btn-secondary">Save Changes</button-->
										<button type="reset" class="btn btn-block btn-gray">Reset to Default</button>
									</div>
			
								</div>
								
							</div>
						</div>		
					</div>
				</div>
			</form>
			
			
			
			<!-- Xenon Conversations Widget -->
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
									Customer History
									<small>Track Record</small>
								</h3>
							</div>
						</div>
						<div class="xe-body">
							
							<ul class="list-unstyled">                            
								<?php foreach ($totalRecordsFiltered as $history){ ?>
								<li>
									<div class="xe-comment-entry">
										<a href="#" class="xe-user-img">
											<i class="linecons-comment"></i>
										</a>
										
										<div class="xe-comment" style="width:50%;">											
												<i><?php 
												$dt = new \DateTime ( $history->updated_date );
												echo $dt->format ( 'd-M-Y  H:i:s' ); ?></i>	
											<p><?php echo $history->customer_comments; ?></p>											
										</div>
										
										<div  class="xe-comment" style="width:50%;text-align:right;">
										
										<strong>Followup by:</strong>
											<p><?php $dt = new \DateTime ( $history->next_followup_date );
												echo $dt->format ( 'd-M-Y' ); ?></p>											
										</div>
										
									</div>
								</li>
								<?php } ?>
                                <?php if(!empty($customerdetailsbyid)){?>							
                                <li>
									<div class="xe-comment-entry">
										<a href="#" class="xe-user-img">
											<i class="linecons-comment"></i>
										</a>
										
										<div class="xe-comment" style="width:50%;">											
												<i><?php 
												$dt = new \DateTime ( $customerdetailsbyid->last_updated_date );
												echo $dt->format ( 'd-M-Y  H:i:s' ); ?></i>	
											<p><?php echo $customerdetailsbyid->comments; ?></p>											
										</div>
										
										<div  class="xe-comment" style="width:50%;text-align:right;">
										
										<?php /*?><strong>Followup by:</strong>
											<p><?php $dt = new \DateTime ( $customerdetailsbyid->next_followup );
												echo $dt->format ( 'd-M-Y' ); ?></p>	<?php */?>										
										</div>
										
									</div>
								</li>                     
								<?php } ?>
							</ul>
							
						</div>
						
					</div>
					
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function($)
				{
				  $("#product_category_id").change(function(){
                  var str = '';
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