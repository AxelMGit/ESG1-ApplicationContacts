<?php
include 'contacts.php'; // Inclusion du fichier contacts.php

if (isset($_GET['id']) && array_key_exists($_GET['id'], $contacts)) {
    $id = intval($_GET['id']);
    $contact = $contacts[$id];
} else {
    echo "Aucun contact trouvé.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Détails du contact</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Détails du contact</h1>
    <p><strong>Nom:</strong> <?php echo filter_var($contact['nom'], FILTER_SANITIZE_SPECIAL_CHARS); ?></p>
    <p><strong>Email:</strong> <?php echo filter_var($contact['email'], FILTER_SANITIZE_SPECIAL_CHARS); ?></p>
    <p><strong>Téléphone:</strong> <?php echo filter_var($contact['telephone'], FILTER_SANITIZE_SPECIAL_CHARS); ?></p>
    <p><a href="list_contacts.php">Retour à la liste</a></p>
</body>
</html>
