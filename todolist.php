<?php
    session_start();
    if($_SESSION == null)
    {
        header("Location: auth.php");
    }

    if(isset($_REQUEST['ins']))
    {
        require('data.php');
        $con = mysqli_connect($host, $user, $pas) or die ('Error con');
        mysqli_select_db($con, $db) or die ('Error db');
        $tsk = $_REQUEST['tasks'];
        $ins = "INSERT INTO tasks (task, idUser) VALUES ('".$tsk."','".$_SESSION["idUser"]."')";
        if(trim($tsk))
        {
            mysqli_query($con, $ins);
            header('Location: index.php');
        }
    }
?>
<div id="registration">
	<div id="blackout">
		<div id="window">
			<p> Окно редактирования задачи </p>
			<p> name: </p>
			<input type="text" placeholder="Type new name">
			<!-- <p> Password: </p> -->
			<!-- <input type="password" placeholder="Type your password"> -->

			<a href="#" class="close"> Изменить имя (я не работаю) </a>
			<a href="#" class="close"> Закрыть окно </a>
		</div>
	</div>
</div>

<div class="content">
    <form action="" method="get">
        <input type="text" name="tasks" id="tasks" placeholder="task">
        <input type="submit" name="ins" id="ins" value="Добавить">
        <input type="submit" name="exit" value="Выход">
    </form>

    <ul>
        <?php
        require('data.php');
        $con = mysqli_connect($host, $user, $pas) or die ('Error con');
        mysqli_select_db($con, $db) or die ('Error db');
        $request = "SELECT * FROM tasks WHERE idUser = '".$_SESSION["idUser"]."'";
        // print( $request);
        $res = mysqli_query($con, $request);
        foreach($res as $result)
        {
            print("
            <li>
            <div class='tsk'>
                <form action='' method='get'>
                    <label>".$result['task']."</label>
                    <input type='submit' name='done' value='".$result['id']."'>

                    <input type='checkbox' disabled='disabled'");
                    if($result['isDone'] == 1)
                    {
                        print(' checked>');
                    }
                    else
                    {
                        print('>');
                    }

                    print("
                    <input type='submit' name='edit' value='".$result['id']."'> <a href='#registration'>Редактировать</a>
                    <input type='submit' name='delete' value='".$result['id']."'> Удалить
                </form>
            </div>
            </li>
            ");
        }
        ?>
    </ul>
</div>

<?php
if(isset($_REQUEST['exit']))
{
    $_SESSION = array();
    session_destroy();
    header('Location: auth.php');
}
?>

<?php
if(isset($_REQUEST['done']))
{
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $upd = "UPDATE `tasks` SET `isDone`='"."1"."' WHERE `id`='".$_REQUEST['done']."'";
    mysqli_query($con, $upd);
    header('Location: index.php');
}

if(isset($_REQUEST['delete']))
{
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $delete = "DELETE FROM `tasks` WHERE `id`='".$_REQUEST['delete']."'";
    print($delete);
    mysqli_query($con, $delete);
    header('Location: index.php');
}

if(isset($_REQUEST['edit']))
{
    
}
?>