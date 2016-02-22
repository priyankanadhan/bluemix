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
}
