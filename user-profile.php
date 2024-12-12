<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérification de la présence de l'ID utilisateur
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
} else {
    die("ID utilisateur non spécifié.");
}

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'monsite');

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les informations de l'utilisateur
$stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("Utilisateur non trouvé.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CV de <?php echo htmlspecialchars($user['prenom']) . ' ' . htmlspecialchars($user['nom']); ?></title>
    <style>
        *{
            margin:0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #2c3e50; 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            margin: 0; 
            padding: 0;
        }

        main{
            padding: 20px;
            overflow-y:auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            height: 20vh;
            margin: 0;
            padding: 20px;
            background-color: #2c3e50; /* Bleu Marine */
            color: #fff;
            position: relative;
        }

        header img {
            border-radius: 50%;
            width: 150px;
            height: auto;
        }

        .contact-info {
            text-align: left;
            font-size: 1em;
        }

        .contact-info p {
            margin: 0;
        }

        .title {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 20px;
            text-align: center;
        }

        .title h1 {
            margin: 0;
            font-size: 1.5em;
        }

        nav {
            position: sticky;
            top: 0;
            height: 50px;
            z-index: 1000;
            display: flex;
            justify-content: center; /* Centre les onglets */
            align-items: center; /* Aligne verticalement les onglets */
            background-color: #d3d3d3; /* Gris Clair */
            padding: 10px;
            width: 100%;
            text-align: center; /* Centre le texte */
        }

        nav a {
            color: #2c3e50;
            text-decoration: none;
            margin: 0 20px; /* Espace entre les onglets */
            font-size: 1em;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            margin-top: 0;
        }

        .section { 
            margin: 0;
            padding: 10px; 
            border: 2px solid #fff; 
            border-radius: 10px; 
            background-color: #2c3e50;
        }

        .section-header {
            background-color: #2c3e50; 
            color: #fff; 
            padding: 10px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
        }

        .section + .section { 
            margin-top: -2px;
        }

        /* Styles pour .section-content */
        .section-content { 
            background-color: #fff; 
            overflow-y: auto;
            max-height: 0;
            transition: max-height 0.5s ease-out; 
            padding: 10px; 
            display: none; 
        }

        /* Styles supplémentaires lorsque .section-content a la classe .open */
        .section-content.open { 
            max-height: 1000px; 
            display: block;
        }

        /* Styles pour les balises h3 à l'intérieur de .section-content */
        .section-content h3 { 
            margin: 0; 
            padding: 10px 0;
            color: #2c3e50;
            font-weight: bold;
        }

        /* Styles pour les paragraphes à l'intérieur de .section-content */
        .section-content p { 
            margin: 10px 0;
            color: #2c3e50;
        }

        /* Styles du carrousel */
        .carousel {
            overflow: hidden;
            width: 100%;
            height: 200px;
            margin: 3px;
            padding: 0;
            position: relative;
        }

        .carousel-track {
            display: flex;
            width: calc(300px * 24);
            animation: scroll 240s linear infinite;
            margin: 0;
            padding: 0;
        }

        .carousel img {
            flex-shrink: 0;
            width: 300px;
            height: 200px;
            object-fit: cover;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-7200px);
            }
        }

        h1 {
            margin: 0;
        }

        .content {
            padding-top: 0;
            margin-top: 0;
        }

        section {
            padding: 0;
            margin: 0;
            background-color: #fff;
            border-radius: 0;
            transition: background-color 0.3s ease-in-out;
        }

        .anchor {
            display: block;
            height: 120px;
            margin-top: -120px;
            visibility: hidden;
        }

        #experience-section,
        #education-section,
        #skills-section,
        #certificates-section,
        #projects-section {
            margin: 0;
            padding: 20px;
            width: 100%;
            background-color: #fff;
            border: 2px solid #2c3e50; 
            padding-left: 15px; 
            border-radius: 10px; 
            background-color: #f7f9fc; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #experience-section h2,
        #education-section h2,
        #skills-section h2,
        #certificates-section h2,
        #projects-section h2 {
            color: #2c3e50; /* Couleur du titre */ 
            font-family: 'Georgia', serif; /* Police élégante */ 
            font-size: 1.8em; /* Taille de police augmentée */ 
            border-bottom: 2px solid #2c3e50; /* Ligne en dessous du titre */ 
            padding-bottom: 5px; 
            margin-bottom: 15px;
        }

        .job,
        .education-item {
            margin-bottom: 15px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            background: #e2e2e2;
            margin-bottom: 5px;
            padding: 10px;
            border-radius: 3px;
        }

        .certificate {
            margin-top: 10px;
        }

        .certificate img {
            width: 150px;
            height: auto;
            display: block;
            margin: 5px 0;
        }

        P {
            line-height: 1.0;
            margin-top: 10px; 
            margin-bottom: 10px; 
        }

        h3 { 
            margin: 0 0 50px 0; 
            padding: 10px;
            border: none;
            width: auto; 
            text-align: left; 
            border-radius: 5px;
            font-weight: bold;
            color: #003366;
        }

    </style>
</head>
<body>
    <header>
        <div class="contact-info">
            <p><?php echo htmlspecialchars($user['prenom']) . ' ' . htmlspecialchars($user['nom']); ?></p>
            <p><?php echo htmlspecialchars($user['adresse']); ?></p>
            <p><?php echo htmlspecialchars($user['telephone']); ?></p>
            <p><?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        <div class="title">
            <h1><?php echo htmlspecialchars($user['description']); ?></h1>
        </div>
        <img src="uploads/photos/<?php echo htmlspecialchars($user['photo']); ?>" alt="Photo de profil">
    </header>
    
    <nav aria-label="Navigation principale">
        <a href="#experience">Expérience</a>
        <a href="#formation">Formation</a>
        <a href="#competence">Compétence</a>
        <a href="#diplome">Diplôme</a>
        <a href="#realisation">Réalisation</a>
    </nav>


    <div class="carousel">
    <div class="carousel-track">
        <img src="images/18_LA_PROVIDENCE.jpg" alt="Réalisation 1">
        <img src="images/19_LA_PROVIDENCE.jpg" alt="Réalisation 2">
        <img src="images/20_LA_PROVIDENCE.jpg" alt="Réalisation 3">
        <img src="images/21_LA_PROVIDENCE.jpg" alt="Réalisation 4">
        <img src="images/23_BAILLARGUE.jpg" alt="Réalisation 5">
        <img src="images/24_BAILLARGUE.jpg" alt="Réalisation 6">
        <img src="images/25_BAILLARGUE.jpg" alt="Réalisation 7">
        <img src="images/26_BAILLARGUE.jpg" alt="Réalisation 8">
        <img src="images/11_PEROLS.jpg" alt="Réalisation 9">
        <img src="images/12_PEROLS.jpg" alt="Réalisation 10">
        <img src="images/13_PEROLS.jpg" alt="Réalisation 11">
        <img src="images/14_CASTELNAU_LE_LEZ.jpg" alt="Réalisation 12">
        <img src="images/15_CASTELNAU_LE_LEZ.jpg" alt="Réalisation 13">
        <img src="images/16_CASTELNAU_LE_LEZ_RUE_DES_IFT.jpg" alt="Réalisation 14">
        <img src="images/17_CASTELNAU_LE_LEZ.jpg" alt="Réalisation 15">
        <img src="images/7_Juvignac.jpg" alt="Réalisation 16">
        <img src="images/8_JUVIGNAC.jpg" alt="Réalisation 17">
        <img src="images/9_JUVIGNAC.jpg" alt="Réalisation 18">
        <img src="images/10_JUVIGNAC.jpg" alt="Réalisation 19">
        <img src="images/1_MAUGUIO.jpg" alt="Réalisation 20">
        <img src="images/3_MAUGUIO.jpg" alt="Réalisation 21">
        <img src="images/4_MAUGUIO.jpg" alt="Réalisation 22">
        <img src="images/5_MAUGUIO.jpg" alt="Réalisation 23">
        <img src="images/6_MAUGUIO.jpg" alt="Réalisation 24">
    </div>
    </div>

    <main>
    <section id="experience" class="section">
        <div class="section-header" onclick="toggleSection('experience-content')">Expérience Professionnelle</div>
        <div id="experience-content" class="section-content">
            <h3>Janv. 2024 à aujourd’hui - Apprenant à distance en Software Engineering et DataScience</h3>
            <p><strong>HTML :</strong> Assimilation des balises pour la création de structures de pages HTML.</p>
            <!-- Ajoutez ici d'autres expériences -->
        </div>
    </section>

    <section id="formation" class="section">
        <div class="section-header" onclick="toggleSection('formation-content')">Formation</div>
        <div id="formation-content" class="section-content">
            <h3>Formation</h3>
            <p>Apprentissage des concepts avancés en science des données et en génie logiciel.</p>
            <!-- Ajoutez ici d'autres formations -->
        </div>
    </section>

    <section id="competence" class="section">
        <div class="section-header" onclick="toggleSection('competence-content')">Compétence</div>
        <div id="competence-content" class="section-content">
            <ul>
                <li>Compétence 1 : Expertise en développement web avec HTML, CSS, JavaScript</li>
                <!-- Ajoutez ici d'autres compétences -->
            </ul>
        </div> 
    </section>

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
                    echo "<img src='uploads/diplomes/" . htmlspecialchars($diplome['file']) . "' alt='Diplôme' style='max-width: 100%; height: auto;'>";
                } elseif ($file_extension == 'pdf') {
                    echo "<a href='uploads/diplomes/" . htmlspecialchars($diplome['file']) . "' target='_blank'>Voir le diplôme PDF</a>";
                }
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </section>

    <section id="realisation" class="section">
        <div class="section-header" onclick="toggleSection('realisation-content')">Réalisation</div>
        <div id="realisation-content" class="section-content">
            <div class="carousel">
                <div class="carousel-track">
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
                        echo "<img src='uploads/realisations/" . htmlspecialchars($realisation['image']) . "' alt='Réalisation' style='max-width: 100%; height: auto;'>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </section>
    </main>

    <script>
    function toggleSection(sectionId) {
        var section = document.getElementById(sectionId);
        if (section.classList.contains('open')) {
            section.classList.remove('open');
        } else {
            section.classList.add('open');
        }
    }

    document.addEventListener('DOMContentLoaded', function () { 
        // Gestion des liens de navigation 
        const navLinks = document.querySelectorAll('nav a'); 
        navLinks.forEach(link => { link.addEventListener('click', 
            function (event) { event.preventDefault(); 
                const targetId = this.getAttribute('href').substring(1); 
                const targetSection = document.getElementById(targetId + '-content'); 
                toggleSection(targetId + '-content'); 
                if (targetId !== 'realisation') { 
                    targetSection.scrollIntoView({ behavior: 'smooth' }); 
                } else { 
                    document.querySelector('#realisation .carousel').scrollIntoView({ behavior: 'smooth' }); 
                } 
            }); 
        }); 
    });
    
    </script>
</main>
</body>
</html>
