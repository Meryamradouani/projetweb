<?php
// Inclure le fichier de configuration pour la connexion à la base de données
include('connexion.php');

// Vérifier si le formulaire pour créer un nouvel événement est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $lieu = $_POST['lieu'];
    $createur = $_POST['createur'];

    // Insérer les données dans la table evenements
    $query = "INSERT INTO evenements (titre, description, date, lieu, categorie, createur) 
              VALUES ('$titre', '$description', '$date', '$lieu', '$categorie', '$createur')";
    $result = mysqli_query($conn, $query);

    // Vérifier les erreurs de la requête
    if (!$result) {
        die("Erreur de la requête : " . mysqli_error($conn));
    }
}

// Récupérer la liste des événements depuis la base de données
$query = "SELECT * FROM evenements";
$result = mysqli_query($conn, $query);

// Vérifier les erreurs de la requête
if (!$result) {
    die("Erreur de la requête : " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Gestion des événements</title>
</head>
<body>
    <h1>Gestion des événements</h1>

    <!-- Formulaire pour créer de nouveaux événements -->
    <form action="admin.php" method="post">
        <label for="titre">Titre :</label>
        <input type="text" name="titre" required>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea>

        <label for="date">Date :</label>
        <input type="date" name="date" required>

        <label for="lieu">Lieu :</label>
        <input type="text" name="lieu" required>

        <label for="categorie">Catégorie :</label>
        <input type="text" name="categorie" required>

        <label for="createur">Créateur :</label>
        <input type="text" name="createur" required>

        <button type="submit">Créer un événement</button>
    </form>

    <!-- Liste des événements existants avec des liens pour les éditer ou les supprimer -->
    <h2>Liste des événements existants</h2>
    <ul>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>";
            echo "{$row['titre']} ({$row['date']}) - <a href='edit_event.php?id={$row['id']}'>Éditer</a> | <a href='delete_event.php?id={$row['id']}'>Supprimer</a>";
            echo "</li>";
        }
        ?>
    </ul>

    <?php
    // Libérer le résultat de la requête
    mysqli_free_result($result);

    // Fermer la connexion à la base de données
    mysqli_close($conn);
    ?>
</body>
</html>
