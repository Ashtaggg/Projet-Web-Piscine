<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Mon Reseau ECE In</title>
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
        <input type="checkbox" id="toggler">
        <label for="toggler"><i class="ri-menu-line"></i></label>
        <div class="inputbox">
                <ion-icon name="search-outline"></ion-icon>
                <input type="text" placeholder="Rechercher" size="22">
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
                <li><a class="oncolor" href="accueil.php">Accueil</a></li>
                <li><a class="oncolor" href="reseau.php" style="color : #037078">Mon réseau</a></li>
                <li><a class="oncolor" href="vous.php">Vous</a></li>
                <li><a class="oncolor" href="notifications.php">Notifications</a></li>
                <li><a class="oncolor" href="messagerie.php">Messagerie</a></li>
                <li><a class="oncolor" href="emplois.php">Emplois</a></li>
            </ul>
        </div>
    </nav>

    <div id="Gray_bar"></div>


    <div id="Info_Right2">
        <h2>Mes demandes d'amis</h2>
        <button id="accepter" value="acceder" onclick="openAcc()">accéder</button>

        <div id="overlayV2" class="overlay3">
            <div class="form-container">
                <h2>Accepter mes demandes</h2>
                <a href="reseau.php">
                    <button class="quitterFormation"><ion-icon name="close-outline"></ion-icon></button>
                </a><br>
                <form method=post>
                    <input type="submit" value="accepter" name="demande" />
                    <input type="submit" value="refuser" name="demande" />
                    <br>
                </form>
                <?php
                     //si le BDD existe, faire le traitement
                    if ($db_found) {

                        $sql = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                        $result = mysqli_query($db_handle, $sql);
                        $data = mysqli_fetch_assoc($result);
                        $IDuser = $data['IDutilisateur'];

                        $Demande = "SELECT * FROM utilisateur join relation WHERE Ami1 LIKE'%$IDuser%' and statut = '1' and Ami2 = IDutilisateur";
                        $result_demande = mysqli_query($db_handle, $Demande);
                        while($data_demande = mysqli_fetch_assoc($result_demande)){
                            $Ami = $data_demande['Ami2'];
                            echo "Nom: " . $data_demande['Nom'] . "<br>";
                            echo "Prénom: " . $data_demande['Prenom'] . "<br><br>";
                            echo "<div class='line-1'>" . "<br></div>";
                            $image = $data_demande['PhotoProfil'];
                            echo "<div class='photoAmi'><img src='$image' height='40' width='60'>" . "<br><br></div>";
                            if(isset($_POST['demande']) AND $_POST['demande']=='accepter'){
                                $sql = "UPDATE relation SET statut = '2' where Ami1 = {$IDuser} and Ami2 = {$Ami}";
                                $result = mysqli_query($db_handle, $sql);
                                $data_sql = mysqli_fetch_assoc($result);
                                $sql2 = "INSERT INTO `relation` (`IDrelation`, `Ami1`, `Ami2`, `statut`) VALUES('', '$Ami', '$IDuser', '2') ";
                                $result2 = mysqli_query($db_handle, $sql2);
                                $data_sql2 = mysqli_fetch_assoc($result2);
                            } 
                            else if(isset($_POST['demande']) AND $_POST['demande']=='refuser'){
                                $sql3 = "UPDATE relation SET statut = '0' where Ami1 = {$IDuser} and Ami2 = {$Ami}";
                                $result3 = mysqli_query($db_handle, $sql3);
                                $data_sql3 = mysqli_fetch_assoc($result3); 
                            }
                        }
                    }//end if
                    //si le BDD n'existe pas
                    else {
                        echo "Database not found";
                    }//end else
                 ?>
                
            </div>
        </div>
        <script>
            function openAcc() {
                var overlayV2 = document.getElementById("overlayV2");
                overlayV2.style.display = "block";
            }
        </script>
        <br>
        <div class="line-1"></div>
        <?php
            //si le BDD existe, faire le traitement
            if ($db_found) {
                $sql = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                $result = mysqli_query($db_handle, $sql);
                $data = mysqli_fetch_assoc($result);
                $IDuser = $data['IDutilisateur'];

                $Demande = "SELECT * FROM utilisateur join relation WHERE Ami1 LIKE'%$IDuser%' and statut = '1' and Ami2 = IDutilisateur";
                $result_demande = mysqli_query($db_handle, $Demande);
                while($data_demande = mysqli_fetch_assoc($result_demande)){
                    echo "Nom: " . $data_demande['Nom'] . "<br>";
                    echo "Prénom: " . $data_demande['Prenom'] . "<br><br>";
                    echo "<div class='line-1'>" . "<br></div>";
                    $image = $data_demande['PhotoProfil'];
                    echo "<div class='photoAmi'><img src='$image' height='40' width='60'>" . "<br><br></div>";
                    //echo "<input type='button' value='accepter' onclick='openAcc()'>";
                    //echo "<div id='demande' class='demande'>" ."Accepter mes demandes"."</h2></div>";
                }
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
                    echo "Prénom: " . $data['Prenom'] . "<br><br>";
                    echo "<div class='line-1'>" . "<br></div>";
                    echo "Ma description : ". $data['Descript']. "<br>";
                    $image = $data['PhotoProfil'];
                     echo "<div class='photo'><img src='$image' height='80' width='100'>" . "<br><br></div>";
                }//end while
            }//end if
            //si le BDD n'existe pas
            else {
                echo "Database not found";
            }//end else
        ?>
    </div>
    <div class="inputbox_res">
        <ion-icon name="search-outline"></ion-icon>
        <input type="text" placeholder="Rechercher des Contacts">
    </div>

    <div id="Sec_Amis" class="section">
        <h2>Mes Amis</h2>
        <div class="line-1"></div>
        <div class="scroll">
        <?php
            //si le BDD existe, faire le traitement
            if ($db_found) {
                $sql = "SELECT * FROM utilisateur where Mail like '%$email%'"; 
                $result_sql = mysqli_query($db_handle, $sql);
                while ($data_sql = mysqli_fetch_assoc($result_sql)) {
                    $IDutilisateur= $data_sql['IDutilisateur'];
                    $Amis = "SELECT * FROM relation join utilisateur WHERE Ami1 like '%$IDutilisateur%' and relation.statut='2' and Ami2 = IDutilisateur";
                    $Amis_result = mysqli_query($db_handle, $Amis);
                    $Amis_data = mysqli_fetch_assoc($Amis_result);
                    echo "<div>". "<br></div>";
                    $image = $Amis_data['PhotoProfil'];
                    echo "<a href='amis.php'><div class='photoMonAmis'><img src='$image' height='40' width='60'>" . "<br></div></a>";
                    echo  "<div class='amis'>".$Amis_data['Nom'] . "</div>";
                    echo  "<div class='amis'>".$Amis_data['Prenom'] . "</div><br>";
                    echo "<div>". "<br></div>";
                    echo "<div class='line-1'>" . "<br></div>";
                    $Ami2 = $Amis_data['Ami2'];
                    $_SESSION['Ami2'] = $Ami2;
                           
                }//end while
                
            }//end if
            //si le BDD n'existe pas
            else {
                echo "Database not found";
            }//end else
        ?>
        </div>
        </br>
    </div>
    <div id="Sec_AmisAmis" class="section">
        <h2>Amis de mes Amis</h2>
        <div class="line-1"></div>
        <div class="scroll">
        <?php
            //si le BDD existe, faire le traitement
            if ($db_found) {
                $sql = "SELECT * FROM utilisateur where Mail like '%$email%'";
                $result_sql = mysqli_query($db_handle, $sql);
                $data_sql = mysqli_fetch_assoc($result_sql);

                $IDutilisateur= $data_sql['IDutilisateur'];

                $Amis = "SELECT DISTINCT u2.* FROM utilisateur u1 JOIN relation r1 ON r1.Ami1 = u1.IDutilisateur JOIN relation r2 ON r2.Ami1 = r1.Ami2 JOIN utilisateur u2 ON u2.IDutilisateur = r2.Ami2 WHERE r1.statut = '2' AND r2.statut = '2' AND u1.IDutilisateur = '$IDutilisateur' AND u2.IDutilisateur NOT IN (SELECT r3.Ami2 FROM relation r3 WHERE r3.Ami1 = '$IDutilisateur') AND u2.IDutilisateur != '$IDutilisateur'";
                $Amis_result = mysqli_query($db_handle, $Amis);
                while($Amis_data = mysqli_fetch_assoc($Amis_result)){
                    echo "<div>". "<br></div>";
                    $image = $Amis_data['PhotoProfil'];
                    echo "<a href='Amiami.php'><div class='photoMonAmis'><img src='$image' height='40' width='60'>" . "<br></div></a>";
                    echo  "<div class='amis'>".$Amis_data['Nom'] . "</div>";
                    echo  "<div class='amis'>".$Amis_data['Prenom'] . "</div><br>";
                    echo "<div>". "<br></div>";                        
                    echo "<div class='line-1'>" . "<br></div>";
                    $Amiami = $Amis_data['IDutilisateur'];
                    $_SESSION['Amiami'] = $Amiami;
                }        
            }//end if
                
            //si le BDD n'existe pas
            else {
                echo "Database not found";
            }//end else
        ?>
        </div>
        </br>
    </div>
        </br>

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