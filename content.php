 <content>
    <h1>Content</h1>
    <div>
        <form action="" method="get">
            <input type="text" name="tasks" placeholder="task">
            <input type="text" name="tasks" placeholder="task">
            <input type="submit" name="exit" value="Выход">
        </form>
        <ul>
            <?php
            $request = "select * from 'tasks' where email = ".$_SESSION['idUser'];

            foreach($res as $result) // Ну или наоборот
            {
                print("
                <li>
                <div>".$result['task']."</div>
                </li>
                ");
            }
            ?>
            <li>
                <div><input type="checkbox"></div>
                <div>Task</div>
            </li>
        </ul>
    </div>
</content>

<?php
if(isset($_REQUEST['exit']))
{
    $_SESSION = array();
    session_destroy();
    header('Location: auth.php');
}
?>