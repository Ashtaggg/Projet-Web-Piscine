<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Messagerie</title>
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
    <?php
        if (isset($_POST["IDenv"]) && !(empty($_POST['IDenv']))) {
            $IDenvoyeur = isset($_POST['IDenv']) ? $_POST['IDenv'] : "";
            $IDrecep = isset($_POST['IDrecep']) ? $_POST['IDrecep'] : "";
            $Contenu = isset($_POST['Contenu']) ? $_POST['Contenu'] : "";
            $IDutilisateur = isset($_POST['IDutilisateur']) ? $_POST['IDutilisateur'] : "";

            $ID = "SELECT * FROM message ORDER BY Date DESC LIMIT 1;"; 
            $ID_result = mysqli_query($db_handle, $ID);
            $data = mysqli_fetch_assoc($ID_result);
            $IDmessage = $data["IDmessage"] + 1;

            $Date = new DateTime("now");
            $Date->modify("+2 hours");
            $Date = $Date->format('Y-m-d H:i:s');

            $sql = "INSERT INTO `message`(`IDmessage`, `Envoyeur`, `Recepteur`, `Date`, `Contenu`, `Data`, `Statut`) VALUES('$IDmessage', '$IDenvoyeur', '$IDrecep', '$Date', '$Contenu', '', '0')";
            $result = mysqli_query($db_handle, $sql);

            echo"CA MARCHE";



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
                        echo "<ion-icon class='icon_me' name='checkmark-outline'></ion-icon><br>";
                    }
                    else{
                        echo "<ion-icon class='icon_me' name='checkmark-done-outline'></ion-icon><br>";
                    }

                    //echo "Test moi    env : " . $IDenvoyeur_mess . "    rec : " . $IDrecepteur_mess . "    statut : " . $Statut_mess . "<br>";
                }
                else{
                    echo"<p class='message_him'>" . $Contenu_message . "</p><br>";
                    if($Statut_mess==0){
                        $message_update = "UPDATE `message` SET `Statut`= 1 WHERE Envoyeur = $IDenvoyeur_mess AND Recepteur = $IDrecepteur_mess";
                        $message_update_result = mysqli_query($db_handle,$message_update);
                        echo "<ion-icon class='icon_him' name='checkmark-done-outline'></ion-icon><br>";
                    }
                    else{
                        echo "<ion-icon class='icon_him' name='checkmark-done-outline'></ion-icon><br>";
                    }
                    //echo "Test lui    env : " . $IDenvoyeur_mess . "    rec : " . $IDrecepteur_mess . "    statut : " . $Statut_mess . "<br>";
                }
            }
        }
    ?>
</body>
</html>