<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise a jour</title>
    
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
    

<?php
     $host = "localhost";
     $db_name = "mabase";
     $username = "root";
     $password = "";
     $table_name = "course";
 
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
          $email = $_POST["usermail"];
          session_start();
         $email2 = $_SESSION["email"];
          $sql = "SELECT * FROM coursedemande WHERE email_user = '$email'";
          $result = $conn->query($sql);
         $row = $result->fetch_assoc();
         $duree=$row['duree'];
         $depart=$row['depart'];
         $arrivee=$row['arrivee'];
         $price=$row['prix'];
         $distance=$row['distance'];
         $date=$row['coursedate'];
         $id=$row['id_coursedm'];

          $request = "INSERT INTO course (email_user	,email,	duree	,depart	,arrivee,	prix,	distance,coursedate	)
VALUES ('$email', '$email2', '$duree', '$depart', '$arrivee', '$price', '$distance' ,'$date')";
if (mysqli_query($conn, $request)) {

    
goto delete;
     } else {
         echo "Erreur <br />" . mysqli_error($conn) . "<br />";
     }
         
        delete:
        $request = "DELETE FROM `coursedemande` WHERE `id_coursedm`= '$id'";
        if (mysqli_query($conn, $request)) {

            echo"<h1>votre client t'attand </h1>";
            echo"<h3>appellez lui </h3>";

             } else {
                 echo "Erreur <br />" . mysqli_error($conn) . "<br />";
             }
   }


    ?>

<button onclick='window.history.back();'>retour</button>
</body>
</html>