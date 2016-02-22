<?php

class CategoriesModel
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
     * Get all songs from database
     */
    public function getAllCategories($start,$limit, $searchKey, $orderStr)
    {
        //$sql = "SELECT * FROM product";
        $sql = "SELECT 
                    product_category_id,
                    product_category_name,
                    active_status,
                    last_updated_date, 
  				CASE
  					when active_status = 0 then 'Inactive' 
        			when active_status = 1 then 'Active'
        		END AS active_status_str
                 FROM product_category" ;
            
            if($searchKey){
                $sql .= " WHERE 
                product_category_name LIKE '%".$searchKey."%'";
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
    public function getAllCategoriesCount()
    {
        $sql = "SELECT count(product_category_id) as total FROM product_category";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetch();
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
    public function add($product_category_name, $active_status,$main_category)
    {
           $sql = "INSERT INTO `product_category`
                    (product_category_name,
					 active_status,
                     last_updated_date,
                     last_updated_by,
           			 parent_id)
                VALUES           
                    (:name,
					:status,
                    NOW(),
                    :userid,
           		    :main_category)";
           
        
        $query = $this->db->prepare($sql);
       
        $parameters = array(':name'=>$product_category_name,                        
                        ':status'=>$active_status,
                        ':userid'=>$_SESSION['sess_user_id'],
        				':main_category' =>$main_category
        );
                        
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
    public function getCategoryById($catalog_id)
    {
        $sql = "SELECT * FROM product_category WHERE product_category_id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $catalog_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

    /**
     * Update a song in database
     * // TODO put this explaination into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     * @param int $song_id Id
     */
    public function update($name, $status, $refKey,$main_category)
    {
        $sql = "UPDATE product_category
                    SET                    
                    product_category_name = :name,
                    active_status = :status,
        			parent_id=:main_category
                    WHERE product_category_id = :id";
        $query = $this->db->prepare($sql);
        
        
         $parameters = array(':name'=>$name,
                        ':status'=>$status,
                        ':id'=>$refKey,
         				':main_category' =>$main_category
                        );

        // useful for debugging: you can see the SQL behind above construction by using:
         //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        return $query->execute($parameters);
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
}
