<div class="page-title">
			
				<div class="title-env">
					<h1 class="title">Product List</h1>
					<p class="description">Product Management page.</p>
                    
				</div>
			
					<div class="breadcrumb-env">
			
								<ol class="breadcrumb bc-1" >
									<li>
							<a href="#"><i class="fa-home"></i>Products</a>
						</li>
								
								</ol>
                                <a href="/products/add" class="btn btn-blue btn-lg">Add</a>
						
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
                                            {"data":"product_name"},
											{"data":"product_model"},
											{"data":"product_category_name"},
                                            {"data":"active_status_str"},                                            
                                            {
                                                "targets": 0,
                                                "data": "product_id",
                                                "render": function ( data, type, full, meta ) {
                                                             var str = '<span class="action-links">&nbsp;&nbsp;';
                                                                  str +='<a href="/products/edit?refKey='+data+'"><i class="linecons-pencil"></i></a>&nbsp;&nbsp;';       
                                                             return str;
                                                            }
                                            } 
                                          ]
						});
					});
					</script>
					
					<table id="catalogsListGrid" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
                                <th>Name</th>
                                <th>Model</th>
                                <th>category Name</th>
								<th>Status</th>
                                <th>Actions</th>								
							</tr>
						</thead>					
						<tfoot>
								<th>Name</th>
                                <th>Model</th>
                                <th>category Name</th>
								<th>Status</th>
                                <th>Actions</th>
						</tfoot>
					
						<tbody>
						
						</tbody>
					</table>
					
				</div>
			</div>
			
				</div>
			
			</div>     
            
            	<!-- Modal 7 (Ajax Modal)-->
	<div class="modal fade" id="modal-7">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Loading...</h4>
				</div>
				
				<div class="modal-body">
                    <div class="row">
						<div class="col-md-4" style="text-align:center;">							
                            <span class="product-content-image"></span>
                        </div>
                    </div>
                    <div class="row">
						<div class="col-md-4">							
							<ul class="list-unstyled line-height-default">
                                <li><b>Name:</b>
                                <span class="pull-right ajax-content-name" >Loading...</span>
                                </li>
                            </ul>							
						</div>
						
						<div class="col-md-4">
							<ul class="list-unstyled line-height-default">
                                <li><b>Case Type:</b>
                                <span class="pull-right ajax-content-casetype" >Loading...</span>
                                </li>
                            </ul>							
						
						</div>
                        <div class="col-md-4">
							<ul class="list-unstyled line-height-default">
                                <li><b>Strap Type:</b>
                                <span class="pull-right ajax-content-straptype" >Loading...</span>
                                </li>
                            </ul>							
						
						</div>
					</div>          
                    <div class="row">
						<div class="col-md-4">							
							<ul class="list-unstyled line-height-default">
                                <li><b>Dial:</b>
                                <span class="pull-right ajax-content-dial" >Loading...</span>
                                </li>
                            </ul>							
						</div>
						
						<div class="col-md-4">
							<ul class="list-unstyled line-height-default">
                                <li><b>Movement:</b>
                                <span class="pull-right ajax-content-movement" >Loading...</span>
                                </li>
                            </ul>							
						
						</div>
                        <div class="col-md-4">
							<ul class="list-unstyled line-height-default">
                                <li><b>Crown:</b>
                                <span class="pull-right ajax-content-crown" >Loading...</span>
                                </li>
                            </ul>							
						
						</div>
					</div>
                    <div class="row">
						<div class="col-md-4">							
							<ul class="list-unstyled line-height-default">
                                <li><b>Hands:</b>
                                <span class="pull-right ajax-content-hands" >Loading...</span>
                                </li>
                            </ul>							
						</div>
						
						<div class="col-md-4">
							<ul class="list-unstyled line-height-default">
                                <li><b>Others</b>:
                                <span class="pull-right ajax-content-others" >Loading...</span>
                                </li>
                            </ul>							
						
						</div>
                        <div class="col-md-4">
							<ul class="list-unstyled line-height-default">
                                <li><b>Category:</b>
                                <span class="pull-right ajax-content-productname" >Loading...</span>
                                </li>
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