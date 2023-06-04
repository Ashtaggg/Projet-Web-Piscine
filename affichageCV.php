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

<body>
<?php
    if (isset($_GET['ID'])){
        
    }




/*
    // Chemin vers le répertoire contenant les fichiers XML
    $repertoire = 'C:\wamp64\www\projet_web\Projet_Web_Piscine\CV\CV';

    // Obtenir la liste des fichiers XML dans le répertoire
    $fichiers = glob($repertoire . '/*.xml');

    // Trier les fichiers par date de création
    usort($fichiers, function($a, $b) {
        return filemtime($a) < filemtime($b);
    });

    // Sélectionner le fichier XML le plus récent
    $fichierXML = $fichiers[0];

    // Charger le contenu du fichier XML
    $xml = simplexml_load_file($fichierXML);

    // Afficher le titre
    echo "<h1>Mes formations</h1>";

    // Parcourir les informations des formations
    foreach ($xml->infoFormations as $formation) {
        echo "<p>Nom de l'école: " . $formation->NomEcole . "</p>";
        echo "<p>Diplôme: " . $formation->Diplome . "</p>";
        echo "<p>Date de début: " . $formation->DateDebut . "</p>";
        echo "<p>Date de fin: " . $formation->DateFin . "</p>";
        echo "<p>Lieu: " . $formation->Lieu . "</p>";
        echo "<p>Domaine d'études: " . $formation->Domaine . "</p>";
        echo "<p>Description: " . $formation->Description . "</p>";
        echo "<br>";
    }
    */
?>






</body>