<?php
include '../config.php';

class PopulairesDB {
    private $conn;
    private $api_key;

    public function __construct($conn, $api_key) {
        $this->conn = $conn;
        $this->api_key = $api_key;
    }

    public function updateDatabase() {
        $popularMoviesApiUrl = "https://api.themoviedb.org/3/movie/popular";
        $params = ['api_key' => $this->api_key];
        $apiUrlWithParams = $popularMoviesApiUrl . '?' . http_build_query($params);
        $response = file_get_contents($apiUrlWithParams);
        $data = json_decode($response, true);

        if (empty($data) || isset($data['status_code'])) {
            $errorMessage = isset($data['status_message']) ? $data['status_message'] : 'Aucune donnée valide trouvée dans la réponse de l\'API.';
            die('Erreur de l\'API : ' . $errorMessage);
        }

        // Assurez-vous d'avoir les ID des films populaires disponibles, par exemple :
        $popularMovieIds = array_column($data['results'], 'id');

        // Récupérer les IDs des films déjà présents dans la base de données
        $existingIds = [];
        $existingIdsQuery = "SELECT id_populaire FROM populaire";
        $existingIdsResult = $this->conn->query($existingIdsQuery);

        if ($existingIdsResult->num_rows > 0) {
            while ($row = $existingIdsResult->fetch_assoc()) {
                $existingIds[] = $row['id_populaire'];
            }
        }

        // Comparer avec les nouveaux IDs obtenus à partir de l'API
        $idsToDelete = array_diff($existingIds, $popularMovieIds);

        // Supprimer les entrées qui ne sont plus présentes dans la nouvelle liste d'IDs
        if (!empty($idsToDelete)) {
            $deleteQuery = "DELETE FROM populaire WHERE id_populaire IN (" . implode(',', $idsToDelete) . ")";
            $this->conn->query($deleteQuery);
        }

        foreach ($popularMovieIds as $idfilm) {
    // URL de l'API pour obtenir les détails du film
    $filmApiUrl = "https://api.themoviedb.org/3/movie/{$idfilm}";
    $params = ['api_key' => $this->api_key];
    $apiUrlWithParams = $filmApiUrl . '?' . http_build_query($params);

    // Effectuer la requête à l'API pour obtenir les détails du film
    $response = file_get_contents($apiUrlWithParams);
    $filmData = json_decode($response, true);

    // Vérifier si la réponse de l'API est valide
    if (empty($filmData) || isset($filmData['status_code'])) {
        $errorMessage = isset($filmData['status_message']) ? $filmData['status_message'] : 'Aucune donnée valide trouvée dans la réponse de l\'API.';
        die('Erreur de l\'API : ' . $errorMessage);
    }

    // Récupérer les détails du film
    $filmName = $filmData['title'];
    $filmYear = isset($filmData['release_date']) ? intval(substr($filmData['release_date'], 0, 4)) : null;
    $filmGenres = $filmData['genres'];
    $filmRuntime = $filmData['runtime'];
    $filmSummary = $filmData['overview'];
    $filmImage = 'https://image.tmdb.org/t/p/w500' . $filmData['poster_path'];

    $videoApiUrl = "https://api.themoviedb.org/3/movie/{$idfilm}/videos?language=en-US&api_key={$this->api_key}";

        // Effectuer la requête à l'API pour obtenir les vidéos du film
        $response = file_get_contents($videoApiUrl);
        $videoData = json_decode($response, true);

        // Vérifier si la réponse de l'API pour les vidéos est valide
        if (empty($videoData) || !isset($videoData['results']) || !is_array($videoData['results'])) {
            die('Aucune donnée valide trouvée dans la réponse de l\'API pour les vidéos.');
        }
    // Vérifier si la réponse de l'API pour les vidéos est valide
    if (empty($videoData) || !isset($videoData['results']) || !is_array($videoData['results'])) {
        die('Aucune donnée valide trouvée dans la réponse de l\'API pour les vidéos.');
    }
  
    $last_key_value = '';

if (!empty($data['results']) && is_array($data['results'])) {
    $lastResult = end($data['results']);
    if (isset($lastResult['key'])) {
        $last_key_value = $lastResult['key'];
    }
}

    // Utilisez $last_key_value comme nécessaire dans la suite de votre code

    // Récupérer les liens des vidéos
    $lastVideoKey = '';

if (isset($videoData['results']) && is_array($videoData['results']) && !empty($videoData['results'])) {
    $lastVideoResult = end($videoData['results']);
    if (isset($lastVideoResult['key'])) {
        $lastVideoKey = $lastVideoResult['key'];
    }
}
    $youtubeLink = "https://www.youtube.com/embed/{$lastVideoKey}";

    // Préparer les données pour l'insertion ou la mise à jour
    $filmName = $this->conn->real_escape_string($filmName);
    $filmYear = intval($filmYear);
    $filmGenres = implode(', ', array_column($filmGenres, 'name'));
    $filmRuntime = intval($filmRuntime);
    $filmSummary = $this->conn->real_escape_string($filmSummary);
    $filmImage = $this->conn->real_escape_string($filmImage);
    $youtubeLink = $this->conn->real_escape_string($youtubeLink);

    // Vérifier si le film existe déjà dans la base de données
    $checkQuery = "SELECT * FROM populaire WHERE id_populaire = '$idfilm'";
    $checkResult = $this->conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Mettre à jour les données existantes
        $updateQuery = "UPDATE populaire SET title_populaire = '$filmName', release_date_populaire = '$filmYear', categories_populaire = '$filmGenres', duration_populaire = '$filmRuntime', description_populaire = '$filmSummary', image_populaire = '$filmImage', trailer_populaire = '$youtubeLink' WHERE id_populaire = '$idfilm'";
        $this->conn->query($updateQuery);
    } else {
        // Insérer de nouvelles données
        $insertQuery = "INSERT INTO populaire (id_populaire, title_populaire, release_date_populaire, categories_populaire, duration_populaire, description_populaire, image_populaire, trailer_populaire) VALUES ('$idfilm', '$filmName', '$filmYear', '$filmGenres', '$filmRuntime', '$filmSummary', '$filmImage', '$youtubeLink')";
        $this->conn->query($insertQuery);
    }
}

// Fermer la connexion à la base de données
//$this->conn->close();
}
}

// Créer une instance de la classe PopulairesDB
$populairesDB = new PopulairesDB($conn, $api_key);

// Appeler la fonction pour mettre à jour la base de données
$populairesDB->updateDatabase();
?>