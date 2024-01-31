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

// Vérifier si un ID est passé dans l'URL
if (isset($_GET['id_movie'])) {
    $id_movie = $_GET['id_movie'];

    // Exécuter une requête SQL pour récupérer les données de la ligne correspondante
    $resultat = $conn->query("SELECT * FROM movies WHERE id_movie = $id_movie");

    // Vérifier si la requête a réussi
    if (!$resultat) {
        die("Échec de la requête SQL : " . $conn->error);
    }

    // Récupérer les données de la ligne
    $donnees = $resultat->fetch_assoc();

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    // Rediriger vers la page principale si l'ID n'est pas spécifié
    header('Location: gestionFilms.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Modifier Film</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-stone-700 flex">
    <?php include "../styles/navAdmin.php"; ?>
    <section class="flex flex-row w-4/5 m-5 p-8 bg-neutral-200 rounded-md">
        <div class="flex-1 h-full max-w-md bg-white shadow-md rounded p-6">
            <h1 class="text-xl mb-2 my-8">Titre</h1>
            <form action="process_edit.php" method="post">
                <input type="hidden" name="id" value="<?php echo $donnees['id_movie']; ?>">
                
                <input class="border border-gray-300 rounded-md py-2 px-3 mb-8 w-full" type="text" name="title" value="<?php echo $donnees['title']; ?>" />
                
                <label for="description" class="block text-xl text-gray-700 mb-2">Description :</label>
                <textarea class="border border-gray-300 rounded-md px-3 mb-4 w-full h-4/6 resize-none" name="description" rows="4" placeholder="Votre description ici..."><?php echo $donnees['description']; ?></textarea>

                <!-- <input type="submit" id="save-button" class="text-3xl bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-8 rounded" value="Save"> -->
            
        </div>
        <div class="flex-1 flex flex-col">
            <div class="flex-1 h-3/5 bg-white shadow-md rounded p-6 ml-5">
                <div class="my-8">
                    <h1 class="text-xl mb-2">Image</h1>
                    <div class="flex justify-center items-center">
                        <label for="image" class="block text-xl text-gray-700 mb-2">Image URL :</label>
                        <input class="border border-gray-300 rounded-md py-2 px-3 w-full" type="text" name="image" value="<?php echo $donnees['image']; ?>" />
                    </div>
                </div>
                <div class="my-8">
                    <h1 class="text-xl mb-2">Vidéo</h1>
                    <div class="flex justify-center items-center">
                        <label for="trailer" class="block text-xl text-gray-700 mb-2">Vidéo URL :</label>
                        <input class="border border-gray-300 rounded-md py-2 px-3 w-full" type="text" name="trailer" value="<?php echo $donnees['trailer']; ?>" />
                    </div>
                </div>
                <div class="flex flex-row content-center my-8">
                    <div class="flex flex-col mr-4 w-1/2">
                        <label for="release_date" class="text-xl mb-2">Date :</label>
                        <input class="border border-gray-300 rounded-md py-2 px-3 mb-4 w-full" type="text" name="release_date" placeholder="Entrez la date" value="<?php echo $donnees['release_date']; ?>" />
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label for="categories" class="text-xl mb-2">Catégorie :</label>
                        <input class="border border-gray-300 rounded-md py-2 px-3 w-full" type="text" name="categories" placeholder="Entrez la catégorie" value="<?php echo $donnees['categories']; ?>" />
                    </div>
                </div>
            </div>
            <div class="flex flex-row items-center justify-around mt-8 pb-8">
                <button id="save-button" class="text-3xl bg-blue-500 hover:bg-blue-700 text-white font-bold py-5 px-8 rounded" name="saveBtn">
                    Save
                </button>
            </form>
                <!-- <button id="delete-button" class="text-3xl bg-red-500 hover:bg-red-700 text-white font-bold py-5 px-8 rounded" name="deleteBtn">
                    Delete
                </button> -->
                <form action="process_delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete this item?');">
                <input type="hidden" name="id" value="<?php echo $donnees['id_movie']; ?>">
                <button type="submit" class="text-3xl bg-red-500 hover:bg-red-700 text-white font-bold py-5 px-8 rounded">
                    Delete
                </button>
            </form>
            </div>
        </div>
    </section>
</body>

</html>
