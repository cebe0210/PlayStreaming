<?php

class RegisterController{

    private $_db;

    public function __construct($db){
        $this->_db = $db;
    }

    public function run(){
        $notification = '';
        if(!empty($_POST['register'])){
            if($_POST['password']==$_POST['pwConfirm']) $notification = $this->_db->register($_POST['email'],$_POST['username'],$_POST['password']);
            else $notification="Passwords don't match";
            if($notification=="true"){
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['role'] = MEMBER;
                $_SESSION['nickname'] =$_SESSION['user']->html_nickname();
                header("Location: pages/menu.php");
                die();
            }
        }

        include(VIEWS_PATH.'inscription.php');
    }

}
?>