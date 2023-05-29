<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js">
    </script>
    <script type="text/javascript" src="carrousel.js"></script>
    <title>Accueil ECE In</title>
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
            <a href ="#" class="logo_ECE_In"><img src="images/logo_ECE.png" alt="logo_ECE_In" width="75" height="75"></a>
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
    <div id="Gray_bar"></div>
    <div id="Suggestion_Acc">
        <h2>Suggestions</h2>
    </div>
    <div id="section">
        <h2>Actualité ECE In de la Semaine</h2>

        <div id="carrousel">
            <img src="images/bob.jpg" width="300"/>
            <img src="images/cars.jpg" width="300"/>
        </div>

        </br></br></br>
        <img src="images/fleche.png" width="40" id="prev"/>
        <img src="images/fleche.png" width="40" id="next"/>


        <table>
            <?php
                $Date = new DateTime("now");
                $Date->modify("-7 day");
                $Date->modify("+2 hours");
                $Date = $Date->format('Y-m-d H:i:s');
                if ($db_found) {
                    $post = "SELECT * FROM post WHERE Date >= '$Date' ORDER BY Date DESC";
                    $post_result = mysqli_query($db_handle,$post);
                    while($post_data = mysqli_fetch_assoc($post_result))
                    {
                        $IDutilisateur = $post_data["Envoyeur"];
                        $utilisateur = "SELECT * FROM utilisateur  WHERE IDutilisateur LIKE '%$IDutilisateur%'";
                        $utilisateur_result = mysqli_query($db_handle,$utilisateur);
                        while($utilisateur_data = mysqli_fetch_assoc($utilisateur_result))
                        {
                            $Date1 = new DateTime("now");
                            $Date1->modify("+2 hours");
                            $Date1 = $Date1->format('Y-m-d H:i:s');
                            $Date1 = strtotime($Date1);
                            $Date2 = strtotime($post_data["Date"]);
                            $DateDiff = $Date1 - $Date2;
                            $DateDiff = $DateDiff/86400;
                            
                            
                            echo"<div class='post'><p class='PhotoProfil'><br><br><img height=75 src='" . $utilisateur_data["PhotoProfil"] . "' /></p>";
                            echo"<p class='Nom'>" . $utilisateur_data["Prenom"] . " " . $utilisateur_data["Nom"] . "</p>";
                            if($DateDiff >=1){
                                $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                echo"<p class='Date'>" . $DateDiff . " j</p>";
                            }
                            else if($DateDiff*24 >=1){
                                $DateDiff = $DateDiff * 24;
                                $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                echo"<p class='Date'>" . $DateDiff . " h</p>";
                            }
                            else if($DateDiff*24*60 >=1){
                                $DateDiff = $DateDiff * 24 * 60;
                                $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                echo"<p class='Date'>" . $DateDiff . " min</p>";
                            }
                            else{
                                $DateDiff = $DateDiff * 24 * 60 * 60;
                                $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                echo"<p class='Date'>" . $DateDiff . " sec</p>";
                            }
                            //echo"<p class='Date'>" . $post_data["Date"] . "</p>";
                            echo"<p class='Legende'>" . $post_data["Legende"] . "</p>";

                            echo"<p class='Data'><img height=400 src='" . $post_data["Data"] . "' /></p></div>";
                        }
                    }
                }
            ?>
        </table>
    </div>
    <div id="footer">
            <p>Nous contacter : </p>
            <p>Mail: <a href="mailto:laureline.grassin@edu.ece.fr">laureline.grassin@edu.ece.fr</a></p>
            <p>Tel: 01 44 39 06 00 </p>
            <P>Adresse: 10, Rue Sextius Michel</p>
            <p></br></br>Droit d'auteur | Copyright © 2023</p>
        <div id="googleMaps">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.3662947158255!2d2.2859909764319983!3d48.851225171331286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6701b4f58251b%3A0x167f5a60fb94aa76!2sECE%20-%20Ecole%20d&#39;ing%C3%A9nieurs%20-%20Engineering%20school.!5e0!3m2!1sfr!2sfr!4v1685365414049!5m2!1sfr!2sfr" width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</body>
</html>