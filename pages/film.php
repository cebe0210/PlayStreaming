<?php
include '../config.php';

// Démarrer la session une seule fois
session_start();

if (empty($_SESSION['user'])) {
    header("Location: ../index.php");
    die();
}

// Récupérer l'identifiant du film depuis l'URL
$film_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Requête pour récupérer les informations du film
$query = "SELECT * FROM movies WHERE id_movie = $film_id";
$result = $conn->query($query);

// Vérifier si la requête a réussi
if ($result === false) {
    die("Erreur de requête : " . $conn->error);
}

// Récupérer les informations du film
$film = $result->fetch_assoc();

// Requête pour récupérer les commentaires
$commentQuery = "SELECT * FROM comments WHERE movie = $film_id";
$commentResult = $conn->query($commentQuery);

// Vérifier si la requête a réussi
if ($commentResult === false) {
    die("Erreur de requête : " . $conn->error);
}

$comments = [];

while ($comment = $commentResult->fetch_assoc()) {
    // Requête pour récupérer le nickname de l'utilisateur
    $commentUserId = $comment['user'];
    $userQuery = "SELECT nickname FROM users WHERE id_user = $commentUserId";
    $userResult = $conn->query($userQuery);

    if ($userResult) {
        $userRow = $userResult->fetch_assoc();
        $nickname = $userRow['nickname'];
        $comment['nickname'] = $nickname; // Ajouter le nickname au tableau de commentaire
    }

    $comments[] = $comment;
}

// Récupérer le nickname de la session
$nickname = isset($_SESSION['nickname']) ? $_SESSION['nickname'] : '';

// Assurez-vous que le nickname est défini
if (!empty($nickname)) {
    // Échapper le nickname pour éviter les injections SQL
    $escapedNickname = $conn->real_escape_string($nickname);

    // Requête pour récupérer l'ID de l'utilisateur en fonction du nickname
    $userQuery = "SELECT id_user FROM users WHERE nickname = '$escapedNickname'";

    // Exécutez la requête
    $userResult = $conn->query($userQuery);

    // Vérifiez si la requête s'est bien déroulée
    if ($userResult === false) {
        die("Erreur de requête pour récupérer l'ID de l'utilisateur : " . $conn->error);
    }

    // Récupérez l'ID de l'utilisateur à partir du résultat de la requête
    $userRow = $userResult->fetch_assoc();
    $user_id = $userRow['id_user'];

    // Libérez les résultats de la requête
    $userResult->free();

    // Ajout de commentaire
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $comment_content = isset($_POST['comment_content']) ? htmlspecialchars($_POST['comment_content']) : '';

        if (!empty($comment_content)) {
            // Requête pour insérer le commentaire dans la base de données
            $insert_comment_query = "INSERT INTO comments (user, movie, content) VALUES ('$user_id', '$film_id', '$comment_content')";
            $insert_result = $conn->query($insert_comment_query);

            if ($insert_result === false) {
                die("Erreur lors de l'ajout du commentaire : " . $conn->error);
            } else {
                // Commentaire ajouté avec succès, rediriger avec un message de succès
                $_SESSION['success_message'] = "Le commentaire a été ajouté avec succès.";
                header("Location: $_SERVER[REQUEST_URI]");
                exit();
            }
        }
    }
} else {
    // Gérez le cas où le nickname n'est pas défini dans la session
    echo "Nickname non défini dans la session.";
}


// Fermer la connexion à la base de données
$conn->close();

function formatDuration($durationMinutes) {
    $hours = floor($durationMinutes / 60);
    $minutes = $durationMinutes % 60;

    return $hours . 'h' . sprintf('%02d', $minutes);
}
?>


<!DOCTYPE html>
<html lang="fr">
<!-- refresh page pour afficher le nouveau commentaire -->

<head>
    <meta charset="UTF-8">
    <title>Film</title>
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

            <img src="<?php echo $film['image']; ?>" alt="affiche <?php echo $film['title']; ?>" class="object-cover w-full h-5/10 rounded-3xl p-3">

        </div>
        <div class="w-1/4 h-full flex flex-row relative py-3 flex-shrink-0">
            <div class="flex w-full h-full items-center">
                <div class="w-full h-full rounded-2xl">
                    <div class="h-full bg-gray-800 rounded-2xl flex flex-col items-center justify-center px-6">
                        <h2 class="w-full h-1/4 flex items-center justify-center text-white text-3xl font-bold text-center"> <?php echo $film['title']; ?> </h2>
                        <div class="flex w-full h-1/2 flex-col justify-center">
                            <div class="w-full h-1/2 overflow-y-auto">
                                <p class="text-white mx-3"><?php echo $film['description']; ?></p>
                            </div>
                            <div class="py-3">
                                <p class="text-white font-bold mx-3 my-2 py-2 pl-1 border-b border-gray-600">Date de sortie: <?php echo $film['release_date']; ?></p>
                                <p class="text-white font-bold mx-3 my-2 py-2 pl-1 border-b border-gray-600">Genres: <?php echo $film['categories']; ?></p>
                                <p class="text-white font-bold mx-3 my-2 py-2 pl-1 border-b border-gray-600">Durée: <?php echo formatDuration($film['duration']); ?></p>
                            </div>
                        </div>
                        <div class="w-1/2 h-1/4 flex justify-center py-3">
                            <div class="flex items-center justify-center gap-28">
                                <button class="flex flex-row items-center justify-center bg-gray-800 border-white border-2 rounded-lg py-3 px-6 hover:scale-110 hover:bg-gray-600">
                                    <img src="../img/like.png" alt="like"> <!-- Ajustement de la largeur de l'image -->
                                    <p class="text-xl text-white font-bold ml-2">33</p> <!-- Ajout d'une marge à gauche pour l'espacement -->
                                </button>
                                <button class="flex flex-row items-center justify-center bg-gray-800 border-white border-2 rounded-lg py-3 px-6 hover:scale-110 hover:bg-gray-600">
                                    <img src="../img/dislike.png" alt="like"> <!-- Ajustement de la largeur de l'image -->
                                    <p class="text-xl text-white font-bold ml-2">11</p> <!-- Ajout d'une marge à gauche pour l'espacement -->
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-1/2 h-4/4 p-3">
            <div class="w-full h-2/3 flex flex-col rounded-xl">
                <iframe src="<?php echo $film['trailer']; ?>" title="trailer <?php echo $film['title']; ?>" frameborder="0" allowfullscreen class="rounded-xl h-5/6 w-full"></iframe>

                <form class="flex flex-row h-1/6 items-center w-full" method="post">
                    <input type="text" name="comment_content" class="w-5/6 border rounded-xl px-2 focus:outline-none focus:ring focus:border-blue-500 mr-1 py-2" placeholder="Votre commentaire..." required>
                    <button type="submit" class="w-1/6 bg-blue-500 text-white rounded-xl ml-1 py-2">Envoyer</button>
                </form>
            </div>
            <div class="w-full h-1/3 custom-scroll overflow-y-auto">
                <div id="successMessage" class="success-message">
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        echo '<div class="bg-blue-500 rounded-lg text-white font-bold pl-3">' . $_SESSION['success_message'] . '</div>';
                        unset($_SESSION['success_message']); 
                    }
                    ?>
                </div>

                <?php foreach ($comments as $comment): ?>
                    <div class="flex flex-col bg-gray-800 rounded-2xl my-2 pl-3 py-1">
                    <h2 class="text-white text-lg font-bold">
                        <?php echo $comment['nickname']; ?> : 
                        <span class="text-white text-sm">
                            <?php echo date('Y-m-d H:i', strtotime($comment['date'])); ?>
                        </span>
                    </h2>
                        <p class="text-white text-sm"><?php echo $comment['content']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <script>
        // Sélectionnez l'élément du message de succès
        var successMessage = document.getElementById('successMessage');

        // Masquez ou supprimez le message après 5 secondes (5000 millisecondes)
        if (successMessage) {
            setTimeout(function () {
                successMessage.style.display = 'none'; // Masquer le message
            }, 3000);
        }
    </script>
</body>

</html>