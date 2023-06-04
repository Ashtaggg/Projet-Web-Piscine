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

    // Récupérer les informations de toutes les formations de l'utilisateur depuis la base de données
    $query = "SELECT * FROM formation WHERE IDutilisateur = '$IDutilisateur'";
    $result = mysqli_query($db_handle, $query);

    //création d'un nouvel xml
    $cv = new SimpleXMLElement('<CV></CV>');
    
        while ($row = mysqli_fetch_assoc($result)) {
            $infoFormations = $cv->addChild('infoFormations');
            $infoFormations->addChild('NomEcole', $row['NomEcole']);
            $infoFormations->addChild('Diplome', $row['Diplome']);
            $infoFormations->addChild('DateDebut', $row['DateDebut']);
            $infoFormations->addChild('DateFin', $row['DateFin']);
            $infoFormations->addChild('Lieu', $row['Lieu']);
            $infoFormations->addChild('Domaine', $row['Domaine']);
            $infoFormations->addChild('Description', $row['Description']);
        }


        //création du chemin vers le fichier xml
        $fichierXML = 'C:\wamp64\www\projet_web\Projet_Web_Piscine\CV\CV' . $IDutilisateur . '.xml';



        //on génere le xml
        $xmlString = $cv->asXML();

        

        file_put_contents($fichierXML, $xmlString);

        echo 'CV bien enregistré';
        unset($_SESSION['IDutilisateur']);

    

?>
