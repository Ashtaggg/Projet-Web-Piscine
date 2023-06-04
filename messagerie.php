<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="messagerie.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <title>Messagerie ECE In</title>
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
<script>
    function messa(element){
        const IDenvoyeur = element.id;
        console.log(IDenvoyeur);
        document.location.href="messagerie.php?IDenvoyeur=" + IDenvoyeur; 
    }
</script>
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
                <input type="text" id="rech-message" placeholder="Rechercher des Contacts" onclick=rech_mess(this)>
            </div>
            <div class="scroll" id="scroll-messagerie">
                <?php
                     $Date = new DateTime("now");
                     $Date->modify("-7 day");
                     $Date->modify("+2 hours");
                     $Date = $Date->format('Y-m-d H:i:s');
                     if ($db_found) {
                         $message = "SELECT * FROM ( SELECT IDmessage, Envoyeur, Recepteur, Date, Contenu, Statut, ROW_NUMBER() OVER(PARTITION BY Recepteur ORDER BY Date DESC) rn FROM message ) a WHERE rn = 1;";
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

                                if($IDrecepteur==$IDutilisateur)
                                {
                                    /*$Date_mess=$message_data["Date"];
                                    $verif = "SELECT * FROM message WHERE Envoyeur LIKE '%$IDutilisateur%' AND Recepteur LIKE '%$IDenvoyeur%' AND Date>'%$Date_mess%'";
                                    $verif_result = mysqli_query($db_handle,$verif);
                                    $verif_data = mysqli_fetch_assoc($verif_result);
                                    if($verif_data==NULL)
                                    {*/
                                    if($Statut==1)
                                    {
                                        echo"<div class='message_box' id='". $message_data['Envoyeur'] . "' onclick=messa(this)><p class='message_PhotoProfil'><img height=30 src='" . $envoyeur_data["PhotoProfil"] . "' /></p>";
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
                                    elseif($Statut==0)
                                    {
                                        echo"<div class='message_box' id='". $message_data['Envoyeur'] . "' style='font-weight: 700' onclick=messa(this)><p class='message_PhotoProfil'><img height=30 src='" . $envoyeur_data["PhotoProfil"] . "' /></p>";
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
                                elseif($IDenvoyeur==$IDutilisateur && $Statut==0)
                                {
                                    $recepteur = "SELECT * FROM utilisateur WHERE IDutilisateur LIKE '%$IDrecepteur%'";
                                    $recepteur_result = mysqli_query($db_handle,$recepteur);
                                    $recepteur_data = mysqli_fetch_assoc($recepteur_result);
                                    echo"<div class='message_box' id='". $message_data['Recepteur'] . "' onclick=messa(this)><p class='message_PhotoProfil'><img height=30 src='" . $recepteur_data["PhotoProfil"] . "' /></p>";
                                    echo"<p class='Nom_box'>" . $recepteur_data["Prenom"] . " " . $recepteur_data["Nom"] . "</p>";
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
                if (isset($_GET["IDenvoyeur"]) && !(empty($_GET['IDenvoyeur']))) {
                    $IDenvoyeur = isset($_GET['IDenvoyeur']) ? $_GET['IDenvoyeur'] : "";
                    if($db_found){
                        $sql = "SELECT * FROM utilisateur WHERE IDutilisateur = $IDenvoyeur";
                        $result = mysqli_query($db_handle, $sql);
                        $data = mysqli_fetch_assoc($result);
                        echo $data["Prenom"] . " " . $data["Nom"];
                        }
                        else {
                            echo "Database not found";
                        }//end else
                }
                ?>
                </p>
            </div>
            <div class="line-1"></div>
            </br>
            <div class="Conv">
                <div class="scroll" id="scroll_msg">
                <?php
                    $Date = new DateTime("now");
                    $Date->modify("-7 day");
                    $Date->modify("+2 hours");
                    $Date = $Date->format('Y-m-d H:i:s');
                    $utilisateur = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                    $utilisateur_result = mysqli_query($db_handle,$utilisateur);
                    $utilisateur_data = mysqli_fetch_assoc($utilisateur_result);
                    $IDutilisateur = $utilisateur_data["IDutilisateur"];
                    if (isset($_GET["IDenvoyeur"]) && !(empty($_GET['IDenvoyeur']))) {
                        $IDenvoyeur = isset($_GET['IDenvoyeur']) ? $_GET['IDenvoyeur'] : "";
                        if ($db_found) {
                            $message = "SELECT * FROM `message` WHERE (Envoyeur = $IDenvoyeur OR Envoyeur = $IDutilisateur) AND (Recepteur = $IDenvoyeur OR Recepteur = $IDutilisateur) ORDER BY Date ASC";
                            $message_result = mysqli_query($db_handle,$message);
                            while($message_data = mysqli_fetch_assoc($message_result))
                            {
                                $IDenvoyeur_mess = $message_data["Envoyeur"];
                                $IDrecepteur_mess = $message_data["Recepteur"];
                                $Contenu_message = $message_data["Contenu"];
                                $Statut_mess = $message_data["Statut"];
                                if($IDenvoyeur_mess==$IDutilisateur){
                                    echo"<p class='message_me'>" . $Contenu_message . "</p><br>";
                                    if($Statut_mess==0){
                                        echo "<ion-icon class='icon_me' name='checkmark-outline'></ion-icon></br>";
                                    }
                                    else{
                                        echo "<ion-icon class='icon_me' name='checkmark-done-outline'></ion-icon></br>";
                                    }

                                    //echo "Test moi    env : " . $IDenvoyeur_mess . "    rec : " . $IDrecepteur_mess . "    statut : " . $Statut_mess . "<br>";
                                }
                                else{
                                    echo"<p class='message_him'>" . $Contenu_message . "</p><br>";
                                    if($Statut_mess==0){
                                        $message_update = "UPDATE `message` SET `Statut`= 1 WHERE Envoyeur = $IDenvoyeur_mess AND Recepteur = $IDrecepteur_mess";
                                        $message_update_result = mysqli_query($db_handle,$message_update);
                                        echo "<ion-icon class='icon_him' name='checkmark-done-outline'></ion-icon></br>";
                                    }
                                    else{
                                        echo "<ion-icon class='icon_him' name='checkmark-done-outline'></ion-icon></br>";
                                    }
                                    //echo "Test lui    env : " . $IDenvoyeur_mess . "    rec : " . $IDrecepteur_mess . "    statut : " . $Statut_mess . "<br>";
                                }
                            }
                        }
                        else {
                            echo "Database not found";
                        }//end else
                    }
                    else {
                        echo "<p class='chat_txt'>Parlez avec un ami !</p><br>";
                    }//end else
                ?>
                </div>
                <div class="message_ecrir">
                    <a href="https://zoom.us/fr/signin#/login"> <ion-icon class="icon_ecrir" id="lefticons" name="call-outline"></ion-icon> </a>
                    <a href="https://zoom.us/fr/signin#/login"> <ion-icon class="icon_ecrir" id="lefticons" name="videocam-outline"></ion-icon> </a>
                    <div class="inputbox_ecrir">
                        <input type="text" placeholder="cause avec le copaing" size="22" id='contenuMess' class="inputMess">
                    </div>
                    <ion-icon class="icon_ecrir" name="paper-plane-outline" data-env="<?php echo $IDutilisateur; ?>" data-recep="<?php echo $IDenvoyeur; ?>" data-utilisateur="<?php echo $IDutilisateur; ?>" data-utilisateur="<?php echo $IDutilisateur; ?>"onclick=mess(this)></ion-icon>
                </div>
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