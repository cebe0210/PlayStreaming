<?php
include '../config.php';

session_start();
if (empty($_SESSION['user'])) {
    header("Location: ../index.php");
    die();
}

// Récupération du terme de recherche depuis le formulaire
$search_term = mysqli_real_escape_string($conn, $_GET['search_term']);

// Requête SQL pour la recherche dans la table 'movies'
$sql_movies = "SELECT * FROM movies 
               WHERE title LIKE '%$search_term%' 
                  OR description LIKE '%$search_term%' 
                  OR categories LIKE '%$search_term%'";

// Requête SQL pour la recherche dans la table 'populaire'
$sql_populaire = "SELECT * FROM populaire 
                  WHERE title_populaire LIKE '%$search_term%' 
                     OR description_populaire LIKE '%$search_term%' 
                     OR categories_populaire LIKE '%$search_term%'";

// Exécution des requêtes
$result_movies = $conn->query($sql_movies);
$result_populaire = $conn->query($sql_populaire);

// Tableau pour stocker les ID des films déjà affichés
$displayed_movies = [];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Recherche</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        ::-webkit-scrollbar {
            width: 3px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #1f1f1f;
            border-radius: 10px;
        }
    </style>
</head>

<body class="w-screen h-screen bg-gray-600 overflow-x-hidden">
    
    <?php include_once "./../styles/navBar.php"; ?>

    <main class="flex-1 flex flex-grow flex-col block">
        <div class="w-full h-1/2 flex-grow">
            <h1 class="w-full h-10vh text-white bg-gray-700 text-4xl text-center py-4">Résultats de la recherche pour "<?php echo $search_term; ?>"</h1>
            <div class="flex flex-wrap justify-center p-8">
                <?php
                if ($result_movies->num_rows > 0) {
                    foreach ($result_movies as $row) {
                        if (!in_array($row['id_movie'], $displayed_movies)) {
                            $displayed_movies[] = $row['id_movie'];
                ?>
                            <!-- Cartes de la table movies -->
                            <div class="w-64 h-96 mx-2 my-2 flex-none overflow-hidden rounded-lg transform transition-transform hover:scale-105">
                                <a href="film.php?id=<?php echo $row['id_movie']; ?>" class="block w-full h-full">
                                    <div class="absolute inset-0 bg-black opacity-0 transition-opacity duration-300 hover:opacity-90 flex flex-col justify-center items-center">
                                        <span class="text-white text-lg font-bold mb-2 px-3 text-center"><?php echo $row['title']; ?></span>
                                        <span class="text-white text-center px-3 text-center"><?php echo $row['description']; ?></span>
                                    </div>
                                    <img src="<?php echo $row['image']; ?>" alt="Image" class="w-full h-full object-cover">
                                </a>
                            </div>
                <?php
                        }
                    }
                }

                if ($result_populaire->num_rows > 0) {
                    foreach ($result_populaire as $row) {
                        if (!in_array($row['id_populaire'], $displayed_movies)) {
                            $displayed_movies[] = $row['id_populaire'];
                ?>
                            <!-- Cartes de la table populaire -->
                            <div class="w-64 h-96 mx-2 my-2 flex-none overflow-hidden rounded-lg transform transition-transform hover:scale-105">
                                <a href="filmPopulaire.php?id=<?php echo $row['id_populaire']; ?>" class="block w-full h-full">
                                    <div class="absolute inset-0 bg-black opacity-0 transition-opacity duration-300 hover:opacity-90 flex flex-col justify-center items-center">
                                        <span class="text-white text-lg font-bold mb-2 px-3 text-center"><?php echo $row['title_populaire']; ?></span>
                                        <span class="text-white text-center px-3"><?php echo $row['description_populaire']; ?></span>
                                    </div>
                                    <img src="<?php echo $row['image_populaire']; ?>" alt="Image" class="w-full h-full object-cover">
                                </a>
                            </div>
                <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </main>

</body>

</html>