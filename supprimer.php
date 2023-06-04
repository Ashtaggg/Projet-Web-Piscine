<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="admin.js"></script>
    <title>Supprimer</title>
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
    <h2>Supprimer un compte ECE In</h2>
    <?php
        if ($db_found) {
            if (isset($_POST["IDuser"]) && !(empty($_POST['IDuser']))) {
                $IDuser = isset($_POST["IDuser"]) ? $_POST["IDuser"] : "";
                echo'<div id="overlay3" class="overlay3" style="display: block;">';
                echo'<div class="supprimer-container">';
                echo'<h2>Voulez vous supprimer ce compte ECE In ?</h2>';
                echo'</br><button class="supprimerOui" data-id="' . $IDuser .'" onclick=supprimer_oui(this)>Oui</button>';
                echo'<button class="supprimerNon" data-id="' . $IDuser .'" onclick=supprimer_non(this)>Non</button>';
                echo'</div>';
                echo'</div>';
            }
            if (isset($_POST["IDsuppr"]) && !(empty($_POST['IDsuppr']))) {
                $IDsuppr = isset($_POST["IDsuppr"]) ? $_POST["IDsuppr"] : "";

                $sql = "DELETE FROM utilisateur WHERE IDutilisateur = $IDsuppr;";
                $result = mysqli_query($db_handle, $sql);
            }
        }



        $sql = "SELECT * FROM utilisateur ORDER BY IDutilisateur ASC;"; 
        $sql_result = mysqli_query($db_handle, $sql);
        while($sql_data = mysqli_fetch_assoc($sql_result)){
            echo "<div class='line-1'></div>";
            echo"<div id='userSupprimer' data-id='" . $sql_data['IDutilisateur'] ."' onclick=validerSupprimer(this)><br>" . $sql_data['Nom']. "<br>";
            echo $sql_data['Prenom'] . "<br><br>";
            $image = $sql_data['PhotoProfil'];
            echo "<div class='photoSupprimer'><img src='$image' height='40' width='60'>" . "<br></div></div>";
        }
    ?>
</body>
</html>