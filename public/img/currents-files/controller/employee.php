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
class Employee extends Controller {
	function __construct() {
		parent::__construct ();
		$this->employeeModel = $this->loadModel ( 'employeeModel' );
	}
	public function index() {
		$regions = $this->employeeModel->getAllRegions ();
		require APP . 'view/_templates/header.php';
		require APP . 'view/employee/index.php';
		require APP . 'view/_templates/footer.php';
	}
	public function getEmployee() {
		$empId = $_REQUEST ['refKey'];
		$employee = $this->employeeModel->getEmployee ( $empId );
		$employees = $employee->employee_name . "  -  " . $employee->employee_id;
		// print_r($employees);exit;
		echo json_encode ( $employees );
		exit ();
	}
	public function getStoreByRegionId() {
		$regionId = $_REQUEST ['region_id'];
		$stores = $this->employeeModel->getAllStoresByRegionId ( $regionId );
		echo json_encode ( $stores );
		exit ();
	}
	public function getEmployeesByStoreId() {
		$storeId = $_REQUEST ['store_id'];
		$stores = $this->employeeModel->getEmployeesByStoreId ( $storeId );
		echo json_encode ( $stores );
		// exit ();
	}
	public function getAllEmployees() {
		if (isset ( $_REQUEST ['employeeId'] ) && $_REQUEST ['employeeId'] != "") {
			$employeeIdRef = $_REQUEST ['employeeId'];
		} else {
			$employeeIdRef = "";
		}
		
		if (isset ( $_REQUEST ['region_id'] ) && $_REQUEST ['region_id'] != "") {
			$regionId = $_REQUEST ['region_id']; // print_r($regionId);exit;
		} else {
			$regionId = "";
		}
		if (isset ( $_REQUEST ['store_id'] ) && $_REQUEST ['store_id'] != "") {
			$storeId = $_REQUEST ['store_id'];
		} else {
			$storeId = "";
		}
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
		$dataArray = "";
		$totalRecordsFiltered = $this->employeeModel->getAllEmployees ( $regionId, $storeId, $employeeIdRef, $start_from, $noOfRecordPerPage, $searchKey, $orderStr, $userId );
		// print_r($totalRecordsFiltered);exit;
		if ($totalRecordsFiltered != "") {
			foreach ( $totalRecordsFiltered as $totalRecords ) {
				if ($totalRecords ['status'] == '0') {
					$totalRecords ['status'] = "Disabled";
					$totalRecords ['icon'] = $totalRecords ['employee_id'] . "-" . "fa-toggle-off";
				} else {
					$totalRecords ['status'] = "Enabled";
					$totalRecords ['icon'] = $totalRecords ['employee_id'] . "-" . "fa-toggle-on";
				}
				$dataArray [] = $totalRecords;
			}
		}
		
		$results ['recordsTotal'] = ( int ) count ( $this->employeeModel->getEmployeesCount ( $regionId, $storeId, $searchKey, $userId ) );
		$results ['recordsFiltered'] = ( int ) count ( $this->employeeModel->getEmployeesCount ( $regionId, $storeId, $searchKey, $userId ) );
		$results ['data'] = $dataArray;
		// echo "<pre/>";
		// print_r($results ['recordsFiltered']);exit;
		
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
	function update() {
		$message = "";
		$employee_ref_id = isset ( $_REQUEST ['employee_ref_id'] ) ? (trim ( @$_REQUEST ['employee_ref_id'] )) : "";
		$employeeId = isset ( $_REQUEST ['employee_id'] ) ? (trim ( @$_REQUEST ['employee_id'] )) : "";
		$employeeName = isset ( $_REQUEST ['employee_name'] ) ? (trim ( @$_REQUEST ['employee_name'] )) : "";
		$dob = isset ( $_REQUEST ['dob'] ) ? (trim ( @$_REQUEST ['dob'] )) : "";
		$doj = isset ( $_REQUEST ['doj'] ) ? (trim ( @$_REQUEST ['doj'] )) : "";
		$designation_id = isset ( $_REQUEST ['designation_id'] ) ? (trim ( @$_REQUEST ['designation_id'] )) : "";
		$role_id = isset ( $_REQUEST ['role_id'] ) ? (trim ( @$_REQUEST ['role_id'] )) : "";
		$region_id = isset ( $_REQUEST ['region_id'] ) ? (trim ( @$_REQUEST ['region_id'] )) : "";
		$userId = $_SESSION ['sess_user_id'];
		// print_r($_POST);
		// print_r($store_id);exit;
		// print_r ( $store_id );
		// exit ();
		$store_id = isset ( $_REQUEST ['store_id'] ) ? (trim ( @$_REQUEST ['store_id'] )) : "";
		if (isset ( $_POST ['submit'] )) {
			$existemployee = $this->employeeModel->isExistEmployeeForUpdate ( $employee_ref_id, $employeeId );
		   
			if ($existemployee > 0) {
				$message = "This Employee Already exists!";
				$_SESSION ['message'] = $message;
				header ( "Location:/employee/update/?refKey=".$employee_ref_id."");
				exit ();
			} else {
				$res = $this->employeeModel->updateEmployeeDetails ( $employeeId, $employeeName, $dob, $doj, $designation_id, $role_id, $region_id, $store_id, $userId, $employee_ref_id );
				$updateLogin = $this->employeeModel->updateLogin ( $employee_ref_id, $employeeId );
				if ($res) {
					$message = "Employee Details Updated successfully!";
					$_SESSION ['message'] = $message;
					header ( 'Location: /employee/index' );
					exit ();
				} else {
					$message = "Technical Error!";
				}
			}
		}
		$empId = isset ( $_REQUEST ['refKey'] ) ? (trim ( @$_REQUEST ['refKey'] )) : "";
		$employeeDetails = $this->employeeModel->getEmployeeDetailsById ( $empId );
		$storeDetails = $this->employeeModel->getStoresByEmployeeId ( $empId );
		$designations = $this->employeeModel->getAllDesignations ();
		$roles = $this->employeeModel->getAllRoles ();
		$regions = $this->employeeModel->getAllRegions ();
		$stores = $this->employeeModel->getAllStoresByRegionId ( $employeeDetails->store_region_id );
		require APP . 'view/_templates/header.php';
		require APP . 'view/employee/history.php';
		require APP . 'view/_templates/footer.php';
	}
	public function add() {
		
		// if(!empty($_SESSION['sess_user_id']) || $_SESSION['sess_user_id']=""){ header("Location:/login/index"); exit();}
		$message = '';
		$employeeArray = array ();
		// print_r($_POST);exit;
		$employeeArray ['employee_id'] = isset ( $_REQUEST ['employee_id'] ) ? (trim ( @$_REQUEST ['employee_id'] )) : "";
		$employeeArray ['employee_name'] = isset ( $_REQUEST ['employee_name'] ) ? (trim ( @$_REQUEST ['employee_name'] )) : "";
		$employeeArray ['dob'] = isset ( $_REQUEST ['dob'] ) ? (trim ( @$_REQUEST ['dob'] )) : "";
		$employeeArray ['doj'] = isset ( $_REQUEST ['doj'] ) ? (trim ( @$_REQUEST ['doj'] )) : "";
		$employeeArray ['designation_id'] = isset ( $_REQUEST ['designation_id'] ) ? (trim ( @$_REQUEST ['designation_id'] )) : "";
		$employeeArray ['role_id'] = isset ( $_REQUEST ['role_id'] ) ? (trim ( @$_REQUEST ['role_id'] )) : "";
		$employeeArray ['region_id'] = isset ( $_REQUEST ['region_id'] ) ? (trim ( @$_REQUEST ['region_id'] )) : "";
		$employeeArray ['password'] = isset ( $_REQUEST ['password'] ) ? (trim ( @$_REQUEST ['password'] )) : "";
		// print_r($employeeArray ['store_id']);exit;
		if (isset ( $_POST ['submit'] )) {
			$existemployee = $this->employeeModel->isExistEmployee ( $employeeArray ['employee_id'] );
			if ($existemployee > 0) {
				$message = "This Employee Alreay exists!";
				$_SESSION ['message'] = $message;
				header ( 'Location:/employee/add' );
				exit ();
			} else {
				
				$lastId = $this->employeeModel->save ( $employeeArray );
				// print_r($lastId);exit;
				// $lastId='117';
				
				$storeId = $_REQUEST ['store_id'];
				$employeeArray ['store_id'] = $storeId;
				// print_r($storeId);exit;
				$this->employeeModel->updateRelationEmployee ( $employeeArray, $lastId );
				if ($lastId) {
					$message = "Employee successfully added!";
					$_SESSION ['message'] = $message;
					header ( 'Location:/employee/add' );
					exit ();
				} else {
					$message = "Unable to add the Customer Data!";
				}
			}
		}
		$designations = $this->employeeModel->getAllDesignations ();
		$roles = $this->employeeModel->getAllRoles ();
		$regions = $this->employeeModel->getAllRegions ();
		// print_r($regions);
		// load views
		require APP . 'view/_templates/header.php';
		require APP . 'view/employee/add.php';
		require APP . 'view/_templates/footer.php';
	}
	public function getEmployeeDetails() {
		$empId = isset ( $_REQUEST ['refKey'] ) ? (trim ( @$_REQUEST ['refKey'] )) : "";
		$employeeDetails = $this->employeeModel->getEmployeeDetailsById ( $empId );
		$storeDetails = $this->employeeModel->getStoresByEmployeeId ( $empId );
		$designations = $this->employeeModel->getAllDesignations ();
		$roles = $this->employeeModel->getAllRoles ();
		$regions = $this->employeeModel->getAllRegions ();
		$stores = $this->employeeModel->getAllStoresByRegionId ( $employeeDetails->store_region_id );
		// print_r($storeDetails);exit;
		if (empty ( $empId )) {
			header ( 'Location: /employee/index' );
			exit ();
		}
		require APP . 'view/_templates/header.php';
		require APP . 'view/employee/history.php';
		require APP . 'view/_templates/footer.php';
	}
	public function getStatusChange() {
		$empId = isset ( $_REQUEST ['refKey'] ) ? (trim ( @$_REQUEST ['refKey'] )) : "";
		if (empty ( $empId )) {
			header ( 'Location: /employee/index' );
			exit ();
		}
		$statusChange = $this->employeeModel->getStatusChange ( $empId );
		if ($statusChange) {
			header ( 'Location: /employee/index' );
		}
	}
	public function passwordChange() {
		$newpass = isset ( $_REQUEST ['newpass'] ) ? (trim ( @$_REQUEST ['newpass'] )) : "";
		$conpass = isset ( $_REQUEST ['conpass'] ) ? (trim ( @$_REQUEST ['conpass'] )) : "";
		$id = isset ( $_REQUEST ['id'] ) ? (trim ( @$_REQUEST ['id'] )) : "";
		$newhash = hash ( 'sha256', '824' . hash ( 'sha256', $newpass ) );
		
		if ($response = $this->employeeModel->passwordChange ( $id, $newhash )) {
			$success = "Password Changed Succesfully!";
			echo $success;
			exit ();
		} else {
			$success = "System Error! Try Again!";
		}
		return $success;
	}
}
