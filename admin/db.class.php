<?php
include '../config.php';
function loadClass($className) {
    require_once('../models/' . $className . '.class.php');
}
spl_autoload_register('loadClass');
$film_Iddb = $idfilm;
$filmNamedb = mysqli_real_escape_string($conn, $filmName);
//$filmYeardb = substr($filmYear, 0, 4);
$filmYeardb = $filmYear;
$filmRuntimedb = $filmRuntime;
$filmSummarydb = mysqli_real_escape_string($conn, $filmSummary);
//$filmImagedb = 'https://image.tmdb.org/t/p/w500' . $filmImage;
$filmImagedb = $filmImage;
//$filmGenresdb = $filmGenres;
$filmGenresdb = is_array($filmGenres) ? implode(", ", array_column($filmGenres, 'name')) : '';
$youtube_linkdb = $youtube_link;

  

// Appeler la méthode addFilm
$insertSuccess = false;  // Déclaration de la variable

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitBtn'])) {
    // Instancier la classe Db
    $db = new Db($conn);

    // Appeler la méthode addFilm
    $insertSuccess = $db->addFilm($film_Iddb, mysqli_real_escape_string($conn, $filmNamedb), mysqli_real_escape_string($conn, $filmSummarydb),
        'https://image.tmdb.org/t/p/w500' . $filmImagedb, $filmRuntimedb, $youtube_linkdb, $filmYeardb, $filmGenresdb);

}
class Db {
    
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addFilm($film_Iddb, $filmNamedb, $filmSummarydb, $filmImagedb, $filmRuntimedb, $youtube_linkdb, $filmYeardb, $filmGenresdb) {
        // Vérifier si l'ID existe déjà dans la base de données
        $sqlCheck = "SELECT id_movie FROM movies WHERE id_movie = ?";
        $stmtCheck = mysqli_prepare($this->conn, $sqlCheck);
        mysqli_stmt_bind_param($stmtCheck, "i", $film_Iddb);
        mysqli_stmt_execute($stmtCheck);
        mysqli_stmt_store_result($stmtCheck);

        if (mysqli_stmt_num_rows($stmtCheck) > 0) {
            mysqli_stmt_close($stmtCheck);
            //echo "Erreur : Le film avec l'ID $film_Iddb existe déjà dans la base de données.";
            return false; // Indiquer que l'ajout a échoué
        }
        //$exists = mysqli_stmt_num_rows($stmtCheck) > 0;

        // Fermer la déclaration de vérification
        mysqli_stmt_close($stmtCheck);

        // L'ID n'existe pas, procéder à l'insertion
        $sqlInsert = "INSERT INTO movies (id_movie, title, description, image, duration, trailer, release_date, categories) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmtInsert = mysqli_prepare($this->conn, $sqlInsert);
        mysqli_stmt_bind_param($stmtInsert, "isssisis", $film_Iddb, $filmNamedb, $filmSummarydb, $filmImagedb, $filmRuntimedb, $youtube_linkdb, $filmYeardb, $filmGenresdb);

        // Exécuter la requête
        $success = mysqli_stmt_execute($stmtInsert);

        // Fermer la déclaration
        mysqli_stmt_close($stmtInsert);

        return $success;
    }

}
?>
