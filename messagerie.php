<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Messagerie ECE In</title>
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
        <input type="checkbox" id="toggler">
        <label for="toggler"><i class="ri-menu-line"></i></label>
        <div class="inputbox">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" placeholder="Rechercher" size="22">
        </div>
        <div class="menu">
            <ul class="list">
                <li><a class="oncolor" href="accueil.php">Accueil</a></li>
                <li><a class="oncolor" href="reseau.php">Mon réseau</a></li>
                <li><a class="oncolor" href="vous.php">Vous</a></li>
                <li><a class="oncolor" href="notifications.php">Notifications</a></li>
                <li><a class="oncolor" href="messagerie.php" style="color : #037078">Messagerie</a></li>
                <li><a class="oncolor" href="emplois.php">Emplois</a></li>
            </ul>
        </div>
    </nav>
    <div id="Gray_bar"></div>
    <div id="Messagerie">
        <div id="Messages" class="section">
            <div id="Icon">
                <p style="font-weight : 700">Messagerie   </p>
                <ion-icon style="margin-left : 5px" name="file-tray-outline"></ion-icon>
            </div>
            <div class="line-1"></div>
            </br>
            <div class="inputbox_mess">
                <ion-icon name="search-outline"></ion-icon>
                <input type="text" placeholder="Rechercher des Contacts">
            </div>
            <div class="scroll">
                <?php
                     $Date = new DateTime("now");
                     $Date->modify("-7 day");
                     $Date->modify("+2 hours");
                     $Date = $Date->format('Y-m-d H:i:s');
                     if ($db_found) {
                         $message = "SELECT * FROM ( SELECT IDmessage, Envoyeur, Recepteur, Date, Contenu, Statut, ROW_NUMBER() OVER(PARTITION BY Envoyeur ORDER BY Date DESC) rn FROM message ) a WHERE rn = 1;";
                         $message_result = mysqli_query($db_handle,$message);
                         while($message_data = mysqli_fetch_assoc($message_result))
                         {
                             $IDenvoyeur = $message_data["Envoyeur"];
                             $IDrecepteur = $message_data["Recepteur"];
                             $Statut = $message_data["Statut"];
                             $utilisateur = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                             $utilisateur_result = mysqli_query($db_handle,$utilisateur);
                             $envoyeur = "SELECT * FROM utilisateur WHERE IDutilisateur LIKE '%$IDenvoyeur%'";
                             $envoyeur_result = mysqli_query($db_handle,$envoyeur);
                             $envoyeur_data = mysqli_fetch_assoc($envoyeur_result);
                             while($utilisateur_data = mysqli_fetch_assoc($utilisateur_result))
                            {
                                $IDutilisateur = $utilisateur_data["IDutilisateur"];
                                $Date1 = new DateTime("now");
                                $Date1->modify("+2 hours");
                                $Date1 = $Date1->format('Y-m-d H:i:s');
                                $Date1 = strtotime($Date1);
                                $Date2 = strtotime($message_data["Date"]);
                                $DateDiff = $Date1 - $Date2;
                                $DateDiff = $DateDiff/86400;

                                if($IDrecepteur==$IDutilisateur && $Statut==1)
                                {
                                    echo"<div class='message_box'><p class='message_PhotoProfil'><img height=30 src='" . $envoyeur_data["PhotoProfil"] . "' /></p>";
                                    echo"<p class='Nom_box'>" . $envoyeur_data["Prenom"] . " " . $envoyeur_data["Nom"] . "</p>";
                                    echo "<div class='message_txt_box'><p class='Message_txt'>" . substr($message_data["Contenu"], 0, 15) . "...</p>";
                                    if($DateDiff >=1){
                                        $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                        echo"<p class='message_Date'>" . $DateDiff . " j</p></div></div>";
                                    }
                                    else if($DateDiff * 24 >=1){
                                        $DateDiff = $DateDiff * 24;
                                        $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                        echo"<p class='message_Date'>" . $DateDiff . " h</p></div></div>";
                                    }
                                    else if($DateDiff * 24 * 60 >=1){
                                        $DateDiff = $DateDiff * 24 * 60;
                                        $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                        echo"<p class='message_Date'>" . $DateDiff . " min</p></div></div>";
                                    }
                                    else{
                                        $DateDiff = $DateDiff * 24 * 60 * 60;
                                        $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                        echo"<p class='message_Date'>" . $DateDiff . " sec</p></div></div>";
                                    }
                                    //echo"<p class='Date'>" . $message_data["Date"] . "</p>";
                                }
                                elseif($IDrecepteur==$IDutilisateur && $Statut==0)
                                {
                                    echo"<div class='message_box'style='font-weight: 700'><p class='message_PhotoProfil'><img height=30 src='" . $envoyeur_data["PhotoProfil"] . "' /></p>";
                                    echo"<p class='Nom_box'>" . $envoyeur_data["Prenom"] . " " . $envoyeur_data["Nom"] . "</p>";
                                    echo "<div class='message_txt_box'><p class='Message_txt'>" . substr($message_data["Contenu"], 0, 15) . "...</p>";
                                    if($DateDiff >=1){
                                        $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                        echo"<p class='message_Date'>" . $DateDiff . " j</p></div></div>";
                                    }
                                    else if($DateDiff * 24 >=1){
                                        $DateDiff = $DateDiff * 24;
                                        $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                        echo"<p class='message_Date'>" . $DateDiff . " h</p></div></div>";
                                    }
                                    else if($DateDiff * 24 * 60 >=1){
                                        $DateDiff = $DateDiff * 24 * 60;
                                        $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                        echo"<p class='message_Date'>" . $DateDiff . " min</p></div></div>";
                                    }
                                    else{
                                        $DateDiff = $DateDiff * 24 * 60 * 60;
                                        $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                                        echo"<p class='message_Date'>" . $DateDiff . " sec</p></div></div>";
                                    }
                                }
                            }
                        }
                    }
                    else {
                        echo "Database not found";
                    }//end else
                ?>
            </div>
            </br>
        </div>
        <div id="Chat" class="section">
            <div id="Name">
                <p style="font-weight : 700">
                <?php
                    if($db_found){
                        $sql = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                        $result = mysqli_query($db_handle, $sql);
                        while($data = mysqli_fetch_assoc($result)){
                            echo $data['Prenom'] . " " . $data['Nom'];
                        }
                    }
                    else {
                        echo "Database not found";
                    }//end else
                ?>
                </p>
            </div>
            <div class="line-1"></div>
            </br>
            <div class="scroll">
                <p>Ami 1</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>Ami 1</p>
            </div>
            </br>
        </div>
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