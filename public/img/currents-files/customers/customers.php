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
class Customers extends Controller {
	function __construct() {
		parent::__construct ();
		$this->customersModel = $this->loadModel ( 'customersModel' );
	}
	public function index() {
		// if($_SESSION['user_type'] != "admin"){ header("Location:/login/index"); exit();}
		// load views
		$employees = $this->customersModel->getAllEmployees ();
		if ($_SESSION ['role'] == "1") {
			$regions = $this->customersModel->getAllRegions ();
		}
		if ($_SESSION ['role'] == "4") {
			$regionId=$_SESSION['store_region'];
			$stores = $this->customersModel->getAllStoresByRegionId ( $regionId );
		}
		if ($_SESSION ['role'] == "2") {
			$employees = $this->customersModel->getAllEmployeesByStoreId ($_SESSION['store']);
		}
		// print_r($stores);exit;
		require APP . 'view/_templates/header.php';
		require APP . 'view/customers/index.php';
		require APP . 'view/_templates/footer.php';
	}
	public function getStoreByRegionId() {
		$regionId = $_REQUEST ['region_id'];
		$stores = $this->customersModel->getAllStoresByRegionId ( $regionId );
		echo json_encode ( $stores );
		exit ();
	}
	public function getEmployeesByStoreId() {
		$storeId = $_REQUEST ['store_id'];
		$stores = $this->customersModel->getEmployeesByStoreId ( $storeId );
		echo json_encode ( $stores );
		//exit ();
	}
	public function getEmployeeById() {
		$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
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
		$results ['recordsTotal'] = ( int ) $this->customersModel->getCustomersCount ( $searchKey, $userId )->total;
		$totalRecordsFiltered = $this->customersModel->getAllCustomerLeads ( $employee, $start_from, $noOfRecordPerPage, $searchKey, $orderStr, $userId );
		$results ['recordsFiltered'] = ( int ) $this->customersModel->getCustomersCount ( $searchKey, $userId )->total;
		$results ['data'] = $totalRecordsFiltered;
		// echo "<pre/>";
		// print_r(json_encode($totalRecordsFiltered));
		
		echo json_encode ( $results );
		exit ();
	}
	function history() {
		$message="";//print_r($_POST);exit;
		$customersId = isset ( $_REQUEST ['refKey'] ) ? (trim ( @$_REQUEST ['refKey'] )) : "";
		if (empty ( $customersId )) {
			header ( 'Location: /customers/index' );
			exit ();
		}
		$validateResult = $this->customersModel->validateUserAgainstCustomer ( $customersId, $_SESSION ['sess_user_id'] );
		if ($validateResult) {
			$comments = isset ( $_REQUEST ['comments'] ) ? (trim ( @$_REQUEST ['comments'] )) : "";
			$followdate = isset ( $_REQUEST ['followdate'] ) ? (trim ( @$_REQUEST ['followdate'] )) : "";
			$leadStatus = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$customerId = isset ( $_REQUEST ['customerId'] ) ? (trim ( @$_REQUEST ['customerId'] )) : "";
			
			$userId = $_SESSION ['sess_user_id'];
			$response = false;
			
			if ($followdate) {
				$dateArray = explode ( "/", $followdate );
				$datee = $dateArray [2] . "-" . $dateArray [0] . "-" . $dateArray [1];
			} else {
				$datee = "";
			}
			
			// get additional details first time
			$cust_demo = isset ( $_REQUEST ['cust_demo'] ) ? (trim ( @$_REQUEST ['cust_demo'] )) : "";
			$cust_source = isset ( $_REQUEST ['cust_source'] ) ? (trim ( @$_REQUEST ['cust_source'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			if ((! empty ( $cust_demo ) || ! empty ( $cust_source ) || ! empty ( $lead_type )) && (! empty ( $customersId ) && ! empty ( $userId ))) {
				$this->customersModel->updateCustomerAdditional ( $cust_demo, $cust_source, $lead_type, $customersId, $userId );
				
			}
			
			if (! empty ( $comments ) && ! empty ( $leadStatus ) && ! empty ( $customersId ) && ! empty ( $userId )) {
				
				$response = $this->customersModel->addHistory ( $comments, $userId, $customersId, $datee );
				if ($response) {
					$res = $this->customersModel->updateLeadStatus ( $leadStatus, $customersId, $userId, $datee );
					if ($res) {
						$message = "Comments added successfully!";
					    $_SESSION['message'] = $message;
						
						header ( 'Location: /customers/index' );
						exit ();
					} else {
						$message = "Technical Error!";
					}
				} else {
					$message = "Technical Error!";
				}
			}
			
			$totalRecordsFiltered = "";
			$customerdetailsbyid = "";
			if (! empty ( $customersId )) {
				$totalRecordsFiltered = $this->customersModel->getCustomersHistory ( $customersId );
				$customerdetailsbyid = $this->customersModel->getCustomersById ( $customersId );
				//print_r($customerdetailsbyid->subcategoryid);exit;
			}
			
			if($_SESSION['role'] == '1'){
				$mcategories = $this->customersModel->getParentCategories ();
				$subcategories = $this->customersModel->getSubCategoriesById ( $customerdetailsbyid->product_category_id );
				
			}
			require APP . 'view/_templates/header.php';
			require APP . 'view/customers/history.php';
			require APP . 'view/_templates/footer.php';
		} else {
			if($_SESSION['role'] == '1'){
				$mcategories = $this->customersModel->getParentCategories ();
				$subcategories = $this->customersModel->getSubCategoriesById ( $customersId );
				
			}
			require APP . 'view/_templates/header.php';
			require APP . 'view/error/index.php';
			require APP . 'view/_templates/footer.php';
		}
	}
	
	/**
	 * PAGE: exampleone
	 * This method handles what happens when you move to http://yourproject/home/exampleone
	 * The camelCase writing is just for better readability.
	 * The method name is case-insensitive.
	 */
	public function getAllOpenCustomers() {
		$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
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
		$results ['recordsTotal'] = ( int ) $this->customersModel->getCustomersCount ( $searchKey, $userId )->total;
		$totalRecordsFiltered = $this->customersModel->getOpenCustomers ( $start_from, $noOfRecordPerPage, $searchKey, $orderStr, $userId );
		$results ['recordsFiltered'] = ( int ) $this->customersModel->getCustomersCount ( $searchKey, $userId )->total;
		$results ['data'] = $totalRecordsFiltered;
		// echo "<pre/>";
		// print_r(json_encode($totalRecordsFiltered));
		
		echo json_encode ( $results );
		exit ();
	}
	public function getAllCustomerLeads() {
		if (isset ( $_REQUEST ['employeeId'] ) && $_REQUEST ['employeeId'] != "") {
			$employeeId = $_REQUEST ['employeeId'];
			$employee = $this->customersModel->getEmployeeById ( $employeeId );
			foreach ( $employee as $emp ) {
				$employeeIdRef = $emp ['employee_id'];
			}
		} else {
			$employeeIdRef = "";
		}
		
		if ($_SESSION ['role'] == "1") {
			if (isset ( $_REQUEST ['region_id'] ) && $_REQUEST ['region_id']!="") {
				$regionId = $_REQUEST ['region_id'];
				$stores = $this->customersModel->getAllStoresByRegionId ( $regionId );
				foreach ( $stores as $store ) {
					$storesIdRef = $store ['store_id'];
				}
			} else {
				$stores = "";
				$storesIdRef = "";
				$regionId = "";
			}
			if(isset ( $_REQUEST ['store_id'] ) && $_REQUEST ['store_id']!=""){
				$storeId = $_REQUEST ['store_id'];
				$stores = $this->customersModel->getAllStoresByRegionId ( $storeId );
				foreach ( $stores as $store ) {
					$storesIdRef = $store ['store_id'];
				}
			}else{
				$storeId="";
			}
		} else {
			$stores = "";
			$regionId = "";
			$storeId="";
		}
		
		if($_SESSION ['role'] == "4"){
			if (isset ( $_REQUEST ['region_id'] ) && $_REQUEST ['region_id']!="") {
				$regionId = $_REQUEST ['region_id'];
				$stores = $this->customersModel->getAllStoresByRegionId ( $regionId );
				foreach ( $stores as $store ) {
					$storesIdRef = $store ['store_id'];
				}
			} else {
				$stores = "";
				$storesIdRef = "";
				$regionId = "";
			}
			if(isset ( $_REQUEST ['store_id'] ) && $_REQUEST ['store_id']!=""){
				$storeId = $_REQUEST ['store_id'];
				$stores = $this->customersModel->getAllStoresByRegionId ( $storeId );
				foreach ( $stores as $store ) {
					$storesIdRef = $store ['store_id'];
				}
			}else{
				$storeId="";
			}
		}else{
			
		}
		// print_r($employeeId);exit;
		
		$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
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
		
		$totalRecordsFiltered = $this->customersModel->getAllCustomerLeads ( $regionId,$storeId, $employeeIdRef, $start_from, $noOfRecordPerPage, $searchKey, $orderStr, $userId );
		//print_r(count($totalRecordsFiltered));exit;
		$results ['recordsTotal'] = ( int ) count($this->customersModel->getCustomersCount ( $regionId,$storeId,$employeeIdRef,$searchKey, $userId ));
		$results ['recordsFiltered'] = ( int ) count($this->customersModel->getCustomersCount ( $regionId,$storeId,$employeeIdRef,$searchKey, $userId ));
		//$results ['recordsFiltered'] = ( int ) $this->customersModel->getCustomersCount ( $searchKey, $userId )->total;
		$results ['data'] = $totalRecordsFiltered;
		// echo "<pre/>";
		// print_r(json_encode($totalRecordsFiltered));
		
		echo json_encode ( $results );
		exit ();
	}
	public function getSubCategories() {
		$refKey = isset ( $_REQUEST ['refKey'] ) ? trim ( $_REQUEST ['refKey'] ) : "";
		$subcategories = $this->customersModel->getSubCategoriesById ( $refKey );
		echo json_encode ( $subcategories );
	}
	public function getCategoryProducts() {
		$refKey = isset ( $_REQUEST ['refKey'] ) ? trim ( $_REQUEST ['refKey'] ) : "";
		$catproducts = $this->customersModel->getCategoryProductsById ( $refKey );
		echo json_encode ( $catproducts );
	}
	public function add() {
		
		// if(!empty($_SESSION['sess_user_id']) || $_SESSION['sess_user_id']=""){ header("Location:/login/index"); exit();}
		$message = '';
		$customerAry = array ();
		$customersId = isset ( $_REQUEST ['refKey'] ) ? (trim ( @$_REQUEST ['refKey'] )) : "";
		$customerAry ['firstname'] = isset ( $_REQUEST ['firstname'] ) ? (trim ( @$_REQUEST ['firstname'] )) : "";
		$customerAry ['lastname'] = "";
		$customerAry ['email'] = isset ( $_REQUEST ['email'] ) ? (trim ( @$_REQUEST ['email'] )) : "";
		$customerAry ['phone'] = isset ( $_REQUEST ['phone'] ) ? (trim ( @$_REQUEST ['phone'] )) : "";
		$customerAry ['comments'] = isset ( $_REQUEST ['comments'] ) ? (trim ( @$_REQUEST ['comments'] )) : "";
		$customerAry ['product_category_id'] = isset ( $_REQUEST ['product_category_id'] ) ? (trim ( @$_REQUEST ['product_category_id'] )) : "";
		$customerAry ['product_subcategory_id'] = isset ( $_REQUEST ['product_subcategory_id'] ) ? (trim ( @$_REQUEST ['product_subcategory_id'] )) : "";
		$customerAry ['product_id'] = isset ( $_REQUEST ['product_id'] ) ? (trim ( @$_REQUEST ['product_id'] )) : "";
		$customerAry ['lead_type'] = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
		if (isset ( $_POST ['submit'] )) {
			$existcustomer = $this->customersModel->isExistOpenCustomer ( $customerAry ['phone'], $customerAry ['product_id'] );
			if ($existcustomer > 0) {
				$message = "This customer Alreay exists!";
				$_SESSION ['message'] = $message;
				header ( 'Location:/customers/add' );
				exit ();
			} else {
				$lastId = $this->customersModel->save ( $customerAry,$customersId );
				
				if ($lastId) {
					$message = "Customer successfully added!";
					$_SESSION ['message'] = $message;
					header ( 'Location:/customers/add' );
					exit ();
				} else {
					$message = "Unable to add the Customer Data!";
				}
			}
		}
		
		$mcategories = $this->customersModel->getParentCategories ();
		// load views
		require APP . 'view/_templates/header.php';
		require APP . 'view/customers/add.php';
		require APP . 'view/_templates/footer.php';
	}
	public function updateCustomerDetailsByAdmin(){
		$customerAry = array ();
		$customersId= isset ( $_REQUEST ['refKey'] ) ? (trim ( @$_REQUEST ['refKey'] )) : "";
		$customerAry ['firstname'] = isset ( $_REQUEST ['firstname'] ) ? (trim ( @$_REQUEST ['firstname'] )) : "";
		$customerAry ['lastname'] = "";
		$customerAry ['email'] = isset ( $_REQUEST ['email'] ) ? (trim ( @$_REQUEST ['email'] )) : "";
		$customerAry ['phone'] = isset ( $_REQUEST ['phone'] ) ? (trim ( @$_REQUEST ['phone'] )) : "";
		$customerAry ['comments'] = isset ( $_REQUEST ['comments'] ) ? (trim ( @$_REQUEST ['comments'] )) : "";
		$customerAry ['product_category_id'] = isset ( $_REQUEST ['product_category_id'] ) ? (trim ( @$_REQUEST ['product_category_id'] )) : "";
		$customerAry ['product_subcategory_id'] = isset ( $_REQUEST ['product_subcategory_id'] ) ? (trim ( @$_REQUEST ['product_subcategory_id'] )) : "";
		$customerAry ['product_id'] = isset ( $_REQUEST ['product_id'] ) ? (trim ( @$_REQUEST ['product_id'] )) : "";
		$customerAry ['lead_type'] = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
		
		if (isset ( $_POST ['submitAdmin'] )) {
			$lastId = $this->customersModel->updateCustomerDetailsByAdmin ( $customerAry,$customersId );
			if ($lastId) {
					$message = "Customer details successfully updated!";
					$_SESSION ['message'] = $message;
					header ( 'Location:/customers/history' );
					exit ();
				} else {
					$message = "Unable to update the Customer Data!";
				}
		}
	}
}
