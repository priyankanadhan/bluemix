<style>
        .loginWrong{
            color:#E81D02;
        }
    </style>
<div class="page-title">
			
				<div class="title-env">
					<h1 class="title">Change Password</h1>
					<p class="description">Interface for Change the password.</p>
				</div>
			
					<div class="breadcrumb-env">
			
								<ol class="breadcrumb bc-1" >
									<li>
							<a href="/customers/index"><i class="fa-home"></i>Home</a>
						</li>
								
							<li class="active">
			
										<strong>Change Password</strong>
								</li>
								</ol>
						
				</div>
				
			</div>
            
            <form method="post" name="product" id="product" class="validate" enctype="multipart/form-data">
				<div class="panel panel-headerless">
					<div class="panel-body">
			
						<div class="member-form-add-header">
							<div class="row">
                                <?php if($success){?>
                                <div class="col-md-4 col-sm-8 pull-left-sm">
                                    <p class="description"><div class="loginWrong"><?php echo $success;?></div></p>											
								</div>
                                <?php }?>
								<div class="col-md-2 col-sm-4 pull-right-sm">
			
									<div class="action-buttons">
                                        <input type="submit" class="btn btn-block btn-secondary" name="submit" value="Submit">
										<!--button type="submit" name="submit" value = "submit" class="btn btn-block btn-secondary">Save Changes</button-->
										<button type="reset" class="btn btn-block btn-gray">Reset to Default</button>
									</div>
			
								</div>
								<!--div class="col-md-10 col-sm-8">
			
									<div class="user-img">
										<img src="<?php //echo URL_LENCO; ?>images/user-4.png" class="img-circle" alt="user-pic" />
									</div>
									<div class="user-name">
										<a href="#">Jack Gates</a>
										<span>Administrator</span>
									</div>
			
								</div-->
							</div>
						</div>		
						<div class="member-form-inputs">                       
							<div class="row">
								<div class="col-sm-2">
									<label class="control-label" for="username">Old Password</label>
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="passwd" id="passwd" value="" data-validate="required" data-message-required="Your Old Password." placeholder="Your Old Password" />
								</div>                                
							</div>			
							
                            <div class="row">
								<div class="col-sm-2">
									<label class="control-label" for="name">New Password</label>
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="newpasswd" id="newpasswd" value="" data-validate="required" data-message-required="Your New Password." placeholder="Your New Password"/>
								</div>                               
							</div>    
							 <div class="row">
								<div class="col-sm-2">
									<label class="control-label" for="name">Confirm New Password</label>
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="confirm_newpasswd" id="confirm_newpasswd" value="" data-validate="required" data-message-required="Confirm New Password." placeholder="Confirm New Password"/>
								</div>                               
							</div>     
                            						
						</div>
			
					</div>
				</div>
			</form>