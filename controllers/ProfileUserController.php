<?php

class ProfileUserController{

    private $_db;

    public function __construct($db){
        $this->_db = $db;
    }

    public function run(){
        $notification = '';
        $newEmail='';
        $newNick='';
        $newPw='';
        if(!empty($_POST['editProfile'])){
            if(!empty($_POST['newEmail'])){
                $newEmail=$_POST['newEmail'];
            }
            if(!empty($_POST['newNick'])){
                $newNick=$_POST['newNick'];
            }
            if(!empty($_POST['newPw'])){
                if($_POST['newPw']==$_POST['confirmNewPw'])$newPw=$_POST['newPw'];
                else {
                    $notification="Passwords don't match";
                    include('profil_user.php');
                    return;
                }
            }
            $notification = $this->_db->editProfile($_SESSION['user']->id_user(),$newEmail,$newNick,$newPw);
            
            if($notification=="true"){
                $_SESSION['email'] =$_SESSION['user']->html_email();
                $_SESSION['nickname'] =$_SESSION['user']->html_nickname();
                header("Location: ../pages/menu.php");
                die();
            }
        }
        include('profil_user.php');
    }

}
?>