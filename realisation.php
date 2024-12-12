<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'monsite');

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les réalisations de l'utilisateur
$stmt = $conn->prepare("SELECT * FROM realisations WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($realisation = $result->fetch_assoc()) {
    $image_path = '/mon_site/uploads/realisation/' . htmlspecialchars($realisation['image']);
    
    // Vérifiez si le fichier existe
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $image_path)) {
        echo "<div class='carousel-item'>";
        echo "<img src='" . $image_path . "' alt='Réalisation' style='max-width: 100%; height: auto;'>";
        echo "</div>";
    } else {
        echo "Image not found: " . $image_path; // Message d'erreur
    }
}

$stmt->close();
$conn->close();
?>
