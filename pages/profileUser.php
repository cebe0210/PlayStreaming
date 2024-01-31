<?php 
    require_once('../config.php');

    function loadClass($className) {
        require_once('../models/' . $className . '.class.php');
    }
    spl_autoload_register('loadClass');

    session_start();
    if (empty($_SESSION['user'])) {
        header("Location: ../index.php");
        die();
    }

    $db=Db::getInstance($servername,$dbname,$username,$password);

    require_once('../controllers/ProfileUserController.php');
    $controller=new ProfileUserController($db);
    $controller->run();
?>