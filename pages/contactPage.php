<?php 
    require_once('../config.php');

    function loadClass($className) {
        require_once('../models/' . $className . '.class.php');
    }
    spl_autoload_register('loadClass');

    $db=Db::getInstance($servername,$dbname,$username,$password);

    require_once('../controllers/ContactPageController.php');
    $controller=new ContactPageController($db);
    $controller->run();
?>