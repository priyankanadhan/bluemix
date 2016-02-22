<?php
class DashboardModel {
	/**
	 *
	 * @param object $db
	 *        	A PDO database connection
	 */
	function __construct($db) {
		try {
			$this->db = $db;
		} catch ( PDOException $e ) {
			exit ( 'Database connection could not be established.' );
		}
	}
	
	/**
	 * Get all Products from database
	 */
	public function getAllProductsCount($ref_id) {
		$sql = "SELECT count(customer_id) as total FROM customer Where lead_status='" . $ref_id . "'
				AND product_subcategory_id != '0'";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetch ();
	}
	public function exportForEmployeeLead($columns, $from, $to, $lead_type, $lead_status, $userId) {
		if ($_SESSION ['role'] == '4') {
			$sql = "select $columns
					from employee
					left join employee_role_store_designation on employee.id=employee_role_store_designation.employee_id
					left join store on store.store_id=employee_role_store_designation.store_id
				where store.store_region_id='" . $_SESSION ['store_region'] . "'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "select $columns
					from employee
					left join employee_role_store_designation on employee.id=employee_role_store_designation.employee_id
					left join store on store.store_id=employee_role_store_designation.store_id";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "select $columns
					from employee
					left join employee_role_store_designation on employee.id=employee_role_store_designation.employee_id
					left join store on store.store_id=employee_role_store_designation.store_id
					where store.store_id='" . $_SESSION ['store'] . "'";
		}
		
		$query = $this->db->prepare ( $sql );
		
		$query->execute (); // $parameters);
		$employeeIds = $query->fetchAll ( PDO::FETCH_ASSOC );
		$dataArray = "";
		
		if ($lead_status == "") {
			$lead_status = 'open';
		}
		if ($from != "") {
			$from = date ( "Y-m-d", strtotime ( $from ) );
		}
		if ($to != "") {
			$to = date ( "Y-m-d", strtotime ( $to ) );
		}
		// print_r($employeeIds);exit;
		foreach ( $employeeIds as $employeeId ) {
			$empId = $employeeId ['employee_id'];
			if ($lead_type != "") {
				$lead_type_value = "c.lead_type='" . $lead_type . "'";
				if (($from != "") && ($to == "")) {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,
							SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,
							Sum(c.product_category_id='4') as mac
					 	from employee as e
				    	left join customer as c on c.last_updated_by=e.id
				    	 where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,
							SUM(c.product_category_id='2') as iphone,
							SUM(c.product_category_id='3') as ipod,
							Sum(c.product_category_id='4') as mac
					       from employee as e
				           left join customer as c on c.last_updated_by=e.id
				           where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectsql = "select SUM(c.product_category_id='1') as ipad,
							SUM(c.product_category_id='2') as iphone,
							SUM(c.product_category_id='3') as ipod,
							Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} else {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,
							SUM(c.product_category_id='2') as iphone,
							SUM(c.product_category_id='3') as ipod,
							Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				}
			} else {
				if (($from != "") && ($to == "")) {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,
							SUM(c.product_category_id='2') as iphone,
							SUM(c.product_category_id='3') as ipod,
							Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND c.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,
							SUM(c.product_category_id='2') as iphone,
							SUM(c.product_category_id='3') as ipod,
							Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND c.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectsql = "select SUM(c.product_category_id='1') as ipad,
							SUM(c.product_category_id='2') as iphone,
							SUM(c.product_category_id='3') as ipod,
							Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND c.lead_status='" . $lead_status . "'";
				} else {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,
							SUM(c.product_category_id='2') as iphone,
							SUM(c.product_category_id='3') as ipod,
							Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND c.lead_status='" . $lead_status . "'";
				}
			}
			$query1 = $this->db->prepare ( $selectsql );
			// $parameters = array(':start' => $start,':limit'=> $limit);
			$query1->execute ();
			$count = $query1->fetch (); // $parameters);
			$employeeId ['iPadProduct'] = $count->ipad;
			$employeeId ['iPhoneProduct'] = $count->iphone;
			$employeeId ['MacProduct'] = $count->mac;
			$employeeId ['iPodProduct'] = $count->ipod;
			$employeeId ['GrandTotal'] = $employeeId ['iPadProduct'] + $employeeId ['iPhoneProduct'] + $employeeId ['iPodProduct'] + $employeeId ['MacProduct'];
			$dataArray [] = $employeeId;
		}
		return $dataArray;
	}
	public function getExportForStoreLead($colmns, $from, $to, $lead_type, $lead_status, $userId) {
		if ($_SESSION ['role'] == '4') {
			$sql = "SELECT $colmns
				from store  
			where store.store_region_id='" . $_SESSION ['store_region'] . "'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "SELECT $colmns
				from store 
				";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "SELECT $colmns
				from store  
			Where store.store_id='" . $_SESSION ['store'] . "'";
		}
		$query = $this->db->prepare ( $sql );
		$query->execute (); // $
		                    // print_r($query);exit;
		$stores = $query->fetchAll ( PDO::FETCH_ASSOC );
		$Count = "";
		if ($lead_status == "") {
			$lead_status = 'open';
		} // echo $lead_status;exit;
		  // echo $from;
		if ($from != "") {
			$from = date ( "Y-m-d", strtotime ( $from ) );
		}
		if ($to != "") {
			$to = date ( "Y-m-d", strtotime ( $to ) );
		}
		
		foreach ( $stores as $store ) {
			$storeId = $store ['store_id'];
			$storename = $store ['StoreName'];
			// print_r($storeId);echo "<br>";
			if ($lead_type != "") {
				$lead_type_value = "customer.lead_type='" . $lead_type . "'";
				if (($from != "") && ($to == "")) {
					// echo "$from";
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%d-%m-%Y'),
							SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer 
					where customer.store_id='" . $storeId . "' 
					AND $lead_type_value 
					AND customer.lead_status='" . $lead_status . "' 
					AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND NOW()";
					// exit;
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' 
					AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' 
					AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' 
					AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				}
			} else {
				if (($from != "") && ($to == "")) {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%d-%m-%Y'),
							customer.lead_status,
							SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' 
					AND customer.lead_status='" . $lead_status . "' 
					AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND NOW()";
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' 
					AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' AND customer.lead_status='" . $lead_status . "'";
				}
			}
			
			$query1 = $this->db->prepare ( $selectCount );
			
			$query1->execute ();
			$countData = $query1->fetch (); // print_r($countData);
			$store ['iPadProduct'] = $countData->ipad_product;
			$store ['iPhoneProduct'] = $countData->iphone_product;
			$store ['MacProduct'] = $countData->mac_product;
			$store ['iPodProduct'] = $countData->ipod_product;
			$store ['GrandTotal'] = $store ['iPadProduct'] + $store ['iPhoneProduct'] + $store ['MacProduct'] + $store ['iPodProduct'];
			// print_r($store ['GrandTotal']);exit;
			$Count [] = $store;
		} // exit;
		  // echo "<pre>";print_r($Count);exit;
		return $Count;
	}
	public function getExportForStoreDemo($columns, $from, $to, $lead_type, $lead_status, $userId) {
		if ($_SESSION ['role'] == '4') {
			$sql = "SELECT $columns
					from store 
					where store.store_region_id='" . $_SESSION ['store_region'] . "'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "SELECT $columns
					from store";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "SELECT $columns
					from store
					where store.store_id='" . $_SESSION ['store'] . "'";
		}
		
		$query = $this->db->prepare ( $sql );
		$query->execute (); // $
		$stores = $query->fetchAll ( PDO::FETCH_ASSOC );
		$Count = "";
		if ($lead_status == "") {
			$lead_status = 'open';
		}
		if ($from != "") {
			$from = date ( "Y-m-d", strtotime ( $from ) );
		}
		if ($to != "") {
			$to = date ( "Y-m-d", strtotime ( $to ) );
		}
		foreach ( $stores as $store ) {
			$storeId = $store ['store_id'];
			// $storename = $store ['store_name'];
			// print_r($storeId);
			if ($lead_type != "") {
				$lead_type_value = "customer.lead_type='" . $lead_type . "'";
				if (($from != "") && ($to == "")) {
					$selectCount = "SELECT cust_demo,
							SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT cust_demo,
							SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectCount = "SELECT cust_demo,
							SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT cust_demo,SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				}
			} else {
				if (($from != "") && ($to == "")) {
					$selectCount = "SELECT cust_demo,
							SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT cust_demo,
							SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND customer.lead_status='" . $lead_status . "' ";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectCount = "SELECT cust_demo,
							SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT cust_demo,
							SUM(product_category_id='1') ipad_product,
							SUM(product_category_id='2') iphone_product,
							SUM(product_category_id='3') ipod_product,
							SUM(product_category_id='4') mac_product 
							from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND customer.lead_status='" . $lead_status . "'";
				}
			}
			$query1 = $this->db->prepare ( $selectCount );
			// $parameters = array(':start' => $start,':limit'=> $limit);
			$query1->execute ();
			$countData = $query1->fetch ();
			$store ['iPadProduct'] = $countData->ipad_product;
			$store ['iPhoneProduct'] = $countData->iphone_product;
			$store ['MacProduct'] = $countData->mac_product;
			$store ['iPodProduct'] = $countData->ipod_product;
			$store ['GrandTotal'] = $store ['iPodProduct'] + $store ['iPadProduct'] + $store ['iPhoneProduct'] + $store ['MacProduct'];
			$Count [] = $store;
		}
		return $Count;
	}
	public function getExportForEmployeeDemo($columns, $from, $to, $lead_type, $lead_status, $userId) {
		if ($_SESSION ['role'] == '4') {
			$sql = "select $columns
				from employee
			   left join employee_role_store_designation on employee.id=employee_role_store_designation.employee_id
				left join store on store.store_id=employee_role_store_designation.store_id
				where store.store_region_id='" . $_SESSION ['store_region'] . "'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "select $columns
				from employee
			   left join employee_role_store_designation on employee.id=employee_role_store_designation.employee_id
				left join store on store.store_id=employee_role_store_designation.store_id
				";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "select $columns
				from employee
			   left join employee_role_store_designation on employee.id=employee_role_store_designation.employee_id
				left join store on store.store_id=employee_role_store_designation.store_id
				where store.store_id='" . $_SESSION ['store'] . "'";
		}
		
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		$employeeIds = $query->fetchAll ( PDO::FETCH_ASSOC );
		$dataArray = "";
		if ($lead_status == "") {
			$lead_status = 'open';
		}
		if ($from != "") {
			$from = date ( "Y-m-d", strtotime ( $from ) );
		}
		if ($to != "") {
			$to = date ( "Y-m-d", strtotime ( $to ) );
		}
		foreach ( $employeeIds as $employeeId ) {
			$empId = $employeeId ['employee_id'];
			
			if ($lead_type != "") {
				$lead_type_value = "c.lead_type='" . $lead_type . "'";
				if (($from != "") && ($to == "")) {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} else {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				}
			} else {
				if (($from != "") && ($to == "")) {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND c.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND c.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND c.lead_status='" . $lead_status . "'";
				} else {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND c.lead_status='" . $lead_status . "'";
				}
			}
			
			$query1 = $this->db->prepare ( $selectsql );
			// $parameters = array(':start' => $start,':limit'=> $limit);
			$query1->execute ();
			$count = $query1->fetch (); // $parameters);
			if (($from != "") && ($to == "")) {
				$selectDemosql = "select SUM(c.product_category_id='1') as ipad,
						SUM(c.product_category_id='2') as iphone,
						SUM(c.product_category_id='3') as ipod,
						Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' And c.cust_demo='Yes' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') >= '" . $from . "'";
			} elseif ($from != "" && $to != "") {
				$selectDemosql = "select SUM(c.product_category_id='1') as ipad,
						SUM(c.product_category_id='2') as iphone,
						SUM(c.product_category_id='3') as ipod,
						Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' And c.cust_demo='Yes' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "'";
			} elseif ($from == "" && $to != "") {
				// echo "dsfdsf";
				$selectDemosql = "select SUM(c.product_category_id='1') as ipad,
						SUM(c.product_category_id='2') as iphone,
						SUM(c.product_category_id='3') as ipod,
						Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' And c.cust_demo='Yes' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') <= '" . $to . "'";
			} else {
				$selectDemosql = "select SUM(c.product_category_id='1') as ipad,
						SUM(c.product_category_id='2') as iphone,
						SUM(c.product_category_id='3') as ipod,
						Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' And c.cust_demo='Yes'";
			}
			
			$query2 = $this->db->prepare ( $selectDemosql );
			// $parameters = array(':start' => $start,':limit'=> $limit);
			$query2->execute ();
			$countDemo = $query2->fetch ();
			
			$employeeId ['iPadDemo'] = $countDemo->ipad;
			$employeeId ['iPhoneDemo'] = $countDemo->iphone;
			$employeeId ['MacDemo'] = $countDemo->mac;
			$employeeId ['iPodDemo'] = $countDemo->ipod;
			// $employeeId ['grand_total_demo'] = $employeeId ['ipad_demo'] + $employeeId ['iphone_demo'] + $employeeId ['mac_demo'] + $employeeId ['ipod_demo'];
			
			$employeeId ['iPadProduct'] = $count->ipad;
			$employeeId ['iPhoneProduct'] = $count->iphone;
			$employeeId ['MacProduct'] = $count->mac;
			$employeeId ['iPodProduct'] = $count->ipod;
			// $employeeId ['grand_total'] = $employeeId ['ipod_product'] + $employeeId ['ipad_product'] + $employeeId ['iphone_product'] + $employeeId ['mac_product'];
			$dataArray [] = $employeeId;
		}
		// print_r($query->fetchAll ());exit;
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $dataArray;
	}
	public function getExportForStoreSource($columns, $from, $to, $lead_type, $lead_status, $userId) {
		if ($_SESSION ['role'] == '4') {
			$sql = "SELECT $columns
				from store where store.store_region_id='" . $_SESSION ['store_region'] . "'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "SELECT $columns
				from store";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "SELECT $columns
				from store where store.store_id='" . $_SESSION ['store'] . "'";
		}
		
		$query = $this->db->prepare ( $sql );
		$query->execute (); // $
		$stores = $query->fetchAll ( PDO::FETCH_ASSOC );
		$Count = "";
		if ($lead_status == "") {
			$lead_status = 'open';
		}
		if ($from != "") {
			$from = date ( "Y-m-d", strtotime ( $from ) );
		}
		if ($to != "") {
			$to = date ( "Y-m-d", strtotime ( $to ) );
		}
		foreach ( $stores as $store ) {
			$storeId = $store ['store_id'];
			$storename = $store ['StoreName'];
			// print_r($storeId);
			
			if ($lead_type != "") {
				$lead_type_value = "customer.lead_type='" . $lead_type . "'";
				if (($from != "") && ($to == "")) {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%d-%m-%Y') as last_updated_date,
							cust_demo,
							SUM(cust_source='Advertisement') advertise,
							SUM(cust_source='Inbound Call') inbound,
							SUM(cust_source='Outbound Call') outbound,
							SUM(cust_source='New Walkin') walkin 
							from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%d-%m-%Y') as last_updated_date,
							cust_demo,SUM(cust_source='Advertisement') advertise,
							SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,
							SUM(cust_source='New Walkin') walkin 
							from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%d-%m-%Y') as last_updated_date,
							cust_demo,SUM(cust_source='Advertisement') advertise,
							SUM(cust_source='Inbound Call') inbound,
							SUM(cust_source='Outbound Call') outbound,
							SUM(cust_source='New Walkin') walkin 
							from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT cust_demo,SUM(cust_source='Advertisement') advertise,SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,SUM(cust_source='New Walkin') walkin from customer
					where customer.store_id='" . $storeId . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				}
			} else {
				if (($from != "") && ($to == "")) {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') as last_updated_date,
							cust_demo,SUM(cust_source='Advertisement') advertise,
							SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,
							SUM(cust_source='New Walkin') walkin 
							from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') as last_updated_date,
							cust_demo,SUM(cust_source='Advertisement') advertise,
							SUM(cust_source='Inbound Call') inbound,
							SUM(cust_source='Outbound Call') outbound,
							SUM(cust_source='New Walkin') walkin 
							from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') as last_updated_date,
							cust_demo,SUM(cust_source='Advertisement') advertise,
							SUM(cust_source='Inbound Call') inbound,
							SUM(cust_source='Outbound Call') outbound,
							SUM(cust_source='New Walkin') walkin 
							from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT cust_demo,
							SUM(cust_source='Advertisement') advertise,
							SUM(cust_source='Inbound Call') inbound,
							SUM(cust_source='Outbound Call') outbound,
							SUM(cust_source='New Walkin') walkin 
							from customer
					where customer.store_id='" . $storeId . "' AND customer.lead_status='" . $lead_status . "'";
				}
			}
			$query1 = $this->db->prepare ( $selectCount );
			// $parameters = array(':start' => $start,':limit'=> $limit);
			$query1->execute ();
			$countData = $query1->fetch ();
			$store ['Advertise'] = $countData->advertise;
			$store ['Inbound'] = $countData->inbound;
			$store ['Outbound'] = $countData->outbound;
			$store ['Walkin'] = $countData->walkin;
			// $store['grand_total']=$countData->ipad_product+$countData->iphone_product+$countData->mac_product+$countData->ipod_product;
			// print_r($countData);
			$Count [] = $store;
		}
		return $Count;
	}
	public function specificMacProductCount($ref_id) {
		/*
		 * $sql = "SELECT count(m.product_id) as mac_product_id,count(n.product_id) as ipad_product_id,count(o.product_id) as iphone_product_id FROM
		 * product as
		 * LEFT JOIN product_category as m on product_category.product_category_id=m.product_category_id
		 * LEFT JOIN product_category as n on product_category.product_category_id=n.product_category_id
		 * LEFT JOIN product_category as o on product_category.product_category_id=o.product_category_id
		 * where m.product_category_id='4' AND n.product_category_id='1' AND o.product_category_id='5'";
		 */
		$sql = "SELECT t4.mac_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='4' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
				LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='4' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
				LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='4' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as mac_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='4' AND t4.lead_status='" . $ref_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIpadProductCount($ref_id) {
		$sql = "SELECT t4.ipad_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='1' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
	 			LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='1' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
	 			LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='1' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as ipad_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='1' AND t4.lead_status='" . $ref_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIphoneProductCount($ref_id) {
		$sql = "SELECT t4.iphone_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='2' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
				LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='2' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
				LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='2' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as iphone_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='2' AND t4.lead_status='" . $ref_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIpodProductCount($ref_id) {
		$sql = "SELECT t4.ipod_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='3' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
				LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='3' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
				LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='3' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as ipod_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='3' AND t4.lead_status='" . $ref_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
	}
	public function getStoreName() {
		$sql = "SELECT store_name from store";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $
		return $query->fetchAll ();
	}
	public function getAllCustomersSummaryCount() {
		if ($_SESSION ['role'] == '4') {
			$sql = "SELECT count(store_id) as total from store where store.store_region_id='" . $_SESSION ['store_region'] . "'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "SELECT count(store_id) as total from store";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "SELECT count(store_id) as total from store where store.store_id='" . $_SESSION ['store'] . "'";
		}
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $
		return $query->fetch ();
	}
	public function getAllEmployeeSummaryCount() {
		if ($_SESSION ['role'] == '4') {
			$sql = "SELECT count(e.id) as total from employee as e
				left join employee_role_store_designation as er on e.id=er.employee_id
				left join store as s on s.store_id=er.store_id
				where s.store_region_id='" . $_SESSION ['store_region'] . "'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "SELECT count(id) as total from employee";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "SELECT count(id) as total from employee 
					left join employee_role_store_designation as er on employee.id=er.employee_id
					where er.store_id='" . $_SESSION ['store'] . "'";
		}
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $
		                    // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function getLeadDetails($from, $to, $lead_type, $lead_status, $start, $limit, $searchKey, $orderStr, $userId) {
		if ($_SESSION ['role'] == '4') {
			$sql = "SELECT s.store_name,s.store_id as grand_total,s.store_id as ipad_product,s.store_id as iphone_product,s.store_id as mac_product,s.store_id as ipad_product,s.store_id 
				from store as s where s.store_region_id='" . $_SESSION ['store_region'] . "'";
			$search_vale = "AND s.store_name LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "SELECT s.store_name,s.store_id as grand_total,s.store_id as ipad_product,s.store_id as iphone_product,s.store_id as mac_product,s.store_id as ipad_product,s.store_id
				from store as s
				";
			$search_vale = "Where s.store_name LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "SELECT s.store_name,s.store_id as grand_total,s.store_id as ipad_product,s.store_id as iphone_product,s.store_id as mac_product,s.store_id as ipad_product,s.store_id
				from store as s Where s.store_id='" . $_SESSION ['store'] . "'";
			$search_vale = "AND s.store_name LIKE '%" . $searchKey . "%'";
		}
		// $parameters = array(':start' => $start,':limit'=> $limit);
		if ($searchKey) {
			$sql .= " ($search_vale)";
		}
		if ($orderStr != "") {
			$sql .= $orderStr;
		}
		
		if ($start >= 0 && $limit > 0) {
			
			$sql .= " LIMIT $start , $limit";
		}
		$query = $this->db->prepare ( $sql );
		$query->execute (); // $
		                    // print_r($query);exit;
		$stores = $query->fetchAll ( PDO::FETCH_ASSOC );
		$Count = "";
		
		if ($lead_status == "") {
			$lead_status = 'open';
		} // echo $lead_status;exit;
		  // echo $from;
		if ($from != "") {
			$from = date ( "Y-m-d", strtotime ( $from ) );
		}
		if ($to != "") {
			$to = date ( "Y-m-d", strtotime ( $to ) );
		}
		foreach ( $stores as $store ) {
			$storeId = $store ['store_id'];
			$storename = $store ['store_name'];
			// print_r($storeId);echo "<br>";
			if ($lead_type != "") {
				$lead_type_value = "customer.lead_type='" . $lead_type . "'";
				if (($from != "") && ($to == "")) {
					// echo "$from";
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%d-%m-%Y'),SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer 
					where customer.store_id='" . $storeId . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND NOW()";
					// exit;
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				}
			} else {
				if (($from != "") && ($to == "")) {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%d-%m-%Y'),customer.lead_status,SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND customer.lead_status='" . $lead_status . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND NOW()";
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND customer.lead_status='" . $lead_status . "'";
				}
			}
			$query1 = $this->db->prepare ( $selectCount );
			// print_r($query1);
			// exit;
			// $parameters = array(':start' => $start,':limit'=> $limit);
			$query1->execute ();
			$countData = $query1->fetch (); // print_r($countData);
			$store ['ipad_product'] = $countData->ipad_product;
			$store ['iphone_product'] = $countData->iphone_product;
			$store ['mac_product'] = $countData->mac_product;
			$store ['ipod_product'] = $countData->ipod_product;
			$store ['grand_total'] = $countData->ipad_product + $countData->iphone_product + $countData->mac_product + $countData->ipod_product;
			// print_r($countData);
			$Count [] = $store;
		} // exit;
		return $Count;
	}
	public function getLeadCount() {
		$sql = "SELECT count(store_id) as total from store";
		// echo $sql;
		
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    // print_r($query->fetchAll ());exit;
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetch ();
	}
	public function getAllEmployee($from, $to, $lead_type, $lead_status, $start, $limit, $searchKey, $orderStr, $userId) {
		if ($_SESSION ['role'] == '4') {
			$sql = "select e.id as employee_id,e.id as ipad_product,e.id as iphone_product,e.id as mac_product,e.id as ipod_product,e.id as grand_total,e.name as employee_name,s.store_name from employee as e
				left join employee_role_store_designation as er on e.id=er.employee_id
				left join store as s on s.store_id=er.store_id
				where s.store_region_id='" . $_SESSION ['store_region'] . "'";
			$search_vale = "Where e.name LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "select e.id as employee_id,e.id as ipad_product,e.id as iphone_product,e.id as mac_product,
					e.id as ipod_product,e.id as grand_total,e.name as employee_name,s.store_name from employee as e
					left join employee_role_store_designation as er on e.id=er.employee_id
					left join store as s on s.store_id=er.store_id
					";
			$search_vale = "Where e.name LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "select e.id as employee_id,
					e.id as ipad_product,e.id as iphone_product,
					e.id as mac_product,
					e.id as ipod_product,
					e.id as grand_total,
					e.name as employee_name,
					s.store_name 
					from employee as e
					left join employee_role_store_designation as er on e.id=er.employee_id
					left join store as s on s.store_id=er.store_id
					where s.store_id='" . $_SESSION ['store'] . "'";
			$search_vale = "AND e.name LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%'";
		}
		if ($searchKey) {
			$sql .= "($search_vale)";
		}
		if ($orderStr != "") {
			$sql .= $orderStr;
		}
		
		if ($start >= 0 && $limit > 0) {
			
			$sql .= " LIMIT $start , $limit";
		}
		
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		$employeeIds = $query->fetchAll ( PDO::FETCH_ASSOC );
		$dataArray = "";
		if ($lead_status == "") {
			$lead_status = 'open';
		}
		if ($from != "") {
			$from = date ( "Y-m-d", strtotime ( $from ) );
		}
		if ($to != "") {
			$to = date ( "Y-m-d", strtotime ( $to ) );
		}
		foreach ( $employeeIds as $employeeId ) {
			$empId = $employeeId ['employee_id'];
			if ($lead_type != "") {
				$lead_type_value = "c.lead_type='" . $lead_type . "'";
				if (($from != "") && ($to == "")) {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} else {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				}
			} else {
				if (($from != "") && ($to == "")) {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND c.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND c.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND c.lead_status='" . $lead_status . "'";
				} else {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND c.lead_status='" . $lead_status . "'";
				}
			}
			$query1 = $this->db->prepare ( $selectsql );
			$query1->execute ();
			$count = $query1->fetch (); // $parameters);
			$employeeId ['ipad_product'] = $count->ipad;
			$employeeId ['iphone_product'] = $count->iphone;
			$employeeId ['mac_product'] = $count->mac;
			$employeeId ['ipod_product'] = $count->ipod;
			$employeeId ['grand_total'] = $employeeId ['ipod_product'] + $employeeId ['ipad_product'] + $employeeId ['iphone_product'] + $employeeId ['mac_product'];
			$dataArray [] = $employeeId;
		}
		return $dataArray;
	}
	public function getAllStoreDemo($from, $to, $lead_type, $lead_status, $start, $limit, $searchKey, $orderStr, $userId) {
		if ($_SESSION ['role'] == '4') {
			$sql = "SELECT s.store_name,s.store_name as cust_demo,s.store_id as grand_total,s.store_id as ipad_product,s.store_id as iphone_product,s.store_id as mac_product,
				s.store_id as ipad_product,s.store_id from store as s where s.store_region_id='" . $_SESSION ['store_region'] . "'";
			$search_vale = "Where s.store_name LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "SELECT s.store_name,s.store_name as cust_demo,s.store_id as grand_total,s.store_id as ipad_product,s.store_id as iphone_product,s.store_id as mac_product,
			s.store_id as ipad_product,s.store_id from store as s";
			$search_vale = "Where s.store_name LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "SELECT s.store_name,s.store_name as cust_demo,s.store_id as grand_total,s.store_id as ipad_product,s.store_id as iphone_product,s.store_id as mac_product,
			s.store_id as ipad_product,s.store_id from store as s where s.store_id='" . $_SESSION ['store'] . "'";
			$search_vale = "AND s.store_name LIKE '%" . $searchKey . "%'";
		}
		
		if ($searchKey) {
			$sql .= " ($search_vale)";
		}
		if ($orderStr != "") {
			$sql .= $orderStr;
		}
		
		if ($start >= 0 && $limit > 0) {
			
			$sql .= " LIMIT $start , $limit";
		}
		$query = $this->db->prepare ( $sql );
		$query->execute (); // $
		$stores = $query->fetchAll ( PDO::FETCH_ASSOC );
		$Count = "";
		if ($lead_status == "") {
			$lead_status = 'open';
		}
		if ($from != "") {
			$from = date ( "Y-m-d", strtotime ( $from ) );
		}
		if ($to != "") {
			$to = date ( "Y-m-d", strtotime ( $to ) );
		}
		foreach ( $stores as $store ) {
			$storeId = $store ['store_id'];
			$storename = $store ['store_name'];
			// print_r($storeId);
			if ($lead_type != "") {
				$lead_type_value = "customer.lead_type='" . $lead_type . "'";
				if (($from != "") && ($to == "")) {
					$selectCount = "SELECT cust_demo,SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT cust_demo,SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					$selectCount = "SELECT cust_demo,SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT cust_demo,SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				}
			} else {
				if (($from != "") && ($to == "")) {
					$selectCount = "SELECT cust_demo,SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT cust_demo,SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND customer.lead_status='" . $lead_status . "' ";
				} elseif ($from == "" && $to != "") {
					// echo "dsfdsf";
					$selectCount = "SELECT cust_demo,SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT cust_demo,SUM(product_category_id='1') ipad_product,SUM(product_category_id='2') iphone_product,SUM(product_category_id='3') ipod_product,SUM(product_category_id='4') mac_product from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND customer.lead_status='" . $lead_status . "'";
				}
			}
			$query1 = $this->db->prepare ( $selectCount );
			$query1->execute ();
			$countData = $query1->fetch ();
			if (($countData->cust_demo) == 'Yes') {
				$store ['cust_demo'] = $countData->cust_demo;
			} else {
				$store ['cust_demo'] = "no";
			}
			$store ['ipad_product'] = $countData->ipad_product;
			$store ['iphone_product'] = $countData->iphone_product;
			$store ['mac_product'] = $countData->mac_product;
			$store ['ipod_product'] = $countData->ipod_product;
			$store ['grand_total'] = $countData->ipad_product + $countData->iphone_product + $countData->mac_product + $countData->ipod_product;
			// print_r($countData);
			$Count [] = $store;
		}
		return $Count;
	}
	public function getAllEmployeeDemo($from, $to, $lead_type, $lead_status, $start, $limit, $searchKey, $orderStr, $userId) {
		if ($_SESSION ['role'] == '4') {
			$sql = "select e.id as employee_id,e.id as ipad_product,e.id as iphone_product,e.id as mac_product,e.id as ipod_product,e.id as grand_total,
				e.id as ipad_demo,e.id as iphone_demo,
				e.id as mac_demo,e.id as ipod_demo,e.id as grand_total_demo,
				e.name as employee_name,s.store_name from employee as e
				left join employee_role_store_designation as er on e.id=er.employee_id
				left join store as s on s.store_id=er.store_id
				where s.store_region_id='" . $_SESSION ['store_region'] . "'";
			$search_vale = "Where e.name LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "select e.id as employee_id,e.id as ipad_product,e.id as iphone_product,e.id as mac_product,e.id as ipod_product,e.id as grand_total,
				e.id as ipad_demo,e.id as iphone_demo,
				e.id as mac_demo,e.id as ipod_demo,e.id as grand_total_demo,
				e.name as employee_name,s.store_name from employee as e
			   left join employee_role_store_designation as er on e.id=er.employee_id
				left join store as s on s.store_id=er.store_id
				";
			$search_vale = "WHERE e.name LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "select e.id as employee_id,e.id as ipad_product,e.id as iphone_product,e.id as mac_product,e.id as ipod_product,e.id as grand_total,
				e.id as ipad_demo,e.id as iphone_demo,
				e.id as mac_demo,e.id as ipod_demo,e.id as grand_total_demo,
				e.name as employee_name,s.store_name from employee as e
			   left join employee_role_store_designation as er on e.id=er.employee_id
				left join store as s on s.store_id=er.store_id
				where s.store_id='" . $_SESSION ['store'] . "'";
			$search_vale = "AND e.name LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%'";
		}
		if ($searchKey) {
			$sql .= "($search_vale)";
		}
		if ($orderStr != "") {
			$sql .= $orderStr;
		}
		
		if ($start >= 0 && $limit > 0) {
			
			$sql .= " LIMIT $start , $limit";
		}
		
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		$employeeIds = $query->fetchAll ( PDO::FETCH_ASSOC );
		$dataArray = "";
		if ($lead_status == "") {
			$lead_status = 'open';
		}
		if ($from != "") {
			$from = date ( "Y-m-d", strtotime ( $from ) );
		}
		if ($to != "") {
			$to = date ( "Y-m-d", strtotime ( $to ) );
		}
		foreach ( $employeeIds as $employeeId ) {
			$empId = $employeeId ['employee_id'];
			if ($lead_type != "") {
				$lead_type_value = "c.lead_type='" . $lead_type . "'";
				if (($from != "") && ($to == "")) {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				} else {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND $lead_type_value AND c.lead_status='" . $lead_status . "'";
				}
			} else {
				if (($from != "") && ($to == "")) {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND c.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND c.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND c.lead_status='" . $lead_status . "'";
				} else {
					$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND c.lead_status='" . $lead_status . "'";
				}
			}
			
			$query1 = $this->db->prepare ( $selectsql );
			$query1->execute ();
			$count = $query1->fetch ();
			if (($from != "") && ($to == "")) {
				$selectDemosql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' And c.cust_demo='Yes' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') >= '" . $from . "'";
			} elseif ($from != "" && $to != "") {
				$selectDemosql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' And c.cust_demo='Yes' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "'";
			} elseif ($from == "" && $to != "") {
				$selectDemosql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' And c.cust_demo='Yes' AND DATE_FORMAT(c.last_updated_date,'%Y-%m-%d') <= '" . $to . "'";
			} else {
				$selectDemosql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' And c.cust_demo='Yes'";
			}
			$query2 = $this->db->prepare ( $selectDemosql );
			$query2->execute ();
			$countDemo = $query2->fetch ();
			
			$employeeId ['ipad_demo'] = $countDemo->ipad;
			$employeeId ['iphone_demo'] = $countDemo->iphone;
			$employeeId ['mac_demo'] = $countDemo->mac;
			$employeeId ['ipod_demo'] = $countDemo->ipod;
			$employeeId ['grand_total_demo'] = $employeeId ['ipad_demo'] + $employeeId ['iphone_demo'] + $employeeId ['mac_demo'] + $employeeId ['ipod_demo'];
			
			$employeeId ['ipad_product'] = $count->ipad;
			$employeeId ['iphone_product'] = $count->iphone;
			$employeeId ['mac_product'] = $count->mac;
			$employeeId ['ipod_product'] = $count->ipod;
			$employeeId ['grand_total'] = $employeeId ['ipod_product'] + $employeeId ['ipad_product'] + $employeeId ['iphone_product'] + $employeeId ['mac_product'];
			$dataArray [] = $employeeId;
		}
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $dataArray;
	}
	public function getAllStoreSource($from, $to, $lead_type, $lead_status, $start, $limit, $searchKey, $orderStr, $userId) {
		if ($_SESSION ['role'] == '4') {
			$sql = "SELECT s.store_name,
					s.store_id as advertise,
					s.store_id as inbound,
					s.store_id as outbound,
					s.store_id as walkin,
					s.store_id 
				from store as s where s.store_region_id='" . $_SESSION ['store_region'] . "'";
			$search_vale = "where s.store_name LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == '1') {
			$sql = "SELECT s.store_name,
					s.store_id as advertise,
					s.store_id as inbound,
					s.store_id as outbound,
					s.store_id as walkin,
					s.store_id
				from store as s";
			$search_vale = "where s.store_name LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == '2') {
			$sql = "SELECT s.store_name,
					s.store_id as advertise,
					s.store_id as inbound,
					s.store_id as outbound,
					s.store_id as walkin,
					s.store_id
				from store as s where s.store_id='" . $_SESSION ['store'] . "'";
			$search_vale = "AND s.store_name LIKE '%" . $searchKey . "%'";
		}
		
		if ($searchKey) {
			$sql .= "($search_vale)";
		}
		if ($orderStr != "") {
			$sql .= $orderStr;
		}
		
		if ($start >= 0 && $limit > 0) {
			
			$sql .= " LIMIT $start , $limit";
		}
		$query = $this->db->prepare ( $sql );
		$query->execute (); // $
		$stores = $query->fetchAll ( PDO::FETCH_ASSOC );
		$Count = "";
		if ($lead_status == "") {
			$lead_status = 'open';
		}
		if ($from != "") {
			$from = date ( "Y-m-d", strtotime ( $from ) );
		}
		if ($to != "") {
			$to = date ( "Y-m-d", strtotime ( $to ) );
		}
		foreach ( $stores as $store ) {
			$storeId = $store ['store_id'];
			$storename = $store ['store_name'];
			if ($lead_type != "") {
				$lead_type_value = "customer.lead_type='" . $lead_type . "'";
				if (($from != "") && ($to == "")) {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%d-%m-%Y') as last_updated_date,cust_demo,SUM(cust_source='Advertisement') advertise,SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,SUM(cust_source='New Walkin') walkin from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%d-%m-%Y') as last_updated_date,cust_demo,SUM(cust_source='Advertisement') advertise,SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,SUM(cust_source='New Walkin') walkin from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%d-%m-%Y') as last_updated_date,cust_demo,SUM(cust_source='Advertisement') advertise,SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,SUM(cust_source='New Walkin') walkin from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT cust_demo,SUM(cust_source='Advertisement') advertise,SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,SUM(cust_source='New Walkin') walkin from customer
					where customer.store_id='" . $storeId . "' AND $lead_type_value AND customer.lead_status='" . $lead_status . "'";
				}
			} else {
				if (($from != "") && ($to == "")) {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') as last_updated_date,cust_demo,SUM(cust_source='Advertisement') advertise,SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,SUM(cust_source='New Walkin') walkin from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') >= '" . $from . "' AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from != "" && $to != "") {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') as last_updated_date,cust_demo,SUM(cust_source='Advertisement') advertise,SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,SUM(cust_source='New Walkin') walkin from customer
					where customer.store_id='" . $storeId . "' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') between '" . $from . "' AND '" . $to . "' AND customer.lead_status='" . $lead_status . "'";
				} elseif ($from == "" && $to != "") {
					$selectCount = "SELECT DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') as last_updated_date,cust_demo,SUM(cust_source='Advertisement') advertise,SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,SUM(cust_source='New Walkin') walkin from customer
					where customer.store_id='" . $storeId . "' AND cust_demo='yes' AND DATE_FORMAT(customer.last_updated_date,'%Y-%m-%d') <= '" . $to . "' AND customer.lead_status='" . $lead_status . "'";
				} else {
					$selectCount = "SELECT cust_demo,SUM(cust_source='Advertisement') advertise,SUM(cust_source='Inbound Call') inbound,SUM(cust_source='Outbound Call') outbound,SUM(cust_source='New Walkin') walkin from customer
					where customer.store_id='" . $storeId . "' AND customer.lead_status='" . $lead_status . "'";
				}
			}
			$query1 = $this->db->prepare ( $selectCount );
			$query1->execute ();
			$countData = $query1->fetch ();
			if (($countData->cust_demo) == 'Yes') {
				$store ['cust_demo'] = $countData->cust_demo;
			} else {
				$store ['cust_demo'] = "no";
			}
			$store ['advertise'] = $countData->advertise;
			$store ['inbound'] = $countData->inbound;
			$store ['outbound'] = $countData->outbound;
			$store ['walkin'] = $countData->walkin;
			// $store['grand_total']=$countData->ipad_product+$countData->iphone_product+$countData->mac_product+$countData->ipod_product;
			// print_r($countData);
			$Count [] = $store;
		}
		return $Count;
	}
	public function specificMacProductStoreCount($ref_id) {
		/*
		 * $sql = "SELECT count(m.product_id) as mac_product_id,count(n.product_id) as ipad_product_id,count(o.product_id) as iphone_product_id FROM
		 * product as
		 * LEFT JOIN product_category as m on product_category.product_category_id=m.product_category_id
		 * LEFT JOIN product_category as n on product_category.product_category_id=n.product_category_id
		 * LEFT JOIN product_category as o on product_category.product_category_id=o.product_category_id
		 * where m.product_category_id='4' AND n.product_category_id='1' AND o.product_category_id='5'";
		 */
		$sql = "SELECT t4.mac_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='4' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 	        		AND t1.store_id='" . $_SESSION ['store'] . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
				LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='4' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 	        		AND t2.store_id='" . $_SESSION ['store'] . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
				LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='4' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 	        		AND t3.store_id='" . $_SESSION ['store'] . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as mac_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='4' AND t4.lead_status='" . $ref_id . "' AND t4.store_id='" . $_SESSION ['store'] . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIpadProductStoreCount($ref_id) {
		$sql = "SELECT t4.ipad_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='1' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 	        		AND t1.store_id='" . $_SESSION ['store'] . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
	 			LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='1' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 	        		AND t2.store_id='" . $_SESSION ['store'] . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
	 			LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='1' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 	        		AND t3.store_id='" . $_SESSION ['store'] . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as ipad_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='1' AND t4.lead_status='" . $ref_id . "' AND t4.store_id='" . $_SESSION ['store'] . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIphoneProductStoreCount($ref_id) {
		$sql = "SELECT t4.iphone_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='2' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 	        		AND t1.store_id='" . $_SESSION ['store'] . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
				LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='2' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 	        		AND t2.store_id='" . $_SESSION ['store'] . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
				LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='2' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 	        		AND t3.store_id='" . $_SESSION ['store'] . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as iphone_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='2' AND t4.lead_status='" . $ref_id . "' AND t4.store_id='" . $_SESSION ['store'] . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIpodProductStoreCount($ref_id) {
		$sql = "SELECT t4.ipod_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='3' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 	        		AND t1.store_id='" . $_SESSION ['store'] . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
				LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='3' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 	        		AND t2.store_id='" . $_SESSION ['store'] . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
				LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='3' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 	        		AND t3.store_id='" . $_SESSION ['store'] . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as ipod_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='3' AND t4.lead_status='" . $ref_id . "' AND t4.store_id='" . $_SESSION ['store'] . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
	}
	public function getAllProductsStoreCount($ref_id) {
		$sql = "SELECT count(customer_id) as total FROM customer Where lead_status='" . $ref_id . "'
				AND store_id='" . $_SESSION ['store'] . "' AND product_subcategory_id != '0'";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetch ();
	}
	
	/**
	 * service for app
	 */
	public function getAllProductsStoreCountForApp($ref_id, $store_id) {
		$sql = "SELECT count(customer_id) as total FROM customer Where lead_status='" . $ref_id . "'
				AND store_id='" . $store_id . "' AND product_subcategory_id != '0'";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetch ();
	}
	public function specificMacProductStoreCountForApp($ref_id, $store_id) {
		/*
		 * $sql = "SELECT count(m.product_id) as mac_product_id,count(n.product_id) as ipad_product_id,count(o.product_id) as iphone_product_id FROM
		 * product as
		 * LEFT JOIN product_category as m on product_category.product_category_id=m.product_category_id
		 * LEFT JOIN product_category as n on product_category.product_category_id=n.product_category_id
		 * LEFT JOIN product_category as o on product_category.product_category_id=o.product_category_id
		 * where m.product_category_id='4' AND n.product_category_id='1' AND o.product_category_id='5'";
		 */
		$sql = "SELECT t4.mac_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='4' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 	        		AND t1.store_id='" . $store_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
				LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='4' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 	        		AND t2.store_id='" . $store_id . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
				LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='4' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 	        		AND t3.store_id='" . $store_id . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as mac_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='4' AND t4.lead_status='" . $ref_id . "' AND t4.store_id='" . $store_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIpadProductStoreCountForApp($ref_id, $store_id) {
		$sql = "SELECT t4.ipad_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='1' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 	        		AND t1.store_id='" . $store_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
	 			LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='1' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 	        		AND t2.store_id='" . $store_id . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
	 			LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='1' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 	        		AND t3.store_id='" . $store_id . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as ipad_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='1' AND t4.lead_status='" . $ref_id . "' AND t4.store_id='" . $store_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIphoneProductStoreCountForApp($ref_id, $store_id) {
		$sql = "SELECT t4.iphone_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='2' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 	        		AND t1.store_id='" . $store_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
				LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='2' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 	        		AND t2.store_id='" . $store_id . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
				LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='2' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 	        		AND t3.store_id='" . $store_id . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as iphone_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='2' AND t4.lead_status='" . $ref_id . "' AND t4.store_id='" . $store_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIpodProductStoreCountForApp($ref_id) {
		$sql = "SELECT t4.ipod_product_id,t1.east_region_id,t2.north_region_id,t3.south_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as east_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='3' AND n.store_region_id=1 AND t1.lead_status='" . $ref_id . "'
	 	        		AND t1.store_id='" . $store_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t2.customer_id,count(o.store_region_id) as north_region_id
	 			FROM
	 			customer as t2
				LEFT JOIN store as s on t2.store_id=s.store_id
	 			LEFT JOIN store_region as o on s.store_region_id=o.store_region_id
	 	        where t2.product_category_id='3' AND o.store_region_id=2 AND t2.lead_status='" . $ref_id . "'
	 	        		AND t2.store_id='" . $store_id . "'
	 			)t2
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select t3.customer_id,count(p.store_region_id) as south_region_id
	 			FROM
	 			customer as t3
				LEFT JOIN store as s on t3.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t3.product_category_id='3' AND p.store_region_id=3 AND t3.lead_status='" . $ref_id . "'
	 	        		AND t3.store_id='" . $store_id . "'
	 			)t3
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as ipod_product_id
	 			FROM
	 			customer as t4
	 	        where t4.product_category_id='3' AND t4.lead_status='" . $ref_id . "' AND t4.store_id='" . $store_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
	}
	/**
	 * Get role name
	 */
	public function getRoleNameByRoleId($id) {
		$sql = "select * from role where role_id=$id";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		return $query->fetch ();
	}
	public function getEmployeeId($id) {
		$sql = "select * from login where login_id=$id";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		return $query->fetch ();
	}
	/**
	 *
	 * @param unknown $userId        	
	 */
	public function getEmployeeOtherDetails($userId) {
		$sql = "SELECT employee_role_store_designation.*,store.store_id,store_region.store_region_id
					FROM employee_role_store_designation
						left join store on store.store_id = employee_role_store_designation.store_id
					    left join store_region on store.store_region_id = store_region.store_region_id
					where employee_role_store_designation.employee_id = :userid and employee_role_store_designation.active_status = '1' LIMIT 1";
		
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':userid' => $userId 
		);
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		$query->execute ( $parameters );
		
		// fetch() is the PDO method that get exactly one result
		return $query->fetch ();
	}
	public function getEmployeeDashboard($empId, $lead_status) {
		$selectsql = "select SUM(c.product_category_id='1') as ipad,SUM(c.product_category_id='2') as iphone,SUM(c.product_category_id='3') as ipod,Sum(c.product_category_id='4') as mac
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND c.lead_status='" . $lead_status . "'";
		$query = $this->db->prepare ( $selectsql );
		$parameters = array (
				':userid' => $userId 
		);
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		$query->execute ( $parameters );
		
		// fetch() is the PDO method that get exactly one result
		return $query->fetch ();
	}
	public function getEmployeeLeadCount($empId, $lead_status) {
		$selectsql = "select count(c.customer_id) as total
					 from employee as e
				    left join customer as c on c.last_updated_by=e.id
				     where e.id='" . $empId . "' AND c.lead_status='" . $lead_status . "'";
		$query = $this->db->prepare ( $selectsql );
		$parameters = array (
				':userid' => $userId 
		);
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		$query->execute ( $parameters );
		
		// fetch() is the PDO method that get exactly one result
		return $query->fetch ();
	}
}
