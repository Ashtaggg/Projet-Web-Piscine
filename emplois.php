<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Emplois</title>
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
    ?>
</head>
<body>
    <div id="header">
        <h1>ECE In: Social Media Professionnel de l'ECE Paris</h1>
    </div>
        <nav class="navigation">
            <a href ="#" class="logo_ECE_In"><img src="images/logo_ECE.png" alt="logo_ECE_In" width="100" height="100"></a>
            <input type="checkbox" id="toggler">
            <label for="toggler"><i class="ri-menu-line"></i></label>
            <div class="search">
                <input type="text" placeholder="Rechercher">
                <i class="ri-search-line"></i>
            </div>
            <div class="menu">
                <ul class="list">
                    <li><a href="accueil.php">Accueil</a></li>
                    <li><a href="reseau.php">Mon réseau</a></li>
                    <li><a href="vous.php">Vous</a></li>
                    <li><a href="notifications.php">Notifications</a></li>
                    <li><a href="messagerie.php">Messagerie</a></li>
                    <li><a href="emplois.php">Emplois</a></li>
                </ul>
            </div>
        </nav>
    <div id="footer">
        <p>Droit d'auteur | Copyright © 2023</p>
    </div>
</body>
</html>