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

    //je laisse ?
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : "";


    //vérifier si les données ont été soumises via le formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($email)){
        $NomEcole = $_POST["NomEcole"];
        $Diplome = $_POST["Diplome"];
        $DateDebut = $_POST["DateDebut"];
        $DateFin = $_POST["DateFin"];
        $Lieu = $_POST["Lieu"];
        $Domaine = $_POST["Domaine"];
        $Description = $_POST["Description"];

        // Récupérer l'IDutilisateur correspondant à l'email
        $query = "SELECT IDutilisateur FROM utilisateur WHERE Mail = '$email'";
        $result = mysqli_query($db_handle, $query);
        $row = mysqli_fetch_assoc($result);
        $IDutilisateur = $row['IDutilisateur'];

        //création du chemin vers le fichier xml
        $fichierXML = 'C:\wamp64\www\projet_web\Projet_Web_Piscine\CV\CV' . $IDutilisateur . '.xml';

        //création d'un nouvel xml
        $cv = new SimpleXMLElement('<CV></CV>');

        $infoFormations = $cv->addChild('infoFormations');
        $infoFormations->addChild('NomEcole', $NomEcole);
        $infoFormations->addChild('Diplome', $Diplome);
        $infoFormations->addChild('DateDebut', $DateDebut);
        $infoFormations->addChild('DateFin', $DateFin);
        $infoFormations->addChild('Lieu', $Lieu);
        $infoFormations->addChild('Domaine', $Domaine);
        $infoFormations->addChild('Description', $Description);

        //on génere le xml
        $xmlString = $cv->asXML();

        

        file_put_contents($fichierXML, $xmlString);

        echo 'CV bien enregistré';
        unset($_SESSION['IDutilisateur']);

    }

?>
