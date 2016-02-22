<?php
/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Dashboard extends Controller {
	function __construct() {
		parent::__construct ();
		$this->loadingModel = $this->loadModel ( 'dashboardModel' );
		$this->emploadingModel = $this->loadModel ( 'empdashboardModel' );
		$this->customersModel = $this->loadModel ( 'customersModel' );
	}
	
	/**
	 * PAGE: index
	 * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
	 */
	public function index() {
		// if($_SESSION['user_type'] != "admin"){ header("Location:/login/index"); exit();}
		// load views
		$ref_id = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
		if (isset ( $_REQUEST ['lead_status'] )) {
			
			$total = $this->loadingModel->getAllProductsCount ( $ref_id )->total;
			$mac_product_id = $this->loadingModel->specificMacProductCount ( $ref_id );
			$ipad_product_id = $this->loadingModel->specificIpadProductCount ( $ref_id );
			$iphone_product_id = $this->loadingModel->specificIphoneProductCount ( $ref_id );
			$ipod_product_id = $this->loadingModel->specificIpodProductCount ( $ref_id );
			$total_div = '<div class="xe-widget xe-counter" data-count=".data" data-from="0"
				data-to=' . $total . ' data-duration="1">
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
			data-duration="2">
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
			data-duration="2" data-easing="false">
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
			data-duration="2" data-easing="false">
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
			$total = $this->loadingModel->getAllProductsCount ( $ref_id )->total;
			$mac_product_id = $this->loadingModel->specificMacProductCount ( $ref_id );
			$ipad_product_id = $this->loadingModel->specificIpadProductCount ( $ref_id );
			$iphone_product_id = $this->loadingModel->specificIphoneProductCount ( $ref_id );
			$ipod_product_id = $this->loadingModel->specificIpodProductCount ( $ref_id );
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
	public function getDetails() {
		$total = $this->loadingModel->getAllProductsCount ()->total;
		$mac_product_id = $this->loadingModel->specificMacProductCount ();
		$ipad_product_id = $this->loadingModel->specificIpadProductCount ();
		$iphone_product_id = $this->loadingModel->specificIphoneProductCount ();
		$ipod_product_id = $this->loadingModel->specificIpodProductCount ();
	}
	public function regionWise() {
		$total = $this->loadingModel->getAllProductsCount ()->total;
		$mac_product_id = $this->loadingModel->specificMacProductCount ();
		$ipad_product_id = $this->loadingModel->specificIpadProductCount ();
		$iphone_product_id = $this->loadingModel->specificIphoneProductCount ();
		$ipod_product_id = $this->loadingModel->specificIpodProductCount ();
		require APP . 'view/_templates/header.php';
		require APP . 'view/dashboard/regionWise.php';
		require APP . 'view/_templates/footer.php';
	}
	public function storeWiseLead() {
		
		// $total=$this->loadingModel->getAllProductsCount()->total;
		require APP . 'view/_templates/header.php';
		require APP . 'view/dashboard/storeWiseLead.php';
		require APP . 'view/_templates/footer.php';
	}
	public function storeWiseDemoView() {
		
		// $total=$this->loadingModel->getAllProductsCount()->total;
		require APP . 'view/_templates/header.php';
		require APP . 'view/dashboard/storeWiseDemo.php';
		require APP . 'view/_templates/footer.php';
	}
	public function employeeWiseLead() {
		// $total=$this->loadingModel->getAllProductsCount()->total;
		require APP . 'view/_templates/header.php';
		require APP . 'view/dashboard/employeeWiseLead.php';
		require APP . 'view/_templates/footer.php';
	}
	public function employeeWiseDemoView() {
		// $total=$this->loadingModel->getAllProductsCount()->total;
		require APP . 'view/_templates/header.php';
		require APP . 'view/dashboard/employeeWiseDemo.php';
		require APP . 'view/_templates/footer.php';
	}
	public function storeWiseSourceView() {
		require APP . 'view/_templates/header.php';
		require APP . 'view/dashboard/storeWiseSource.php';
		require APP . 'view/_templates/footer.php';
	}
	public function getAllCustomerLeads() {
		$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
		// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
		$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
		$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
		$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
		$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
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
		$stores = $this->loadingModel->getStoreName ();
		$totalRecordsFiltered = $this->loadingModel->getLeadDetails ( $from, $to, $lead_type, $lead_status, $start_from, $noOfRecordPerPage, $searchKey, $orderStr, $userId );
		// print_r($totalRecordsFiltered);exit;
		$results ['recordsTotal'] = ( int ) $this->loadingModel->getAllCustomersSummaryCount ()->total;
		$results ['recordsFiltered'] = ( int ) $this->loadingModel->getAllCustomersSummaryCount ()->total;
		// $results ['recordsFiltered'] = ( int ) $this->customersModel->getCustomersCount ( $searchKey, $userId )->total;
		$results ['data'] = $totalRecordsFiltered;
		// echo "<pre/>";
		// print_r(json_encode($totalRecordsFiltered));
		
		echo json_encode ( $results );
		exit ();
	}
	public function getAllEmployees() {
		$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
		// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
		$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
		$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
		$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
		$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
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
		$stores = $this->loadingModel->getStoreName ();
		$totalRecordsFiltered = $this->loadingModel->getAllEmployee ( $from, $to, $lead_type, $lead_status, $start_from, $noOfRecordPerPage, $searchKey, $orderStr, $userId );
		// print_r($totalRecordsFiltered);exit;
		$results ['recordsTotal'] = ( int ) $this->loadingModel->getAllEmployeeSummaryCount ()->total;
		$results ['recordsFiltered'] = ( int ) $this->loadingModel->getAllEmployeeSummaryCount ()->total;
		// $results ['recordsFiltered'] = ( int ) $this->customersModel->getCustomersCount ( $searchKey, $userId )->total;
		$results ['data'] = $totalRecordsFiltered;
		// echo "<pre/>";
		// print_r($results ['recordsFiltered']);exit;
		
		echo json_encode ( $results );
		exit ();
	}
	public function getAllStoreDemo() {
		$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
		// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
		$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
		$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
		$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
		$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
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
		$stores = $this->loadingModel->getStoreName ();
		$totalRecordsFiltered = $this->loadingModel->getAllStoreDemo ( $from, $to, $lead_type, $lead_status, $start_from, $noOfRecordPerPage, $searchKey, $orderStr, $userId );
		// print_r($totalRecordsFiltered);exit;
		$results ['recordsTotal'] = ( int ) $this->loadingModel->getAllCustomersSummaryCount ()->total;
		$results ['recordsFiltered'] = ( int ) $this->loadingModel->getAllCustomersSummaryCount ()->total;
		// $results ['recordsFiltered'] = ( int ) $this->customersModel->getCustomersCount ( $searchKey, $userId )->total;
		$results ['data'] = $totalRecordsFiltered;
		// echo "<pre/>";
		// print_r(json_encode($totalRecordsFiltered));
		
		echo json_encode ( $results );
		exit ();
	}
	public function getAllEmployeeDemo() {
		$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
		$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
		$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
		// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
		$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
		$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
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
		$totalRecordsFiltered = $this->loadingModel->getAllEmployeeDemo ( $from, $to, $lead_type, $lead_status, $start_from, $noOfRecordPerPage, $searchKey, $orderStr, $userId );
		// print_r($totalRecordsFiltered);exit;
		$results ['recordsTotal'] = ( int ) $this->loadingModel->getAllEmployeeSummaryCount ()->total;
		$results ['recordsFiltered'] = ( int ) $this->loadingModel->getAllEmployeeSummaryCount ()->total;
		// $results ['recordsFiltered'] = ( int ) $this->customersModel->getCustomersCount ( $searchKey, $userId )->total;
		$results ['data'] = $totalRecordsFiltered;
		// echo "<pre/>";
		// print_r(json_encode($totalRecordsFiltered));
		
		echo json_encode ( $results );
		exit ();
	}
	public function getAllStoreSource() {
		$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
		$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
		$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
		// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
		$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
		$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
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
		$totalRecordsFiltered = $this->loadingModel->getAllStoreSource ( $from, $to, $lead_type, $lead_status, $start_from, $noOfRecordPerPage, $searchKey, $orderStr, $userId );
		// print_r($totalRecordsFiltered);exit;
		$results ['recordsTotal'] = ( int ) $this->loadingModel->getAllCustomersSummaryCount ()->total;
		$results ['recordsFiltered'] = ( int ) $this->loadingModel->getAllCustomersSummaryCount ()->total;
		// $results ['recordsFiltered'] = ( int ) $this->customersModel->getCustomersCount ( $searchKey, $userId )->total;
		$results ['data'] = $totalRecordsFiltered;
		// echo "<pre/>";
		// print_r(json_encode($totalRecordsFiltered));
		
		echo json_encode ( $results );
		exit ();
	}
	public function storeDashboard() {
		$ref_id = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
		if (isset ( $_REQUEST ['lead_status'] )) {
			
			$total = $this->loadingModel->getAllProductsStoreCount ( $ref_id )->total;
			$mac_product_id = $this->loadingModel->specificMacProductStoreCount ( $ref_id );
			$ipad_product_id = $this->loadingModel->specificIpadProductStoreCount ( $ref_id );
			$iphone_product_id = $this->loadingModel->specificIphoneProductStoreCount ( $ref_id );
			$ipod_product_id = $this->loadingModel->specificIpodProductStoreCount ( $ref_id );
			$total_div = '<div class="xe-widget xe-counter" data-count=".data" data-from="0"
				data-to=' . $total . ' data-duration="1">
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
    	
					</div>
					</div>';
			$ipad_div = '<div class="xe-widget xe-counter-block xe-counter-block-purple"
			data-count=".num" data-from="0"
			data-to=' . $ipad_product_id->ipad_product_id . '
			data-duration="2">
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
		
				
			</div>
		</div>';
			$iphone_div = '
		   <div class="xe-widget xe-counter-block xe-counter-block-blue"
			data-count=".num" data-from="0"
			data-to=' . $iphone_product_id->iphone_product_id . '
			data-duration="2" data-easing="false">
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
				
			</div>
		</div>';
			$ipod_div = '
		<div class="xe-widget xe-counter-block xe-counter-block-orange"
			data-count=".num" data-from="0"
			data-to=' . $ipod_product_id->ipod_product_id . '
			data-duration="2" data-easing="false">
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
			$total = $this->loadingModel->getAllProductsStoreCount ( $ref_id )->total;
			$mac_product_id = $this->loadingModel->specificMacProductStoreCount ( $ref_id );
			$ipad_product_id = $this->loadingModel->specificIpadProductStoreCount ( $ref_id );
			$iphone_product_id = $this->loadingModel->specificIphoneProductStoreCount ( $ref_id );
			$ipod_product_id = $this->loadingModel->specificIpodProductStoreCount ( $ref_id );
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
				
			</div>
		</div>';
			require APP . 'view/_templates/header.php';
			require APP . 'view/empdashboard/regionWise.php';
			require APP . 'view/_templates/footer.php';
		}
	}
	public function exporttypeForStoreLead() {
		$type = $_REQUEST ['exporttype'];
		if ($type == "xls") {
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			// $products1 = dashboard::exportxlsForStoreLead ($from, $to, $lead_type, $lead_status,$userId);
			$customer1 = URL . "dashboard/exportxlsForStoreLead/?from=" . $from . "&to=" . $to . "&lead_type=" . $lead_type . "&lead_status=" . $lead_status . "&exporttype=" . $exporttype;
			echo $customer1;
			exit ();
		} else {
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			// $products1 = dashboard::exportxlsForStoreLead ($from, $to, $lead_type, $lead_status,$userId);
			$customer1 = URL . "dashboard/exportXlsxForStoreLead/?from=" . $from . "&to=" . $to . "&lead_type=" . $lead_type . "&lead_status=" . $lead_status . "&exporttype=" . $exporttype;
			echo $customer1;
			exit ();
		}
	}
	public function exportXlsForStoreLead() {
		try {
			$columns = "store.store_id,
					store.store_name as StoreName,
					store.store_id as MacProduct,
					store.store_id as iPadProduct,
					store.store_id as iPhoneProduct,
					store.store_id as iPodProduct,
					store.store_id as GrandTotal";
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$stud = $this->loadingModel->getExportForStoreLead ( $columns, $from, $to, $lead_type, $lead_status, $userId );
			
			foreach ( $stud as $student ) {
				$ss [] = get_object_vars ( $student );
			}
			
			require_once dirname ( __FILE__ ) . '/../import_export/PHPExcel.php';
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel ();
			// Add data
			$cc = 1;
			
			foreach ( $stud as $student ) {
				foreach ( $student as $cus => $val ) {
					$titleVal [] = $cus;
				}
				$titledd = $titleVal;
				foreach ( $titledd as $vv => $kk ) {
					$titleVal1 [] = $kk;
				}
				break;
			}
			
			$titleValue = array (
					$titleVal1 
			);
			
			$responce = array_merge ( $titleValue, $stud );
			// $responce = $stud;
			$var = 'A';
			$i = 0;
			foreach ( $responce as $data ) {
				foreach ( $data as $key => $value ) {
					if ($key != "store_id") {
						$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $var . $cc, $data [$key] );
						if ($var == 'Z') {
							$var = 'A';
						} else {
							$var ++;
						}
					}
				}
				$cc ++;
				$var = 'A';
			} // exit;
			  
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			// Redirect output to a client’s web browser (Excel5)
			$fileName = "StoreWiseLead" . " " . date ( "Y-m-d H-i-s" ) . ".xls";
			header ( 'Content-Type: application/vnd.ms-excel' );
			header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
			
			// header ( 'Cache-Control: max-age=0' );
			// If you're serving to IE 9, then the following may be needed
			// header ( 'Cache-Control: max-age=1' );
			
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
			if ($objWriter->save ( 'php://output' )) {
				echo "Data Export successfully";
			} else {
				echo "Unable to Export Data";
			}
		} catch ( Exception $e ) {
			echo "Error Occured";
		}
	}
	public function exportXlsxForStoreLead() {
		try {
			/**
			 * Include PHPExcel
			 */
			$columns = "store.store_id,
					store.store_name as StoreName,
					store.store_id as MacProduct,
					store.store_id as iPadProduct,
					store.store_id as iPhoneProduct,
					store.store_id as iPodProduct,
					store.store_id as GrandTotal";
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$stud = $this->loadingModel->getExportForStoreLead ( $columns, $from, $to, $lead_type, $lead_status, $userId );
			// print_r($stud);exit;
			// $students = $this->productModel->getAllStudents ();
			// print_r($stud);exit;
			// foreach ( $students as $student ) {
			// $ss [] = get_object_vars ( $student );
			// $idArray[]=$student->name;
			// }
			
			foreach ( $stud as $student ) {
				$ss [] = get_object_vars ( $student );
			}
			// print_r($ss);exit;
			// $userArray[]=$_POST['export'];var_dump($userArray);
			require_once dirname ( __FILE__ ) . '/../import_export/PHPExcel.php';
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel ();
			// Add data
			$cc = 1;
			// print_r($userArray);
			// $dataArray=array();
			// foreach ( $userArray as $data1 ) {
			// $dataArray[]=$data1;
			// }
			foreach ( $stud as $student ) {
				foreach ( $student as $cus => $val ) {
					$titleVal [] = $cus;
				}
				$titledd = $titleVal;
				foreach ( $titledd as $vv => $kk ) {
					$titleVal1 [] = $kk;
				}
				break;
			}
			
			$titleValue = array (
					$titleVal1 
			);
			
			$responce = array_merge ( $titleValue, $stud );
			// $responce = $stud;
			$var = 'A';
			$i = 0;
			foreach ( $responce as $data ) {
				foreach ( $data as $key => $value ) {
					if ($key != "store_id") {
						$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $var . $cc, $data [$key] );
						if ($var == 'Z') {
							$var = 'A';
						} else {
							$var ++;
						}
					}
				}
				$cc ++;
				$var = 'A';
			} // exit;
			  // foreach ( $responce as $data ) {
			  
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			
			// Redirect output to a client’s web browser (Excel2007)
			$fileName = "StoreWiseLead" . " " . date ( "Y-m-d H-i-s" ) . ".xlsx";
			header ( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
			header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
			header ( 'Cache-Control: max-age=0' );
			
			// If you're serving to IE 9, then the following may be needed
			
			header ( 'Cache-Control: max-age=1' );
			
			// If you're serving to IE over SSL, then the following may be needed
			
			header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
			header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
			header ( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
			header ( 'Pragma: public' ); // HTTP/1.0
			
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
			$objWriter->save ( 'php://output' );
			exit ();
		} catch ( Exception $e ) {
			
			$this->logger->error ( $e->getLine () . " " . $e->getFile () . " " . $e->getMessage () );
			return $this->response->setJsonContent ( array (
					"success" => "false",
					"error_message" => $e->getMessage () 
			) );
		}
	}
	public function exporttypeForEmployeeLead() {
		$type = $_REQUEST ['exporttype'];
		if ($type == "xls") {
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			// $products1 = dashboard::exportxlsForStoreLead ($from, $to, $lead_type, $lead_status,$userId);
			$customer1 = URL . "dashboard/exportXlsForEmployeeLead/?from=" . $from . "&to=" . $to . "&lead_type=" . $lead_type . "&lead_status=" . $lead_status . "&exporttype=" . $exporttype;
			echo $customer1;
			exit ();
		} else {
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			// $products1 = dashboard::exportxlsForStoreLead ($from, $to, $lead_type, $lead_status,$userId);
			$customer1 = URL . "dashboard/exportXlsxForEmployeeLead/?from=" . $from . "&to=" . $to . "&lead_type=" . $lead_type . "&lead_status=" . $lead_status . "&exporttype=" . $exporttype;
			echo $customer1;
			exit ();
		}
	}
	public function exportXlsForEmployeeLead() {
		try {
			$columns = "employee.id as employee_id,
					store.store_name as StoreName,
					employee.employees_id as EmployeeId,
					employee.name as EmployeeName,
					employee.id as MacProduct,
					employee.id as iPadProduct,
					employee.id as iPhoneProduct,
					employee.id as iPodProduct,
					employee.id as GrandTotal";
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$stud = $this->loadingModel->exportForEmployeeLead ( $columns, $from, $to, $lead_type, $lead_status, $userId );
			
			foreach ( $stud as $student ) {
				$ss [] = get_object_vars ( $student );
			}
			// print_r($ss);exit;
			// $userArray[]=$_POST['export'];var_dump($userArray);
			require_once dirname ( __FILE__ ) . '/../import_export/PHPExcel.php';
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel ();
			// Add data
			$cc = 1;
			
			foreach ( $stud as $student ) {
				foreach ( $student as $cus => $val ) {
					$titleVal [] = $cus;
				}
				$titledd = $titleVal;
				foreach ( $titledd as $vv => $kk ) {
					$titleVal1 [] = $kk;
				}
				break;
			}
			
			$titleValue = array (
					$titleVal1 
			);
			
			$responce = array_merge ( $titleValue, $stud );
			$var = 'A';
			$i = 0;
			foreach ( $responce as $data ) {
				foreach ( $data as $key => $value ) {
					if ($key != "employee_id") {
						$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $var . $cc, $data [$key] );
						if ($var == 'Z') {
							$var = 'A';
						} else {
							$var ++;
						}
					}
				}
				$cc ++;
				$var = 'A';
			} // exit;
			  
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			// Redirect output to a client’s web browser (Excel5)
			$fileName = "EmployeeWiseLead" . " " . date ( "Y-m-d H-i-s" ) . ".xls";
			header ( 'Content-Type: application/vnd.ms-excel' );
			header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
			
			// header ( 'Cache-Control: max-age=0' );
			// If you're serving to IE 9, then the following may be needed
			// header ( 'Cache-Control: max-age=1' );
			
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
			if ($objWriter->save ( 'php://output' )) {
				echo "Data Export successfully";
			} else {
				echo "Unable to Export Data";
			}
		} catch ( Exception $e ) {
			echo "Error Occured";
		}
	}
	public function exportXlsxForEmployeeLead() {
		try {
			/**
			 * Include PHPExcel
			 */
			$columns = "employee.id as employee_id,
					store.store_name as StoreName,
					employee.employees_id as EmployeeId,
					employee.name as EmployeeName,
					employee.id as MacProduct,
					employee.id as iPadProduct,
					employee.id as iPhoneProduct,
					employee.id as iPodProduct,
					employee.id as GrandTotal";
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$stud = $this->loadingModel->exportForEmployeeLead ( $columns, $from, $to, $lead_type, $lead_status, $userId );
			// $students = $this->productModel->getAllStudents ();
			// print_r($stud);exit;
			// foreach ( $students as $student ) {
			// $ss [] = get_object_vars ( $student );
			// $idArray[]=$student->name;
			// }
			
			foreach ( $stud as $student ) {
				$ss [] = get_object_vars ( $student );
			}
			// print_r($ss);exit;
			// $userArray[]=$_POST['export'];var_dump($userArray);
			require_once dirname ( __FILE__ ) . '/../import_export/PHPExcel.php';
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel ();
			// Add data
			$cc = 1;
			// print_r($userArray);
			// $dataArray=array();
			// foreach ( $userArray as $data1 ) {
			// $dataArray[]=$data1;
			// }
			foreach ( $stud as $student ) {
				foreach ( $student as $cus => $val ) {
					$titleVal [] = $cus;
				}
				$titledd = $titleVal;
				foreach ( $titledd as $vv => $kk ) {
					$titleVal1 [] = $kk;
				}
				break;
			}
			
			$titleValue = array (
					$titleVal1 
			);
			
			$responce = array_merge ( $titleValue, $stud );
			$var = 'A';
			$i = 0;
			foreach ( $responce as $data ) {
				foreach ( $data as $key => $value ) {
					if ($key != "employee_id") {
						$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $var . $cc, $data [$key] );
						if ($var == 'Z') {
							$var = 'A';
						} else {
							$var ++;
						}
					}
				}
				$cc ++;
				$var = 'A';
			} // exit;
			  
			// foreach ( $responce as $data ) {
			  
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			
			// Redirect output to a client’s web browser (Excel2007)
			$fileName = "EmployeeWiseLead" . " " . date ( "Y-m-d H-i-s" ) . ".xlsx";
			header ( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
			header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
			header ( 'Cache-Control: max-age=0' );
			
			// If you're serving to IE 9, then the following may be needed
			
			header ( 'Cache-Control: max-age=1' );
			
			// If you're serving to IE over SSL, then the following may be needed
			
			header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
			header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
			header ( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
			header ( 'Pragma: public' ); // HTTP/1.0
			
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
			$objWriter->save ( 'php://output' );
			exit ();
		} catch ( Exception $e ) {
			
			$this->logger->error ( $e->getLine () . " " . $e->getFile () . " " . $e->getMessage () );
			return $this->response->setJsonContent ( array (
					"success" => "false",
					"error_message" => $e->getMessage () 
			) );
		}
	}
	public function exporttypeForStoreDemo() {
		$type = $_REQUEST ['exporttype'];
		if ($type == "xls") {
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			// $products1 = dashboard::exportxlsForStoreLead ($from, $to, $lead_type, $lead_status,$userId);
			$customer1 = URL . "dashboard/exportXlsForStoreDemo/?from=" . $from . "&to=" . $to . "&lead_type=" . $lead_type . "&lead_status=" . $lead_status . "&exporttype=" . $exporttype;
			echo $customer1;
			exit ();
		} else {
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			// $products1 = dashboard::exportxlsForStoreLead ($from, $to, $lead_type, $lead_status,$userId);
			$customer1 = URL . "dashboard/exportXlsxForStoreDemo/?from=" . $from . "&to=" . $to . "&lead_type=" . $lead_type . "&lead_status=" . $lead_status . "&exporttype=" . $exporttype;
			echo $customer1;
			exit ();
		}
	}
	public function exportXlsForStoreDemo() {
		try {
			$columns = "store.store_id,
					store.store_name as StoreName,
					store.store_id as MacProduct,
					store.store_id as iPadProduct,
					store.store_id as iPhoneProduct,
					store.store_id as iPodProduct,
					store.store_id as GrandTotal";
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$stud = $this->loadingModel->getExportForStoreDemo ( $columns, $from, $to, $lead_type, $lead_status, $userId );
			foreach ( $stud as $student ) {
				$ss [] = get_object_vars ( $student );
			}
			// print_r($ss);exit;
			// $userArray[]=$_POST['export'];var_dump($userArray);
			require_once dirname ( __FILE__ ) . '/../import_export/PHPExcel.php';
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel ();
			// Add data
			$cc = 1;
			// print_r($userArray);
			// $dataArray=array();
			// foreach ( $userArray as $data1 ) {
			// $dataArray[]=$data1;
			// }
			foreach ( $stud as $student ) {
				foreach ( $student as $cus => $val ) {
					$titleVal [] = $cus;
				}
				$titledd = $titleVal;
				foreach ( $titledd as $vv => $kk ) {
					$titleVal1 [] = $kk;
				}
				break;
			}
			
			$titleValue = array (
					$titleVal1 
			);
			
			$responce = array_merge ( $titleValue, $stud );
			$var = 'A';
			$i = 0;
			foreach ( $responce as $data ) {
				
				foreach ( $data as $key => $value ) {
					if ($key != "store_id") {
						$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $var . $cc, $data [$key] );
						if ($var == 'Z') {
							$var = 'A';
						} else {
							$var ++;
						}
					}
				}
				$cc ++;
				$var = 'A';
			} // exit;
			  
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			// Redirect output to a client’s web browser (Excel5)
			$fileName = "StoreWiseDemo" . " " . date ( "Y-m-d H-i-s" ) . ".xls";
			header ( 'Content-Type: application/vnd.ms-excel' );
			header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
			
			// header ( 'Cache-Control: max-age=0' );
			// If you're serving to IE 9, then the following may be needed
			// header ( 'Cache-Control: max-age=1' );
			
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
			if ($objWriter->save ( 'php://output' )) {
				echo "Data Export successfully";
			} else {
				echo "Unable to Export Data";
			}
		} catch ( Exception $e ) {
			echo "Error Occured";
		}
	}
	public function exportXlsxForStoreDemo() {
		try {
			/**
			 * Include PHPExcel
			 */
			$columns = "store.store_id,
					store.store_name as StoreName,
					store.store_id as MacProduct,
					store.store_id as iPadProduct,
					store.store_id as iPhoneProduct,
					store.store_id as iPodProduct,
					store.store_id as GrandTotal";
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$stud = $this->loadingModel->getExportForStoreDemo ( $columns, $from, $to, $lead_type, $lead_status, $userId );
			
			foreach ( $stud as $student ) {
				$ss [] = get_object_vars ( $student );
			}
			// print_r($ss);exit;
			// $userArray[]=$_POST['export'];var_dump($userArray);
			require_once dirname ( __FILE__ ) . '/../import_export/PHPExcel.php';
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel ();
			// Add data
			$cc = 1;
			// print_r($userArray);
			// $dataArray=array();
			// foreach ( $userArray as $data1 ) {
			// $dataArray[]=$data1;
			// }
			foreach ( $stud as $student ) {
				foreach ( $student as $cus => $val ) {
					$titleVal [] = $cus;
				}
				$titledd = $titleVal;
				foreach ( $titledd as $vv => $kk ) {
					$titleVal1 [] = $kk;
				}
				break;
			}
			
			$titleValue = array (
					$titleVal1 
			);
			
			$responce = array_merge ( $titleValue, $stud );
			$var = 'A';
			$i = 0;
			foreach ( $responce as $data ) {
				
				foreach ( $data as $key => $value ) {
					if ($key != "store_id") {
						$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $var . $cc, $data [$key] );
						if ($var == 'Z') {
							$var = 'A';
						} else {
							$var ++;
						}
					}
				}
				$cc ++;
				$var = 'A';
			} // exit;
			  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			
			// Redirect output to a client’s web browser (Excel2007)
			$fileName = "StoreWiseDemo" . " " . date ( "Y-m-d H-i-s" ) . ".xlsx";
			header ( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
			header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
			header ( 'Cache-Control: max-age=0' );
			
			// If you're serving to IE 9, then the following may be needed
			
			header ( 'Cache-Control: max-age=1' );
			
			// If you're serving to IE over SSL, then the following may be needed
			
			header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
			header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
			header ( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
			header ( 'Pragma: public' ); // HTTP/1.0
			
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
			$objWriter->save ( 'php://output' );
			exit ();
		} catch ( Exception $e ) {
			
			$this->logger->error ( $e->getLine () . " " . $e->getFile () . " " . $e->getMessage () );
			return $this->response->setJsonContent ( array (
					"success" => "false",
					"error_message" => $e->getMessage () 
			) );
		}
	}
	public function exporttypeForEmployeeDemo() {
		$type = $_REQUEST ['exporttype'];
		if ($type == "xls") {
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			// $products1 = dashboard::exportxlsForStoreLead ($from, $to, $lead_type, $lead_status,$userId);
			$customer1 = URL . "dashboard/exportXlsForEmployeeDemo/?from=" . $from . "&to=" . $to . "&lead_type=" . $lead_type . "&lead_status=" . $lead_status . "&exporttype=" . $exporttype;
			echo $customer1;
			exit ();
		} else {
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			// $products1 = dashboard::exportxlsForStoreLead ($from, $to, $lead_type, $lead_status,$userId);
			$customer1 = URL . "dashboard/exportXlsxForEmployeeDemo/?from=" . $from . "&to=" . $to . "&lead_type=" . $lead_type . "&lead_status=" . $lead_status . "&exporttype=" . $exporttype;
			echo $customer1;
			exit ();
		}
	}
	public function exportXlsForEmployeeDemo() {
		try {
			$columns = "
					employee.id as employee_id,
					store.store_name as StoreName,
					employee.employees_id as EmployeeId,
					employee.name as EmployeeName,
					employee.id as MacProduct,
					employee.id as MacDemo,
					employee.id as iPadProduct,
					employee.id as iPadDemo,
					employee.id as iPhoneProduct,
					employee.id as iPhoneDemo,
					employee.id as iPodProduct,
					employee.id as iPodDemo";
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$stud = $this->loadingModel->getExportForEmployeeDemo ( $columns, $from, $to, $lead_type, $lead_status, $userId );
			// print_r($stud);exit;
			
			foreach ( $stud as $student ) {
				$ss [] = get_object_vars ( $student );
			}
			
			require_once dirname ( __FILE__ ) . '/../import_export/PHPExcel.php';
			// Create new PHPExcel object
			
			$objPHPExcel = new PHPExcel ();
			
			// Add data
			$cc = 1;
			
			foreach ( $stud as $student ) {
				foreach ( $student as $cus => $val ) {
					$titleVal [] = $cus;
				}
				$titledd = $titleVal;
				foreach ( $titledd as $vv => $kk ) {
					$titleVal1 [] = $kk;
				}
				break;
			}
			
			$titleValue = array (
					$titleVal1 
			);
			
			$responce = array_merge ( $titleValue, $stud );
			$var = 'A';
			$i = 0;
			foreach ( $responce as $data ) {
				foreach ( $data as $key => $value ) {
					if ($key != "employee_id") {
						$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $var . $cc, $data [$key] );
						if ($var == 'Z') {
							$var = 'A';
						} else {
							$var ++;
						}
					}
				}
				$cc ++;
				$var = 'A';
			} // exit;
			  
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			// Redirect output to a client’s web browser (Excel5)
			$fileName = "EmployeeWiseDemo" . " " . date ( "Y-m-d H-i-s" ) . ".xls";
			header ( 'Content-Type: application/vnd.ms-excel' );
			header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
			
			// header ( 'Cache-Control: max-age=0' );
			// If you're serving to IE 9, then the following may be needed
			// header ( 'Cache-Control: max-age=1' );
			
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
			if ($objWriter->save ( 'php://output' )) {
				echo "Data Export successfully";
			} else {
				echo "Unable to Export Data";
			}
		} catch ( Exception $e ) {
			echo "Error Occured";
		}
	}
	public function exportXlsxForEmployeeDemo() {
		try {
			/**
			 * Include PHPExcel
			 */
			$columns = "
					employee.id as employee_id,
					store.store_name as StoreName,
					employee.employees_id as EmployeeId,
					employee.name as EmployeeName,
					employee.id as MacProduct,
					employee.id as MacDemo,
					employee.id as iPadProduct,
					employee.id as iPadDemo,
					employee.id as iPhoneProduct,
					employee.id as iPhoneDemo,
					employee.id as iPodProduct,
					employee.id as iPodDemo";
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$stud = $this->loadingModel->getExportForEmployeeDemo ( $columns, $from, $to, $lead_type, $lead_status, $userId );
			// print_r($stud);exit;
			
			foreach ( $stud as $student ) {
				$ss [] = get_object_vars ( $student );
			}
			
			require_once dirname ( __FILE__ ) . '/../import_export/PHPExcel.php';
			// Create new PHPExcel object
			
			$objPHPExcel = new PHPExcel ();
			
			// Add data
			$cc = 1;
			
			foreach ( $stud as $student ) {
				foreach ( $student as $cus => $val ) {
					$titleVal [] = $cus;
				}
				$titledd = $titleVal;
				foreach ( $titledd as $vv => $kk ) {
					$titleVal1 [] = $kk;
				}
				break;
			}
			
			$titleValue = array (
					$titleVal1 
			);
			
			$responce = array_merge ( $titleValue, $stud );
			$var = 'A';
			$i = 0;
			foreach ( $responce as $data ) {
				foreach ( $data as $key => $value ) {
					if ($key != "employee_id") {
						$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $var . $cc, $data [$key] );
						if ($var == 'Z') {
							$var = 'A';
						} else {
							$var ++;
						}
					}
				}
				$cc ++;
				$var = 'A';
			} // exit;
			  
			// Rename worksheet
			  // $objPHPExcel->getActiveSheet ()->setTitle ( 'Simple' );
			  
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			
			// Redirect output to a client’s web browser (Excel2007)
			$fileName = "EmployeeWiseDemo" . " " . date ( "Y-m-d H-i-s" ) . ".xlsx";
			header ( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
			header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
			header ( 'Cache-Control: max-age=0' );
			
			// If you're serving to IE 9, then the following may be needed
			
			header ( 'Cache-Control: max-age=1' );
			
			// If you're serving to IE over SSL, then the following may be needed
			
			header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
			header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
			header ( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
			header ( 'Pragma: public' ); // HTTP/1.0
			
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
			$objWriter->save ( 'php://output' );
			exit ();
		} catch ( Exception $e ) {
			
			$this->logger->error ( $e->getLine () . " " . $e->getFile () . " " . $e->getMessage () );
			return $this->response->setJsonContent ( array (
					"success" => "false",
					"error_message" => $e->getMessage () 
			) );
		}
	}
	public function exporttypeForStoreSource() {
		$type = $_REQUEST ['exporttype'];
		if ($type == "xls") {
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			// $products1 = dashboard::exportxlsForStoreLead ($from, $to, $lead_type, $lead_status,$userId);
			$customer1 = URL . "dashboard/exportXlsForStoreSource/?from=" . $from . "&to=" . $to . "&lead_type=" . $lead_type . "&lead_status=" . $lead_status . "&exporttype=" . $exporttype;
			echo $customer1;
			exit ();
		} else {
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			// $products1 = dashboard::exportxlsForStoreLead ($from, $to, $lead_type, $lead_status,$userId);
			$customer1 = URL . "dashboard/exportXlsxForStoreSource/?from=" . $from . "&to=" . $to . "&lead_type=" . $lead_type . "&lead_status=" . $lead_status . "&exporttype=" . $exporttype;
			echo $customer1;
			exit ();
		}
	}
	public function exportXlsForStoreSource() {
		try {
			$columns = "store.store_id,
					store.store_name as StoreName,
					store.store_id as Advertise,
					store.store_id as Inbound,
					store.store_id as Outbound,
					store.store_id as Walkin,
					store.store_id";
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$stud = $this->loadingModel->getExportForStoreSource ( $columns, $from, $to, $lead_type, $lead_status, $userId );
			
			foreach ( $stud as $student ) {
				$ss [] = get_object_vars ( $student );
			}
			// print_r($ss);exit;
			// $userArray[]=$_POST['export'];var_dump($userArray);
			require_once dirname ( __FILE__ ) . '/../import_export/PHPExcel.php';
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel ();
			// Add data
			$cc = 1;
			
			foreach ( $stud as $student ) {
				foreach ( $student as $cus => $val ) {
					$titleVal [] = $cus;
				}
				$titledd = $titleVal;
				foreach ( $titledd as $vv => $kk ) {
					$titleVal1 [] = $kk;
				}
				break;
			}
			
			$titleValue = array (
					$titleVal1 
			);
			
			$responce = array_merge ( $titleValue, $stud );
			$var = 'A';
			$i = 0;
			foreach ( $responce as $data ) {
				foreach ( $data as $key => $value ) {
					if ($key != "store_id") {
						$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $var . $cc, $data [$key] );
						if ($var == 'Z') {
							$var = 'A';
						} else {
							$var ++;
						}
					}
				}
				$cc ++;
				$var = 'A';
			} // exit;
			  
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			// Redirect output to a client’s web browser (Excel5)
			$fileName = "StoreWiseSource" . " " . date ( "Y-m-d H-i-s" ) . ".xls";
			header ( 'Content-Type: application/vnd.ms-excel' );
			header ( 'Content-Disposition: attachment;filename="' . $fileName . '""' );
			
			// header ( 'Cache-Control: max-age=0' );
			// If you're serving to IE 9, then the following may be needed
			// header ( 'Cache-Control: max-age=1' );
			
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
			if ($objWriter->save ( 'php://output' )) {
				echo "Data Export successfully";
			} else {
				echo "Unable to Export Data";
			}
		} catch ( Exception $e ) {
			echo "Error Occured";
		}
	}
	public function exportXlsxForStoreSource() {
		try {
			/**
			 * Include PHPExcel
			 */
			$columns = "store.store_id,
					store.store_name as StoreName,
					store.store_id as Advertise,
					store.store_id as Inbound,
					store.store_id as Outbound,
					store.store_id as Walkin,
					store.store_id";
			$userId = isset ( $_SESSION ['sess_user_id'] ) ? (trim ( @$_SESSION ['sess_user_id'] )) : "";
			// if (isset($_REQUEST["draw"])) { $page = $_REQUEST["draw"]; } else { $page=1; };
			$from = isset ( $_REQUEST ['from'] ) ? (trim ( @$_REQUEST ['from'] )) : "";
			$to = isset ( $_REQUEST ['to'] ) ? (trim ( @$_REQUEST ['to'] )) : "";
			$lead_type = isset ( $_REQUEST ['lead_type'] ) ? (trim ( @$_REQUEST ['lead_type'] )) : "";
			$lead_status = isset ( $_REQUEST ['lead_status'] ) ? (trim ( @$_REQUEST ['lead_status'] )) : "";
			$stud = $this->loadingModel->getExportForStoreSource ( $columns, $from, $to, $lead_type, $lead_status, $userId );
			// foreach ( $students as $student ) {
			// $ss [] = get_object_vars ( $student );
			// $idArray[]=$student->name;
			// }
			
			foreach ( $stud as $student ) {
				$ss [] = get_object_vars ( $student );
			}
			// print_r($ss);exit;
			// $userArray[]=$_POST['export'];var_dump($userArray);
			require_once dirname ( __FILE__ ) . '/../import_export/PHPExcel.php';
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel ();
			// Add data
			$cc = 1;
			// print_r($userArray);
			// $dataArray=array();
			// foreach ( $userArray as $data1 ) {
			// $dataArray[]=$data1;
			// }
			foreach ( $stud as $student ) {
				foreach ( $student as $cus => $val ) {
					$titleVal [] = $cus;
				}
				$titledd = $titleVal;
				foreach ( $titledd as $vv => $kk ) {
					$titleVal1 [] = $kk;
				}
				break;
			}
			
			$titleValue = array (
					$titleVal1 
			);
			
			$responce = array_merge ( $titleValue, $stud );
			$var = 'A';
			$i = 0;
			foreach ( $responce as $data ) {
				foreach ( $data as $key => $value ) {
					if ($key != "store_id") {
						$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( $var . $cc, $data [$key] );
						if ($var == 'Z') {
							$var = 'A';
						} else {
							$var ++;
						}
					}
				}
				$cc ++;
				$var = 'A';
			} // exit;
			  // foreach ( $responce as $data ) {
			  // print_r($data);exit;
			  // $objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A' . $cc, $data ['name'] )->setCellValue ( 'B' . $cc, $data ['dob'] )->setCellValue ( 'C' . $cc, $data ['gender'] )->setCellValue ( 'D' . $cc, $data ['email'] )->setCellValue ( 'E' . $cc, $data ['mobile_number'] )->setCellValue ( 'F' . $cc, $data ['occupation'] )->setCellValue ( 'G' . $cc, $data ['city'] )->setCellValue ( 'H' . $cc, $data ['state'] )->setCellValue ( 'I' . $cc, $data ['address'] )->setCellValue ( 'J' . $cc, $data ['about_lenco'] );
			  // $cc ++;
			  // }
			  // Rename worksheet
			  // $objPHPExcel->getActiveSheet ()->setTitle ( 'Simple' );
			  
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			
			$objPHPExcel->setActiveSheetIndex ( 0 );
			
			// Redirect output to a client’s web browser (Excel2007)
			$fileName = "StoreWiseSource" . " " . date ( "Y-m-d H-i-s" ) . ".xlsx";
			header ( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
			header ( 'Content-Disposition: attachment;filename="' . $fileName . '"' );
			header ( 'Cache-Control: max-age=0' );
			
			// If you're serving to IE 9, then the following may be needed
			
			header ( 'Cache-Control: max-age=1' );
			
			// If you're serving to IE over SSL, then the following may be needed
			
			header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
			header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
			header ( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
			header ( 'Pragma: public' ); // HTTP/1.0
			
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
			$objWriter->save ( 'php://output' );
			exit ();
		} catch ( Exception $e ) {
			
			$this->logger->error ( $e->getLine () . " " . $e->getFile () . " " . $e->getMessage () );
			return $this->response->setJsonContent ( array (
					"success" => "false",
					"error_message" => $e->getMessage () 
			) );
		}
	}
	
	/**
	 * get Dashboard services for mobile app
	 */
	public function getAllRegions() {
		try {
			
			$inputArray = json_decode ( file_get_contents ( 'php://input' ), true );
			if (isset ( $_REQUEST ['token'] ) && $_REQUEST ['token'] != "") {
				$token = $this->customersModel->getTokenAuthendication ( $_REQUEST ['token'] );
				if ($token != "") {
					$regions = $this->customersModel->getAllRegions ();
					echo json_encode ( $regions );
				} else {
					echo json_encode ( array (
							"success" => "false",
							"result" => "Invalid User" 
					) );
				}
			} else {
				echo json_encode ( array (
						"success" => "false",
						"result" => "Invalid User" 
				) );
			}
		} catch ( Exception $e ) {
			throw new Exception ( $e->getMessage () );
		}
	}
	/**
	 * get store by region id
	 */
	public function getStoresByRegionId() {
		try {
			
			$inputArray = json_decode ( file_get_contents ( 'php://input' ), true );
			if (isset ( $_REQUEST ['token'] ) && $_REQUEST ['token'] != "") {
				$token = $this->customersModel->getTokenAuthendication ( $_REQUEST ['token'] );
				if ($token != "") {
					if (isset ( $inputArray ['region_id'] ) && $inputArray ['region_id'] != "") {
						$stores = $this->customersModel->getAllStoresByRegionId ( $inputArray ['region_id'] );
						echo json_encode ( $stores );
					} else {
						echo json_encode ( array (
								"success" => "false",
								"result" => "Please select the region" 
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
						"result" => "Invalid User" 
				) );
			}
		} catch ( Exception $e ) {
			throw new Exception ( $e->getMessage () );
		}
	}
	/**
	 * get employees by store
	 */
	public function getEmployeesByStore() {
		try {
			$inputArray = json_decode ( file_get_contents ( 'php://input' ), true );
			if (isset ( $_REQUEST ['token'] ) && $_REQUEST ['token'] != "") {
				$token = $this->customersModel->getTokenAuthendication ( $_REQUEST ['token'] );
				if ($token != "") {
					if (isset ( $inputArray ['store'] ) && $inputArray ['store'] != "") {
						$employees = $this->customersModel->getAllEmployeesByStoreId ( $_SESSION ['store'] );
						echo json_encode ( $employees );
					} else {
						echo json_encode ( array (
								"success" => "false",
								"result" => "Please select the store" 
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
						"result" => "Invalid User" 
				) );
			}
		} catch ( Exception $e ) {
			throw new Exception ( $e->getMessage () );
		}
	}
	
	/**
	 * get total leads action
	 */
	public function getTotalLeadsDashboard() {
		try {
			
			$inputArray = json_decode ( file_get_contents ( 'php://input' ), true );
			if (isset ( $_REQUEST ['token'] ) && $_REQUEST ['token'] != "") {
				$token = $this->customersModel->getTokenAuthendication ( $_REQUEST ['token'] );
				if ($token != "") {
					$empId = $this->loadingModel->getEmployeeId ( $token->ref_id );
					$userOtherDetails = $this->loadingModel->getEmployeeOtherDetails ( $empId->employee_id );
					$roleName = $this->loadingModel->getRoleNameByRoleId ( $userOtherDetails->role_id );
					
					if (isset ( $inputArray ['ref_type'] ) && $inputArray ['ref_type'] != "") {
						if ($roleName->role_id == 1) {
							$ref_id = $inputArray ['ref_type'];
							$total = $this->loadingModel->getAllProductsCount ( $ref_id )->total;
							$mac_product_id = $this->loadingModel->specificMacProductCount ( $ref_id );
							$ipad_product_id = $this->loadingModel->specificIpadProductCount ( $ref_id );
							$iphone_product_id = $this->loadingModel->specificIphoneProductCount ( $ref_id );
							$ipod_product_id = $this->loadingModel->specificIpodProductCount ( $ref_id );
							
							echo json_encode ( array (
									"success" => "true",
									"result" => array (
											"total" => $total,
											"mac_count" => $mac_product_id,
											"ipad_count" => $ipad_product_id,
											"iphone_count" => $iphone_product_id,
											"ipod_count" => $ipod_product_id 
									) 
							) );
						} elseif ($roleName->role_id == 2) {
							$ref_id = $inputArray ['ref_type'];
							$total = $this->loadingModel->getAllProductsStoreCountForApp ( $ref_id, $store_id )->total;
							$mac_product_id = $this->loadingModel->specificMacProductStoreCountForApp ( $ref_id, $store_id );
							$ipad_product_id = $this->loadingModel->specificIpadProductStoreCountForApp ( $ref_id, $store_id );
							$iphone_product_id = $this->loadingModel->specificIphoneProductStoreCountForApp ( $ref_id, $store_id );
							$ipod_product_id = $this->loadingModel->specificIpodProductStoreCountForApp ( $ref_id, $store_id );
							
							echo json_encode ( array (
									"success" => "true",
									"result" => array (
											"total" => $total,
											"mac_count" => $mac_product_id,
											"ipad_count" => $ipad_product_id,
											"iphone_count" => $iphone_product_id,
											"ipod_count" => $ipod_product_id 
									) 
							) );
						} elseif ($roleName->role_id == 4) {
							$ref_id = $inputArray ['ref_type'];
							$macStore = $this->emploadingModel->getMacStoreDetails ( $ref_id );
							$total = $this->emploadingModel->getAllProductsCountForApp ( $ref_id, $store_id );
							$macStores = $this->emploadingModel->getMacStoreDetailsForApp ( $ref_id, $store_id );
							$ipodStores = $this->emploadingModel->getiPodStoreDetailsForApp ( $ref_id, $store_id );
							$ipadStores = $this->emploadingModel->getiPadStoreDetailsForApp ( $ref_id, $store_id );
							$iphoneStores = $this->emploadingModel->getiPhoneStoreDetailsForApp ( $ref_id, $store_id );
							$mac_product_id = $this->emploadingModel->specificMacProductCountForApp ( $ref_id, $store_id );
							$ipad_product_id = $this->emploadingModel->specificIpadProductCountForApp ( $ref_id, $store_id );
							$iphone_product_id = $this->emploadingModel->specificIphoneProductCountForApp ( $ref_id, $store_id );
							$ipod_product_id = $this->emploadingModel->specificIpodProductCountForApp ( $ref_id, $store_id );
							echo json_encode ( array (
									"success" => "true",
									"result" => array (
											"total" => $total,
											"mac_count" => $macStores,
											"ipad_count" => $ipodStores,
											"iphone_count" => $ipadStores,
											"ipod_count" => $iphoneStores 
									) 
							) );
						} elseif ($roleName->role_id == 3) {
							$ref_id = $inputArray ['ref_type'];
							$total = $this->loadingModel->getEmployeeLeadCount ( $empId->employee_id, $ref_id )->total;
							$mac_product_id = $this->loadingModel->getEmployeeDashboard ( $empId->employee_id, $ref_id );
							echo json_encode ( array (
									"success" => "true",
									"result" => array (
											"total" => $total,
											"mac_count" => $mac_product_id->mac,
											"ipad_count" => $mac_product_id->ipad,
											"iphone_count" => $mac_product_id->iphone,
											"ipod_count" => $mac_product_id->ipod 
									) 
							) );
						} else {
							$ref_id = $inputArray ['ref_type'];
							$total = $this->loadingModel->getAllProductsCount ( $ref_id )->total;
							$mac_product_id = $this->loadingModel->specificMacProductCount ( $ref_id );
							$ipad_product_id = $this->loadingModel->specificIpadProductCount ( $ref_id );
							$iphone_product_id = $this->loadingModel->specificIphoneProductCount ( $ref_id );
							$ipod_product_id = $this->loadingModel->specificIpodProductCount ( $ref_id );
							
							echo json_encode ( array (
									"success" => "true",
									"result" => array (
											"total" => $total,
											"mac_count" => $mac_product_id,
											"ipad_count" => $ipad_product_id,
											"iphone_count" => $iphone_product_id,
											"ipod_count" => $ipod_product_id 
									) 
							) );
						}
					} else {
						echo json_encode ( array (
								"success" => "false",
								"result" => "Please select the lead status" 
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
						"result" => "Invalid User" 
				) );
			}
		} catch ( Exception $e ) {
			throw new Exception ( $e->getMessage () );
		}
	}
	/**
	 * get store wise dashboard
	 */
	public function getStoreDashboardForApp() {
		try {
			$inputArray = json_decode ( file_get_contents ( 'php://input' ), true );
			if (isset ( $_REQUEST ['token'] ) && $_REQUEST ['token'] != "") {
				$token = $this->customersModel->getTokenAuthendication ( $_REQUEST ['token'] );
				$userDetails = $this->customersModel->getUserDetailsByToken ( $token->ref_id );
				if ($token != "") {
					$store_id = $userDetails->store_id;
					if (isset ( $inputArray ['ref_type'] ) && $inputArray ['ref_type'] != "") {
						$ref_id = $inputArray ['ref_type'];
						$total = $this->loadingModel->getAllProductsStoreCountForApp ( $ref_id, $store_id )->total;
						$mac_product_id = $this->loadingModel->specificMacProductStoreCountForApp ( $ref_id, $store_id );
						$ipad_product_id = $this->loadingModel->specificIpadProductStoreCountForApp ( $ref_id, $store_id );
						$iphone_product_id = $this->loadingModel->specificIphoneProductStoreCountForApp ( $ref_id, $store_id );
						$ipod_product_id = $this->loadingModel->specificIpodProductStoreCountForApp ( $ref_id, $store_id );
						echo json_encode ( array (
								"success" => "true",
								"total" => $total,
								"mac_count" => $mac_product_id,
								"ipad_count" => $ipad_product_id,
								"iphone_count" => $iphone_product_id,
								"ipod_count" => $ipod_product_id 
						) );
					} else {
						echo json_encode ( array (
								"success" => "false",
								"result" => "Please select the lead status" 
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
						"result" => "Invalid User" 
				) );
			}
		} catch ( Exception $e ) {
			throw new Exception ( $e->getMessage () );
		}
	}
}
