<div class="page-title">

	<div class="title-env">
		<h1 class="title">Add Event</h1>
		<p class="description">Interface for adding new Event.</p>
	</div>

	<div class="breadcrumb-env">

		<ol class="breadcrumb bc-1">
			<li><a href="/catalogs/index"><i class="fa-home"></i>All Events</a></li>

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
						<label class="control-label">What</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="category"
							id="product_name" value="" data-validate="required"
							data-message-required="Product Name is required."
							placeholder="Enter the Product Name" />
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="product_name"
							id="product_name" value="" data-validate="required"
							data-message-required="Product Name is required."
							placeholder="Enter the Product Name" />
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label">Product Model</label>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="product_model"
							id="product_model" value="" data-validate="required"
							data-message-required="Product Model is required."
							placeholder="Enter the Product Model" />
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label">Product Specification</label>
					</div>
					<div class="col-sm-3">
						<textarea name="product_specification" id="product_specification"
							class="form-control"
							placeholder="Enter the Product Specification"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label">Select Category</label>
					</div>
					<div class="col-sm-3">
						<select class="form-control" data-validate="required"
							name="product_category_id" id="product_category_id">
							<option value="" selected>Select the Category</option>
                                        <?php foreach($categories as $category){?>
                                            <option
								value="<?php echo $category['product_category_id'];?>"><?php echo $category['product_category_name'];?></option>
                                        <?php }?>
									</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<label class="control-label">Status</label>
					</div>
					<div class="col-sm-3">
						<input type="radio" name="active_status" value="1" checked
							class="cbr cbr-info form-control "><label class="control-label">Enable</label>&nbsp;
						<input type="radio" name="active_status" value="0"
							class="cbr cbr-info form-control "><label class="control-label">Disable</label>
					</div>
				</div>

			</div>
		</div>

</form>