<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="admin.js"></script>
    <title>Ajouter</title>
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
    <h2>Créer un compte ECE In</h2>
    <div class="line-1"></div></br>
    <script>
        function validerAjouter(element) {
            var Type = document.querySelector('input[name="Type"]:checked').value;
            var Admin = document.querySelector('input[name="Admin"]:checked').value;
            var Nom = document.getElementsByName('Nom')[0].value;
            var Prenom = document.getElementsByName('Prenom')[0].value;
            var DateNaissance = document.getElementsByName('DateNaissance')[0].value;
            var Adresse = document.getElementsByName('Adresse')[0].value;
            var Mail = document.getElementsByName('Mail')[0].value;
            var MotDePasse = document.getElementsByName('MotDePasse')[0].value;
            var PhotoProfilElement = document.getElementById('PhotoProfil');
            var PhotoProfil = PhotoProfilElement.value.split('\\').pop();
            var AnneeEtude = document.getElementsByName('AnneeEtude')[0].value;

            if (Nom === '' || Prenom === '' || DateNaissance === '' || Adresse === '' || Mail === '' || MotDePasse === '' || PhotoProfil === '' || AnneeEtude === '') {
                alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }
            else{
                $.ajax({
                    url: 'ajouter.php',
                    type: 'POST',
                    cache: false,
                    success: function(response) {
                        $('#AdminSection').load('ajouter.php', { CreerCompte: 'oui', Type: Type, Admin: Admin, Nom: Nom, Prenom: Prenom, DateNaissance: DateNaissance, Adresse: Adresse, Mail: Mail, MotDePasse: MotDePasse, PhotoProfil: PhotoProfil, AnneeEtude: AnneeEtude});
                        location.reload();
                    },
                    error: function() {
                        alert('Erreur lors de la requête AJAX');
                    }
                });
            }
        }
    </script>
    <form method="post">
        <fieldset>
            <legend>Type de compte</legend>
            <div>
                <input type="radio" id="Prof" name="Type" value="2">
                <label for="Prof">Prof</label>
            </div>
            <div>
                <input type="radio" id="Etudiant" name="Type" value="3" checked>
                <label for="Etudiant">Etudiant</label>
            </div>
            <div>
                <input type="radio" id="AncienEtudiant" name="Type" value="4">
                <label for="AncienEtudiant">Ancien Etudiant</label>
            </div>
        </fieldset>
        <fieldset>
            <legend>Compte Admin</legend>
            <div>
                <input type="radio" id="Oui" name="Admin" value="1">
                <label for="Oui">Oui</label>
            </div>
            <div>
                <input type="radio" id="Non" name="Admin" value="0" checked>
                <label for="Non">Non</label>
            </div>
        </fieldset>
        <p>Nom : <input type="text" name="Nom" required></br></p>
        <p>Prenom : <input type="text" name="Prenom" required></br></p>
        <p>Date de Naissance : <input type="date" name="DateNaissance" required></br></p>
        <p>Adresse : <input type="text" name="Adresse" required></br></p>
        <p>Mail : <input type="email" name="Mail" required></br></p>
        <p>Mot de Passe : <input type="text" name="MotDePasse" required></br></p>   
        <p>Photo Profil : <input type="file" name="PhotoProfil" id="PhotoProfil" required></br></p>
        <p>Année d'étude : <input type="number" name="AnneeEtude" required></br></p>
        <input  onclick=validerAjouter(this) type="button" value="CreerCompte" name=CreerCompte>
    </form>
    <?php
        if ($db_found) {
            if (isset($_POST["CreerCompte"]) && !(empty($_POST['CreerCompte']))) {
                $ID = "SELECT * FROM utilisateur ORDER BY IDutilisateur DESC LIMIT 1;"; 
                $ID_result = mysqli_query($db_handle, $ID);
                $data = mysqli_fetch_assoc($ID_result);
                $IDutilisateur = $data["IDutilisateur"] + 1;

                $Type = isset($_POST["Type"]) ? $_POST["Type"] : "";
                $Admin = isset($_POST["Admin"]) ? $_POST["Admin"] : "";
                $Nom = isset($_POST["Nom"]) ? $_POST["Nom"] : "";
                $Prenom = isset($_POST["Prenom"]) ? $_POST["Prenom"] : "";
                $DateNaissance = isset($_POST["DateNaissance"]) ? $_POST["DateNaissance"] : "";
                $Adresse = isset($_POST["Adresse"]) ? $_POST["Adresse"] : "";
                $Mail = isset($_POST["Mail"]) ? $_POST["Mail"] : "";
                $MotDePasse = isset($_POST["MotDePasse"]) ? $_POST["MotDePasse"] : "";
                $PhotoProfil = isset($_POST["PhotoProfil"]) ? $_POST["PhotoProfil"] : "";
                $PhotoProfil = "images/" . $PhotoProfil;
                $AnneeEtude = isset($_POST["AnneeEtude"]) ? $_POST["AnneeEtude"] : "";

                $sql = "INSERT INTO `utilisateur`(`IDutilisateur`, `Type`, `Admin`, `Nom`, `Prenom`, `DateNaissance`, `Adresse`, `Mail`, `MotDePasse`, `PhotoProfil`, `AnneeEtude`, `Amis`, `Messages`, `Posts`, `Emplois`, `Descript`, `Humeur`) VALUES('$IDutilisateur', '$Type', '$Admin', '$Nom', '$Prenom', '$DateNaissance', '$Adresse', '$Mail', '$MotDePasse', '$PhotoProfil', '$AnneeEtude', '', '', '', '', '', '')";
                $result = mysqli_query($db_handle, $sql);
            }
        }
    ?>
</body>
</html>