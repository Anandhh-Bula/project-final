<?php
    require_once("connection.inc.php");
    if(isset($_POST['submit'])){
        $email=$_POST['email'];
        $password=$_POST['password'];
        if(empty($email)&&empty($password)){
            $_SESSION['message']="Fill out the fields";
        }
        else{
            $userQuery = 'SELECT * FROM users where email="'.$email.'"';
            $result = $con->query($userQuery);
            $check_user=mysqli_num_rows($result);
            if($check_user>0){
            	$row=mysqli_fetch_assoc($result);
            	$_SESSION['USER_LOGIN']='yes';
            	$_SESSION['USER_ID']=$row['id'];
            	$_SESSION['USER_NAME']=$row['name'];
            
            	if(isset($_SESSION['WISHLIST_ID']) && $_SESSION['WISHLIST_ID']!=''){
            		wishlist_add($con,$_SESSION['USER_ID'],$_SESSION['WISHLIST_ID']);
            		unset($_SESSION['WISHLIST_ID']);
            	}
            
            	echo "valid";
                header('Location: index.php');
            }else{
            	echo "wrong";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register-Ekart</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400;600;700&display=swap');
        *{
            font-family: 'Montserrat',sans-serif;
        }
        a{
            text-decoration: none;
            color: black;
            text-align: center;
        }
        .login-form{
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 400px;
            margin: auto;
        }
        .login-head{
            margin-right: 220px;
        }
        form{
            width: 360px;
        }
        .form-element{
            display: flex;
            flex-direction: column;
            margin-bottom: 8px;
        }
        .form-element > *{
            margin: 2px 2px;
        }
        input[type=text],[type=email],[type=password]{
            padding: 8px;
            font-size: 16px;
        }
        .login-btn{
            padding: 8px;
            border: none;
            font-size: 16px;
            font-weight: 600;
            margin: 16px 0px;
        }
        .error{
            text-align: center;
            padding: 8px 100px;
            font-weight: 600;
            color:white;
            background-color: #D82148;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <a href="index.php"><h1>Ekart</h1></a>
    <div class="login-form">
    <?php if(isset($_SESSION['message'])){echo "<span class='error'>".$_SESSION['message']."</span>"; unset($_SESSION['message']);}?>
        <div class="login-head"><h1>Login</h1></div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-element">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-element">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-element">
                <button type="submit" name="submit" value="submit" class="login-btn">Sign In</button>
            </div>
        </form>
        <p>OR</p>
        <a href="register.php">Create an account</a>
    </div>
</body>
</html>