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
                    <li><a href="accueil.php">Accueil</a></li>
                    <li><a href="reseau.php">Mon réseau</a></li>
                    <li><a href="vous.php">Vous</a></li>
                    <li><a href="notifications.php">Notifications</a></li>
                    <li><a href="messagerie.php">Messagerie</a></li>
                    <li><a href="emplois.php">Emplois</a></li>
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
            <p>Nous contacter : </p>
            <p>Mail: <a href="mailto:laureline.grassin@edu.ece.fr">laureline.grassin@edu.ece.fr</a></p>
        <div id="googleMaps">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.3662947158255!2d2.2859909764319983!3d48.851225171331286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6701b4f58251b%3A0x167f5a60fb94aa76!2sECE%20-%20Ecole%20d&#39;ing%C3%A9nieurs%20-%20Engineering%20school.!5e0!3m2!1sfr!2sfr!4v1685365414049!5m2!1sfr!2sfr" width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

            <p>Droit d'auteur | Copyright © 2023</p>
    </div>
</body>
</html>