<?php
include '../config.php';

session_start();
if (empty($_SESSION['user'])) {
    header("Location: ../index.php");
    die();
}

// Vérifier si l'ID du film est présent dans l'URL
if (isset($_GET['id'])) {
    $idfilm = $_GET['id'];

    // URL de l'API pour obtenir les détails du film
    $filmApiUrl = "https://api.themoviedb.org/3/movie/{$idfilm}";
    $params = ['api_key' => $api_key];
    $apiUrlWithParams = $filmApiUrl . '?' . http_build_query($params);

    // Effectuer la requête à l'API pour obtenir les détails du film
    $response = file_get_contents($apiUrlWithParams);
    $data = json_decode($response, true);

    // Vérifier si la réponse de l'API est valide
    if (empty($data) || isset($data['status_code'])) {
        $errorMessage = isset($data['status_message']) ? $data['status_message'] : 'Aucune donnée valide trouvée dans la réponse de l\'API.';
        die('Erreur de l\'API : ' . $errorMessage);
    }

    // Récupérer les détails du film
    $filmName = $data['title'];
    $filmYear = isset($data['release_date']) ? intval(substr($data['release_date'], 0, 4)) : null;
    $filmGenres = $data['genres'];
    $filmRuntime = $data['runtime'];
    $filmSummary = $data['overview'];
    $filmImage = 'https://image.tmdb.org/t/p/w500' . $data['poster_path'];

    // Convertisseur minutes - heures:minutes
    $hours = floor($filmRuntime / 60);
    $minutes = $filmRuntime % 60;

    // URL de l'API pour obtenir les vidéos du film
    $videoApiUrl = "https://api.themoviedb.org/3/movie/{$idfilm}/videos?language=en-US&api_key={$api_key}";

    // Effectuer la requête à l'API pour obtenir les vidéos du film
    $response = file_get_contents($videoApiUrl);
    $data = json_decode($response, true);

    // Vérifier si la réponse de l'API pour les vidéos est valide
    if (empty($data) || !isset($data['results']) || !is_array($data['results'])) {
        die('Aucune donnée valide trouvée dans la réponse de l\'API pour les vidéos.');
    }

    // Récupérer les liens des vidéos
    $first_key_value = $data['results'][0]['key'];
    $last_key_value = end($data['results'])['key'];

    //$youtube_link = "https://www.youtube.com/watch?v={$last_key_value}";
    $youtube_link = "https://www.youtube.com/embed/{$last_key_value}";

    // Le reste de votre code HTML reste inchangé
} else {
    // Rediriger l'utilisateur ou afficher un message d'erreur si l'ID du film n'est pas présent dans l'URL
    header('Location: page_d_accueil.php');
    exit();
}
function formatDuration($durationMinutes) {
    $hours = floor($durationMinutes / 60);
    $minutes = $durationMinutes % 60;

    return $hours . 'h' . ($minutes > 0 ? sprintf('%02d', $minutes) . 'min' : '');
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 3px;
        }
    </style>

</head>

<body class="w-screen h-screen bg-gray-600 overflow-x-hidden flex flex-col">
    <?php include "../styles/navBar.php"; ?>
    <main class="flex-1 flex flex-row block overflow-hidden">
        <div class="w-1/4 h-4/4 flex items-stretch flex-shrink-0">
            <img src="<?php echo  $filmImage; ?>" alt="affiche <?php echo $filmName; ?>" class="object-cover w-full h-9/10 rounded-2xl p-3">
        </div>
        <div class="w-3/4 h-4/4 flex flex-col relative m-3 flex-shrink-0">
            <div class="flex h-2/3">
                <div class="w-1/3 h-full rounded-2xl">
                    <div class="h-5/6 bg-gray-800 rounded-2xl flex flex-col items-center justify-center px-6">
                        <h2 class="w-full h-1/3 flex items-center justify-center text-white text-3xl font-bold text-center"> <?php echo $filmName; ?> </h2>
                        <div class="flex w-full h-2/3 flex-col justify-center">
                            <div class="w-full h-1/2 overflow-y-auto">
                                <p class="text-white text-center mx-5"><?php echo $filmSummary; ?></p>
                            </div>
                            <div class="py-5">
                                <p class="text-white font-bold mx-5 my-2">Date de sortie: <?php echo $filmYear; ?></p>
                                <p class="text-white font-bold mx-5 my-2">Genres: <?php echo implode(', ', array_column($filmGenres, 'name')); ?></p>
                                <p class="text-white font-bold mx-5 my-2">Durée: <?php echo formatDuration($filmRuntime); ?></p>
                            </div>
                        </div>
                    </div>

                        <div class="h-1/6 flex justify-center">
                            <div class="flex items-center justify-center gap-28">
                                <button class="flex flex-row bg-blue-500 rounded-lg items-center px-5 py-4">
                                    <img src="../img/like.png" alt="like" class="w-1/4">
                                    <p class="text-2xl font-bold pl-5">33</p>
                                </button>
                                <button class="flex flex-row bg-red-500 rounded-lg items-center px-5 py-4">
                                    <img src="../img/dislike.png" alt="dislike" class="w-1/4">
                                    <p class="text-2xl font-bold pl-5">5</p>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="w-2/3 h-full flex flex-col rounded-xl mx-6">

                        <iframe src="<?php echo $youtube_link; ?>" title="trailer <?php echo $filmName; ?>" frameborder="0" allowfullscreen class="rounded-xl h-5/6 w-full"></iframe>

                        <form class="flex flex-row w-6/6 h-1/6 py-4">
                            <input type="text" class="w-5/6 border rounded-xl px-2 focus:outline-none focus:ring focus:border-blue-500 mr-1" placeholder="Votre commentaire...">
                            <button type="submit" class="w-1/6 bg-blue-500 text-white rounded-xl ml-1">Envoyer</button>
                        </form>
                    </div>
                </div>
                <div class="h-1/3 overflow-y-auto mr-4 custom-scroll">

                <?php foreach ($comments as $comment): ?>
                    <div class="flex flex-col bg-gray-800 rounded-2xl px-2 py-1 my-2 mx-1">
                        <h2 class="text-white text-xl"><?php echo $comment['nickname']; ?></h2>
                        <p class="text-white"><?php echo $comment['content']; ?></p>
                    </div>
                <?php endforeach; ?>
                                      

              </div>
         </div>
    </main>

</body>

</html>