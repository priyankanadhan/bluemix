<?php
class EmpdashboardModel {
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
	 * Get all songs from database
	 */
	public function getAllProducts($start, $limit, $searchKey, $orderStr) {
		// $sql = "SELECT * FROM product";
		$sql = "SELECT 
                    product_id,
                    product_name,
					product_model,
					product_category_id,
                    active_status,
                    last_updated_date, 
  				CASE
  					when active_status = 0 then 'Inactive' 
        			when active_status = 1 then 'Active'
        		END AS active_status_str
                 FROM product";
		
		if ($searchKey) {
			$sql .= " WHERE 
                product_category_name LIKE '%" . $searchKey . "%'";
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
	public function getAllCategoriesFromProducts($start, $limit, $searchKey, $orderStr) {
		$sql = "SELECT 
                    product_category_id,
                    product_category_name
                 FROM product_category";
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
	 * Get all Products from database
	 */
	public function getAllProductsCount($ref_id) {
		// echo $_SESSION['store_region'];
		$sql = "SELECT SUM(c.product_category_id=1) as ipad,
				SUM(c.product_category_id=2) as iphone,SUM(c.product_category_id=3) as ipod,
				SUM(c.product_category_id=4) as mac,
				count(c.customer_id) as total FROM customer as c 
				left join store as s on c.store_id=s.store_id
				left join store_region as sr on s.store_region_id=sr.store_region_id
				Where c.lead_status='" . $ref_id . "' AND s.store_region_id='" . $_SESSION ['store_region'] . "' AND c.product_subcategory_id !='0'";
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
		$sql = "SELECT t4.mac_product_id,t1.store_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as store_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='4' AND s.store_region_id='" . $_SESSION ['store_region'] . "' AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as mac_product_id
	 			FROM
	 			customer as t4
	 	       	LEFT JOIN store as s on t4.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t4.product_category_id='4' AND t4.lead_status='" . $ref_id . "' AND s.store_region_id='" . $_SESSION ['store_region'] . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		return $query->fetch ();
	}
	public function specificIpadProductCount($ref_id) {
		$sql = "SELECT t4.ipad_product_id,t1.store_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as store_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='1' AND s.store_region_id='" . $_SESSION ['store_region'] . "' AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as ipad_product_id
	 			FROM
	 			customer as t4
	 	        LEFT JOIN store as s on t4.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t4.product_category_id='1' AND t4.lead_status='" . $ref_id . "' AND s.store_region_id='" . $_SESSION ['store_region'] . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIphoneProductCount($ref_id) {
		$sql = "SELECT t4.iphone_product_id,t1.store_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as store_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='2' AND s.store_region_id='" . $_SESSION ['store_region'] . "' AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as iphone_product_id
	 			FROM
	 	        		customer as t4
	 			LEFT JOIN store as s on t4.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t4.product_category_id='2' AND t4.lead_status='" . $ref_id . "' AND s.store_region_id='" . $_SESSION ['store_region'] . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIpodProductCount($ref_id) {
		$sql = "SELECT t4.ipod_product_id,t1.store_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as store_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='3' AND s.store_region_id='" . $_SESSION ['store_region'] . "' AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as ipod_product_id
	 			FROM
	 	        		customer as t4
	 			LEFT JOIN store as s on t4.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t4.product_category_id='3' AND t4.lead_status='" . $ref_id . "' AND s.store_region_id='" . $_SESSION ['store_region'] . "'
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
	public function add($product_name, $product_model, $product_category_id, $product_specification, $active_status) {
		$sql = "INSERT INTO `product`
                    (product_name,
					 product_model,
					 product_category_id,
					 product_specification,
					 active_status,
                     last_updated_date,
                     last_updated_by)
                VALUES           
                    (:name,
					:model,
					:category_id,
					:specification,
					:status,
                    NOW(),
                    :userid)";
		
		$query = $this->db->prepare ( $sql );
		
		$parameters = array (
				':name' => $product_name,
				':model' => $product_model,
				':category_id' => $product_category_id,
				':specification' => $product_specification,
				':status' => $active_status,
				':userid' => $_SESSION ['sess_user_id'] 
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
	public function getProductById($prod_id) {
		$sql = "SELECT * FROM product WHERE product_id = :id LIMIT 1";
		$query = $this->db->prepare ( $sql );
		$parameters = array (
				':id' => $prod_id 
		);
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		$query->execute ( $parameters );
		
		// fetch() is the PDO method that get exactly one result
		return $query->fetch ();
	}
	
	/**
	 * Update a song in database
	 * // TODO put this explaination into readme and remove it from here
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
	 * @param int $song_id
	 *        	Id
	 */
	public function update($product_name, $product_model, $product_category_id, $product_specification, $status, $refKey) {
		$sql = "UPDATE product
                    SET                    
                    product_name = :name,
					product_model = :model,
					product_category_id = :category_id,
					product_specification = :specification,
                    active_status = :status
                    WHERE product_id = :id";
		$query = $this->db->prepare ( $sql );
		
		$parameters = array (
				':name' => $product_name,
				':model' => $product_model,
				':category_id' => $product_category_id,
				':specification' => $product_specification,
				':status' => $status,
				':id' => $refKey 
		);
		
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		
		return $query->execute ( $parameters );
	}
	public function getMacStoreDetails($lead_status) {
		$selectSql = "select s.store_id as store_lead,s.store_id as store_id,s.store_name as store_name from store as s where s.store_region_id='" . $_SESSION ['store_region'] . "'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		$stores = $query->fetchAll (); // print_r($stores);exit;
		foreach ( $stores as $store ) {
			$countSql = "select count(c.customer_id) as store_lead from customer as c
 				left join store as s on s.store_id=c.store_id
 				where s.store_id='" . $store->store_id . "' AND c.product_category_id='4' AND c.lead_status='" . $lead_status . "'";
			$query1 = $this->db->prepare ( $countSql );
			$query1->execute ();
			$count = $query1->fetch ();
			$store->store_lead = $count->store_lead;
		}
		return $stores;
	}
	public function getiPodStoreDetails($lead_status) {
		$selectSql = "select s.store_id as store_lead,s.store_id as store_id,s.store_name as store_name from store as s where s.store_region_id='" . $_SESSION ['store_region'] . "'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		$stores = $query->fetchAll (); // print_r($stores);exit;
		foreach ( $stores as $store ) {
			$countSql = "select count(c.customer_id) as store_lead from customer as c
 				left join store as s on s.store_id=c.store_id
 				where s.store_id='" . $store->store_id . "' AND c.product_category_id='3' AND c.lead_status='" . $lead_status . "'";
			$query1 = $this->db->prepare ( $countSql );
			$query1->execute ();
			$count = $query1->fetch ();
			$store->store_lead = $count->store_lead;
		}
		return $stores;
	}
	public function getiPadStoreDetails($lead_status) {
		$selectSql = "select s.store_id as store_lead,s.store_id as store_id,s.store_name as store_name from store as s where s.store_region_id='" . $_SESSION ['store_region'] . "'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		$stores = $query->fetchAll (); // print_r($stores);exit;
		foreach ( $stores as $store ) {
			$countSql = "select count(c.customer_id) as store_lead from customer as c
 				left join store as s on s.store_id=c.store_id
 				where s.store_id='" . $store->store_id . "' AND c.product_category_id='1' AND c.lead_status='" . $lead_status . "'";
			$query1 = $this->db->prepare ( $countSql );
			$query1->execute ();
			$count = $query1->fetch ();
			$store->store_lead = $count->store_lead;
		}
		return $stores;
	}
	public function getiPhoneStoreDetails($lead_status) {
		$selectSql = "select s.store_id as store_lead,s.store_id as store_id,s.store_name as store_name from store as s where s.store_region_id='" . $_SESSION ['store_region'] . "'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		$stores = $query->fetchAll (); // print_r($stores);exit;
		foreach ( $stores as $store ) {
			$countSql = "select count(c.customer_id) as store_lead from customer as c
 				left join store as s on s.store_id=c.store_id
 				where s.store_id='" . $store->store_id . "' AND c.product_category_id='2' AND c.lead_status='" . $lead_status . "'";
			$query1 = $this->db->prepare ( $countSql );
			$query1->execute ();
			$count = $query1->fetch ();
			$store->store_lead = $count->store_lead;
		}
		return $stores;
	}
	
	/**
	 * Services for mobile app
	 */
	
	/**
	 * Get all Products from database
	 */
	public function getAllProductsCountForApp($ref_id, $store_id) {
		// echo $_SESSION['store_region'];
		$sql = "SELECT SUM(c.product_category_id=1) as ipad,
				SUM(c.product_category_id=2) as iphone,SUM(c.product_category_id=3) as ipod,
				SUM(c.product_category_id=4) as mac,
				count(c.customer_id) as total FROM customer as c
				left join store as s on c.store_id=s.store_id
				left join store_region as sr on s.store_region_id=sr.store_region_id
				Where c.lead_status='" . $ref_id . "' AND s.store_region_id='" . $store_id . "' AND c.product_subcategory_id !='0'";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetch ();
	}
	public function specificMacProductCountForApp($ref_id, $store_id) {
		/*
		 * $sql = "SELECT count(m.product_id) as mac_product_id,count(n.product_id) as ipad_product_id,count(o.product_id) as iphone_product_id FROM
		 * product as
		 * LEFT JOIN product_category as m on product_category.product_category_id=m.product_category_id
		 * LEFT JOIN product_category as n on product_category.product_category_id=n.product_category_id
		 * LEFT JOIN product_category as o on product_category.product_category_id=o.product_category_id
		 * where m.product_category_id='4' AND n.product_category_id='1' AND o.product_category_id='5'";
		 */
		$sql = "SELECT t4.mac_product_id,t1.store_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as store_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='4' AND s.store_region_id='" . $store_id . "' AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as mac_product_id
	 			FROM
	 			customer as t4
	 	       	LEFT JOIN store as s on t4.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t4.product_category_id='4' AND t4.lead_status='" . $ref_id . "' AND s.store_region_id='" . $store_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		return $query->fetch ();
	}
	public function specificIpadProductCountForApp($ref_id, $store_id) {
		$sql = "SELECT t4.ipad_product_id,t1.store_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as store_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='1' AND s.store_region_id='" . $store_id . "' AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as ipad_product_id
	 			FROM
	 			customer as t4
	 	        LEFT JOIN store as s on t4.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t4.product_category_id='1' AND t4.lead_status='" . $ref_id . "' AND s.store_region_id='" . $store_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIphoneProductCountForApp($ref_id, $store_id) {
		$sql = "SELECT t4.iphone_product_id,t1.store_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as store_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='2' AND s.store_region_id='" . $store_id . "' AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as iphone_product_id
	 			FROM
	 	        		customer as t4
	 			LEFT JOIN store as s on t4.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t4.product_category_id='2' AND t4.lead_status='" . $ref_id . "' AND s.store_region_id='" . $store_id . "'
	 			)t4
	 			on m.customer_id=m.customer_id
	 	";
		$query = $this->db->prepare ( $sql );
		$query->execute (); // print_r($query->fetch ());exit;
		return $query->fetch ();
	}
	public function specificIpodProductCountForApp($ref_id, $store_id) {
		$sql = "SELECT t4.ipod_product_id,t1.store_region_id
	 			FROM
	 	        customer as m
	 	        INNER JOIN(
	 			select t1.customer_id,count(n.store_region_id) as store_region_id
	 			FROM
	 			customer as t1
				LEFT JOIN store as s on t1.store_id=s.store_id
	 			LEFT JOIN store_region as n on s.store_region_id=n.store_region_id
	 	        where t1.product_category_id='3' AND s.store_region_id='" . $store_id . "' AND t1.lead_status='" . $ref_id . "'
	 			)t1
	 			on m.customer_id=m.customer_id
	 			INNER JOIN(
	 			select count(t4.customer_id) as ipod_product_id
	 			FROM
	 	        		customer as t4
	 			LEFT JOIN store as s on t4.store_id=s.store_id
	 			LEFT JOIN store_region as p on s.store_region_id=p.store_region_id
	 	        where t4.product_category_id='3' AND t4.lead_status='" . $ref_id . "' AND s.store_region_id='" . $store_id . "'
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
	public function getMacStoreDetailsForApp($lead_status, $store_id) {
		$selectSql = "select s.store_id as store_lead,s.store_id as store_id,s.store_name as store_name from store as s where s.store_region_id='" . $store_id . "'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		$stores = $query->fetchAll (); // print_r($stores);exit;
		foreach ( $stores as $store ) {
			$countSql = "select count(c.customer_id) as store_lead from customer as c
 				left join store as s on s.store_id=c.store_id
 				where s.store_id='" . $store->store_id . "' AND c.product_category_id='4' AND c.lead_status='" . $lead_status . "'";
			$query1 = $this->db->prepare ( $countSql );
			$query1->execute ();
			$count = $query1->fetch ();
			$store->store_lead = $count->store_lead;
		}
		return $stores;
	}
	public function getiPodStoreDetailsForApp($lead_status, $store_id) {
		$selectSql = "select s.store_id as store_lead,s.store_id as store_id,s.store_name as store_name from store as s where s.store_region_id='" . $store_id . "'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		$stores = $query->fetchAll (); // print_r($stores);exit;
		foreach ( $stores as $store ) {
			$countSql = "select count(c.customer_id) as store_lead from customer as c
 				left join store as s on s.store_id=c.store_id
 				where s.store_id='" . $store->store_id . "' AND c.product_category_id='3' AND c.lead_status='" . $lead_status . "'";
			$query1 = $this->db->prepare ( $countSql );
			$query1->execute ();
			$count = $query1->fetch ();
			$store->store_lead = $count->store_lead;
		}
		return $stores;
	}
	public function getiPadStoreDetailsForApp($lead_status, $store_id) {
		$selectSql = "select s.store_id as store_lead,s.store_id as store_id,s.store_name as store_name from store as s where s.store_region_id='" . $store_id . "'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		$stores = $query->fetchAll (); // print_r($stores);exit;
		foreach ( $stores as $store ) {
			$countSql = "select count(c.customer_id) as store_lead from customer as c
 				left join store as s on s.store_id=c.store_id
 				where s.store_id='" . $store->store_id . "' AND c.product_category_id='1' AND c.lead_status='" . $lead_status . "'";
			$query1 = $this->db->prepare ( $countSql );
			$query1->execute ();
			$count = $query1->fetch ();
			$store->store_lead = $count->store_lead;
		}
		return $stores;
	}
	public function getiPhoneStoreDetailsForApp($lead_status, $store_id) {
		$selectSql = "select s.store_id as store_lead,s.store_id as store_id,s.store_name as store_name from store as s where s.store_region_id='" . $store_id . "'";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		$stores = $query->fetchAll ();
		foreach ( $stores as $store ) {
			$countSql = "select count(c.customer_id) as store_lead from customer as c
 				left join store as s on s.store_id=c.store_id
 				where s.store_id='" . $store->store_id . "' AND c.product_category_id='2' AND c.lead_status='" . $lead_status . "'";
			$query1 = $this->db->prepare ( $countSql );
			$query1->execute ();
			$count = $query1->fetch ();
			$store->store_lead = $count->store_lead;
		}
		return $stores;
	}
}
