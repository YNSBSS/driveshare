<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> authentification chauffeur</title>
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
    $table_name = "chauffeur";

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
        $mot_de_passe = $_POST["mot_de_passe"];

        setcookie('mot_de_passe_cookie',$mot_de_passe, time() + 60, '/');
        setcookie('email_cookie', $email, time() + 60, '/');

        // Vérification des champs du formulaire
        if (empty($email) || empty($mot_de_passe)) {
            echo "Veuillez remplir tous les champs du formulaire";
            goto end;
        } else {
            if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
                echo "Champ Email = $email invalide!";
                $error_message="Champ Email = $email invalide!";
                goto end;

             }
             if (($email== 'admin@gmail.com') && ($mot_de_passe=='admin')) {
                session_start();
                $_SESSION["email"] = $email;
                echo 
                ' <div >
                       <form action="accueiladmin.html" method="post">
                           <div> <h3> Bienvenue admin   </h3></div>
                           <br>
                           <br>
                              </h2> Appuyez sur button pour allez a menu principal </h2>
                           <br>
                           <br>
                           <button type="submit"> suivant</button>
                      </form>
                  </div>';
                goto fin;
             }
             else {
                $req_email = "SELECT * FROM chauffeur WHERE email = '$email'";
                $result= mysqli_query($conn, $req_email);
                if (mysqli_num_rows($result) < 1) {
                    echo "L'adresse e-mail n'existe pas .";
                    $error_message = "il ya pas un user qui inscrit avec ce adress mail .";
                    goto end;
                } 
                  $req_email = "SELECT * FROM chauffeur WHERE email = ?";
                  $stmt = $conn->prepare($req_email);
                  $stmt->bind_param("s", $email);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    // Utilisez password_verify pour comparer les mots de passe de manière sécurisée
                    if (($mot_de_passe == $row["mot_de_passe"])) {
                        session_start();
                        $_SESSION["email"] = $email;
                        // Le mot de passe correspond, effectuez les actions nécessaires ici
                        echo 
                        ' <div >
                               <form action="coursesdemanded.php" method="post">
                                   
                                   <button type="submit"> suivant</button>
                              </form>
                          </div>';
                        goto fin;
                         }
                     else 
                        {
                          echo '<form action="authentificationchauffeur.html" method="post">
                                
                                <button type="submit"> retourner </button>
                                 </form>';
                                 goto fin;
                          } 
                   }

                end:
                   echo '<form action="authentificationchauffeur.html" method="post">
                  <div><?php echo $error_message; ?></div>
                  <br>
                  <br>
                  </h3> Appuyez sur button pourretourner a l\'authentification </h3>
                  <br>
                  <br>
                  <button type="submit">retourner a l\'authentification </button>
                   </form>';
              } 
           }                   
        }
        fin:;
    // Fermer la connexion à la base de données
    $conn->close();
    ?>
</body>
</html>
