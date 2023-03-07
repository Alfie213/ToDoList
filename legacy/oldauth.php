<?php
    if (isset($_REQUEST['sub']))
    {
        require('data.php')
        $con = mysqli_connect($host, $user, $pas) or die("no connection");
        mysqli_set_charset($con, "utfa");
        mysqli_select_db($con, $db) or die("no db");
        $login = $_REQUEST['login'];
        $pas = $_REQUEST['password'];

        $s = "select * from users where login='".$login."' ans password='".$pas."'"
    }
    else {
?>
<div id="auth">
    <form action="auth.php" method="get">
        <div class="auth_form">
            <label>Email</label>
            <input type="email" name="email" class="email">
            <label>Password</lavel>
            <input type="password" name="password" class="password">
        </div>

        <input type="submit" name="sub" value="sign in" class="sub" disabled>
    </form>
    <script src="auth.js"></script>
</div>
<?php
    }
?>