<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Mon Espace ECE In</title>
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
    <script>
        function limitWords() {
            var textarea = document.getElementById("myTextarea");
            var words = textarea.value.trim().split(/\s+/); // Divise le contenu en mots
            var maxWords = 250; // Limite maximale de mots
      
            if (words.length > maxWords) {
                // Si le nombre de mots dépasse la limite
                alert("La limite maximale de mots est de " + maxWords);
                textarea.value = words.slice(0, maxWords).join(" "); // Réduit le texte aux premiers mots
            }
        }
  </script>


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
                $result_sql = mysqli_query($db_handle, $sql);
                while ($data_sql = mysqli_fetch_assoc($result_sql)) {
                    $IDutilisateur= $data_sql['IDutilisateur'];
                    $Amis = "SELECT * FROM relation join utilisateur WHERE Ami1 like '%$IDutilisateur%' AND Ami2 like '3'";
                    $Amis_result = mysqli_query($db_handle, $Amis);
                    while($Amis_data = mysqli_fetch_assoc($Amis_result)){
                        echo  $Amis_data['Ami2'] . "<br>";
                        echo  $Amis_data['Prenom'] . "<br>";
                        //$image = $data['PhotoProfil'];
                        //echo "<div class='photoAmis'><img src='$image' height='60' width='80'>" . "<br><br></div>";
                    }//end while
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
            <a href="connexion.php"><button>Se déconnecter</button></a>
        </div>
        <br><br>
        <button class='bouton' onclick="openProf()">Modifier mon profil</button>
        <div id="modification" class="modification">
            <div class="form-container">
                <h2>Modifier mon profil</h2>
                <a href="vous.php">
                   <button class="quitterFormation"><ion-icon name="close-outline"></ion-icon></button>
                </a><br>
                <form method="post">
                    <style>
                        .texte-reduit {
                        font-size: 10px;
                        }
                    </style>
                    <p class="texte-reduit">Si vous ne souhaitez pas modifier un paramètre, laissez le vide</br></p>
                    <p>Changer ma photo de profil : <input type="file" name="Data" required></br></p>
                    <p>Nom : <input type="text" name="Nom" required></br></p>
                    <p>Prenom : <input type="text" name="Prenom" required></br></p>
                    <p>Mon adresse : <input type="text" name="Adresse" required></br></p>
                    <br><br><br><br><br><br><br>
                    <input type="submit" value="Valider" name=PosterChangement>
                </form>
                <?php
                    if ($db_found) {
                        if (isset($_POST["PosterChangement"]) && !(empty($_POST['PosterChangement']))) {
                            echo "test";
                            $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                            $IDuser_result = mysqli_query($db_handle, $IDuser);
                            $IDuser_data = mysqli_fetch_assoc($IDuser_result);
                            $IDuser2 = $IDuser_data["IDutilisateur"];
        
                            $Data = isset($_POST["Data"]) ? $_POST["Data"] : "";
                            $Data = "images/" . $Data;
                            //echo $Data;

                            $Nom = isset($_POST["Nom"]) ? $_POST["Nom"] : "";
                            $Prenom = isset($_POST["Prenom"]) ? $_POST["Prenom"] : "";
                            $Adresse = isset($_POST["Adresse"]) ? $_POST["Adresse"] : "";

                            $sql = "UPDATE utilisateur SET Prenom = '$Prenom' where IDutilisateur = {$IDuser2}";
                            $result = mysqli_query($db_handle, $sql);

                            $sql2 = "UPDATE utilisateur SET Nom = '$Nom' where IDutilisateur = {$IDuser2}";
                            $sql2_result = mysqli_query($db_handle, $sql2);

                            $sql3 = "UPDATE utilisateur SET Adresse = '$Adresse' where IDutilisateur = {$IDuser2}";
                            $sql3_result = mysqli_query($db_handle, $sql3);

                            $sql4 = "UPDATE utilisateur SET PhotoProfil = '$Data' where IDutilisateur = {$IDuser2}";
                            $sql3_result = mysqli_query($db_handle, $sql4);
                        }
                        
                    }
                ?>
            </div>
        </div>
        <script>
        function openProf() {
            var modification = document.getElementById("modification");
            modification.style.display = "block";
        }
        </script>
    </div>

    <div id="Formation">  
        <div style="text-align: center;">
            <h2>Formations</h2>
        </div>
        <button class="plusFormation" onclick="openForm()"><ion-icon name="add-circle-outline"></ion-icon></button>

        <?php
            //si le BDD existe, faire le traitement
            if ($db_found) {
                $sql = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                $result = mysqli_query($db_handle, $sql);
                $data = mysqli_fetch_assoc($result);
                $IDutilisateur= $data['IDutilisateur']; 

                $sql2 = "SELECT * FROM utilisateur JOIN formation WHERE $IDutilisateur = utilisateur.IDutilisateur AND $IDutilisateur = formation.IDutilisateur"; 
                $result2 = mysqli_query($db_handle, $sql2);
                while ($data2 = mysqli_fetch_assoc($result2)) {
                    echo "<div class='affichageFormation'>Ecole: " . $data2['NomEcole'] . "<br>";
                    echo "Diplome: " . $data2['Diplome'] . "<br>";
                    echo "Date de début: " . $data2['DateDebut'] . "<br>";
                    echo "Date de fin: " . $data2['DateFin'] . "<br>";
                    echo "Lieu: " . $data2['Lieu'] . "<br>";
                    echo "Domaine: " . $data2['Domaine'] . "<br>";
                    echo "Description: " . $data2['Description'] . "<br></div>";
                    echo "<div> "."<br> </div>";
                }
            }//end if
            //si le BDD n'existe pas
            else {
                echo "Database not found";
            }//end else
        ?>

        
  
        <div id="overlay" class="overlay">
            <div class="form-container">
                <h2>Ajouter une formation</h2>
                <a href="vous.php">
                    <button class="quitterFormation"><ion-icon name="close-outline"></ion-icon></button>
                </a><br>
                <form method=post>
                <style>
                    .texte-reduit {
                        font-size: 10px;
                    }
                </style>
                <p class="texte-reduit">*indique un champ obligatoire </br></p>
                <label for="ecole">Ecole* </label></br>
                <input type="text" id="ecole" name="ecole" placeholder="Ex: Université Paris V" required><br><br>
                <label for="diplome">Diplôme</label></br>
                <input type="text" id="diplome" name="diplome" placeholder="Ex: Licence"><br><br>
                <label for="domaine">Domaine d'études</label></br>
                <input type="text" id="domaine" name="domaine" placeholder="Ex: Economie"><br><br>
                <label for="lieu">Lieu</label></br>
                <input type="text" id="lieu" name="lieu" placeholder="Ex: France"><br><br>
                                
                <label for="dateDeb">Date de début*</label><br>
                <input type="date" id="dateDeb" name="dateDeb" min="1900-01-01" max="2023-12-31" style="margin-left: 15%;" required placeholder="jj/mm/aaaa"><br>

                
                <label for="dateFin">Date de fin (ou prévue)*</label><br>
                <input type="date" id="dateFin" name="dateFin" min="1900-01-01" max="2099-12-31" style="margin-left: 15%;" required placeholder="jj/mm/aaaa"><br><br>

       
                <label for="descriptif">Descriptif</label><br>
                <textarea id="myTextarea" name="descriptif" rows="4" cols="33" oninput="limitWords()"></textarea>
            
                <br><br>         
                <input type="submit" value="Envoyer" name="PosterFormation">

                <br><br>
                </form>

            </div>
        </div>
  
        <script>
            function openForm() {
                var overlay = document.getElementById("overlay");
                overlay.style.display = "block";
            }
        </script>

        <?php
            if ($db_found) {     
                if (isset($_POST["PosterFormation"]) && !(empty($_POST['PosterFormation']))) {

                    $ID = "SELECT * FROM formation ORDER BY DateDebut DESC LIMIT 1;"; 
                    $ID_result = mysqli_query($db_handle, $ID);
                    $data = mysqli_fetch_assoc($ID_result);
                    $IDformation = $data["IDformation"] + 1;

                    $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
                    $IDuser_result = mysqli_query($db_handle, $IDuser);
                    $IDuser_data = mysqli_fetch_assoc($IDuser_result);
                    $IDuser2 = $IDuser_data["IDutilisateur"];

                    $Ecole = isset($_POST["ecole"]) ? $_POST["ecole"] : "";
                    $Diplome = isset($_POST["diplome"]) ? $_POST["diplome"] : "";
                    $Domaine = isset($_POST["domaine"]) ? $_POST["domaine"] : "";
                    $Lieu = isset($_POST["lieu"]) ? $_POST["lieu"] : "";
                    $DateDeb = isset($_POST["dateDeb"]) ? $_POST["dateDeb"] : "";
                    $DateFin = isset($_POST["dateFin"]) ? $_POST["dateFin"] : "";
                    $Descriptif = isset($_POST["descriptif"]) ? $_POST["descriptif"] : "";


                    $sql = "INSERT INTO `formation`(`IDformation`, `IDutilisateur`, `NomEcole`, `Diplome`, `Type`, `DateDebut`, `DateFin`, `Lieu`, `Poste`, `Domaine`, `Description`) VALUES ('$IDformation', '$IDuser2', '$Ecole', '$Diplome', '', '$DateDeb', '$DateFin', '$Lieu', '', '$Domaine', '$Descriptif')";
                    $result = mysqli_query($db_handle, $sql);

                }
                        
            }
        ?>

    </div>


    <div id="Projet">
        <h2>Projets</h2>
        <button class="plusProjet" onclick="openFormulaire()"><ion-icon name="add-circle-outline"></ion-icon></button>
  
        <div id="overlay2" class="overlay2">
            <div class="form-container">
                <h2>Ajouter un projet</h2>
                <a href="vous.php">
                    <button class="quitterProjet"><ion-icon name="close-outline"></ion-icon></button>
                </a><br>
                <form method=post>
                    <style>
                        .texte-reduit {
                            font-size: 10px;
                        }
                    </style>
                    <p class="texte-reduit">*indique un champ obligatoire </br></p>
                    <label for="ecole">Ecole* </label></br>
                    <input type="text" id="ecole" name="ecole" placeholder="Ex: Université Paris V" required><br><br>
                <form>
                <style>
                    .texte-reduit {
                        font-size: 10px;
                    }
                </style>
                <p class="texte-reduit">*indique un champ obligatoire </br></p>
                <label for="entreprise">Nom de l'entreprise/de l'école* </label></br>
                <input type="text" id="entreprise" name="entreprise" placeholder="Ex: Omnes Education" required><br><br>

                <label for="lieu">lieu </label></br>
                <input type="text" id="lieu" name="lieu" placeholder="Ex: San Francisco"><br><br>
                
                <label for="dateDeb">Date de début</label><br>
                <input type="month" id="dateDeb" name="dateDeb" min="1900" max="2023" style="margin-left: 15%;" required placeholder="année"><br>
                
                <label for="dateFin">Date de fin (ou prévue)</label><br>
                <input type="month" id="dateFin" name="dateFin" min="1900" max="2099" style="margin-left: 15%;" required placeholder="année"><br><br>
                
                <label for="descriptif">Description</label><br>
                <textarea id="myTextarea" rows="4" cols="33" oninput="limitWords()"></textarea>
            
                    <br><br>         
                    <input type="submit" value="Envoyer" name=poster>

                    <br><br>
                </form>

            </div>
        </div>
        <script>
            function openFormulaire() {
                var overlay2 = document.getElementById("overlay2");
                overlay2.style.display = "block";
            }
        </script>
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
                    $Moi = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'";
                    $Moi_result = mysqli_query($db_handle, $Moi);
                    while($Moi_data = mysqli_fetch_assoc($Moi_result))
                    {
                        $Envoyeur = "SELECT * FROM post WHERE Envoyeur LIKE '%$Moi_data[IDutilisateur]%' ORDER BY Date DESC";
                        $Envoyeur_result = mysqli_query($db_handle, $Envoyeur);
                        while($Envoyeur_data = mysqli_fetch_assoc($Envoyeur_result))
                        {
                            $Date1 = new DateTime("now");
                            $Date1->modify("+2 hours");
                            $Date1 = $Date1->format('Y-m-d H:i:s');
                            $Date1 = strtotime($Date1);
                            $Date2 = strtotime($Envoyeur_data["Date"]);
                            $DateDiff = $Date1 - $Date2;
                            $DateDiff = $DateDiff/86400;
                    
                            echo"<div class='post'><p class='PhotoProfil'><br><br><img height=75 src='" . $Moi_data["PhotoProfil"] . "' /></p>";
                            echo"<p class='Nom'>" . $Moi_data["Prenom"] . " " . $Moi_data["Nom"] . "</p>";
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
                            echo"<p class='Legende'>" . $Envoyeur_data["Legende"] . "</p>";
                            echo"<p class='Data'><img height=250 src='" . $Envoyeur_data["Data"] . "' /></p></div>";
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
