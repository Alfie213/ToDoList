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

<?php
    if(isset($_REQUEST['change']))
    {
        print("
        <button>Button</button>
        ");
    }
?>

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
        print("<form action='todolist.php' method='get'>");
        foreach($res as $result)
        {
            print("
            <li>
            <div class='tsk'>
               
                    <label>".$result['task']."</label>
                    <button type='submit' name='done' value='".$result['id']."'>Checked/Unchecked</button>

                    <input type='checkbox' name='checkbox' disabled='disabled' value='".$result['id']."'");
                    if($result['isDone'] == 1)
                    {
                        print("checked>");
                    }
                    else
                    {
                        print(">");
                    }

                    print("
                    <button type='submit' name='edit' value='".$result['id']."'>Редактировать</button>
                    <input type='submit' name='delete' value='".$result['id']."'> Удалить
                
            </div>
            </li>
            ");
        }
        print("</form>");
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
    $request = "SELECT `isDone` FROM `tasks` WHERE `id`='".$_REQUEST['done']."'";
    $res = mysqli_query($con, $request);
    foreach($res as $result)
    {
        $res = $result['isDone'];
    }
    if($res)
    {
        $upd = "UPDATE `tasks` SET `isDone`='0' WHERE `id`='".$_REQUEST['done']."'";
    }
    else
    {
        $upd = "UPDATE `tasks` SET `isDone`='1' WHERE `id`='".$_REQUEST['done']."'";
    }
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
    require('form.php');
    
    // header('Location: index.php');
}
?>