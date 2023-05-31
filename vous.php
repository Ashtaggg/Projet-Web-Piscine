<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />



    <title>Mon Espace ECE In</title>
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
    <div id="header">
        <h1>ECE In: Social Media Professionnel de l'ECE Paris</h1>
    </div>
    <nav class="navigation">
        <a href ="#" class="logo_ECE_In"><img src="images/logo_ECE_IN.png" alt="logo_ECE_In" width="135" height="65"></a>
        <input type="checkbox" id="toggler" placeholder="Rechercher">
        <label for="toggler"><i class="ri-menu-line"></i></label>
        <div class="inputbox">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" placeholder="Rechercher">
        </div>
        <div class="menu">
            <ul class="list">
                <li><a class="oncolor" href="accueil.php">Accueil</a></li>
                <li><a class="oncolor" href="reseau.php">Mon réseau</a></li>
                <li><a class="oncolor" href="vous.php" style="color : #037078">Vous</a></li>
                <li><a class="oncolor" href="notifications.php">Notifications</a></li>
                <li><a class="oncolor" href="messagerie.php">Messagerie</a></li>
                <li><a class="oncolor" href="emplois.php">Emplois</a></li>
            </ul>
        </div>
    </nav>
    <div id="Gray_bar"></div>
    <div id="Info_Right">
        <h2>Mes amis</h2>
        <div class="line-1"></div>
        <?php
            //si le BDD existe, faire le traitement
            if ($db_found) {
                $sql = "SELECT * FROM utilisateur where Mail like '%$email%'"; 
                $result = mysqli_query($db_handle, $sql);
                while ($data = mysqli_fetch_assoc($result)) {
                    echo  $data['Amis'] . "<br>";
                    //echo  $data['Prenom'] . "<br>";
                    //$image = $data['PhotoProfil'];
                    //echo "<div class='photoAmis'><img src='$image' height='60' width='80'>" . "<br><br></div>";
                }//end while
            }//end if
            //si le BDD n'existe pas
            else {
                echo "Database not found";
            }//end else
        ?>
    </div>
    <div id="MonProfil">
        <br><br>
         <?php
            //si le BDD existe, faire le traitement
            if ($db_found) {
                $sql = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                $result = mysqli_query($db_handle, $sql);
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "Nom: " . $data['Nom'] . "<br>";
                    echo "Prénom: " . $data['Prenom'] . "<br>";
                    echo "Adresse: " . $data['Adresse'] . "<br>";
                    echo "Date de naissance: " . $data['DateNaissance'] . "<br>";
                    $image = $data['PhotoProfil'];
                     echo "<div class='photo'><img src='$image' height='80' width='100'>" . "<br><br></div>";
                }//end while
            }//end if
            //si le BDD n'existe pas
            else {
                echo "Database not found";
            }//end else
        ?>
        <div class='bouton'><button type="submit" >Charger mon CV</button></div>
        <br><br>
        <div class='bouton'>
            <a href="connexion.php"><button>se déconnecter</button></a>
        </div>
    </div>
    
    <div id="Formation">  
        <h2>Formations</h2>
        <button id="plusFormation"onclick="clic()"><ion-icon name="add-circle-outline"></ion-icon></button>
        
        <div id="menuPoster" style="display: none;" style="list-style: none;">
                <form method="post">
                    <input type="text" name="Legende"></br>
                    <input type="file" name="Data"></br>
                    <button id="PosterFinal" type="submit" name="PosterFinal" value="10">Poster</button>
                    
                </form>
            </div>
            <script>
                function clic(){
                    const menu = document.getElementById('menuPoster');
                    if (menu.style.display === "none") {
                        menu.style.display = "block";
                    } else {
                        menu.style.display = "none";
                    }
                }
            </script>

    </div>
    <div id="Projet">
        <h2>Projets</h2>
    </div>
    <div id="MesPost">
        <h2>Mes posts</h2>
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
                        $utilisateur = "SELECT * FROM utilisateur WHERE IDutilisateur LIKE '%$IDutilisateur%'";
                        $utilisateur_result = mysqli_query($db_handle,$utilisateur);
                        while($utilisateur_data = mysqli_fetch_assoc($utilisateur_result))
                        {
                            if($IDutilisateur == $utilisateur){
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
                                else if($DateDiff * 24 >=1){
                                    $DateDiff = $DateDiff * 24;
                                    $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                    echo"<p class='Date'>" . $DateDiff . " h</p>";
                                }
                                 else if($DateDiff * 24 * 60 >=1){
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

                                echo"<p class='Data'><img height=300 src='" . $post_data["Data"] . "' /></p></div>";
                        }
                        }
                    }
                }
            ?>
        </table>
        </br>
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
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>