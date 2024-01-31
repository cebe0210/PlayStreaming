<?php session_start();
if (empty($_SESSION['user'])) {
    header("Location: ../index.php");
    die();
}
if ($_SESSION['role'] == 'm') {
    header("Location: ../pages/menu.php");
    die();
}
include '../config.php';

// Fonction pour récupérer le nombre de lignes d'une table
function getRowCount($conn, $tableName) {
    $query = "SELECT COUNT(*) as total_rows FROM $tableName";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total_rows'];
    } else {
        return -1; // En cas d'erreur
    }
}

// Récupération du nombre de lignes pour chaque table
$membres = getRowCount($conn, "users");
$movies = getRowCount($conn, "movies");
$populaire = getRowCount($conn, "populaire");
$commentaires = getRowCount($conn, "comments");
$contact = getRowCount($conn, "contact");
$film = $movies + $populaire;


// Fermeture de la connexion
$conn->close();
?>
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Layout avec Tailwind CSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-stone-700 ">
    <div class="flex">
          <!-- Insertion de la navbar -->
        <?php include "../styles/navAdmin.php"; ?>
        <section class="w-4/5 m-5 p-8 bg-neutral-200 rounded-md flex-grow">
        <h1 class="text-black text-center text-2xl pt-4">Administration</h1>
            <div class="grid grid-cols-2 grid-rows-2 gap-4 wrap-2 m-8 ps-8 pt-10 content-center">
                <div class=" p-6 m-6 h-[12rem] w-[75%] rounded-md bg-red-400 hover:bg-rose-600 cursor-pointer"> <!-- 3 times the default height (3rem) -->
                    <h3 class="text-xl">Membres</h3>
                    <output class=" text-7xl text-center block "><?php echo $membres; ?></output>
                </div>
                <div class=" p-6 m-6 h-[12rem] w-[75%] rounded-md bg-yellow-300 hover:bg-yellow-500 cursor-pointer"> <!-- 3 times the default height (3rem) -->
                    <h3 class="text-xl">Films</h3>
                    <output class=" text-7xl text-center block rounded-sm"><?php echo $film; ?></output>
                </div>
                <div class=" p-6 m-6 h-[12rem] w-[75%] rounded-md bg-cyan-400 hover:bg-cyan-600 cursor-pointer"> <!-- 3 times the default height (3rem) -->
                    <h3 class="text-xl">Commentaires</h3>
                    <output class=" text-7xl text-center block rounded-sm"><?php echo $commentaires; ?></output>
                </div>
                <div class=" p-6 m-6 h-[12rem] w-[75%] rounded-md bg-green-400 hover:bg-green-600 cursor-pointer"> <!-- 3 times the default height (3rem) -->
                    <h3 class="text-xl">Contact</h3>
                    <output class=" text-7xl text-center block rounded-sm"><?php echo $contact; ?></output>
                </div>
        </section>
    </div>
</body>

</html>
