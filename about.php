<?php
    session_start();
    if($_SESSION == null)
    {
        header("Location: auth.php");
    }
?>

<?php

require('header.html');

printID();
printNAME();
printEMAIL();
printNumberOfTasks();

require('about.html');

require('footer.html');

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