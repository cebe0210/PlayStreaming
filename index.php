<?php
include 'config.php';

// Requête pour récupérer 10 films aléatoires
$randomMoviesQuery = "SELECT * FROM movies ORDER BY RAND() LIMIT 10";
$randomMoviesResult = $conn->query($randomMoviesQuery);

// Vérifier si la requête a réussi
if ($randomMoviesResult === false) {
    die("Erreur de requête pour les films aléatoires : " . $conn->error);
}

// Récupérer les films aléatoires
$randomMovies = $randomMoviesResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Welcome To Play</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
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
    <div class="fixed top-0 left-0 w-full h-full flex justify-center items-center bg-black bg-opacity-50 hidden z-50" id="overlay">
        <div class="bg-gray-700 p-6 rounded max-w-md relative transform transition-transform hover:scale-110" style="pointer-events: auto;">
            <h2 class="text-white text-2xl font-bold mb-4 text-center" id="popupTitle">Se connecter ?</h2>
            <p class="text-white text-xl my-8 text-center mx-6" id="popupDescription">Profiter de tout notre catalogue en vous connectant juste ici.</p>
            <div class="flex justify-around">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded hover:scale-110" id="popupButton1"><a href="auth.php?action=login">Se connecter</a></button>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-4 px-8 rounded hover:scale-110" id="popupButton2"><a href="index.php">Quitter</a></button>
            </div>
        </div>
    </div>
    <?php include "styles/navAno.php"; ?>
    <main class="flex-1 flex flex-grow flex-col block">
        <div class="w-full h-1/2 flex-grow">
            <div class="flex flex-wrap justify-center p-8">
                <?php foreach ($randomMovies as $movie): ?>
                    <div class="w-64 h-96 mx-5 my-5 relative overflow-hidden rounded-lg transform transition-transform hover:scale-105">
                        <a href="film.php?id=<?php echo $movie['id_movie']; ?>" class="popupLink block w-full h-full bg-cover bg-center relative">
                            <div class="absolute inset-0 bg-black opacity-0 transition-opacity duration-300 hover:opacity-90 flex flex-col justify-center items-center">
                                <span class="text-white text-lg font-bold mb-2"><?php echo $movie['title']; ?></span>
                                <span class="text-white text-center mx-5"><?php echo $movie['description']; ?></span>
                            </div>
                            <img src="<?php echo $movie['image']; ?>" alt="<?php echo $movie['title']; ?>" class="w-full h-full object-cover">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <script>
        const links = document.querySelectorAll('.popupLink');
        const overlay = document.getElementById('overlay');

        function openPopup(event) {
            event.preventDefault();
            overlay.classList.remove('hidden');
        }

        function closePopup() {
            overlay.classList.add('hidden');
        }

        links.forEach(link => {
            link.addEventListener('click', openPopup);
        });

        const disconnectButtons = document.querySelectorAll('.popupButton2');

        disconnectButtons.forEach(button => {
            button.addEventListener('click', closePopup);
        });
    </script>


</body>

</html>