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

    // Récupérer l'IDutilisateur correspondant à l'email
    $query = "SELECT IDutilisateur FROM utilisateur WHERE Mail = '$email'";
    $result = mysqli_query($db_handle, $query);
    $row = mysqli_fetch_assoc($result);
    $IDutilisateur = $row['IDutilisateur'];

    

    //création d'un nouvel xml
    $cv = new SimpleXMLElement('<CV></CV>');

    $infoUtilisateur = $cv->addChild('infoUtilisateur');
    $infoUtilisateur->addChild('IDutilisateur', $IDutilisateur);

    // Récupérer les informations de l'utilisateur depuis la table utilisateur
    $queryUser = "SELECT * FROM utilisateur WHERE IDutilisateur = '$IDutilisateur'";
    $resultUser = mysqli_query($db_handle, $queryUser);
    $rowUser = mysqli_fetch_assoc($resultUser);

    $infoUtilisateur->addChild('Nom', $rowUser['Nom']);
    $infoUtilisateur->addChild('Prenom', $rowUser['Prenom']);
    $infoUtilisateur->addChild('DateNaissance', $rowUser['DateNaissance']);
    $infoUtilisateur->addChild('Adresse', $rowUser['Adresse']);
    $infoUtilisateur->addChild('Mail', $rowUser['Mail']);
    $infoUtilisateur->addChild('PhotoProfil', $rowUser['PhotoProfil']);
    $infoUtilisateur->addChild('AnneeEtude', $rowUser['AnneeEtude']);

    

    // Récupérer les informations de toutes les formations de l'utilisateur depuis la base de données
    $query2 = "SELECT * FROM formation WHERE IDutilisateur = '$IDutilisateur'";
    $result2 = mysqli_query($db_handle, $query2);

    // Récupérer les informations de tous les projets de l'utilisateur depuis la base de données
    $query3 = "SELECT * FROM projet WHERE IDutilisateur = '$IDutilisateur'";
    $result3 = mysqli_query($db_handle, $query3);
    
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $infoFormations = $cv->addChild('infoFormations');
        $infoFormations->addChild('NomEcole', $row2['NomEcole']);
        $infoFormations->addChild('Diplome', $row2['Diplome']);
        $infoFormations->addChild('DateDebut', $row2['DateDebut']);
        $infoFormations->addChild('DateFin', $row2['DateFin']);
        $infoFormations->addChild('Lieu', $row2['Lieu']);
        $infoFormations->addChild('Domaine', $row2['Domaine']);
        $infoFormations->addChild('Description', $row2['Description']);
    }

    while ($row3 = mysqli_fetch_assoc($result3)) {
        $infoProjets = $cv->addChild('infoProjets');
        $infoProjets->addChild('NomEcole', $row3['NomEcole']);
        $infoProjets->addChild('NomProjet', $row3['NomProjet']);
        $infoProjets->addChild('Lieu', $row3['Lieu']);
        $infoProjets->addChild('DateDebut', $row3['DateDebut']);
        $infoProjets->addChild('DateFin', $row3['DateFin']);
        $infoProjets->addChild('Description', $row3['Description']);
    }

    //création du chemin vers le fichier xml
    $fichierXML = 'C:\wamp64\www\projet_web\Projet-Web-Piscine\CV\CV' . $IDutilisateur . '.xml';
        


    //on génere le xml
    $xmlString = $cv->asXML();


    // Écriture du fichier XML
    if (file_put_contents($fichierXML, $xmlString) !== false) {
        // Redirection vers la page d'affichage avec l'IDutilisateur
        header("Location: affichageCV.php?IDutilisateur=" . $IDutilisateur);
        exit();
    } else {
        echo 'Erreur lors de l\'enregistrement du CV';
    }


    echo 'CV bien enregistré';
    unset($_SESSION['IDutilisateur']);

    
?>
