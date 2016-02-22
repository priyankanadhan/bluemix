<?php

/**
 * Class Songs
 * This is a demo class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Login extends Controller {
	function __construct() {
		parent::__construct ();
		$this->loingModel = $this->loadModel ( 'loginModel' );
	}
	/**
	 * PAGE: index
	 * This method handles what happens when you move to http://yourproject/songs/index
	 */
	public function index() {
		
		// session_destroy();
		$success = true;
		// echo "dsfdsf";exit;
		$username = isset ( $_REQUEST ['username'] ) ? (trim ( @$_REQUEST ['username'] )) : "";
		$password = isset ( $_REQUEST ['passwd'] ) ? (trim ( @$_REQUEST ['passwd'] )) : "";
		
		if ($username && $password) {
			$userData = $this->loingModel->getLogin ( $username );
			
			if ($userData) {
			
				$hash = hash ( 'sha256', $userData->salt . hash ( 'sha256', $password ) );
				
				if ($hash == $userData->password) // Incorrect password. So, redirect to login_form again.
{
	
					$userFullDetails = $this->loingModel->getUserDetails ( $userData->id );
					if ($userFullDetails) {
						session_regenerate_id ();
						$_SESSION ['sess_user_id'] = $userFullDetails->id;
						$_SESSION ['sess_username'] = $userFullDetails->login;
						$_SESSION ['email'] = $userFullDetails->email;
						session_write_close ();
						header ( 'Location: /events/index' );
					} else {
						$success = false;
					}
				} else {
					$success = false;
				}
			} else {
				$success = false;
			}
		}
		
		// print_r($_REQUEST);
		// getting all songs and amount of songs
		// $songs = $this->songsModel->getAllSongs();
		// $amount_of_songs = $this->songsModel->getAmountOfSongs();
		
		// load views. within the views we can echo out $songs and $amount_of_songs easily
		// require APP . 'view/_templates/login.php';
		require APP . 'view/login/login.php';
		// require APP . 'view/_templates/footer.php';
	}
	public function logout() {
		session_destroy ();
		header ( 'Location: /' );
	}
	public function changepassword() {
		$success = "";
		$username = isset ( $_SESSION ['sess_username'] ) ? (trim ( @$_SESSION ['sess_username'] )) : "";
		$password = isset ( $_REQUEST ['passwd'] ) ? (trim ( @$_REQUEST ['passwd'] )) : "";
		$newpassword = isset ( $_REQUEST ['newpasswd'] ) ? (trim ( @$_REQUEST ['newpasswd'] )) : "";
		$newConfirmPassword = isset ( $_REQUEST ['confirm_newpasswd'] ) ? (trim ( @$_REQUEST ['confirm_newpasswd'] )) : "";
		
		if ($username && $password) {
			$userData = $this->loingModel->getLogin ( $username );
			
			if ($userData && ($newpassword == $newConfirmPassword)) {
				$hash = hash ( 'sha256', $userData->salt . hash ( 'sha256', $password ) );
				
				if ($hash == $userData->password) // Incorrect password. So, redirect to login_form again.
{
					$newhash = hash ( 'sha256', $userData->salt . hash ( 'sha256', $newpassword ) );
					
					if ($response = $this->loingModel->changePassword ( $username, $newhash )) {
						$success = "Password Changed Succesfully!";
					} else {
						$success = "System Error! Try Again!";
					}
				} else {
					$success = "Old Password is Wrong!";
				}
			} else {
				$success = "Invalid Data";
			}
			
			if ($newpassword != $newConfirmPassword) {
				$success = "New Passwords doesnot Match!";
			}
		}
		
		require APP . 'view/_templates/header.php';
		require APP . 'view/login/changepassword.php';
		require APP . 'view/_templates/footer.php';
	}
	public function dashboard() {
		$ref_id = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
		if (isset ( $_REQUEST ['lead_status'] )) {
			
			$total = $this->loingModel->getAllProductsCount ( $ref_id )->total;
			$mac_product_id = $this->loingModel->specificMacProductCount ( $ref_id );
			$ipad_product_id = $this->loingModel->specificIpadProductCount ( $ref_id );
			$iphone_product_id = $this->loingModel->specificIphoneProductCount ( $ref_id );
			$ipod_product_id = $this->loingModel->specificIpodProductCount ( $ref_id );
			$total_div = '<div class="xe-widget xe-counter" data-count=".data" data-from="0"
				data-to=' . $total . ' data-duration="2">
				<div class="xe-icon">
				<i class="fa-smile-o"></i>
				</div>
				<div class="xe-label">
				<strong class="num" style="text-align: center;">Lead</strong>
				<div class="data" style="text-align: center;">' . $total . '</div>
				</div>
				</div>';
			$mac_div = '<div class="xe-widget xe-counter-block" data-count=".num"
					data-from="0" data-to=' . $mac_product_id->mac_product_id . '
					data-duration="2">
					<div class="xe-upper">
		
					<div class="xe-icon">
					<i class="linecons-desktop"></i>
					</div>
					<div class="xe-label">
					<strong class="num">' . $mac_product_id->mac_product_id . '</strong> <span><b>Mac</b></span>
					</div>
		
					</div>
					<div class="xe-lower" style="text-align: center;">
					<div class="border"></div>
		
					<span>North</span> <strong class="num">' . $mac_product_id->north_region_id . '</strong>
						</div>
						<div class="xe-lower" style="text-align: center;">
							<div class="border"></div>
		
							<span>South</span> <strong class="num">' . $mac_product_id->south_region_id . '</strong>
						</div>
						<div class="xe-lower" style="text-align: center;">
							<div class="border"></div>
		
							<span>East</span> <strong class="num">' . $mac_product_id->east_region_id . '</strong>
						</div>
					</div>';
			$ipad_div = '<div class="xe-widget xe-counter-block xe-counter-block-purple"
			data-count=".num" data-from="0"
			data-to=' . $ipad_product_id->ipad_product_id . '
			data-duration="3">
			<div class="xe-upper">
			
				<div class="xe-icon">
					<i class="linecons-camera"></i>
				</div>
				<div class="xe-label">
					<strong class="num">' . $ipad_product_id->ipad_product_id . '</strong> <span><b>iPad</b></span>
				</div>
			
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
			
				<span>North</span> <strong class="num">' . $ipad_product_id->north_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
			
				<span>South</span> <strong class="num">' . $ipad_product_id->south_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
			
				<span>East</span> <strong class="num">' . $ipad_product_id->east_region_id . '</strong>
			</div>
		</div>';
			$iphone_div = '
		<div class="xe-widget xe-counter-block xe-counter-block-blue"
			data-count=".num" data-from="0"
			data-to=' . $iphone_product_id->iphone_product_id . '
			data-duration="4" data-easing="false">
			<div class="xe-upper">
			
				<div class="xe-icon">
					<i class="linecons-mobile"></i>
				</div>
				<div class="xe-label">
					<strong class="num">' . $iphone_product_id->iphone_product_id . '</strong> <span><b>iPhone</b></span>
				</div>
			
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>North</span> <strong class="num">' . $iphone_product_id->north_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>South</span> <strong class="num">' . $iphone_product_id->south_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>East</span> <strong class="num">' . $iphone_product_id->east_region_id . '</strong>
			</div>
		</div>';
			$ipod_div = '
		<div class="xe-widget xe-counter-block xe-counter-block-orange"
			data-count=".num" data-from="0"
			data-to=' . $ipod_product_id->ipod_product_id . '
			data-duration="4" data-easing="false">
			<div class="xe-upper">
			
				<div class="xe-icon">
					<i class="fa-life-ring"></i>
				</div>
				<div class="xe-label">
					<strong class="num">' . $ipod_product_id->ipod_product_id . '</strong> <span><b>iPod</b></span>
				</div>
			
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>North</span> <strong class="num">' . $ipod_product_id->north_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>South</span> <strong class="num">' . $ipod_product_id->south_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>East</span> <strong class="num">' . $ipod_product_id->east_region_id . '</strong>
			</div>
		</div>';
			// print_r($mac_product_id->mac_product_id);exit;
			$mergeArray = array (
					"total" => $total_div,
					"mac_div" => $mac_div,
					"ipad_div" => $ipad_div,
					"iphone_div" => $iphone_div,
					"ipod_div" => $ipod_div 
			);
			echo json_encode ( $mergeArray );
		} else {
			$ref_id = "open";
			$total = $this->loingModel->getAllProductsCount ( $ref_id )->total;
			$mac_product_id = $this->loingModel->specificMacProductCount ( $ref_id );
			$ipad_product_id = $this->loingModel->specificIpadProductCount ( $ref_id );
			$iphone_product_id = $this->loingModel->specificIphoneProductCount ( $ref_id );
			$ipod_product_id = $this->loingModel->specificIpodProductCount ( $ref_id );
			$total_div = '<div class="xe-widget xe-counter" data-count=".data" data-from="0"
				data-to=' . $total . ' data-duration="2" id="total">
				<div class="xe-icon">
				<i class="fa-smile-o"></i>
				</div>
				<div class="xe-label">
				<strong class="num" style="text-align: center;">Lead</strong>
				<div class="data" style="text-align: center;">0</div>
				</div>
				</div>';
			$mac_div = '<div class="xe-widget xe-counter-block" data-count=".num"
					data-from="0" data-to=' . $mac_product_id->mac_product_id . '
					data-duration="2">
					<div class="xe-upper">
			
					<div class="xe-icon">
					<i class="linecons-desktop"></i>
					</div>
					<div class="xe-label">
					<strong class="num">0</strong> <span><b>Mac</b></span>
					</div>
			
					</div>
					<div class="xe-lower" style="text-align: center;">
					<div class="border"></div>
			
					<span>North</span> <strong class="num">' . $mac_product_id->north_region_id . '</strong>
						</div>
						<div class="xe-lower" style="text-align: center;">
							<div class="border"></div>
			
							<span>South</span> <strong class="num">' . $mac_product_id->south_region_id . '</strong>
						</div>
						<div class="xe-lower" style="text-align: center;">
							<div class="border"></div>
			
							<span>East</span> <strong class="num">' . $mac_product_id->east_region_id . '</strong>
						</div>
					</div>';
			$ipad_div = '<div class="xe-widget xe-counter-block xe-counter-block-purple"
			data-count=".num" data-from="0"
			data-to=' . $ipad_product_id->ipad_product_id . '
			data-duration="3">
			<div class="xe-upper">

				<div class="xe-icon">
					<i class="linecons-camera"></i>
				</div>
				<div class="xe-label">
					<strong class="num">0</strong> <span><b>iPad</b></span>
				</div>

			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>

				<span>North</span> <strong class="num">' . $ipad_product_id->north_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>

				<span>South</span> <strong class="num">' . $ipad_product_id->south_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>

				<span>East</span> <strong class="num">' . $ipad_product_id->east_region_id . '</strong>
			</div>
		</div>';
			$ipone_div = '
		<div class="xe-widget xe-counter-block xe-counter-block-blue"
			data-count=".num" data-from="0"
			data-to=' . $iphone_product_id->iphone_product_id . '
			data-duration="4" data-easing="false">
			<div class="xe-upper">

				<div class="xe-icon">
					<i class="linecons-mobile"></i>
				</div>
				<div class="xe-label">
					<strong class="num">0</strong> <span><b>iPhone</b></span>
				</div>

			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>North</span> <strong class="num">' . $iphone_product_id->north_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>South</span> <strong class="num">' . $iphone_product_id->south_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>East</span> <strong class="num">' . $iphone_product_id->east_region_id . '</strong>
			</div>
		</div>';
			$ipod_div = '
		<div class="xe-widget xe-counter-block xe-counter-block-orange"
			data-count=".num" data-from="0"
			data-to=' . $ipod_product_id->ipod_product_id . '
			data-duration="4" data-easing="false">
			<div class="xe-upper">

				<div class="xe-icon">
					<i class="fa-life-ring"></i>
				</div>
				<div class="xe-label">
					<strong class="num">0</strong> <span><b>iPod</b></span>
				</div>

			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>North</span> <strong class="num">' . $ipod_product_id->north_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>South</span> <strong class="num">' . $ipod_product_id->south_region_id . '</strong>
			</div>
			<div class="xe-lower" style="text-align: center;">
				<div class="border"></div>
				<span>East</span> <strong class="num">' . $ipod_product_id->east_region_id . '</strong>
			</div>
		</div>';
			
			require APP . 'view/_templates/header.php';
			require APP . 'view/dashboard/index.php';
			require APP . 'view/_templates/footer.php';
		}
	}
	public function check($permission, $action, $userid) {
		
		// we check the user permissions first
		If (! $this->user_permissions ( $permission, $action, $userid )) {
			return true;
		} else {
			return false;
		}
	}
	public function user_permissions($permission, $action, $userid) {
		$permission = $this->loingModel->user_permissions ( $permission, $action, $userid );
		if ($permission == 1) {
			return true;
		}
	}
	/**
	 * Login action
	 */
	public function appLogin() {
		$inputArray = json_decode ( file_get_contents ( 'php://input' ), true );
		$username = isset ( $inputArray ['username'] ) ? (trim ( @$inputArray ['username'] )) : "";
		$password = isset ( $inputArray ['passwd'] ) ? (trim ( @$inputArray ['passwd'] )) : "";
		
		if ($username && $password) {
			
			$userData = $this->loingModel->getLogin ( $username );
			
			if ($userData) {
				$hash = hash ( 'sha256', $userData->salt . hash ( 'sha256', $password ) );
				if ($hash == $userData->password) {
					$token = $this->loingModel->createToken ( $userData->login_id );
					$userOtherDetails = $this->loingModel->getEmployeeOtherDetails ( $userData->employee_id );
					$roleName = $this->loingModel->getRoleNameByRoleId ( $userOtherDetails->role_id );
					
					echo json_encode ( array (
							"success" => "true",
							"result" => "Login Success",
							"token" => $token,
							"role" => $roleName->role_name,
							"user_name" => $userData->name 
					) );
				} else {
					echo json_encode ( array (
							"success" => "false",
							"result" => "Username or password is invalid" 
					) );
				}
			} else {
				echo json_encode ( array (
						"success" => "false",
						"result" => "Invalid User" 
				) );
			}
		} else {
			echo json_encode ( array (
					"success" => "false",
					"result" => "Please give the username and password" 
			) );
		}
	}
}
