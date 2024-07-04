<?php
require_once "config.php";

$id = intval(trim($_POST['id']));
$name = trim($_POST['name']);
$subject = trim($_POST['subject']);
$marks = $_POST['marks'];
//  echo $id.' '.$name.' '.$subject.' '.$marks;
$data = array();

    if(isset($id) && isset($name) && isset($subject) && isset($marks)){
        // Prepare an insert statement

        $query = "update students set name = '".$name."',subject = '".$subject."', marks = '".$marks."' where id = $id";

        $result = $link -> query($query); 
        if($result)
        {
            $data['status'] =  0;
            $data['result'] =  "Record updated Successfully";
        } else {
            $data['status'] =  1;
            $data['result'] =  "Error updating Record";            
        }          
        $link -> close();

        $data = json_encode($data);
        print_r($data);
    }
    
?>

