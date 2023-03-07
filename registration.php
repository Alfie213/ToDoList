<?php
    if(isset($_REQUEST['reg']))
    {
        require('data.php');
        $con = mysqli_connect ($host, $user, $pas) or die('error_con');
        mysqli_select_db($con, $db) or die('error_db');

        $username = $_REQUEST['username'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        
        $checkRequest = "SELECT email FROM `users` WHERE email='".$email."'";
        $checkRes = mysqli_query($con, $checkRequest);
        if(mysqli_num_rows($checkRes)==1)
        {
            echo
            "<script>alert('Email $email уже используется!');
            location.href='http://localhost/test/registration.php';</script>";
            return;
        }

        $request = "insert into `users` (`id_user`, `name`, `email`, `password`) values (null, '".$username."', '".$email."', '".$password."')";
        $res = mysqli_query($con, $request);

        header('Location: auth.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="auth">
        <form action="registration.php" name="form2" class="form1" method="get" onsubmit="return FormData();">
            <div class="register_form">

                <label for="">Name</label>
                <input type="username" name="username" class="username">

                <label for="">Email</label>
                <input type="email" name="email" class="email">

                <label for="">Password</label>
                <input type="password" name="password" class="password">

            </div>
        <input type="submit" value="register" name="reg" class="reg">
        </form>
    </div>
</body>
</html>