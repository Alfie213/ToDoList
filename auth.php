<?php
session_start();

if($_SESSION != null)
{
    header("Location: index.php");
}
?>

<?php
    // if(isset($_REQUEST['check']))
    // {
        // echo "<script>alert('Это сработал alert в php')</script>";
        // echo "<script>alert('$request')</script>";
    // }
    if(isset($_REQUEST['sub']))
    {
        require('data.php');
        $con = mysqli_connect ($host, $user, $pas) or die('error_con');
        mysqli_select_db($con, $db) or die('error_db');
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $request = "SELECT * FROM `users` WHERE email='".$email."' AND password='".$password."'";
        $res = mysqli_query($con, $request);


        // foreach($res as $result)
        // {
        //     echo $result["name"];
        // }


        // print('$request');

        //print(mysqli_num_rows($res));

        if(mysqli_num_rows($res)==1){
            // Начало сессии.
            //session_start();
            foreach($res as $result)
            {
                // Записываем мейл авторизованного пользователя
                $_SESSION["email"] = $result["email"];
                $_SESSION["idUser"] = $result["id_user"];
                $_SESSION["isStarted"] = true;
            }

           // print( $_SESSION["idUser"]);
            // А можно по-другому написать
            // $_SESSION["email"] = $login;



            header('Location: index.php');
        }
        else{
            header('Location:registration.php');
        }
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
        <form name="form1" class="form1" method="get" onsubmit="return FormData();">
            <div class="auth_form">
                <label for="">Email</label>
                <input type="email" name="email" class="email">
                <label for="">password</label>
                <input type="password" name="password" class="password">
            </div>
        <!-- <button type="submit" name="check" value="submit">Alert в php</button> -->
        <input type="submit" value="sign in" name="sub" class="sub">
        </form>
    </div>
</body>
</html>