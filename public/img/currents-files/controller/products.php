<?php
/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Products extends Controller
{
    function __construct(){
        
        parent::__construct();		
		$this->loadingModel = $this->loadModel('productsModel');
    
    }
    
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
       // if($_SESSION['user_type'] != "admin"){ header("Location:/login/index"); exit();}
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/products/index.php';
        require APP . 'view/_templates/footer.php';
    }

    

    /**
     * PAGE: exampleone
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function getAllProducts()
    { 
      //if (isset($_REQUEST["draw"])) { $page  = $_REQUEST["draw"]; } else { $page=1; }; 
       $start	=	isset($_REQUEST['start'])?(trim(@$_REQUEST['start'])):"";  
       $length	=	isset($_REQUEST['length'])?(trim(@$_REQUEST['length'])):""; 
       $draw	=	isset($_REQUEST['draw'])?(trim(@$_REQUEST['draw'])):"";
       $searchKey = isset($_REQUEST['search']['value'])?(trim(@$_REQUEST['search']['value'])):"";
       
       $columns = isset($_REQUEST['columns'])?($_REQUEST['columns']):"";
       $orderColumnDetails = isset($_REQUEST['columns'])?($_REQUEST['order']):"";
              
        $orderStr = "";      
       if($columns && $orderColumnDetails){
           $orderColumnName = $columns[$orderColumnDetails[0]['column']]['data'];
           $orderBy = $orderColumnDetails[0]['dir'];
           
           $orderStr = " ORDER BY ".$orderColumnName." ".$orderBy." ";
       }
       
        
      if ( isset($start) && $length != -1 ) {
			$start_from = intval($start);
            $noOfRecordPerPage = intval($length);
		}else{
            $start_from =0;
            $noOfRecordPerPage=0;
        }
        
       
      
     //echo $start_from." -- ".$noOfRecordPerPage;
      $results = array();
      $results['draw'] =$draw ;
      $results['recordsTotal'] = (int) $this->loadingModel->getAllProductsCount()->total;
      $totalRecordsFiltered = $this->loadingModel->getAllProducts($start_from,$noOfRecordPerPage,$searchKey,$orderStr);
      $results['recordsFiltered'] = (int) $this->loadingModel->getAllProductsCount()->total;//count($totalRecordsFiltered);
      $results['data'] = $totalRecordsFiltered;
      //echo "<pre/>";
      //print_r(json_encode($totalRecordsFiltered));
      
      echo json_encode($results);
      exit();
      
      /*   "draw": 1,
          "recordsTotal": 57,
          "recordsFiltered": 57, 
  
       $_REQUEST['draw']
       echo "<pre/>";
       print_r($this->loadingModel->getAllProducts("",""));*/
        
    }

    
    public function add()
    {
    
        $message = '';
               
        $product_name = isset($_REQUEST['product_name'])?(trim(@$_REQUEST['product_name'])):"";
		$product_model = isset($_REQUEST['product_model'])?(trim(@$_REQUEST['product_model'])):"";
		$product_specification = isset($_REQUEST['product_specification'])?(trim(@$_REQUEST['product_specification'])):"";
		$product_category_id = isset($_REQUEST['product_category_id'])?(trim(@$_REQUEST['product_category_id'])):"";
        $active_status = isset($_REQUEST['active_status'])?(trim(@$_REQUEST['active_status'])):"";                
                       
            if(isset($_POST['submit'])){            
                $lastId = $this->loadingModel->add($product_name, $product_model, $product_category_id, $product_specification, $active_status);                
                
                    if($lastId){
                        $message = "Product successfully added!";
                        header('Location:/products/index');exit();
                    }                    
                    else{
                        $message = "Unable to add the Product!";
                    }                
            }     
        
        $categories = $this->loadingModel->getAllCategoriesFromProducts();	
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/products/add.php';
        require APP . 'view/_templates/footer.php';
    }
    
    
    public function edit()
    {
       // if($_SESSION['user_type'] != "admin"){ header("Location:/login/index"); exit();}
        $refKey = isset($_REQUEST['refKey'])?trim($_REQUEST['refKey']):"";
             
        
        if($refKey==""){ //if key is identified then push this into login. It might be a hack
            header('Location:/login/index');
        }
        $message = "";
       // print_r($_POST);exit;
        $product_category_id = isset($_REQUEST['product_category_id'])?(trim(@$_REQUEST['product_category_id'])):"";
        $active_status = isset($_REQUEST['active_status'])?(trim(@$_REQUEST['active_status'])):"";
        $product_name = isset($_REQUEST['product_name'])?(trim(@$_REQUEST['product_name'])):"";
        $product_model = isset($_REQUEST['product_model'])?(trim(@$_REQUEST['product_model'])):"";
        $product_specification = isset($_REQUEST['product_specification'])?(trim(@$_REQUEST['product_specification'])):"";
      //  $product_category_name = isset($_REQUEST['product_category_name'])?(trim(@$_REQUEST['product_category_name'])):"";
                      
            if(isset($_POST['submit'])){               	      
                    if($this->loadingModel->update($product_name,$product_model,$product_specification,$product_category_id, $active_status, $refKey)){
                        $message = "Category successfully updated!";
                        header('Location:/products/index');exit();
                    }                    
                    else{
                        $message = "Unable to add the Data!";
                    }                
            }   
		$categories = $this->loadingModel->getAllCategoriesFromProducts();	     
        $products = $this->loadingModel->getProductById($refKey);       
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/products/edit.php';
        require APP . 'view/_templates/footer.php';
    }  
    
}
