<?php 
require 'dbClass.php';
require 'validatorClass.php';

class crud {
    public $title;
    public $content;
    public $img;

    function __construct($title,$content,$img){
      
       $this->title     = $title;
       $this->content    = $content;
       $this->img = $img; 

    }
    // public function getData($query)
	// {		
	// 	$result = $this->connection->query($query);
		
	// 	if ($result == false) {
	// 		return false;
	// 	} 
		
	// 	$rows = array();
		
	// 	while ($row = $result->fetch_assoc()) {
	// 		$rows[] = $row;
	// 	}
		
	// 	return $rows;
	// }



    public function Iinsert(){
        // logic ..... 

        $Validator = new Validator();
        
        $this->title     = $Validator->Clean($this->title);
        $this->content = $Validator->Clean($this->content);
        $this->img    = $Validator->Clean($this->img);
        
        $errors = [];

        if(!$Validator->validate($this->title,1)){
            $errors['title'] = "Field Required";
        }elseif(!$Validator->validate($this->title,2,7)){
                $errors['title'] = "len";
            }


        if(!$Validator->validate($this->content,1)){
            $errors['content'] = "Field Required";}
         elseif(!$Validator->validate($this->content,2.20)){
             $errors['content'] = "len";
         }


         if (!validate($_FILES['img']['name'], 1)) {
            $errors['Image'] = 'Field Required';
        } else {
            $tmpPath = $_FILES['img']['tmp_name'];
            $imageName = $_FILES['img']['name'];
            $imageSize = $_FILES['img']['size'];
            $imageType = $_FILES['img']['type'];
    
            $exArray = explode('.', $imageName);
            $extension = end($exArray);
    
            $FinalName = rand() . time() . '.' . $extension;
    
            $allowedExtension = ['png', 'jpg'];
    
            if (!validate($extension, 5)) {
                $errors['img'] = 'Error In Extension';
            }
        }


       if(count($errors)>0){
           $_SESSION['Message'] = $errors;
       }else{
        $desPath = './uploads/' . $FinalName;

        if (move_uploaded_file($tmpPath, $desPath)) {
         $dbObj = new database;


         $sql = "insert into forma (title,content,img) values ('$this->title','$this->content','$this->FinalName')";
        
         $result = $dbObj->doQuery($sql);

         if($result){
             $message = "Data Inserted";
         }else{
             $message = "Error Try Again";
         }

           $_SESSION['Message'] = ['message' => $message];
       }
    }


    }



   











    // public function displayData()
    // {
    //     $query = "SELECT * FROM forma";
    //     $result = $this->con->query($query);
    // if ($result->num_rows > 0) {
    //     $data = array();
    //     while ($row = $result->fetch_assoc()) {
    //            $data[] = $row;
    //     }
    //      return $data;
    //     }else{
    //      echo "No found records";
    //     }
    // }

}


?>