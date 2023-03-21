<?php/*
session_start();

if($_SESSION == null)
{
    header("Location: auth.php");
}*/
?>

<?php

require('header.html');

require('todolist.php');

?>

<div id="container">
    <div class="zone1"></div>
    <div class="zone2">
        <img id="ufo" src="./ufo.png" draggable="true">
    </div>
</div>
<script src="drop.js"></script>

<?php

// require('footer.html');

?>

