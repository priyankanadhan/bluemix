
<div class="page-title">

	<div class="title-env">
		<h1 class="title">Dashboard</h1>
		<p class="description"></p>

	</div>


</div>
<div class="container">
	<div class="row">
		<div class="col-sm-3" style="margin-left: 35%;" id="total" name="total">
		 <?php if($total_div !=""){
		 	echo $total_div;
		 	
		 }?>
		</div>

		<div class="col-md-3" style="float: right;">
			<select name="lead_status" id="lead_status"
				 class="form-control">
				<option value="open">open</option>
				<option value="closed">closed</option>
				<option value="dead">dead</option>
			</select>
		</div>
	</div>
	<div class="out"></div>
	<script>
	jQuery(document).ready(function(){
		jQuery("#lead_status").change(function(){
    var data=jQuery('#lead_status').val();
	jQuery.ajax({
	type : "post",
	url :"<?php echo URL; ?>dashboard/index/?lead_status=" +data,
	success:function(response){
		var JSONObject = JSON.parse(response);
		jQuery('div #total').html(JSONObject.total);
		jQuery('div #mac_product').html(JSONObject.mac_div);
		jQuery('div #ipad_product').html(JSONObject.ipad_div);
		jQuery('div #iphone_product').html(JSONObject.iphone_div);
		jQuery('div #ipod_product').html(JSONObject.ipod_div);
	}
	});
	});
	});

</script>
	<div class="col-sm-3" id="mac_product">
		<?php if($mac_div != ""){
			echo $mac_div;
		}?>
	</div>

	<div class="col-sm-3" id="ipad_product">

		<?php if($ipad_div != ""){
			echo $ipad_div;
		}?>
	</div>

	<div class="col-sm-3" id="iphone_product">
      <?php if($ipone_div != ""){
			echo $ipone_div;
		}?>

	</div>

	<div class="col-sm-3" id="ipod_product">
    <?php if($ipod_div != ""){
			echo $ipod_div;
		}?>

	</div>

</div>

