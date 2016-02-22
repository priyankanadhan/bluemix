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
}
