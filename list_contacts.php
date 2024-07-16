<?php
include 'functions.php'; //Inclusion du fichier contacts.php et des functions pour intéragir avec celui-ci
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
    <bg>
        <table>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Détails</th>
            </tr>
            <?php
            foreach ($contacts as $id => $contact) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($contact['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($contact['email']) . "</td>";
                echo "<td>" . htmlspecialchars($contact['telephone']) . "</td>";
                echo "<td><a href='view_contact.php?id=" . $id . "'>+</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </bg>
    <div class="button-group">
        <a href="index.html">Accueil</a>
        <a href="add_contact.php">Ajouter un contact</a>
    </div>
</body>
</html>
