<section id="diplome" class="section">
    <div class="section-header" onclick="toggleSection('diplome-content')">Diplôme</div>
    <div id="diplome-content" class="section-content">
        <h3>Diplômes</h3>
        <?php
        // Connexion à la base de données
        $conn = new mysqli('localhost', 'root', '', 'monsite');

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }

        // Récupérer les diplômes de l'utilisateur
        $stmt = $conn->prepare("SELECT * FROM diplomes WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($diplome = $result->fetch_assoc()) {
            $file_extension = pathinfo($diplome['file'], PATHINFO_EXTENSION);
            if (in_array($file_extension, ['jpg', 'jpeg', 'png'])) {
                echo "<img src='mon_site/uploads/diplomes/" . htmlspecialchars($diplome['file']) . "' alt='Diplôme' style='max-width: 100%; height: auto;'>";
            } elseif ($file_extension == 'pdf') {
                echo "<a href='mon_site/uploads/diplomes/" . htmlspecialchars($diplome['file']) . "' target='_blank'>Voir le diplôme PDF</a>";
            }
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</section>

