<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Accueil</title>
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
                    <li><a href="accueil.html">Accueil</a></li>
                    <li><a href="reseau.html">Mon réseau</a></li>
                    <li><a href="vous.html">Vous</a></li>
                    <li><a href="notifications.html">Notifications</a></li>
                    <li><a href="messagerie.html">Messagerie</a></li>
                    <li><a href="emplois.html">Emplois</a></li>
                </ul>
            </div>
        </nav>
    <div id="Reseaux_Acc">
        <h2>Mon réseau</h2>
    </div>
    <div id="section">
        <h2>Actualité ECE In de la Semaine</h2>
    </div>
    <div id="footer">
        <p>Droit d'auteur | Copyright © 2023</p>
    </div>
</body>
</html>