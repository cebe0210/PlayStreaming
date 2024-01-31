<?php
session_start();
if (empty($_SESSION['user'])) {
    header("Location: ../index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Recherche</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
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
            <h1 class="w-full h-10vh text-white bg-gray-700 text-4xl text-center py-4">Action</h1>
            <div class="flex justify-around p-8">
                <div class="w-64 h-96 mx-5 relative overflow-hidden rounded-lg transform transition-transform hover:scale-105">
                    <a href="film.php" class="block w-full h-full bg-cover bg-center relative">
                        <div class="absolute inset-0 bg-black opacity-0 transition-opacity duration-300 hover:opacity-90 flex flex-col justify-center items-center">
                            <span class="text-white text-lg font-bold mb-2">TITRE DU FILM</span>
                            <span class="text-white text-center mx-5">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellat rem, unde ea illum, adipisci nulla cum maxime officia blanditiis rerum nesciunt? Excepturi natus asperiores recusandae nostrum magni voluptate dolorum exercitationem?</span>
                        </div>
                        <img src="../img/test-img1.jpg" alt="Image" class="w-full h-full object-cover">
                    </a>
                </div>
            </div>
        </div>
    </main>



</body>

</html>
