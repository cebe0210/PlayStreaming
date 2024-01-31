<?php


class Movie
{
    private $_id_movie;
    private $_title;
    private $_description;
    private $_image;
    private $_duration;
    private $_trailer;
    private $_release_date;
    private $_categories;

    public function __construct($id_movie,$title, $description, $image, $duration, $trailer, $release_date, $categories){
        $this->_id_movie = $id_movie;
        $this->_title = $title;
        $this->_description = $description;
        $this->_image = $image;
        $this->_duration = $duration;
        $this->_trailer = $trailer;
        $this->_release_date = $release_date;
        $this->_categories = $categories;
    }

    public function id_movie(){
        return $this->_id_movie;
    }
    public function title(){
        return $this->_title;
    }
    public function description(){
        return $this->_description;
    }
    public function image(){
        return $this->_image;
    }
    public function duration(){
        return $this->_duration;
    }
    public function trailer(){
        return $this->_trailer;
    }
    public function release_date(){
        return $this->_release_date;
    }
    public function categories(){
        return $this->_categories;
    }

    public function html_id_movie(){
        return htmlspecialchars($this->_id_movie);
    }
    public function html_title(){
        return htmlspecialchars($this->_title);
    }
    public function html_description(){
        return htmlspecialchars($this->_description);
    }
    public function html_image(){
        return htmlspecialchars($this->_image);
    }
    public function html_duration(){
        return htmlspecialchars($this->_duration);
    }
    public function html_trailer(){
        return htmlspecialchars($this->_trailer);
    }
    public function html_release_date(){
        return htmlspecialchars($this->_release_date);
    }
    public function html_categories(){
        return htmlspecialchars($this->_categories);
    }
}