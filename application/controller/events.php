<?php
/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Events extends Controller {
	function __construct() {
		parent::__construct ();
		$this->loadingModel = $this->loadModel ( 'eventsModel' );
	}
	
	/**
	 * PAGE: index
	 * Loading the Event Index Page
	 */
	public function index() {
		// if($_SESSION['user_type'] != "admin"){ header("Location:/login/index"); exit();}
		// load views
		require APP . 'view/_templates/header.php';
		require APP . 'view/events/index.php';
		require APP . 'view/_templates/footer.php';
	}
	
	/**
	 * Function for Event Datatable
	 */
	public function getAllEvents() {
		// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
		$start = isset ( $_REQUEST ['start'] ) ? (trim ( @$_REQUEST ['start'] )) : "";
		$length = isset ( $_REQUEST ['length'] ) ? (trim ( @$_REQUEST ['length'] )) : "";
		$draw = isset ( $_REQUEST ['draw'] ) ? (trim ( @$_REQUEST ['draw'] )) : "";
		$searchKey = isset ( $_REQUEST ['search'] ['value'] ) ? (trim ( @$_REQUEST ['search'] ['value'] )) : "";
		
		$columns = isset ( $_REQUEST ['columns'] ) ? ($_REQUEST ['columns']) : "";
		$orderColumnDetails = isset ( $_REQUEST ['columns'] ) ? ($_REQUEST ['order']) : "";
		
		$orderStr = "";
		if ($columns && $orderColumnDetails) {
			$orderColumnName = $columns [$orderColumnDetails [0] ['column']] ['data'];
			$orderBy = $orderColumnDetails [0] ['dir'];
			
			$orderStr = " ORDER BY " . $orderColumnName . " " . $orderBy . " ";
		}
		
		if (isset ( $start ) && $length != - 1) {
			$start_from = intval ( $start );
			$noOfRecordPerPage = intval ( $length );
		} else {
			$start_from = 0;
			$noOfRecordPerPage = 0;
		}
		
		// echo $start_from." -- ".$noOfRecordPerPage;
		$results = array ();
		$results ['draw'] = $draw;
		$results ['recordsTotal'] = ( int ) $this->loadingModel->getAllEventsCount ()->total;
		$totalRecordsFiltered = $this->loadingModel->getAllEvents ( $start_from, $noOfRecordPerPage, $searchKey, $orderStr );
		$results ['recordsFiltered'] = ( int ) $this->loadingModel->getAllEventsCount ()->total; // count($totalRecordsFiltered);
		$results ['data'] = $totalRecordsFiltered;
		// echo "<pre/>";
		// print_r(json_encode($totalRecordsFiltered));
		
		echo json_encode ( $results );
		exit ();
	}
	/**
	 * function to add the event
	 */
	public function add() {
		$message = '';
		
		$category = isset ( $_REQUEST ['category'] ) ? (trim ( @$_REQUEST ['category'] )) : "";
		$subject = isset ( $_REQUEST ['subject'] ) ? (trim ( @$_REQUEST ['subject'] )) : "";
		$season_id = isset ( $_REQUEST ['season_id'] ) ? (trim ( @$_REQUEST ['season_id'] )) : "";
		$month = isset ( $_REQUEST ['month'] ) ? (trim ( @$_REQUEST ['month'] )) : "";
		$state_id = isset ( $_REQUEST ['state_id'] ) ? (trim ( @$_REQUEST ['state_id'] )) : "";
		$region_id = isset ( $_REQUEST ['region_id'] ) ? (trim ( @$_REQUEST ['region_id'] )) : "";
		$descrition = isset ( $_REQUEST ['description'] ) ? (trim ( @$_REQUEST ['description'] )) : "";
		$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
		$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
		$address = isset ( $_REQUEST ['address'] ) ? (trim ( @$_REQUEST ['address'] )) : "";
		$comments = isset ( $_REQUEST ['comments'] ) ? (trim ( @$_REQUEST ['comments'] )) : "";
		
		if (isset ( $_POST ['submit'] )) {
			$lastId = $this->loadingModel->add ( $category, $subject, $season_id, $month, $state_id, $region_id, $descrition, $from, $to, $address, $comments );
			
			if ($lastId) {
				$message = "Event successfully added!";
				header ( 'Location:/events/index' );
				exit ();
			} else {
				$message = "Unable to add the Event!";
			}
		}
		
		$categories = $this->loadingModel->getAllCategories ();
		$seasons = $this->loadingModel->getAllSeasons ();
		$states = $this->loadingModel->getAllStates ();
		$tableValues = $this->loadingModel->getAllFiles ();
		// load views
		require APP . 'view/_templates/header.php';
		require APP . 'view/events/add.php';
		require APP . 'view/_templates/footer.php';
	}
	/**
	 * function to get the Month By season Id
	 */
	public function getAllMonthsBySeasonId() {
		$refKey = isset ( $_REQUEST ['refKey'] ) ? trim ( $_REQUEST ['refKey'] ) : "";
		$months = $this->loadingModel->getAllMonthsBySeasonId ( $refKey );
		echo json_encode ( $months );
	}
	/**
	 * function to get the Region By State
	 */
	public function getAllRegionByStateId() {
		$refKey = isset ( $_REQUEST ['refKey'] ) ? trim ( $_REQUEST ['refKey'] ) : "";
		$regions = $this->loadingModel->getAllRegionByStateId ( $refKey );
		echo json_encode ( $regions );
	}
	/**
	 * Function to update the Event
	 */
	public function edit() {
		
		// if($_SESSION['user_type'] != "admin"){ header("Location:/login/index"); exit();}
		$refKey = isset ( $_REQUEST ['refKey'] ) ? trim ( $_REQUEST ['refKey'] ) : "";
		
		if ($refKey == "") { // if key is identified then push this into login. It might be a hack
			header ( 'Location:/login/index' );
		}
		$message = "";
		// print_r($_POST);exit;
		$product_category_id = isset ( $_REQUEST ['product_category_id'] ) ? (trim ( @$_REQUEST ['product_category_id'] )) : "";
		$active_status = isset ( $_REQUEST ['active_status'] ) ? (trim ( @$_REQUEST ['active_status'] )) : "";
		$product_name = isset ( $_REQUEST ['product_name'] ) ? (trim ( @$_REQUEST ['product_name'] )) : "";
		$product_model = isset ( $_REQUEST ['product_model'] ) ? (trim ( @$_REQUEST ['product_model'] )) : "";
		$product_specification = isset ( $_REQUEST ['product_specification'] ) ? (trim ( @$_REQUEST ['product_specification'] )) : "";
		// $product_category_name = isset($_REQUEST['product_category_name'])?(trim(@$_REQUEST['product_category_name'])):"";
		
		if (isset ( $_POST ['submit'] )) {
			if ($this->loadingModel->update ( $product_name, $product_model, $product_specification, $product_category_id, $active_status, $refKey )) {
				$message = "Category successfully updated!";
				header ( 'Location:/products/index' );
				exit ();
			} else {
				$message = "Unable to add the Data!";
			}
		}
		// $categories = $this->loadingModel->getAllCategoriesFromProducts ();
		$event = $this->loadingModel->getEventById ( $refKey );
		$photos = $this->loadingModel->getPhotos ( $refKey );
		$comments = $this->loadingModel->getComments ( $refKey );
		foreach ( $comments as $comment ) {
			$commentArray [] = $comment ['comments'];
		}
		$implode = implode ( ",", $commentArray );
		// load views
		require APP . 'view/_templates/header.php';
		require APP . 'view/events/edit.php';
		require APP . 'view/_templates/footer.php';
	}
	/**
	 * Function for File Upload
	 */
	public function FileUpload() {
		$fileName = $_FILES ['file'] ['name'];
		$string = $fileName [0];
		$size = $_FILES ['file'] ['size'];
		$imageName = $fileName;
		$type = $_FILES ['file'] ['type'];
		$date = date ( 'Y:M:D' );
		$target_dir = getcwd () . "/uploads/";
		$target_file = $target_dir . basename ( $_FILES ["file"] ["name"] );
		if (! $target_dir) {
			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file ( $_FILES ["file"] ["tmp_name"], $target_file )) {
				$res = $this->loadingModel->fileUpload ( $fileName, $size, $target_dir, $type );
				echo $res;
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	/**
	 * Function for adding comment
	 */
	public function addComment() {
		$refKey = isset ( $_POST ['refKey'] ) ? trim ( $_POST ['refKey'] ) : "";
		
		$comment = isset ( $_POST ['comment'] ) ? trim ( $_POST ['comment'] ) : "";
		print_r ( $comment );
		$addComment = $this->loadingModel->addComment ( $refKey, $comment );
		// $categories = $this->loadingModel->getAllCategoriesFromProducts ();
		$event = $this->loadingModel->getEventById ( $refKey );
		$photos = $this->loadingModel->getPhotos ( $refKey );
		
		// load views
		require APP . 'view/_templates/header.php';
		require APP . 'view/events/edit.php';
		require APP . 'view/_templates/footer.php';
	}
	/**
	 * Function to get the single event
	 */
	public function getEventById() {
		$refKey = isset ( $_REQUEST ['refKey'] ) ? trim ( $_REQUEST ['refKey'] ) : "";
		$event = $this->loadingModel->getEventById ( $refKey );
		echo json_encode ( $event );
	}
	public function register() {
		print_r("sdfsd");exit;
		//require APP . 'view/login/register.php';
	}
}
