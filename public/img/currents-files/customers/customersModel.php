<?php
class CustomersModel {
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
	public function getEmployeeById($employeeId) {
		$sql = "SELECT name as employee_name,id as employee_id from employee where id=:id";
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':id' => $employeeId 
		);
		$query->execute ( $parameters ); // $parameters);
		                               // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                               // core/controller.php! If you prefer to get an associative array as the result, then do
		                               // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                               // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getEmployeesByStoreId($storeId) {
		$sql = "SELECT name as employee_name,id as employee_id from employee 
				left join employee_role_store_designation on employee_role_store_designation.employee_id=employee.id
				where employee_role_store_designation.store_id=:store_id";
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':store_id' => $storeId 
		);
		$query->execute ( $parameters ); // $parameters);
		
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllRegions() {
		$sql = "SELECT store_region_name as store_region_name,store_region_id as store_region_id from store_region";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllStoresByRegionId($region_id) {
		$sql = "SELECT store_name as store_name,store_id as store_id from store where store_region_id=:region_id";
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':region_id' => $region_id 
		);
		$query->execute ( $parameters ); // $parameters);
		                               // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                               // core/controller.php! If you prefer to get an associative array as the result, then do
		                               // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                               // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllEmployees() {
		$sql = "SELECT name as employee_name,id as employees_id from employee";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	/* Added by Suresh G
	   getting employees under Manager-Role 2
	*/
	public function getAllEmployeesByStoreId($storeId) {
		$sql = "SELECT name as employee_name,id as employees_id from employee 
				left join employee_role_store_designation on employee_role_store_designation.employee_id=employee.id
				where employee_role_store_designation.store_id=:store_id";
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':store_id' => $storeId 
		);
		$query->execute ( $parameters ); // $parameters);
		
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	/**
	 * Get a song from database
	 */
	public function getCustomersHistory($customersId) {
		$sql = "SELECT * FROM customer_history where customer_id = '" . $customersId . "' ORDER BY updated_date DESC";
		$query = $this->db->prepare ( $sql );
		
		$query->execute (); // $parameters);
		                    
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ();
	}
	public function validateUserAgainstCustomer($customersId, $userId) {
		$sql = "SELECT * FROM customer where customer_id = '" . $customersId . "' AND last_updated_by='" . $userId . "' and lead_status='open'";
		$query = $this->db->prepare ( $sql );
		
		$query->execute ();
		
		// fetch() is the PDO method that get exactly one result
		$res = $query->fetch ();
		if (isset ( $res )) {
			return true;
		} else {
			return false;
		}
	}
	public function addHistory($comments, $lastUpdatedBy = "", $customerId, $followupDate) {
		$sql = "INSERT INTO `customer_history`
							(`id`,
							`customer_comments`,
							`updated_by`,
							`updated_date`,
							`next_followup_date`,
							`customer_id`)
							VALUES
							(NULL,
							:customer_comments,
							:updated_by,
							:updated_date,
							:next_followup_date,
							:customer_id )";
		
		$query = $this->db->prepare ( $sql );
		
		$parameters = array (
				':customer_comments' => $comments,
				':updated_by' => $lastUpdatedBy,
				':updated_date' => date ( 'Y-m-d H:i:s' ),
				':next_followup_date' => $followupDate,
				':customer_id' => $customerId 
		);
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		// echo $sql;exit;
		return $query->execute ( $parameters );
	}
	public function updateLeadStatus($status, $customerId, $userId, $nextFollowupDate) {
		$sql = "UPDATE `customer` 
    				SET `lead_status` ='" . $status . "',
    					`next_followup` = '" . $nextFollowupDate . "' 
    			WHERE `customer_id` ='" . $customerId . "' and last_updated_by = '" . $userId . "'";
		
		$query = $this->db->prepare ( $sql );
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		//print_r($query);exit;
		return $query->execute ();
	}
	
	/**
	 * Get all songs from database
	 */
	public function getOpenCustomers($start, $limit, $searchKey, $orderStr, $userId) {
		$sql = "SELECT
                    c.customer_id,
                    c.firstname,
                    c.email,
                    c.phone,
					pc.product_category_name,
					c.product_id,
					DATE_FORMAT(c.last_updated_date,'%d-%M-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%M-%Y') as next_followup
                 FROM customer as c 
				 LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id
				 WHERE c.lead_status='open' and c.last_updated_by = '" . $userId . "' ";
		
		if ($searchKey) {
			$sql .= " AND (c.firstname LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%')";
		}
		if ($orderStr != "") {
			$sql .= $orderStr;
		}
		
		if ($start >= 0 && $limit > 0) {
			
			$sql .= " LIMIT $start , $limit";
		}
		
		// echo $sql;
		
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllCustomerLeads($regionId, $storeId, $employee, $start, $limit, $searchKey, $orderStr, $userId) {
		$colums='';
		$joins='';
		$search_vale='';
		$condition='';
		if ($_SESSION ['role'] == "1") {
			$colums = "sr.store_region_name,s.store_name,e.name as employee_name,e.employees_id,c.customer_id,c.lead_status, c.firstname, c.email,c.phone,pc.product_category_name,c.product_id,DATE_FORMAT(c.last_updated_date,'%d-%m-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%m-%Y') as next_followup";
			$search_vale = "e.name LIKE '%" . $searchKey . "%' OR e.employees_id LIKE '%" . $searchKey . "%' OR c.lead_status LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%' OR sr.store_region_name LIKE '%" . $searchKey . "%' OR c.firstname LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%'";
			if ($regionId != "") {
				$joins = "LEFT JOIN product_category as pc on c.product_subcategory_id=pc.product_category_id
					LEFT JOIN employee as e on c.last_updated_by=e.id
		    		LEFT JOIN employee_role_store_designation as r on c.last_updated_by=r.employee_id
		    		LEFT JOIN store as s on s.store_id=r.store_id
		    		LEFT JOIN store_region as sr on sr.store_region_id=s.store_region_id";
				if ($employee != "" && $regionId != "") {
					$condition = 'e.id="' . $employee . '" and sr.store_region_id="' . $regionId . '"';
				} elseif ($employee != "" && $regionId != "" && $storeId != "") {
					$condition = 'e.id="' . $employee . '" and sr.store_region_id="' . $regionId . '" and s.store_id="' . $storeId . '"';
				} elseif ($regionId != "" && $storeId != "") {
					$condition = 'sr.store_region_id="' . $regionId . '" and s.store_id="' . $storeId . '"';
				} elseif($regionId != "") {
					$condition = 'sr.store_region_id="' . $regionId . '"';
				}else{
					$condition='1';
				}
			} else {
				$joins = "LEFT JOIN product_category as pc on c.product_subcategory_id=pc.product_category_id
					LEFT JOIN employee as e on c.last_updated_by=e.id
					LEFT JOIN employee_role_store_designation as r on c.last_updated_by=r.employee_id
		    		LEFT JOIN store as s on s.store_id=r.store_id
		    		LEFT JOIN store_region as sr on sr.store_region_id=s.store_region_id";
				$condition = '1';
			}
		} elseif ($_SESSION ['role'] == "2") {
			$colums = "e.name as employee_name,e.employees_id,c.lead_status,c.customer_id, c.firstname, c.email,c.phone,pc.product_category_name,c.product_id,DATE_FORMAT(c.last_updated_date,'%d-%m-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%m-%Y') as next_followup";
			
			$joins = "LEFT JOIN product_category as pc on c.product_subcategory_id=pc.product_category_id
					LEFT JOIN employee as e on c.last_updated_by=e.id
					";
			if ($employee != "") {
				$condition = 'e.id="' . $employee . '"';
			} 
			elseif ($_SESSION ['store'] != "") {
				$condition = 'c.store_id="' . $_SESSION ['store'] . '"';
			} 
			else {
				$condition = '1';
			}
			$search_vale = "e.name LIKE '%" . $searchKey . "%' OR e.employees_id LIKE '%" . $searchKey . "%' OR c.lead_status LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == "3") {
			$colums = "c.customer_id, c.firstname, c.email,c.phone,pc.product_category_name,c.product_id,DATE_FORMAT(c.last_updated_date,'%d-%m-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%M-%Y') as next_followup";
			$search_vale = "c.firstname LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%'";
			$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id";
			$condition = "c.lead_status='open' and c.last_updated_by = '" . $userId . "'";
		}elseif($_SESSION ['role'] == "4"){
			$colums = "sr.store_region_name,s.store_name,e.name as employee_name,e.employees_id,c.customer_id,c.lead_status, c.firstname, c.email,c.phone,pc.product_category_name,c.product_id,DATE_FORMAT(c.last_updated_date,'%d-%m-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%m-%Y') as next_followup";
			$search_vale = "e.name LIKE '%" . $searchKey . "%' OR e.employees_id LIKE '%" . $searchKey . "%' OR c.lead_status LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%' OR sr.store_region_name LIKE '%" . $searchKey . "%' OR c.firstname LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%'";
			if ($regionId != "") {
				$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id
					LEFT JOIN employee as e on c.last_updated_by=e.id
		    		LEFT JOIN employee_role_store_designation as r on c.last_updated_by=r.employee_id
		    		LEFT JOIN store as s on s.store_id=r.store_id
		    		LEFT JOIN store_region as sr on sr.store_region_id=s.store_region_id";
				if ($employee != "" && $regionId != "") {
					$condition = 'e.id="' . $employee . '" and sr.store_region_id="' . $regionId . '"';
				} elseif ($employee != "" && $regionId != "" && $storeId != "") {
					$condition = 'e.id="' . $employee . '" and sr.store_region_id="' . $regionId . '" and s.store_id="' . $storeId . '"';
				} elseif ($regionId != "" && $storeId != "") {
					$condition = 'sr.store_region_id="' . $regionId . '" and s.store_id="' . $storeId . '"';
				} elseif($regionId != "") {
					$condition = 'sr.store_region_id="' . $regionId . '"';
				}else{
					$condition='1';
				}
			} else {
				$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id
					LEFT JOIN employee as e on c.last_updated_by=e.id
					LEFT JOIN employee_role_store_designation as r on c.last_updated_by=r.employee_id
		    		LEFT JOIN store as s on s.store_id=r.store_id
		    		LEFT JOIN store_region as sr on sr.store_region_id=s.store_region_id";
				$condition = '1';
			}
		}else{
			$colums = "c.customer_id, c.firstname, c.email,c.phone,pc.product_category_name,c.product_id,DATE_FORMAT(c.last_updated_date,'%d-%m-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%M-%Y') as next_followup";
			$search_vale = "c.firstname LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%'";
			$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id";
			$condition = "c.lead_status='open' and c.last_updated_by = '" . $userId . "'";
		}
		//print_r($colums);exit;
		$sql = "SELECT
                    $colums
                 FROM customer as c
				 $joins
				 WHERE $condition";
		
		if ($searchKey) {
			$sql .= " AND ($search_vale)";
		}
		if ($orderStr != "") {
			$sql .= $orderStr;
		}
		
		if ($start >= 0 && $limit > 0) {
			
			$sql .= " LIMIT $start , $limit";
		}
		
		// echo $sql;
		
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    // print_r($query->fetchAll ());exit;
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	/**
	 * Get all Products from database
	 */
	public function getCustomersCount($regionId,$storeId, $employee,$searchKey = '', $userId) {
	if ($_SESSION ['role'] == "1") {
			$colums = "sr.store_region_name,s.store_name,e.name as employee_name,e.employees_id,c.customer_id,c.lead_status, c.firstname, c.email,c.phone,pc.product_category_name,c.product_id,DATE_FORMAT(c.last_updated_date,'%d-%m-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%m-%Y') as next_followup";
			$search_vale = "e.name LIKE '%" . $searchKey . "%' OR e.employees_id LIKE '%" . $searchKey . "%' OR c.lead_status LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%' OR sr.store_region_name LIKE '%" . $searchKey . "%' OR c.firstname LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%'";
			if ($regionId != "") {
				$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id
					LEFT JOIN employee as e on c.last_updated_by=e.id
		    		LEFT JOIN employee_role_store_designation as r on c.last_updated_by=r.employee_id
		    		LEFT JOIN store as s on s.store_id=r.store_id
		    		LEFT JOIN store_region as sr on sr.store_region_id=s.store_region_id";
				if ($employee != "" && $regionId != "") {
					$condition = 'e.id="' . $employee . '" and sr.store_region_id="' . $regionId . '"';
				} elseif ($employee != "" && $regionId != "" && $storeId != "") {
					$condition = 'e.id="' . $employee . '" and sr.store_region_id="' . $regionId . '" and s.store_id="' . $storeId . '"';
				} elseif ($regionId != "" && $storeId != "") {
					$condition = 'sr.store_region_id="' . $regionId . '" and s.store_id="' . $storeId . '"';
				} elseif($regionId != "") {
					$condition = 'sr.store_region_id="' . $regionId . '"';
				}else{
					$condition='1';
				}
			} else {
				$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id
					LEFT JOIN employee as e on c.last_updated_by=e.id
					LEFT JOIN employee_role_store_designation as r on c.last_updated_by=r.employee_id
		    		LEFT JOIN store as s on s.store_id=r.store_id
		    		LEFT JOIN store_region as sr on sr.store_region_id=s.store_region_id";
				$condition = '1';
			}
		} elseif ($_SESSION ['role'] == "2") {
			$colums = "e.name as employee_name,e.employees_id,c.lead_status,c.customer_id, c.firstname, c.email,c.phone,pc.product_category_name,c.product_id,DATE_FORMAT(c.last_updated_date,'%d-%m-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%m-%Y') as next_followup";
			
			$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id
					LEFT JOIN employee as e on c.last_updated_by=e.id
					";
			if ($employee != "") {
				$condition = 'e.id="' . $employee . '"';
			} 
			elseif ($_SESSION ['store'] != "") {
				$condition = 'c.store_id="' . $_SESSION ['store'] . '"';
			} 
			else {
				$condition = '1';
			}
			$search_vale = "e.name LIKE '%" . $searchKey . "%' OR e.employees_id LIKE '%" . $searchKey . "%' OR c.lead_status LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%'";
		} elseif ($_SESSION ['role'] == "3") {
			$colums = "c.customer_id, c.firstname, c.email,c.phone,pc.product_category_name,c.product_id,DATE_FORMAT(c.last_updated_date,'%d-%m-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%M-%Y') as next_followup";
			$search_vale = "c.firstname LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%'";
			$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id";
			$condition = "c.lead_status='open' and c.last_updated_by = '" . $userId . "'";
			}elseif($_SESSION ['role'] == "4"){
				$colums = "sr.store_region_name,s.store_name,e.name as employee_name,e.employees_id,c.customer_id,c.lead_status, c.firstname, c.email,c.phone,pc.product_category_name,c.product_id,DATE_FORMAT(c.last_updated_date,'%d-%m-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%m-%Y') as next_followup";
				$search_vale = "e.name LIKE '%" . $searchKey . "%' OR e.employees_id LIKE '%" . $searchKey . "%' OR c.lead_status LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%' OR sr.store_region_name LIKE '%" . $searchKey . "%' OR c.firstname LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%'";
				if ($regionId != "") {
					$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id
					LEFT JOIN employee as e on c.last_updated_by=e.id
		    		LEFT JOIN employee_role_store_designation as r on c.last_updated_by=r.employee_id
		    		LEFT JOIN store as s on s.store_id=r.store_id
		    		LEFT JOIN store_region as sr on sr.store_region_id=s.store_region_id";
					if ($employee != "" && $regionId != "") {
						$condition = 'e.id="' . $employee . '" and sr.store_region_id="' . $regionId . '"';
					} elseif ($employee != "" && $regionId != "" && $storeId != "") {
						$condition = 'e.id="' . $employee . '" and sr.store_region_id="' . $regionId . '" and s.store_id="' . $storeId . '"';
					} elseif ($regionId != "" && $storeId != "") {
						$condition = 'sr.store_region_id="' . $regionId . '" and s.store_id="' . $storeId . '"';
					} elseif($regionId != "") {
						$condition = 'sr.store_region_id="' . $regionId . '"';
					}else{
						$condition='1';
					}
				} else {
					$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id
					LEFT JOIN employee as e on c.last_updated_by=e.id
					LEFT JOIN employee_role_store_designation as r on c.last_updated_by=r.employee_id
		    		LEFT JOIN store as s on s.store_id=r.store_id
		    		LEFT JOIN store_region as sr on sr.store_region_id=s.store_region_id";
					$condition = '1';
				}
		}else{
			$colums = "c.customer_id, c.firstname, c.email,c.phone,pc.product_category_name,c.product_id,DATE_FORMAT(c.last_updated_date,'%d-%m-%Y') as last_updated_date,
    				DATE_FORMAT(c.next_followup,'%d-%M-%Y') as next_followup";
			$search_vale = "c.firstname LIKE '%" . $searchKey . "%' OR c.phone LIKE '%" . $searchKey . "%' OR c.`next_followup` LIKE '%" . $searchKey . "%' OR pc.`product_category_name` LIKE '%" . $searchKey . "%'";
			$joins = "LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id";
			$condition = "c.lead_status='open' and c.last_updated_by = '" . $userId . "'";
		}
		$sql = "SELECT
                    $colums
                 FROM customer as c
				 $joins
				 WHERE $condition";
		if ($searchKey) {
			$sql .= " AND ($search_vale)";
		}
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		//print_r($query->fetchAll ());exit;
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ();
	}
	public function getParentCategories() {
		$sql = "SELECT
                    product_category_id,
                    product_category_name
                 FROM product_category WHERE parent_id ='0' AND active_status='1'";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getSubCategoriesById($subid) {
		$sql = "SELECT
                    product_category_id,
                    product_category_name
                 FROM product_category WHERE parent_id ='" . $subid . "' AND active_status='1'";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getCategoryProductsById($catid) {
		$sql = "SELECT
                    product_id,
                    product_name
                 FROM product WHERE product_category_id ='" . $catid . "' AND active_status='1'";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	/**
	 * Add a product to database
	 * TODO put this explanation into readme and remove it from here
	 * Please note that it's not necessary to "clean" our input in any way.
	 * With PDO all input is escaped properly
	 * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
	 * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
	 * in the views (see the views for more info).
	 *
	 * @param string $artist
	 *        	Artist
	 * @param string $track
	 *        	Track
	 * @param string $link
	 *        	Link
	 */
	public function save($customer_array) {
		$sql = "INSERT INTO `customer`
                    (firstname,
					 lastname,
					 email,
					 phone,
					 comments,
					 lead_type,
					 product_category_id,
					 product_subcategory_id,
					 product_id,
					 store_id,
					 active_status,
					 lead_status,
                     last_updated_date,
                     last_updated_by)
                VALUES
                    (:frm_firstname,
					:frm_lastname,
					:frm_email,
					:frm_phone,
					:frm_comments,
					:frm_lead_type,
					:frm_product_category_id,
					:frm_product_subcategory_id,
					:frm_product_id,
					:ses_store_id,
					1,
					'open',
                    NOW(),
                    :ses_userid)";
		
		$query = $this->db->prepare ( $sql );
		
		$parameters = array (
				':frm_firstname' => $customer_array ['firstname'],
				':frm_lastname' => $customer_array ['lastname'],
				':frm_email' => $customer_array ['email'],
				':frm_phone' => $customer_array ['phone'],
				':frm_comments' => $customer_array ['comments'],
				':frm_lead_type' => $customer_array ['lead_type'],
				':frm_product_category_id' => $customer_array ['product_category_id'],
				':frm_product_subcategory_id' => $customer_array ['product_subcategory_id'],
				':frm_product_id' => $customer_array ['product_id'],
				':ses_store_id' => $_SESSION ['store'],
				':ses_userid' => $_SESSION ['sess_user_id'] 
		);
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		// echo $sql;exit;
		if ($query->execute ( $parameters )) {
			return $this->db->lastInsertId ();
		}
	}
	
	/**
	 * Get a catalog from database
	 */
	public function geCustomerById($catalog_id) {
		$sql = "SELECT * FROM customer WHERE customer_id = :id LIMIT 1";
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':id' => $catalog_id 
		);
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		$query->execute ( $parameters );
		
		// fetch() is the PDO method that get exactly one result
		return $query->fetch ();
	}
	public function isExistOpenCustomer($phone, $productid) {
		$sql = "SELECT COUNT(customer_id) AS customerid FROM customer WHERE phone='" . $phone . "' AND product_id='" . $productid . "' AND lead_status='open'";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		
		// fetch() is the PDO method that get exactly one result
		return $query->fetch ()->customerid;
	}
	public function getCustomersById($customersId) {
		$sql = "SELECT c.*, p.product_name, pc.product_category_name, spc.product_category_name as subcategoryname FROM customer as c 
				LEFT JOIN product_category as pc on c.product_category_id=pc.product_category_id
				LEFT JOIN product_category as spc on c.product_subcategory_id=spc.product_category_id
				LEFT JOIN product as p on c.product_id=p.product_id						
				where customer_id = '" . $customersId . "'";
		
		$query = $this->db->prepare ( $sql );
		
		$query->execute ();
		return $query->fetch ();
	}
	public function updateCustomerAdditional($cust_demo, $cust_source, $lead_type, $customersId, $userId) {
		$sql = "UPDATE `customer` 
    				SET `cust_demo` ='" . $cust_demo . "',
    					`cust_source` = '" . $cust_source . "',
    					`lead_type` = '" . $lead_type . "'						
    			WHERE `customer_id` ='" . $customersId . "' and last_updated_by = '" . $userId . "'";
		$query = $this->db->prepare ( $sql );
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		return $query->execute ();
	}
	public function updateCustomerDetailsByAdmin($customer_array,$customersId){
		$sql = "UPDATE  `customer` SET
                    `firstname`='" . $customer_array ['firstname'] . "',
					 `lastname`='" . $customer_array ['lastname'] . "',
					 email='" . $customer_array ['email'] . "',
					 phone='" . $customer_array ['phone'] . "',
					 comments='" . $customer_array ['comments'] . "',
					 lead_type='" . $customer_array ['lead_type'] . "',
					 product_category_id='" . $customer_array ['product_category_id'] . "',
					 product_subcategory_id='" . $customer_array ['product_subcategory_id'] . "'
					 where customer_id='".$customersId."'";
		
		$query = $this->db->prepare ( $sql );
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		// echo $sql;exit;
			return $query->execute ();
		
	}
}
