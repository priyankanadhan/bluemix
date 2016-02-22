<?php
class EventsModel {
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
	public function getAllEvents($start, $limit, $searchKey, $orderStr) {
		$sql = "SELECT 
                   event.id,
                    event.category_id,
				    event.subject,
					cat.category,
					event.from_date,
					event.to_date,
                   event.address,
                   event.description,
				   event.month_id,
				   m.month as month,
				   event.seasons_id,
				   s.season_name,
				   event.state_id,
				   st.state_name,
				   event.region_id,
				   r.region_name,
				   event.created_by,
				   login.login,
                   c.comments as others_comments,
        		CASE
  					when product.status = 0 then 'Inactive' 
        			when product.status = 1 then 'Active'
        		END AS active_status_str
                 FROM event
                 left join comments as c on event.id=c.event_id
				 left join category as cat on event.category_id=cat.id
				 left join month as m on event.month_id=m.id
				 left join seasons as s on event.seasons_id=s.id
				 left join state as st on event.state_is=st.id
				 left join region as r on event.region_id=r.id
				left join login on event.created_by=login.id";
		
		if ($searchKey) {
			$sql .= " WHERE 
                cat.category LIKE '%" . $searchKey . "%'";
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
	public function getAllEventsCount() {
		$sql = "SELECT count(id) as total FROM event";
		$query = $this->db->prepare ( $sql );
		$query->execute ();
		
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetch ();
	}
	
	/**
	 * Add Event
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
	 * Update the Events
	 */
	public function update($product_name, $product_model, $product_specification, $product_category_id, $status, $refKey) {
		// echo $product_name;echo "<br>";echo $product_model;echo "<br>";echo $product_category_id;echo "<br>";echo $product_specification;echo "<br>";echo $status;echo "<br>";echo $refKey;
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
		// print_r($query->execute($parameters));exit;
		return $query->execute ( $parameters );
	}
}
