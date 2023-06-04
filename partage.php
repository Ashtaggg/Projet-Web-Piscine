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

        if (isset($_POST["IDpostPartage"]) && !(empty($_POST['IDpostPartage']))) {
            $IDpostPartage = isset($_POST['IDpostPartage']) ? $_POST['IDpostPartage'] : "";

            $Amis = "SELECT * FROM relation join utilisateur WHERE Ami1 like '%$IDuser%' and relation.statut='2' and Ami2 = IDutilisateur";
            $Amis_result = mysqli_query($db_handle, $Amis);
            while($Amis_data = mysqli_fetch_assoc($Amis_result)){
                echo "<div>". "<br></div>";
                $image = $Amis_data['PhotoProfil'];
                echo "<div id='mesAmis' data-id='" . $IDuser ."' data-amis='" . $Amis_data['IDutilisateur'] ."' data-post='" . $IDpostPartage ."' onclick=selecAmis(this)><div class='photoMonAmis'><img src='$image' height='40' width='60'>" . "<br></div></a>";
                echo  "<div class='amis'>".$Amis_data['Nom'] . "</div>";
                echo  "<div class='amis'>".$Amis_data['Prenom'] . "</div><br>";
                echo "<div>". "<br></div></div>";
                echo "<div class='line-1'>" . "<br></div>";
            }
        }
        if (isset($_POST["IDuser"]) && !(empty($_POST['IDuser']))) {
            $IDuser = isset($_POST['IDuser']) ? $_POST['IDuser'] : "";
            $IDamis = isset($_POST['IDamis']) ? $_POST['IDamis'] : "";
            $IDpostPartage = isset($_POST['IDpostPartage']) ? $_POST['IDpostPartage'] : "";

            $Date = new DateTime("now");
            $Date->modify("+2 hours");
            $Date = $Date->format('Y-m-d H:i:s');

            $ID = "SELECT * FROM message ORDER BY Date DESC LIMIT 1;"; 
            $ID_result = mysqli_query($db_handle, $ID);
            $data = mysqli_fetch_assoc($ID_result);
            $IDmessage = $data["IDmessage"] + 1;

            $sql = "INSERT INTO `message`(`IDmessage`, `Envoyeur`, `Recepteur`, `Date`, `Contenu`, `Data`, `Statut`) VALUES('$IDmessage', '$IDuser', '$IDamis', '$Date', '', '$IDpostPartage', '0')";
            $result = mysqli_query($db_handle, $sql);

            echo"ujvbnli";
        }

    ?>
</body>
</html>