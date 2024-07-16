<?php
include 'functions.php';
$contacts = getContacts();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des contacts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Liste des contacts</h1>
    </header>
    <main>
        <table>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Détail</th>
            </tr>
            <?php
            foreach ($contacts as $id => $contact) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($contact['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($contact['email']) . "</td>";
                echo "<td>" . htmlspecialchars($contact['telephone']) . "</td>";
                echo "<td><a href='view_contact.php?id=" . $id . "'>Voir Détail</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </main>
    <div class="button-group">
        <a href="index.html">Accueil</a>
        <a href="add_contact.php">Ajouter un contact</a>
    </div>
</body>
</html>
