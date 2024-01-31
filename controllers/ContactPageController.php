<?php

class ContactPageController{

    private $_db;

    public function __construct($db){
        $this->_db = $db;
    }

    public function run(){
        $notification = '';
        if(!empty($_POST['contactForm'])){
            $name="Anonymous";
            if(!empty($_POST['contactName']))$name=$_POST['contactName'];
            $notification=$this->_db->sendContactMessage($_POST['contactEmail'],$name,$_POST['contactTopic'],$_POST['contactMessage']);
        }

        include('contact.php');
    }

}
?>