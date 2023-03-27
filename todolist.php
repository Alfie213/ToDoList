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
    // if(isset($_REQUEST['change']))
    // {
    //     print("
    //     <button>Button</button>
    //     ");
    // }
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
        print("<div class='container'>");
        print("<section class='tasks'>");
        print("<form action='todolist.php' method='get'>");
        print("<ul class='tasks__list'>");
        foreach($res as $result)
        {
            print("
            <li class='tsk'>
                <label class='coolText'>".$result['task']."</label>
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
                <button type='submit' name='delete' value='".$result['id']."'>Удалить</button>
            </li>
            ");
        }
        print("</ul>");
        print("</form>");
        print("</section>");
        print("</div>");

        if(file_get_contents('form.php'))
        {
            require('form.php');
            print("
            <div id='registration'>
                <div id='blackout'>
                    <div id='window'>
                        <p> Changing name </p>
                        <p> Type new name: </p>
                        <form action='todolist.php' method='get'>
                        <input type='text' name='name' placeholder='Type new Name' value='".$name."'>
                        <!-- <p> Password: </p>
                        <input type='password' name='password' placeholder='Type your password'> -->

                        <button type='submit' name='change' value='"."$id"."'>Change name</button>
                        <a href='./todolist.php?name=someVal&close=' class='close'> Закрыть окно </a>
                        </form>
                    </div>
                </div>
            </div>  
            ");
        }
        if(isset($_REQUEST['close']))
        {
            $fp = fopen("form.php", "a"); // Открываем файл в режиме записи
            file_put_contents("form.php", ''); // Стираем содержимое.
            header('Location: index.php');
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
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $request = "SELECT `task` FROM tasks WHERE id = '".$_REQUEST['edit']."'";
    // print($request);
    $res = mysqli_query($con, $request);
    $name = 'empty';
    foreach($res as $result)
    {
        $name = $result['task'];
    }
    
    $fp = fopen("form.php", "a"); // Открываем файл в режиме записи
    file_put_contents("form.php", ''); // Стираем содержимое.
    $mytext =
    '<?php
        $id = '.$_REQUEST['edit'].';
        $name = "'.$name.'";
    ?>'; // Исходная строка
    $test = fwrite($fp, $mytext); // Запись в файл
    // if ($test) echo 'Данные в файл успешно занесены.';
    // else echo 'Ошибка при записи в файл.';
    fclose($fp); //Закрытие файла
    
    header('Location: index.php');
    

    // require('form.php');
    // print("
    // <div id='registration'>
    //     <div id='blackout'>
    //         <div id='window'>
    //             <p> Changing name </p>
    //             <p> Type new name: </p>
    //             <form action='todolist.php' method='get'>
    //             <input type='text' name='name' placeholder='Type new Name' value='"."$name"."'>
    //             <!-- <p> Password: </p>
    //             <input type='password' name='password' placeholder='Type your password'> -->

    //             <button type='submit' name='change' value='"."$id"."'>Change name</button>

    //             <a href='./index.php' class='close'> Закрыть окно </a>
    //             </form>
    //         </div>
    //     </div>
    // </div>  
    // ");
}
if(isset($_REQUEST['change']))
{
    require('data.php');
    $con = mysqli_connect($host, $user, $pas) or die ('Error con');
    mysqli_select_db($con, $db) or die ('Error db');
    $upd = "UPDATE `tasks` SET `task`='".$_REQUEST['name']."' WHERE `id`='".$_REQUEST['change']."'";
    mysqli_query($con, $upd);
    $fp = fopen("form.php", "a"); // Открываем файл в режиме записи
    file_put_contents("form.php", ''); // Стираем содержимое.
    header('Location: index.php');
}
?>