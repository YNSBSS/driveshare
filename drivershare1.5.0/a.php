<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> </title>
</head>
<body>
    <?php
        // Informations de connexion à la base de données
        $host = "localhost";
        $db_name = "mabase";
        $username = "root";
        $password = "";
        $table_name = "users";

        // Connexion à la base de données avec mysqli
        $conn = new mysqli($host, $username, $password, $db_name);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données: " . $conn->connect_error);
        }

        $error_message = "";
        $success_message = "";
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
           $nom_prenom = $_POST["nom_prenom"];
           $email = $_POST["email"];
           $telephone = $_POST["telephone"];
           $matricule = $_POST["matricule"];
           $mot_de_passe = $_POST["mot_de_passe"];

            if (in_array('', $_POST)) {
                echo "Veuillez remplir tous les champs du formulaire";
            } else {

                if (!preg_match("/^[a-zA-Z\-']+$/", $nom_prenom)) {
                    echo"Champ Nom et Prénom  $nom_prenom invalide ! essayer un nouveau :)";
                    $error_message="Champ Nom et Prénom = $nom_prenom invalide! essayer un nouveau :)";
                    goto end;
                }
                
                if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
                    echo "Champ Email  $email invalide! essayer un nouveau :)";
                    $error_message= "Champ Email  $email invalide ! essayer un nouveau :)";
                    goto end;
                }
                
                if (!preg_match("/^(213\d{9}|0[567]\d{8})$/", $telephone)) {
                   echo"Champ Téléphone $telephone invalide! essayer un nouveau :)";
                    $error_message="Champ Téléphone $telephone invalide ! essayer un nouveau :)";
                    goto end;
                }
                
                if (!preg_match("/^\d{12}$/", $matricule)) {
                    echo"Champ Téléphone $matricule invalide!essayer un nouveau :)";
                    $error_message="Champ Matricule  $matricule invalide ! essayer un nouveau :)";
                    goto end;
                }
                
                if (!preg_match("/^[a-zA-Z0-9]+(?:[ ]?[a-zA-Z0-9]+){0,}$/", $mot_de_passe)) {
                    echo"Champ Mot de passe invalide ! essayer un nouveau :)";
                    $error_message="Champ Mot de passe invalide ! essayer un nouveau :) ";
                    goto end;
                }

                $req_email = "SELECT * FROM users WHERE email_user = '$email'";
                $result_email = mysqli_query($conn, $req_email);
                
                if ($result_email === false) {
                    // Gérer l'erreur, afficher un message, journaliser, etc.
                    die("Erreur de requête SQL: " . mysqli_error($conn));
                }
                
                if (mysqli_num_rows($result_email) > 0) {
                    echo "L'adresse e-mail est déjà utilisée par un autre utilisateur.";
                    $error_message = "L'adresse e-mail est déjà utilisée par un autre utilisateur.";
                    goto end;
                }
                
                $req_telephone = "SELECT  id FROM users WHERE telephone = '$telephone'";
                //numero_telephone = '$telephone'";
                $result_telephone = mysqli_query($conn, $req_telephone);
               if ($result_telephone == false ) {
                    // Gérer l'erreur, afficher un message
                    $error_message = die("Erreur de requête SQL: " . mysqli_error($conn));
                    goto end;
                }
                
                if (mysqli_num_rows($result_telephone) > 0) {
                    echo "Le numéro de téléphone est déjà utilisé par un autre utilisateur.";
                    $error_message = "Le numéro de téléphone est déjà utilisé par un autre utilisateur.";
                    goto end;
                }
                
                $req_nom_prenom = "SELECT * FROM users WHERE nom_prenom = '$nom_prenom'";
                $result_nom_prenom = mysqli_query($conn, $req_nom_prenom);
                
                if ($result_nom_prenom === false) {
                    // Gérer l'erreur, afficher un message
                    die("Erreur de requête SQL: " . mysqli_error($conn));
                }
                
                if (mysqli_num_rows($result_nom_prenom) > 0) {
                    echo "Le nom et prénom sont déjà utilisés par un autre utilisateur.";
                    $error_message = "Le nom et prénom sont déjà utilisés par un autre utilisateur.";
                    goto end;
                }
                $request = "INSERT INTO users (nom_prenom, email_user, nemero_telephone, matricule, mot_de_passe)
                            VALUES ('$nom_prenom', '$email', '$telephone', '$matricule', '$mot_de_passe')";

                if (mysqli_query($conn, $request)) {

                        echo '<form action="accueilcompteuser.html" method="post">
                                <div>
                                <div> <h3>Bienvenue monsieur ' . $row["nom_prenom"] . 'a drivereshare </h3></div>
                                </div>
                                    <br>
                                         <br>
                                            <h3>Appuyez sur le bouton pour contenu </h3>
                                         <br>
                                    <br>
                              <button type="submit"> suivant </button>
                          </form>';
                   
                } else {
                    echo "Erreur <br />" . mysqli_error($conn) . "<br />";
                }

                mysqli_close($conn);
            }
        }

        end: 
           echo 
                '<form action="authentification.html" method="post">
                     <div>
                         <?php echo $error_message; ?>
                     </div>
                         <br>
                              <br>
                                 <h3>Appuyez sur le bouton pour retourner à l\'authentification</h3>
                              <br>
                         <br>
                   <button type="submit">Retourner à l\'authentification</button>
               </form>';
         
    ?>
</body>
</html>
