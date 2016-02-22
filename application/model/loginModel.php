<?php
class LoginModel {
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
	 * Get a song from database
	 */
	public function getLogin($userName) {
		$sql = "SELECT id,login, password, salt FROM login where login = :username and status = '1' LIMIT 1";
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':username' => $userName 
		);
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		$query->execute ( $parameters );
		
		// fetch() is the PDO method that get exactly one result
		return $query->fetch ();
	}
	
	/**
	 *
	 * @param unknown $userId        	
	 */
	public function getUserDetails($userId) {
		$sql = "SELECT id,login, email, phone_number FROM login where id = :userid and status = '1' LIMIT 1";
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
	
	/**
	 *
	 * @param unknown $username        	
	 * @param unknown $password        	
	 */
	public function changePassword($username, $password) {
		$sql = "UPDATE `login`
					SET
					`password` = :password,
					`last_updated_date` = :datefield
					WHERE `name` = :name";
		// echo $sql;
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':name' => $username,
				':password' => $password,
				':datefield' => date ( 'Y-m-d H:i:s' ) 
		);
		// var_dump($parameters);exit();
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		return $query->execute ( $parameters );
		
		// fetch() is the PDO method that get exactly one result
		// return $query->fetch();
	}
	/**
	 * Get all Products from database
	 */
	public function getAllProductsCount($ref_id) {
		$sql = "SELECT count(customer_id) as total FROM customer Where lead_status='" . $ref_id . "'";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetch ();
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
	public function user_permissions($permission, $action, $userid) {
		$sql = "SELECT COUNT(*) AS count FROM user_permissions WHERE controller_name=:permission AND page_name=:action AND user_id=:userid";
		
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':userid' => $userid,
				':permission' => $permission,
				':action' => $action 
		);
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		$query->execute ( $parameters );
		
		// fetch() is the PDO method that get exactly one result
		$count = $query->fetch ();
		if (($count->count) > 0) {
			
			$sql1 = "SELECT * FROM user_permissions WHERE controller_name=:permission AND page_name=:action AND user_id=:userid";
			$query1 = $this->db->prepare ( $sql1 );
			// $param = array(':userid' => $userid,':permission' => $permission,':action' => $action);
			
			// useful for debugging: you can see the SQL behind above construction by using:
			// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
			
			$query1->execute ( $parameters );
			// print_r($query1->execute($param));exit;
			// fetch() is the PDO method that get exactly one result
			$count1 = $query1->fetch ();
			if (($count1->permission_type) == 0) {
				return false;
			} else {
				
				return true;
			}
		} else {
			return 0;
		}
	}
	
	/**
	 * create token for app
	 */
	public function createToken($id) {
		$sql = "select * from token where ref_id=$id";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		$count = $query->fetch ();
		$token = md5 ( uniqid ( mt_rand (), true ) );
		if ($count > 0) {
			$updatesql = "UPDATE `token`
					SET
					`token` = :token
					WHERE `ref_id` = :id";
			$updatequery = $this->db->prepare ( $updatesql );
			$updateparameters = array (
					':token' => $token,
					':id' => $id 
			);
			if ($updatequery->execute ( $updateparameters )) {
				return $token;
			}
		} else {
			$insertsql = "insert into token (`token`,`status`,`ref_id`,`ref_type`) values(:token,:status,:ref_id,:ref_type)";
			$insertquery = $this->db->prepare ( $insertsql );
			$insertparameters = array (
					':token' => $token,
					':status' => 1,
					':ref_id' => $id,
					':ref_type' => "user" 
			);
			if ($insertquery->execute ( $insertparameters )) {
				return $token;
			}
		}
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
}
