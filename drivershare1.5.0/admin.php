<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> </title>
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
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
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données: " . $conn->connect_error);
        }
        session_start();

        $error_message = "";
        $success_message = "";
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $telephone = $_POST["telephone"];
        $num_carte = $_POST["num_carte"];
        $num_ss = $_POST["num_ss"];
        $nom_v = $_POST["nom_v"];
        $email = $_POST["email"];
        $matricule = $_POST["matricule"];

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifiez quelle action a été soumise
      if (isset($_POST['action'])) {
          $action = $_POST['action'];

        // Exécutez les instructions en fonction de l'action
        if ($action == "ajouter"){
        
          // $mot_de_passe = $_POST["mot_de_passe"];

            if (in_array('', $_POST)) {
                echo "Veuillez remplir tous les champs du formulaire";
            } else {       

                if (!preg_match("/^[a-zA-Z\-']+$/", $nom)) {
                    echo"Champ Nom et Prénom  $nom invalide ! essayer un nouveau :)";
                    $error_message="Champ Nom et Prénom   $nom invalide! essayer un nouveau :)";
                    goto end;
                }
                if (!preg_match("/^[a-zA-Z\-']+$/", $prenom)) {
                    echo"Champ Nom et Prénom  $prenom invalide ! essayer un nouveau :)";
                    $error_message="Champ Nom et Prénom  $prenom invalide! essayer un nouveau :)";
                    goto end;
                }
                
                if (!preg_match("/^(213\d{9}|0[567]\d{8})$/", $telephone)) {
                    echo"Champ Téléphone $telephone invalide! essayer un nouveau :)";
                     $error_message="Champ Téléphone $telephone invalide ! essayer un nouveau :)";
                     goto end;
                 }
                 
                if (!preg_match("/^(?!0{10}$)\d{10}$/", $num_carte)) {
                    echo"Champ num_carte $num_carte invalide! essayer un nouveau :)";
                     $error_message="Champ num_carte $num_carte invalide ! essayer un nouveau :)";
                     goto end;
                 }
                
                if (!preg_match("/^(?!0{10}$)\d{8}$/", $num_ss)) {
                    echo"Champ num_carte $num_ss invalide! essayer un nouveau :)";
                     $error_message="Champ num_carte $num_ss invalide ! essayer un nouveau :)";
                     goto end;
                 }
           
                if (!preg_match("/^[a-zA-Z0-9\s\-]+$/", $nom_v)) {
                    echo"Champ nom de vehécule  $nom_v invalide! essayer un nouveau :)";
                     $error_message="Champ nom de vehécule  $nom_v invalide ! essayer un nouveau :)";
                     goto end;
                 }
           
                if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
                    echo "Champ Email  $email invalide! essayer un nouveau :)";
                    $error_message= "Champ Email  $email invalide ! essayer un nouveau :)";
                    goto end;
                }
                
                if (!preg_match("/^\d{10}$/", $matricule)) {
                    echo"Champ matricule de vehecule  $matricule invalide!essayer un nouveau :)";
                    $error_message="Champ Matricule  $matricule invalide ! essayer un nouveau :)";
                    goto end;
                }
                
               /* if (!preg_match("/^[a-zA-Z0-9]+(?:[ ]?[a-zA-Z0-9]+){0,}$/", $mot_de_passe)) {
                    echo"Champ Mot de passe invalide ! essayer un nouveau :)";
                    $error_message="Champ Mot de passe invalide ! essayer un nouveau :) ";
                    goto end;
                }*/

             $req_email = "SELECT * FROM chauffeur WHERE email = '$email'";
             $result_email = mysqli_query($conn, $req_email);
                
                if ($result_email == false) {
                    // Gérer l'erreur, afficher un message, journaliser, etc.
                    die("Erreur de requête SQL: " . mysqli_error($conn));
                }
                
                if (mysqli_num_rows($result_email) > 0) {
                    echo "L'adresse e-mail est déjà utilisée par un autre chauffeur";
                    $error_message = "L'adresse e-mail est déjà utilisée par un autre chauffeur.";
                    goto end;
                }
                
                $req = "SELECT * FROM chauffeur WHERE nom = '$nom' AND prenom = '$prenom'";
                $result = mysqli_query($conn, $req);
                
                if ($result === false) {
                    // Gérer l'erreur, afficher un message, journaliser, etc.
                    die("Erreur de requête SQL: " . mysqli_error($conn));
                }
                
                if (mysqli_num_rows($result) > 0) {
                    echo "le nom et prenom sont déjà utilisée par un autre chauffeur";
                    $error_message = "le nom et prenom sont déjà utilisée par un autre chauffeur.";
                    goto end;
                }
                
             $req_telephone = "SELECT * FROM chauffeur WHERE numero_telephone = '$telephone'";
             $result_telephone = mysqli_query($conn, $req_telephone);

                 if ($result_telephone == false ) {
                    // Gérer l'erreur, afficher un message
                    $error_message = die("Erreur de requête SQL: " . mysqli_error($conn));
                    goto end;
                }
                
                if (mysqli_num_rows($result_telephone) > 0) {
                    echo "Le numéro de téléphone est déjà utilisé par un autre chauffeur.";
                    $error_message = "Le numéro de téléphone est déjà utilisé par un autre chauffeur.";
                    goto end;
                }

             $req = "SELECT * FROM chauffeur WHERE numero_carte_nationale = '$num_carte'";
             $result = mysqli_query($conn, $req);

                 if ($result == false ) {
                    // Gérer l'erreur, afficher un message
                    $error_message = die("Erreur de requête SQL: " . mysqli_error($conn));
                    goto end;
                }
                
                if (mysqli_num_rows($result) > 0) {
                    echo "Le numero_carte_nationale est déjà utilisé par un autre chauffeur.";
                    $error_message = "Le numero_carte_nationaleest déjà utilisé par un autre chauffeur.";
                    goto end;
                }
            
             $req = "SELECT * FROM chauffeur WHERE  numero_assurance_nationale = '$num_ss'";
             $result = mysqli_query($conn, $req);

                 if ($result == false ) {
                    // Gérer l'erreur, afficher un message
                    $error_message = die("Erreur de requête SQL: " . mysqli_error($conn));
                    goto end;
                }
                
                if (mysqli_num_rows($result) > 0) {
                    echo "Le numero_assurance_nationale est déjà utilisé par un autre chauffeur.";
                    $error_message = "Le numero_assurance_nationale déjà utilisé par un autre chauffeur.";
                    goto end;
                }
                
             $req = "SELECT * FROM chauffeur WHERE matricule_voiture = '$matricule'";
             $result = mysqli_query($conn, $req);

                 if ($result == false ) {
                    // Gérer l'erreur, afficher un message
                    $error_message = die("Erreur de requête SQL: " . mysqli_error($conn));
                    goto end;
                }
                
                if (mysqli_num_rows($result) > 0) {
                    echo "Le matricule_voiture est déjà utilisé par un autre voiture.";
                    $error_message = "Le numero_assurance_nationale déjà utilisé par un autre voiture ";
                    goto end;
                }
                
                   $request = "INSERT INTO chauffeur (nom, prenom, numero_telephone, email, nom_voiture, matricule_voiture,
                                                    numero_assurance_nationale, numero_carte_nationale)
                              VALUES ('$nom', '$prenom', '$telephone', '$email', '$nom_v', '$matricule', '$num_ss', '$num_carte')";

                if (mysqli_query($conn, $request)) {

                        echo '<form action="accueiladmin.html" method="post">
                                <div>
                                <div> <h3> le  chauffeur " '  . $prenom . ' " est ajouter avec succes a drivereshare </h3></div>
                                </div>
                                    <br>
                                         <br>
                                            <h4>Appuyez sur button  pour ajoueter autre chauffeur </h4>
                                         <br>
                                    <br>
                              <button type="submit"> ajoute </button>
                          </form>';
                        echo'<br>';
                        echo '<form action="authentification.html" method="post">
                                <div>
                                </div>
                                    <br>
                                         <br>
                                            <h3>Appuyez sur button pour exite </h3>
                                         <br>
                                    <br>
                              <button type="submit"> exite </button>
                          </form>';
                          goto fin;
                   
                         } else {
                             echo "Erreur <br />" . mysqli_error($conn) . "<br />";
                         }

                   end: 
                     echo 
                          '<form action="accueiladmin.html" method="post">
                               <div>
                                 <?php echo $error_message; ?>
                              </div>
                               <br>
                               <br>
                                 <h3>Appuyez sur le bouton pour retourner </h3>
                               <br>
                               <br>
                                 <button type="submit"> Retourner à page principale </button>
                            </form>';
                  fin:;
                 mysqli_close($conn);
             }
   
        
        } elseif ($action == "supprimer") {

            if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
                echo "Champ Email $email invalide! Essayer un nouveau :)";
            } else {
                $req_email = "SELECT * FROM chauffeur WHERE email = '$email'";
                $result_email = mysqli_query($conn, $req_email);
        
                if ($result_email === false) {
                    die("Erreur de requête SQL: " . mysqli_error($conn));
                }
        
                if (mysqli_num_rows($result_email) == 0) {
                    echo "L'adresse e-mail n'existe pas";
                } else {
                    $request = "DELETE FROM `chauffeur` WHERE `chauffeur`.`email` = '$email'";
        
                    if (mysqli_query($conn, $request)) {
                        echo '<form action="accueiladmin.html" method="post">
                                    <div>
                                      <div> <h3>Le chauffeur a été supprimé avec succès de drivereshare</h3></div>
                                    </div>
                                 <br>
                                     <br>
                                      <h4>Appuyez sur le bouton pour supprimer un autre chauffeur </h4>
                                     <br>
                                 < br>
                                <button type="submit">Ajouter</button>
                            </form>';
                        echo '<br>';
                        echo '<form action="authentification.html" method="post">
                                <div>
                                </div>
                                  <br>
                                      <br>
                                        <h3>Appuyez sur le bouton pour sortir </h3>
                                      <br>
                                   <br>
                                <button type="submit">Sortir</button>
                            </form>';
                    } else {
                        echo "Erreur <br />" . mysqli_error($conn) . "<br />";
                    }
                }
            }
            mysqli_close($conn);
        } 
        } elseif ($action == "modifier"){
      }
   } 
    ?>
</body>
</html>
