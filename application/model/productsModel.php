<?php

class ProductsModel
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
    public function getAllProducts($start,$limit, $searchKey, $orderStr)
    {
        //$sql = "SELECT * FROM product";
        $sql = "SELECT 
                   product.product_id,
                    product.product_name,
					product.product_model,
					product.product_category_id,
                   product.active_status,
                   product.last_updated_date,
                   c.product_category_name,
        		CASE
  					when product.active_status = 0 then 'Inactive' 
        			when product.active_status = 1 then 'Active'
        		END AS active_status_str
                 FROM product
                 left join product_category as c on product.product_category_id=c.product_category_id" ;
            
            if($searchKey){
                $sql .= " WHERE 
                c.product_category_name LIKE '%".$searchKey."%'";
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
    
	
	public function getAllCategoriesFromProducts($start,$limit, $searchKey, $orderStr)
    {
        $sql = "SELECT 
                    product_category_id,
                    product_category_name
                 FROM product_category" ;              
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
    public function getAllProductsCount()
    {
        $sql = "SELECT count(product_id) as total FROM product";
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
    public function add($product_name, $product_model, $product_category_id, $product_specification, $active_status)
    {
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
           
        
        $query = $this->db->prepare($sql);
       
        $parameters = array(':name'=>$product_name,  
						':model'=>$product_model,
						':category_id'=>$product_category_id,  
						':specification'=>$product_specification,                    
                        ':status'=>$active_status,
                        ':userid'=>$_SESSION['sess_user_id']);
                        
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
    public function getProductById($prod_id)
    {
        $sql = "SELECT * FROM product WHERE product_id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $prod_id);

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
    public function update($product_name,$product_model,$product_specification,$product_category_id, $status, $refKey)
    {
    	//echo $product_name;echo "<br>";echo  $product_model;echo "<br>";echo $product_category_id;echo "<br>";echo $product_specification;echo "<br>";echo $status;echo "<br>";echo $refKey;
        $sql = "UPDATE product
                    SET                    
                    product_name = :name,
					product_model = :model,
					product_category_id = :category_id,
					product_specification = :specification,
                    active_status = :status
                    WHERE product_id = :id";
        $query = $this->db->prepare($sql);
        
        
         $parameters = array(':name'=>$product_name,  
						':model'=>$product_model,
						':category_id'=>$product_category_id,  
						':specification'=>$product_specification,
                        ':status'=>$status,
                        ':id'=>$refKey
                        );

        // useful for debugging: you can see the SQL behind above construction by using:
         //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
	//	print_r($query->execute($parameters));exit;
        return $query->execute($parameters);
    }  
 
}
