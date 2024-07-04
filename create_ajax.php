<?php
require_once "config.php";

$name = trim($_POST['name']);
$subject = trim($_POST['subject']);
$marks = intval($_POST['marks']);
//echo $name.' '.$subject.' '.$marks;
$data = array();

    // Check input errors before inserting in database
    if(isset($name) && isset($subject) && isset($marks)){
        // Prepare an insert statement

        $query = "select * from students where name = '".$name."' and subject = '".$subject."'";
        $result = $link -> query($query); 
        if($result -> num_rows > 0)
        {
            $query = "update students set marks = '".$marks."' where name = '$name' and subject = '$subject'";
            $result = $link -> query($query);
            $data['status'] =  1;
            $data['result'] =  "Existing record, Updated";
        } else {
            $sql = "INSERT INTO students (`name`, `subject`, `marks`) VALUES ('".$name."', '".$subject."', ".$marks.")";
            
            if ($result = $link -> query($sql)) {
                $data['status'] =  0;
                $data['result'] =  "Inserted record";
            }
        }          
        $link -> close();

        $result = json_encode($data);
        print_r($result);
    }
    
?>

