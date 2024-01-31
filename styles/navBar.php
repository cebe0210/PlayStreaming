
<header class="h-10vh flex items-center justify-between p-4 bg-gray-800">
    <!-- Left side with photo and name -->
    <div class="flex items-center w-1/4">
        <img src="../img/test-img2.jpg" alt="img" class="w-12 h-12 object-cover rounded-full">
        <div class="dropdown ml-2 relative inline-block">
            <div class="w-48 px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-200 bg-gray-700 cursor-pointer" id="dropdownMenu">
                <?php echo $_SESSION['nickname']?> <!-- Le nom de l'utilisateur affiché -->
            </div>
            <ul class="hidden absolute left-0 mt-2 w-48 py-2 bg-white border border-gray-300 rounded-lg shadow-md" id="dropdownOptions">
                <li><a href="../pages/profileUser.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Edition de profil</a></li>
                <li><a href="../auth.php?action=disconnect" class="block px-4 py-2 text-gray-800 hover:bg-gray-200" id="disconnectLink">Déconnexion</a></li>
            </ul>
        </div>
    </div>




    <!-- Center with logo -->
    <div class="flex items-center justify-center flex-1 group w-1/2">
        <a href="menu.php"><img src="../img/home.png" alt="home" class="hidden group-hover:block hover:scale-110 w-12 h-12 object-cover rounded-full mx-1"></a>
        <div class="hidden group-hover:block w-px h-10 bg-gray-600"></div>
        <a href="#" id="centralLogo"><img src="../img/logo.png" alt="Logo" class="w-12 mx-1 hover:scale-110"></a>
    </div>

    <!-- Right side with search bar -->
    <div class="flex justify-end items-center w-1/4">
        <form action="search_results.php" method="GET">
            <input type="text" name="search_term" placeholder="Search..." class="px-2 py-1 rounded border border-gray-300 focus:outline-none focus:ring focus:border-blue-500">
            <button class="ml-2 px-3 py-1 bg-blue-500 text-white rounded">Search</button>
        </form>
    </div>
    <div id="categoriesDiv" class="hidden absolute top-20 left-0 w-full h-1/3 bg-gray-800 px-0 m-0 z-50">
        <div class="flex flex-wrap justify-center items-center h-full">
            <div class="w-1/3 text-center px-2 py-3 m-0 text-white hover:bg-gray-300 hover:text-gray-800"><a href="search_results.php?search_term=Action">Action</a></div>
            <div class="w-1/3 text-center px-2 py-3 m-0 text-white hover:bg-gray-300 hover:text-gray-800"><a href="search_results.php?search_term=Comedy">Comedy</a></div>
            <div class="w-1/3 text-center px-2 py-3 m-0 text-white hover:bg-gray-300 hover:text-gray-800"><a href="search_results.php?search_term=Adventure">Adventure</a></div>
            <div class="w-1/3 text-center px-2 py-3 m-0 text-white hover:bg-gray-300 hover:text-gray-800"><a href="search_results.php?search_term=Drama">Drama</a></div>
            <div class="w-1/3 text-center px-2 py-3 m-0 text-white hover:bg-gray-300 hover:text-gray-800"><a href="search_results.php?search_term=Science%20Fiction">Science Fiction</a></div>
            <div class="w-1/3 text-center px-2 py-3 m-0 text-white hover:bg-gray-300 hover:text-gray-800"><a href="search_results.php?search_term=Thriller">Thriller</a></div>
            <div class="w-1/3 text-center px-2 py-3 m-0 text-white hover:bg-gray-300 hover:text-gray-800"><a href="search_results.php?search_term=Horror">Horror</a></div>
            <div class="w-1/3 text-center px-2 py-3 m-0 text-white hover:bg-gray-300 hover:text-gray-800"><a href="search_results.php?search_term=Fantasy">Fantasy</a></div>
            <div class="w-1/3 text-center px-2 py-3 m-0 text-white hover:bg-gray-300 hover:text-gray-800"><a href="search_results.php?search_term=Animation">Animation</a></div>
        </div>
    </div>

</header>

<!-- Popup div -->

    <div class="fixed top-0 left-0 w-full h-full flex justify-center items-center bg-black bg-opacity-50 hidden z-50" id="popup">
        <div class="bg-gray-700 p-6 rounded max-w-md relative transform transition-transform hover:scale-110" style="pointer-events: auto;">
            <p class="text-white text-xl my-8 text-center mx-6" id="popupDescription">Voulez vous vous déconnecter ?</p>
            <div class="flex justify-around">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-8 mr-2 rounded hover:scale-110" id="confirmDisconnect">Quitter</button>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-4 px-8 rounded hover:scale-110" id="cancelDisconnect">Annuler</button>
            </div>
        </div>
    </div>

<script>

    // Écouter le clic sur le bouton de la liste déroulante
    const dropdownMenu = document.getElementById('dropdownMenu');
    const dropdownOptions = document.getElementById('dropdownOptions');
    const disconnectLink = document.getElementById('disconnectLink');
        // Cibler le logo central et le div des catégories
    const centralLogo = document.getElementById('centralLogo');
    const categoriesDiv = document.getElementById('categoriesDiv');

    // Ajouter un écouteur d'événements pour le clic sur le logo central
    centralLogo.addEventListener('click', function () {
        categoriesDiv.classList.toggle('hidden');
    });

    dropdownMenu.addEventListener('click', function () {
        dropdownOptions.classList.toggle('hidden');
    });

    // Afficher la popup au clic sur "Déconnexion"
    disconnectLink.addEventListener('click', function (event) {
        event.preventDefault(); // Empêche le lien de se comporter par défaut (navigation)
        document.getElementById('popup').classList.remove('hidden');
    });

    // Masquer la popup au clic sur "Annuler"
    document.getElementById('cancelDisconnect').addEventListener('click', function () {
        document.getElementById('popup').classList.add('hidden');
    });
    document.getElementById('confirmDisconnect').addEventListener('click', function () {
        window.location.href = '../auth.php?action=disconnect';
    });
</script>
