<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>confirmation de la demande </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="accueilcompteuser.css">
  <script src='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />
  <style>
  body{
    background-color:green ;
  }
  button{
    background-color:wheat;
    color: green;
  }
  div{
    display: inline-block;
  justify-content: center; 
  align-items: center;
  align-content: center;
  }
  </style>
</head>
<body>
<main>
    <div style="background-color: black;" class="sidebar">
        <div class="logo-details">
        <div class="logo_name"> <img src="driversharegreen.png" style = " height: 40px; width: 40px;"> Drivershare</div>
            <i class='bx bx-menu' id="btn" ></i>
        </div>
        <ul class="nav-list">
          <li>
              <i class='bx bx-search' ></i>
             <input type="text" placeholder="Rechercher...">
          </li>
          <li>
            <a href="demandertrajet.html">
              <i class='bx bx-home' ></i>
              <span class="links_name"> Acceuil</span>
            </a>
          </li>
          <li>
           <a href="profiluser.html">
             <i class='bx bx-user' ></i>
             <span class="links_name"> Profil</span>
           </a>
         </li>
         <li>
          <a href="mestrajets.html">
            <i class='bx bx-list-plus' ></i>
            <span class="links_name"> Mes trajets</span>
          </a>
         </li>
         <li>
          <a href='authentification.html'>
            <i class='bx bxs-dock-left'></i>
            <span class="links_name" name="deconnexion" id="deconnexion">Déconnexion</span></a>
         </li>
        </ul>
    </div>
  <section class="home-section">
  
  <h1> Votre demande a ete enregestré avec success</h1>
    <h3>votre chauffeur vous appeler dans quqleques minutes</h3>

    <?php
     $host = "localhost";
     $db_name = "mabase";
     $username = "root";
     $password = "";
     $table_name = "coursedemande";
 
     // Connexion à la base de données avec mysqli
     $conn = new mysqli($host, $username, $password, $db_name);
 
     // Vérifier la connexion
     if ($conn->connect_error)
      {
         die("Erreur de connexion à la base de données: " . $conn->connect_error);
      }
        
     // Vérification si le formulaire est soumis
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // Récupération des donnée
         session_start();
          
          $arrive = $_POST['arrive'];
          $depart = $_POST['depart'];
          $currentDate = $_POST['currentDate'];
          $distance = $_POST['distance'];
          $price = $_POST['price'];
          $duree = $_POST['duree'];
          $email = $_SESSION["email"];
         // Do something with the data
        

          $request = "INSERT INTO coursedemande (email_user , duree , depart , arrivee , prix , distance , coursedate	)
                      VALUES ('$email', '$duree', '$depart',' $arrive '  , '$price', '$distance ' ,' $currentDate'  )";

                if (mysqli_query($conn, $request)) {

                        echo '<form action="mestrajet.php" method="post">
                                <div>
                                
                                </div>
                                    <br>
                                         <br>
                                            <h3>Appuyez sur le bouton pour retourner  </h3>
                                         <br>
                                    <br>
                                    <div class="group">
                              <button type="submit"> suivant </button>
                              </div>
                          </form>';
                   
                } else {
                    echo "Erreur <br />" . mysqli_error($conn) . "<br />";
                }
     
     
     
        } else {
         echo "No data received";
     }






    ?>
      
  </section>
    
  
  </main>
  <script src="compteuser.js"></script>
</body>
</html>