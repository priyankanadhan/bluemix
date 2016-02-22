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
	public function add($category, $subject, $season_id, $month, $state_id, $region_id, $descrition, $from, $to, $address, $comments) {
		$sql = "INSERT INTO `event`
                    (category,
					 subject,
					 seasons_id,
					 month_id,
					 state_id,region_id
                     description,
                     from_date,to_date,address,comments)
                VALUES           
                    (:category,
					:subject,
					:seasons_id,
					:month_id,
					:state_id,
                    :region_id,
                    :description,:from_date,:to_date,:address,:comments)";
		
		$query = $this->db->prepare ( $sql );
		
		$parameters = array (
				':category' => $product_name,
				':subject' => $product_model,
				':seasons_id' => $product_category_id,
				':month_id' => $product_specification,
				':state_id' => $active_status,
				':region_id' => $active_status,
				':description' => $active_status,
				':from_date' => $active_status,
				':to_date' => $active_status,
				':comments' => $active_status,
				'created_date' => NOW (),
				':created_by' => $_SESSION ['sess_user_id'] 
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
	public function getAllCategories() {
		$sql = "SELECT
                    *
                 FROM category where status='1'";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllSeasons() {
		$sql = "SELECT
                    *
                 FROM seasons where status='1'";
		$query = $this->db->prepare ( $sql );
		// $parameters = array(':start' => $start,':limit'=> $limit);
		$query->execute (); // $parameters);
		                    
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		                    // core/controller.php! If you prefer to get an associative array as the result, then do
		                    // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		                    // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllMonthsBySeasonId($id) {
		$sql = "SELECT
                    *
                 FROM month where seasons_id='" . $id . "' AND status='1'";
		$query = $this->db->prepare ( $sql );
		
		$query->execute ();
		
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllStates() {
		$sql = "SELECT
                    *
                 FROM state where status='1'";
		$query = $this->db->prepare ( $sql );
		
		$query->execute ();
		
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getAllRegionByStateId($id) {
		$sql = "SELECT
                    *
                 FROM region where state_id='" . $id . "' AND status='1'";
		$query = $this->db->prepare ( $sql );
		
		$query->execute ();
		
		// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
		// core/controller.php! If you prefer to get an associative array as the result, then do
		// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
		// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function fileUpload($fileName, $size, $path, $type) {
		$sql = "insert into file_upload (`file_name`,`size`,`path`,`status`)
						values('" . $fileName . "','" . $size . "','" . $path . "','1')";
		$query = $this->db->prepare ( $sql );
		print_r ( $query );
		exit ();
		// useful for debugging: you can see the SQL behind above construction by using:
		// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
		// echo $sql;exit;
		if ($query->execute ()) {
			return $this->db->lastInsertId ();
		}
	}
	public function getAllFiles() {
		$selectSql = "select * from file_upload";
		$query = $this->db->prepare ( $selectSql );
		$query->execute ();
		return $query->fetchAll ( PDO::FETCH_ASSOC );
	}
}
