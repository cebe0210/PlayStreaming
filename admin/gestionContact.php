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
$query = "SELECT * FROM contact
WHERE contact.archive = 1";
$result = $conn->query($query);


// Vérifiez si la requête a réussi
if ($result === false) {
    die("Erreur de requête : " . $conn->error);
}

// Récupérez les contacts
$contacts = [];
while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
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
        <h1 class="text-center text-2xl pb-6">Contact</h1>
        <div class="flex justify-center items-center">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th class="px-8 py-4 text-center">Name</th>
                        <th class="px-8 py-4 text-center">Email</th>
                        <th class="px-8 py-4 text-center">Message</th>
                        <th class="px-8 py-4 text-center">Topic</th>
                        <th class="px-8 py-4 text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($contacts as $cont): ?>
                    <tr class="pb-5">
                        <td class="px-8 py-4 text-center"><?= $cont['name'] ?></td>
                        <td class="px-8 py-4 text-center"><?= $cont['email'] ?></td>
                        <td class="px-8 py-4 text-center"><?= $cont['message'] ?></td>
                        <td class="px-8 py-4 text-center"><?= $cont['topic'] ?></td>
                        <td class="px-4 py-2 text-center">
                            <form action="delete_contact.php" method="post">
                                <input type="hidden" name="contactId" value="<?= $cont['id_contact'] ?>">
                                <button type="submit" class="action-link text-white bg-red-500 rounded-lg p-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">Archiver</button>
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
