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

// Utilisez la connexion mysqli au lieu de PDO
$query = "SELECT * FROM users
WHERE users.is_disabled = 0";
$result = $conn->query($query);

// Vérifiez si la requête a réussi
if ($result === false) {
    die("Erreur de requête : " . $conn->error);
}

// Récupérez les utilisateurs
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
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
        <h1 class="text-center text-2xl pb-6">Gestion des Membres</h1>
        <div class="flex justify-center items-center">
            <table class="table-auto">
            <thead>
                <tr>
                    <th class="px-8 py-4 text-center">Name</th>
                    <th class="px-8 py-4 text-center">Email</th>
                    <th class="px-8 py-4 text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
                
            <?php foreach ($users as $user): ?>
    <tr class="pb-5">
        <td class="px-8 py-4 text-center"><?= $user['nickname'] ?></td>
        <td class="px-8 py-4 text-center"><?= $user['email'] ?></td>
        <td class="px-4 py-2 text-center">
            <form action="delete_user.php" method="post">
                <input type="hidden" name="userId" value="<?= $user['id_user'] ?>">
                <button type="submit" class="action-link text-white bg-red-500 rounded-lg p-2" onclick="return confirm('Êtes-vous sûr de vouloir désactiver cet utilisateur ?')">Delete</button>
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
