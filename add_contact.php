<?php
include 'functions.php';

$nomErr = $emailErr = $telephoneErr = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nom"])) {
        $nomErr = "Le nom est requis";
    } else {
        $nom = $_POST["nom"];
    }

    if (empty($_POST["email"])) {
        $emailErr = "L'email est requis";
    } else {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format d'email invalide";
        }
    }

    if (empty($_POST["telephone"])) {
        $telephoneErr = "Le téléphone est requis";
    } else {
        $telephone = $_POST["telephone"];
        if (!preg_match("/^[0-9]{10}$/", $telephone)) {
            $telephoneErr = "Format de téléphone invalide. Exemple : 0616970682";
        }
    }

    if (empty($nomErr) && empty($emailErr) && empty($telephoneErr)) {
        $newContact = ['nom' => $nom, 'email' => $email, 'telephone' => $telephone];

        $contacts = getContacts();

        $nextId = max(array_keys($contacts)) + 1;

        $contacts[$nextId] = $newContact;

        saveContacts($contacts);

        $successMessage = "Le contact a été ajouté avec succès.";

        $nom = $email = $telephone = "";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ajouter un contact</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error {
            color: red;
            font-weight: bold;
        }
        .success {
            color: green;
            font-weight: bold;

        }
    </style>
</head>
<body>
    <header>
        <h1>Ajouter un contact</h1><br>
        <a href="list_contacts.php">Retour à la liste des contacts</a>
    </header>
    <main>
        <?php
        if (!empty($nomErr) || !empty($emailErr) || !empty($telephoneErr)) {
            echo "<div class='error'>";
            echo "<p>Veuillez corriger les erreurs suivantes :</p>";
            echo "<ul>";
            if (!empty($nomErr)) {
                echo "<li>$nomErr</li>";
            }
            if (!empty($emailErr)) {
                echo "<li>$emailErr</li>";
            }
            if (!empty($telephoneErr)) {
                echo "<li>$telephoneErr</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
        ?>

        <form method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo isset($nom) ? htmlspecialchars($nom) : ''; ?>" required><br><br>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required><br><br>
            <label for="telephone">Téléphone :</label>
            <input type="tel" id="telephone" name="telephone" value="<?php echo isset($telephone) ? htmlspecialchars($telephone) : ''; ?>" required><br><br>
            <input type="submit" value="Ajouter le contact">
        </form>
        <br><br>

        <?php
        if (!empty($successMessage)) {
            echo "<div class='success'>$successMessage</div>";
        }
        ?>

    </main>
    <script src="index.js"></script>
</body>
</html>
