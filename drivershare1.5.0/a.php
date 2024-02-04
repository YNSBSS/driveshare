<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> </title>
</head>
<body>
    <?php
        // Informations de connexion a la base de donnees
        $host = "localhost";
        $db_name = "mabase";
        $username = "root";
        $password = "";
        $table_name = "users";
        $row;

        // Connexion a la base de donnees avec mysqli
        $conn = new mysqli($host, $username, $password, $db_name);

        // Verifier la connexion
        if ($conn->connect_error) {
            die("Erreur de connexion a la base de donnees: " . $conn->connect_error);
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

                if (!preg_match("/^[a-zA-Z\ -']+$/", $nom_prenom)) {
                    echo"Champ Nom et Prenom  $nom_prenom invalide ! essayer un nouveau :)";
                    $error_message="Champ Nom et Prenom = $nom_prenom invalide! essayer un nouveau :)";
                    goto end;
                }
                
                if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
                    echo "Champ Email  $email invalide! essayer un nouveau :)";
                    $error_message= "Champ Email  $email invalide ! essayer un nouveau :)";
                    goto end;
                }
                
                if (!preg_match("/^(213\d{9}|0[567]\d{8})$/", $telephone)) {
                   echo"Champ Telephone $telephone invalide! essayer un nouveau :)";
                    $error_message="Champ Telephone $telephone invalide ! essayer un nouveau :)";
                    goto end;
                }
                
                if (!preg_match("/^\d{12}$/", $matricule)) {
                    echo"Champ Telephone $matricule invalide!essayer un nouveau :)";
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
                    // Gerer l'erreur, afficher un message, journaliser, etc.
                    die("Erreur de requête SQL: " . mysqli_error($conn));
                }
                
                if (mysqli_num_rows($result_email) > 0) {
                    echo "L'adresse e-mail est deja utilisee par un autre utilisateur.";
                    $error_message = "L'adresse e-mail est deja utilisee par un autre utilisateur.";
                    goto end;
                }
                
                $req_telephone = "SELECT * FROM users WHERE numero_telephone = '$telephone'";
                //numero_telephone = '$telephone'";
                $result_telephone = mysqli_query($conn, $req_telephone);
               if ($result_telephone == false ) {
                    // Gerer l'erreur, afficher un message
                    $error_message = die("Erreur de requête SQL: " . mysqli_error($conn));
                    goto end;
                }
                
                if (mysqli_num_rows($result_telephone) > 0) {
                    echo "Le numero de telephone est deja utilise par un autre utilisateur.";
                    $error_message = "Le numero de telephone est deja utilise par un autre utilisateur.";
                    goto end;
                }
                
                $req_nom_prenom = "SELECT * FROM users WHERE nom_prenom = '$nom_prenom'";
                $result_nom_prenom = mysqli_query($conn, $req_nom_prenom);
                
                if ($result_nom_prenom === false) {
                    // Gerer l'erreur, afficher un message
                    die("Erreur de requête SQL: " . mysqli_error($conn));
                }
                
                if (mysqli_num_rows($result_nom_prenom) > 0) {
                    echo "Le nom et prenom sont deja utilises par un autre utilisateur.";
                    $error_message = "Le nom et prenom sont deja utilises par un autre utilisateur.";
                    goto end;
                }
                $request = "INSERT INTO users (nom_prenom, email_user, numero_telephone, matricule, mot_de_passe)
                            VALUES ('$nom_prenom', '$email', '$telephone', '$matricule', '$mot_de_passe')";

                if (mysqli_query($conn, $request)) {

                        echo '<form action="demandertrajet.html" method="post">
                                <div>
                                <div> <h3>Bienvenue monsieur ' . $nom_prenom. ' a drivereshare </h3></div>
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
                                 <h3>Appuyez sur le bouton pour retourner a l\'authentification</h3>
                              <br>
                         <br>
                   <button type="submit">Retourner a l\'authentification</button>
               </form>';
         
    ?>
</body>
</html>
