<?php

class Db {
    private static $instance = null;
    private $_connection;

    public function __construct($servername,$dbname,$username,$password) {
        try {
            $this->_connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->_connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        }
        catch (PDOException $e) {
            die('Database connection error : '.$e->getMessage());
        }
    }

    public static function getInstance($servername,$dbname,$username,$password)
    {
        if (is_null(self::$instance)) {
            self::$instance = new Db($servername,$dbname,$username,$password);
        }
        return self::$instance;
    }

    public function register($email, $nickname, $password){
        $queryNickname = 'SELECT nickname from users WHERE nickname = :nickname';
        $psNickname = $this->_connection->prepare($queryNickname);
        $psNickname->bindValue(':nickname',$nickname);
        $psNickname->execute();
        if($psNickname->rowcount() != 0)
            return 'Nickname already used';

        $queryEmail = 'SELECT email FROM users WHERE email=:email';
        $psEmail = $this->_connection->prepare($queryEmail);
        $psEmail->bindValue(':email',$email);
        $psEmail->execute();
        if($psEmail->rowCount() != 0)
            return 'Email already used';

        $query = 'INSERT INTO users (password, nickname, email)
                    VALUES (:password, :nickname, :email)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':password', password_hash($password,PASSWORD_BCRYPT));
        $ps->bindValue(':nickname', $nickname);
        $ps->bindValue(':email', $email);
        $ps->execute();
        self::connectUser($email);
        return "true";
    }

    public function login_user($email, $password){
        $query = 'SELECT role, password, is_disabled from users WHERE email = :email';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $row = $ps->fetch();
        if ($ps->rowcount() == 0)
            return 'Email is not registered';
        if ($row->is_disabled == '1') // == true
            return 'Account banned';
        if (password_verify($password, $row->password)) {
            self::connectUser($email);
            return $row->role;
        }
        return 'Incorrect password';

    }

    public function connectUser($email){
        $query =    'SELECT u.*
                    FROM users u
                    WHERE u.email = :email';

        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email', $email);
        $ps->execute();

        $row = $ps->fetch();
        $_SESSION['user'] = new User($row->id_user,$row->nickname,$row->email, $row->role,$row->is_disabled);
    }

    public function editProfile($idUser, $email, $nickname, $password){
        if($nickname!=''){
            $queryNickname = 'SELECT nickname from users WHERE nickname = :nickname';
            $psNickname = $this->_connection->prepare($queryNickname);
            $psNickname->bindValue(':nickname',$nickname);
            $psNickname->execute();
            if($psNickname->rowcount() != 0)
                return 'Nickname already used';
        }
        if($email!=''){
            $queryEmail = 'SELECT email FROM users WHERE email=:email';
            $psEmail = $this->_connection->prepare($queryEmail);
            $psEmail->bindValue(':email',$email);
            $psEmail->execute();
            if($psEmail->rowCount() != 0)
                return 'Email already used';
        }
        if($nickname!=''){
            $updateNick = 'UPDATE users SET nickname=:nickname WHERE id_user= :id_user';
            $ps = $this->_connection->prepare($updateNick);
            $ps->bindValue(':nickname', $nickname);
            $ps->bindValue(':id_user', $idUser);
            $ps->execute();
        }
        if($email!=''){
            $updateEmail = 'UPDATE users SET email=:email WHERE id_user= :id_user';
            $ps = $this->_connection->prepare($updateEmail);
            $ps->bindValue(':email', $email);
            $ps->bindValue(':id_user', $idUser);
            $ps->execute();
        }
        if($password!=''){
            $updatePw = 'UPDATE users SET email=:email WHERE id_user= :id_user';
            $ps = $this->_connection->prepare($updatePw);
            $ps->bindValue(':password', password_hash($password,PASSWORD_BCRYPT));
            $ps->bindValue(':id_user', $idUser);
            $ps->execute();
        }
        self::connectUserById($idUser);
        return "true";
    }

    public function connectUserById($id){
        $query =    'SELECT u.*
                    FROM users u
                    WHERE u.id_user = :id_user';

        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_user', $id);
        $ps->execute();

        $row = $ps->fetch();
        $_SESSION['user'] = new User($row->id_user,$row->nickname,$row->email, $row->role,$row->is_disabled);
    }

    public function sendContactMessage($email,$name,$topic,$message){
        $query = 'INSERT INTO contact (name, email, message, topic)
                    VALUES (:name, :email, :message, :topic)';

        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':name', $name);
        $ps->bindValue(':email', $email);
        $ps->bindValue(':message', $message);
        $ps->bindValue(':topic',$topic);
        $ps->execute();

        return "Message sent";
    }

    public function seeAllUsers(){

        $query = 'SELECT id_user, nickname, email, role, is_disabled FROM users';
        $ps = $this->_connection->prepare($query);
        $ps->execute();

        return $ps->fetchAll(PDO::FETCH_ASSOC);
    }

    public function promote($id){
        $query = 'UPDATE users SET role=:role WHERE id_user= :id_user';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':role','a');
        $ps->bindValue(':id_user',$id);
        $ps->execute();

        return 'User with the id '.$id.' was promoted';
    }

    public function demote($id){
        $query = 'UPDATE users SET role=:role WHERE id_user= :id_user';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':role','m');
        $ps->bindValue(':id_user',$id);
        $ps->execute();

        return 'User with the id '.$id.' was demoted';
    }

    public function ban($id){
        $query = 'UPDATE users SET is_disabled=:is_disabled WHERE id_user= :id_user';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':is_disabled',1);
        $ps->bindValue(':id_user',$id);
        $ps->execute();

        return 'User with the id '.$id.' was banned';
    }

    public function unban($id){
        $query = 'UPDATE users SET is_disabled=:is_disabled WHERE id_user= :id_user';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':is_disabled',0);
        $ps->bindValue(':id_user',$id);
        $ps->execute();

        return 'User with the id '.$id.' was unbanned';
    }

    public function selectComments($selectedmovie){
        $query =    'SELECT c.*, u.nickname
                    FROM comments c, users u
                    WHERE c.user = u.id_user
                    AND c.movie = :selectedmovie';

        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':selectedmovie',$selectedmovie);
        $ps->execute();

        $results = array();
        while ($row = $ps->fetch()) {
            $results[] = new Comment($row->id_comment,$row->user,$row->movie,$row->date,$row->content,$row->is_deleted);
        }

        return $results;
    }


    public function insertComment($content, $user, $movie){
        $query = 'INSERT INTO comments (user, movie, content)
                    VALUES (:user, :movie, :content)';

        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':user', $user);
        $ps->bindValue(':movie', $movie);
        $ps->bindValue(':content', $content);
        $ps->execute();
    }

    public function myComments($user){
        $query =    'SELECT m.title, c.comment
                    FROM movies m, comments c
                    WHERE m.id_movie = c.movie
                    AND c.user = :user; ';

        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':user', $user, PDO::PARAM_INT);
        $ps->execute();

        $results = array();
        while ($row = $ps->fetch()) {
            $results[] = array($row->title,$row->comment);
        }

        return $results;
    }

    public function deleteComment($user, $comment){
        $query = 'UPDATE comments 
                    SET is_deleted=TRUE
                    WHERE id_comment= :comment
                    AND user = :user;';

        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':comment', $comment);
        $ps->bindValue(':user', $user);
        $ps->execute();
    }
}
?>
