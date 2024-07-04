<?php
require_once "config.php";

$id = trim($_POST['id']);
//echo $id;
$data = array();

    // Check input errors before inserting in database
    if(isset($id)){
        // Prepare an insert statement

        $query = "delete from students where id = $id";
        $result = $link -> query($query); 
        if($result)
        {
            $data['status'] =  0;
            $data['result'] =  "Successfully deleted";
        } else {            
            $data['status'] =  1;
            $data['result'] =  "Error delete";
        }          
        $link -> close();

        $result = json_encode($data);
        echo $result;
    }
    
?>

