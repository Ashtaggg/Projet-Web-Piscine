<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Messagerie</title>
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
        if (isset($_POST["Contenu"]) && !(empty($_POST['Contenu']))) {
            $Contenu = isset($_POST['Contenu']) ? $_POST['Contenu'] : "";
            $Search_user = "SELECT * FROM utilisateur WHERE 1 = 1"; 
            // Recherche
            if ($Contenu != "") {
                $Search_user .= " AND Prenom LIKE '%$Contenu%';";
            }
            $Search_user_result = mysqli_query($db_handle, $Search_user);
            $data = mysqli_fetch_assoc($Search_user_result);

            echo"<div class='message_box' id='". $data['IDutilisateur'] . "' onclick=messa(this)><p class='message_PhotoProfil'><img height=30 src='" . $data["PhotoProfil"] . "' /></p>";
            echo"<p class='Nom_box'>" . $data["Prenom"] . " " . $data["Nom"] . "</p>";
        }
    ?>
</body>
</html>