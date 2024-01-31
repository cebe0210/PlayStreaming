<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez l'ID du commentaire depuis la requête POST
    $commentId = $_POST['commentId'];

    // Mettez à jour la base de données pour marquer le commentaire comme supprimé
    $updateQuery = "UPDATE comments SET is_deleted = 1 WHERE id_comment = $commentId";
    $conn->query($updateQuery);

    // Redirigez l'utilisateur vers la page des commentaires après la mise à jour
    header("Location: gestionCommentaires.php");
    exit();
} else {
    // Réponse pour les requêtes invalides
    http_response_code(400);
    echo 'Requête invalide';
}
?>