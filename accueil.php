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
    <script type="text/javascript" src="accueil.js"></script>
    <title>Accueil ECE In</title>
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
    


    <div id="header">
        <h1>ECE In: Social Media Professionnel de l'ECE Paris</h1>
    </div>
    <nav class="navigation">
        <a href ="#" class="logo_ECE_In"><img src="images/logo_ECE_IN.png" alt="logo_ECE_In" width="135" height="65"></a>
        <input type="checkbox" id="toggler" placeholder="REchercher">
        <label for="toggler"><i class="ri-menu-line"></i></label>
        <div class="inputbox">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" placeholder="Rechercher">
        </div>
        <div class="menu">
            <ul class="list">
                <?php
                    $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                    $IDuser_result = mysqli_query($db_handle, $IDuser);
                    $data = mysqli_fetch_assoc($IDuser_result);
                    $Envoyeur = $data['IDutilisateur'];

                    if($data['Admin'] == 1)
                    {
                        echo"<li><a class='oncolor' href='admin.php'>Admin</a></li>";
                    }
                ?>
                <li><a class="oncolor" href="accueil.php" style="color : #037078">Accueil</a></li>
                <li><a class="oncolor" href="reseau.php">Mon réseau</a></li>
                <li><a class="oncolor" href="vous.php">Vous</a></li>
                <li><a class="oncolor" href="notifications.php">Notifications</a></li>
                <li><a class="oncolor" href="messagerie.php">Messagerie</a></li>
                <li><a class="oncolor" href="emplois.php">Emplois</a></li>
            </ul>
        </div>
    </nav>
    <div id="Gray_bar"></div>
    <div id="Info_Right">
        <div class='boutonPoster'>
            <button id="Poster" onclick="clic()">Ajouter Une Publication<ion-icon name="add-circle-outline"></ion-icon></button>
            <div id="menuPoster" style="display: none;" style="list-style: none;">
                <form method="post">
                    <input type="text" name="Legende"></br>
                    <input type="file" name="Data"></br>
                    <button id="PosterFinal" type="submit" name="PosterFinal" value="ON">Poster<ion-icon name="add-circle-outline"></ion-icon></button>
                </form>
                <?php
                    if ($db_found) {
                        if (isset($_POST["PosterFinal"]) && !(empty($_POST['PosterFinal']))) {
                            $Date = new DateTime("now");
                            $Date->modify("+2 hours");
                            $Date = $Date->format('Y-m-d H:i:s');

                        
                            $ID = "SELECT * FROM post ORDER BY Date DESC LIMIT 1;"; 
                            $ID_result = mysqli_query($db_handle, $ID);
                            $data = mysqli_fetch_assoc($ID_result);
                            $IDpost = $data["IDpost"] + 1;

                            $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                            $IDuser_result = mysqli_query($db_handle, $IDuser);
                            $data = mysqli_fetch_assoc($IDuser_result);
                            $Envoyeur = $data['IDutilisateur'];

                            $Data = isset($_POST["Data"]) ? $_POST["Data"] : "";
                            $Data = "images/" . $Data;

                            $Legende = isset($_POST["Legende"]) ? $_POST["Legende"] : "";

                            $sql = "INSERT INTO `post`(`IDpost`, `Envoyeur`, `Type`, `Date`, `Data`, `Legende`, `Commentaires`, `Aime`) VALUES('$IDpost', '$Envoyeur', '', '$Date', '$Data', '$Legende' , '0' , '0')";
                            
                            $result = mysqli_query($db_handle, $sql);
                            if ($result) {
                                header('Location: accueil.php');
                                die();
                            }
                            
                            /*$sql = "INSERT INTO `post`(`IDpost`, `Envoyeur`, `Type`, `Date`, `Data`, `Legende`, `Commentaires`, `Aime`, `Localisation`) VALUES('$IDpost', '$Envoyeur', '', '$Date', '$Data', '$Legende' , '0' , '0', '$Localisation')";
                            $All_usres = "SELECT * FROM utilisateur";
                            $All_usres_result = mysqli_query($db_handle, $All_usres);
                            while($data_all_users = mysqli_fetch_assoc($All_usres_result))
                            {
                                $IDuser_notif = $data_all_users['IDutilisateur'];
                                $IDposter = $Envoyeur;
                                $TypePoster = $data['Type'];

                                $IDnotif_sql = "SELECT * FROM notifications ORDER BY IDnotification DESC LIMIT 1;"; 
                                $IDnotif_result = mysqli_query($db_handle, $IDnotif_sql);
                                $IDnotif_data = mysqli_fetch_assoc($IDnotif_result);
                                $IDnotif = $IDnotif_data['IDnotification'] + 1;

                                $sql2 = "INSERT INTO `notification`(`IDnotification`, `IDutilisateur`,'IDposter',`TypePoster` `IDpost`, `Vu`) VALUES ('$IDnotif', '$IDuser_notif', '$IDposter', '$IDpost', '0')";
                                $result_all_users = mysqli_query($db_handle, $sql2);
                            }*/
                        }
                        else{
                            $sql = "";
                        }
                    }
                ?>
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

        <div class="line-2"></div>
        <div id="suggestions">
            <h2>Suggestions</h2>
            <button id="Poster" onclick="ajouter()">Ajouter un ami</ion-icon></button>
            <div id="menuAjout" style="display: none;" style="list-style: none;">
                <form method="post">
                    <p>Nom : <input type="text" name="Nom"></br></p>
                    <p>Prenom : <input type="text" name="Prenom"></p>
                    <button id="Recherher" type="submit" name="Rechercher" value="ON">Ajouter</button>
                </form>
                <?php
                    if ($db_found) {
                        if (isset($_POST["Rechercher"]) && !(empty($_POST['Rechercher']))) {
                            $Nom = isset($_POST["Nom"]) ? $_POST["Nom"] : "";
                            $Prenom = isset($_POST["Prenom"]) ? $_POST["Prenom"] : "";

                            $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                            $IDuser_result = mysqli_query($db_handle, $IDuser);
                            $data = mysqli_fetch_assoc($IDuser_result);
                            $IDuser2 = $data['IDutilisateur'];

                            $sql = "SELECT * FROM utilisateur where Nom LIKE '%$Nom%' and Prenom LIKE '%$Prenom%'";
                            $sql_result = mysqli_query($db_handle, $sql);
                            while($sql_data = mysqli_fetch_assoc($sql_result)){
                                $IDnvAmi = $sql_data['IDutilisateur'];
                                echo $IDnvAmi;

                                $Ajout = "INSERT INTO `relation`(`IDrelation`, `Ami1`, `Ami2`,`statut`) VALUES('', '$IDnvAmi', '$IDuser2', '1')";
                                $result_ajout = mysqli_query($db_handle, $Ajout);
                            }
                        }
                    }
                ?>
            </div>
            <br><br> 
            <div class="line-1"></div>
            <div class="scrollSugg">
            <?php
                if ($db_found) {
                    $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                    $IDuser_result = mysqli_query($db_handle, $IDuser);
                    $IDuser_data = mysqli_fetch_assoc($IDuser_result);
                    $IDuser2 = $IDuser_data["IDutilisateur"];

                    $sql="SELECT * FROM utilisateur WHERE  utilisateur.IDutilisateur NOT IN (SELECT Ami2 FROM relation join utilisateur WHERE Ami1 LIKE '%$IDuser2%' and statut ='2') AND utilisateur.IDutilisateur NOT LIKE '%$IDuser2%'";
                    $sql_result = mysqli_query($db_handle, $sql);
                    while($sql_data = mysqli_fetch_assoc($sql_result))
                    {
                        $Amis2 = $sql_data['IDutilisateur'];
                        echo "<div style='text-align: center;'>" .$sql_data['Nom']. "<br></div>";
                        echo "<div style='text-align: center;'>" .$sql_data['Prenom'] . "<br><br></div>";
                        //echo "<div class='demander'><form method='post'><input type='submit' value='valider' name='demander'>"."</form></div>";
                        $image = $sql_data['PhotoProfil'];
                        echo "<div class='photoSuggestion'><img src='$image' height='40' width='60'>" . "<br></div>"; 
                        echo "<div class='line-1'></div>";
                        //if(isset($_POST['demander']) AND $_POST['demander']=='valider'){
                            //$sql = "INSERT INTO `relation` (`IDrelation`, `Ami1`, `Ami2`, `statut`) VALUES('', '$Amis2', '$IDuser2', '1') ";
                            //$result = mysqli_query($db_handle, $sql);
                        //} 
                    } 
                }
            ?>
            </div>
        </div>
        <script>
                function ajouter(){
                    const menu = document.getElementById('menuAjout');
                    if (menu.style.display === "none") {
                        menu.style.display = "block";
                    } else {
                        menu.style.display = "none";
                    }
                }
            </script>
    </div>

    <div id="ECEin_News" class="section">
        <h2>Un petit mot sur nous</h2>
        <p>
            Bienvenue sur ECE In ! Une plate-frome en ligne permettant à un utilisateur de se connecter à son réseau dans un but professionnel.
            Vous pourrez également publier vos événements, des photos, des vidéos, votre CV, chercher un emploi et chatter avec votre réseau. 
        </p>
        </br>
        <h2>Actualité ECE In de la Semaine</h2>

        <div id="carrousel_all">
            <ion-icon name="caret-forward-outline" id="prev"></ion-icon>
            <div id="carrousel">
                <img src="images/bob.jpg" width="300"/> <!-- 1ère image du carrousel -->
                <img src="images/cars.jpg" width="300"/> <!-- 2ème image du carrousel -->
            </div>
            <ion-icon name="caret-forward-outline" id="next"></ion-icon>
        </div>
        </br>
    </div>
    <div id="ECEin_Feed" class="section">
        <h2>L'actualité de vos Amis</h2>
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
                            echo"<p class='Legende'>" . $post_data["Legende"] . "</p>";

                            $extension = pathinfo($post_data["Data"], PATHINFO_EXTENSION);
                            if ($extension === 'jpg' || $extension === 'png' || $extension === 'gif') {
                                echo"<p class='Data'><img height=250 src='" . $post_data["Data"] . "' /></p>";
                            }
                            else if ($extension === 'mp4') {
                                echo"<p class='Data'><video height=220 controls autoplay><source src='" . $post_data["Data"] . "' type='video/mp4'></video></p>";
                            }
                            else if ($extension === 'webm') {
                                echo"<p class='Data'><video height=220 controls autoplay><source src='" . $post_data["Data"] . "' type='video/webm'></video></p>";
                            }

                            echo"<div class='post2' ><button class='Like' name='Like' id='" . $post_data['IDpost'] . "' data-like='" . $post_data['Aime'] ."' onclick=like(this) style='color:white'><ion-icon name='heart'></ion-icon></button><p class='nbrLike' data-idpost='" . $post_data['IDpost'] . "'>" . $post_data["Aime"] . "</p>";
                            echo"<button class='Com' name='Com' id='" . $post_data['IDpost'] . "' data-com='" . $post_data['Commentaires'] ."' onclick=com(this) style='color:white'><ion-icon name='chatbox-ellipses'></ion-icon></button><p class='nbrCom'  data-idpost='" . $post_data['IDpost'] . "'>" . $post_data["Commentaires"] . "</p>";
                            echo"<button class='Partager' name='Partager' id='" . $post_data['IDpost'] . "' onclick=partage(this) style='color:white'><ion-icon name='share-social'></ion-icon></button></div></div>";
                        }
                    }
                }
            ?>
            <?php 
                if (isset($_POST["IDpostLike"]) && !(empty($_POST['IDpostLike']))) {
                    $IDpostLike = isset($_POST['IDpostLike']) ? $_POST['IDpostLike'] : "";

                    $like = "SELECT * FROM post WHERE IDpost LIKE '%$IDpostLike%'";
                    $like_result = mysqli_query($db_handle,$like);
                    $like_data = mysqli_fetch_assoc($like_result);
                    
                    $Like = $like_data["Aime"] + 1;
                    
                    $sql = "UPDATE post SET Aime = $Like WHERE IDpost = {$IDpostLike}";
            
                    $result2 = mysqli_query($db_handle, $sql);
                } 
                if (isset($_POST["IDpostDislike"]) && !(empty($_POST['IDpostDislike']))) {
                    $IDpostDislike = isset($_POST['IDpostDislike']) ? $_POST['IDpostDislike'] : "";

                    $like = "SELECT * FROM post WHERE IDpost LIKE '%$IDpostDislike%'";
                    $like_result = mysqli_query($db_handle,$like);
                    $like_data = mysqli_fetch_assoc($like_result);
                    
                    $Like = $like_data["Aime"] - 1;
                    
                    $sql = "UPDATE post SET Aime = $Like WHERE IDpost = {$IDpostDislike}";
            
                    $result2 = mysqli_query($db_handle, $sql);
                } 
                if (isset($_POST["IDpostPartage"]) && !(empty($_POST['IDpostPartage']))) {
                    $IDpostPartage = isset($_POST['IDpostPartage']) ? $_POST['IDpostPartage'] : "";

                    echo"ghvjbkjnk";
                    /*$like = "SELECT * FROM post WHERE IDpost LIKE '%$IDpostDislike%'";
                    $like_result = mysqli_query($db_handle,$like);
                    $like_data = mysqli_fetch_assoc($like_result);
                    
                    $Like = $like_data["Aime"] - 1;
                    
                    $sql = "UPDATE post SET Aime = $Like WHERE IDpost = {$IDpostDislike}";
            
                    $result2 = mysqli_query($db_handle, $sql);*/
                } 
            ?>
        </table>
        <div id="overlay3" class="overlay3">
            <div class="com-container">
                <h2>Ajouter un commentaire</h2>
                <button class="quitterCom" onclick=com_cacher(this)><ion-icon name="close-outline"></ion-icon></button>
                <div class="php">
                    
                </div>
            </div>
        </div>
        <div id="overlay4" class="overlay4">
            <div class="partager-container">
                <h2>Partager la publication</h2>
                <button class="quitterPartage" onclick=partage_cacher(this)><ion-icon name="close-outline"></ion-icon></button>
                <div class="php">
                    
                </div>
            </div>
        </div>
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