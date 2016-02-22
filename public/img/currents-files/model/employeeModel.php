<?php
class EmployeeModel {
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
	public function getEmployee($empId) {
		// echo $empId;// exit;
		$sql = "SELECT employees_id as employee_id,name as employee_name
	   			 from employee where id='" . $empId . "'";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    // print_r($query->execute ());exit;
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetch ();
	}
	public function getEmployeeDetailsById($empId) {
		$sql = "SELECT e.id as employee_id,e.name as employee_name,
				e.employees_id as employees_id,e.active_status as status,e.dob,e.doj,
				d.designation_id,d.designation_name as designation_name,r.role_id,r.role_name as role_name,
				s.store_id,s.store_name,sr.store_region_id,sr.store_region_name as region_name
				from employee as e
		        left join employee_role_store_designation as er on e.id=er.employee_id
				left join designation as d on d.designation_id=er.designation_id
				left join role as r on r.role_id=er.role_id
				left join store as s on s.store_id=er.store_id
				left join store_region as sr on sr.store_region_id=s.store_region_id where e.id='" . $empId . "'";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // $parameters);
		return $query->fetch ();
	}
	public function getStoresByEmployeeId($empId){
		$sql = "SELECT e.id as employee_id,e.name as employee_name,
				s.store_id,s.store_name
				from employee as e
		        left join employee_role_store_designation as er on e.id=er.employee_id
				left join store as s on s.store_id=er.store_id
			    where er.employee_id='" . $empId . "'";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // $parameters);
		return $query->fetchAll ();
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
	public function getEmployeeDetails() {
		$sql = "SELECT e.id as employee_id,e.name as employee_name,e.employees_id as employees_id,e.active_status as status,e.doj
				d.designation_name as designation_name,r.role_name as role_name,
				s.store_name,sr.store_region_name
				from employee as e
				left join employee_role_store_designation as er
				left join designation as d on d.id=er.dsignation_id
				left join role as r on er.id=r.id
				left join store as s er.store_id=s.store_id
				left join store_region as sr sr.store_region_id=s.store_region_id";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // $parameters);
		                    // print_r($query->fetchAll);exit;
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllEmployeesCount() {
		$sql = "SELECT count(employee.id) as total
				from employee";
		$query = $this->db->prepare ( $sql );
		// print_r($query->execute ());exit;
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetch ();
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
	public function getAllDesignations() {
		$sql = "SELECT designation_name as designation_name,designation_id as designation_id
	   			 from designation";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllRoles() {
		$sql = "SELECT role_name as role_name,role_id as role_id
	   			 from role";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllEmployees($regionId, $storeId, $employee, $start, $limit, $searchKey, $orderStr, $userId) {
		// echo "$storeId";//exit;
		$colums = '';
		$joins = '';
		$search_vale = '';
		$condition = '';
		$colums = "SELECT  
				DISTINCT(e.employees_id) as employees_id,e.id as employee_id,
				e.name as employee_name,
				e.active_status as status,e.doj,
				d.designation_name as designation_name,
				r.role_id as role_id,
				r.role_name as role_name,
				s.store_name,
				sr.store_region_name as region_name";
		$joins = "left join employee_role_store_designation as er on e.id=er.employee_id
				left join designation as d on d.designation_id=er.designation_id
				left join role as r on r.role_id=er.role_id
				left join store as s on s.store_id=er.store_id
				left join store_region as sr on sr.store_region_id=s.store_region_id";
		if ($storeId != "" && $regionId != "") {
			$condition = "sr.store_region_id='" . $regionId . "' AND s.store_id='" . $storeId . "'";
		} elseif ($regionId != "" && $storeId == "") {
			$condition = "sr.store_region_id='" . $regionId . "'";
		} else {
			$condition = "1 ";
		}
		$search_vale .= "e.employees_id LIKE '%" . $searchKey . "%' 
						OR e.name LIKE '%" . $searchKey . "%' 
						OR d.designation_name LIKE '%" . $searchKey . "%' 
						OR r.role_name LIKE '%" . $searchKey . "%' 
						OR s.store_name LIKE '%" . $searchKey . "%'
						OR sr.store_region_name LIKE '%" . $searchKey . "%'";
		$sql = "$colums
		  from employee as e 
		  $joins 
		  Where $condition";
		if ($searchKey) {
			$sql .= " AND ($search_vale) group by e.employees_id";
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
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getEmployeesCount($regionId, $storeId, $searchKey, $userId) {
		$colums = '';
		$joins = '';
		$search_vale = '';
		$condition = '';
		$colums = "SELECT e.id as employee_id,e.name as employee_name,
				e.employees_id as employees_id,e.active_status as status,e.doj,
				d.designation_name as designation_name,r.role_name as role_name,
				s.store_name,sr.store_region_name as region_name";
		$joins = "left join employee_role_store_designation as er on e.id=er.employee_id
				left join designation as d on d.designation_id=er.designation_id
				left join role as r on r.role_id=er.role_id
				left join store as s on s.store_id=er.store_id
				left join store_region as sr on sr.store_region_id=s.store_region_id";
		if ($storeId != "" && $regionId != "") {
			$condition = "sr.store_region_id='" . $regionId . "' AND s.store_id='" . $storeId . "'";
		} elseif ($regionId != "" && $storeId == "") {
			$condition = "sr.store_region_id='" . $regionId . "'";
		} else {
			$condition = "1";
		}
		$search_vale .= "e.name LIKE '%" . $searchKey . "%' OR d.designation_name LIKE '%" . $searchKey . "%' OR
					r.role_name LIKE '%" . $searchKey . "%' OR s.store_name LIKE '%" . $searchKey . "%'
					OR sr.store_region_name LIKE '%" . $searchKey . "%'";
		$sql = "$colums
		from employee as e
		$joins
		Where $condition";
		if ($searchKey) {
			$sql .= " AND ($search_vale)";
		}
		if ($orderStr != "") {
			$sql .= $orderStr;
		}
		
		if ($start >= 0 && $limit > 0) {
			
			$sql .= " LIMIT $start , $limit";
		}
		$query = $this->db->prepare ( $sql );
		// print_r($query);exit;
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ();
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
	public function save($employeeArray) {
		// print_r($employeeArray);//exit;
		$sql = "INSERT INTO `employee`
                    (employees_id,
					 name,
					 dob,
					 doj,
					 last_updated_by,
					 last_updated_date,
					 active_status)
                VALUES
                    (:employee_id,
					:employee_name,
					:dob,
					:doj,
					:ses_userid,
					Now(),
					1)";
		
		$query = $this->db->prepare ( $sql );
		
		$parameters = array (
				':employee_id' => $employeeArray ['employee_id'],
				':employee_name' => $employeeArray ['employee_name'],
				':dob' => $employeeArray ['dob'],
				':doj' => $employeeArray ['doj'],
				':ses_userid' => $_SESSION ['sess_user_id'] 
		);
		// print_r($query->execute ( $parameters ));exit;
		if ($query->execute ( $parameters )) {
			$employee_id = $this->db->lastInsertId ();
		}
		// $employee_id='112';
		/*
		 * $relation = "INSERT INTO `employee_role_store_designation`
		 * (ref_id,
		 * designation_id,
		 * role_id,
		 * store_id,
		 * last_updated_by,
		 * last_updated_date,
		 * active_status,
		 * employee_id)
		 * VALUES
		 * (:ref_id,
		 * :designation_id,
		 * :role_id,
		 * :store_id,
		 * :ses_userid,
		 * Now(),
		 * 1,
		 * :employee_id)";
		 *
		 * $relationQuery = $this->db->prepare ( $relation );
		 *
		 * $params = array (
		 * ':ref_id' => $employee_id,
		 * ':employee_id' => $employee_id,
		 * ':role_id' => $employeeArray ['role_id'],
		 * ':store_id' => $employeeArray ['store_id'],
		 * ':designation_id' => $employeeArray ['designation_id'],
		 * ':ses_userid' => $_SESSION ['sess_user_id']
		 * );
		 */
		$passwordCreate = "INSERT INTO `login`
                    (name,
					 password,
					 salt,
					 status,
					 last_login,
					 last_updated_by,
					 last_updated_date,
					 active_status,
				     employee_id)
                VALUES
                    (:employee_name,
					 :password,
					  '824',
					  1,
					 Now(),
					:ses_userid,
					Now(),
					    1,
				     :employee_id)";
		
		$passwordCreateQuery = $this->db->prepare ( $passwordCreate );
		$newpassword = hash ( 'sha256', '824' . hash ( 'sha256', $employeeArray ['password'] ) );
		$passwordCreateQueryParams = array (
				':employee_name' => $employeeArray ['employee_id'],
				':password' => $newpassword,
				':employee_id' => $employee_id,
				':ses_userid' => $_SESSION ['sess_user_id'] 
		);
		$passwordCreateQuery->execute ( $passwordCreateQueryParams );
		// print_r($passwordCreateQuery->execute ( $passwordCreateQueryParams ));exit;
		// print_r($relationQuery->execute ( $params ));exit;
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		// echo $sql;exit;
		// if ($passwordCreateQuery->execute ( $passwordCreateQueryParams )) {
		return $employee_id;
		// }
	}
	public function updateRelationEmployee($employeeArray, $employee_id) {
		// print_r($employee_id);
		$relation = "INSERT INTO `employee_role_store_designation`
                    (
					 designation_id,
					 role_id,
					 store_id,
					 last_updated_by,
					 last_updated_date,
					 active_status,
				     employee_id)
                VALUES
                    (
					 :designation_id,
					 :role_id,
					 :store_id,
					:ses_userid,
					Now(),
					1,
				     :employee_id)";
		
		$relationQuery = $this->db->prepare ( $relation );
		$params = array (
				':employee_id' => $employee_id,
				':role_id' => $employeeArray ['role_id'],
				':store_id' => $employeeArray ['store_id'],
				':designation_id' => $employeeArray ['designation_id'],
				':ses_userid' => $_SESSION ['sess_user_id'] 
		);
		return $relationQuery->execute ( $params ); // print_r($relationQuery);
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
	public function isExistEmployee($employeeId) {
		$sql = "SELECT COUNT(id) AS employee_id FROM employee WHERE employees_id='" . $employeeId . "'";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		// fetch() is the PDO method that get exactly one result
		return $query->fetch ()->employee_id;
	}
	public function isExistEmployeeForUpdate($employee_ref_id,$employeeId) {
		$sql = "SELECT COUNT(id) AS employee_id FROM employee WHERE employees_id ='" . $employeeId . "' AND id !='" . $employee_ref_id . "' ";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		// fetch() is the PDO method that get exactly one result
		return $query->fetch ()->employee_id;
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
	public function updateEmployeeDetails($employeeId, $employeeName, $dob, $doj, $designation_id, $role_id, $region_id, $store_id, $userId, $employee_ref_id) {
		$sql = "UPDATE `employee` 
    				SET `employees_id` ='" . $employeeId . "',
    					`name` = '" . $employeeName . "',
    					`dob` ='" . $dob . "',
    					`doj` ='" . $doj . "',
    					`last_updated_by` ='" . $userId . "',					
    					`last_updated_date` = 'Now()'
    			WHERE `id` ='" . $employee_ref_id . "'";
		
		$query = $this->db->prepare ( $sql );
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		if ($query->execute ()) {
			$Updatesql = "UPDATE `employee_role_store_designation`
    				SET `designation_id` = '" . $designation_id . "',
    					`role_id` ='" . $role_id . "',
    					`store_id` ='" . $store_id . "',
    					`last_updated_by` ='" . $userId . "',
    					`last_updated_date` = 'Now()'
    			    WHERE `employee_id` ='" . $employee_ref_id . "'";
			
			$Updatequery = $this->db->prepare ( $Updatesql );
			
			//print_r($Updatequery);
			// print_r($Updatequery->execute ());exit;
			return $Updatequery->execute ();
		}
	}
	public function updateLogin($id,$name){
		$UpdateLogin = "UPDATE `login`
					SET
					`name` = :name,
					`last_updated_date` = :datefield
					WHERE `employee_id` = :id";
		
		$UpdateLoginQuery = $this->db->prepare ( $UpdateLogin );
		$parameters = array (
				':id' => $id,
				':name' => $name,
				':datefield' => date ( 'Y-m-d H:i:s' )
		);
		return $UpdateLoginQuery->execute ($parameters);
	}
	public function getStatusChange($empId) {
		$selectQuery = "Select active_status from employee where id='" . $empId . "'";
		$select = $this->db->prepare ( $selectQuery );
		$select->execute ();
		$present = $select->fetch (); // print_r($present);exit;
		if ($present->active_status == '1') {
			$sql = "UPDATE `employee`
    				SET `active_status` ='0'
    			WHERE `id` ='" . $empId . "'";
		} else {
			$sql = "UPDATE `employee`
    				SET `active_status` ='1'
    			WHERE `id` ='" . $empId . "'";
		}
		$query = $this->db->prepare ( $sql );
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		return $query->execute ();
	}
	public function passwordChange($id, $password) {
		// echo "$id";echo "<br>";echo "$password";exit;
		$sql = "UPDATE `login`
					SET
					`password` = :password,
					`last_updated_date` = :datefield
					WHERE `login_id` = :id";
		// echo $sql;
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':id' => $id,
				':password' => $password,
				':datefield' => date ( 'Y-m-d H:i:s' ) 
		);
		// print_r($query->execute ( $parameters ));exit;
		// var_dump($parameters);exit();
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		return $query->execute ( $parameters );
	}
}
