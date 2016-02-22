<?php

class CustomersModel
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    
    /**
     * Get a song from database
     */
    public function getCustomersHistory($customersId)
    {
        $sql = "SELECT * FROM customer_history where customer_id = '".$customersId."' ORDER BY updated_date DESC";
        $query = $this->db->prepare($sql);
       
        $query->execute();//$parameters);

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }
    
    
    public function validateUserAgainstCustomer($customersId, $userId){
    	
    	$sql = "SELECT * FROM customer where customer_id = '".$customersId."' AND last_updated_by='".$userId."' and lead_status='open'";
    	$query = $this->db->prepare($sql);
    	 
    	$query->execute();

        // fetch() is the PDO method that get exactly one result
    	$res = $query->fetch();
        if(isset($res)){
        	return true;
        }else{
        	return false;
        }
    	
    }
    
    public function addHistory($comments, $lastUpdatedBy = "", $customerId, $followupDate)
    {
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
    	 
    
    	$query = $this->db->prepare($sql);
    	 
    	$parameters = array(':customer_comments'=>$comments,
    			':updated_by'=>$lastUpdatedBy,
    			':updated_date'=> date('Y-m-d H:i:s'),
    			':next_followup_date'=>$followupDate,
    			':customer_id'=>$customerId,
    			
    	);
    	// useful for debugging: you can see the SQL behind above construction by using:
    	 //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
    	//echo $sql;exit;
    	return $query->execute($parameters);
    }
    
    public function updateLeadStatus($status, $customerId, $userId, $nextFollowupDate){
    	
    	$sql = "UPDATE `customer` 
    				SET `lead_status` ='".$status."',
    					`next_followup` = '".$nextFollowupDate."' 
    			WHERE `customer_id` ='".$customerId."' and last_updated_by = '".$userId."'";
    	
    	$query = $this->db->prepare($sql);
    	 
    	// useful for debugging: you can see the SQL behind above construction by using:
    	//echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
    	
    	return $query->execute();
    	
    }
    
    
    /**
     * Get all songs from database
     */
    public function getOpenCustomers($start,$limit, $searchKey, $orderStr, $userId)
    {
    	$sql = "SELECT
                    customer_id,
                    firstname,
                    email,
                    phone,
					product_id,
					DATE_FORMAT(last_updated_date,'%d-%M-%Y %H:%i:%s') as last_updated_date,
    				DATE_FORMAT(next_followup,'%d-%M-%Y') as next_followup
                 FROM customer WHERE lead_status='open' and last_updated_by = '".$userId."' ";
    
    	if($searchKey){
    		$sql .= " AND (firstname LIKE '%".$searchKey."%' OR email LIKE '%".$searchKey."%' OR phone LIKE '%".$searchKey."%' OR `next_followup` LIKE '%".$searchKey."%')";
    	}
    	if($orderStr!=""){
    		$sql .=$orderStr;
    	}
    	 
    	if($start>=0 && $limit>0){
    		 
    		$sql .= " LIMIT $start , $limit";
    	}
    	 
    	 
    	//echo $sql;
    	 
    	 
    	$query = $this->db->prepare($sql);
    	//$parameters = array(':start' => $start,':limit'=> $limit);
    	$query->execute();//$parameters);
    
    	// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
    	// core/controller.php! If you prefer to get an associative array as the result, then do
    	// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
    	// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
    	return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get all Products from database
     */
    public function getCustomersCount($searchKey='', $userId)
    {
    	$sql = "SELECT count(customer_id) as total FROM customer WHERE lead_status='open' and last_updated_by = '".$userId."'";
    	if($searchKey){
    		$sql .= " AND (firstname LIKE '%".$searchKey."%' OR email LIKE '%".$searchKey."%' OR phone LIKE '%".$searchKey."%')";
    	}
    	$query = $this->db->prepare($sql);
    	$query->execute();
    
    	// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
    	// core/controller.php! If you prefer to get an associative array as the result, then do
    	// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
    	// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
    	return $query->fetch();
    }
    
    public function getParentCategories()
    {
    	$sql = "SELECT
                    product_category_id,
                    product_category_name
                 FROM product_category WHERE parent_id ='0' AND active_status='1'" ;
    	$query = $this->db->prepare($sql);
    	//$parameters = array(':start' => $start,':limit'=> $limit);
    	$query->execute();//$parameters);
    
    	// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
    	// core/controller.php! If you prefer to get an associative array as the result, then do
    	// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
    	// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
    	return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSubCategoriesById($subid)
    {
    	$sql = "SELECT
                    product_category_id,
                    product_category_name
                 FROM product_category WHERE parent_id ='".$subid."' AND active_status='1'" ;
    	$query = $this->db->prepare($sql);
    	//$parameters = array(':start' => $start,':limit'=> $limit);
    	$query->execute();//$parameters);
    
    	// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
    	// core/controller.php! If you prefer to get an associative array as the result, then do
    	// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
    	// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
    	return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCategoryProductsById($catid)
    {
    	$sql = "SELECT
                    product_id,
                    product_name
                 FROM product WHERE product_category_id ='".$catid."' AND active_status='1'" ;
    	$query = $this->db->prepare($sql);
    	//$parameters = array(':start' => $start,':limit'=> $limit);
    	$query->execute();//$parameters);
    
    	// fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
    	// core/controller.php! If you prefer to get an associative array as the result, then do
    	// $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
    	// $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
    	return $query->fetchAll(PDO::FETCH_ASSOC);
    }
     
    /**
     * Add a product to database
     * TODO put this explanation into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     */
    public function save($customer_array)
    {
    	$sql = "INSERT INTO `customer`
                    (firstname,
					 lastname,
					 email,
					 phone,
					 comments,
					 lead_type,
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
					:frm_product_subcategory_id,
					:frm_product_id,
					:ses_store_id,
					1,
					'open',
                    NOW(),
                    :ses_userid)";
    	 
    
    	$query = $this->db->prepare($sql);
    	 
    	$parameters = array(':frm_firstname'=>$customer_array['firstname'],
    			':frm_lastname'=>$customer_array['lastname'],
    			':frm_email'=>$customer_array['email'],
    			':frm_phone'=>$customer_array['phone'],
    			':frm_comments'=>$customer_array['comments'],
    			':frm_lead_type'=>$customer_array['lead_type'],
    			':frm_product_subcategory_id'=>$customer_array['product_subcategory_id'],
    			':frm_product_id'=>$customer_array['product_id'],
    			':ses_store_id'=>$_SESSION['store'],
    			':ses_userid'=>$_SESSION['sess_user_id']);
    	 
    	// useful for debugging: you can see the SQL behind above construction by using:
    	// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
    	//echo $sql;exit;
    	if($query->execute($parameters)){
    		return $this->db->lastInsertId();
    	}
    }
     
    
    /**
     * Get a catalog from database
     */
    public function geCustomerById($catalog_id)
    {
    	$sql = "SELECT * FROM customer WHERE customer_id = :id LIMIT 1";
    	$query = $this->db->prepare($sql);
    	$parameters = array(':id' => $catalog_id);
    
    	// useful for debugging: you can see the SQL behind above construction by using:
    	// echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
    
    	$query->execute($parameters);
    
    	// fetch() is the PDO method that get exactly one result
    	return $query->fetch();
    }
    
    public function isExistOpenCustomer($phone, $productid)
    {
    	$sql = "SELECT COUNT(customer_id) AS customerid FROM customer WHERE phone='".$phone."' AND product_id='".$productid."' AND lead_status='open'";
    	$query = $this->db->prepare($sql);
    	$query->execute();
    
    	// fetch() is the PDO method that get exactly one result
    	return $query->fetch()->customerid;
    }
   
    
    
    
}
