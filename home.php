<?php
    session_start();    
    if (!isset($_SESSION['user_name'])) 
    {
        header('Location: '.'login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    
    
</head>
<body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <a href="logout.php" class="btn btn-danger" style="float:right">Logout <i class="fa fa-sign-out" style="font-size:25px;color:white"></i></a>
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Student Details</h2>
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-primary pull-right" data-bs-toggle="modal" data-bs-target="#myModal" style = "margin-left:10px">Add New Student</button>
                        
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM students";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Subject</th>";
                                        echo "<th>Marks</th>";
                                        echo "<th style='width:200px;text-align:center'>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td style='contenteditable:false' id=name".$row['id'].">" . $row['name'] . "</td>";
                                        echo "<td style='contenteditable:false' id=subject".$row['id'].">" . $row['subject'] . "</td>";
                                        echo "<td style='contenteditable:false' id=marks".$row['id'].">" . $row['marks'] . "</td>";
                                        

                                        echo "<td style='width:200px;text-align:center'>";
                                        echo '
                                            <button type="button" id=buttongroup'.$row['id'].' class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"></button>
                                            <ul class="dropdown-menu" style="background-color:#cac8db;color:black">
                                                <li><button class="dropdown-item" id=edit'.$row['id'].' onclick=editUser('.$row['id'].') >Edit</button></li>
                                                <li><button class="dropdown-item" id=delete'.$row['id'].' onclick=deleteUser('.$row['id'].') >Delete</button></li>
                                            </ul>
                                            <button type="button" class="btn btn-primary" id=update'.$row['id'].' style="display: none;" onclick=updateUser('.$row['id'].') >Update</button>
                                            <button type="button" class="btn btn-warning" id=cancel'.$row['id'].' style="display: none;" onclick=cancel('.$row['id'].') >Cancel</button>
                                            
                                        ';
                                        echo "</td>";

                                        
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>


    <script>
        $(document).ready(function()
        {
            $("#myForm").submit(function(event){
                event.preventDefault();
                var name = $("input[name='name']",this).val();
                var subject = $("input[name='subject']",this).val();
                var marks = $("input[name='marks']",this).val();
                // var email = $("input[name='email']",this).val();

                $.ajax({
                    type: 'POST',  
                    url: 'create_ajax.php', 
                    data: { name: name, subject:subject, marks:marks },
                    success: function(response) {
                        //content.html(response);
                        console.log(response);
                        //alert(response);

                        var data = JSON.parse(response);
                        console.log(response);
                        if(data.status == 0 ){
                            alert("Record Added Successfully !")
                        } else {
                            alert("Student already exist under the Subject provided. Marks were updated !")
                        }

                        $('#myModal').modal('hide');
                        location.reload();
                    }
                });
            });



        });


        function editUser(userId)
        {

            // alert('update'+userId);
            document.getElementById('buttongroup'+userId).style.display = "none";
            document.getElementById('update'+userId).style.display = "inline";
            document.getElementById('cancel'+userId).style.display = "inline";

            document.getElementById('name'+userId).style.border = "3px solid grey";
            document.getElementById('subject'+userId).style.border = "3px solid grey";
            document.getElementById('marks'+userId).style.border = "3px solid grey";

            document.getElementById('name'+userId).setAttribute('contenteditable', 'true');
            document.getElementById('subject'+userId).setAttribute('contenteditable', 'true');
            document.getElementById('marks'+userId).setAttribute('contenteditable', 'true');
        }


        function updateUser(userId)
        {
            var name = document.getElementById('name'+userId).innerHTML;
            var subject = document.getElementById('subject'+userId).innerHTML;
            var marks = document.getElementById('marks'+userId).innerHTML;

            $.ajax({
                    type: 'POST',  
                    url: 'update_ajax.php', 
                    data: { id: userId, name: name, subject:subject, marks:marks },
                    success: function(response) { 
                        // alert(response);                                               
                        var data = JSON.parse(response);
                        console.log(response);
                        if(data.status == 0 ){
                            alert("Record Updated Successfully !")
                        }
                        location.reload();                      
                    }
                });

        }


        function deleteUser(userId)
        {
            //alert(userId);
            $.ajax({
                    type: 'POST',  
                    url: 'delete_ajax.php', 
                    data: { id: userId },
                    success: function(response) {
                        var data = JSON.parse(response);
                        console.log(response);
                        if(data.status == 0 ){
                            alert("Record deleted Successfully !")
                        }
                        location.reload();                      
                    }
                });
        }


        function cancel(userId)
        {
            document.getElementById('buttongroup'+userId).style.display = "inline";
            document.getElementById('update'+userId).style.display = "none";
            document.getElementById('cancel'+userId).style.display = "none";

            document.getElementById('name'+userId).style.border = "none";
            document.getElementById('subject'+userId).style.border = "none";
            document.getElementById('marks'+userId).style.border = "none";
        }


    </script>

    

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create Student</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="myForm">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required></span>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control" required></span>
                        </div>
                        <div class="form-group">
                            <label>Marks</label>
                            <input type="number" name="marks" class="form-control" min=0 max = 100 required></span>
                        </div>
                        <div class="form-group" style= "text-align:center">
                            <input type="submit" name="submit" class="btn btn-primary" value="ADD">
                            <!-- <a href="index.php" class="btn btn-secondary ml-2">Cancel</a> -->
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    
      </div>

      <!-- Modal footer -->
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div> -->

    </div>
  </div>
</div>
</body>
</html>