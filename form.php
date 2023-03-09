<?php
ob_clean();
print("
<div id='registration'>
    <div id='blackout'>
        <div id='window'>
            <p> Окно регистрации </p>
            <p> Email: </p>
            <form action='todolist.php' method='get'>
            <input type='text' name='name' placeholder='Type new Name' value='name'>
            <!-- <p> Password: </p>
            <input type='password' name='password' placeholder='Type your password'> -->

            <button type='submit' name='change' value=''>Change name</button>
            <a href='#' class='close'> Закрыть окно </a>
            </form>
        </div>
    </div>
</div>
");
?>