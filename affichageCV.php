<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Affichage du CV</title>
    <link rel="icon" href="images/logo_ECE_IN.png" type="image/gif">
    <?php
        // Identifier le nom de base de données
        $database = "projet-web-piscine";

        // Connexion à la base de donnée
        // à adapter en fonction de votre ordinateur

        // Création de la connexion à la base de donnée

        // WAMP sur Windows avec MySQL
        $db_handle = mysqli_connect('localhost', 'root', '', $database);
        // WAMP sur Windows avec MariaDB
        // $db_handle = mysqli_connect('db', 'root', '', $database, 3307);
        // Mac OS
        // $db_handle = mysqli_connect('localhost', 'root', 'root', $database, 8889);

        $db_found = mysqli_select_db($db_handle, $database);
        session_start();
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : "";
    ?>



</head>

<body class="affichageCV">
<div class="cv-container">
        
            <?php
            // Récupérer l'IDutilisateur depuis l'URL
            $IDutilisateur = isset($_GET['IDutilisateur']) ? $_GET['IDutilisateur'] : "";

            // Chemin du fichier XML
            $fichierXML = 'C:/wamp64/www/projet_web/Projet-Web-Piscine/CV/CV' . $IDutilisateur . '.xml';


            if (file_exists($fichierXML)) {
                // Charger le contenu du fichier XML
                $xml = simplexml_load_file($fichierXML);

                // Parcourir les infos utilisateurs et afficher les informations
                foreach ($xml->infoUtilisateur as $utilisateur) {
                    if (!empty($utilisateur->PhotoProfil)) {
                        $photoUrl = $utilisateur->PhotoProfil; 
                        //echo '<img src="' . $photoUrl . '" alt="Photo de profil"><br>';
                        //echo '<div class="cv-section-item" style="text-align: center;"><img src="' . $photoUrl . '" alt="Photo de profil"></div>';
                        echo '<div class="cv-section-item" style="text-align: center;"><img src="' . $photoUrl . '" alt="Photo de profil" style="max-width: 100px;"></div>';
                    }
                    echo 'Nom : ' . $utilisateur->Nom . '<br>';
                    echo 'Prénom : ' . $utilisateur->Prenom . '<br>';
                    echo 'Date de naissance : ' . $utilisateur->DateNaissance . '<br>';
                    echo 'Adresse : ' . $utilisateur->Adresse . '<br>';
                    echo 'Mail : ' . $utilisateur->Mail . '<br>';
                    echo 'Année d\'étude : ' . $utilisateur->AnneeEtude . '<br>';
                    echo '<br>';
                }
                
                
                echo '<h2 class="cv-section-title" style="background-color: rgba(0, 95, 99, 0.279);">Formations</h2>';
                
                // Parcourir les formations et afficher les informations
                foreach ($xml->infoFormations as $formation) {
                    echo 'Nom de l\'école : ' . $formation->NomEcole . '<br>';
                    echo 'Diplôme : ' . $formation->Diplome . '<br>';
                    echo 'Date de début : ' . $formation->DateDebut . '<br>';
                    echo 'Date de fin : ' . $formation->DateFin . '<br>';
                    echo 'Lieu : ' . $formation->Lieu . '<br>';
                    echo 'Domaine : ' . $formation->Domaine . '<br>';
                    echo 'Description : ' . $formation->Description . '<br>';
                    echo '<br>';
                }

                
                echo '<h2 class="cv-section-title" style="background-color: rgba(0, 95, 99, 0.279);">Projets</h2>';

                // Parcourir les projets et afficher les informations
                foreach ($xml->infoProjets as $projet) {
                    echo 'Nom de l\'école : ' . $projet->NomEcole . '<br>';
                    echo 'Nom du projet : ' . $projet->NomProjet . '<br>';
                    echo 'Lieu : ' . $projet->Lieu . '<br>';
                    echo 'Date de début : ' . $projet->DateDebut . '<br>';
                    echo 'Date de fin : ' . $projet->DateFin . '<br>';
                    echo 'Description : ' . $projet->Description . '<br>';
                    echo '<br>';
                }

            } 
            else {
                echo 'Le fichier XML n\'existe pas';
            }

        
    ?>
</div>




</body>