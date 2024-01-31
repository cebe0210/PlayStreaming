<header class="h-10vh flex flex-row items-center p-4 bg-gray-800">
    <!-- Left side with photo and name -->
    <div class="flex items-center">
        <a href="auth.php?action=login" class="ml-2 text-white text-lg font-bold">Se Connecter</a>
    </div>

    <!-- Center with logo -->
    <div class="flex items-center justify-center flex-1"> <!-- Utilisation de justify-center pour centrer horizontalement -->
        <div class="flex items-center justify-center h-full">
            <img src="../img/logo.png" alt="Logo" class="w-10">
        </div>
    </div>

    <!-- Right side with search bar -->
    <div class="flex items-center">
        <input type="text" placeholder="Search..." class="px-2 py-1 rounded border border-gray-300 focus:outline-none focus:ring focus:border-blue-500">
        <button class="ml-2 px-3 py-1 bg-blue-500 text-white rounded">Search</button>
    </div>
</header>
