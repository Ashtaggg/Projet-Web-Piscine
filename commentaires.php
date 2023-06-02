<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="accueil.js"></script>
    <title>Commentaires</title>
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
            var maxWords = 100; // Limite maximale de mots
      
            if (words.length > maxWords) {
                // Si le nombre de mots dépasse la limite
                //alert("La limite maximale de mots est de " + maxWords);
                textarea.value = words.slice(0, maxWords).join(" "); // Réduit le texte aux premiers mots
            }
        }
  </script>
</head>
<body>
    <?php
        $IDuser = "SELECT * FROM utilisateur WHERE Mail LIKE '%$email%'"; 
        $IDuser_result = mysqli_query($db_handle, $IDuser);
        $data = mysqli_fetch_assoc($IDuser_result);
        $IDuser = $data['IDutilisateur'];

        if (isset($_POST["ContenuCom"]) && !(empty($_POST['ContenuCom']))) {
            $ContenuCom = isset($_POST['ContenuCom']) ? $_POST['ContenuCom'] : "";
            $IDpostCom = isset($_POST['IDpostCom']) ? $_POST['IDpostCom'] : "";
            $NbrCom = isset($_POST['NbrCom']) ? $_POST['NbrCom'] : "";

            $Date1 = new DateTime("now");
            $Date1->modify("+2 hours");
            $Date1 = $Date1->format('Y-m-d H:i:s');

            $ID = "SELECT * FROM commentaire ORDER BY IDcommentaire DESC LIMIT 1;"; 
            $ID_result = mysqli_query($db_handle, $ID);
            $data = mysqli_fetch_assoc($ID_result);
            $IDcommentaire = $data["IDcommentaire"] + 1;
            
            $sql = "INSERT INTO `commentaire`(`IDcommentaire`, `Envoyeur`, `IDpost`, `Date`, `Contenu`) VALUES('$IDcommentaire', '$IDuser', '$IDpostCom', '$Date1', '$ContenuCom')";
            $result = mysqli_query($db_handle, $sql);

            $sql = "UPDATE post SET Commentaires = $NbrCom WHERE IDpost = {$IDpostCom}";
            $result2 = mysqli_query($db_handle, $sql);
        }
       
        if (isset($_POST["IDpostCom"]) && !(empty($_POST['IDpostCom']))) {
            $IDpostCom = isset($_POST['IDpostCom']) ? $_POST['IDpostCom'] : "";

            $post = "SELECT * FROM post WHERE IDpost = $IDpostCom";
            $post_result = mysqli_query($db_handle,$post);
            $post_data = mysqli_fetch_assoc($post_result);
            
            $sql = "SELECT * FROM commentaire WHERE IDpost LIKE '%$IDpostCom%' ORDER BY Date ASC"; 
            $result = mysqli_query($db_handle, $sql);
            echo"<div class='afficherCom'>";
            while ($com_data = mysqli_fetch_assoc($result)) {
                $IDutilisateur = $com_data["Envoyeur"];
                $utilisateur = "SELECT * FROM utilisateur WHERE IDutilisateur LIKE '%$IDutilisateur%'";                    $utilisateur_result = mysqli_query($db_handle,$utilisateur);
                while($utilisateur_data = mysqli_fetch_assoc($utilisateur_result))
                {
                    $Date1 = new DateTime("now");
                    $Date1->modify("+2 hours");
                    $Date1 = $Date1->format('Y-m-d H:i:s');
                    $Date1 = strtotime($Date1);
                    $Date2 = strtotime($com_data["Date"]);
                    $DateDiff = $Date1 - $Date2;
                    $DateDiff = $DateDiff/86400;

                    if($IDuser == $com_data["Envoyeur"]){
                        echo"<div class='comUser'><p class='PhotoProfilCom'><br><br><img height=20 src='" . $utilisateur_data["PhotoProfil"] . "' /></p>";
                        echo"<p class='NomCom'>" . $utilisateur_data["Prenom"] . " " . $utilisateur_data["Nom"] . "</p>";
                        if($DateDiff >=1){
                            $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                            echo"<p class='DateCom'>" . $DateDiff . " j</p>";
                        }
                        else if($DateDiff * 24 >=1){
                            $DateDiff = $DateDiff * 24;
                            $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                            echo"<p class='DateCom'>" . $DateDiff . " h</p>";
                        }
                        else if($DateDiff * 24 * 60 >=1){
                            $DateDiff = $DateDiff * 24 * 60;
                            $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                            echo"<p class='DateCom'>" . $DateDiff . " min</p>";
                        }
                        else{
                            $DateDiff = $DateDiff * 24 * 60 * 60;
                            $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                            echo"<p class='DateCom'>" . $DateDiff . " sec</p>";
                        }
                        echo"<p class='ContenuCom'>" . $com_data["Contenu"] . "</p>";
                        echo"</div>";
                    }
                    else{
                        echo"<div class='com'><p class='PhotoProfilCom'><br><br><img height=20 src='" . $utilisateur_data["PhotoProfil"] . "' /></p>";
                        echo"<p class='NomCom'>" . $utilisateur_data["Prenom"] . " " . $utilisateur_data["Nom"] . "</p>";
                        if($DateDiff >=1){
                            $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                            echo"<p class='DateCom'>" . $DateDiff . " j</p>";
                        }
                        else if($DateDiff * 24 >=1){
                            $DateDiff = $DateDiff * 24;
                            $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                            echo"<p class='DateCom'>" . $DateDiff . " h</p>";
                        }
                        else if($DateDiff * 24 * 60 >=1){
                            $DateDiff = $DateDiff * 24 * 60;
                            $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                            echo"<p class='DateCom'>" . $DateDiff . " min</p>";
                        }
                        else{
                            $DateDiff = $DateDiff * 24 * 60 * 60;
                            $DateDiff = round($DateDiff, 0, PHP_ROUND_HALF_DOWN);
                            echo"<p class='DateCom'>" . $DateDiff . " sec</p>";
                        }
                        echo"<p class='ContenuCom'>" . $com_data["Contenu"] . "</p>";
                        echo"</div>";
                    }
                }
            }
            echo"</div>";
            echo"<div class='posterCom'>";
            echo"<label for='descriptif'>Descriptif</label><br>";
            echo"<textarea id='contenuCom' rows='4' cols='33' oninput='limitWords()'></textarea>";
            echo"<button class='boutonCom' id='" . $IDpostCom . "' data-com='" . $post_data['Commentaires'] ."' onclick=com_poster(this)>Poster</button>";
            echo"</div>";
        } 
    ?>
</body>
</html>