<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez l'ID de l'utilisateur depuis la requête POST
    $userId = $_POST['userId'];

    // Mettez à jour la base de données pour marquer l'utilisateur comme désactivé
    $updateQuery = "UPDATE users SET is_disabled = 1 WHERE id_user = $userId";
    $conn->query($updateQuery);

    // Redirigez l'utilisateur vers la page de gestion des membres après la mise à jour
    header("Location: gestionMembres.php");
    exit();
} else {
    // Réponse pour les requêtes invalides
    http_response_code(400);
    echo 'Requête invalide';
}
?>
