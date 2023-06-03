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
        $Ami2 = isset($_SESSION['Ami2']) ? $_SESSION['Ami2'] : "";
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
    <div id="MonProfil">
        <br><br>
         <?php
            //si le BDD existe, faire le traitement
            if ($db_found) {
                $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                $IDuser_result = mysqli_query($db_handle, $IDuser);
                $IDuser_data = mysqli_fetch_assoc($IDuser_result);
                $IDuser2 = $IDuser_data["IDutilisateur"];

                
                $sql2 ="SELECT * FROM relation join utilisateur WHERE Ami2 LIKE '%$Ami2%' and relation.Ami2 = utilisateur.IDutilisateur and relation.Ami1 like '%$IDuser2%'";
                $sql2_result = mysqli_query($db_handle, $sql2);
                while($data_sql2 = mysqli_fetch_assoc($sql2_result)){
                //affichage du profil de l'ami
                echo $data_sql2['Ami2'];
                echo  $data_sql2['Nom'] . "<br>";
                echo  $data_sql2['Prenom'] . "<br>";
                echo "Adresse: " . $data_sql2['Adresse'] . "<br>";
                echo "Date de naissance: " . $data_sql2['DateNaissance'] ."<br>";
                echo "Humeur: " . $data_sql2['Humeur'] . "<br>";
                $image = $data_sql2['PhotoProfil'];
                echo "<div class='photo_ami2'><img src='$image' height='80' width='100'>" . "</div>";
                }
            }//end if
            //si le BDD n'existe pas
            else {
                echo "Database not found";
            }//end else
        ?>
        <br><br><br>
        </div>

        <div id="Formation2">  
        <div style="text-align: center;">
            <h2>Formations</h2>
        </div>
        <?php
            //si le BDD existe, faire le traitement
            if ($db_found) {
                $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                $IDuser_result = mysqli_query($db_handle, $IDuser);
                $IDuser_data = mysqli_fetch_assoc($IDuser_result);
                $IDuser2 = $IDuser_data["IDutilisateur"];
                
                $sql = "SELECT * FROM relation join utilisateur WHERE relation.Ami1 LIKE '%$IDuser2%' and Ami2 LIKE '%$Ami2%' and IDutilisateur LIKE '%$Ami2%'"; 
                $result_sql = mysqli_query($db_handle, $sql);
                $data_sql = mysqli_fetch_assoc($result_sql);
                $IDutilisateur= $data_sql['IDutilisateur']; 
                echo $IDutilisateur;
                echo $Ami2;
                echo $data_sql['Ami2'];
                
                $sql2 = "SELECT * FROM utilisateur JOIN formation WHERE utilisateur.IDutilisateur LIKE '1'  AND formation.IDutilisateur LIKE '1'"; 
                $result_sql2 = mysqli_query($db_handle, $sql2);
                while($data_sql2 = mysqli_fetch_assoc($result_sql2)){
                    //Affichage des formation de l'ami
                    echo "<div class='affichageFormation'>Ecole: " . $data_sql2['NomEcole'] . "<br>";
                    echo "Diplome: " . $data_sql2['Diplome'] . "<br>";
                    echo "Date de début: " . $data_sql2['DateDebut'] . "<br>";
                    echo "Date de fin: " . $data_sql2['DateFin'] . "<br>";
                    echo "Lieu: " . $data_sql2['Lieu'] . "<br>";
                    echo "Domaine: " . $data_sql2['Domaine'] . "<br>";
                    echo "Description: " . $data_sql2['Description'] . "<br></div>";
                    echo "<div> "."<br> </div>";
                } 
            }//end if
            //si le BDD n'existe pas
            else {
                echo "Database not found";
            }//end else
        ?>
    </div>

    <div id="Projet">
        <div style="text-align: center;">
            <h2>Projets</h2>
        </div>
        <button class="plusProjet" onclick="openFormulaire()"><ion-icon name="add-circle-outline"></ion-icon></button>
        
        <?php
            //si le BDD existe, faire le traitement
            if ($db_found) {
                $sql = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                $result = mysqli_query($db_handle, $sql);
                $data = mysqli_fetch_assoc($result);
                $IDutilisateur= $data['IDutilisateur']; 

                $sql2 = "SELECT * FROM utilisateur JOIN projet WHERE $IDutilisateur = utilisateur.IDutilisateur AND $IDutilisateur = projet.IDutilisateur"; 
                $result2 = mysqli_query($db_handle, $sql2);
                while ($data2 = mysqli_fetch_assoc($result2)) {
                    echo "<div class='affichageFormation'>Ecole: " . $data2['NomEcole'] . "<br>";
                    echo "Nom du projet: " . $data2['NomProjet'] . "<br>";
                    echo "Lieu: " . $data2['Lieu'] . "<br>";
                    echo "Date de début: " . $data2['DateDebut'] . "<br>";
                    echo "Date de fin: " . $data2['DateFin'] . "<br>";
                    echo "Description: " . $data2['Description'] . "<br></div>";
                    echo "<div> "."<br> </div>";
                }
            }//end if
            //si le BDD n'existe pas
            else {
                echo "Database not found";
            }//end else
        ?>
        
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