<?php
include 'contacts.php';

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
    <title>Détail du contact</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Détail du contact</h1>
    <p><strong>Nom:</strong> <?php echo htmlspecialchars($contact['nom']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
    <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($contact['telephone']); ?></p>
    <p><a href="list_contacts.php">Retour à la liste</a></p>
</body>
</html>
