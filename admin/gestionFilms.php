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

// Exécuter une requête SQL
$resultat = $conn->query("SELECT * FROM movies");

// Vérifier si la requête a réussi
if (!$resultat) {
    die("Échec de la requête SQL : " . $conn->error);
}
$conn->close();
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
        <h1 class="text-center text-2xl pb-6">Gestion des Films</h1>
        <div class="flex justify-center items-center">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th class="px-8 py-4 text-center">Name</th>
                        <th class="px-8 py-4 text-center">Description</th>
                        <th class="px-8 py-4 text-center">Release</th>
                        <th class="px-8 py-4 text-center">Category</th>
                        <th class="px-8 py-4 text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    while ($ligne = $resultat->fetch_assoc()) {
                        echo '<tr class="pb-5">';
                        echo '<td class="px-8 py-4 text-center">' . $ligne['title'] . '</td>';
                        echo '<td class="px-8 py-4 text-center">' . $ligne['description'] . '</td>';
                        echo '<td class="px-8 py-4 text-center">' . $ligne['release_date'] . '</td>';
                        
                        // Afficher les catégories sous forme d'array
                        $categoriesArray = explode(', ', $ligne['categories']);
                        $categoriesString = implode('<br>', $categoriesArray);
                        echo '<td class="px-8 py-4 text-center">' . $categoriesString . '</td>';
                        
                        echo '<td class="px-4 py-2 text-center"><a href="editerFilms.php?id_movie=' . $ligne['id_movie'] . '" class="action-link text-white bg-orange-600 rounded-lg p-2">Edit</a></td>';

                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>
