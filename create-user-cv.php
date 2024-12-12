<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'monsite');

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $description = $_POST['description'];

    // Gérer l'upload de la photo de profil
    $photo = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $photo_destination = "uploads/photos/" . $photo;
    move_uploaded_file($photo_tmp, $photo_destination);

    // Insertion des données dans la table 'utilisateurs'
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, adresse, email, telephone, description, photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nom, $prenom, $adresse, $email, $telephone, $description, $photo);
    
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $stmt->close();
        $conn->close();

        // Redirection vers la page du profil utilisateur
        header("Location: user-profile.php?id=" . $user_id);
        exit();
    } else {
        echo "Erreur lors de l'insertion des données : " . $stmt->error;
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Aucune donnée reçue.";
}
?>
