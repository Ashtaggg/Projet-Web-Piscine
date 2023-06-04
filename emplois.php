<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Emplois ECE In</title>
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
    <nav class="navigation"> <!-- bare de navigation -->
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
                <li><a class="oncolor" href="reseau.php">Mon réseau</a></li>
                <li><a class="oncolor" href="vous.php">Vous</a></li>
                <li><a class="oncolor" href="notifications.php">Notifications</a></li>
                <li><a class="oncolor" href="messagerie.php">Messagerie</a></li>
                <li><a class="oncolor" href="emplois.php" style="color : #037078">Emplois</a></li>
            </ul>
        </div>
    </nav>
    <div id="Gray_bar"></div>
    <div id="Info_Right">
        <h3>Jobs auxquels vous avez postulé :</h3>
        <div class='ajoutEmplois'>
            <form method="post">    <!-- formulaire pour postuler à un emplois -->
                <label for="choix">Choisir un job </label></br>
                <input type="text" id="job" name="job" placeholder="1" required><br><br>
                <input type="submit" value="Envoyer" name="PosterEmplois">
            </form>
            <?php
                if($db_found){
                    if (isset($_POST["PosterEmplois"]) && !(empty($_POST['PosterEmplois']))) {
                        //on récupère le numero entré dans le formulaire et on lui associe la valeur IDemplois
                        //dans la table emplois de la bdd pour avoir toutes les autres infos sur l'emplois (type, nom, salaire, etc)
                        $IDemplois= isset($_POST["job"]) ? $_POST["job"] : "";
                        $Emplois= "SELECT * FROM emplois WHERE IDemplois = $IDemplois"; 
                        $Emplois_result = mysqli_query($db_handle, $Emplois);
                        $Emplois_data = mysqli_fetch_assoc($Emplois_result);
                    }       
                }
            ?>
            <div class="line-1"></div>
            <div id="stage">
                <h4> Stages </h4>
                <?php
                    if ($db_found) {
                        if (isset($_POST["PosterEmplois"]) && !(empty($_POST['PosterEmplois']))) {
                            //si c'est un stage
                            if($Emplois_data['Type'] == 'Stage')
                            {
                                $IDemplois = $Emplois_data['IDemplois'];
                                $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                                $IDuser_result = mysqli_query($db_handle, $IDuser);
                                $data2 = mysqli_fetch_assoc($IDuser_result);
                                $Envoyeur = $data2['IDutilisateur'];



                                // on vérifie si l'utilisateur a déjà postulé
                                $query = "SELECT * FROM postulant WHERE IDemplois = '$IDemplois' AND IDutilisateur = '$Envoyeur'";
                                $result = mysqli_query($db_handle, $query);

                                if (mysqli_num_rows($result) == 0) {
                                // l'utilisateur n'a pas encore postulé, on peut insérer une nouvelle ligne dans la table "Postulants"
                                $sql = "INSERT INTO `postulant` (`IDpostulant`, `IDemplois`, `IDutilisateur`) VALUES ('', '$IDemplois', '$Envoyeur')";
                                $result = mysqli_query($db_handle, $sql);
                                } else {
                                // l'utilisateur a déjà postulé, on afficher un message d'erreur
                                    echo "<script>alert('Vous avez déjà postulé pour cet emploi.');</script>";
                                }
                            }
                        } 
                        $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                        $IDuser_result = mysqli_query($db_handle, $IDuser);
                        $data2 = mysqli_fetch_assoc($IDuser_result);
                        $Envoyeur = $data2['IDutilisateur'];

                        //on joint les tables utilisateur et postulant pour que l'IDutilisateur soit le même dans les 2 tables (celui de la personne connectée)
                        $sql1 = "SELECT * FROM utilisateur JOIN postulant WHERE utilisateur.IDutilisateur LIKE '%$Envoyeur%' AND postulant.IDutilisateur LIKE '%$Envoyeur%'";
                        $IDuser_result1 = mysqli_query($db_handle, $sql1);
                        while ($data3 = mysqli_fetch_assoc($IDuser_result1)){
                            $test = $data3['IDemplois'];
                            
                            //on joint les tables emplois et postulant pour que l'IDemplois soit le même pour que l'emplois séléctionné soit attribué au bon utilisateur
                            $sql2 = "SELECT * FROM emplois JOIN postulant WHERE emplois.IDemplois LIKE '%$test%' AND postulant.IDutilisateur LIKE '%$Envoyeur%'";
                            $IDuser_test = mysqli_query($db_handle, $sql2);
                            $data_test = mysqli_fetch_assoc($IDuser_test);
                            
                            //si le type d'emplois est un stage alors on affiche le nom de l'entreprise et le poste qu'elle propose
                            if ($data_test['Type'] == 'Stage'){
                                echo $data_test['NomEntreprise'] . "<br>";
                                echo $data_test['Poste']. "<br><br>";
                            }
                        }
                        
                    }
                ?>
                <div class="line-1"></div>
            </div>
            <div id="CDD">
                <h4> CDD </h4>
                <?php
                    //ce code fonctionne de la même manière que pour les stages
                    if ($db_found) {
                        if (isset($_POST["PosterEmplois"]) && !(empty($_POST['PosterEmplois']))) {
                            if($Emplois_data['Type'] == 'CDD')
                            {
                                $IDemplois = $Emplois_data['IDemplois'];
                                $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                                $IDuser_result = mysqli_query($db_handle, $IDuser);
                                $data2 = mysqli_fetch_assoc($IDuser_result);
                                $Envoyeur = $data2['IDutilisateur'];


                                $query = "SELECT * FROM postulant WHERE IDemplois = '$IDemplois' AND IDutilisateur = '$Envoyeur'";
                                $result = mysqli_query($db_handle, $query);

                                if (mysqli_num_rows($result) == 0) {
                                $sql = "INSERT INTO `postulant` (`IDpostulant`, `IDemplois`, `IDutilisateur`) VALUES ('', '$IDemplois', '$Envoyeur')";
                                $result = mysqli_query($db_handle, $sql);
                                } else {
                                    echo "<script>alert('Vous avez déjà postulé pour cet emploi.');</script>";
                                }
                            }
                        } 
                        $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                        $IDuser_result = mysqli_query($db_handle, $IDuser);
                        $data2 = mysqli_fetch_assoc($IDuser_result);
                        $Envoyeur = $data2['IDutilisateur'];

                        $sql1 = "SELECT * FROM utilisateur JOIN postulant WHERE utilisateur.IDutilisateur LIKE '%$Envoyeur%' AND postulant.IDutilisateur LIKE '%$Envoyeur%'";
                        $IDuser_result1 = mysqli_query($db_handle, $sql1);
                        while ($data3 = mysqli_fetch_assoc($IDuser_result1)){
                            $test = $data3['IDemplois'];
                        
                            $sql2 = "SELECT * FROM emplois JOIN postulant WHERE emplois.IDemplois LIKE '%$test%' AND postulant.IDutilisateur LIKE '%$Envoyeur%'";
                            $IDuser_test = mysqli_query($db_handle, $sql2);
                            $data_test = mysqli_fetch_assoc($IDuser_test);

                            if ($data_test['Type'] == 'CDD'){
                                echo $data_test['NomEntreprise'] . "<br>";
                                echo $data_test['Poste']. "<br><br>";
                            }
                        }
                        
                    }
                ?>
                <div class="line-1"></div>
            </div>
            <div id="CDI">
                <h4> CDI </h4>
                <?php
                //ce code fonctionne de la même manière que pour les stages et les CDD
                    if ($db_found) {
                        if (isset($_POST["PosterEmplois"]) && !(empty($_POST['PosterEmplois']))) {
                            if($Emplois_data['Type'] == 'CDI')
                            {
                                $IDemplois = $Emplois_data['IDemplois'];
                                $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                                $IDuser_result = mysqli_query($db_handle, $IDuser);
                                $data2 = mysqli_fetch_assoc($IDuser_result);
                                $Envoyeur = $data2['IDutilisateur'];

                                $query = "SELECT * FROM postulant WHERE IDemplois = '$IDemplois' AND IDutilisateur = '$Envoyeur'";
                                $result = mysqli_query($db_handle, $query);

                                if (mysqli_num_rows($result) == 0) {
                                $sql = "INSERT INTO `postulant` (`IDpostulant`, `IDemplois`, `IDutilisateur`) VALUES ('', '$IDemplois', '$Envoyeur')";
                                $result = mysqli_query($db_handle, $sql);
                                } else {
                                    echo "<script>alert('Vous avez déjà postulé pour cet emploi.');</script>";
                                }
                            }
                        } 
                        $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                        $IDuser_result = mysqli_query($db_handle, $IDuser);
                        $data2 = mysqli_fetch_assoc($IDuser_result);
                        $Envoyeur = $data2['IDutilisateur'];

                        $sql1 = "SELECT * FROM utilisateur JOIN postulant WHERE utilisateur.IDutilisateur LIKE '%$Envoyeur%' AND postulant.IDutilisateur LIKE '%$Envoyeur%'";
                        $IDuser_result1 = mysqli_query($db_handle, $sql1);
                        while ($data3 = mysqli_fetch_assoc($IDuser_result1)){
                            $test = $data3['IDemplois'];
                        
                            $sql2 = "SELECT * FROM emplois JOIN postulant WHERE emplois.IDemplois LIKE '%$test%' AND postulant.IDutilisateur LIKE '%$Envoyeur%'";
                            $IDuser_test = mysqli_query($db_handle, $sql2);
                            $data_test = mysqli_fetch_assoc($IDuser_test);

                            if ($data_test['Type'] == 'CDI'){
                                echo $data_test['NomEntreprise'] . "<br>";
                                echo $data_test['Poste']. "<br><br>";
                            }
                        }
                        
                    }
                ?>
                <div class="line-1"></div>
            </div>

            <div id="apprentissage">
                <h4> Apprentissages </h4>
                <?php
                //ce code fonctionne de la même manière que les stages, cdd et cdi
                    if ($db_found) {
                        if (isset($_POST["PosterEmplois"]) && !(empty($_POST['PosterEmplois']))) {
                            if($Emplois_data['Type'] == 'Apprentissage')
                            {
                                $IDemplois = $Emplois_data['IDemplois'];
                                $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                                $IDuser_result = mysqli_query($db_handle, $IDuser);
                                $data2 = mysqli_fetch_assoc($IDuser_result);
                                $Envoyeur = $data2['IDutilisateur'];

                                $query = "SELECT * FROM postulant WHERE IDemplois = '$IDemplois' AND IDutilisateur = '$Envoyeur'";
                                $result = mysqli_query($db_handle, $query);

                                if (mysqli_num_rows($result) == 0) {
                                $sql = "INSERT INTO `postulant` (`IDpostulant`, `IDemplois`, `IDutilisateur`) VALUES ('', '$IDemplois', '$Envoyeur')";
                                $result = mysqli_query($db_handle, $sql);
                                } else {
                                    echo "<script>alert('Vous avez déjà postulé pour cet emploi.');</script>";
                                }
                            }
                        } 
                        $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                        $IDuser_result = mysqli_query($db_handle, $IDuser);
                        $data2 = mysqli_fetch_assoc($IDuser_result);
                        $Envoyeur = $data2['IDutilisateur'];

                        $sql1 = "SELECT * FROM utilisateur JOIN postulant WHERE utilisateur.IDutilisateur LIKE '%$Envoyeur%' AND postulant.IDutilisateur LIKE '%$Envoyeur%'";
                        $IDuser_result1 = mysqli_query($db_handle, $sql1);
                        while ($data3 = mysqli_fetch_assoc($IDuser_result1)){
                            $test = $data3['IDemplois'];
                        
                            $sql2 = "SELECT * FROM emplois JOIN postulant WHERE emplois.IDemplois LIKE '%$test%' AND postulant.IDutilisateur LIKE '%$Envoyeur%'";
                            $IDuser_test = mysqli_query($db_handle, $sql2);
                            $data_test = mysqli_fetch_assoc($IDuser_test);

                            if ($data_test['Type'] == 'Apprentissage'){
                                echo $data_test['NomEntreprise'] . "<br>";
                                echo $data_test['Poste']. "<br><br>";
                            }
                        }
                        
                    }
                ?>
                <div class="line-1"></div>
            </div>

        </div>
    </div>
    <div id="Emplois">
        <div style="text-align: center;">
            <h2>Emplois disponibles</h2>
        </div>
        
        <div class="scroll">
            <?php
            //si le BDD existe
            if ($db_found) {
                //on affiche certaines valeurs de la table emplois pour pouvoir voir les emplois auxquels l'utilisateur peut postuler
                $sql2 = "SELECT * FROM emplois";
                $result2 = mysqli_query($db_handle, $sql2);
                while ($data2 = mysqli_fetch_assoc($result2)) {
                    echo "<div class='affichageFormation'>Entreprise: " . $data2['NomEntreprise'];
                    echo "<div style='display: inline-block; margin-left: 500px;'>" . $data2['IDemplois'] . "</div><br>";
                    echo "Poste: " . $data2['Poste'] . "<br>";
                    echo "Type: " . $data2['Type'] . "<br>";
                    echo "Salaire (mensuel): " . $data2['Salaire'] . " €<br>";
                    echo "Date de début: " . $data2['DateDebut'] . "<br>";
                    echo "Date de fin: " . $data2['DateFin'] . "<br></div>";
                    echo "<div> "."<br> </div>";

                }
            }//end if
            //si le BDD n'existe pas
            else {
                echo "Database not found";
            }//end else

            
            ?>
        
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