<?php


class Comment
{
    private $_id_comment;
    private $_user;
    private $_movie;
    private $_date;
    private $_content;
    private $_is_deleted;

    public function __construct($id_comment,$user, $movie, $date, $content, $is_deleted){
        $this->_id_comment = $id_comment;
        $this->_user = $user;
        $this->_movie = $movie;
        $this->_date = $date;
        $this->_content = $content;
        $this->_is_deleted = $is_deleted;
    }

    public function id_comment(){
        return $this->_id_comment;
    }
    public function user(){
        return $this->_user;
    }
    public function movie(){
        return $this->_movie;
    }
    public function date(){
        return $this->_date;
    }
    public function content(){
        return $this->_content;
    }
    public function is_deleted(){
        return $this->_is_deleted;
    }

    public function html_id_comment(){
        return htmlspecialchars($this->_id_comment);
    }
    public function html_user(){
        return htmlspecialchars($this->_user);
    }
    public function html_movie(){
        return htmlspecialchars($this->_movie);
    }
    public function html_date(){
        return htmlspecialchars($this->_date);
    }
    public function html_content(){
        return htmlspecialchars($this->_content);
    }
    public function html_is_deleted(){
        return htmlspecialchars($this->_is_deleted);
    }
}