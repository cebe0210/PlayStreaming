<?php
include '../config.php';

session_start();
if (empty($_SESSION['user'])) {
    header("Location: ../index.php");
    die();
}
if ($_SESSION['role'] == 'm') {
    header("Location: ../pages/menu.php");
    die();
}


$query = "SELECT comments.*, users.nickname, movies.title
          FROM comments
          INNER JOIN users ON comments.user = users.id_user
          INNER JOIN movies ON comments.movie = movies.id_movie
          WHERE comments.is_deleted = 0";

$result = $conn->query($query);

// Vérifiez si la requête a réussi
if ($result === false) {
    die("Erreur de requête : " . $conn->error);
}

// Récupérez les commentaires
$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Layout avec Tailwind CSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-stone-700 flex h-screen overflow-hidden">
    <?php include "../styles/navAdmin.php"; ?>
    <section class="w-4/5 m-5 p-8 bg-neutral-200 rounded-md overflow-auto h-95vh">
        <h1 class="text-center text-2xl pb-6">Gestion Commentaires</h1>
        <div class="flex justify-center items-center">
            <table class="table-auto">
                <thead>
                    <tr>
                        <!-- <th class="px-8 py-4 text-center">Email</th> -->
                        <th class="px-8 py-4 text-center">Author</th>
                        <th class="px-8 py-4 text-center">Date</th>
                        <th class="px-8 py-4 text-center">Movie</th>
                        <th class="px-8 py-4 text-center">Message</th>
                        <th class="px-8 py-4 text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment): ?>
                        <tr class="pb-5">
                            <!-- <td class="px-8 py-4 text-center"><?= $comment['email'] ?></td> -->
                            <td class="px-8 py-4 text-center"><?= $comment['nickname'] ?></td>
                            <td class="px-8 py-4 text-center"><?= $comment['date'] ?></td>
                            <td class="px-8 py-4 text-center"><?= $comment['title'] ?></td>
                            <td class="px-8 py-4 text-center"><?= $comment['content'] ?></td>
                            <td class="px-4 py-2 text-center">
                                <td>
                                    <form action="delete_comment.php" method="post">
                                    <?//php var_dump($comment['id_comment']); ?>
                                    <input type="hidden" name="commentId" value="<?=  $comment['id_comment'] ?>">
                                    <button type="submit" class="action-link text-white bg-red-500 rounded-lg p-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>
