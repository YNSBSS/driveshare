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
        $table_name = "chauffeur";
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
            
           $nom = $_POST["nom"];
           $prenom = $_POST["prenom"];
           $email = $_POST["email"];
           $telephone = $_POST["telephone"];
           $adresse = $_POST["adresse"];
           $mot_de_passe = $_POST["mot_de_passe"];
           $nomvoiture = $_POST["nomvoiture"];

           $matriculevoiture = $_POST["matriculevoiture"];
           $numassnat = $_POST["numassnat"];
           $notion = $_POST["notion"];
           $numcartenat = $_POST["numcartenat"];

            if (in_array('', $_POST)) {
                echo "Veuillez remplir tous les champs du formulaire";
            } else {

                if (!preg_match("/^[a-zA-Z\-']+$/", $nom)) {
                    echo"Champ Nom et Prenom  $nom invalide ! essayer un nouveau :)";
                    $error_message="Champ Nom et Prenom = $nom invalide! essayer un nouveau :)";
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
                
                
                if (!preg_match("/^[a-zA-Z0-9]+(?:[ ]?[a-zA-Z0-9]+){0,}$/", $mot_de_passe)) {
                    echo"Champ Mot de passe invalide ! essayer un nouveau :)";
                    $error_message="Champ Mot de passe invalide ! essayer un nouveau :) ";
                    goto end;
                }

                $req_email = "SELECT * FROM chauffeur WHERE email = '$email'";
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
                
                $req_telephone = "SELECT * FROM chauffeur WHERE numero_telephone = '$telephone'";
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
                
                $req_nom = "SELECT * FROM chauffeur WHERE nom = '$nom'";
                $result_nom = mysqli_query($conn, $req_nom);
                
                
                $request = "INSERT INTO chauffeur (nom,prenom,	adresse,	numero_telephone	,email	,mot_de_passe	,nom_voiture	,matricule_voiture	,numero_assurance_nationale	,notion	,numero_carte_nationale )
                            VALUES ('$nom', '$prenom','$adresse', '$telephone', '$email', '$mot_de_passe' , '$nomvoiture' , '$matriculevoiture', '$numassnat', '$notion', '$numcartenat'   )";

                if (mysqli_query($conn, $request)) {
                    session_start();
                    $_SESSION["email"] = $email;
                        echo '<form action="coursesdemanded.php" method="post">
                                
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
                '<form action="authentificationchauffeur.html" method="post">
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
