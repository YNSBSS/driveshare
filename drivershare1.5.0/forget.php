<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> authentification</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form {
             display: flex;
             height: 100%;
             width: 100%;
             border-radius: 12px;
             align-items: center;
             text-decoration: none;
             transition: all 0.4s ease;
             background-color:  rgb(71, 12, 233);;
           }
    </style>
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
    if ($conn->connect_error)
     {
        die("Erreur de connexion à la base de données: " . $conn->connect_error);
     }
       
    // Vérification si le formulaire est soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire et utilisation de prepared statements pour éviter les attaques SQL
        $email = $_POST["email"];
        $passe1 = isset($_POST["passe1"]) ? $_POST["passe1"] : "";
        $passe2 = isset($_POST["passe2"]) ? $_POST["passe2"] : "";
        setcookie('email_cookie', $email, time() + 60, '/');
        
        // Vérification des champs du formulaire
        if (empty($email) || empty($passe1) || empty($passe2)) {
            $error_message = "Veuillez remplir tous les champs du formulaire";
            goto end;
        } else {
            if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
                $error_message = "Champ Email = $email invalide!";
                goto end;

            } else {

                   if ($passe1 === $passe2) {
                      $req_email = "SELECT * FROM users WHERE email_user = '$email'";
                      $result = mysqli_query($conn, $req_email);

                        if  (mysqli_num_rows($result) < 1) {
                             $error_message = " erreur ! Il n'y a pas d'utilisateur avec cet email ";
                             goto end;
                      } else {
                            $req = "UPDATE users
                                    SET mot_de_passe = '$passe1'
                                    WHERE email_user = '$email'";
                            $rslt = mysqli_query($conn, $req);
        
                            if ($rslt) {
                                $success_message = "Le mot de passe a été modifié avec succès.";
                                goto fin; }
                        else {
                                $error_message = "Erreur lors de la mise à jour du mot de passe : " . mysqli_error($conn);
                                goto end;
                            }
                        }
                    }
                 else {
                    $error_message = "Les mots de passe ne correspondent pas.";
                    goto end;
                }
            }
        }}
    
                end:
                echo '<div>';
                echo '<form action="authentification.html" method="post">';
                echo '  <div>' . $error_message . '</div>';
                echo '  <br>';
                echo '  <h3>Appuyez sur le bouton pour retourner à l\'authentification</h3>';
                echo '  <br>';
                echo '  <button type="submit">Retourner à l\'authentification</button>';
                echo '</form>';
                echo '<br>';
                echo '<br>';
                echo '<form action="forget.html" method="post">';
                echo '  <br>';
                echo '  <h3>Appuyez sur le bouton pour essayer nouveau </h3>';
                echo '  <br>';
                echo '  <button type="submit"> retourner </button>';
                echo '</form>';
                echo '</div>';
                goto fin2;
              
        fin:;
        echo 
        ' <div >
               <form action="authentification.html" method="post">
                   <div> <h3>  Mot de passe modifié avec succès :) </h3></div>
                   <br>
                      </h3> Appuyez sur button pour contenu </h3>
                   <br>
                   <br>
                   <button type="submit"> contenu  </button>
              </form>
          </div>';
          fin2:;
    // Fermer la connexion à la base de données
    $conn->close();
    ?>
</body>
</html>
