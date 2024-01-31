<?php
include '../config.php';

// Requête pour récupérer les informations des films
$queryPopulaire = "SELECT * FROM populaire";
$resultPopulaire = $conn->query($queryPopulaire);

// Vérifier si la requête a réussi
if ($resultPopulaire === false) {
    die("Erreur de requête : " . $conn->error);
}

$moviesPopulaire = [];

// Récupérer les informations des films
while ($moviePopulaire = $resultPopulaire->fetch_assoc()) {
    $moviesPopulaire[] = $moviePopulaire;
}
?>

<div class="w-full h-1/2 flex-grow">
    <h1 class="w-full h-10vh text-white bg-gray-700 text-4xl text-center py-4">Populaire</h1>
    <div class="flex justify-around items-center p-8 relative">
        <button onclick="prevPopulaire('carouselPopulaire')" class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white px-3 py-2 rounded-l-lg focus:outline-none flex items-center">
            <img src="../img/selectorLeft.png" alt="left" class="w-1/2 h-auto transition-transform hover:scale-125 mx-auto">
        </button>
        <div class="carousel flex" id="carouselPopulaire">
            <!-- Les cartes de films seront générées ici -->
            <?php
            // Afficher les cinq premiers films populaires
            for ($i = 0; $i < min(5, count($moviesPopulaire)); $i++) {
                $moviePopulaire = $moviesPopulaire[$i];
                echo "
                <div class='w-64 h-96 mx-5 relative overflow-hidden rounded-lg transform transition-transform hover:scale-105'>
                    <a href='filmPopulaire.php?id={$moviePopulaire['id_populaire']}' class='block w-full h-full bg-cover bg-center relative'>
                        <div class='absolute inset-0 bg-black opacity-0 transition-opacity duration-300 hover:opacity-90 flex flex-col justify-center items-center'>
                            <span class='text-white text-lg font-bold mb-2'>{$moviePopulaire['title_populaire']}</span>
                            <span class='text-white text-center mx-5'>{$moviePopulaire['description_populaire']}</span>
                        </div>
                        <img src='{$moviePopulaire['image_populaire']}' alt='Image' class='w-full h-full object-cover'>
                    </a>
                </div>";
            }
            ?>
        </div>
        <button onclick="nextPopulaire('carouselPopulaire')" class="absolute right-0 top-1/2 transform -translate-y-1/2 text-white px-3 py-2 rounded-r-lg focus:outline-none flex items-center">
            <img src="../img/selectorRight.png" alt="left" class="w-1/2 h-auto transition-transform hover:scale-125 mx-auto">
        </button>
    </div>
</div>

<script>
    // Fonction pour afficher les cartes suivantes pour un carrousel spécifique
    function showNextPopulaire(carouselId) {
        const cardContainerPop = document.getElementById(carouselId);
        cardContainerPop.innerHTML = '';

        let startIndexPopular = cardContainerPop.dataset.startIndexPopular ? parseInt(cardContainerPop.dataset.startIndexPopular) : 0;
        const totalMovies = <?= count($moviesPopulaire) ?>;

        for (let i = startIndexPopular; i < startIndexPopular + 5; i++) {
            const movieIndexPop = i % totalMovies;
            const movie = <?= json_encode($moviesPopulaire) ?>[movieIndexPop];
            const cardPop = `
                <div class="w-64 h-96 mx-5 relative overflow-hidden rounded-lg transform transition-transform hover:scale-105">
                    <a href="filmPopulaire.php?id=${movie.id_populaire}" class="block w-full h-full bg-cover bg-center relative">
                        <div class="absolute inset-0 bg-black opacity-0 transition-opacity duration-300 hover:opacity-90 flex flex-col justify-center items-center">
                            <span class="text-white text-lg font-bold mb-2">${movie.title_populaire}</span>
                            <span class="text-white text-center mx-5">${movie.description_populaire}</span>
                        </div>
                        <img src="${movie.image_populaire}" alt="Image" class="w-full h-full object-cover">
                    </a>
                </div>`;
                cardContainerPop.innerHTML += cardPop;
        }

        startIndexPopular = (startIndexPopular + 5) % totalMovies; // Mettre à jour l'index de départ pour le prochain lot de films
        cardContainerPop.dataset.startIndexPopular = startIndexPopular;
    }
    // Fonction pour afficher les cartes précédentes pour un carrousel spécifique
    function showPrevPopulaire(carouselId) {
        const cardContainerPop = document.getElementById(carouselId);
        let startIndexPopular = cardContainerPop.dataset.startIndexPopular ? parseInt(cardContainerPop.dataset.startIndexPopular) : 0;
        startIndexPopular -= 10;
        if (startIndexPopular < 0) {
            startIndexPopular = 0;
        }
        cardContainerPop.dataset.startIndexPopular = startIndexPopular;
        showNextPopulaire(carouselId);
    }
    // Fonctions pour les boutons Précédent et Suivant
    function nextPopulaire(carouselId) {
        showNextPopulaire(carouselId);
    }
    function prevPopulaire(carouselId) {
        showPrevPopulaire(carouselId);
    }
</script>
