<?php
    session_start();
    if($_SESSION == null)
    {
        header("Location: auth.php");
    }
?>

<!-- echo '<script type="text/javascript">',
     'alert("hi"); WRITE CODE HERE',
     '</script>';!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
<?php

print("
<script src='https://www.google.com/jsapi'></script>
<script>
google.load('visualization', '1', {packages:['corechart']});
google.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
    ['Task', 'isDone'],
    ['Done',     ".printDoneNum()."],
    ['Undone', ".printUndoneNum()."],
]);
var options = {
    title: 'Done/Undone',
    is3D: true
};
var chart = new google.visualization.PieChart(document.getElementById('air'));
chart.draw(data, options);
}
</script>
");

function printDoneNum()
{
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $query = "SELECT COUNT(`isDone`) FROM `tasks` WHERE `idUser`='".$_SESSION["idUser"]."' AND `isDone` = 1";
    $res = mysqli_query($con, $query);
    foreach($res as $result)
    {
        return($result['COUNT(`isDone`)']);
    }
}

function printUndoneNum()
{
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $query = "SELECT COUNT(`isDone`) FROM `tasks` WHERE `idUser`='".$_SESSION["idUser"]."' AND `isDone` = 0";
    $res = mysqli_query($con, $query);
    foreach($res as $result)
    {
        return($result['COUNT(`isDone`)']);
    }
}

?>

<?php

require('header.html');

print("<div class='about-border'>");
printID();
printNAME();
printEMAIL();
printNumberOfTasks();

print("
    <form action='about.php' method='get'>
        <label>Changing of password</label>
        <input type='text' name='current' placeholder='Type your current password'>
        <input type='text' name='new' placeholder='Type new password'>
        <input type='submit' name='changePassword' value='Change'>
        <br>
        <label>Changing of name</label>
        <input type='text' name='newName' placeholder='Type your new name'>
        <input type='submit' name='changeName' value='Change'>
    </form>
");
print("</div>");

print("<div id='air' style='width: 500px; height: 400px;'></div>");

require('footer.html');

?>

<?php

if(isset($_REQUEST['changePassword']))
{
    if($_REQUEST['current'] and $_REQUEST['new']) {}
    else
    {
        echo "<script>alert('Пароли должны быть непустыми!')</script>";
        return;
    }
    // Здесь нужно запросить текущий пароль и сравнить с $_REQUEST['current']
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $select = "SELECT `password` FROM `users` WHERE `id_user`='".$_SESSION["idUser"]."'";
    $res = mysqli_query($con, $select);
    foreach($res as $result)
    {
        if($result["password"] == $_REQUEST['current'])
        {
            require('data.php');
            $con = mysqli_connect($host, $user, $pas) or die ('Error con');
            mysqli_select_db($con, $db) or die ('Error db');
            $update = "UPDATE `users` SET `password`=".$_REQUEST['new']." WHERE `id_user`='".$_SESSION["idUser"]."'";
            mysqli_query($con, $update);
        }
        else
        {
            echo "<script>alert('Текущий пароль введен неверно!')</script>";
            return;
        }
    }
    header("Location: about.php");
}

if(isset($_REQUEST['changeName']))
{
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $update = "UPDATE `users` SET `name`='".$_REQUEST['newName']."' WHERE `id_user`='".$_SESSION["idUser"]."'";
    print($update);
    mysqli_query($con, $update);
    // echo "<script>alert('Имя изменено!')</script>";
    header("Location: about.php");
}

?>

<?php

function printID()
{
    echo('Your unique ID is '.$_SESSION["idUser"]);
}

function printNAME()
{
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $query = "SELECT name FROM `users` WHERE `id_user`='".$_SESSION["idUser"]."'";
    $res = mysqli_query($con, $query);
    foreach($res as $result)
    {
        echo('<br>');
        print('Your name is '.$result['name']);
    }
}

function printEMAIL()
{
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $query = "SELECT email FROM `users` WHERE `id_user`='".$_SESSION["idUser"]."'";
    $res = mysqli_query($con, $query);
    foreach($res as $result)
    {
        echo('<br>');
        print('Your email is '.$result['email']);
    }
}

function printNumberOfTasks()
{
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $query = "SELECT count(task) FROM `tasks` WHERE `idUser`='".$_SESSION["idUser"]."'";
    $res = mysqli_query($con, $query);
    foreach($res as $result)
    {
        echo('<br>');
        print('Number of your tasks is '.$result['count(task)']);
    }
}

?>