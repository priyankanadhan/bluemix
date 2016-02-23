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
		require_once dirname ( __FILE__ ) . '/../libs/gplus-lib/vendor/autoload.php';
		$CLIENT_ID = "101191849109-u2evcenu909egqnkgtfi8c81dctjs0bs.apps.googleusercontent.com";
		$CLIENT_SECRET = "11OhXev3elozUKmK9NeBvGL5";
		$REDIRECT_URI = URL."events/index";
		$client = new Google_Client ();
		$client->setClientId ( $CLIENT_ID );
		$client->setClientSecret ( $CLIENT_SECRET );
		$client->setRedirectUri ( $REDIRECT_URI );
		$client->setScopes ( 'email' );
		
		$plus = new Google_Service_Plus ( $client ); // exit;
		                                             // Actual Process
		
		if (isset ( $_REQUEST ['logout'] )) {
			session_unset ();
		}
		if (isset ( $_GET ['code'] )) {
			$client->authenticate ( $_GET ['code'] );
			$_SESSION ['access_token'] = $client->getAccessToken ();
			$redirect = 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['PHP_SELF'];
			header ( 'location:' . filter_var ( $redirect, FILTER_SANITIZE_URL ) );
		}
		if (isset ( $_SESSION ['access_token'] ) && $_SESSION ['access_token']) {
			$client->setAccessToken ( $_SESSION ['access_token'] );
			$me = $plus->people->get ( 'me' );
			$id = $me ['id'];
			$Name = $me ['displayName'];
			$email = $me ['emails'] [0] ['value'];
			$profile_image_url = $me ['image'] ['url'];
			$cover_image_url = $me ['cover'] ['coverPhoto'] ['url'];
			$profile_url = $me ['url'];
		} else {
			$authurl = $client->createAuthUrl ();
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
