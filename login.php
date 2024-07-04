<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">    </script>

<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

.input-container {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  width: 100%;
  margin-bottom: 15px;
}

.icon {
  padding: 10px;
  background: dodgerblue;
  color: white;
  min-width: 50px;
  text-align: center;
}

.input-field {
  width: 100%;
  padding: 10px;
  outline: none;
}

.input-field:focus {
  border: 2px solid dodgerblue;
}

/* Set a style for the submit button */
.btn {
  background-color: dodgerblue;
  color: white;
  padding: 15px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.btn:hover {
  opacity: 1;
}

.container{
    padding:20px;
    background-color:lightgrey;
    width:500px;
    margin-top:100px
}
</style>
</head>
<body>

<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='POST' style="max-width:400px;margin:auto">
    <h2>Teacher Login</h2>
    <div class="input-container">
        <i class="fa fa-user icon"></i>
        <input class="input-field" type="text" placeholder="Username" name="userName">
    </div>

    <div class="input-container">
        <i class="fa fa-key icon"></i>
        <input class="input-field" type="password" placeholder="Password" name="password">
    </div>

    <button type="submit" name='submit' class="btn">Login</button>
    </form>
</div>

</body>
</html>


<?php
if(isset($_POST['submit']))
{
    require_once "config.php";

    $userName = trim($_POST['userName']);
    $passw = trim($_POST['password']);
    //password encrypted with md5 hash
    $password = md5($passw);
    $data = array();

        if(isset($userName) && isset($password)){
            
            $query = "select * from users where user_name = '".$userName."' and password = '".$password."'";
            $result = $link -> query($query); 

            if($result -> num_rows > 0)
            {
                session_start();
                $_SESSION['user_name'] = $userName;
                header('Location: '.'home.php');
            } else {
                ?>
                <script>
                    alert("Invalid Credentials ! Please try again.")
                </script>
            <?php
            }          
            $link -> close();

        }
}
    
?>
