<?php
class BuiltinModel {
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
	public function getAllCount() {
		$selectSql = "select * from daily_updates where category='builtin'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllCountForFileUpload() {
		$selectSql = "select * from daily_updates where category='file_upload'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function add($fileName, $size, $path, $type) {
		$selectSql = "select count(id) as count from daily_updates where category='builtin'";
		$query1 = $this->db->prepare ( $selectSql );
		$query1->execute ();
		$count = $query1->fetch ();
		if (($count->count) < 3) {
			$sql = "insert into daily_updates (`name`,`size`,`path`,`mime`)
						values('" . $fileName . "','" . $size . "','" . $path . "','" . $type . "')";
			$query = $this->db->prepare ( $sql );
			
			// useful for debugging: you can see the SQL behind above construction by using:
			// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
			// echo $sql;exit;
			if ($query->execute ()) {
				return $this->db->lastInsertId ();
			}
		} else {
			return true;
		}
	}
	public function fileUploadForIncentive($fileName, $size, $path, $type) {
		$sql = "insert into daily_updates (`name`,`size`,`path`,`mime`,`category`)
						values('" . $fileName . "','" . $size . "','" . $path . "','" . $type . "','file_upload')";
		$query = $this->db->prepare ( $sql );
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		// echo $sql;exit;
		if ($query->execute ()) {
			return $this->db->lastInsertId ();
		}
	}
	public function delete($id) {
		$selectSql = "select name,path from daily_updates where id='" . $id . "'";
		$query1 = $this->db->prepare ( $selectSql );
		$query1->execute ();
		$count = $query1->fetch ();
		$sql = "delete from daily_updates where id='" . $id . "'";
		$query = $this->db->prepare ( $sql );
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		// echo $sql;exit;
		if ($query->execute ()) {
			return $count;
		}
	}
	public function getAllCountApp() {
		$dir = "http://" . $_SERVER ['HTTP_HOST'] . "/uploads/";
		$selectSql = "select id,path,size,concat('$dir',name) as file_path,category from daily_updates where category='builtin'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllCountForFileUploadApp() {
		$dir = "http://" . $_SERVER ['HTTP_HOST'] . "/uploads/";
		$selectSql = "select id,path,size,concat('$dir',name) as file_path,category from daily_updates where category='file_upload'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
}
